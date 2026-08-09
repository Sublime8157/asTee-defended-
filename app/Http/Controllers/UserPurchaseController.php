<?php

namespace App\Http\Controllers;

use App\Enums\CancelReason;
use App\Enums\OrderStatus;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserPurchaseController extends Controller
{
    /**
     * The customer's purchase tabs.
     *
     * Replaces toPay() and productStatus(), which were the same method twice
     * and read the user id from session('id') rather than from the guard.
     */
    public function index(Request $request)
    {
        $status = OrderStatus::tryFrom((string) $request->query('status')) ?? OrderStatus::ToPay;

        $items = $this->ownedItems()
            ->with('order')
            ->where('status', $status)
            ->latest()
            ->get();

        // One grouped query. This was four separate count() queries, and the
        // order details were re-fetched inside a per-row transform() closure.
        $counts = $this->ownedItems()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('user.userProfile.myPurchase', compact('items', 'counts', 'status'));
    }

    /** Cancel a line and put the stock back. */
    public function submitToCancel(Request $request, int $id)
    {
        $validated = $request->validate([
            'reason' => ['required', Rule::enum(CancelReason::class)],
            'specify' => ['nullable', 'string', 'max:255'],
        ]);

        $item = $this->findOwnedItem($id);

        if (! $item->status->isOpen()) {
            throw ValidationException::withMessages([
                'reason' => 'This order can no longer be cancelled.',
            ]);
        }

        DB::transaction(function () use ($item, $validated) {
            $item->product?->increment('stock', $item->quantity);

            $item->update([
                'status' => OrderStatus::Cancelled,
                'cancel_reason' => $validated['reason'],
                'cancel_note' => $validated['specify'] ?? null,
            ]);
        });

        return redirect()->back()->with('success', 'Your order was cancelled successfully');
    }

    public function orderReceived(Request $request)
    {
        $validated = $request->validate([
            'order_item_id' => ['required', 'integer'],
        ]);

        $this->findOwnedItem($validated['order_item_id'])
            ->update(['status' => OrderStatus::ToReview]);

        return redirect()->back()->with('success', 'Order moved to feedback');
    }

    /**
     * Leave a review and close the line.
     *
     * The old version inserted a fresh row into the `products` table purely so
     * `feedback.productId` had something to point at, then deleted the order
     * line entirely — the customer's purchase history disappeared the moment
     * they reviewed it.
     */
    public function submitReview(Request $request)
    {
        $validated = $request->validate([
            'order_item_id' => ['required', 'integer'],
            'rating_overall' => ['required', 'integer', 'between:1,5'],
            'rating_quality' => ['required', 'integer', 'between:1,5'],
            'rating_service' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $item = $this->findOwnedItem($validated['order_item_id']);

        if ($item->review()->exists()) {
            throw ValidationException::withMessages([
                'order_item_id' => 'You have already reviewed this item.',
            ]);
        }

        // store() hashes the name. storeAs($clientOriginalName) let one customer
        // overwrite another's upload by picking the same filename.
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : null;

        DB::transaction(function () use ($item, $validated, $imagePath) {
            Review::create([
                'user_id' => Auth::id(),
                'order_item_id' => $item->id,
                'rating_overall' => $validated['rating_overall'],
                'rating_quality' => $validated['rating_quality'],
                'rating_service' => $validated['rating_service'],
                'comment' => $validated['comment'] ?? null,
                'image_path' => $imagePath,
            ]);

            $item->update(['status' => OrderStatus::Completed]);
        });

        return redirect()->back()->with('success', 'Thank you for your feedback');
    }

    /**
     * Lines belonging to the signed-in customer.
     *
     * submitCancel, orderRecieved and submitReview all previously took an id
     * from the request and acted on it without tying it to anyone — any
     * customer could cancel or review any other customer's order.
     */
    private function ownedItems()
    {
        return OrderItem::whereRelation('order', 'user_id', Auth::id());
    }

    private function findOwnedItem(int $id): OrderItem
    {
        return $this->ownedItems()->whereKey($id)->firstOrFail();
    }
}
