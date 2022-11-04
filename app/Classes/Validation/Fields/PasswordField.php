<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;

class PasswordField extends BaseField
{
    public string $name = 'password';
    public bool $required = true;

    public function rules(): array
    {
        return [
            'string',
            'min:8' ,
            'max:100',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[[#?!@$%^&№*_ \/<>,.\/:"|;\'\{}\\[\]])[A-Za-z\d#?!@$%^&№*_ \/<>,.\/:"|;\'\{}\\[\]]{8,}$/'
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'Password should be not less than 8 symbols and must include capital letter, small letter, digit, special symbol',
            'min' => 'Password should be not less than 8 symbols and must include capital letter, small letter, digit, special symbol',
            'max' => 'The password is too long',
            'regex' => 'Password should be not less than 8 symbols and must include capital letter, small letter, digit, special symbol'
        ];
    }
}
