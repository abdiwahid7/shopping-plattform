<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Fashion'],
            ['name' => 'Home Appliances'],
            ['name' => 'Books'],
            ['name' => 'Sports'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}