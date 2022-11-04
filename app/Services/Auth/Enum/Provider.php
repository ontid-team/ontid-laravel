<?php

namespace App\Services\Auth\Enum;

enum Provider: string
{
    case google = 'google';
    case facebook = 'facebook';
    case apple = 'apple';
}
