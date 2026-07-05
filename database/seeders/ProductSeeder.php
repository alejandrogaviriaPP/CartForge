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
            'name_es' => 'Monitor de 22 pulgadas',
            'description' => '22-inch Full HD monitor with IPS panel, slim design and HDMI connectivity.',
            'description_es' => 'Monitor Full HD de 22 pulgadas con panel IPS, diseño delgado y conectividad HDMI.',
            'price' => 129.99,
            'image' => 'images/products/monitor.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Virtual Assistant',
            'name_es' => 'Asistente virtual',
            'description' => 'Smart speaker with voice control and smart home integration.',
            'description_es' => 'Altavoz inteligente con control por voz e integración con el hogar inteligente.',
            'price' => 49.99,
            'image' => 'images/products/alexa.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Apple TV',
            'name_es' => 'Apple TV',
            'description' => '4K streaming device with HDR support.',
            'description_es' => 'Dispositivo de transmisión 4K con soporte HDR.',
            'price' => 149.00,
            'image' => 'images/products/apple-tv.jpg',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Apple Watch',
            'name_es' => 'Apple Watch',
            'description' => 'Smartwatch with fitness tracking.',
            'description_es' => 'Reloj inteligente con seguimiento de actividad física.',
            'price' => 299.00,
            'image' => 'images/products/apple-watch.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Charger',
            'name_es' => 'Cargador',
            'description' => 'Fast charging adapter.',
            'description_es' => 'Adaptador de carga rápida.',
            'price' => 15.99,
            'image' => 'images/products/charger.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Digital Clock',
            'name_es' => 'Reloj digital',
            'description' => 'LED digital clock with alarm.',
            'description_es' => 'Reloj digital LED con alarma.',
            'price' => 19.99,
            'image' => 'images/products/digital-clock.jpeg',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Headphones',
            'name_es' => 'Auriculares',
            'description' => 'Wireless headphones with long battery life.',
            'description_es' => 'Auriculares inalámbricos con gran autonomía.',
            'price' => 59.99,
            'image' => 'images/products/headphones.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Wireless Mouse',
            'name_es' => 'Ratón inalámbrico',
            'description' => 'Ergonomic wireless mouse.',
            'description_es' => 'Ratón inalámbrico ergonómico.',
            'price' => 14.99,
            'image' => 'images/products/mouse.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Power Bank',
            'name_es' => 'Batería externa',
            'description' => 'Portable power bank with fast charging.',
            'description_es' => 'Batería externa portátil con carga rápida.',
            'price' => 24.99,
            'image' => 'images/products/power-bank.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Smart Clock',
            'name_es' => 'Reloj inteligente',
            'description' => 'Smart alarm clock with voice assistant.',
            'description_es' => 'Reloj despertador inteligente con asistente de voz.',
            'price' => 39.99,
            'image' => 'images/products/smart-alarm.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Smart TV',
            'name_es' => 'Smart TV',
            'description' => '4K Smart TV with streaming apps.',
            'description_es' => 'Smart TV 4K con aplicaciones de streaming.',
            'price' => 499.99,
            'image' => 'images/products/smart-tv.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Speaker',
            'name_es' => 'Altavoz',
            'description' => 'Portable Bluetooth speaker.',
            'description_es' => 'Altavoz Bluetooth portátil.',
            'price' => 45.99,
            'image' => 'images/products/speaker.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Ray-Ban Meta',
            'name_es' => 'Ray-Ban Meta',
            'description' => 'Smart glasses with Meta AI and camera.',
            'description_es' => 'Gafas inteligentes con Meta AI y cámara.',
            'price' => 499.99,
            'image' => 'images/products/sunglasses.jpg',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'Air Conditioner',
            'name_es' => 'Aire acondicionado',
            'description' => 'Energy-efficient air conditioner.',
            'description_es' => 'Aire acondicionado de bajo consumo.',
            'price' => 349.99,
            'image' => 'images/products/air-conditioning.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Chair',
            'name_es' => 'Silla',
            'description' => 'Ergonomic chair with modern style.',
            'description_es' => 'Silla ergonómica de estilo moderno.',
            'price' => 89.99,
            'image' => 'images/products/chair.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Coffee Maker',
            'name_es' => 'Cafetera',
            'description' => 'Compact coffee maker.',
            'description_es' => 'Cafetera compacta.',
            'price' => 59.99,
            'image' => 'images/products/coffee-maker.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Couch',
            'name_es' => 'Sofá',
            'description' => 'Comfortable modern couch.',
            'description_es' => 'Sofá moderno y cómodo.',
            'price' => 499.99,
            'image' => 'images/products/couch.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Cupboard',
            'name_es' => 'Alacena',
            'description' => 'Spacious modern cupboard.',
            'description_es' => 'Alacena moderna y espaciosa.',
            'price' => 199.99,
            'image' => 'images/products/cupboard.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Rice Cooker',
            'name_es' => 'Olla arrocera',
            'description' => 'Digital rice cooker.',
            'description_es' => 'Olla arrocera digital.',
            'price' => 79.99,
            'image' => 'images/products/digital-rice-cooker.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Desk Lamp',
            'name_es' => 'Lámpara de escritorio',
            'description' => 'LED desk lamp.',
            'description_es' => 'Lámpara de escritorio LED.',
            'price' => 29.99,
            'image' => 'images/products/lamp.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Refrigerator',
            'name_es' => 'Refrigerador',
            'description' => 'Large capacity refrigerator.',
            'description_es' => 'Refrigerador de gran capacidad.',
            'price' => 545.00,
            'old_price' => 629.99,
            'image' => 'images/products/refrigerator.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Vacuum Cleaner',
            'name_es' => 'Aspiradora',
            'description' => 'High power vacuum cleaner.',
            'description_es' => 'Aspiradora de alta potencia.',
            'price' => 129.99,
            'image' => 'images/products/vacuum-cleaner.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Thermos Bottle',
            'name_es' => 'Botella térmica',
            'description' => 'Stainless steel thermos bottle.',
            'description_es' => 'Botella térmica de acero inoxidable.',
            'price' => 22.99,
            'image' => 'images/products/water-bottle.png',
            'category' => 'home',
        ]);

        Product::create([
            'name' => 'Blue T-Shirt',
            'name_es' => 'Camiseta azul',
            'description' => 'Soft cotton t-shirt.',
            'description_es' => 'Camiseta de algodón suave.',
            'price' => 19.99,
            'image' => 'images/products/blue-tshirt.jpg',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Bracelet',
            'name_es' => 'Brazalete',
            'description' => 'Elegant minimalist bracelet.',
            'description_es' => 'Brazalete minimalista y elegante.',
            'price' => 24.99,
            'image' => 'images/products/bracelet.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Denim Jacket',
            'name_es' => 'Chaqueta vaquera',
            'description' => 'Classic denim jacket.',
            'description_es' => 'Chaqueta vaquera clásica.',
            'price' => 69.99,
            'image' => 'images/products/denim-jacket.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Denim Pants',
            'name_es' => 'Pantalón vaquero',
            'description' => 'Comfortable slim-fit denim pants.',
            'description_es' => 'Pantalón vaquero slim-fit cómodo.',
            'price' => 49.99,
            'image' => 'images/products/denim-pants.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Sweatshirt',
            'name_es' => 'Sudadera',
            'description' => 'Warm and comfortable sweatshirt.',
            'description_es' => 'Sudadera cálida y cómoda.',
            'price' => 34.99,
            'image' => 'images/products/grey-sweatshirt.jpeg',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Red Cap',
            'name_es' => 'Gorra roja',
            'description' => 'Stylish red cap.',
            'description_es' => 'Gorra roja con estilo.',
            'price' => 12.99,
            'image' => 'images/products/red-cap.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Running Shoes',
            'name_es' => 'Zapatillas de running',
            'description' => 'Lightweight running shoes.',
            'description_es' => 'Zapatillas de running ligeras.',
            'price' => 89.99,
            'image' => 'images/products/running-shoes.jpeg',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Sandals',
            'name_es' => 'Sandalias',
            'description' => 'Comfortable everyday sandals.',
            'description_es' => 'Sandalias cómodas para el día a día.',
            'price' => 29.99,
            'image' => 'images/products/sandals.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Backpack',
            'name_es' => 'Mochila',
            'description' => 'Durable backpack with compartments.',
            'description_es' => 'Mochila resistente con compartimentos.',
            'price' => 39.99,
            'image' => 'images/products/school-backpack.jpeg',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Sport Shorts',
            'name_es' => 'Pantalón corto deportivo',
            'description' => 'Breathable sport shorts.',
            'description_es' => 'Pantalón corto deportivo transpirable.',
            'price' => 19.99,
            'image' => 'images/products/sports-shorts.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Suitcase',
            'name_es' => 'Maleta',
            'description' => 'Durable travel suitcase.',
            'description_es' => 'Maleta de viaje resistente.',
            'price' => 119.99,
            'image' => 'images/products/suitcase.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Perfume',
            'name_es' => 'Perfume',
            'description' => 'Elegant long-lasting fragrance.',
            'description_es' => 'Fragancia elegante y duradera.',
            'price' => 79.99,
            'image' => 'images/products/valentino.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'Winter Hat',
            'name_es' => 'Gorro de invierno',
            'description' => 'Warm winter hat.',
            'description_es' => 'Gorro de invierno abrigador.',
            'price' => 14.99,
            'image' => 'images/products/winter-hat.png',
            'category' => 'fashion',
        ]);

        Product::create([
            'name' => 'iPhone 17 Pro Max',
            'name_es' => 'iPhone 17 Pro Max',
            'description' => 'iPhone 17 Pro Max 256GB Silver.',
            'description_es' => 'iPhone 17 Pro Max 256GB Plateado.',
            'price' => 1049.00,
            'old_price' => 1149.00,
            'brand' => 'Apple',
            'image' => 'images/products/iphone-17-pro-max.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'MacBook Air 13 inch',
            'name_es' => 'MacBook Air 13 pulgadas',
            'description' => 'Apple 2025 MacBook Air 13-inch Laptop with M4 chip: Built for Apple Intelligence.',
            'description_es' => 'Portátil Apple 2025 MacBook Air de 13 pulgadas con chip M4: diseñado para Apple Intelligence.',
            'price' => 1100.00,
            'old_price' => 1199.00,
            'brand' => 'Apple',
            'image' => 'images/products/macbook-air.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'AirPods Pro',
            'name_es' => 'AirPods Pro',
            'description' => 'AirPods Pro with noise cancellation and wireless charging case.',
            'description_es' => 'AirPods Pro con cancelación de ruido y funda de carga inalámbrica.',
            'price' => 239.00,
            'old_price' => 269.00,
            'brand' => 'Apple, headphones',
            'image' => 'images/products/airpods.png',
            'category' => 'tech',
        ]);

        Product::create([
            'name' => 'JBL Tune 670NC',
            'name_es' => 'JBL Tune 670NC',
            'description' => 'Lightness, comfort, and great sound. With the JBL Tune 670NC Adaptive Noise Cancelling wireless headphones.',
            'description_es' => 'Ligereza, comodidad y gran sonido. Con los auriculares inalámbricos JBL Tune 670NC con cancelación adaptativa de ruido.',
            'price' => 59.99,
            'old_price' => 79.00,
            'brand' => 'headphones',
            'image' => 'images/products/jbl-tune.png',
            'category' => 'tech',
        ]);
    }
}
