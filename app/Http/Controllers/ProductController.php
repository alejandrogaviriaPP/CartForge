<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function information()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        Product::create($request->all());

        return redirect('/products');
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->price) {
            if ($request->price === 'low') {
                $query->where('price', '<', 50);
            } elseif ($request->price === 'mid') {
                $query->whereBetween('price', [50, 100]);
            } elseif ($request->price === 'high') {
                $query->where('price', '>', 100);
            }
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }
}
