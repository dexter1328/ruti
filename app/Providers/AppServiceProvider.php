<?php

namespace App\Providers;

use App\WbWishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../Helpers/Helper.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // $wb_wishlist = null;

        // if (Auth::guard('w2bcustomer')->user()) {
        //     $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
        //     ->get();
        // }
        // view()->share('wb_wishlist', $wb_wishlist);

    }
}
