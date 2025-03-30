<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['role' => 'ADMIN', 'description' => 'Administrator role'],
            ['role' => 'USER', 'description' => 'Standard user role'],
            ['role' => 'CUSTOMER', 'description' => 'Customer role'],
        ]);

//        Role::factory()
//            ->role('USER')
//            ->description('User')
//            ->create();
//
//        Role::factory()
//            ->role('CUSTOMER')
//            ->description('Customer')
//            ->create();
//
//        Role::factory()
//            ->role('ADMIN')
//            ->description('Admin')
//            ->create();
//
//        Role::factory()
//            ->role('SUPER_ADMIN')
//            ->description('Super Admin')
//            ->create();
    }
}
