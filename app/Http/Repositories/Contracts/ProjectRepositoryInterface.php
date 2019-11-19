<?php


namespace App\Http\Repositories\Contracts;


use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{
    public function findById($id, $columns = ['*']);

    public function create(array $attributes);

    public function getAll() : Collection;

    public function update($id, array $attributes);

    public function findWhere(array $where, $columns = ['*']);
}
