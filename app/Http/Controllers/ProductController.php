<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCollection(Product::all());
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
    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->image = $request->image;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->save();
        return new ProductResource($product);
//        return response()->json(['message' => 'Product created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($product_id)
    {
        if (Product::where('product_id', $product_id)->exists()) {
            $product = Product::find($product_id);
            return new ProductResource($product);
        }else{
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $product_id)
    {
        if (Product::where('product_id', $product_id)->exists()) {
            $product = Product::find($product_id);
            $product->image = is_null($request->image) ? $product->image : $request->image;
            $product->product_name = is_null($request->product_name) ? $product->product_name : $request->product_name;
            $product->price = is_null($request->price) ? $product->price : $request->price;
            $product->brand_id = is_null($request->brand_id) ? $product->brand_id : $request->brand_id;
            $product->category_id = is_null($request->category_id) ? $product->category_id : $request->category_id;
            $product->description = is_null($request->description) ? $product->description : $request->description;
            $product->save();
            return new ProductResource($product);
//            return response()->json(['message' => 'Product updated successfully'], 200);
        }else{
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product_id)
    {
        if (Product::find($product_id)){
            $product = Product::find($product_id);
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 202);
        }else{
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
