<?php

namespace App\Payloads\Sorting;

use App\Classes\Abstracts\AbstractSortingPayload;

class PersonalSortingPayload extends AbstractSortingPayload
{
    public int $user_id;

    /**
     * @param int $user_id
     */
    public function __construct(int $user_id, $ids = [])
    {
        $this->user_id = $user_id;
        $this->ids = $ids;
    }
}
