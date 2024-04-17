<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAccountRoutes();

        $this->mapFleetRoutes();

        $this->mapDispatcherRoutes();

        $this->mapProviderRoutes();

        $this->mapAdminRoutes();
        
        $this->mapCmsRoutes();

       $this->mapCrmRoutes();
        
        $this->mapProviderApiRoutes();
        $this->mapSupportRoutes();
        $this->mapFulfillmentRoutes();
        $this->mapBranchManagerRoutes();

        $this->mapReturnRoutes();
        $this->mapSortCenterRoutes();
        $this->mapPickupRoutes();
        
        $this->mapDispatcherApiRoutes();

        //
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => ['web', 'admin', 'auth:admin'],
            'prefix' => 'admin',
            'as' => 'admin.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/admin.php');
        });
    }
    

    protected function mapCmsRoutes()
    {
        Route::group([
            'middleware' => ['web', 'cms', 'auth:cms'],
            'prefix' => 'cms',
            'as' => 'cms.',
            'namespace' => $this->namespace,
        ], function ($router) {
            
            require base_path('routes/cms.php');
        });
    }
    protected function mapCrmRoutes()
    {
        Route::group([
            'middleware' => ['web', 'crm', 'auth:crm'],
            'prefix' => 'crm',
            'as' => 'crm.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/crm.php');
        });
    }
    /**
     * Define the "provider" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapProviderRoutes()
    {
        Route::group([
            'middleware' => ['web', 'provider', 'auth:provider'],
            'prefix' => 'provider',
            'as' => 'provider.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/provider.php');
        });
    }

    /**
     * Define the "dispatcher" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapDispatcherRoutes()
    {
        Route::group([
            'middleware' => ['web', 'dispatcher', 'auth:dispatcher'],
            'prefix' => 'dispatcher',
            'as' => 'dispatcher.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/dispatcher.php');
        });
    }

    /**
     * Define the "fleet" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapFleetRoutes()
    {
        Route::group([
            'middleware' => ['web', 'fleet', 'auth:fleet'],
            'prefix' => 'fleet',
            'as' => 'fleet.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/fleet.php');
        });
    }

    /**
     * Define the "account" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAccountRoutes()
    {
        Route::group([
            'middleware' => ['web', 'account', 'auth:account'],
            'prefix' => 'account',
            'as' => 'account.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/account.php');
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api/user',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }

    protected function mapSupportRoutes()
    {
        Route::group([
            'middleware' => ['web', 'support', 'auth:support'],
            'prefix' => 'support',
            'as' => 'support.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/support.php');
        });
    }


    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapProviderApiRoutes()
    {
        Route::group([
            'namespace' => $this->namespace,
            'prefix' => 'api/provider',
        ], function ($router) {
            require base_path('routes/providerapi.php');
        });
    }

    /**
     * Define the "fulfillment" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapFulfillmentRoutes()
    {
        Route::group([
            'middleware' => ['web', 'fulfillment'],
            'prefix' => 'fulfillment',
            'as' => 'fulfillment.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/fulfillment.php');
        });
    }

    /**
     * Define the "return" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapReturnRoutes()
    {
        Route::group([
            'middleware' => ['web', 'return', 'auth:return'],
            'prefix' => 'return',
            'as' => 'return.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/return.php');
        });
    }
    protected function mapPickupRoutes()
    {
        Route::group([
            'middleware' => ['web', 'pickup', 'auth:pickup'],
            'prefix' => 'pickup',
            'as' => 'pickup.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/pickup.php');
        });
    }

    /**
     * Define the "bm" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapBranchManagerRoutes()
    {
        Route::group([
            'middleware' => ['web', 'bm', 'auth:bm'],
            'prefix' => 'bm',
            'as' => 'bm.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/bm.php');
        });
    }
    protected function mapSortCenterRoutes()
    {
        Route::group([
            'middleware' => ['web', 'sortcenter', 'auth:sortcenter'],
            'prefix' => 'sortcenter',
            'as' => 'sortcenter.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/sortcenter.php');
        });
    }

    protected function mapDispatcherApiRoutes(){
         Route::group([
            'namespace' => $this->namespace,
            'prefix' => 'api/dispatcher',
        ], function ($router) {
            require base_path('routes/dispatcherapi.php');
        });
    }
}
