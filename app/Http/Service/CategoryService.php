<?php

namespace App\Http\Service;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function create(array $data){
        return Category::create([
            'name' => $data['name']
        ]);
    }
    public function update(Category $category, $data):Category{
        $category->update($data);
        return $category;
    }
    public function delete(Category $category):bool{
        return $category->delete();
    }
    public function getCategories():LengthAwarePaginator{
        return Category::orderBy('id', 'desc')->paginate(10);
    }
    public function getCategoryById($id):?Category{
        return Category::where("id",$id)->first();
    }
    public function searchCategory($name):LengthAwarePaginator{
        return Category::where("name","like","%$name%")
            ->orderBy("name")
            ->paginate(5);
    }
}
