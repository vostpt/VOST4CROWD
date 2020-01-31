<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Repositories\Contracts\ProjectRepositoryInterface;
use App\Http\Requests\ProjectIconRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectsIconsController extends ApiController
{
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->projectRepository->getAll();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectIconRequest  $request
     * @param $id
     * @return JsonResponse
     */
    public function store(ProjectIconRequest $request, $id)
    {
        $project = $this->projectRepository->findById($id);

        try {
            $storageDisk = Storage::disk('public');

            if (! empty($project->icon)) {
                $storageDisk->delete($project->icon);
            }

            $uploadedFile = $request->file('icon');
            $filename     = \uniqid('vostpt_icon_').'.'.$uploadedFile->getClientOriginalExtension();
            $basePath     = 'files/projects/%s';
            $fileBasePath = \sprintf($basePath, $project->uuid);
            $path         = $storageDisk->putFileAs($fileBasePath, $uploadedFile, $filename);

            $project->icon = $path;
            $project->save();
        } catch (\Throwable $t) {
            return $this->respond()->internalServerError();
        }

        return $this->respond()->success(['path' => url($path)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $project = $this->projectRepository->findById($id);

        $storageDisk = Storage::disk('public');
        $storageDisk->delete($project->icon);

        return $this->respond()->success([], 'Deleted.');
    }
}
