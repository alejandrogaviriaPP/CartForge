<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Mail\PaymentRequestMail;
use App\Models\Product;
use App\Services\ShippingEstimator;
use App\Services\WompiPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function add(int $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $currentQuantity = $cart[$id]['quantity'] ?? 0;

        if ($currentQuantity + 1 > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => __('There is not enough stock for :name', ['name' => $product->name]),
            ]);
        }

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
                $stock = (int) Product::find($id)?->stock;
                $cart[$id]['quantity'] = min($request->quantity, $stock);
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

    public function checkout(Request $request, ShippingEstimator $shipping)
    {
        $cart = session()->get('cart', []);
        $user = auth()->user();

        if (empty($cart) || ! $user) {
            return response()->json([
                'success' => false,
            ]);
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'in:card,paypal,nequi'],
        ]);

        $rules = match ($validated['payment_method']) {
            'card' => [
                'payment_details.card_number' => ['required', 'digits:16'],
                'payment_details.card_holder' => ['required', 'string', 'min:3'],
                'payment_details.card_expiry' => ['required', 'date_format:m/y'],
                'payment_details.card_cvv' => ['required', 'digits_between:3,4'],
            ],
            'paypal' => [
                'payment_details.paypal_email' => ['required', 'email'],
            ],
            'nequi' => [
                'payment_details.nequi_phone' => ['required', 'digits:10'],
            ],
        };

        $request->validate($rules);

        try {
            $order = DB::transaction(function () use ($cart, $user, $shipping, $validated) {
                $products = Product::whereIn('id', array_keys($cart))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($cart as $id => $item) {
                    $product = $products[$id] ?? null;

                    if (! $product || $product->stock < $item['quantity']) {
                        throw InsufficientStockException::forProduct($item['name']);
                    }
                }

                $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

                ['min' => $deliveryMin, 'max' => $deliveryMax] = $shipping->estimate($user->country);

                $order = $user->orders()->create([
                    'total' => $total,
                    'country' => $user->country ?? 'Colombia',
                    'payment_method' => $validated['payment_method'],
                    'status' => 'pending',
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

                    $products[$id]->decrement('stock', $item['quantity']);
                }

                return $order;
            });
        } catch (InsufficientStockException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        $payment = app(WompiPayment::class);

        if ($payment->isConfigured()) {
            $link = $payment->createPaymentLink($order, $user->email);

            if ($link === null) {
                return response()->json(['success' => false]);
            }

            $order->update([
                'payment_reference' => $link['reference'],
                'payment_url' => $link['url'],
            ]);

            Mail::to($user->email)->send(new PaymentRequestMail($order, $link['url']));

            return response()->json([
                'success' => true,
                'payment_url' => $link['url'],
                'deliveryText' => __('Arrives between :min and :max', [
                    'min' => $order->delivery_min->locale(app()->getLocale())->translatedFormat('j M'),
                    'max' => $order->delivery_max->locale(app()->getLocale())->translatedFormat('j M'),
                ]),
            ]);
        }

        $order->update(['status' => 'paid']);

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
