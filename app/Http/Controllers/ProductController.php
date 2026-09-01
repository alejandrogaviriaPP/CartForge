<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function information()
    {
        $products = Product::query()
            ->where('stock', '>', 0)
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->latest('id')
            ->take(8)
            ->get();

        return view('products.index', ['products' => $products, 'home' => true]);
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $nameCol = app()->isLocale('es') ? 'name_es' : 'name';

            $query->where(function ($q) use ($request, $nameCol) {
                $q->where($nameCol, 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
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

        $products = $query->withCount('ratings')->withAvg('ratings', 'rating')->get();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load(['ratings.user']);

        $distribution = $product->ratings
            ->groupBy('rating')
            ->map(fn($group) => $group->count())
            ->sortKeysDesc();

        $userRating = null;

        if (auth()->check()) {
            $userRating = $product->ratings
                ->firstWhere('user_id', auth()->id());
        }

        $average = round((float) $product->ratings->avg('rating'), 1);
        $count = $product->ratings->count();

        $ratingBreakdown = [];

        foreach (range(5, 1) as $star) {
            $starCount = $distribution[$star] ?? 0;
            $ratingBreakdown[$star] = [
                'count' => $starCount,
                'percentage' => $count > 0 ? round(($starCount / $count) * 100) : 0,
            ];
        }

        $related = Product::query()
            ->where('id', '!=', $product->id)
            ->when(
                $product->category,
                fn($query) => $query->where('category', $product->category)->orWhere('brand', $product->brand)
            )
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $images = $product->gallery_images;

        return view('products.show', compact(
            'product',
            'userRating',
            'average',
            'count',
            'ratingBreakdown',
            'related',
            'images',
        ));
    }

    public function reviews(Product $product)
    {
        $reviews = $product->ratings()
            ->with('user')
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($rating) {
                return [
                    'id' => $rating->id,
                    'name' => $rating->user?->name ?? '—',
                    'initial' => strtoupper(substr($rating->user?->name ?? '?', 0, 1)),
                    'rating' => $rating->rating,
                    'comment' => $rating->comment,
                    'time' => $rating->updated_at->diffForHumans(),
                ];
            });

        return response()->json([
            'reviews' => $reviews,
        ]);
    }

    public function rate(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $rating = Rating::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        $average = round((float) $product->ratings()->avg('rating'), 1);
        $count = $product->ratings()->count();

        return response()->json([
            'success' => true,
            'average' => $average,
            'count' => $count,
            'user_rating' => $rating->rating,
            'comment' => $rating->comment,
        ]);
    }
}
