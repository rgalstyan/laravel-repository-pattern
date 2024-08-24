<?php

declare(strict_types=1);


namespace App\Repository;

/**
 * Interface BaseRepositoryInterface.
 */
interface BaseRepositoryInterface
{
    public function create(array $attributes): mixed;

    public function all(): mixed;

    public function updateOrCreate(array $searchAttributes, array $changeAttributes);

    public function insertOrIgnore(array $attributes): mixed;

    public function insert(array $attributes): mixed;

    public function insertGetId(array $attributes): mixed;

    public function find(int $id): mixed;

    public function findTrashed(int $id): mixed;

    public function delete(int $id): mixed;

    public function first(): mixed;

    public function last(): mixed;

    public function findWhere(array $conditions);

    public function updateById(int $id, array $attributes);

    public function updateWhere(array $params, array $data);
}