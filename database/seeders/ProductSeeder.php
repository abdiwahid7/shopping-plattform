<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Smartphone',
                'description' => 'Latest model smartphone with advanced features.',
                'price' => 699.99,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop',
                'description' => 'High performance laptop for gaming and work.',
                'price' => 1299.99,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Headphones',
                'description' => 'Noise-cancelling over-ear headphones.',
                'price' => 199.99,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smartwatch',
                'description' => 'Stylish smartwatch with health tracking features.',
                'price' => 249.99,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tablet',
                'description' => 'Portable tablet with a large display.',
                'price' => 499.99,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}