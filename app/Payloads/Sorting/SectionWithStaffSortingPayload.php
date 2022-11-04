<?php

namespace App\Payloads\Sorting;
use App\Classes\Abstracts\AbstractSortingPayload;
use App\Models\User;
use OpenApi\Attributes as OA;

#[OA\Schema(required: ['staff_id', 'ids'])]
class SectionWithStaffSortingPayload extends AbstractSortingPayload
{
    #[OA\Property(property: 'staff_id', type: 'integer')]
    public int $staff_id;
    public ?User $user;

    public function __construct(int $staff_id, array $ids = [], User $user = null)
    {
        $this->staff_id = $staff_id;
        $this->ids = $ids;
        $this->user = $user;
    }
}
