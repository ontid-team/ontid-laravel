<?php

namespace App\Services\Auth\Enum;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Salon;

enum Profile: string
{
    case Admin = 'admin';
    case Customer = 'customer';
    case Salon = 'salon';


    public function getProfileModel()
    {
        $models = [
            'admin' => Admin::class,
            'customer' => Customer::class,
            'salon' => Salon::class,
        ];
        return $models[$this->value];
    }
}
