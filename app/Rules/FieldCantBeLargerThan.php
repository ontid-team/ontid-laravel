<?php

namespace App\Rules;

use DynamicOperator;
use Illuminate\Contracts\Validation\Rule;

class FieldCantBeLargerThan implements Rule
{
    private string $attribute;
    private string $tmpAttribute;
    private string $validatedAttribute;
    private string $operator = '<';
    private string $position;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($attribute, $strictMode = false, $position = 0)
    {
        $this->attribute = $attribute;
        $this->tmpAttribute = $attribute;
        $this->position = $position;
        if ($strictMode) $this->operator = '<=';
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
        $explodedAttribute = explode('.', $attribute);
        if (is_array($explodedAttribute) && !empty($this->position)) {
            $key = $explodedAttribute[$this->position-1];
        }
        if (isset($key)) {
            $this->attribute = str($this->attribute)->replace('*', $key);
        }

        $this->validatedAttribute = $attribute;

        if (
            request()->has($this->attribute) &&
            DynamicOperator::is(request()->input($this->attribute), $this->operator, $value)
        ) {
            $this->resetAttribute();
            return false;
        }
        $this->resetAttribute();
        return true;
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->operator == '<') {
            $messagePart = 'larger';
        } else {
            $messagePart = 'equal or larger';
        }
        return 'The "' . $this->validatedAttribute . '" cant`t be '. $messagePart .' than "' . $this->attribute . '"' ;
    }

    private function resetAttribute()
    {
        $this->attribute = $this->tmpAttribute;
    }
}
