<?php

namespace App\Models\Sorting;


use DB;
use Illuminate\Database\Eloquent\Builder;

class ServiceSorting
{
    public function rating(Builder $builder, $direction)
    {
        return $builder->with(['profile' => function ($q) use ($direction) {
            $q->withCount(['reviews as average_rating' => function ($q) {
                $q->select(DB::raw('coalesce(avg(rating),0)'));
            }])->orderBy('average_rating', $direction);
        }]);
    }

    public function price(Builder $builder, $direction)
    {
        $builder->orderByRaw('IFNULL(discount_price, price) ' . $direction);
    }
}
