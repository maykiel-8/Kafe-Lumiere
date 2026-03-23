<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::with(['category', 'photos', 'addons'])
            ->where('is_available', true)
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->filled('min_price'), fn($q) => $q->where('price_tall', '>=', $request->min_price))
            ->when($request->filled('max_price'), fn($q) => $q->where('price_tall', '<=', $request->max_price))
            ->latest()
            ->paginate(12);

        $maxProductPrice = Product::where('is_available', true)->max('price_tall') ?? 300;
        $maxProductPrice = ceil($maxProductPrice / 50) * 50; // round up to nearest 50
        return view('home', compact('products', 'categories', 'maxProductPrice'));
    }

    /**
     * MP8 — Search using Laravel Scout (model search)
     * Falls back to LIKE query if Scout not configured.
     */
    public function search(Request $request)
    {
        $request->validate(['q' => ['required', 'string', 'max:100']]);
        $query = $request->q;

        try {
            // Laravel Scout search (Meilisearch/Algolia)
            $products = Product::search($query)
                ->query(fn($q) => $q->with(['category', 'photos', 'addons'])->where('is_available', true))
                ->paginate(12)
                ->withQueryString();
        } catch (\Exception $e) {
            // Fallback: LIKE query
            $products = Product::with(['category', 'photos', 'addons'])
                ->where('is_available', true)
                ->where(fn($q) => $q
                    ->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$query}%"))
                )
                ->paginate(12)
                ->withQueryString();
        }

        $categories      = Category::all();
        $maxProductPrice = Product::where('is_available', true)->max('price_tall') ?? 300;
        $maxProductPrice = ceil($maxProductPrice / 50) * 50;
        return view('home', compact('products', 'categories', 'query', 'maxProductPrice'));
    }
}