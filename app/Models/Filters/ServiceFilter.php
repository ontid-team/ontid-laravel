<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class ServiceFilter extends ModelFilter
{
    public function price($data)
    {
        $filter = $this;
        if (isset($data['min'])) $filter->where('price', '>=', $data['min']);
        if (isset($data['max'])) $filter->where('price', '<=', $data['max']);
        return $filter;
    }

    public function category($category)
    {
        return $this->where('category_id', $category);
    }
}
