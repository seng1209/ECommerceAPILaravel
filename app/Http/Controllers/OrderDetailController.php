<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderDetialCollection;
use App\Http\Resources\OrderDetialResource;
use App\Models\OrderDetail;
use App\Http\Requests\StoreOrderDetailRequest;
use App\Http\Requests\UpdateOrderDetailRequest;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OrderDetialCollection(OrderDetail::all());
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
    public function store(StoreOrderDetailRequest $request)
    {
//        $orderDetail = new OrderDetail();
//        $orderDetail->order_id = $request->order_id;
//        $orderDetail->product_id = $request->product_id;
//        $orderDetail->quantity = $request->quantity;
//        $orderDetail->amount = $request->amount;
//        $orderDetail->save();
//        return response()->json(['message' => 'Order Detail was created.'], 201);

        $orderDetail = OrderDetail::create($request->all());

        return new OrderDetialResource( $orderDetail);

    }

    /**
     * Display the specified resource.
     */
    public function show($order_detail_id)
    {
        $orderDetail = OrderDetail::where('order_detail_id', $order_detail_id)->first();
        if ($orderDetail) {
            return new OrderDetialResource($orderDetail);
        }
        return response()->json(['message' => 'Order Detail was not found.'], 404);
    }

    /**
     *  Find by Order ID
     */
    public function findByOrderId($order_id){
        if ($orderDetails = OrderDetail::where('order_id', $order_id)->get()){
            return new OrderDetialCollection($orderDetails);
        }
        return response()->json(['message' => 'Order Detail was not found.'], 404);
    }

    /**
     * Get Total Amount
     */

    public function getTotalAmount($order_id){
        if ($totalAmount = OrderDetail::where('order_id', $order_id)->sum('amount')){
            return $totalAmount;
        }else{
            return response()->json(['message' => 'Order Detail was not found.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderDetailRequest $request, $order_detail_id)
    {
        $orderDetail = OrderDetail::where('order_detail_id', $order_detail_id)->first();
        if ($orderDetail) {
            $orderDetail->update($request->all());
            return new OrderDetialResource($orderDetail);
        }
        return response()->json(['message' => 'Order Detail was not updated.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($order_detail_id)
    {
        $orderDetail = OrderDetail::where('order_detail_id', $order_detail_id)->first();
        if ($orderDetail) {
            $orderDetail->delete();
            return response()->json(['message' => 'Order Detail was deleted.'], 202);
        }
        return response()->json(['message' => 'Order Detail was not found.'], 404);
    }
}
