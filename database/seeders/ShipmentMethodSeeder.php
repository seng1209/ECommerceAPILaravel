<?php

namespace Database\Seeders;

use App\Models\ShipmentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShipmentMethod::insert([
            ['image' => 'VET.png', 'name' => 'VET', 'price' => '3', 'description' => 'VET'],
            ['image' => 'JNT.png', 'name' => 'J&T Express', 'price' => '5', 'description' => 'J&T Express'],
            ['image' => 'AliExpress.png', 'name' => 'AliExpress', 'price' => '10', 'description' => 'AliExpress'],
        ]);
    }
}
