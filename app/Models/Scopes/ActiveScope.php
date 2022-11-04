<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static disabled()
 * @method static active()
 */
trait ActiveScope
{

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('active', 1);
    }

    public function scopeDisabled(Builder $builder): Builder
    {
        return $builder->where('active', 0);
    }

}
