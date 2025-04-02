<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentMethodCollection;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PaymentMethodCollection(PaymentMethod::all());
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
    public function store(StorePaymentMethodRequest $request)
    {
        if (PaymentMethod::where('name', $request->name)->first()){
            return response()->json(['message' => 'Payment Method already exists.'], 400);
        }

        $paymentMethod = PaymentMethod::create($request->all());

        return new PaymentMethodResource($paymentMethod);
    }

    /**
     * Display the specified resource.
     */
    public function show($name)
    {
        $paymentMethod = PaymentMethod::where('name', $name)->first();
        if ($paymentMethod){
            return new PaymentMethodResource($paymentMethod);
        }

        return response()->json(['message' => 'Payment Method was not found.'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, $name)
    {
        $paymentMethod = PaymentMethod::where('name', $name)->first();
        if ($paymentMethod){
//            $paymentMethod->update($request->all());
            $paymentMethod->image = is_null($request->image) ? $paymentMethod->image : $request->image;
            $paymentMethod->name = is_null($request->name) ? $paymentMethod->name : $request->name;
            $paymentMethod->price = is_null($request->price) ? $paymentMethod->price : $request->price;
            $paymentMethod->description = is_null($request->description) ? $paymentMethod->description : $request->description;
            $paymentMethod->save();
            return new PaymentMethodResource($paymentMethod);
//            return response()->json(['message' => 'Payment Method was updated.'], 200);
        }

        return response()->json(['message' => 'Payment Method was not updated.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($name)
    {
        $paymentMethod = PaymentMethod::where('name', $name)->first();
        if ($paymentMethod){
            $paymentMethod->delete();
            return response()->json(['message' => 'Payment Method was deleted.'], 202);
        }

        return response()->json(['message' => 'Payment Method was not found.'], 404);
    }
}
