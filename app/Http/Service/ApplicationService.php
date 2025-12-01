<?php

namespace App\Http\Service;

use App\Models\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApplicationService
{

    public function addAplications(array $request):Application{
        return Application::create([
            'job_id' => $request['job_id'],
            'user_id' => $request['user_id'],
            'status' => $request['status']??"pending",
            'linkedinUrl'=> $request['linkedinUrl']??null,
            'resume_url'=> $request['resume_url'],
        ]);
    }
    public function updateAplication(Application $application,array $request):Application{
        $application->update($request);
        return $application;
    }
    public function deleteAplication(Application $application):bool{
        return $application->delete();
    }
    public function getAllAplicationsForJob($jobId):LengthAwarePaginator{
        return Application::where('job_id', $jobId)->
            paginate(10);
    }
    public function getAllAplicationsForUser($userId):LengthAwarePaginator{
        return Application::where('user_id', $userId)->
        paginate(10);
    }

}
