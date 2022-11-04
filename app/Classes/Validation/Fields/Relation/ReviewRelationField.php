<?php

namespace App\Classes\Validation\Fields\Relation;

use App\Classes\Validation\Fields\RelationField;
use App\Models\Review;
use App\Models\Staff;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class ReviewRelationField extends RelationField
{
    public string $name = 'review_id';
    protected $model = Review::class;
    protected bool $is_owner = true;

    protected function existsRule(): Exists
    {
        $exists = Rule::exists($this->model, 'id');
        if ($this->is_owner) {
            $exists->where(function ($query) {
                return $query->where('salon_id', auth()->user()->profile->id);
            });
        }
        return $exists;
    }
}
