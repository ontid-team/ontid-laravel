<?php

namespace App\Traits;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * @method static Builder|self filter(Request|array $input = [])
 */
trait FilterableModel
{
    use Filterable;

    /**
     * @param $query
     * @param $input
     * @param $filter
     * @return mixed
     */
    public function scopeFilter($query, array|Request $input = [], $filter = null)
    {
        if ($input instanceof Request) {
            $input = $input->filter ?? [];
        }

        if ($filter === null) {
            $filter = $this->getModelFilterClass();
        }

        // Create the model filter instance
        $modelFilter = new $filter($query, $input);

        // Set the input that was used in the filter (this will exclude empty strings)
        $this->filtered = $modelFilter->input();

        // Return the filter query
        return $modelFilter->handle();
    }


}
