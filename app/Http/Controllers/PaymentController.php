<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PaymentCollection(Payment::all());
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
    public function store(StorePaymentRequest $request)
    {
//        return new PaymentResource(Payment::create($request->all()));
        $payment = new Payment();
        $payment->payment_date = (new \DateTime())->format('Y-m-d H:i:s');
        $payment->payment_method_id = $request->payment_method_id;
        $payment->order_id = $request->order_id;
        $payment->amount = $request->amount;
        $payment->status = 'Completed';
        $payment->save();
        return new PaymentResource($payment);
    }

    /**
     * Display the specified resource.
     */
    public function show($payment_id)
    {
        $payment = Payment::where('payment_id', $payment_id)->first();
        if ($payment){
            return new PaymentResource($payment);
        }
        return response()->json(['message' => 'Payment was not found.'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, $payment_id)
    {
        if ($payment = Payment::where('payment_id', $payment_id)->first()){
            $payment->update($request->all());
            return new PaymentResource($payment);
        }
        return response()->json(['message' => 'Payment was not found.'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($payment_id)
    {
        if ($payment = Payment::where('payment_id', $payment_id)->first()){
            $payment->delete();
            return response()->json(['message' => 'Payment was deleted.'], 202);
        }
        return response()->json(['message' => 'Payment was not found.'], 404);
    }
}
