<?php

namespace App\Models\Sorting;

use Illuminate\Database\Eloquent\Builder;

class ReviewSorting
{
    public function rating(Builder $builder, $direction): Builder
    {
        return $builder->orderBy('rating', $direction);
    }

    public function date(Builder $builder, $direction): Builder
    {
        return $builder->orderBy('created_at', $direction);
    }

    public function client(Builder $builder, $direction): Builder
    {
        return $builder->join('users', 'users.id', '=', 'user_id')->orderBy('users.name', $direction);
    }
}
