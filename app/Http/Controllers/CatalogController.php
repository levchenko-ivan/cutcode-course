<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function page(?Category $category): Factory|View|Application
    {
        $brands = Brand::query()
            ->select(['id', 'title'])
            ->has('products')
            ->get();

        $categories = Category::query()
            ->select(['id', 'title', 'slug'])
            ->has('products')
            ->get();

        $products = Product::query()
            ->select([
                'id',
                'title',
                'slug',
                'price',
                'thumbnail',
                'json_properties'
            ])
            ->search()
            ->withCategory($category);

        return view('catalog.catalog-page', compact('brands', 'categories', 'products', 'category'));
    }
}
