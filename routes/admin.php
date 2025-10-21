<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;

Route::prefix('management/portal/admin')->name('admin.')->group(function () {

    // Admin Authentication Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    });

    // Admin Protected Routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [\App\Http\Controllers\Admin\DashboardController::class, 'getStats'])->name('dashboard.stats');
        Route::get('/dashboard/widgets', [\App\Http\Controllers\Admin\DashboardController::class, 'getWidgetsData'])->name('dashboard.widgets');
        Route::get('/dashboard/line-chart-data', [\App\Http\Controllers\Admin\DashboardController::class, 'getLineChartData'])->name('dashboard.line-chart-data');
        Route::get('/dashboard/pie-chart-data', [\App\Http\Controllers\Admin\DashboardController::class, 'getPieChartData'])->name('dashboard.pie-chart-data');
        Route::get('/widgets/data', [\App\Http\Controllers\Admin\DashboardController::class, 'getWidgetsData'])->name('widgets.data');


        // Users Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->middleware('admin.permission:view-users')->name('index');
            Route::get('/stats', [\App\Http\Controllers\Admin\UserController::class, 'stats'])->middleware('admin.permission:view-users')->name('stats');
            Route::get('/widgets', [\App\Http\Controllers\Admin\UserController::class, 'getWidgetsData'])->middleware('admin.permission:view-users')->name('widgets');
            Route::get('/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->middleware('admin.permission:create-users')->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->middleware('admin.permission:create-users')->name('store');
            Route::get('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->middleware('admin.permission:view-users')->name('show');
            Route::get('/{user}/view', [\App\Http\Controllers\Admin\UserController::class, 'show'])->middleware('admin.permission:view-users')->name('view');
            Route::get('/{user}/view', [\App\Http\Controllers\Admin\UserController::class, 'view'])->middleware('admin.permission:view-users')->name('view');
            Route::get('/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->middleware('admin.permission:edit-users')->name('edit');
            Route::put('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->middleware('admin.permission:edit-users')->name('update');
            Route::delete('/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->middleware('admin.permission:delete-users')->name('destroy');
            Route::post('/{userId}/login-as', [\App\Http\Controllers\Admin\UserController::class, 'loginAsUser'])->middleware('admin.permission:edit-users')->name('login-as');
        });

        // KYC Management
        Route::prefix('kyc')->name('kyc.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\KycController::class, 'index'])->name('index');
            Route::get('/history', [\App\Http\Controllers\Admin\KycController::class, 'history'])->name('history');
            Route::get('/{kyc}/view', [\App\Http\Controllers\Admin\KycController::class, 'view'])->name('view');
            Route::post('/{kyc}/approve', [\App\Http\Controllers\Admin\KycController::class, 'approve'])->name('approve');
            Route::post('/{kyc}/reject', [\App\Http\Controllers\Admin\KycController::class, 'reject'])->name('reject');
            Route::get('/stats', [\App\Http\Controllers\Admin\KycController::class, 'stats'])->name('stats');
        });

        // Coin Packages Management
        Route::prefix('coin-packages')->name('coin-packages.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\CoinPackageController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\CoinPackageController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\CoinPackageController::class, 'store'])->name('store');
            Route::get('/{coinPackage}', [\App\Http\Controllers\Admin\CoinPackageController::class, 'show'])->name('show');
            Route::get('/{coinPackage}/edit', [\App\Http\Controllers\Admin\CoinPackageController::class, 'edit'])->name('edit');
            Route::put('/{coinPackage}', [\App\Http\Controllers\Admin\CoinPackageController::class, 'update'])->name('update');
            Route::delete('/{coinPackage}', [\App\Http\Controllers\Admin\CoinPackageController::class, 'destroy'])->name('destroy');
        });

        // Coin Transactions Management
        Route::prefix('coin-transactions')->name('coin-transactions.')->group(function () {
            Route::get('/pending', [\App\Http\Controllers\Admin\CoinTransactionController::class, 'pending'])->name('pending');
            Route::get('/pending-data', [\App\Http\Controllers\Admin\CoinTransactionController::class, 'pendingData'])->name('pending-data');
            Route::get('/history', [\App\Http\Controllers\Admin\CoinTransactionController::class, 'history'])->name('history');
            Route::get('/{coinTransaction}', [\App\Http\Controllers\Admin\CoinTransactionController::class, 'show'])->name('show');
            Route::put('/{coinTransaction}/approve', [\App\Http\Controllers\Admin\CoinTransactionController::class, 'approve'])->name('approve');
            Route::put('/{coinTransaction}/decline', [\App\Http\Controllers\Admin\CoinTransactionController::class, 'decline'])->name('decline');
        });

        // Payment Methods Management
        Route::prefix('payment-methods')->name('payment-methods.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'store'])->name('store');
            Route::get('/{paymentMethod}/edit', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'edit'])->name('edit');
            Route::put('/{paymentMethod}', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'update'])->name('update');
            Route::delete('/{paymentMethod}', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'destroy'])->name('destroy');
        });

        // Permissions Management
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->middleware('admin.permission:view-permissions')->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\PermissionController::class, 'create'])->middleware('admin.permission:create-permissions')->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\PermissionController::class, 'store'])->middleware('admin.permission:create-permissions')->name('store');
            Route::get('/{permission}', [\App\Http\Controllers\Admin\PermissionController::class, 'view'])->middleware('admin.permission:view-permissions')->name('view');
            Route::get('/{permission}/edit', [\App\Http\Controllers\Admin\PermissionController::class, 'edit'])->middleware('admin.permission:edit-permissions')->name('edit');
            Route::put('/{permission}', [\App\Http\Controllers\Admin\PermissionController::class, 'update'])->middleware('admin.permission:edit-permissions')->name('update');
            Route::delete('/{permission}', [\App\Http\Controllers\Admin\PermissionController::class, 'destroy'])->middleware('admin.permission:delete-permissions')->name('destroy');
            Route::get('/widgets', [\App\Http\Controllers\Admin\PermissionController::class, 'getWidgetsData'])->middleware('admin.permission:view-permissions')->name('widgets');
        });

        // Roles Management
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->middleware('admin.permission:view-roles')->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->middleware('admin.permission:create-roles')->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->middleware('admin.permission:create-roles')->name('store');
            Route::get('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'view'])->middleware('admin.permission:view-roles')->name('view');
            Route::get('/{role}/edit', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])->middleware('admin.permission:edit-roles')->name('edit');
            Route::put('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->middleware('admin.permission:edit-roles')->name('update');
            Route::delete('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->middleware('admin.permission:delete-roles')->name('destroy');
            Route::get('/widgets', [\App\Http\Controllers\Admin\RoleController::class, 'getWidgetsData'])->middleware('admin.permission:view-roles')->name('widgets');
        });

        // Admins Management
        Route::prefix('admins')->name('admins.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->middleware('admin.permission:view-admins')->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\AdminController::class, 'create'])->middleware('admin.permission:create-admins')->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\AdminController::class, 'store'])->middleware('admin.permission:create-admins')->name('store');
            Route::get('/{admin}', [\App\Http\Controllers\Admin\AdminController::class, 'view'])->middleware('admin.permission:view-admins')->name('view');
            Route::get('/{admin}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'edit'])->middleware('admin.permission:edit-admins')->name('edit');
            Route::put('/{admin}', [\App\Http\Controllers\Admin\AdminController::class, 'update'])->middleware('admin.permission:edit-admins')->name('update');
            Route::delete('/{admin}', [\App\Http\Controllers\Admin\AdminController::class, 'destroy'])->middleware('admin.permission:delete-admins')->name('destroy');
        });

        // Revenue Management
        Route::get('/revenue', [\App\Http\Controllers\Admin\RevenueController::class, 'index'])->middleware('admin.permission:view-revenue')->name('revenue.index');
        
        // System Wallet Management
        Route::get('/system-wallet', [\App\Http\Controllers\Admin\SystemWalletController::class, 'index'])->middleware('admin.permission:view-system-wallet')->name('system-wallet.index');
        
        // Platform Wallet Management
        Route::get('/platform-wallet', [\App\Http\Controllers\Admin\PlatformWalletController::class, 'index'])->middleware('admin.permission:view-platform-wallet')->name('platform-wallet.index');

        // Settings Management
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', function() { return redirect()->route('admin.settings.general'); });
            Route::get('/general', [\App\Http\Controllers\Admin\SettingsController::class, 'general'])->name('general');
            Route::get('/sms', [\App\Http\Controllers\Admin\SettingsController::class, 'sms'])->name('sms');
            Route::get('/finance', [\App\Http\Controllers\Admin\SettingsController::class, 'finance'])->name('finance');
            Route::put('/general', [\App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('general.update');
            Route::put('/sms', [\App\Http\Controllers\Admin\SettingsController::class, 'updateSms'])->name('sms.update');
            Route::put('/finance', [\App\Http\Controllers\Admin\SettingsController::class, 'updateFinance'])->name('finance.update');
        });

        // Profile Management
        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/theme', [\App\Http\Controllers\Admin\ProfileController::class, 'updateTheme'])->name('profile.theme.update');

        // Job Management
        Route::prefix('jobs')->name('jobs.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\JobController::class, 'jobs'])->name('index');
            Route::get('/batches', [\App\Http\Controllers\Admin\JobController::class, 'batches'])->name('batches');
            Route::get('/failed', [\App\Http\Controllers\Admin\JobController::class, 'failedJobs'])->name('failed');
            Route::post('/retry-all', [\App\Http\Controllers\Admin\JobController::class, 'retryFailedJobs'])->name('retry-all');
            Route::post('/retry/{id}', [\App\Http\Controllers\Admin\JobController::class, 'retryFailedJob'])->name('retry');
        });

        // Assets Management
        Route::prefix('assets')->name('assets.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AssetController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\AssetController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\AssetController::class, 'store'])->name('store');
            Route::get('/{asset}', [\App\Http\Controllers\Admin\AssetController::class, 'show'])->name('view');
            Route::get('/{asset}/edit', [\App\Http\Controllers\Admin\AssetController::class, 'edit'])->name('edit');
            Route::put('/{asset}', [\App\Http\Controllers\Admin\AssetController::class, 'update'])->name('update');
            Route::delete('/{asset}', [\App\Http\Controllers\Admin\AssetController::class, 'destroy'])->name('destroy');
            Route::post('/{asset}/inspect', [\App\Http\Controllers\Admin\AssetController::class, 'inspect'])->name('inspect');
            Route::post('/{asset}/toggle-marketplace', [\App\Http\Controllers\Admin\AssetController::class, 'toggleMarketplace'])->name('toggle-marketplace');
            Route::post('/{asset}/toggle-featured', [\App\Http\Controllers\Admin\AssetController::class, 'toggleFeatured'])->name('toggle-featured');
        });

        // Categories Management
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
            Route::get('/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('view');
            Route::get('/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('destroy');
        });

        // Subcategories Management
        Route::prefix('subcategories')->name('subcategories.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SubcategoryController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\SubcategoryController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\SubcategoryController::class, 'store'])->name('store');
            Route::get('/{subcategory}', [\App\Http\Controllers\Admin\SubcategoryController::class, 'show'])->name('view');
            Route::get('/{subcategory}/edit', [\App\Http\Controllers\Admin\SubcategoryController::class, 'edit'])->name('edit');
            Route::put('/{subcategory}', [\App\Http\Controllers\Admin\SubcategoryController::class, 'update'])->name('update');
            Route::delete('/{subcategory}', [\App\Http\Controllers\Admin\SubcategoryController::class, 'destroy'])->name('destroy');
        });

        // Tags Management
        Route::prefix('tags')->name('tags.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\TagController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\TagController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\TagController::class, 'store'])->name('store');
            Route::get('/{tag}', [\App\Http\Controllers\Admin\TagController::class, 'show'])->name('view');
            Route::get('/{tag}/edit', [\App\Http\Controllers\Admin\TagController::class, 'edit'])->name('edit');
            Route::put('/{tag}', [\App\Http\Controllers\Admin\TagController::class, 'update'])->name('update');
            Route::delete('/{tag}', [\App\Http\Controllers\Admin\TagController::class, 'destroy'])->name('destroy');
        });

        // Reviews Management
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('index');
            Route::get('/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'show'])->name('view');
            Route::delete('/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('destroy');
        });



        // Asset Media Management
        Route::prefix('asset-media')->name('asset-media.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AssetMediaController::class, 'index'])->name('index');
            Route::get('/{assetMedia}', [\App\Http\Controllers\Admin\AssetMediaController::class, 'show'])->name('view');
            Route::delete('/{assetMedia}', [\App\Http\Controllers\Admin\AssetMediaController::class, 'destroy'])->name('destroy');
        });

        // Asset Favorites Management
        Route::prefix('asset-favorites')->name('asset-favorites.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AssetFavoriteController::class, 'index'])->name('index');
            Route::delete('/{assetFavorite}', [\App\Http\Controllers\Admin\AssetFavoriteController::class, 'destroy'])->name('destroy');
        });

        // Stores Management
        Route::prefix('stores')->name('stores.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\StoreController::class, 'index'])->name('index');
            Route::get('/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'show'])->name('view');
            Route::delete('/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'destroy'])->name('destroy');
        });

        // Ideas Management
        Route::prefix('ideas')->name('ideas.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\IdeaController::class, 'index'])->name('index');
            Route::get('/{idea}', [\App\Http\Controllers\Admin\IdeaController::class, 'view'])->name('view');
            Route::patch('/{idea}/mark-seen', [\App\Http\Controllers\Admin\IdeaController::class, 'markSeen'])->name('mark-seen');
            Route::delete('/{idea}', [\App\Http\Controllers\Admin\IdeaController::class, 'destroy'])->name('destroy');
        });

        // Reserved Management
        Route::prefix('reserved')->name('reserved.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReservedController::class, 'index'])->name('index');
            Route::get('/{reserved}', [\App\Http\Controllers\Admin\ReservedController::class, 'show'])->name('view');
        });

        // Welcome Messages Management
        Route::prefix('welcomes')->name('welcomes.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\WelcomeController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\WelcomeController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\WelcomeController::class, 'store'])->name('store');
            Route::get('/{welcome}', [\App\Http\Controllers\Admin\WelcomeController::class, 'show'])->name('view');
            Route::get('/{welcome}/edit', [\App\Http\Controllers\Admin\WelcomeController::class, 'edit'])->name('edit');
            Route::put('/{welcome}', [\App\Http\Controllers\Admin\WelcomeController::class, 'update'])->name('update');
            Route::delete('/{welcome}', [\App\Http\Controllers\Admin\WelcomeController::class, 'destroy'])->name('destroy');
        });

        // Notifications Management
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('index');
            Route::get('/unread', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnread'])->name('unread');
            Route::post('/{id}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('read');
            Route::post('/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
            Route::post('/clear-all', [\App\Http\Controllers\Admin\NotificationController::class, 'clearAll'])->name('clear-all');
        });

        // Affiliates Management
        Route::prefix('affiliates')->name('affiliates.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AffiliateController::class, 'index'])->name('index');
            Route::get('/{affiliate}', [\App\Http\Controllers\Admin\AffiliateController::class, 'view'])->name('view');
        });

        // Countries Management
        Route::resource('countries', \App\Http\Controllers\Admin\CountryController::class);

        // States Management
        Route::resource('states', \App\Http\Controllers\Admin\StateController::class);
        
        // Currencies Management
        Route::resource('currencies', \App\Http\Controllers\Admin\CurrencyController::class);
        
        // Newsletter Subscriptions Management
        Route::resource('newsletter-subscriptions', \App\Http\Controllers\Admin\NewsletterSubscriptionController::class)->only(['index', 'show', 'destroy']);
        Route::patch('newsletter-subscriptions/{newsletterSubscription}/status', [\App\Http\Controllers\Admin\NewsletterSubscriptionController::class, 'updateStatus'])->name('newsletter-subscriptions.update-status');
        
        // Verification Badges Management
        Route::resource('verification-badges', \App\Http\Controllers\Admin\VerificationBadgeController::class);
        
        // Follows Management
        Route::resource('follows', \App\Http\Controllers\Admin\FollowController::class)->only(['index', 'show', 'destroy']);


        

        
        // Coin Manager
        Route::prefix('coin-manager')->name('coin-manager.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\CoinManagerController::class, 'index'])->name('index');
            Route::get('/search-users', [\App\Http\Controllers\Admin\CoinManagerController::class, 'searchUsers'])->name('search-users');
            Route::post('/update-coins', [\App\Http\Controllers\Admin\CoinManagerController::class, 'updateCoins'])->name('update-coins');
        });

        // Withdrawals Management
        Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('index');
            Route::get('/history', [\App\Http\Controllers\Admin\WithdrawalController::class, 'history'])->name('history');
            Route::get('/{withdrawal}', [\App\Http\Controllers\Admin\WithdrawalController::class, 'view'])->name('view');
            Route::post('/{withdrawal}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('approve');
            Route::post('/{withdrawal}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('reject');
        });

        
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
    
    // Impersonation route (outside admin middleware)
    Route::get('/impersonate/{token}', [\App\Http\Controllers\Admin\UserController::class, 'executeImpersonation'])->name('impersonate.login');
});

// Stop impersonation route
Route::get('/admin/stop-impersonation', [\App\Http\Controllers\Admin\UserController::class, 'stopImpersonation'])->name('admin.stop-impersonation');
Route::post('/admin/stop-impersonation', [\App\Http\Controllers\Admin\UserController::class, 'stopImpersonation']);
