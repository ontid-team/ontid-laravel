<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class CommentField extends BaseField
{
    public string $name = 'comment';

    public function rules(): array
    {
        return [
            'max:200',
            'min:3',
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
