<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $sessionId = session()->getId();

            $recentSearches = DB::table('search_histories')
                ->where('user_session', $sessionId)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            $view->with('recentSearches', $recentSearches);
        });


        // Setting the default pagination view to Bootstrap 5. This is correct.
        Paginator::useBootstrapFive();
    }
}