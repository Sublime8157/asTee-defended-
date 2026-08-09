<?php

namespace Database\Seeders;

use App\Enums\CancelReason;
use App\Enums\OrderStatus;
use App\Models\AdminUser;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Database\Seeder;

/**
 * A catalog, one admin and enough orders for every admin screen to have rows on
 * it. Orders are placed through OrderService rather than inserted directly, so
 * the seeded data is data the application could actually have produced —
 * stock is decremented, totals are computed, snapshots are taken.
 */
class DatabaseSeeder extends Seeder
{
    public function run(OrderService $orders): void
    {
        AdminUser::create([
            'fname' => 'Store',
            'lname' => 'Owner',
            'email' => 'admin@astee.test',
            'username' => 'owner',
            'password' => 'Password123!',
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $products = Product::factory(24)->create();
        $inStock = $products->where('stock', '>', 5);

        $customers = User::factory(12)->create();
        User::factory(3)->blocked()->create();
        User::factory(3)->unverified()->create();

        $shopper = User::factory()->idVerified()->create([
            'fname' => 'Demo',
            'lname' => 'Customer',
            'email' => 'customer@astee.test',
            'username' => 'demo',
        ]);

        // A cart to look at on /cart.
        foreach ($inStock->random(3) as $product) {
            CartItem::create([
                'user_id' => $shopper->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3),
            ]);
        }

        $statuses = OrderStatus::cases();

        foreach ($customers->take(8) as $index => $customer) {
            $order = $orders->placeFor(
                $customer,
                $inStock->random(rand(1, 3))->mapWithKeys(fn ($p) => [$p->id => rand(1, 2)])->all(),
                [
                    'address' => $customer->address,
                    'contact' => $customer->contact,
                    'payment_method' => $index % 3 === 0 ? 'cash_on_delivery' : 'online_payment',
                ]
            );

            $status = $statuses[$index % count($statuses)];

            $order->items()->update([
                'status' => $status,
                'cancel_reason' => $status === OrderStatus::Cancelled
                    ? fake()->randomElement(CancelReason::cases())
                    : null,
            ]);

            if (in_array($status, [OrderStatus::ToReceive, OrderStatus::ToReview, OrderStatus::Completed], true)) {
                $order->update(['paid_at' => $order->created_at]);
            }

            if ($status === OrderStatus::Completed) {
                foreach ($order->items as $item) {
                    Review::create([
                        'user_id' => $customer->id,
                        'order_item_id' => $item->id,
                        'rating_overall' => rand(3, 5),
                        'rating_quality' => rand(3, 5),
                        'rating_service' => rand(3, 5),
                        'comment' => fake()->sentence(12),
                        'is_featured' => true,
                    ]);
                }
            }
        }
    }
}
