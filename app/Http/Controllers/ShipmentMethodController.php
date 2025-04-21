<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShipmentMethodCollection;
use App\Http\Resources\ShipmentMethodResource;
use App\Models\ShipmentMethod;
use App\Http\Requests\StoreShipmentMethodRequest;
use App\Http\Requests\UpdateShipmentMethodRequest;

class ShipmentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ShipmentMethodCollection(ShipmentMethod::all());
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
    public function store(StoreShipmentMethodRequest $request)
    {
        $shipment_method = ShipmentMethod::where('name', $request->name)->first();

        if ($shipment_method){
            return response()->json(['message' => 'Shipment Method already exists.'], 400);
        }

        $shipment_method = ShipmentMethod::create($request->all());

        return new ShipmentMethodResource($shipment_method);

//        return response()->json(['message' => 'Shipment Method was created.'], 201);
    }

    /**
     * get by id
     */
    public function getById($shipmentMethodId)
    {
        if ($shipmentMethod = ShipmentMethod::where('shipment_method_id', $shipmentMethodId)->first()){
            return new ShipmentMethodResource($shipmentMethod);
        }
        return response()->json(['message' => 'Shipment Method was not found.'], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show($name)
    {
        $shipmentMethod = ShipmentMethod::where('name', $name)->first();
        if ($shipmentMethod){
            return new ShipmentMethodResource($shipmentMethod);
        }
        return response()->json(['message' => 'Shipment Method was not found.'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShipmentMethod $shipmentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentMethodRequest $request, $name)
    {
        $shipmentMethod = ShipmentMethod::where('name', $name)->first();
        if ($shipmentMethod){
            $shipmentMethod->update($request->all());
//            $shipmentMethod->image = is_null($request->image) ? $shipmentMethod->image : $request->image;
//            $shipmentMethod->name = is_null($request->name) ? $shipmentMethod->name : $request->name;
//            $shipmentMethod->price = is_null($request->price) ? $shipmentMethod->price : $request->price;
//            $shipmentMethod->save();
            return response()->json(['message' => 'Shipment Method was updated.'], 200);
        }
        return response()->json(['message' => 'Shipment Method was not updated.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($name)
    {
        $shipmentMethod = ShipmentMethod::where('name', $name)->first();
        if ($shipmentMethod){
            $shipmentMethod->delete();
            return response()->json(['message' => 'Shipment Method was deleted.'], 202);
        }
        return response()->json(['message' => 'Shipment Method was not found.'], 404);
    }
}
