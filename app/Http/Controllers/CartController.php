<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
   public function add($id)
{
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "price" => $product->price,
            "image" => $product->image,
            "quantity" => 1
        ];
    }

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'cartCount' => array_sum(array_column($cart, 'quantity'))
    ]);
}

public function remove($id)
{
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        unset($cart[$id]);
    }

    session()->put('cart', $cart);

    return response()->json([
    'success' => true,
    'cartCount' => array_sum(array_column($cart, 'quantity')),
    'total' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart))
    ]);
}

public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {

        if($request->quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $request->quantity;
        }

    }

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'cartCount' => array_sum(array_column($cart, 'quantity'))
    ]);
}

public function index()
{
    $cart = session()->get('cart', []);
    return view('products.cart', compact('cart'));
}

public function checkout()
{
    session()->forget('cart');

    return response()->json([
        'success' => true
    ]);
}
}

