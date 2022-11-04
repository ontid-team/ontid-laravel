<?php

namespace App\Classes\Macros\Builder;

use App\Enums\BuilderOperationEnum;
use App\ValueObjects\Duration;
use Illuminate\Database\Eloquent\Builder;

class WhereCross
{
    private Builder $builder;
    private string $start;
    private string $end;
    private Duration $duration;

    public function __construct(Builder $builder, string $start, string $end, Duration $duration)
    {
        $this->builder = $builder;
        $this->start = $start;
        $this->end = $end;
        $this->duration = $duration;
    }

    public function execute(BuilderOperationEnum $operation): Builder
    {
        $this->builder->{$operation->value}(function ($q) {
            $q->where(function ($q) {
                $q->where($this->start, '>', $this->duration->from);
                $q->where($this->start, '<', $this->duration->to);
            })->orWhere(function ($q) {
                $q->where($this->end, '>', $this->duration->from);
                $q->where($this->end, '<', $this->duration->to);
            })->orWhere(function ($q) {
                $q->where($this->start, '<=', $this->duration->from);
                $q->where($this->end, '>=', $this->duration->to);
            });
        });
        return $this->builder;
    }

}
