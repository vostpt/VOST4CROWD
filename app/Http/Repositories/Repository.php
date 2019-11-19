<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\RepositoryInterface;
use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Repository implements RepositoryInterface
{
    protected $app;

    protected $model;

    /**
     * @param  Application  $app
     * @throws BindingResolutionException
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model();


    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param  null  $model
     * @return Repository
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function makeModel($model = null)
    {
        $modelClass = $model ? $model : $this->model();

        $model = $this->app->make($modelClass);

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of " . Model::class);
        }

        $this->model = $model;

        return $this;
    }

    /**
     * @throws BindingResolutionException
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    public function getTable()
    {
        return mb_strtolower(Str::plural($this->model()));
    }

    public function findById($id, $columns = ['*'])
    {
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();
        return $model;
    }

    public function create(array $attributes)
    {
        $model = $this->model->newInstance(Arr::only($attributes, $this->model->getFillable()));
        $model->save();
        $this->resetModel();

        return $model;
    }

    public function getAll($columns = ['*']) : Collection
    {
        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();

        return $results;
    }

    public function update($id, array $attributes)
    {
        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();
        $this->resetModel();

        return $model;
    }

    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyConditions($where);
        $model = $this->model->get($columns);
        $this->resetModel();
        return $model;
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     * @return void
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                if ($condition == 'in') {
                    $this->model = $this->model->whereIn($field, $val);
                } elseif ($condition == 'not') {
                    $this->model = $this->model->whereNotIn($field, $val);
                } else {
                    $this->model = $this->model->where($field, $condition, $val);
                }
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }
}
