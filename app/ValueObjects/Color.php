<?php

namespace App\ValueObjects;

class Color
{
    public string $color;

    public function __construct($color)
    {
        $this->color = $color;
    }
}
