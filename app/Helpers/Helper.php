<?php

namespace App\Helpers;

class Helper
{
    public static function formatNumber(string $number)
    {

        if (strlen($number) === 10) {
            $first = substr($number, 0, 4);

            $middle = substr($number, 4, 3);

            $end = substr($number, 7, 3);

            $number = $first . "." . $middle . "." . $end;

            return $number;
        }
    }

    public static function formatPrice(int $price, string $prefix = "đ")
    {

        if (isset($price) && is_int($price)) {
            return number_format($price, 0, '.', '.') . $prefix;
        }
    }
}
