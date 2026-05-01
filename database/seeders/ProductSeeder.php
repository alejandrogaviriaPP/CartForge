<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
    'name' => 'Monitor 22 inch',
    'description' => '22-inch Full HD monitor with IPS panel, slim design and HDMI connectivity. Ideal for work and entertainment.',
    'price' => 129.99,
    'image' => 'images/products/monitor.png'
]);

Product::create([
    'name' => 'Air Conditioner',
    'description' => 'Energy-efficient air conditioner with fast cooling and quiet operation.',
    'price' => 349.99,
    'image' => 'images/products/air-conditioning.png'
]);

Product::create([
    'name' => 'Virtual Assistant',
    'description' => 'Smart speaker with voice control, music streaming and smart home integration.',
    'price' => 49.99,
    'image' => 'images/products/alexa.png'
]);

Product::create([
    'name' => 'Apple TV',
    'description' => '4K streaming device with HDR support and access to popular apps.',
    'price' => 149.00,
    'image' => 'images/products/apple-tv.jpg'
]);

Product::create([
    'name' => 'Apple Watch',
    'description' => 'Smartwatch with fitness tracking, heart rate monitoring and modern design.',
    'price' => 299.00,
    'image' => 'images/products/apple-watch.png'
]);

Product::create([
    'name' => 'Blue T-Shirt',
    'description' => 'Soft cotton t-shirt with a comfortable fit for everyday wear.',
    'price' => 19.99,
    'image' => 'images/products/blue-tshirt.jpg'
]);

Product::create([
    'name' => 'Bracelet',
    'description' => 'Elegant bracelet with a minimalist design, perfect for daily use.',
    'price' => 24.99,
    'image' => 'images/products/bracelet.png'
]);

Product::create([
    'name' => 'Chair',
    'description' => 'Ergonomic chair with comfortable cushioning and modern style.',
    'price' => 89.99,
    'image' => 'images/products/chair.png'
]);

Product::create([
    'name' => 'Charger',
    'description' => 'Fast charging adapter compatible with multiple devices.',
    'price' => 15.99,
    'image' => 'images/products/charger.png'
]);

Product::create([
    'name' => 'Coffee Maker',
    'description' => 'Compact coffee maker with quick brewing and easy operation.',
    'price' => 59.99,
    'image' => 'images/products/coffee-maker.png'
]);

Product::create([
    'name' => 'Cupboard',
    'description' => 'Spacious cupboard with durable wood finish and modern design.',
    'price' => 199.99,
    'image' => 'images/products/cupboard.png'
]);

Product::create([
    'name' => 'Denim Jacket',
    'description' => 'Classic denim jacket with a stylish and durable design.',
    'price' => 69.99,
    'image' => 'images/products/denim-jacket.png'
]);

Product::create([
    'name' => 'Denim Pants',
    'description' => 'Comfortable denim pants with a slim fit and modern look.',
    'price' => 49.99,
    'image' => 'images/products/denim-pants.png'
]);

Product::create([
    'name' => 'Digital Clock',
    'description' => 'LED digital clock with alarm and clear display.',
    'price' => 19.99,
    'image' => 'images/products/digital-clock.jpeg'
]);

Product::create([
    'name' => 'Rice Cooker',
    'description' => 'Digital rice cooker with multiple cooking modes and timer.',
    'price' => 79.99,
    'image' => 'images/products/digital-rice-cooker.png'
]);

Product::create([
    'name' => 'Sweatshirt',
    'description' => 'Warm and comfortable sweatshirt for casual wear.',
    'price' => 34.99,
    'image' => 'images/products/grey-sweatshirt.jpeg'
]);

Product::create([
    'name' => 'Headphones',
    'description' => 'Wireless headphones with clear sound and long battery life.',
    'price' => 59.99,
    'image' => 'images/products/headphones.png'
]);

Product::create([
    'name' => 'Desk Lamp',
    'description' => 'LED desk lamp with adjustable brightness and modern design.',
    'price' => 29.99,
    'image' => 'images/products/lamp.png'
]);

Product::create([
    'name' => 'Wireless Mouse',
    'description' => 'Ergonomic wireless mouse with smooth and precise tracking.',
    'price' => 14.99,
    'image' => 'images/products/mouse.png'
]);

Product::create([
    'name' => 'Power Bank',
    'description' => 'Portable power bank with fast charging and high capacity.',
    'price' => 24.99,
    'image' => 'images/products/power-bank.png'
]);

Product::create([
    'name' => 'Red Cap',
    'description' => 'Stylish red cap with adjustable strap for a perfect fit.',
    'price' => 12.99,
    'image' => 'images/products/red-cap.png'
]);

Product::create([
    'name' => 'Refrigerator',
    'description' => 'Large capacity refrigerator with energy-saving technology.',
    'price' => 599.99,
    'image' => 'images/products/refrigerator.png'
]);

Product::create([
    'name' => 'Running Shoes',
    'description' => 'Lightweight running shoes with excellent cushioning.',
    'price' => 89.99,
    'image' => 'images/products/running-shoes.jpeg'
]);

Product::create([
    'name' => 'Sandals',
    'description' => 'Comfortable sandals for everyday use.',
    'price' => 29.99,
    'image' => 'images/products/sandals.png'
]);

Product::create([
    'name' => 'Backpack',
    'description' => 'Durable backpack with multiple compartments.',
    'price' => 39.99,
    'image' => 'images/products/school-backpack.jpeg'
]);

Product::create([
    'name' => 'Smart Clock',
    'description' => 'Smart alarm clock with voice assistant integration.',
    'price' => 39.99,
    'image' => 'images/products/smart-alarm.png'
]);

Product::create([
    'name' => 'Smart TV',
    'description' => '4K Smart TV with streaming apps and high-quality display.',
    'price' => 499.99,
    'image' => 'images/products/smart-tv.png'
]);

Product::create([
    'name' => 'Speaker',
    'description' => 'Portable speaker with powerful sound and Bluetooth connectivity.',
    'price' => 45.99,
    'image' => 'images/products/speaker.png'
]);

Product::create([
    'name' => 'Sport Shorts',
    'description' => 'Breathable sport shorts designed for comfort and flexibility.',
    'price' => 19.99,
    'image' => 'images/products/sports-shorts.png'
]);

Product::create([
    'name' => 'Suitcase',
    'description' => 'Durable suitcase with wheels and large storage capacity.',
    'price' => 119.99,
    'image' => 'images/products/suitcase.png'
]);

Product::create([
    'name' => 'Ray-Ban Meta',
    'description' => 'Smart lenses with advanced technology, including Meta AI, a 12MP ultra-wide-angle camera for HD.',
    'price' => 499.99,
    'image' => 'images/products/sunglasses.jpg'
]);

Product::create([
    'name' => 'Vacuum Cleaner',
    'description' => 'High power vacuum cleaner with efficient dust removal.',
    'price' => 129.99,
    'image' => 'images/products/vacuum-cleaner.png'
]);

Product::create([
    'name' => 'Perfume',
    'description' => 'Elegant fragrance with long-lasting scent.',
    'price' => 79.99,
    'image' => 'images/products/valentino.png'
]);

Product::create([
    'name' => 'Thermos Bottle',
    'description' => 'Stainless steel thermos that keeps drinks hot or cold for hours.',
    'price' => 22.99,
    'image' => 'images/products/water-bottle.png'
]);

Product::create([
    'name' => 'Winter Hat',
    'description' => 'Warm winter hat made with soft and comfortable fabric.',
    'price' => 14.99,
    'image' => 'images/products/winter-hat.png'
]);

Product::create([
    'name' => 'Couch',
    'description' => 'Comfortable sofa with modern design and durable materials.',
    'price' => 499.99,
    'image' => 'images/products/couch.png'
]);
    }
}