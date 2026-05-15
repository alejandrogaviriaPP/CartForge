#!/bin/bash

echo "🚀 Starting XAMPP..."
sudo /opt/lampp/lampp start

echo "🔥 Starting Laravel server..."
php artisan serve > /dev/null 2>&1 &

echo "⚡ Starting Vite..."
npm run dev > /dev/null 2>&1 &

echo "✅ Ecommerce environment started!"
