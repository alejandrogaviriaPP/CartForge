<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        View::composer('*', function ($view) {

            $cart = session('cart', []);

            $count = array_sum(array_column($cart, 'quantity'));

            $view->with('cartCount', $count);
        });

    }
}
