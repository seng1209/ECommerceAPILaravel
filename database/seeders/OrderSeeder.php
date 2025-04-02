<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::insert([
            ['user_id' => 1, 'total_amount' => 1000,],
            ['user_id' => 2, 'total_amount' => 300,],
        ]);
    }
}
