<?php

namespace App\Classes\Abstracts;

abstract class BasePayload
{
    public function __toString(): string
    {
        $properties = get_object_vars($this);
        return implode(', ', array_map(function ($entry) {
            return ($entry[key($entry)]);
        }, $properties));
    }
}
