<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\AssetController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Join affiliate program
    Route::get('/join-affiliate-program', [AffiliateController::class, 'join'])->name('affiliate.join');
    Route::post('/join-affiliate-program', [AffiliateController::class, 'joinPost'])->name('affiliate.join.post');
    
    // Affiliate dashboard (protected by affiliate middleware)
    Route::middleware('affiliate')->group(function () {
        Route::get('/affiliate-dashboard', [AffiliateController::class, 'dashboard'])->name('affiliate.dashboard');
        Route::get('/affiliate/dashboard/line-chart-data', [AffiliateController::class, 'getLineChartData'])->name('affiliate.dashboard.line-chart-data');
        
        // Asset Manager routes
        Route::prefix('assets')->name('affiliate.assets.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Affiliate\AssetController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Affiliate\AssetController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Affiliate\AssetController::class, 'store'])->name('store');
            Route::get('/{asset}', [\App\Http\Controllers\Affiliate\AssetController::class, 'show'])->name('show');
            Route::get('/{asset}/edit', [\App\Http\Controllers\Affiliate\AssetController::class, 'edit'])->name('edit');
            Route::put('/{asset}', [\App\Http\Controllers\Affiliate\AssetController::class, 'update'])->name('update');
            Route::delete('/{asset}', [\App\Http\Controllers\Affiliate\AssetController::class, 'destroy'])->name('destroy');
            Route::get('/categories/{category}/subcategories', [\App\Http\Controllers\Affiliate\AssetController::class, 'getSubcategories'])->name('subcategories');
        });
        
        // Legacy asset manager route (redirect to new route)
        Route::get('/asset-manager', function() {
            return redirect()->route('affiliate.assets.index');
        })->name('asset-manager.index');
        
        // Store routes
        Route::prefix('store')->name('affiliate.store.')->group(function () {
            Route::get('/', [AffiliateController::class, 'storeIndex'])->name('index');
            Route::get('/settings', [AffiliateController::class, 'storeSettings'])->name('settings');
            Route::get('/stats', [AffiliateController::class, 'getStoreStats'])->name('stats');
            Route::post('/create', [AffiliateController::class, 'createStore'])->name('create');
            Route::put('/update', [AffiliateController::class, 'updateStore'])->name('update');
            Route::post('/upload-images', [AffiliateController::class, 'uploadImages'])->name('upload-images');
            Route::post('/shipping-settings', [AffiliateController::class, 'updateShippingSettings'])->name('shipping-settings');
            
            // Product routes
            Route::prefix('products')->name('products.')->group(function () {
                Route::get('/', [AffiliateController::class, 'getProducts'])->name('index');
                Route::get('/create', function() { return view('affiliate.store.products.create'); })->name('create');
                Route::post('/', [AffiliateController::class, 'storeProduct'])->name('store');
                Route::get('/{product}/edit', [AffiliateController::class, 'editProduct'])->name('edit');
                Route::put('/{product}', [AffiliateController::class, 'updateProduct'])->name('update');
                Route::delete('/{product}', [AffiliateController::class, 'deleteProduct'])->name('destroy');
            });
            
            // Category routes
            Route::prefix('categories')->name('categories.')->group(function () {
                Route::get('/', [AffiliateController::class, 'categoriesIndex'])->name('index');
                Route::get('/api', [AffiliateController::class, 'getCategories'])->name('api');
                Route::post('/', [AffiliateController::class, 'storeCategory'])->name('store');
                Route::delete('/{category}', [AffiliateController::class, 'deleteCategory'])->name('destroy');
            });
        });
        
        // My Code routes
        Route::prefix('my-code')->name('affiliate.my-code.')->group(function () {
            Route::get('/', [AffiliateController::class, 'myCodeIndex'])->name('index');
            Route::post('/generate-link', [AffiliateController::class, 'generateLink'])->name('generate-link');
            Route::post('/generate-qr', [AffiliateController::class, 'generateQR'])->name('generate-qr');
        });
        
        // Orders routes
        Route::prefix('affiliate-orders')->name('affiliate.orders.')->group(function () {
            Route::get('/', [AffiliateController::class, 'ordersIndex'])->name('index');
            Route::get('/{order}', [AffiliateController::class, 'viewOrder'])->name('view');
            Route::post('/{order}/update-status', [AffiliateController::class, 'updateOrderStatus'])->name('update-status');
            Route::post('/{order}/update-product-status', [AffiliateController::class, 'updateProductStatus'])->name('update-product-status');
        });
        
        // Earnings routes
        Route::prefix('earnings')->name('affiliate.earnings.')->group(function () {
            Route::get('/', [AffiliateController::class, 'earningsIndex'])->name('index');
            Route::post('/request-payout', [AffiliateController::class, 'requestPayout'])->name('request-payout');
            Route::post('/add-payment-method', [AffiliateController::class, 'addPaymentMethod'])->name('add-payment-method');
        });
        
        // Notifications routes
        Route::prefix('affiliate-notifications')->name('affiliate.notifications.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Affiliate\NotificationController::class, 'index'])->name('index');
            Route::get('/unread', [\App\Http\Controllers\Affiliate\NotificationController::class, 'getUnread'])->name('unread');
            Route::post('/{id}/read', [\App\Http\Controllers\Affiliate\NotificationController::class, 'markAsRead'])->name('read');
            Route::post('/mark-all-read', [\App\Http\Controllers\Affiliate\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        });
    });
});