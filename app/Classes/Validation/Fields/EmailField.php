<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class EmailField extends BaseField
{
    public string $name = 'email';

    public function rules(): array
    {
        return [
            'email',
            'min:5',
            'max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'email' => 'Invalid email format',
            'min' => 'The email is too short',
            'max' => 'The email is too long',
        ];
    }
}
