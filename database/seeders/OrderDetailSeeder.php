<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderDetailSeeder::insert([
            ['order_id' => 1, 'product_id' => 1, 'quantity' => 5, 'amount' => 125],
            ['order_id' => 1, 'product_id' => 2, 'quantity' => 2, 'amount' => 45],
            ['order_id' => 1, 'product_id' => 3, 'quantity' => 1, 'amount' => 40],
            ['order_id' => 1, 'product_id' => 4, 'quantity' => 1, 'amount' => 500],
            ['order_id' => 2, 'product_id' => 1, 'quantity' => 1, 'amount' => 32],
            ['order_id' => 2, 'product_id' => 2, 'quantity' => 1, 'amount' => 10],
            ['order_id' => 2, 'product_id' => 3, 'quantity' => 1, 'amount' => 120],
            ['order_id' => 2, 'product_id' => 5, 'quantity' => 1, 'amount' => 40],
        ]);
    }
}
