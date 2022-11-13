<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BrandFactory::new()->count(20)->create();

        CategoryFactory::new()->count(20)
            ->has(Product::factory(rand(1, 3)))
            ->create();
    }
}
