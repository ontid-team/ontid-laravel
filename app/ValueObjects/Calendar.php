<?php

namespace App\ValueObjects;

class Calendar
{
    public string $date;
    public Duration $work;
    public array|Duration $break;
    public $duration;

    /**
     * @param string $date
     * @param Duration $work
     * @param array|Duration $break
     */
    public function __construct(string $date, Duration $work, array|Duration $break)
    {
        $this->date = $date;
        $this->work = $work;
        $this->break = $break;
        $this->duration = (new DurationDay($this->work, $this->break))->getDuration();
    }

}
