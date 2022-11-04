<?php

namespace App\ValueObjects;

class DurationDay
{
    public Duration $work;
    public ?array $break = null;

    /**
     * @param Duration $work
     * @param $break
     */
    public function __construct(Duration $work, ?array $break)
    {
        $this->work = $work;
        $this->break = $break;
    }

    public function getDuration()
    {
        $breakSummary = $this->getBreakSummary();
        return [
            'work' => $this->seconds2human($this->work->getDuration() - $breakSummary, true),
            'break' => $this->seconds2human($breakSummary, true)
        ];
    }

    private function getBreakSummary()
    {
        $duration = 0;
        if (is_array($this->break)) {
            /** @var Duration $item */
            foreach ($this->break as $item) {
                $duration += $item->getDuration();
            }
        }
        return $duration;
    }

    /**
     * @param $ss
     * @param $nullable
     * @return string|null
     */
    public function seconds2human($sec, $nullable): ?string
    {
        if (empty($sec) && $nullable) {
            return null;
        }
        $m = floor(($sec%3600)/60);
        $h = floor(($sec%86400)/3600);

        $result = '';
        if ($h != 0) {
            $result = $h . 'h';
        }

        if ($m != 0) {
            if (!empty($result)) $result .= ' ';
            $result .= $m . 'm';
        }

        return $result;
    }
}
