<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use DateTime;
use Illuminate\Support\Facades\Date;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OrderCollection(Order::all());
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
    public function store(StoreOrderRequest $request)
    {

        $order = new Order();
        $order->order_date = (new DateTime())->format('Y-m-d H:i:s');
        $order->user_id = $request->user_id;
        $order->total_amount = $request->total_amount;
        $order->save();
        return new OrderResource($order);

//        return new OrderResource(Order::create([
//            'order_date' => (new DateTime())->format('Y-m-d H:i:s'),
//            'user_id' => $request->user_id,
//            'total_amount' => $request->total_amount,
//        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        if ($order){
            return new OrderResource($order);
        }
        return response()->json(['message' => 'Order was not found.'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        if ($order){
//            $order->update($request->all());
            $order->user_id = is_null($request->user_id) ? $order->user_id : $request->user_id;
            $order->total_amount = is_null($request->total_amount) ? $order->total_amount : $request->total_amount;
            $order->save();
            return new OrderResource($order);
        }
        return response()->json(['message' => 'Order was not updated.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        if ($order){
            $order->delete();
            return response()->json(['message' => 'Order was deleted.'], 202);
        }
        return response()->json(['message' => 'Order was not found.'], 404);
    }
}
