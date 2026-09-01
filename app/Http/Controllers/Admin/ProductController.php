<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . $request->search . '%';

                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', $term)
                        ->orWhere('name_es', 'like', $term)
                        ->orWhere('brand', 'like', $term)
                        ->orWhere('category', 'like', $term);
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product]);
    }

    public function store(ProductRequest $request)
    {
        Product::create($this->payload($request));

        return redirect()->route('admin.products.index')->with('success', __('Product created successfully.'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($this->payload($request, $product));

        return redirect()->route('admin.products.index')->with('success', __('Product updated successfully.'));
    }

    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'delta' => ['required', 'integer', 'between:-1000000,1000000'],
        ]);

        $product->update(['stock' => max(0, (int) $product->stock + $validated['delta'])]);

        return back()->with('success', __('Stock updated successfully.'));
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return redirect()->route('admin.products.index')->with('error', __('This product has orders and cannot be deleted.'));
        }

        $this->deleteImages($product);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('Product deleted successfully.'));
    }

    private function payload(ProductRequest $request, ?Product $product = null): array
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = 'storage/' . $request->file('image')->store('products', 'public');
        } elseif ($product) {
            $data['image'] = $product->image;
        }

        if ($request->hasFile('gallery')) {
            $data['gallery'] = array_map(
                fn ($file) => 'storage/' . $file->store('products', 'public'),
                $request->file('gallery')
            );
        } elseif ($product) {
            $data['gallery'] = $product->gallery ?? [];
        } else {
            $data['gallery'] = [];
        }

        return $data;
    }

    private function deleteImages(Product $product): void
    {
        $paths = array_merge([$product->image], $product->gallery ?? []);

        foreach ($paths as $path) {
            if (str_starts_with((string) $path, 'storage/')) {
                Storage::disk('public')->delete(substr($path, strlen('storage/')));
            }
        }
    }
}
