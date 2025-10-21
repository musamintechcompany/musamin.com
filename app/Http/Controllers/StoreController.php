<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        // Temporarily less restrictive for debugging
        $stores = Store::where('is_active', true)
            ->whereHas('user.affiliate', function($query) {
                $query->where('status', 'active')->where('expires_at', '>', now());
            })
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('stores.index', compact('stores'));
    }

    public function show(string $handle)
    {
        $store = Store::where('handle', $handle)
            ->active()
            ->whereHas('user.affiliate', function($query) {
                $query->where('status', 'active')->where('expires_at', '>', now());
            })
            ->with(['user', 'products' => function($query) {
                $query->active()->latest();
            }])
            ->firstOrFail();

        // Increment visits only once per session
        $sessionKey = 'visited_store_' . $store->id;
        if (!session()->has($sessionKey)) {
            $store->increment('visits_count');
            session()->put($sessionKey, true);
        }

        return view('stores.show', compact('store'));
    }

    public function create()
    {
        return view('affiliate.store.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
        ]);

        $store = Store::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
        ]);

        return redirect()->route('affiliate.store.index')
            ->with('success', 'Store created successfully! Your store URL is: ' . $store->url);
    }

    public function showProduct(string $handle, string $productId)
    {
        $store = Store::where('handle', $handle)
            ->active()
            ->whereHas('user.affiliate', function($query) {
                $query->where('status', 'active')->where('expires_at', '>', now());
            })
            ->with('user')
            ->firstOrFail();

        $product = $store->products()
            ->where('id', $productId)
            ->active()
            ->firstOrFail();

        // Get related products from same store
        $relatedProducts = $store->products()
            ->where('id', '!=', $productId)
            ->active()
            ->limit(4)
            ->get();

        return view('stores.products.show', compact('store', 'product', 'relatedProducts'));
    }
}