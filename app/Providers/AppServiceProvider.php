<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use  Illuminate\Support\Facades\Schema;
use Auth;
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
    public function boot()
    {
        Schema::defaultStringLength(191);
    
        view()->composer('*', function ($view) {
            if(Auth::guard('admin')->check()){
                $view->with('layout', 'layouts.admin.app');
        
            }else if (Auth::guard('user')->check()){
                $view->with('layout', 'layouts.user.app');
            }

    });
    }
}
