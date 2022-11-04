<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;
use App\Rules\TimeNotBeEmpty;

class TimeField extends BaseField
{
    public string $name = 'time';

    public function rules(): array
    {
        return [
            'date_format:H:i',
            new TimeNotBeEmpty()
        ];
    }

    public function messages(): array
    {
        return [
            'date_format' => 'Invalid time format'
        ];
    }
}
