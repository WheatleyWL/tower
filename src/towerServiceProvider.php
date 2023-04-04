<?php

namespace zedsh\tower;

use Illuminate\Support\ServiceProvider;
use zedsh\tower\Commands\towerCreateController;
use zedsh\tower\Commands\towerInstall;

class towerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/tower'),
            ], 'views');

            $this->publishes([
                __DIR__ . '/../assets/admin_assets' => public_path('admin_assets'),
            ], 'public');

            $this->commands([
                towerInstall::class,
                towerCreateController::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tower');
//        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
//        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register()
    {
    }

    public function provides()
    {
        return [
            towerInstall::class,
            towerCreateController::class,
        ];
    }
}
