<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * Affiliate Controller
 * Handles affiliate program functionality including dashboard, joining, and payments
 */
class AffiliateController extends Controller
{
    /**
     * Display affiliate dashboard with stats
     * Only accessible to active affiliate members
     */
    public function dashboard(): View
    {
        $user = auth()->user();
        
        // Mock data - replace with real affiliate analytics from database
        $stats = [
            'total_clicks' => 1248,
            'conversions' => 84,
            'conversion_rate' => 6.73,
            'earnings' => 1284.50,
            'monthly_growth' => [
                'clicks' => 12.5,
                'conversions' => 8.3,
                'conversion_rate' => -1.2,
                'earnings' => 18.7
            ]
        ];
        
        return view('affiliate.dashboard', compact('stats'));
    }
    
    /**
     * Show affiliate program join page
     * Displays benefits and join button
     */
    public function join(): View
    {
        return view('affiliate.join-affiliate.join');
    }
    
    /**
     * Process affiliate program join request
     * Handles payment and membership activation via AJAX
     */
    public function joinPost(Request $request): JsonResponse
    {
        $user = auth()->user();
        
        // Validate plan type
        $validated = $request->validate([
            'plan_type' => 'required|in:monthly,yearly',
            'fee' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
        ]);
        
        $planType = $validated['plan_type'];
        
        // Check if user is already an active affiliate
        if ($user->isAffiliate()) {
            return response()->json([
                'success' => false,
                'message' => 'You are already an affiliate member!'
            ]);
        }
        
        // Check if this is a renewal (user has expired affiliate record)
        if ($user->affiliate && $user->affiliate->isExpired()) {
            $result = $user->renewAffiliate($planType);
            $message = $result['success'] ? 'Affiliate membership renewed successfully!' : $result['message'];
        } else {
            // New affiliate join
            $result = $user->becomeAffiliate($planType);
            $message = $result['success'] ? 'Welcome to our affiliate program!' : $result['message'];
        }
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('affiliate.dashboard')
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => $result['message']
        ]);
    }
    
    /**
     * Display Asset Manager page
     * Shows affiliate's assets for marketplace
     */
    public function assetManager(): View
    {
        return view('affiliate.asset-manager.index');
    }
    
    /**
     * Store new asset
     */
    public function storeAsset(Request $request): JsonResponse
    {
        // Asset creation logic will be implemented here
        return response()->json([
            'success' => true,
            'message' => 'Asset created successfully!'
        ]);
    }
    
    /**
     * Update existing asset
     */
    public function updateAsset(Request $request, $id): JsonResponse
    {
        // Asset update logic will be implemented here
        return response()->json([
            'success' => true,
            'message' => 'Asset updated successfully!'
        ]);
    }
    
    /**
     * Delete asset
     */
    public function deleteAsset($id): JsonResponse
    {
        // Asset deletion logic will be implemented here
        return response()->json([
            'success' => true,
            'message' => 'Asset deleted successfully!'
        ]);
    }
    
    /**
     * Display Store management page
     */
    public function storeIndex(): View
    {
        $user = auth()->user();
        $store = $user->store;
        
        if ($store) {
            // Load categories with product count
            $store->load(['categories' => function($query) {
                $query->withCount('products');
            }, 'products' => function($query) {
                $query->latest();
            }]);
        }
        
        return view('affiliate.store.index', compact('store'));
    }
    
    /**
     * Create new store
     */
    public function createStore(Request $request): JsonResponse
    {
        $user = auth()->user();
        
        // Check if user already has a store
        if ($user->store) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a store created.'
            ]);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'handle' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9]+$/',
            'description' => 'nullable|string|max:1000',
        ]);
        
        // Add @ prefix to handle if provided
        if (!empty($validated['handle'])) {
            $validated['handle'] = '@' . $validated['handle'];
            
            // Check if handle is unique
            if (\App\Models\Store::where('handle', $validated['handle'])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This handle is already taken. Please choose a different one.'
                ]);
            }
        }

        try {
            $store = \App\Models\Store::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'handle' => $validated['handle'] ?? null,
                'description' => $validated['description'] ?? null,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Store created successfully! Your store URL is: ' . $store->url,
                'store_url' => $store->url,
                'store' => $store
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            Log::error('Store creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create store. Please try again.'
            ]);
        }
    }
    
    /**
     * Update store settings
     */
    public function updateStore(Request $request): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'handle' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9]+$/',
            'description' => 'nullable|string|max:1000',
        ]);
        
        // Add @ prefix to handle if provided and check uniqueness
        if (!empty($validated['handle'])) {
            $validated['handle'] = '@' . $validated['handle'];
            
            // Check if handle is unique (excluding current store)
            if (\App\Models\Store::where('handle', $validated['handle'])->where('id', '!=', $store->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This handle is already taken. Please choose a different one.'
                ]);
            }
        }
        
        try {
            // Generate new slug if name changed
            if ($store->name !== $validated['name']) {
                $newSlug = $store->generateUniqueSlug($validated['name']);
                $validated['slug'] = $newSlug;
            }
            
            $store->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Store updated successfully!',
                'store_url' => $store->fresh()->url
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            Log::error('Store update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update store. Please try again.'
            ]);
        }
    }
    
    /**
     * Display My Code page
     */
    public function myCodeIndex(): View
    {
        return view('affiliate.my-code.index');
    }
    
    /**
     * Generate referral link
     */
    public function generateLink(Request $request): JsonResponse
    {
        // Link generation logic will be implemented here
        return response()->json([
            'success' => true,
            'message' => 'Referral link generated successfully!',
            'link' => 'https://musamin.com/ref/AF' . rand(100000, 999999)
        ]);
    }
    
    /**
     * Generate QR code
     */
    public function generateQR(Request $request): JsonResponse
    {
        // QR code generation logic will be implemented here
        return response()->json([
            'success' => true,
            'message' => 'QR code generated successfully!'
        ]);
    }
    
    /**
     * Display Orders page
     */
    public function ordersIndex(Request $request): View
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('affiliate.store.index')->with('error', 'Please create your store first.');
        }
        
        $status = $request->get('status', 'all');
        
        $baseQuery = \App\Models\Order::where('order_type', \App\Models\Order::ORDER_TYPE_STORE)
            ->whereJsonContains('order_data->store_id', $store->id);
        
        // Calculate counts for tabs
        $counts = [
            'all' => $baseQuery->count(),
            'active' => (clone $baseQuery)->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped'])->count(),
            'completed' => (clone $baseQuery)->whereIn('status', ['delivered', 'completed'])->count(),
            'cancelled' => (clone $baseQuery)->whereIn('status', ['cancelled', 'refunded'])->count(),
        ];
        
        $query = \App\Models\Order::where('order_type', \App\Models\Order::ORDER_TYPE_STORE)
            ->whereJsonContains('order_data->store_id', $store->id)
            ->with('user');
        
        if ($status === 'active') {
            $query->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped']);
        } elseif ($status === 'completed') {
            $query->whereIn('status', ['delivered', 'completed']);
        } elseif ($status === 'cancelled') {
            $query->whereIn('status', ['cancelled', 'refunded']);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('affiliate.orders.index', compact('orders', 'store', 'status', 'counts'));
    }
    
    /**
     * View order details
     */
    public function viewOrder($orderId): View
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            abort(404, 'Store not found');
        }
        
        $order = \App\Models\Order::where('order_type', \App\Models\Order::ORDER_TYPE_STORE)
            ->whereJsonContains('order_data->store_id', $store->id)
            ->with('user')
            ->findOrFail($orderId);
        
        return view('affiliate.orders.view', compact('order', 'store'));
    }
    
    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, $orderId): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json(['success' => false, 'message' => 'Store not found']);
        }
        
        $order = \App\Models\Order::where('order_type', \App\Models\Order::ORDER_TYPE_STORE)
            ->whereJsonContains('order_data->store_id', $store->id)
            ->findOrFail($orderId);
        
        // Check if order is digital-only (should not be editable)
        $items = collect($order->order_data['items'] ?? []);
        $isDigitalOnly = $items->every(function($item) {
            return ($item['product_snapshot']['type'] ?? 'physical') === 'digital';
        });
        
        if ($isDigitalOnly) {
            return response()->json(['success' => false, 'message' => 'Digital orders cannot be modified']);
        }
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered'
        ]);
        
        // Update order status
        $order->update(['status' => $request->status]);
        
        // Sync product statuses with order status (except already completed products)
        $orderData = $order->order_data;
        $items = $orderData['items'] ?? [];
        $updated = false;
        
        foreach ($items as $index => $item) {
            if (($item['product_snapshot']['type'] ?? 'physical') === 'physical') {
                $currentSellerStatus = $item['seller_status'] ?? 'pending';
                
                // Don't downgrade completed products unless order is being completed
                if ($currentSellerStatus === 'completed' && $request->status !== 'completed') {
                    continue;
                }
                
                $items[$index]['seller_status'] = $request->status;
                $updated = true;
            }
        }
        
        if ($updated) {
            $orderData['items'] = $items;
            $order->update(['order_data' => $orderData]);
        }
        
        // Check if coins should be transferred
        $this->checkAndTransferCoins($order);
        
        return response()->json(['success' => true, 'message' => 'Order status updated successfully']);
    }

    /**
     * Update individual product status
     */
    public function updateProductStatus(Request $request, $orderId): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json(['success' => false, 'message' => 'Store not found']);
        }
        
        $order = \App\Models\Order::where('order_type', \App\Models\Order::ORDER_TYPE_STORE)
            ->whereJsonContains('order_data->store_id', $store->id)
            ->findOrFail($orderId);
        
        $request->validate([
            'product_index' => 'required|integer|min:0',
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered'
        ]);
        
        $orderData = $order->order_data;
        $items = $orderData['items'] ?? [];
        $index = $request->product_index;
        
        if (!isset($items[$index])) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
        
        // Check if product is digital (should not be editable)
        if (($items[$index]['product_snapshot']['type'] ?? 'physical') === 'digital') {
            return response()->json(['success' => false, 'message' => 'Digital products cannot be modified']);
        }
        
        // Update product seller status
        $items[$index]['seller_status'] = $request->status;
        $orderData['items'] = $items;
        $order->update(['order_data' => $orderData]);
        
        // Check if all products are completed and both buyer/seller confirmed
        $this->checkAndTransferCoins($order);
        
        return response()->json(['success' => true, 'message' => 'Product status updated successfully']);
    }

    /**
     * Check if coins should be transferred based on product statuses
     */
    private function checkAndTransferCoins($order)
    {
        $items = collect($order->order_data['items'] ?? []);
        $physicalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'physical');
        
        if ($physicalItems->isEmpty()) {
            return; // No physical products to check
        }
        
        // Check if all physical products are completed by buyer (coins transfer on buyer completion only)
        $allBuyerCompleted = $physicalItems->every(function($item) {
            $buyerStatus = $item['buyer_status'] ?? 'pending';
            return $buyerStatus === 'completed';
        });
        
        if ($allBuyerCompleted) {
            // Update order status to completed
            $order->update(['status' => 'completed']);
            
            // Transfer coins from pending to earned
            $store = \App\Models\Store::find($order->order_data['store_id'] ?? null);
            if ($store && $store->user && $store->user->pending_earned_coins >= $order->total_coins_used) {
                $store->user->increment('earned_coins', $order->total_coins_used);
                $store->user->decrement('pending_earned_coins', $order->total_coins_used);
            }
        }
    }

    /**
     * Display Earnings page
     */
    public function earningsIndex(): View
    {
        return view('affiliate.earnings.index');
    }
    
    /**
     * Request payout
     */
    public function requestPayout(Request $request): JsonResponse
    {
        // Payout request logic will be implemented here
        return response()->json([
            'success' => true,
            'message' => 'Payout request submitted successfully!'
        ]);
    }
    
    /**
     * Add payment method
     */
    public function addPaymentMethod(Request $request): JsonResponse
    {
        // Payment method addition logic will be implemented here
        return response()->json([
            'success' => true,
            'message' => 'Payment method added successfully!'
        ]);
    }
    
    /**
     * Upload store images (logo and banner)
     */
    public function uploadImages(Request $request): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        
        try {
            $updateData = [];
            
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('stores/logos', 'public');
                $updateData['logo'] = '/storage/' . $logoPath;
            }
            
            if ($request->hasFile('banner')) {
                $bannerPath = $request->file('banner')->store('stores/banners', 'public');
                $updateData['banner'] = '/storage/' . $bannerPath;
            }
            
            if (!empty($updateData)) {
                $store->update($updateData);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Images uploaded successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Image upload failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload images. Please try again.'
            ]);
        }
    }
    
    /**
     * Get store products
     */
    public function getProducts(): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        $products = $store->products()->latest()->get();
        
        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }
    
    /**
     * Store new product
     */
    public function storeProduct(Request $request): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'list_price' => 'nullable|numeric|min:0',
            'type' => 'required|in:digital,physical',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
            'spec_keys.*' => 'nullable|string|max:255',
            'spec_values.*' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'digital_file' => 'nullable|file|max:10240', // 10MB max
        ]);
        
        try {
            // Handle specifications
            $specifications = null;
            if ($request->has('spec_keys') && $request->has('spec_values')) {
                $keys = array_filter($request->spec_keys ?? []);
                $values = array_filter($request->spec_values ?? []);
                if (count($keys) === count($values) && !empty($keys)) {
                    $specifications = array_combine($keys, $values);
                }
            }
            
            $productData = [
                'store_id' => $store->id,
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'list_price' => $validated['list_price'] ?? null,
                'category' => $validated['category'] ?? null,
                'type' => $validated['type'],
                'tags' => $validated['tags'] ? $this->parseHashtags($validated['tags']) : null,
                'stock_quantity' => $validated['type'] === 'physical' ? ($validated['stock_quantity'] ?? 0) : null,
                'specifications' => $specifications,
            ];
            
            // Handle image uploads
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products/images', 'public');
                    $imagePaths[] = '/storage/' . $path;
                }
                $productData['images'] = $imagePaths;
            }
            
            // Handle digital file upload
            if ($request->hasFile('digital_file') && $validated['type'] === 'digital') {
                $filePath = $request->file('digital_file')->store('products/files', 'public');
                $productData['file_path'] = '/storage/' . $filePath;
            }
            
            $product = \App\Models\StoreProduct::create($productData);
            
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product. Please try again.'
            ]);
        }
    }
    
    /**
     * Show edit product page
     */
    public function editProduct($product)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('affiliate.store.index')->with('error', 'Store not found.');
        }
        
        // Find product by UUID
        $product = $store->products()->where('id', $product)->firstOrFail();
        
        return view('affiliate.store.products.edit', compact('product'));
    }
    
    /**
     * Update product
     */
    public function updateProduct(Request $request, $product): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        $product = $store->products()->where('id', $product)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'list_price' => 'nullable|numeric|min:0',
            'type' => 'required|in:digital,physical',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'stock_quantity' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'spec_keys.*' => 'nullable|string|max:255',
            'spec_values.*' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'digital_file' => 'nullable|file|max:10240',
        ]);
        
        try {
            // Handle specifications
            $specifications = null;
            if ($request->has('spec_keys') && $request->has('spec_values')) {
                $keys = array_filter($request->spec_keys ?? []);
                $values = array_filter($request->spec_values ?? []);
                if (count($keys) === count($values) && !empty($keys)) {
                    $specifications = array_combine($keys, $values);
                }
            }
            
            $updateData = [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'list_price' => $validated['list_price'] ?? null,
                'category' => $validated['category'] ?? null,
                'type' => $validated['type'],
                'tags' => $validated['tags'] ? $this->parseHashtags($validated['tags']) : null,
                'stock_quantity' => $validated['type'] === 'physical' ? ($validated['stock_quantity'] ?? 0) : null,
                'is_active' => $request->boolean('is_active'),
                'specifications' => $specifications,
            ];
            
            // Handle image uploads
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products/images', 'public');
                    $imagePaths[] = '/storage/' . $path;
                }
                $updateData['images'] = $imagePaths;
            }
            
            // Handle digital file upload
            if ($request->hasFile('digital_file') && $validated['type'] === 'digital') {
                $filePath = $request->file('digital_file')->store('products/files', 'public');
                $updateData['file_path'] = '/storage/' . $filePath;
            }
            
            $product->update($updateData);
            
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product. Please try again.'
            ]);
        }
    }
    
    /**
     * Delete product
     */
    public function deleteProduct($product): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        $product = $store->products()->where('id', $product)->firstOrFail();
        $product->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!'
        ]);
    }
    
    /**
     * Display categories index page
     */
    public function categoriesIndex(): View
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('affiliate.store.index')->with('error', 'Store not found.');
        }
        
        $categories = $store->categories()->latest()->get();
        
        return view('affiliate.categories.index', compact('categories'));
    }
    
    /**
     * Get store categories
     */
    public function getCategories(): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        $categories = $store->categories()->where('is_active', true)->latest()->get();
        
        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
    
    /**
     * Store new category
     */
    public function storeCategory(Request $request)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->back()->with('error', 'Store not found.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);
        
        try {
            \App\Models\StoreCategory::create([
                'store_id' => $store->id,
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);
            
            return redirect()->route('affiliate.store.index')->with('success', 'Category added successfully!');
        } catch (\Exception $e) {
            Log::error('Category creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add category. Please try again.');
        }
    }
    
    /**
     * Delete category
     */
    public function deleteCategory($categoryId)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->back()->with('error', 'Store not found.');
        }
        
        $category = $store->categories()->findOrFail($categoryId);
        $category->delete();
        
        return redirect()->route('affiliate.store.index')->with('success', 'Category deleted successfully!');
    }
    
    /**
     * Get store stats (visits, products count, total sales)
     */
    public function getStoreStats(): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        // Calculate total sales from completed orders
        $totalSales = \App\Models\Order::where('order_type', \App\Models\Order::ORDER_TYPE_STORE)
            ->whereJsonContains('order_data->store_id', $store->id)
            ->where('payment_status', 'completed')
            ->sum('total_amount');
        
        $stats = [
            'visits_count' => $store->visits_count,
            'products_count' => $store->products()->count(),
            'active_products_count' => $store->products()->where('is_active', true)->count(),
            'total_sales' => $totalSales ?? 0,
        ];
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
    
    /**
     * Display Store Settings page
     */
    public function storeSettings(): View|\Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('stores')->with('error', 'Please create a store first.');
        }
        
        return view('affiliate.store.settings.index', compact('store'));
    }
    
    /**
     * Update shipping settings
     */
    public function updateShippingSettings(Request $request): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }
        
        $validated = $request->validate([
            'offers_shipping' => 'boolean',
            'default_shipping_cost' => 'nullable|numeric|min:0',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
        ]);
        
        $shippingSettings = [
            'offers_shipping' => $validated['offers_shipping'] ?? false,
            'default_cost' => $validated['default_shipping_cost'] ?? 0,
            'free_threshold' => $validated['free_shipping_threshold'] ?? null,
        ];
        
        $store->update(['shipping_settings' => $shippingSettings]);
        
        return response()->json([
            'success' => true,
            'message' => 'Shipping settings updated successfully!'
        ]);
    }
    
    /**
     * Get line chart data for affiliate dashboard
     */
    public function getLineChartData(Request $request): JsonResponse
    {
        $period = (int) $request->get('period', 30);
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json([
                'labels' => [],
                'visits' => []
            ]);
        }
        
        $labels = [];
        $visits = [];
        
        for ($i = $period - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M j');
            
            // Use real store visits count - since we don't have daily tracking yet,
            // show current total only for today, 0 for other days
            if ($i == 0) {
                $visits[] = $store->visits_count ?? 0;
            } else {
                $visits[] = 0;
            }
        }
        
        return response()->json([
            'labels' => $labels,
            'visits' => $visits
        ]);
    }
    
    /**
     * Parse hashtags from string
     */
    private function parseHashtags($input)
    {
        if (empty($input)) return null;
        
        // Extract hashtags using regex
        preg_match_all('/#([a-zA-Z0-9_]+)/', $input, $matches);
        
        return !empty($matches[1]) ? $matches[1] : null;
    }
}