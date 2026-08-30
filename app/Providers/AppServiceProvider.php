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
                    'payment_method' => __('Payment method'),
                    'credit_debit_card' => __('Credit / Debit Card'),
                    'select_payment_method' => __('Please select a payment method.'),
                    'confirm_checkout' => __('Confirm'),
                    'payment_details_title' => __('Payment details'),
                    'card_number' => __('Card number'),
                    'card_holder' => __('Cardholder name'),
                    'card_holder_placeholder' => __('Name as it appears on the card'),
                    'card_expiry' => __('Expiry (MM/YY)'),
                    'card_cvv' => __('CVV'),
                    'paypal_email' => __('PayPal email'),
                    'paypal_note' => __('You will receive a payment request at this email.'),
                    'nequi_phone' => __('Nequi phone number'),
                    'nequi_note' => __('We will send a payment request to this number.'),
                    'pay_now' => __('Pay now'),
                    'processing_payment' => __('Processing payment...'),
                    'invalid_card_number' => __('The card number must have 16 digits.'),
                    'invalid_card_holder' => __('Please enter the cardholder name.'),
                    'invalid_expiry' => __('The expiry date must be in MM/YY format.'),
                    'expired_card' => __('The card has expired.'),
                    'invalid_cvv' => __('The CVV must have 3 or 4 digits.'),
                    'invalid_email' => __('Please enter a valid email address.'),
                    'invalid_phone' => __('Please enter a valid 10-digit phone number.'),
                    'pay_now_redirect' => __('Go to pay'),
                ],
            ]);
        });

    }
}
