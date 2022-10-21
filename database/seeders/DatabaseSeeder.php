<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Brand::factory(20)->create();

        Category::factory(20)
            ->has(Product::factory(rand(1, 3)))
            ->create();
    }
}
