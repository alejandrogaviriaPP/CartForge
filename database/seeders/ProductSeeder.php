<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {

        Product::create([
            'name' => 'Monitor 22 inch',
            'description' => '22-inch Full HD monitor with IPS panel, slim design and HDMI connectivity.',
            'price' => 129.99,
            'image' => 'images/products/monitor.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Virtual Assistant',
            'description' => 'Smart speaker with voice control and smart home integration.',
            'price' => 49.99,
            'image' => 'images/products/alexa.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Apple TV',
            'description' => '4K streaming device with HDR support.',
            'price' => 149.00,
            'image' => 'images/products/apple-tv.jpg',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Apple Watch',
            'description' => 'Smartwatch with fitness tracking.',
            'price' => 299.00,
            'image' => 'images/products/apple-watch.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Charger',
            'description' => 'Fast charging adapter.',
            'price' => 15.99,
            'image' => 'images/products/charger.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Digital Clock',
            'description' => 'LED digital clock with alarm.',
            'price' => 19.99,
            'image' => 'images/products/digital-clock.jpeg',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Headphones',
            'description' => 'Wireless headphones with long battery life.',
            'price' => 59.99,
            'image' => 'images/products/headphones.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Wireless Mouse',
            'description' => 'Ergonomic wireless mouse.',
            'price' => 14.99,
            'image' => 'images/products/mouse.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Power Bank',
            'description' => 'Portable power bank with fast charging.',
            'price' => 24.99,
            'image' => 'images/products/power-bank.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Smart Clock',
            'description' => 'Smart alarm clock with voice assistant.',
            'price' => 39.99,
            'image' => 'images/products/smart-alarm.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Smart TV',
            'description' => '4K Smart TV with streaming apps.',
            'price' => 499.99,
            'image' => 'images/products/smart-tv.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Speaker',
            'description' => 'Portable Bluetooth speaker.',
            'price' => 45.99,
            'image' => 'images/products/speaker.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Ray-Ban Meta',
            'description' => 'Smart glasses with Meta AI and camera.',
            'price' => 499.99,
            'image' => 'images/products/sunglasses.jpg',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Air Conditioner',
            'description' => 'Energy-efficient air conditioner.',
            'price' => 349.99,
            'image' => 'images/products/air-conditioning.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Chair',
            'description' => 'Ergonomic chair with modern style.',
            'price' => 89.99,
            'image' => 'images/products/chair.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Coffee Maker',
            'description' => 'Compact coffee maker.',
            'price' => 59.99,
            'image' => 'images/products/coffee-maker.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Couch',
            'description' => 'Comfortable modern couch.',
            'price' => 499.99,
            'image' => 'images/products/couch.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Cupboard',
            'description' => 'Spacious modern cupboard.',
            'price' => 199.99,
            'image' => 'images/products/cupboard.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Rice Cooker',
            'description' => 'Digital rice cooker.',
            'price' => 79.99,
            'image' => 'images/products/digital-rice-cooker.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Desk Lamp',
            'description' => 'LED desk lamp.',
            'price' => 29.99,
            'image' => 'images/products/lamp.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Refrigerator',
            'description' => 'Large capacity refrigerator.',
            'price' => 545.00,
            'old_price' => 629.99,
            'image' => 'images/products/refrigerator.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Vacuum Cleaner',
            'description' => 'High power vacuum cleaner.',
            'price' => 129.99,
            'image' => 'images/products/vacuum-cleaner.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Thermos Bottle',
            'description' => 'Stainless steel thermos bottle.',
            'price' => 22.99,
            'image' => 'images/products/water-bottle.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Blue T-Shirt',
            'description' => 'Soft cotton t-shirt.',
            'price' => 19.99,
            'image' => 'images/products/blue-tshirt.jpg',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Bracelet',
            'description' => 'Elegant minimalist bracelet.',
            'price' => 24.99,
            'image' => 'images/products/bracelet.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Denim Jacket',
            'description' => 'Classic denim jacket.',
            'price' => 69.99,
            'image' => 'images/products/denim-jacket.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Denim Pants',
            'description' => 'Comfortable slim-fit denim pants.',
            'price' => 49.99,
            'image' => 'images/products/denim-pants.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Sweatshirt',
            'description' => 'Warm and comfortable sweatshirt.',
            'price' => 34.99,
            'image' => 'images/products/grey-sweatshirt.jpeg',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Red Cap',
            'description' => 'Stylish red cap.',
            'price' => 12.99,
            'image' => 'images/products/red-cap.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Running Shoes',
            'description' => 'Lightweight running shoes.',
            'price' => 89.99,
            'image' => 'images/products/running-shoes.jpeg',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Sandals',
            'description' => 'Comfortable everyday sandals.',
            'price' => 29.99,
            'image' => 'images/products/sandals.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Backpack',
            'description' => 'Durable backpack with compartments.',
            'price' => 39.99,
            'image' => 'images/products/school-backpack.jpeg',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Sport Shorts',
            'description' => 'Breathable sport shorts.',
            'price' => 19.99,
            'image' => 'images/products/sports-shorts.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Suitcase',
            'description' => 'Durable travel suitcase.',
            'price' => 119.99,
            'image' => 'images/products/suitcase.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Perfume',
            'description' => 'Elegant long-lasting fragrance.',
            'price' => 79.99,
            'image' => 'images/products/valentino.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Winter Hat',
            'description' => 'Warm winter hat.',
            'price' => 14.99,
            'image' => 'images/products/winter-hat.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'iPhone 17 Pro Max',
            'description' => 'iPhone 17 Pro Max 256GB Silver.',
            'price' => 1049.00,
            'old_price' => 1149.00,
            'brand' => 'Apple',
            'image' => 'images/products/iphone-17-pro-max.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'MacBook Air 13 inch',
            'description' => 'Apple 2025 MacBook Air 13-inch Laptop with M4 chip: Built for Apple Intelligence.',
            'price' => 1100.00,
            'old_price' => 1199.00,
            'brand' => 'Apple',
            'image' => 'images/products/macbook-air.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'AirPods Pro',
            'description' => 'AirPods Pro with noise cancellation and wireless charging case.',
            'price' => 239.00,
            'old_price' => 269.00,
            'brand' => 'Apple, headphones',
            'image' => 'images/products/airpods.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'JBL Tune 670NC',
            'description' => 'Lightness, comfort, and great sound. With the JBL Tune 670NC Adaptive Noise Cancelling wireless headphones.',
            'price' => 59.99,
            'old_price' => 79.00,
            'brand' => 'headphones',
            'image' => 'images/products/jbl-tune.png',
            'category' => 'tech',
        ]);
    }
}
