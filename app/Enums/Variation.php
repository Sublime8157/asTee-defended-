<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum Variation: string
{
    use HasOptions;

    case Couple = 'couple';
    case Solo = 'solo';
    case Family = 'family';
    case Kids = 'kids';

    public function label(): string
    {
        return match ($this) {
            self::Couple => 'Couple Shirt',
            self::Solo => 'Solo Shirt',
            self::Family => 'Family Shirt',
            self::Kids => 'Kids Wear',
        };
    }
}
