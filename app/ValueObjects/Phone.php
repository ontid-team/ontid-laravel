<?php

namespace App\ValueObjects;

class Phone
{
    public string $number;

    public function __construct($number)
    {
        $this->number = $number;
    }
}
