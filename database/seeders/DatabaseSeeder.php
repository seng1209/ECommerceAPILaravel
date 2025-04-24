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
use App\Models\UserRole;
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
        User::insert([
            'image' => 'https://4kwallpapers.com/images/wallpapers/madara-uchiha-2560x1440-14899.jpg',
            'image_name' => 'madara-uchiha-2560x1440-14899.jpg',
            'username' => 'bunthav11',
            'password' => bcrypt('bunthav11'),
            'email' => 'bunthav@gmail.com',
            'phone' => '09483742',
            'address' => 'Phnom Penh',
        ]);
        UserRole::insert([
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 1, 'role_id' => 2],
        ]);
//        Brand::factory()->count(3)->create();
//        Category::factory()->count(3)->create();
//        Product::factory()->count(5)->hasBrand(3)->hasCategory(3)->create();
//        ShipmentMethod::factory()->count(3)->create();
//        PaymentMethod::factory()->count(1)->create();
    }
}
