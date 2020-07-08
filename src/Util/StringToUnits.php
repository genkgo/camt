<?php

declare(strict_types=1);

namespace Genkgo\Camt\Util;

use InvalidArgumentException;

final class StringToUnits
{
    /**
     * Converts a string value with an amount into an integer.
     * Supports up to 5 decimals points.
     *
     * Credit goes to the mathiasverraes/money library
     */
    public static function convert(string $string): int
    {
        $sign = '(?P<sign>[-\\+])?';
        $digits = '(?P<digits>\\d*)';
        $separator = '(?P<separator>[.,])?';
        $decimals = '(?P<decimal1>\\d)?(?P<decimal2>\\d)?(?P<remaining_decimals>\\d)*';
        $pattern = '/^' . $sign . $digits . $separator . $decimals . '$/';

        if (!preg_match($pattern, trim($string), $matches)) {
            throw new InvalidArgumentException('The value could not be parsed as money');
        }

        $units = $matches['sign'] === '-' ? '-' : '';
        $units .= $matches['digits'];
        $units .= $matches['decimal1'] ?? '0';
        $units .= $matches['decimal2'] ?? '0';

        return (int) $units;
    }
}
