<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class DateField extends BaseField
{
    public string $name = 'date';

    public function rules(): array
    {
        return [
            'date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'date_format' => 'Invalid date format',
            'required' => 'Field is required'
        ];
    }

}
