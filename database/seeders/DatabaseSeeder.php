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
            'image' => 'https://i.pinimg.com/474x/6c/9e/6b/6c9e6bc37699c8d103bd17bff803cfa4.jpg',
            'image_name' => '6c9e6bc37699c8d103bd17bff803cfa4.jpg',
            'username' => 'developer1',
            'password' => bcrypt('developer1'),
            'email' => 'bunthav@gmail.com',
            'phone' => '09483742',
            'address' => 'Phnom Penh',
        ],
        [
            'image' => "https://static.wikia.nocookie.net/narutofanon/images/4/4f/Hashirama_Senju_%28Edo_Tensei%29.png/revision/latest?cb=20240304051346",
            'image_name' => "cb=20240304051346",
            "username" => "developer2",
            'password' => bcrypt('developer2'),
            'email' => 'hongpink@gmail.com',
            'phone' => '09083742',
            'address' => 'Phnom Penh',
        ]
        );
        UserRole::insert([
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 1, 'role_id' => 2],
            ['user_id' => 1, 'role_id' => 3],
//            ['user_id' => 2, 'role_id' => 1],
//            ['user_id' => 2, 'role_id' => 2],
//            ['user_id' => 2, 'role_id' => 3],
        ]);
//        Brand::factory()->count(3)->create();
//        Category::factory()->count(3)->create();
//        Product::factory()->count(5)->hasBrand(3)->hasCategory(3)->create();
//        ShipmentMethod::factory()->count(3)->create();
//        PaymentMethod::factory()->count(1)->create();
    }
}
