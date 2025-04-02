<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::insert([
            ['payment_method_id' => 1, 'order_id' => 1, 'amount' => 1005, 'status' => 'Completed'],
            ['payment_method_id' => 2, 'order_id' => 2, 'amount' => 305, 'status' => 'Completed'],
        ]);
    }
}
