<?php

namespace App\Auth\Providers;

use App\Auth\Libraries\ApiAuth;
use App\Auth\Middleware\Authenticate;
use App\Auth\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('auth.token', Authenticate::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);
        $router->aliasMiddleware('role', RoleMiddleware::class);
        $this->registerConfig('Auth');
        $this->mapRoutes('Auth');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('apiauth', function () {
            return new ApiAuth($this->app['request'], new UserRepository($this->app));
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig(string $systemName)
    {
        $lower = strtolower($systemName);
        $configFile = __DIR__.'/../Config/config.php';

        $this->publishes([$configFile => config_path($lower.'.php')], 'config');
        $this->mergeConfigFrom($configFile, $lower);
    }

    /**
     * Define the routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRoutes(string $systemName)
    {
        $systemName = ucwords($systemName);
        $lower = strtolower($systemName);

        $middleware = ['api'];

        if (app()->environment('production')) {
            $middleware[] = 'auth.token';
        }

        Route::prefix($lower)
            ->middleware($middleware)
            ->namespace("App\\{$systemName}\Controllers")
            ->group(module_path($systemName).'/routes.php');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
