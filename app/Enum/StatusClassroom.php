<?php

namespace App\Enum;

enum StatusClassroom
{
    const PENDING = "pending";
    const ACTIVE = 'active';
    const COMPLETED = 'completed';

    public static function value()
    {
        return [
            self::PENDING,
            self::ACTIVE,
            self::COMPLETED,
        ];
    }
    public static function labels()
    {
        return [
            self::PENDING => "Sắp khai giảng",
            self::ACTIVE => "Đang hoạt động",
            self::COMPLETED => 'Đã hoàn thành',
        ];
    }
    public static function colors(): array
    {
        return [
            self::PENDING => "text-danger fw-semibold", // vàng
            self::ACTIVE => "text-primary fw-semibold",           // xanh
            self::COMPLETED => "text-success fw-semibold",           // xanh dương
        ];
    }
}
