<?php

namespace  App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class TokenField extends BaseField
{
    public string $name = 'token';

    public function rules(): array
    {
        return [
            'required',
            'string',
            'min:1',
            'max:100'
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
