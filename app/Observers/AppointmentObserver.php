<?php

namespace App\Observers;

use App\Exceptions\DomainException;
use App\Models\Appointment;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class AppointmentObserver
{
    /**
     * @throws DomainException
     */
    public function saving(Appointment $appointment)
    {
        //todo: tz
        $startedAt = new Carbon($appointment->from . ' ' . $appointment->started_at);
        if ($appointment->service) {
            $duration = $appointment->service->duration;
        } else {
            $duration = CarbonInterval::createFromFormat('H:i', '01:00');
        }

        $appointment->finished_at = clone $startedAt;

        $appointment->finished_at->add($duration);
        if ($startedAt->toDateString() != $appointment->finished_at->toDateString()) {
            throw new DomainException('It`s forbidden to complete the service on the next day');
        }
        $appointment->finished_at = $appointment->finished_at->toTimeString();
        $appointment->day = $startedAt->dayOfWeek;
    }
}
