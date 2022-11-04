<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class PriceField extends BaseField
{
    public string $name = 'price';

    public function rules(): array
    {
        return [
            'numeric',
            'min:0,01',
            'regex:/^\d+(\.\d{1,2})?$/'
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
