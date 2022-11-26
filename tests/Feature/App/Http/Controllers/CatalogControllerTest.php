<?php
namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CatalogController;
use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;

use Tests\TestCase;

class CatalogControllerTest extends TestCase
{
    public function test_page(): void
    {
        BrandFactory::new()->count(1)->create();

        $properties = PropertyFactory::new()->count(1)->create();

        OptionFactory::new()->count(1)->create();

        $optionValues = OptionValueFactory::new()->count(2)->create();

        $catalog = CategoryFactory::new()->count(2)
            ->has(
                Product::factory(2)
                    ->hasAttached($optionValues)
                    ->hasAttached($properties, function () {
                        return ['value' => ucfirst(fake()->word())];
                    })
            )
            ->create();

        $this->get(action([CatalogController::class, 'page'], null))
            ->assertOk()
            ->assertSee($catalog[0]->title)
            ->assertSee($catalog[1]->title)
        ;
    }
}
