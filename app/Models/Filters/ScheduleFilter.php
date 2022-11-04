<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class ScheduleFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];


    public function schedule($payload)
    {
        return $this->where('finished_at', '>=', $payload['from'])
            ->where('started_at', '<=', $payload['to']);
    }
}
