<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class AppointmentFilter extends ModelFilter
{
    public function staff($id)
    {
        return $this->where('staff_id', $id);
    }

    public function from($date)
    {
        return $this->where('from', '>=', $date);
    }

    public function to($date)
    {
        return $this->where('from', '<=', $date);
    }
}
