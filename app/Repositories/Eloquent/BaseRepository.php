<?php

namespace App\Repositories\Eloquent;

use App\Classes\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Classes\Paginate\Paginate;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     * @throws \Exception
     */
    public function __construct(Model $model)
    {
        if (!$model instanceof Model) {
            throw new \Exception("Class {$model} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     *
     * @return Model
     */
    public function update(int $id,array $attributes): Model
    {
        $model = $this->model->find($id);
        $model->update($attributes);
        return $model;
    }

    /**
     * Delete row from table.
     *
     * @param Model
     * @return bool|null
     * @throws \Exception
     */
    public function delete($model)
    {
        return $model->delete();
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Create a new Eloquent Query Builder instance
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * Get all the records.
     *
     * @param FilterInterface $filter
     * @return Paginate
     */
    public function paginate(FilterInterface $filter): ?Paginate
    {
        return new Paginate($this->model->loadRelations()->filter($filter));
    }


}
