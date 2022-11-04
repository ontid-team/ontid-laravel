<?php

namespace App\ValueObjects;

use Carbon\Carbon;
use OpenApi\Attributes as OA;

#[OA\Schema()]
class Duration
{
    #[OA\Property(property: 'from', type: 'date')]
    public ?string $from = null;

    #[OA\Property(property: 'to', type: 'date')]
    public ?string $to = null;

    public string $label;
    public ?string $duration = null;

    private ?Time $tFrom = null;
    private ?Time $tTo = null;
    private int $durationInSeconds = 0;

    /**
     * @param $from
     * @param $to
     */
    public function __construct($from = null, $to = null)
    {
        if (is_null($from)) {
            $this->label = 'No Shift';
        } else {
            $this->tFrom = new Time($from);
            $this->tTo = new Time($to);
            $this->from = $from;
            $this->to = $to;
            $this->label = $this->tFrom->getShortValue() . ' - ' . $this->tTo->getShortValue();
            $this->duration = $this->tFrom->getShortValue() . ' - ' . $this->tTo->getShortValue();
            $this->setDuration();
        }

    }

    public function setDuration()
    {
        $startTime = Carbon::parse($this->tFrom->getValue());
        $finishTime = Carbon::parse($this->tTo->getValue());
        $this->durationInSeconds =  $finishTime->diffInSeconds($startTime);
        $this->duration = $finishTime->shortAbsoluteDiffForHumans($startTime);
    }

    public function getDuration(): int
    {
        return $this->durationInSeconds;
    }
}
