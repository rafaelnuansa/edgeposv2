<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Using DB facade to insert data
        DB::table('categories')->insert([
            'name' => 'Category A',
            'branch_id' => 1, // You may change this to the appropriate branch_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add more categories as needed
        DB::table('categories')->insert([
            'name' => 'Category B',
            'branch_id' => 2, // You may change this to the appropriate branch_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // You can continue adding more categories as necessary
    }
}
