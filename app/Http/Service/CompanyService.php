<?php

namespace App\Http\Service;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyService
{
    public function addCompany(Request $request,$user_id){
        return Company::create([
            'name'=>$request['company_name'],
            'description'=>$request['description'],
            'address'=>$request['address'],
            'phone'=>$request['phone'],
            'user_id'=>$user_id,
        ]);
    }
}
