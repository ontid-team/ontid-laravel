<?php

namespace App\Classes\Validation\Fields;

use App\Classes\Abstracts\BaseField;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class RelationField extends BaseField
{
    protected $model;
    protected bool $is_owner = false;

    public function rules(): array
    {
        $rules = [
            'integer',
        ];
        if ($this->model) $rules[] = $this->existsRule();

        return $rules;
    }

    public function messages(): array
    {
        return [];
    }

    public function setModel($model, $is_owner = false): static
    {
        $this->model = $model;
        $this->is_owner = $is_owner;
        return $this;
    }

    protected function existsRule(): Exists
    {
        $exists = Rule::exists($this->model, 'id');
        if ($this->is_owner) {
            $exists->where(function ($query) {
                return $query->where('user_id', auth()->id());
            });
        }

        return $exists;
    }

}
