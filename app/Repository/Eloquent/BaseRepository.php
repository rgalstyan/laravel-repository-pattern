<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Repository\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected mixed $model;

    /** BaseRepository constructor. */
    public function __construct(mixed $model = null)
    {
        $this->model = $model;
    }

    public function create(array $attributes): mixed
    {
        return $this->model->create($attributes);
    }

    public function updateOrCreate(array $searchAttributes, array $changeAttributes): mixed
    {
        return $this->model->updateOrCreate($searchAttributes, $changeAttributes);
    }

    public function insertOrIgnore(array $attributes): mixed
    {
        return $this->model->insertOrIgnore($attributes);
    }

    public function insert(array $attributes): mixed
    {
        return $this->model->insert($attributes);
    }

    public function insertGetId(array $attributes): mixed
    {
        return $this->model->insertGetId($attributes);
    }

    public function find(int $id): mixed
    {
        return $this->model->find($id);
    }

    public function findTrashed(int $id): mixed
    {
        return $this->model->onlyTrashed()->find($id);
    }

    public function all(): mixed
    {
        return $this->model->all();
    }

    public function delete(int $id): mixed
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function updateById(int $id, array $attributes): mixed
    {
        return $this->model->findOrFail($id)->update($attributes);
    }

    public function updateWhere(array $params, array $data): void
    {
        $this->model->where($params)->update($data);
    }

    public function first(): mixed
    {
        return $this->model->first();
    }

    public function last(): mixed
    {
        return $this->model->orderByDesc('id')->first();
    }

    public function findWhere(array $conditions): mixed
    {
        return $this->model->where($conditions)->get();
    }
}