<?php

namespace App\Support\Strings;

class StringHelper
{
    public static function clear(?string $string): ?string
    {
        if (empty($string)) {
            return null;
        }

        $string = str_replace(' ', '', $string);
        $string = str_replace('-', '', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}
