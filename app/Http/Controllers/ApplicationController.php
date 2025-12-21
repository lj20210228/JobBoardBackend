<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Http\Service\ApplicationService;
use App\Http\Service\JobService;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    protected ApplicationService $applicationService;
    protected JobService $jobService;
    public function __construct( ApplicationService $applicationService, JobService $jobService)
    {
        $this->applicationService = $applicationService;
        $this->jobService = $jobService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|exists:jobs,id',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'linkedinUrl' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $userId = $request->user()->id;

        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'public');
            $resumeUrl = asset('storage/' . $path);
        }

        $application = $this->applicationService->addAplications([
            'job_id' => $request->job_id,
            'user_id' => $userId,
            'resume_url' => $resumeUrl,
            'linkedinUrl' => $request->linkedinUrl,
            'status' => 'pending'
        ]);

        return response()->json([
            "application" => new ApplicationResource($application),
            "message" => "Application added successfully"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $applicationUpdated=$this->applicationService->updateAplication($application,$request->toArray());
        return response()->json(["application"=>new ApplicationResource($applicationUpdated),"message"=>"Application updated successfully"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $this->applicationService->deleteAplication($application);
        return response()->json(["message"=>"Application deleted successfully"], 200);
    }
    public function getApplicationsForJob( $jobId){
        $applications=$this->applicationService->getAllAplicationsForJob($jobId);
        return response()->json(["applications"=>ApplicationResource::collection($applications)], 200);
    }
    public function getApplicationsForUser(Request $request){
        $userId=$request->user()->id;
        $applications=$this->applicationService->getAllAplicationsForUser($userId);
        return response()->json(["applications"=>ApplicationResource::collection($applications)], 200);
    }
}
