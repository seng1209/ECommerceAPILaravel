<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Role;
use App\Models\ShipmentMethod;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            ['role' => 'ADMIN', 'description' => 'Administrator role'],
            ['role' => 'USER', 'description' => 'Standard user role'],
            ['role' => 'CUSTOMER', 'description' => 'Customer role'],
        ]);
        Brand::factory()->count(3)->create();
        Category::factory()->count(3)->create();
        Product::factory()->count(5)->hasBrand(3)->hasCategory(3)->create();
        ShipmentMethod::factory()->count(3)->create();
        PaymentMethod::factory()->count(1)->create();
    }
}
