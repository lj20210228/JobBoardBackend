<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Service\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Pest\Laravel\json;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getCategories();
        return response()->json(['categories'=>CategoryResource::collection($categories)],200);
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
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:category',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $category = $this->categoryService->create($request->toArray());
        return response()->json(['category'=>new CategoryResource($category),'message'=>"Category added successfully"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $categoryId=$category->id;
        $categoryFounded=$this->categoryService->getCategoryById($categoryId);
        return response()->json(['category'=>new CategoryResource($categoryFounded)],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $categoryUpdate=$this->categoryService->update($category,$request);
        return response()->json(['category'=>new CategoryResource($categoryUpdate)],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
         $this->categoryService->delete($category);
         return response()->json(['message'=>"Category successfully deleted"],200);
    }
    public function searchCategory(Request $request){
        $name=$request->get('name');
        $categories=$this->categoryService->searchCategory($name);
        return response()->json(['categories'=>CategoryResource::collection($categories)],200);

    }
}
