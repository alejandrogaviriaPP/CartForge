#!/bin/bash

echo "🛑 Stopping Laravel..."
kill $(cat laravel.pid)

echo "🛑 Stopping Vite..."
kill $(cat vite.pid)

echo "🛑 Stopping XAMPP..."
sudo /opt/lampp/lampp stop

echo "✅ Everything stopped!"
