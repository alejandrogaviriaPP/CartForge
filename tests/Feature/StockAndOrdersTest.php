<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

function makeProductWithStock(int $stock): Product
{
    return Product::create([
        'name' => 'Stock Product',
        'description' => 'Stock test product',
        'price' => 10,
        'stock' => $stock,
        'image' => 'images/products/test.png',
    ]);
}

function makeOrderWithItem(User $customer, Product $product, int $quantity = 1): Order
{
    $order = Order::create([
        'user_id' => $customer->id,
        'total' => $product->price * $quantity,
        'country' => 'Colombia',
        'payment_method' => 'card',
        'status' => 'paid',
        'delivery_min' => now()->addDays(2),
        'delivery_max' => now()->addDays(5),
    ]);

    $order->items()->create([
        'product_id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'quantity' => $quantity,
    ]);

    return $order;
}

test('storefront pages render with the new design', function () {
    makeProductWithStock(5);

    $this->get('/')->assertOk()->assertSee(__('Featured products'));
    $this->get('/products')->assertOk();
});

test('add to cart is rejected when product is out of stock', function () {
    $user = User::factory()->create();
    $product = makeProductWithStock(0);

    $this->actingAs($user)
        ->postJson("/cart/add/{$product->id}")
        ->assertOk()
        ->assertJson(['success' => false]);
});

test('checkout decrements product stock', function () {
    $user = User::factory()->create(['country' => 'Colombia']);
    $product = makeProductWithStock(5);

    session(['cart' => [
        $product->id => [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => 2,
        ],
    ]]);

    $this->actingAs($user)
        ->postJson('/cart/checkout', [
            'payment_method' => 'card',
            'payment_details' => [
                'card_number' => '4242424242424242',
                'card_holder' => 'Test User',
                'card_expiry' => now()->addYear()->format('m/y'),
                'card_cvv' => '123',
            ],
        ])
        ->assertOk()
        ->assertJson(['success' => true]);

    expect($product->fresh()->stock)->toBe(3);
});

test('checkout fails when there is not enough stock', function () {
    $user = User::factory()->create(['country' => 'Colombia']);
    $product = makeProductWithStock(1);

    session(['cart' => [
        $product->id => [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => 3,
        ],
    ]]);

    $this->actingAs($user)
        ->postJson('/cart/checkout', [
            'payment_method' => 'card',
            'payment_details' => [
                'card_number' => '4242424242424242',
                'card_holder' => 'Test User',
                'card_expiry' => now()->addYear()->format('m/y'),
                'card_cvv' => '123',
            ],
        ])
        ->assertOk()
        ->assertJson(['success' => false]);

    expect($product->fresh()->stock)->toBe(1)
        ->and(Order::count())->toBe(0);
});

test('customers can cancel their order and stock is restored', function () {
    $customer = User::factory()->create();
    $product = makeProductWithStock(4);
    $order = makeOrderWithItem($customer, $product, 2);

    $this->actingAs($customer)
        ->post("/orders/{$order->id}/cancel")
        ->assertRedirect();

    $order->refresh();
    $product->refresh();

    expect($order->status)->toBe('cancelled')
        ->and($product->stock)->toBe(6);
});

test('customers cannot cancel orders from other users', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $product = makeProductWithStock(5);
    $order = makeOrderWithItem($owner, $product);

    $this->actingAs($intruder)
        ->post("/orders/{$order->id}/cancel")
        ->assertForbidden();

    expect($order->fresh()->status)->toBe('paid');
});

test('delivered or shipped orders cannot be cancelled by customers', function () {
    $customer = User::factory()->create();
    $product = makeProductWithStock(5);
    $order = makeOrderWithItem($customer, $product);

    $order->update(['status' => 'shipped']);

    $this->actingAs($customer)
        ->post("/orders/{$order->id}/cancel")
        ->assertRedirect();

    expect($order->fresh()->status)->toBe('shipped')
        ->and($product->fresh()->stock)->toBe(5);
});

test('shipped orders are marked delivered when the delivery window passes', function () {
    $customer = User::factory()->create();
    $product = makeProductWithStock(5);
    $order = makeOrderWithItem($customer, $product);

    $order->update([
        'status' => 'shipped',
        'delivery_max' => now()->subDay(),
    ]);

    Order::markDelivered();

    expect($order->fresh()->status)->toBe('delivered');
});

test('unpaid pending orders expire after 24 hours and stock is restored', function () {
    $customer = User::factory()->create();
    $product = makeProductWithStock(3);
    $order = makeOrderWithItem($customer, $product, 2);

    $order->update(['status' => 'pending']);
    $order->forceFill(['created_at' => now()->subHours(25)])->save();

    Order::expireUnpaid();

    expect($order->fresh()->status)->toBe('cancelled')
        ->and($product->fresh()->stock)->toBe(5);
});
