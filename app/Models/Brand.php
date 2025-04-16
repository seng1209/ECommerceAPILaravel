<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;

    protected $primaryKey = 'brand_id';

    protected $fillable = ['image', 'image_name', 'brand', 'description'];

    protected function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

}
