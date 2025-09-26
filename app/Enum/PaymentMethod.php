<?php

namespace App\Enum;

enum PaymentMethod
{
    const CASHER = 'cash';
    const TRANSFER = 'transfer';


    public static function label()
    {
        return [
            self::CASHER => 'Tiền mặt',
            self::TRANSFER => 'Chuyển khoản',
        ];
    }
}
