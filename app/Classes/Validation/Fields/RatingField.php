<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class RatingField extends BaseField
{
    public string $name = 'rating';

    public function rules(): array
    {
        return [
            'required',
            'numeric',
            'min:0',
            'max:5'
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
