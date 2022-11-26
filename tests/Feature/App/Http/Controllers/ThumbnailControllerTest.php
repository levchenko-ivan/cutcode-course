<?php

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\ProductFactory;
use File;
use Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    public function test_thumbnail()
    {
        $size = '500x500';
        $method = 'resize';
        $storage = Storage::disk('images');

        config()->set('thumbnail', ['allowed_sizes' => [$size]]);

        $product = ProductFactory::new()->create();

        $response = $this->get($product->makeThumbnail($size, $method));

        $response->assertOk();

        $storage->assertExists(
            "products/$method/$size/". File::basename($product->thumbnail)
        );
    }
}
