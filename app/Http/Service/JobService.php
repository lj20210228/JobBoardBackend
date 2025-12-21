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
            'category_id' => $request['category_id'],
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
    public function searchJobs(array $filters): LengthAwarePaginator
    {
        $query = Job::query();

        if (!empty($filters['name'])) {
            $query->where('title', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['salary_min'])) {
            $query->where('salary', '>=', $filters['salary_min']);
        }

        if (!empty($filters['salary_max'])) {
            $query->where('salary', '<=', $filters['salary_max']);
        }

        return $query
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 po strani
    }

    public function getJobsForCompany($companyId):Collection
    {
        return Job::where("company_id", $companyId)->get();
    }
}
