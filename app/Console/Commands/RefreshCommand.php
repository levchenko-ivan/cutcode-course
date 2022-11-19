<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Storage;

class RefreshCommand extends Command
{
    protected $signature = 'shop:refresh';

    protected $description = 'Command description';

    public function handle(): int
    {
        if(app()->isProduction()) {
            return self::FAILURE;
        }

        $this->call('cache:clear');

        $cleanDirectories = [
            'images/brands',
            'images/products'
        ];

        foreach ($cleanDirectories as $cleanDirectory) {
            if(Storage::directoryExists($cleanDirectory)) {
               File::cleanDirectory(Storage::path($cleanDirectory));
            }
        }

        $this->call('migrate:fresh', [
            '--seed' => true
        ]);

        return self::SUCCESS;
    }
}
