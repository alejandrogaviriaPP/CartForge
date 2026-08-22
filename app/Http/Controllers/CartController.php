<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ShippingEstimator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(int $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function remove(int $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
            'total' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            if ($request->quantity <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = $request->quantity;
            }
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        if (! empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

            foreach ($cart as $id => &$item) {
                $item['name'] = $products[$id]->name ?? $item['name'];
                $item['subtotal'] = $item['price'] * $item['quantity'];
            }
            unset($item);
        }

        $total = array_sum(array_column($cart, 'subtotal'));

        return view('products.cart', compact('cart', 'total'));
    }

    public function checkout(ShippingEstimator $shipping)
    {
        $cart = session()->get('cart', []);
        $user = auth()->user();

        if (empty($cart) || ! $user) {
            return response()->json([
                'success' => false,
            ]);
        }

        $order = DB::transaction(function () use ($cart, $user, $shipping) {
            $total = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));

            ['min' => $deliveryMin, 'max' => $deliveryMax] = $shipping->estimate($user->country);

            $order = $user->orders()->create([
                'total' => $total,
                'country' => $user->country ?? 'Colombia',
                'delivery_min' => $deliveryMin->toDateString(),
                'delivery_max' => $deliveryMax->toDateString(),
            ]);

            foreach ($cart as $id => $item) {
                $order->items()->create([
                    'product_id' => $id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return response()->json([
            'success' => true,
            'deliveryText' => __('Arrives between :min and :max', [
                'min' => $order->delivery_min->locale(app()->getLocale())->translatedFormat('j M'),
                'max' => $order->delivery_max->locale(app()->getLocale())->translatedFormat('j M'),
            ]),
        ]);
    }
}
