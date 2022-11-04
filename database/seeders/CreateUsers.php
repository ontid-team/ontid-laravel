<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Accounting\ValueObjects\Customer;
use App\Services\Accounting\ValueObjects\Salon;
use App\Services\Auth\Interfaces\IAuthService;
use App\Services\Auth\ValueObjects\Admin;
use Illuminate\Database\Seeder;

class CreateUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IAuthService $service)
    {

    }
}
