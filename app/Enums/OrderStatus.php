<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

/**
 * The lifecycle of a single order line.
 *
 * This replaces both the `product_status` lookup table and the physical move
 * between `product_on_hand`, `product_on_process` and `product_on_return_cancel`
 * — an item now stays in one row and changes `status`.
 *
 * The old integer 0 ("On Hand") is deliberately absent: on-hand stock is the
 * catalog (`products`), never an order line.
 */
enum OrderStatus: string
{
    use HasOptions;

    case ToPay = 'to_pay';
    case ToShip = 'to_ship';
    case ToReceive = 'to_receive';
    case ToReview = 'to_review';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::ToPay => 'To Pay',
            self::ToShip => 'To Ship',
            self::ToReceive => 'To Receive',
            self::ToReview => 'To Review',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    /** Lines that still hold stock and still owe the customer something. */
    public function isOpen(): bool
    {
        return ! in_array($this, [self::Completed, self::Cancelled], true);
    }
}
