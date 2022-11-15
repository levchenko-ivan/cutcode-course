<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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
            ->select(['id', 'title', 'slug', 'price', 'thumbnail'])
            ->paginate(6);

        return view('catalog.catalog-page', compact('brands', 'categories', 'products', 'category'));
    }
}
