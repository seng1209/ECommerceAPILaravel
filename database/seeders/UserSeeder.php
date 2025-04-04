<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        User::insert([
//            ['image' => 'userimage.png', 'username' => 'user1', 'password' => bcrypt('12345678'), 'email' => 'user1@gmail.com', 'phone' => '0912345678', 'address' => 'Phnom Penh'],
//            ['image' => 'userimage.png', 'username' => 'user2', 'password' => bcrypt('12345678'), 'email' => 'user2@gmail.com', 'phone' => '1912345678', 'address' => 'Phnom Penh']
//        ]);

        DB::table('users')->insert([
            'image' => 'path/to/image.jpg',
            'username' => 'user1',
            'password' => bcrypt('12345678'), // Ensure you hash passwords
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'is_verified' => false,
            'address' => '123 Test St',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
