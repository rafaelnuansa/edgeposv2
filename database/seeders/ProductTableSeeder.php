<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Using DB facade to insert data
        DB::table('products')->insert([
            'name' => 'Product A',
            'code' => 'P001',
            'barcode' => '123456789', // Optional, set to null if not needed
            'description' => 'Description for Product A',
            'price' => 19.99,
            'cost' => 10.00,
            'image' => 'path/to/product_a_image.jpg', // Set the actual image path
            'stock' => 100,
            'category_id' => 1, // You may change this to the appropriate category_id
            'branch_id' => 1, // You may change this to the appropriate branch_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add more products as needed
        DB::table('products')->insert([
            'name' => 'Product B',
            'code' => 'P002',
            'barcode' => '987654321', // Optional, set to null if not needed
            'description' => 'Description for Product B',
            'price' => 29.99,
            'cost' => 15.00,
            'image' => 'path/to/product_b_image.jpg', // Set the actual image path
            'stock' => 150,
            'category_id' => 2, // You may change this to the appropriate category_id
            'branch_id' => 2, // You may change this to the appropriate branch_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // You can continue adding more products as necessary
    }
}
