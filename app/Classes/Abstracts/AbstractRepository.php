<?php

namespace App\Classes\Abstracts;


use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;
use Request;

abstract class AbstractRepository extends BaseRepository implements CacheableInterface
{
    use CacheableRepository {
        CacheableRepository::paginate as cacheablePaginate;
    }

    protected int $maxPaginationLimit = 0;

    protected ?bool $allowDisablePagination = null;

    public function model(): string
    {
        $className = $this->getClassName();

        if (method_exists($this, 'repositoryModel')) {
            return $this->repositoryModel();
        }
        $modelName = $this->getModelName($className); // e.g. User
        return $this->getModelNamespace($modelName);
    }

    private function getClassName(): string
    {
        $fullName = static::class;
        return substr($fullName, strrpos($fullName, '\\') + 1);
    }

    private function getModelName(string $className): string|array
    {
        return str_replace('Repository', '', $className);
    }

    private function getModelNamespace(array|string $modelName): string
    {
        return 'App\\Models\\' . $modelName;
    }

    public function boot()
    {
    }

    /**
     * @param null $limit
     * @param array $columns
     * @param string $method
     *
     * @return  mixed
     */
    public function paginate($limit = null, $columns = ['*'], $method = "paginate"): mixed
    {
        $limit = $this->setPaginationLimit($limit);

        if ($this->wantsToSkipPagination($limit) && $this->canSkipPagination()) {
            return $this->all($columns);
        }

        if ($this->exceedsMaxPaginationLimit($limit)) {
            $limit = $this->maxPaginationLimit;
        }

        return $this->cacheablePaginate($limit, $columns, $method);
    }

    private function setPaginationLimit($limit): mixed
    {
        return $limit ?? Request::get('limit');
    }

    private function wantsToSkipPagination(mixed $limit): bool
    {
        return $limit == "0";
    }

    private function canSkipPagination(): mixed
    {
        if (!is_null($this->allowDisablePagination)) {
            return $this->allowDisablePagination;
        }

        return config('repository.pagination.skip');
    }

    private function exceedsMaxPaginationLimit(mixed $limit): bool
    {
        return $this->maxPaginationLimit > 0 && $limit > $this->maxPaginationLimit;
    }
}
