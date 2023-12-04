<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use Illuminate\Http\Request;
use App\Http\Resources\MedicineResource;
use App\Models\Category;


//I found the use of category controller in organizing the routes and work generally
class CategoryController extends Controller
{

    //show function used to display the medicines under certain category in browse page
    public function show(Category $category)
    {
        $medicines = $category->medicines()->get();
        $message = [
            'message' => 'medicines listed successfully under a category!'
        ];
        return MedicineResource::collection($medicines)->additional($message)->response()->setStatusCode(200);
    }

    //used by the storeMan to create a category
    public function store()
    {
        Category::create([
            'name' => request()->get('name'),
            'ar_name' => request()->get('ar_name')
        ]);
        return response()->json([
            'message' => 'category created successfully!'
        ], 201);
    }

    //used by storeMan to delete a category and all the medicines under it, may not be used by the front-end developer
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'category deleted successfully'
        ], 200);
    }

    //this function return to the home page all the categories with the top 5 medicines in each category
    public function list()
    {
        $categories = Category::latest()->get();
        $message = ['message' => 'categories listed successfully!'];
        return (new CategoryCollection($categories))->additional($message)->response()->setStatusCode(200);
    }

    public function update(Category $category)
    {
        $updated = [
            'name' => request()->get('name'),
            'ar_name' => request()->get('ar_name')
        ];
        $category->update($updated);

        return response()->json(['message' => 'updated the category successfully!'], 200);
    }
}
