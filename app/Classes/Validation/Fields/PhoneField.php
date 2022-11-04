<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class PhoneField extends BaseField
{
    public string $name = 'phone';

    public function rules(): array
    {
        return [
            'regex:/^52-[0-9]{2}-[0-9]{4}-[0-9]{4}$/'
            //'regex:/^(1-(905|706)|52)\s[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/'
        ];
    }

    public function messages(): array
    {
        return [
            'regex' => 'Invalid number format',
        ];
    }
}
