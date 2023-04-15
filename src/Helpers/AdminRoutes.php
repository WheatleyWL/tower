<?php

namespace zedsh\tower\Helpers;

use Illuminate\Support\Facades\Route;


class AdminRoutes
{
    public static $app_routes = array();
    public static $authRoutesIsPublished = false;


    public static function make(array $options = [], string $prefix, string $name_prefix)
    {
        if (!self::checkExistAuthRoutesInApp()) {
            Route::prefix($prefix)->name($name_prefix . '.')->middleware(['web'])->group(function () use ($options) {
                if ($options['login'] ?? true) {
                    Route::get('login',
                        [\zedsh\tower\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
                    Route::post('login', [\zedsh\tower\Controllers\Auth\LoginController::class, 'login']);
                }
                if ($options['registration'] ?? true) {
                    Route::get('registration', [
                        \zedsh\tower\Controllers\Auth\RegisterController::class,
                        'showRegistrationForm'
                    ])->name('registration');
                    Route::post('registration', [\zedsh\tower\Controllers\Auth\RegisterController::class, 'register']);
                }
                if ($options['logout'] ?? true) {
                    Route::post('logout',
                        [\zedsh\tower\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
                }
                if ($options['file'] ?? true) {
                    Route::resource('file', \zedsh\tower\Controllers\FilesController::class);
                }
            });
        }

        return;
    }

    public static function checkExistAuthRoutesInApp()
    {
        foreach (Route::getRoutes() as $route) {
            self::$app_routes[] = $route->uri;
        }

        if (in_array('admin/login', self::$app_routes) &&
            in_array('admin/registration', self::$app_routes) &&
            in_array('admin/logout', self::$app_routes)) {
            self::$authRoutesIsPublished = true;
        }

        return self::$authRoutesIsPublished;
    }
}



