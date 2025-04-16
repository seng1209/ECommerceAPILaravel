<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = ['image', 'image_name', 'category', 'description'];

    protected function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
