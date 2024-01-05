<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //permission dashboard
        Permission::create(['name' => 'dashboard', 'guard_name' => 'web']);
        //permission users
        Permission::create(['name' => 'users', 'guard_name' => 'web']);
        //permission roles
        Permission::create(['name' => 'roles', 'guard_name' => 'web']);
        //permission permissions
        Permission::create(['name' => 'permissions', 'guard_name' => 'web']);


        //permission categories
        Permission::create(['name' => 'categories', 'guard_name' => 'web']);

        //permission products
        Permission::create(['name' => 'products', 'guard_name' => 'web']);

        //permission customers
        Permission::create(['name' => 'customers', 'guard_name' => 'web']);

        //permission transactions
        Permission::create(['name' => 'transactions', 'guard_name' => 'web']);

        //permissions sales
        Permission::create(['name' => 'reports', 'guard_name' => 'web']);

        //permissions profites
        Permission::create(['name' => 'profits', 'guard_name' => 'web']);
    }
}
