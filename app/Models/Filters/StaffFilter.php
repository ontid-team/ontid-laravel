<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class StaffFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [
        'schedule' => [
            'schedule'
        ]
    ];

}
