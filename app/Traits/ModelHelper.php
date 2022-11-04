<?php

namespace App\Traits;

trait ModelHelper
{
    public function getFieldFromRequest($field)
    {
        $request = request();
        if ($request->has($field)) $this->{$field} = $request->{$field};
    }
}
