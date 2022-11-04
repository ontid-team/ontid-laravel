<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Duration implements Rule
{
    private $attribute;
    private $value;
    private $attributes;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($attributes = ['from', 'to'])
    {
        $this->attributes = $attributes;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $keys = array_keys($value);
        if (count(array_intersect($this->attributes, $keys)) == 2) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ucfirst($this->attribute) . ' attribute must contain: ' . implode(', ' , $this->attributes);
    }
}
