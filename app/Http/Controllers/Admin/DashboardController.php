<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'revenue' => Order::whereIn('status', ['paid', 'shipped', 'delivered'])->sum('total'),
            'pending' => Order::where('status', 'pending')->count(),
            'users' => User::count(),
        ];

        $latestOrders = Order::with('user:id,name')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestOrders'));
    }
}
