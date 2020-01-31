<?php


namespace App\Http\Repositories;


use App\Http\Repositories\Contracts\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository extends Repository implements ProjectRepositoryInterface
{
    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return Project::class;
    }
}
