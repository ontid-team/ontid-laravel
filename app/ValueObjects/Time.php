<?php

namespace App\ValueObjects;

class Time
{
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function getShortValue(): string
    {
        return date('H:i', strtotime($this->value));
    }

    public function __toString(): string
    {
        return $this->value;
    }

}
