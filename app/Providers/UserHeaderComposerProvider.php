<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserHeaderComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->composeHeader();
    }

    public function composeHeader(){
        view()->composer('user.layout.partials.header','App\Http\Composers\UserHeaderComposer');
        view()->composer('user.layout.partials.topbar','App\Http\Composers\UserHeaderComposer');
        view()->composer('user.account.profile','App\Http\Composers\UserHeaderComposer');
        view()->composer('user.account.wallet','App\Http\Composers\UserHeaderComposer');
        view()->composer('account.users.user','App\Http\Composers\UserHeaderComposer');
        view()->composer('account.users.user','App\Http\Composers\UserHeaderComposer');
        view()->composer('user.layout.master','App\Http\Composers\UserHeaderComposer');
    }
}
