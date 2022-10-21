<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
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

        DB::whenQueryingForLongerThan(CarbonInterval::second(5), function (Connection $connection) {
            logger()
                ->channel('telegram')
                ->debug('whenQueryingForLongerThan: '. $connection->totalQueryDuration());
        });

        DB::listen(function ($query) {
            if($query->time > 100) {
                logger()
                    ->channel('telegram')
                    ->debug('LongQuery: '. $query->sql, $query->bindings);
            }
        });

        $kernel = app(Kernel::class);
        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::second(5),
            function () {
                logger()
                    ->channel('telegram')
                    ->debug('whenQueryingForLongerThan: '. request()->url());
            }
        );
    }
}
