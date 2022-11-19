<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Brand;
use Support\Traits\Makeable;

class BrandViewModel
{
    use Makeable;

    public function homePage()
    {
        return \Cache::rememberForever('brand_home_page', function () {
            return Brand::query()
                ->homePage()
                ->get();
        });
    }
}
