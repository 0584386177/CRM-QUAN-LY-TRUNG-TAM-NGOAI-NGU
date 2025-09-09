<?php

namespace App;

enum TeacherType
{
    const FULLTIME = 'full-time';
    const PARTTIME = 'part-time';

    public static function values()
    {
        return [
            self::FULLTIME,
            self::PARTTIME,
        ];
    }

    public static function labels()
    {
        return [
            self::FULLTIME => 'Full Time',
            self::PARTTIME => 'Part Time',
        ];
    }
}
