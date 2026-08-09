<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

/**
 * Reasons 4–7 were placeholders ("Reason 1".."Reason 4") in the admin views and
 * real text in the customer view. The customer wording is the one that reached
 * an actual person, so it is the one kept.
 */
enum CancelReason: string
{
    use HasOptions;

    case WrongProduct = 'wrong_product';
    case DifferentColor = 'different_color';
    case WrongDesign = 'wrong_design';
    case ChangedMind = 'changed_mind';
    case OrderDetails = 'order_details';
    case ChangeOrder = 'change_order';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::WrongProduct => 'Wrong Product',
            self::DifferentColor => 'Different Color',
            self::WrongDesign => 'Wrong Design',
            self::ChangedMind => 'Changed my mind',
            self::OrderDetails => 'Order details',
            self::ChangeOrder => 'Change order',
            self::Other => 'Other',
        };
    }
}
