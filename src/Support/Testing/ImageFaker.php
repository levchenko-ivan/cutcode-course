<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Storage;

class ImageFaker extends Base
{
    private string $fakeImagePath = 'tests/Fixtures/images/';

    private string $storageIamgePath = 'app/public/images/';

    public function copyImages(string $path): string
    {
        $this->createDirectories($path);

        return '/storage/images/'.$path.'/'.$this->generator->file(
            base_path($this->fakeImagePath.$path),
            storage_path($this->storageIamgePath.$path),
            false
        );
    }

    private function createDirectories(string $path): void
    {
        if(!Storage::directoryExists('images/'.$path)) {
            Storage::makeDirectory('images/'.$path);
        }
    }

}