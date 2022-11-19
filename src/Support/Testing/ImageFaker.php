<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Storage;

class ImageFaker extends Base
{
    private string $fakeImagePath = 'tests/Fixtures/images/';

    public function copyImages(string $path): string
    {
        $storage = Storage::disk('images');

        if(!$storage->exists($path)) {
            $storage->makeDirectory($path);
        }

        return '/storage/images/'.$path.'/'.$this->generator->file(
            base_path($this->fakeImagePath.$path),
            $storage->path($path),
            false
        );
    }
}
