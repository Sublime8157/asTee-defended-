<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * The headline money finding: order totals were computed in the browser.
 * public/js/cart.js summed them, they travelled in a GET query string,
 * checkout.blade.php rendered them into editable text inputs, and
 * confirmCheckout wrote $request->total to the database — a field absent from
 * the validation rules entirely. Per-line price was a hidden input validated
 * only as `numeric` and never compared against the catalog.
 */
class CheckoutPricingTest extends TestCase
{
    use RefreshDatabase;

    private function cartFor(User $user, Product $product, int $quantity = 2): void
    {
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }

    public function test_the_order_total_ignores_money_sent_in_the_request(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 500.00, 'stock' => 10]);
        $this->cartFor($user, $product);

        $this->actingAs($user)
            ->post('/confirmCheckout', [
                'items' => (string) $product->id,
                'address' => '1 Test St',
                'contact' => '09171234567',
                'payment_method' => 'online_payment',
                // What an attacker would send.
                'total' => 1,
                'price' => 1,
                'subTotal' => 1,
                'shippingFee' => 0,
            ])
            ->assertRedirect(route('myPurchase'));

        $order = Order::sole();

        $this->assertEquals(1000.00, $order->subtotal);
        $this->assertEquals(OrderService::SHIPPING_FEE, $order->shipping_fee);
        $this->assertEquals(1000.00 + OrderService::SHIPPING_FEE, $order->total);
        $this->assertEquals(500.00, $order->items->sole()->unit_price);
    }

    public function test_stock_is_decremented_and_the_cart_is_cleared(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 250.00, 'stock' => 10]);
        $this->cartFor($user, $product, 3);

        $this->actingAs($user)->post('/confirmCheckout', [
            'items' => (string) $product->id,
            'address' => '1 Test St',
            'contact' => '09171234567',
            'payment_method' => 'cash_on_delivery',
        ]);

        $this->assertSame(7, $product->fresh()->stock);
        $this->assertSame(0, CartItem::where('user_id', $user->id)->count());
        $this->assertSame(OrderStatus::ToPay, Order::sole()->items->sole()->status);
    }

    public function test_an_order_short_on_stock_fails_whole_and_rolls_back(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $available = Product::factory()->create(['price' => 100.00, 'stock' => 10]);
        $short = Product::factory()->create(['price' => 100.00, 'stock' => 1]);

        $this->cartFor($user, $available, 1);
        $this->cartFor($user, $short, 5);

        $this->actingAs($user)->post('/confirmCheckout', [
            'items' => $available->id.','.$short->id,
            'address' => '1 Test St',
            'contact' => '09171234567',
            'payment_method' => 'cash_on_delivery',
        ])->assertSessionHasErrors('items');

        // The in-stock line must not have been sold or removed from the cart.
        $this->assertSame(0, Order::count());
        $this->assertSame(10, $available->fresh()->stock);
        $this->assertSame(2, CartItem::where('user_id', $user->id)->count());
    }

    public function test_a_customer_cannot_check_out_another_customers_cart(): void
    {
        Mail::fake();

        $owner = User::factory()->create();
        $attacker = User::factory()->create();
        $product = Product::factory()->create(['price' => 100.00, 'stock' => 10]);
        $this->cartFor($owner, $product);

        // The product id is guessable; the cart row it belongs to is not the
        // attacker's, so there is nothing to check out.
        $this->actingAs($attacker)->post('/confirmCheckout', [
            'items' => (string) $product->id,
            'address' => '1 Test St',
            'contact' => '09171234567',
            'payment_method' => 'cash_on_delivery',
        ])->assertSessionHasErrors('items');

        $this->assertSame(0, Order::count());
        $this->assertSame(10, $product->fresh()->stock);
    }
}
