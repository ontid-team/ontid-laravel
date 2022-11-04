<?php

namespace App\Console\Commands;

use App\Enums\Week;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Sorting\SectionSorting;
use App\Models\Sorting\ServiceSorting;
use App\Models\User;
use App\Payloads\Sorting\ServiceWithStaffAndSectionSortingPayload;
use App\Repositories\ScheduleNesw\ScheduleRepository;
use App\Services\Auth\AuthService;
use Illuminate\Console\Command;

class DevelopHelpers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:helpers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Developer helper tools';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(AuthService $service)
    {
//        $user = User::find(20);
//        $user->notify(new ForgotPassword);
//        return 0;
        $shift = Shift::where('id', 1)->get();
        dd($shift);

    }
}
