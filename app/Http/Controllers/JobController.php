<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Http\Service\CategoryService;
use App\Http\Service\CompanyService;
use App\Http\Service\JobService;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{

    protected JobService $jobService;
    protected CompanyService $companyService;
    protected CategoryService $categoryService;
    public function __construct(JobService $jobService, CompanyService $companyService,CategoryService $categoryService){
        $this->jobService = $jobService;
        $this->companyService = $companyService;
        $this->categoryService = $categoryService;
    }
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required',
            'company_id'=>'required',
            'deadline'=>'required|date',
            'category_id'=>'required',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $company=$this->companyService->getCompanyById($request->get('company_id'));
        if ($company ===null){
            return response()->json(['message'=>"Company doesn't exist"], 400);
        }
        $category=$this->categoryService->getCategoryById($request->get('category_id'));
        if ($category ===null){
            return response()->json(['message'=>"Category doesn't exist"], 400);
        }



        $job=$this->jobService->addJob($request->toArray());
        return response()->json(["job"=>new JobResource($job),'message'=>"Job created successfully"],201);
    }


    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $jobUpdated=$this->jobService->updateJob($job,$request->toArray());
        return response()->json(["jobUpdated"=>new JobResource($jobUpdated)],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $this->jobService->deleteJob($job);
        return response()->json(["message"=>"Job deleted successfully"],201);
    }
    public function searchJobs(Request $request)
    {
        $name=$request->input('name','');
        $jobs=$this->jobService->searchJobs($name);
        return response()->json(['jobs'=>JobResource::collection($jobs)]);
    }
    public function getJobsForCompany($company_id){
        $jobs=$this->jobService->getJobsForCompany($company_id);
        return response()->json(['jobs'=>JobResource::collection($jobs)]);
    }
}
