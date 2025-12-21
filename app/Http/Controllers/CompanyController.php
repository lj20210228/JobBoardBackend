<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Http\Service\CompanyService;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
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

    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company=$this->companyService->getCompanyById($company->id);
        return response()->json(['company'=>new CompanyResource($company)]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {

        $companyUpdated=$this->companyService->updateCompany($request->toArray(),$company);
        return response()->json(['company'=>new CompanyResource($companyUpdated),'message'=>'Company updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $this->companyService->deleteCompany($company);
        return response()->json(['message'=>'Company deleted successfully.']);
    }

    public function searchCompany(Request $request){
        $name = $request->input('name');

        $companies = $this->companyService->getCompaniesByName($name);

        return response()->json([
            'companies' => CompanyResource::collection($companies)
        ]);
    }
}
