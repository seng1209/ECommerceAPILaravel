<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    /** @use HasFactory<\Database\Factories\OrderDetailFactory> */
    use HasFactory;

    protected $table = 'order_details';

    protected $primaryKey = 'order_detail_id';

    protected $fillable = ['order_id', 'product_id', 'quantity', 'amount'];
}
