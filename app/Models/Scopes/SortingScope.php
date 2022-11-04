<?php

namespace App\Models\Scopes;

trait SortingScope
{
    public static function bootSortingScope()
    {
        static::addGlobalScope(new SortingScopeProcessor);
    }
}
