<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class NameField extends BaseField
{
    public string $name = 'name';

    public function rules(): array
    {
        return [
            'string',
            'min:1',
            'max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'Invalid format'
        ];
    }
}
