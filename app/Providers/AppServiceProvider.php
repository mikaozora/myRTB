<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale(env('LOCALE', 'id'));
        Paginator::useBootstrapFive();
        
        View::composer('*', function ($view) {
            $NIP = session('NIP');
            $user = User::find($NIP);
            $currentPassword = $user ? $user->password : null;

            $view->with('currentPassword', $currentPassword);
        });
    }
}    
