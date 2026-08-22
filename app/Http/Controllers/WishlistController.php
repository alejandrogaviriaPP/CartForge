<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $products = auth()->user()->wishlistProducts()->get();

        return view('products.wishlist', compact('products'));
    }

    public function toggle(Product $product)
    {
        $result = auth()->user()->wishlistProducts()->toggle([$product->id]);

        return response()->json([
            'success' => true,
            'inWishlist' => ! empty($result['attached']),
        ]);
    }
}
