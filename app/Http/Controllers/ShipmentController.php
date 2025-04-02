<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShipmentCollection;
use App\Http\Resources\ShipmentResource;
use App\Models\Shipment;
use App\Http\Requests\StoreShipmentRequest;
use App\Http\Requests\UpdateShipmentRequest;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new  ShipmentCollection(Shipment::all());
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
    public function store(StoreShipmentRequest $request)
    {
        $shipment = new Shipment();
        $shipment->shipment_date = (new \DateTime())->format('Y-m-d H:i:s');
        $shipment->shipment_method_id = $request->shipment_method_id;
        $shipment->user_id = $request->user_id;
        $shipment->order_id = $request->order_id;
        $shipment->city = $request->city;
        $shipment->street_address = $request->street_address;
        $shipment->save();
        return new ShipmentResource($shipment);
    }

    /**
     * Display the specified resource.
     */
    public function show($shipment_id)
    {
        if ($shipment = Shipment::where('shipment_id', $shipment_id)->first()){
            return new ShipmentResource($shipment);
        }
        return response()->json(['message' => 'Shipment was not found.'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequest $request, $shipment_id)
    {
        if ($shipment = Shipment::where('shipment_id', $shipment_id)->first()){
            $shipment->update($request->all());
            return new ShipmentResource($shipment);
        }
        return response()->json(['message' => 'Shipment was not found.'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($shipment_id)
    {
        if ($shipment = Shipment::where('shipment_id', $shipment_id)->delete()){
            return response()->json(['message' => 'Shipment was deleted.'], 202);
        }
        return response()->json(['message' => 'Shipment was not found.'], 404);
    }
}
