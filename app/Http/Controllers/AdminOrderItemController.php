<?php

namespace App\Http\Controllers;

use App\Enums\CancelReason;
use App\Enums\Gender;
use App\Enums\OrderStatus;
use App\Enums\ShirtSize;
use App\Enums\Variation;
use App\Models\OrderItem;
use App\Traits\SortsQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * The order-line screens — the admin panel's "Processing" and "Cancel/Return"
 * tabs.
 *
 * Both tabs are now the same query with a different status filter. Previously
 * they were separate tables, and every transition was a create() into one
 * followed by a delete() from the other with no transaction between them: an
 * interrupted move duplicated or destroyed the line. The two controllers had
 * also drifted — `total` was price × quantity in moveProduct but bare `price`
 * in four of six moveMultiple arms, and adminOnProcessController's "move to
 * cancel" bulk arm wrote to OnHand instead.
 */
class AdminOrderItemController extends Controller
{
    use SortsQueries;

    private const SORTABLE = ['id', 'description', 'unit_price', 'quantity', 'line_total', 'status', 'created_at'];

    /** The Processing tab: everything still in flight. */
    public function processing(Request $request)
    {
        return view('admin.products.proccessing', [
            'items' => $this->baseQuery($request)
                ->whereIn('status', [
                    OrderStatus::ToPay,
                    OrderStatus::ToShip,
                    OrderStatus::ToReceive,
                    OrderStatus::ToReview,
                ])
                ->paginate(20),
        ]);
    }

    /** The Cancel/Return tab. */
    public function cancelReturn(Request $request)
    {
        return view('admin.products.cancelReturn', [
            'items' => $this->baseQuery($request)
                ->where('status', OrderStatus::Cancelled)
                ->paginate(20),
        ]);
    }

    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate($this->statusRules());

        $this->applyStatus(OrderItem::findOrFail($id), $validated);

        return redirect()->back()->with('success', 'Status updated');
    }

    public function updateStatusMany(Request $request)
    {
        $validated = $request->validate($this->statusRules() + [
            'toUpdate' => ['required', 'string'],
        ]);

        $ids = $this->idList($validated['toUpdate']);

        if ($ids === []) {
            return redirect()->back()->with(['fail' => 'No selected item']);
        }

        DB::transaction(function () use ($ids, $validated) {
            foreach (OrderItem::whereIn('id', $ids)->get() as $item) {
                $this->applyStatus($item, $validated);
            }
        });

        return redirect()->back()->with(['success' => 'Updating success']);
    }

    public function destroy(int $id)
    {
        OrderItem::findOrFail($id)->delete();

        return redirect()->back()->with('removedSucess', 'Item successfully removed');
    }

    public function destroyMany(Request $request)
    {
        $ids = $this->idList($request->input('toRemove'));

        if ($ids === []) {
            return redirect()->back()->with(['fail' => 'No selected item']);
        }

        OrderItem::whereIn('id', $ids)->delete();

        return redirect()->back()->with(['success' => 'Deleted successfully']);
    }

    public function filter(Request $request)
    {
        $validated = $request->validate([
            'id' => ['nullable', 'integer'],
            'userId' => ['nullable', 'integer'],
            'variation' => ['nullable', Rule::enum(Variation::class)],
            'gender' => ['nullable', Rule::enum(Gender::class)],
            'size' => ['nullable', Rule::enum(ShirtSize::class)],
            'price' => ['nullable', 'numeric'],
            'status' => ['nullable', Rule::enum(OrderStatus::class)],
        ]);

        $items = OrderItem::with('order.user')
            ->when($validated['id'] ?? null, fn ($q, $v) => $q->whereKey($v))
            ->when($validated['userId'] ?? null, fn ($q, $v) => $q->whereRelation('order', 'user_id', $v))
            ->when($validated['variation'] ?? null, fn ($q, $v) => $q->where('variation', $v))
            ->when($validated['gender'] ?? null, fn ($q, $v) => $q->where('gender', $v))
            ->when($validated['size'] ?? null, fn ($q, $v) => $q->where('size', $v))
            ->when($validated['price'] ?? null, fn ($q, $v) => $q->where('unit_price', $v))
            ->when($validated['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->get();

        return view('admin.products.processingPartial', compact('items'));
    }

    public function sort(Request $request)
    {
        $items = $this->applySort(
            OrderItem::with('order.user'),
            $request,
            self::SORTABLE,
            'sortProductBy',
            'orderProductBy'
        )->get();

        return view('admin.products.sort.sortProducts', compact('items'));
    }

    public function filterDate(Request $request)
    {
        $validated = $request->validate([
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date', 'after_or_equal:startDate'],
        ]);

        $items = OrderItem::with('order.user')
            ->when(
                ! empty($validated['startDate']) && ! empty($validated['endDate']),
                // The old version ran whereBetween whenever *either* bound was
                // filled, so a start date with no end date matched nothing.
                fn ($q) => $q->whereBetween('created_at', [$validated['startDate'], $validated['endDate']])
            )
            ->get();

        return view('admin.products.processingPartial', compact('items'));
    }

    private function baseQuery(Request $request)
    {
        return $this->applySort(
            OrderItem::with('order.user'),
            $request,
            self::SORTABLE,
            'sortProductBy',
            'orderProductBy'
        );
    }

    private function statusRules(): array
    {
        return [
            'status' => ['required', Rule::enum(OrderStatus::class)],
            'reason' => ['required_if:status,'.OrderStatus::Cancelled->value, Rule::enum(CancelReason::class)],
            'specify' => ['nullable', 'string', 'max:255'],
        ];
    }

    /** Cancelling returns the stock; nothing in the old code ever did. */
    private function applyStatus(OrderItem $item, array $validated): void
    {
        $status = OrderStatus::from($validated['status']);

        if ($status === $item->status) {
            return;
        }

        DB::transaction(function () use ($item, $status, $validated) {
            if ($status === OrderStatus::Cancelled) {
                $item->product?->increment('stock', $item->quantity);
            }

            $item->update([
                'status' => $status,
                'cancel_reason' => $status === OrderStatus::Cancelled ? $validated['reason'] : null,
                'cancel_note' => $status === OrderStatus::Cancelled ? ($validated['specify'] ?? null) : null,
            ]);
        });
    }

    private function idList(?string $csv): array
    {
        if (blank($csv)) {
            return [];
        }

        return array_values(array_filter(array_map('intval', explode(',', $csv))));
    }
}
