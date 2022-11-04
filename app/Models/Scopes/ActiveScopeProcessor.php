<?php

namespace App\Models\Scopes;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;

class ActiveScopeProcessor implements Scope
{

    public function apply(Builder $builder, Model $model): Builder
    {
        $user = app(Request::class)->user();
        if (!$user || !$user->profile instanceof Admin) {
            return $builder->where('active', 1);
        }
        return $builder;
    }
}
