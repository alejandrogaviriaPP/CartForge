<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function fakeImage(string $name): UploadedFile
{
    return UploadedFile::fake()->createWithContent(
        $name,
        base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==')
    );
}

test('guests are redirected from admin panel', function () {
    $this->get('/admin')->assertRedirect('/login');
});

test('non admin users cannot access admin panel', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/admin')->assertForbidden();
});

test('admins can access the dashboard', function () {
    $this->actingAs(User::factory()->create(['is_admin' => true]));

    $this->get('/admin')->assertOk()->assertSee(__('Admin panel'));
});

test('admins can create products with uploaded images', function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->create(['is_admin' => true]));

    $response = $this->post('/admin/products', [
        'name' => 'Test Product',
        'description' => 'A test product description',
        'price' => 99.99,
        'stock' => 10,
        'image' => fakeImage('test.png'),
        'gallery' => [
            fakeImage('gallery-1.png'),
            fakeImage('gallery-2.png'),
        ],
        'category' => 'tech',
        'brand' => 'TestBrand',
    ]);

    $response->assertRedirect(route('admin.products.index'));

    $product = Product::query()->where('name', 'Test Product')->first();

    expect($product)->not->toBeNull()
        ->and($product->stock)->toBe(10)
        ->and($product->image)->toStartWith('storage/products/')
        ->and(count($product->gallery ?? []))->toBe(2);
});

test('product form pages render', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $product = Product::create([
        'name' => 'Form Product',
        'description' => 'Form render test',
        'price' => 30,
        'stock' => 4,
        'image' => 'images/products/test.png',
    ]);

    $this->actingAs($admin)->get('/admin/products/create')->assertOk();
    $this->actingAs($admin)->get("/admin/products/{$product->id}/edit")->assertOk();
    $this->actingAs($admin)->get(route('admin.products.index'))->assertOk();
});

test('product validation rejects invalid data', function () {
    $this->actingAs(User::factory()->create(['is_admin' => true]));

    $this->post('/admin/products', ['name' => ''])
        ->assertSessionHasErrors(['name', 'description', 'price', 'image', 'stock']);
});

test('admins can adjust product stock', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $product = Product::create([
        'name' => 'Stocked Product',
        'description' => 'Stock test',
        'price' => 20,
        'stock' => 5,
        'image' => 'images/products/test.png',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.products.stock', $product), ['delta' => 10])
        ->assertRedirect();

    $this->actingAs($admin)
        ->patch(route('admin.products.stock', $product), ['delta' => -3])
        ->assertRedirect();

    expect($product->fresh()->stock)->toBe(12);
});

test('admins can update order status', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $customer = User::factory()->create();

    $order = Order::create([
        'user_id' => $customer->id,
        'total' => 150,
        'country' => 'CO',
        'payment_method' => 'card',
        'status' => 'paid',
        'delivery_min' => now()->addDays(2),
        'delivery_max' => now()->addDays(5),
    ]);

    $this->actingAs($admin)
        ->patch("/admin/orders/{$order->id}/status", ['status' => 'shipped'])
        ->assertRedirect();

    expect($order->fresh()->status)->toBe('shipped');
});

test('products with orders cannot be deleted', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $customer = User::factory()->create();
    $product = Product::create([
        'name' => 'Ordered Product',
        'description' => 'Has orders',
        'price' => 50,
        'stock' => 5,
        'image' => 'images/products/test.png',
    ]);

    $order = Order::create([
        'user_id' => $customer->id,
        'total' => 50,
        'country' => 'CO',
        'payment_method' => 'card',
        'status' => 'paid',
        'delivery_min' => now()->addDays(2),
        'delivery_max' => now()->addDays(5),
    ]);

    $order->items()->create([
        'product_id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'quantity' => 1,
    ]);

    $this->actingAs($admin)
        ->delete("/admin/products/{$product->id}")
        ->assertRedirect(route('admin.products.index'));

    expect($product->fresh())->not->toBeNull();
});
