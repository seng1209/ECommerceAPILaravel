<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentFactory> */
    use HasFactory;

    protected $primaryKey = 'shipment_id';

    protected $fillable = ['shipment_method_id', 'user_id', 'order_id', 'city', 'street_address'];

    public function shipmentMethod()
    {
        return $this->belongsTo(ShipmentMethod::class, 'shipment_method_id', 'shipment_method_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
