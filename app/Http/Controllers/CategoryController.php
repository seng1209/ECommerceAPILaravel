<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoryCollection(Category::all());
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
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->image = $request->image;
        $category->category = $request->category;
        $category->description = $request->description;
        $category->save();
        return response()->json(['message' => 'Category created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($category_id)
    {
        if (Category::where('category_id', $category_id)->exists()) {
            $category = Category::find($category_id);
            return new CategoryResource($category);
        }else{
            return response()->json(['message' => 'Category not found'], 404);
        }
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
    public function update(UpdateCategoryRequest $request, $category_id)
    {
        if (Category::where('category_id', $category_id)->exists()) {
            $category = Category::find($category_id);
            $category->image = is_null($request->image) ? $category->image : $request->image;
            $category->category = is_null($request->category) ? $category->category : $request->category;
            $category->description = is_null($request->description) ? $category->description : $request->description;
            $category->save();
            return response()->json(['message' => 'Category updated successfully'], 200);
        }else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category_id)
    {
        if (Category::where('category_id', $category_id)->exists()){
            if (Category::find($category_id)->delete()){
                return response()->json(['message' => 'Category deleted successfully'], 202);
            }else{
                return response()->json(['message' => 'Category not found'], 404);
            }
        }
    }
}
