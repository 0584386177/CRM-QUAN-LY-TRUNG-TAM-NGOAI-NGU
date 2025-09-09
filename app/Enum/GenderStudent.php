<?php

namespace App\Enum;

enum GenderStudent
{
    const MALE = 'nam';
    const FEMALE = 'nữ';

    public static function values()
    {
        return [
            self::MALE,
            self::FEMALE,
        ];
    }

    public static function labels()
    {
        return [
            self::MALE => 'Nam',
            self::FEMALE => 'Nữ',
        ];
    }
}
