<?php

namespace App\Http\Controllers;

use App\View\CatalogViewModel;
use Domain\Catalog\Models\Category;

class CatalogController extends Controller
{
    public function page(?Category $category): CatalogViewModel
    {
        return (new CatalogViewModel($category))->view('catalog.catalog-page');
    }
}
