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

        View::composer('layouts.app', function ($view) {

            $cart = session('cart', []);

            $wishlistIds = auth()->user()
                ? auth()->user()->wishlistProducts()->pluck('products.id')->all()
                : [];

            $view->with([
                'cartCount' => array_sum(array_column($cart, 'quantity')),
                'wishlistIds' => $wishlistIds,
                'i18n' => [
                    'login_required_title' => __('Login required'),
                    'login_required_text' => __('You need to login to add items to your cart'),
                    'go_to_login' => __('Go to login'),
                    'added' => __('Product added to cart'),
                    'removed' => __('Product removed from cart'),
                    'total_label' => __('Total:'),
                    'empty_cart_title' => __('Empty Cart'),
                    'empty_cart_text' => __('Your shopping cart is currently empty.'),
                    'checkout_confirm_title' => __('Are you sure?'),
                    'checkout_confirm_text' => __('Do you want to complete this purchase?'),
                    'yes_checkout' => __('Yes, checkout!'),
                    'cancel' => __('Cancel'),
                    'order_placed_title' => __('Order Placed!'),
                    'order_placed_text' => __('Your order has been processed successfully.'),
                    'shopping_cart' => __('Shopping Cart'),
                    'cart_empty_thanks' => __('Your cart is now empty. Thank you for your purchase!'),
                    'back_to_products' => __('Back to Products'),
                    'error_title' => __('Error'),
                    'error_text' => __('Something went wrong with the transaction.'),
                    'rating_saved' => __('Thank you for your rating!'),
                    'wishlist_added' => __('Added to your wishlist'),
                    'wishlist_removed' => __('Removed from your wishlist'),
                    'wishlist_login_required' => __('Log in to save favorites'),
                    'wishlist_error' => __('Could not update your wishlist'),
                ],
            ]);
        });

    }
}
