<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if(!app()->isProduction()) {
            if(empty($_COOKIE['XDEBUG_SESSION'])) {
                setcookie('XDEBUG_SESSION', 'start');
            }
        }

        Model::shouldBeStrict(!app()->isProduction());

//        if(app()->isProduction()) {
//            return;
//        }

        DB::listen(function ($query) {
            if($query->time > 100) {
                logger()
                    ->channel('telegram')
                    ->debug('LongQuery: '. $query->sql, $query->bindings);
            }
        });

        app(Kernel::class)->whenRequestLifecycleIsLongerThan(
            CarbonInterval::second(5),
            function () {
                logger()
                    ->channel('telegram')
                    ->debug('whenQueryingForLongerThan: '. request()->url());
            }
        );
    }
}
