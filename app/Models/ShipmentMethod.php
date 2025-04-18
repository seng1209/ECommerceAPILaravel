<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentMethod extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentMethodFactory> */
    use HasFactory;

    protected $primaryKey = 'shipment_method_id';

    protected $fillable = ['image', 'image_name', 'name', 'price', 'description'];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_method_id', 'shipment_method_id');
    }
}
