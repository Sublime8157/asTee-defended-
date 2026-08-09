<?php

namespace Tests\Unit;

use App\Enums\CancelReason;
use App\Enums\Gender;
use App\Enums\OrderStatus;
use App\Enums\ShirtSize;
use App\Enums\Variation;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EnumOptionsTest extends TestCase
{
    public static function enums(): array
    {
        return [
            [CancelReason::class],
            [Gender::class],
            [OrderStatus::class],
            [ShirtSize::class],
            [Variation::class],
        ];
    }

    /**
     * Blade renders `<select>` options from options() and the controllers
     * validate the submitted value with Rule::enum. If a key ever failed to
     * round-trip through from(), the form would post a value its own validator
     * rejects.
     */
    #[DataProvider('enums')]
    public function test_every_option_key_is_a_valid_case_and_every_case_is_offered(string $enum): void
    {
        $options = $enum::options();

        $this->assertCount(count($enum::cases()), $options);

        foreach ($options as $value => $label) {
            $this->assertSame($label, $enum::from($value)->label());
        }
    }
}
