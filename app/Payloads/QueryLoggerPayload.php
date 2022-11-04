<?php

namespace App\Payloads;

use App\Classes\Abstracts\BasePayload;

class QueryLoggerPayload extends BasePayload
{

    public $duration;
    public $sql;
    public $bindings;

    /**
     * @param $start
     * @param $end
     * @param $query
     */
    public function __construct($duration, $sql, $bindings)
    {
        $this->duration = $duration;
        $this->sql = $sql;
        $this->bindings = $bindings;
    }
}
