<?php

namespace App\Traits;

use App\Exceptions\DomainException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * @method static Builder|self sorting(Request|string $input = [])
 */
trait SortingByRequest
{
    private static $className = null;

    /**
     * @throws DomainException
     */
    public static function bootSortingByRequest()
    {
        self::$className = config('sorting.namespace', 'App\\Models\\Sorting\\').class_basename(self::class).'Sorting';
        if (!class_exists(self::$className)) {
            throw new DomainException('Class ' . self::$className . ' does`t exist');
        }
    }

    public function scopeSorting($builder, Request|string $request)
    {
        if ($request instanceof Request) {
            if ($request->has('sort')) {
                $this->process($builder, $request->sort);
            }
        } else {
            $this->process($builder, $request);
        }
        return $builder;
    }

    protected function process($builder, $sort)
    {
        $parts = explode('|', $sort);
        if (method_exists(self::$className, $parts[0])) {
            if (in_array($parts[1], ['asc', 'desc'])) {

                $instance = new self::$className;
                return $instance->{$parts[0]}($builder, $parts[1]);
            }
        }
    }
}
