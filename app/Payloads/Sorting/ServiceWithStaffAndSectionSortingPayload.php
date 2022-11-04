<?php

namespace App\Payloads\Sorting;

use App\Classes\Abstracts\AbstractSortingPayload;
use App\Models\User;
use OpenApi\Attributes as OA;

#[OA\Schema(required: ['staff_id', 'section_id', 'ids'])]
class ServiceWithStaffAndSectionSortingPayload extends AbstractSortingPayload
{
    #[OA\Property(property: 'staff_id', type: 'int')]
    public int $staff_id;

    #[OA\Property(property: 'section_id', type: 'int')]
    public int $section_id;

    public ?User $user;

    /**
     * @param int $staff_id
     * @param int $section_id
     * @param array $ids
     */
    public function __construct(int $staff_id, int $section_id, array $ids = [], User $user = null)
    {
        $this->staff_id = $staff_id;
        $this->section_id = $section_id;
        $this->ids = $ids;
        $this->user = $user;
    }
}
