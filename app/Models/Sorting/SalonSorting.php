<?php

namespace App\Models\Sorting;

use DB;
use Illuminate\Database\Eloquent\Builder;

class SalonSorting
{
    public function rating(Builder $builder, $direction)
    {
        return $builder->withCount(['reviews as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(rating),0)'));
        }])->orderBy('average_rating', $direction);
    }
}
