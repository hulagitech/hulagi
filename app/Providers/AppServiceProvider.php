<?php

namespace App\Providers;
use App\Notice;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
         $user_notices = Notice::orderByRaw('updated_at DESC')->where(function($query){
             $query->where('domain_name',env('APP_NAME', 'Hulagi'))->orWhere('domain_name','all');
        })->get();
        view()->share('user_notices', $user_notices);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
