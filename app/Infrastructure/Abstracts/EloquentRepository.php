<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Infrastructure\Abstracts;

use App\Infrastructure\Contracts\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository implements BaseRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var \Closure
     */
    protected $scopeQuery = null;

    /**
     * A new instance of EloquentRepository
     *
     * @param Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @throws \Exception
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    /**
     * @return Model
     * @throws \Exception
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model.");
        }

        return $this->model = $model;
    }

    /**
     * Get all data
     *
     * @param array $columns
     */
    public function all(array $columns = ['*'])
    {
        $this->applyScope();
        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    /**
     * Find data by id
     *
     * @param $id
     * @param array $columns
     */
    public function find($id, array $columns = ['*'])
    {
        $this->applyScope();

        $model = $this->model->findOrFail($id, $columns);

        $this->resetModel();

        return $model;
    }

    /**
     * Find one data by field and value
     *
     * @param $field
     * @param $value
     * @param array $columns
     */
    public function findOneByField($field, $value, array $columns = ['*'])
    {
        $model = $this->findByField($field, $value, $columns);
        return $model->first();
    }

    /**
     * Find data by field and value
     *
     * @param $field
     * @param $value
     * @param array $columns
     */
    public function findByField($field, $value, array $columns = ['*'])
    {
        $this->applyScope();
        $model = $this->model->where($field, '=', $value)->get($columns);

        $this->resetModel();

        return $model;
    }

    /**
     * Find one data where conditions
     *
     * @param array $where
     * @param array $columns
     */
    public function findOneWhere(array $where, array $columns = ['*'])
    {
        $model = $this->findWhere($where, $columns);

        return $model->first();
    }

    /**
     * Find data where conditions
     *
     * @param array $where
     * @param array $columns
     */
    public function findWhere(array $where, array $columns = ['*'])
    {
        $this->applyScope();
        $this->applyConditions($where);

        $model = $this->model->get($columns);

        $this->resetModel();
        return $model;
    }

    /**
     * Save a new entity in repository
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $model = $this->model->newInstance($data);
        $model->save();

        $this->resetModel();

        return $model;
    }

    /**
     * Update entity in repository by id
     *
     * @param $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $this->applyScope();
        $model = $this->model->findOrFail($id);

        $model->fill($data);

        $this->resetModel();

        return $model;
    }

    /**
     * Delete entity in repository by id
     *
     * @param $id
     */
    public function delete($id)
    {
        $this->applyScope();
        $model = $this->find($id);

        $this->resetModel();

        $deleted = $model->delete();

        return $deleted;
    }

    /**
     * Query scope
     *
     * @param \Closure $scope
     *
     * @return self
     */
    public function scopeQuery(\Closure $scope)
    {
        $this->scopeQuery = $scope;
        return $this;
    }

    /**
     * Reset query scope
     *
     * @return self
     */
    public function resetScope()
    {
        $this->scopeQuery = null;
        return $this;
    }

    /**
     * Apply scope in current query.
     *
     * @return self
     */
    protected function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $callback = $this->scopeQuery;
            $this->model = $callback($this->model);
        }

        return $this;
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }
}
