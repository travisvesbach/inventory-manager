<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Session;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Inertia::share('flash', function () {
            return [
                'message' => Session::get('flash_message'),
                'status' => Session::get('flash_status'),
                'timestamp' => Carbon::now(),
            ];
        });
        Inertia::share('categories_top', function () {
            return \App\Models\Category::whereNull('parent_id')->with('allChildren')->orderBy('name')->get();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
