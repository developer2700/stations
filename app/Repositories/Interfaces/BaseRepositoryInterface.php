<?php

namespace App\Repositories\Interfaces;

use App\Classes\Filters\FilterInterface;
use App\Classes\Paginate\Paginate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;

    /**
     * Get all the records.
     *
     * @param FilterInterface $filter
     * @return Paginate
     */
    public function paginate(FilterInterface $filter): ?Paginate;


}
