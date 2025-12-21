<?php

namespace App\Http\Service;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
    public function updateCompany(array $data,Company $company):?Company{
        $company->update($data);
        return $company;
    }

    public function deleteCompany(Company $company):bool{
        return $company->delete();
    }
    public function getCompanyById($id): ?Company{
        return Company::where("id",$id)->first();
    }
    public function getCompaniesByName(?string $name): Collection{
        return Company::when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->orderBy('name')
            ->get();
    }


}
