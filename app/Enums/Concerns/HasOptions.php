<?php

namespace App\Enums\Concerns;

/**
 * Shared helpers for the backed enums that replaced the `variations`, `genders`,
 * `sizes`, `status` and `product_status` lookup tables.
 *
 * `options()` exists so a Blade `<select>` renders from the enum itself rather
 * than a hand-typed `<option>` list — the old lists had already drifted apart
 * (cancel reason 7 read "Reason 4" in one view, "Other" in a second and
 * "Other reasons" in a third).
 */
trait HasOptions
{
    /** @return array<string, string> value => label */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
