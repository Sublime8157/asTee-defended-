<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    /**
     * The checkout page has always shown a flat ₱60 shipping fee, but it lived
     * in a `value="60"` attribute on an editable input and was added to the
     * total by a two-line script in the page. It is a server-side figure now.
     * ponytail: a constant until shipping actually varies by destination.
     */
    public const SHIPPING_FEE = 60.00;

    /**
     * Turn a selection of the customer's cart into one order.
     *
     * The request supplies product ids, an address, a contact number and a
     * payment method. It does not supply money. Every price here is read from
     * `products` under a row lock.
     *
     * Previously the browser summed the total in public/js/cart.js, passed it
     * through a GET query string, and checkout.blade.php rendered it into text
     * inputs the customer could edit; confirmCheckout then wrote
     * $request->total straight to the database without so much as a validation
     * rule on it. Per-line price was a hidden input validated `numeric` and
     * never compared against the catalog.
     *
     * The old version also had no transaction anywhere in app/: it created one
     * order row per line item inside the loop while appending to a $processingId
     * array that was never initialised, decremented stock in a branch whose
     * else arm referenced an undefined $productId, and emptied the cart by
     * productId with no user scope, once per iteration.
     */
    public function place(User $user, array $productIds, array $details): Order
    {
        return DB::transaction(function () use ($user, $productIds, $details) {
            $cartItems = CartItem::where('user_id', $user->id)
                ->whereIn('product_id', $productIds)
                ->get();

            if ($cartItems->isEmpty()) {
                throw ValidationException::withMessages([
                    'items' => 'No selected product.',
                ]);
            }

            $order = $this->placeFor(
                $user,
                $cartItems->pluck('quantity', 'product_id')->all(),
                $details
            );

            // Scoped to this customer. The old cart wipe deleted by productId
            // alone, so checking out removed that product from every other
            // customer's cart too.
            CartItem::where('user_id', $user->id)
                ->whereIn('product_id', $cartItems->pluck('product_id'))
                ->delete();

            return $order;
        });
    }

    /**
     * Place an order directly from product id => quantity.
     *
     * Used by checkout above, and by the admin screen that sells an on-hand
     * product to a named customer — the action the old moveProduct performed by
     * copying a `product_on_hand` row into `product_on_process`.
     *
     * @param  array<int, int>  $quantities
     */
    public function placeFor(User $user, array $quantities, array $details): Order
    {
        return DB::transaction(function () use ($user, $quantities, $details) {
            // lockForUpdate so two customers checking out the last shirt at the
            // same time cannot both read stock = 1 and both succeed.
            $products = Product::whereIn('id', array_keys($quantities))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $lines = [];
            $subtotal = 0.0;

            foreach ($quantities as $productId => $quantity) {
                $product = $products->get($productId);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'items' => 'A product in your cart is no longer available.',
                    ]);
                }

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Only {$product->stock} left of \"{$product->description}\".",
                    ]);
                }

                $lineTotal = round((float) $product->price * $quantity, 2);
                $subtotal += $lineTotal;

                $lines[] = [
                    'product_id' => $product->id,
                    // Snapshotted: editing the catalog later must not rewrite
                    // what this customer bought.
                    'description' => $product->description,
                    'image_path' => $product->image_path,
                    'variation' => $product->variation,
                    'gender' => $product->gender,
                    'size' => $product->size,
                    'unit_price' => $product->price,
                    'quantity' => $quantity,
                    'line_total' => $lineTotal,
                ];
            }

            $subtotal = round($subtotal, 2);

            $shippingFee = self::SHIPPING_FEE;

            $order = $user->orders()->create([
                'address' => $details['address'],
                'contact' => $details['contact'],
                'payment_method' => $details['payment_method'],
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => round($subtotal + $shippingFee, 2),
            ]);

            $order->items()->createMany($lines);

            foreach ($lines as $line) {
                $products->get($line['product_id'])->decrement('stock', $line['quantity']);
            }

            return $order->load('items');
        });
    }
}
