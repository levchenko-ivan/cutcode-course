<?php

namespace App\Fakers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\File;
use Storage;

class ImageFaker extends Base
{
    private string $fakeImagePath = 'tests/Fixtures/images/';

    private string $storageIamgePath = 'app/public/images/';

    private bool $isValidateDir = false;

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
        if($this->isValidateDir) {
            return;
        }
        $this->isValidateDir = true;

        $isCreateMainDir = false;
        $isCreateSubDir = false;

        if(!Storage::directoryExists('images')) {
            Storage::makeDirectory('images');
            $isCreateMainDir = true;
        }

        if(!Storage::directoryExists('images/'.$path)) {
            Storage::makeDirectory('images/'.$path);
            $isCreateSubDir = true;
        }

        if(!($isCreateMainDir || $isCreateSubDir)) {
            File::cleanDirectory(Storage::path('images/'.$path));
        }
    }

}
