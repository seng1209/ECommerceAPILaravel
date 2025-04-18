<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = ['user_id', 'total_amount'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function shipments()
    {
        return $this->belongsTo(Shipment::class, 'order_id', 'order_id');
    }

}
