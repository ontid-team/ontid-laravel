<?php

namespace App\Classes\Validation\Fields\Relation;

use App\Classes\Validation\Fields\RelationField;
use App\Models\Service;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;


class ServiceRelationField extends RelationField
{
    public string $name = 'service_id';
    protected $model = Service::class;
    protected bool $is_owner = true;

    protected function existsRule(): Exists
    {
        $exists = Rule::exists($this->model, 'id');
        if ($this->is_owner) {
            $exists->where(function ($query) {
                return $query->where('profile_id', auth()->user()->profile->id);
            });
        }
        return $exists;
    }
}
