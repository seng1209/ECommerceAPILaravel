<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::insert([
            ['image' => 'visa.png', 'name' => 'Visa', 'price' => '1', 'description' => 'Visa Card'],
            ['image' => 'mastercard.png', 'name' => 'MasterCard', 'price' => '1', 'description' => 'MasterCard Card'],
            ['image' => 'paypal.png', 'name' => 'PayPal', 'price' => '1', 'description' => 'PayPal Card'],
            ['image' => 'aba.png', 'name' => 'ABA', 'price' => '1', 'description' => 'ABA Card'],
        ]);
    }
}
