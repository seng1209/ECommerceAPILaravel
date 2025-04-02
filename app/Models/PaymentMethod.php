<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentMethodFactory> */
    use HasFactory;

    protected $primaryKey = 'payment_method_id';

    protected $fillable = ['image', 'name', 'price', 'description'];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_method_id', 'payment_method_id');
    }

}
