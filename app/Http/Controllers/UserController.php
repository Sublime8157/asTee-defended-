<?php

namespace App\Http\Controllers;

use App\Mail\InvoicePaymentMail;
use App\Mail\NewOrderMadeMail;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function about_us()
    {
        return view('user.about_us');
    }

    public function DIY()
    {
        return view('user.DIY');
    }

    public function userProfile()
    {
        return view('user.userProfile.myaccount', ['user' => Auth::user()]);
    }

    public function userPassword()
    {
        return view('user.userProfile.myPassword');
    }

    /**
     * Add a product to the signed-in customer's cart.
     *
     * The user id used to arrive in the request body and was merely validated
     * as existing, so any customer could fill any other customer's cart.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $cartItem = CartItem::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
        ]);

        return redirect()->back()->with([
            'success' => $cartItem->wasRecentlyCreated
                ? 'Added to cart'
                : 'Item was already in the cart',
        ]);
    }

    /** The route used to be /cart/{userId} — any id, no ownership check. */
    public function cart()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            // A product deleted from the catalog leaves a dangling line.
            ->filter(fn (CartItem $item) => $item->product !== null);

        return view('user.userCart', compact('cartItems'));
    }

    /** Remove one line. Scoped to the owner — the id alone is not authorisation. */
    public function remove(int $cartItemId)
    {
        CartItem::where('user_id', Auth::id())->whereKey($cartItemId)->delete();

        return redirect()->back();
    }

    public function removeAll(Request $request)
    {
        $ids = $this->idList($request->input('toRemove'));

        CartItem::where('user_id', Auth::id())->whereIn('product_id', $ids)->delete();

        return redirect()->back();
    }

    /** Review screen. Prices come from the catalog, never from the request. */
    public function checkout(Request $request)
    {
        $productIds = $this->idList($request->input('items'));

        $this->syncQuantities($request->input('quantity'));

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('product_id', $productIds)
            ->get()
            ->filter(fn (CartItem $item) => $item->product !== null);

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with(['error' => 'No selected product']);
        }

        $subtotal = $cartItems->sum(
            fn (CartItem $item) => round((float) $item->product->price * $item->quantity, 2)
        );

        return view('user.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => round($subtotal, 2),
            'user' => Auth::user(),
        ]);
    }

    public function confirmCheckout(Request $request, OrderService $orders)
    {
        $validated = $request->validate([
            'items' => ['required', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'min:10', 'max:20'],
            'payment_method' => ['required', 'in:cash_on_delivery,online_payment'],
        ]);

        $order = $orders->place(
            Auth::user(),
            $this->idList($validated['items']),
            $validated
        );

        $invoice = [
            'orderNo' => $order->id,
            'address' => $order->address,
            'contact' => $order->contact,
            'items' => $order->items,
            'mop' => $order->payment_method,
            'total' => $order->total,
            'orderDate' => $order->created_at->format('Y-m-d'),
        ];

        // Still synchronous — Phase 4 moves the Mailables onto the queue.
        Mail::to(Auth::user()->email)->send(new InvoicePaymentMail($invoice));
        Mail::to(config('mail.inboxes.orders'))->send(new NewOrderMadeMail($invoice));

        return redirect()->route('myPurchase')->with(
            'success',
            'Order has been made successfully, an order invoice has been sent to your email. Thank you!'
        );
    }

    /** "1, 2,3" -> [1, 2, 3]. The forms post ids as one comma-joined string. */
    private function idList(?string $csv): array
    {
        if (blank($csv)) {
            return [];
        }

        return array_values(array_filter(array_map('intval', explode(',', $csv))));
    }

    /**
     * Persist the quantities chosen on the cart page.
     *
     * Quantity is the customer's to pick, so it is accepted from the request —
     * but it is stored on the cart row and read back from there, rather than
     * riding along to checkout in a query string next to a price.
     */
    private function syncQuantities(?string $json): void
    {
        foreach (json_decode((string) $json, true) ?? [] as $row) {
            if (! isset($row['id'], $row['quantity'])) {
                continue;
            }

            $quantity = max(1, (int) $row['quantity']);
            $stock = Product::whereKey((int) $row['id'])->value('stock') ?? 0;

            CartItem::where('user_id', Auth::id())
                ->where('product_id', (int) $row['id'])
                ->update(['quantity' => min($quantity, max(1, $stock))]);
        }
    }
}
