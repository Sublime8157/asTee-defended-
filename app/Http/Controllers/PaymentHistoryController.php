<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Traits\SortsQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentHistoryController extends Controller
{
    use SortsQueries;

    private const SORTABLE = ['id', 'order_id', 'provider', 'amount', 'created_at'];

    public function display()
    {
        return view('admin.payments', [
            'payments' => Payment::with('order')->latest()->paginate(20),
            'unpaidOrderIds' => Order::whereNull('paid_at')->pluck('id'),
        ]);
    }

    public function refresh()
    {
        return view('admin.results.paymentResult', [
            'payments' => Payment::with('order')->latest()->paginate(20),
            'unpaidOrderIds' => Order::whereNull('paid_at')->pluck('id'),
        ]);
    }

    /** Record a manual bank transfer against an order. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'provider' => ['required', 'string', 'max:255'],
            'proof' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $order = Order::findOrFail($validated['order_id']);

        if ($order->isPaid()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'The order number has already been paid',
            ], 422);
        }

        // The amount was an operator-typed field validated only as `integer`,
        // so a mistyped figure became the recorded sale. It is the order total
        // or it is not a payment for this order.
        // Private disk: a bank transfer screenshot shows an account number.
        // These were world-readable under the uploader's own filename.
        $proofPath = $request->file('proof')->store('payment-proofs', 'private');

        DB::transaction(function () use ($order, $validated, $proofPath) {
            Payment::create([
                'order_id' => $order->id,
                'provider' => $validated['provider'],
                'amount' => $order->total,
                'proof_path' => $proofPath,
            ]);

            $order->update(['paid_at' => now()]);
        });

        return response()->json(['status' => 'success', 'message' => 'Successfully inserted']);
    }

    public function sort(Request $request)
    {
        return $this->partial(
            $this->applySort(Payment::with('order'), $request, self::SORTABLE)->get()
        );
    }

    public function filterDate(Request $request)
    {
        $validated = $request->validate([
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date', 'after_or_equal:startDate'],
        ]);

        // Both bounds, or no filter. The old trait ran whereBetween when either
        // was filled and its else branch referenced an unimported class, so an
        // empty date filter was a fatal error rather than an unfiltered list.
        $query = Payment::with('order');

        if (! empty($validated['startDate']) && ! empty($validated['endDate'])) {
            $query->whereBetween('created_at', [$validated['startDate'], $validated['endDate']]);
        }

        return $this->partial($query->get());
    }

    public function filterBanks(Request $request)
    {
        return $this->partial(
            Payment::with('order')->where('provider', $request->input('bank'))->get()
        );
    }

    public function filterPrice(Request $request)
    {
        $validated = $request->validate([
            'min' => ['nullable', 'numeric'],
            'max' => ['nullable', 'numeric', 'gte:min'],
        ]);

        $query = Payment::with('order');

        if (isset($validated['min'], $validated['max'])) {
            $query->whereBetween('amount', [$validated['min'], $validated['max']]);
        }

        return $this->partial($query->get());
    }

    public function searchById(Request $request)
    {
        $search = $request->input('searchBar');

        // The old query also matched a `customers_id` column that does not
        // exist on payment_history, so any search was a SQL error.
        $payments = Payment::with('order')
            ->where('id', 'LIKE', "%{$search}%")
            ->orWhere('order_id', 'LIKE', "%{$search}%")
            ->get();

        return $this->partial($payments);
    }

    public function removePaymentsRecords(Request $request)
    {
        $ids = $this->idList($request->input('toRemove'));

        if ($ids === []) {
            return redirect()->back()->with(['fail' => 'No selected item']);
        }

        $this->deletePayments($ids);

        return redirect()->back()->with(['success' => 'Deletion completed']);
    }

    public function removeRecord(Request $request)
    {
        $this->deletePayments([(int) $request->input('toDelete')]);

        return redirect()->back()->with(['success' => 'Deletion completed']);
    }

    /** The order-total lookup the payment form uses to prefill its amount. */
    public function ordersIdAmount(Request $request)
    {
        $order = Order::select('total', 'user_id')->findOrFail($request->input('ids'));

        return response()->json(['total' => $order->total, 'userId' => $order->user_id]);
    }

    /** Deleting the payment un-pays the order it was recorded against. */
    private function deletePayments(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            $payments = Payment::whereIn('id', $ids)->get();

            Order::whereIn('id', $payments->pluck('order_id')->unique())
                ->update(['paid_at' => null]);

            Payment::whereIn('id', $payments->pluck('id'))->delete();
        });
    }

    private function partial($payments)
    {
        return view('admin.results.paymentResult', [
            'payments' => $payments,
            'unpaidOrderIds' => Order::whereNull('paid_at')->pluck('id'),
        ]);
    }

    private function idList(?string $csv): array
    {
        if (blank($csv)) {
            return [];
        }

        return array_values(array_filter(array_map('intval', explode(',', $csv))));
    }
}
