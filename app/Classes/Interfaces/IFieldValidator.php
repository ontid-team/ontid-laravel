<?php

namespace App\Classes\Interfaces;

interface IFieldValidator
{
    public function rules(): array;
    public function messages(): array;
    public static function options(string $name = null, bool $required = false): static;
    public function getName(): string;
    public function getAdditionalRules(): array;
}
