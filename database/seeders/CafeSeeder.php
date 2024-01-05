<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Category;

class CafeSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Membuat kategori 'Cafe' jika belum ada
        $cafeCategory = Category::firstOrCreate(['name' => 'Cafe']);

        // Menambahkan data makanan
        foreach (range(1, 2) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'code' => $faker->unique()->ean8,
                'barcode' => $faker->ean13,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 1, 10),
                'cost' => $faker->randomFloat(2, 0.5, 5),
                'image' => 'path_to_espresso_image.jpg', // Gantilah dengan path gambar yang sesuai
                'stock' => $faker->numberBetween(1, 100),
                'category_id' => $cafeCategory->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Menambahkan data minuman
        foreach (range(1, 10) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'code' => $faker->unique()->ean8,
                'barcode' => $faker->ean13,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 1, 10),
                'cost' => $faker->randomFloat(2, 0.5, 5),
                'image' => 'path_to_cappuccino_image.jpg', // Gantilah dengan path gambar yang sesuai
                'stock' => $faker->numberBetween(1, 100),
                'category_id' => $cafeCategory->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
