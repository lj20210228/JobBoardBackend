<?php

namespace App\Http\Service;

use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class JobService
{
    public function addJob(array $request):Job{
        return Job::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'company_id' => $request['company_id'],
            'deadline' => $request['deadline'],
            'salary' => $request['salary'],
        ]);
    }
    public function updateJob(Job $job,array $data):Job{
         $job->update($data);
         return $job;
    }
    public function deleteJob(Job $job):bool{
        return $job->delete();
    }
    public function getJob($jobId):?Job{
        return Job::where("id",$jobId)->first();
    }
    public function searchJobs($name):LengthAwarePaginator{
        return Job::where("title",'like',"%$name%")
            ->orderBy("title")
            ->paginate(10);
    }
    public function getJobsForCompany($companyId):Collection
    {
        return Job::where("company_id", $companyId)->get();
    }
}
