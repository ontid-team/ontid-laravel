<?php

namespace App\ValueObjects;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class TimeSlot
{
    public string $from;
    public string $to;
    private Carbon $sourceFrom;
    private Carbon $sourceTo;
    public static CarbonInterval $interval;

    public function __construct(Carbon $from, Carbon $to)
    {
        $this->sourceFrom = $from;
        $this->sourceTo = $to;
        $this->from = $from->toTimeString();
        $this->to = $to->toTimeString();
        self::setInterval();
    }

    public static function setInterval(CarbonInterval $value = null)
    {
       self::$interval = !empty($value) ? $value : CarbonInterval::createFromFormat('H:i:s', '0:5:0');
    }

    public function next()
    {
        $this->from = $this->sourceFrom->add(self::$interval)->toTimeString();
        $this->to = $this->sourceTo->add(self::$interval)->toTimeString();
    }

    public function crossBreak($break): bool
    {
        return $this->from > $break->from && $this->from < $break->to ||
            $this->to > $break->from && $this->to < $break->to ||
            $this->from < $break->from && $this->to > $break->to;
    }
}
