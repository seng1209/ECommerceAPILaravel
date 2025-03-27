<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new BrandCollection(Brand::all());
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
    public function store(StoreBrandRequest $request)
    {
//        Brand::created($request->all());
        $brand = new Brand();
        $brand->image = $request->image;
        $brand->brand = $request->brand;
        $brand->description = $request->description;
        $brand->save();
        return response()->json(['message' => 'Brand created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Brand::where('brand_id', $id)->exists()) {
            $band = Brand::find($id);
            if (!$band) {
                return response()->json(['message' => 'Brand not found'], 404);
            }else{
                return new BrandResource($band);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        if (Brand::where('brand_id', $id)->exists()) {
            $brand = Brand::find($id);
            $brand->image = is_null($request->image) ? $brand->image : $request->image;
            $brand->brand = is_null($request->brand) ? $brand->brand : $request->brand;
            $brand->description = is_null($request->description) ? $brand->description : $request->description;
            $brand->save();
            return response()->json(['message' => 'Brand updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Brand not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Brand::where('brand_id', $id)->exists()){
            if (Brand::find($id)->delete()){
                return response()->json(['message' => 'Brand deleted successfully'], 202);
            }else{
                return response()->json(['message' => 'Brand not found'], 404);
            }
        }
    }
}
