<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum ShirtSize: string
{
    use HasOptions;

    case XS = 'xs';
    case S = 's';
    case M = 'm';
    case L = 'l';
    case XL = 'xl';
    case XXL = 'xxl';

    // The old Types trait mapped both 6 and 7 to "XXL", so size 7 was
    // unreachable in the UI. XXXL is the size that was meant.
    case XXXL = 'xxxl';

    public function label(): string
    {
        return match ($this) {
            self::XS => 'XS',
            self::S => 'Small',
            self::M => 'Medium',
            self::L => 'Large',
            self::XL => 'XL',
            self::XXL => 'XXL',
            self::XXXL => 'XXXL',
        };
    }
}
