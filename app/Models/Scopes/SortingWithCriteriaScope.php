<?php

namespace App\Models\Scopes;

use App\Classes\Interfaces\ISortingPayload;
use App\Models\Section;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder|Section sortingWithCriteria(User $user, ISortingPayload $payload)
 */
trait SortingWithCriteriaScope
{
    public function scopeSortingWithCriteria(Builder $builder, User $user, ISortingPayload $payload)
    {
        $personalSorting = $user->personalSorting()
            ->where('model', get_class($builder->getModel()))
            ->select('payload->' . $payload->getId() . ' as payload')
            ->first();
        if ($personalSorting && is_array($personalSorting->payload)) {
            return $builder->orderBy(DB::raw('FIELD(id,' . implode(',', $personalSorting->payload) . ')'));
        }
        return $builder;
    }
}
