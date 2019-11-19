<?php

namespace App\Http\Controllers\Api;

use App\Http\Repositories\Contracts\ProjectRepositoryInterface;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectsController extends ApiController
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
     * @param  ProjectRequest  $request
     * @return JsonResponse
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->validated();

        $model = $this->projectRepository->create($data);

        return $this->respond()->created($model);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadIcon(Request $request, $id)
    {
        $project = $this->projectRepository->findById($id);

        // TODO get requirements validation and implement
        if(!$request->hasFile('icon')){
            $this->respond()->validationFailed();
        }

        $uploadedFile = $request->file('icon');

        $path = sprintf('projects/%s/%s',$project->uuid,'cenas.'.$uploadedFile->getClientOriginalExtension());
        dd($path);
        $uploadedFile->storePubliclyAs();


    }
}
