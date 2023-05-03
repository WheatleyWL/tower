<?php

namespace zedsh\tower\Helpers;

use Closure;
use Illuminate\Support\Facades\Route;
use zedsh\tower\Http\Controllers\Auth\LoginController;
use zedsh\tower\Http\Controllers\Auth\RegisterController;
use zedsh\tower\Http\Controllers\FilesController;
use zedsh\tower\Http\Controllers\HomeController;
use zedsh\tower\Exceptions\ConfigurationException;
use zedsh\tower\Exceptions\TowerInternalException;

/**
 * AdminRoutesBuilder class.
 * Provides convenient facade to initialize Tower Admin routes.
 */
class AdminRoutesBuilder
{
    protected const ROUTE_LOGIN = 'login';
    protected const ROUTE_REGISTER = 'register';
    protected const ROUTE_LOGOUT = 'logout';
    protected const ROUTE_FILE = 'file';

    protected static bool $towerRoutesInstalled = false;

    protected array $requiredRoutes = [];
    protected string $routePrefix = 'admin';
    protected ?Closure $appRouteSpawner = null;

    /**
     * @return static
     * @throws ConfigurationException
     */
    public static function make(): self
    {
        if(self::$towerRoutesInstalled) {
            throw new ConfigurationException('Tower admin routes were already installed.');
        }

        return new self();
    }

    /**
     * Sets default parameters for the route builder to initialize with.
     * Strongly recommended using this unless you know what you're doing.
     * @return $this
     */
    public function default(): self
    {
        $this->needLogin()
            ->needRegister()
            ->needLogout()
            ->needFiles();

        return $this;
    }

    /**
     * Declares that routes for package-provided login form should be installed.
     * @return $this
     */
    public function needLogin(): self
    {
        $this->requiredRoutes[] = self::ROUTE_LOGIN;
        return $this;
    }

    /**
     * Declares that routes for package-provided registration from should be installed.
     * @return $this
     */
    public function needRegister(): self
    {
        $this->requiredRoutes[] = self::ROUTE_REGISTER;
        return $this;
    }

    /**
     * Declares that routes for package-provided logout should be installed.
     * @return $this
     */
    public function needLogout(): self
    {
        $this->requiredRoutes[] = self::ROUTE_LOGOUT;
        return $this;
    }

    /**
     * Declares that routes for file operations should be defined.
     * If omitted, admin panel looses ability to work with file fields.
     * @return $this
     */
    public function needFiles(): self
    {
        $this->requiredRoutes[] = self::ROUTE_FILE;
        return $this;
    }

    /**
     * Overrides default prefix used for all administrative routes.
     * Default prefix is 'admin'.
     * @param string $prefix
     * @return $this
     */
    public function setRoutePrefix(string $prefix): self
    {
        $this->routePrefix = $prefix;
        return $this;
    }

    /**
     * @param callable $spawner
     * @return $this
     */
    public function defineAppRoutes(callable $spawner): self
    {
        $this->appRouteSpawner = Closure::fromCallable($spawner);
        return $this;
    }

    /**
     * Install required routes.
     */
    public function install(): void
    {
        Route::prefix($this->routePrefix)
            ->middleware(['web'])
            ->group(function () {
                Route::group(['as' => 'tower_admin::'], function() {
                    foreach($this->requiredRoutes as $routeName) {
                        $this->installRoute($routeName);
                    }
                });

                $this->appRouteSpawner?->call($this);

                Route::get('/', [HomeController::class, 'index'])->name('home');
            });

        self::$towerRoutesInstalled = true;
    }

    /**
     * @param string $routeName
     * @throws TowerInternalException
     */
    protected function installRoute(string $routeName): void
    {
        switch($routeName) {
            case self::ROUTE_LOGIN:
                Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
                Route::post('login', [LoginController::class, 'login']);
                break;

            case self::ROUTE_REGISTER:
                Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
                Route::post('register', [RegisterController::class, 'register']);
                break;

            case self::ROUTE_LOGOUT:
                Route::post('logout', [LoginController::class, 'logout'])->name('logout');
                break;

            case self::ROUTE_FILE:
                Route::resource('file', FilesController::class)->only(['store', 'update', 'destroy']);
                break;

            default:
                throw new TowerInternalException("Unable to install unknown route '$routeName'.");
        }
    }
}
