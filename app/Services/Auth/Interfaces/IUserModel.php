<?php

namespace App\Services\Auth\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface IUserModel
{
    public function tokens();
}
