<?php

namespace App\Enums;

enum Week: int
{
    case monday = 1;
    case tuesday = 2;
    case wednesday = 3;
    case thursday = 4;
    case friday = 5;
    case saturday = 6;
    case sunday = 0;

    public static function days(string $day = null)
    {
        $values = array_column(self::cases(), 'value');
        $keys = array_column(self::cases(), 'name');
        $days = array_combine($keys, $values);

        if (is_null($day)) {
            return $days;
        }

        return $days[$day];
    }
}
