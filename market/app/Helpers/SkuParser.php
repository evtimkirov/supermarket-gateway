<?php

namespace App\Helpers;

/**
 * Separate the letters from the string
 */
class SkuParser
{
    /**
     * Parse the string with the products "ABABBD" in array
     *
     * @param string $skuString
     * @return array
     */
    public static function parse(string $skuString): array
    {
        return array_count_values(str_split($skuString));
    }
}
