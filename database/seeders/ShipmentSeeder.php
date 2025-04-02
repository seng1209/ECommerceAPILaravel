<?php

namespace Database\Seeders;

use App\Models\Shipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipment::insert([
            ['shipment_method_id' => 1, 'user_id' => 1, 'order_id' => 1, 'city' => 'Phnom Penh', 'street_address' => '2004']
        ]);
    }
}
