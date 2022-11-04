<?php

namespace App\Classes\Facades\DynamicOperator;

use Illuminate\Support\Facades\Facade;

class DynamicOperatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'DynamicOperator';
    }
}
