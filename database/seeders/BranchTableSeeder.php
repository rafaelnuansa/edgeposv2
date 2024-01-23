<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Using DB facade to insert data
        DB::table('branches')->insert([
            'name' => 'Branch A',
            'type' => 'Main',
            'address' => '123 Main Street',
            'user_id' => 1, // You may change this to the appropriate user_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add more branches as needed
        DB::table('branches')->insert([
            'name' => 'Branch B',
            'type' => 'Secondary',
            'address' => '456 Second Street',
            'user_id' => 1, // You may change this to the appropriate user_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // You can continue adding more branches as necessary
    }
}
