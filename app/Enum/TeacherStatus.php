<?php

namespace App\Enum;

enum TeacherStatus
{
    const WORKING = 'working';
    const RESIGNED = 'resigned';

    public static function value()
    {
        return [
            self::WORKING,
            self::RESIGNED,
        ];
    }

    public static function label()
    {
        return [
            self::WORKING => 'Đang công tác',
            self::RESIGNED => 'Đã nghỉ làm'
        ];
    }
}
