<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

use App\Http\Controllers\CoinPackageController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CoinTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;

// Guest routes (login/register)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    
    Route::post('/login', [LoginController::class, 'store']);
    Route::post('/register', [RegisterController::class, 'store']);
    
    Route::get('/two-factor-challenge', function () {
        return view('auth.two-factor-challenge');
    })->name('two-factor.challenge');
    
    Route::post('/two-factor-challenge', [LoginController::class, 'twoFactorLogin'])->name('two-factor.login');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/', function () {
    return view('guest1-pages.home');
});

Route::get('/home', function () {
    return view('guest1-pages.home');
})->name('home');



Route::get('/how-it-works', function () {
    return view('guest1-pages.how-it-works');
})->name('how-it-works');

Route::get('/testimonials', function () {
    return view('guest1-pages.testimonials');
})->name('testimonials');

Route::get('/contact', function () {
    return view('guest1-pages.contact');
})->name('contact');

Route::get('/affiliate', function () {
    return view('guest1-pages.affiliate');
})->name('affiliate');

// Terms and Policy routes
Route::get('/terms', function () {
    return view('terms');
})->name('terms.show');

Route::get('/policy', function () {
    return view('policy');
})->name('policy.show');

// Public Marketplace routes (no auth required)
Route::get('/market-place', function () {
    return view('market-place.index');
})->name('market-place.index');

Route::get('/market-place/details', function () {
    return view('market-place.details');
})->name('market-place.details');

// Public Software routes (no auth required)
Route::get('/softwares', function () {
    return view('softwares.index');
})->name('softwares.index');

Route::get('/softwares/details', function () {
    return view('softwares.details');
})->name('softwares.details');

Route::middleware([
    'auth',
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Coin Packages
    Route::get('/coin-packages', [CoinPackageController::class, 'index'])
        ->name('coin-packages.index');
    Route::get('/coin-packages/data', [CoinPackageController::class, 'getData'])
        ->name('coin-packages.data');

    // Payment Methods
    Route::prefix('payment-methods')->group(function () {
        Route::get('/manual', [PaymentMethodController::class, 'getManualMethods'])
            ->name('payment.methods.manual');
        Route::get('/data', [PaymentMethodController::class, 'getData'])
            ->name('payment-methods.data');
    });

    // User Address Update
    Route::post('/user/update-address', [UserController::class, 'updateAddress'])
        ->name('user.update-address');

    // User Coin Balance
    Route::get('/user/coin-balance', [UserController::class, 'getCoinBalance'])
        ->name('user.coin-balance');

    // Coin Transactions
    Route::prefix('coin-transactions')->group(function () {
        Route::post('/submit', [CoinTransactionController::class, 'submit'])
            ->name('coin-transaction.submit');
        Route::post('/complete', [CoinTransactionController::class, 'complete'])
            ->name('coin-transaction.complete');
    });

    // Coin Transfers
    Route::prefix('coin-transfers')->group(function () {
        Route::post('/internal', [App\Http\Controllers\CoinTransferController::class, 'internal'])
            ->name('coin-transfer.internal');
        Route::post('/external', [App\Http\Controllers\CoinTransferController::class, 'external'])
            ->name('coin-transfer.external');
        Route::get('/fees', [App\Http\Controllers\CoinTransferController::class, 'getFees'])
            ->name('coin-transfer.fees');
        Route::get('/validate-wallet', [App\Http\Controllers\CoinTransferController::class, 'validateWallet'])
            ->name('coin-transfer.validate-wallet');
    });

    // Withdrawals
    Route::prefix('withdrawals')->group(function () {
        Route::post('/submit', [App\Http\Controllers\WithdrawalController::class, 'submit'])
            ->name('withdrawal.submit');
        Route::get('/fees', [App\Http\Controllers\WithdrawalController::class, 'getFees'])
            ->name('withdrawal.fees');
        Route::get('/bank-accounts', [App\Http\Controllers\WithdrawalController::class, 'getBankAccounts'])
            ->name('withdrawal.bank-accounts');
    });

    // Delivery Details
    Route::prefix('delivery-details')->group(function () {
        Route::get('/', [App\Http\Controllers\DeliveryDetailController::class, 'index'])
            ->name('delivery-details.index');
        Route::post('/', [App\Http\Controllers\DeliveryDetailController::class, 'store'])
            ->name('delivery-details.store');
        Route::get('/{deliveryDetail}', [App\Http\Controllers\DeliveryDetailController::class, 'show'])
            ->name('delivery-details.show');
        Route::put('/{deliveryDetail}', [App\Http\Controllers\DeliveryDetailController::class, 'update'])
            ->name('delivery-details.update');
        Route::delete('/{deliveryDetail}', [App\Http\Controllers\DeliveryDetailController::class, 'destroy'])
            ->name('delivery-details.destroy');
        Route::post('/{deliveryDetail}/set-default', [App\Http\Controllers\DeliveryDetailController::class, 'setDefault'])
            ->name('delivery-details.set-default');
    });

    // Stores
    Route::get('/stores', [App\Http\Controllers\StoreController::class, 'index'])
        ->name('stores');
    Route::get('/stores/create', [App\Http\Controllers\StoreController::class, 'create'])
        ->name('stores.create');
    Route::post('/stores', [App\Http\Controllers\StoreController::class, 'store'])
        ->name('stores.store');

    // Wallets
    Route::get('/wallet', function () {
        return view('wallets.index');
    })->name('wallet');

    // Orders (Unified)
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'view'])
        ->name('orders.view');
    Route::get('/orders/{order}/download/{itemIndex}', [OrderController::class, 'downloadDigitalFiles'])
        ->name('orders.download')
        ->where('itemIndex', '[0-9]+');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])
        ->name('orders.cancel');
    Route::post('/orders/{order}/bulk-action', [OrderController::class, 'bulkAction'])
        ->name('orders.bulk-action');
    Route::post('/orders/{order}/product-action', [OrderController::class, 'productAction'])
        ->name('orders.product-action');

    // Store Orders (for store owners)
    Route::prefix('store/orders')->group(function () {
        Route::get('/', [App\Http\Controllers\OrderController::class, 'storeOrders'])
            ->name('store.orders.index');
        Route::get('/{order}', [App\Http\Controllers\OrderController::class, 'storeOrderShow'])
            ->name('store.orders.show');
        Route::post('/{order}/shipped', [App\Http\Controllers\OrderController::class, 'markAsShipped'])
            ->name('store.orders.shipped');
        Route::post('/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])
            ->name('store.orders.status');
    });



    // Ideas
    Route::get('/ideas', [IdeaController::class, 'index'])
        ->name('ideas.index');
    Route::post('/ideas', [IdeaController::class, 'store'])
        ->name('ideas.store');

    // Marketplace and software routes moved to public section



    // Support (authenticated)
    Route::get('/support', function () {
        return view('support.index');
    })->name('support.index');



    // Profile Details
    Route::get('/profile/details', function () {
        return view('profile.view-profile-details');
    })->name('profile.details');
    
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');



    // Password Change
    Route::post('/password/send-code', [App\Http\Controllers\PasswordChangeController::class, 'sendCode'])
        ->name('password.send-code');
    Route::post('/password/verify-change', [App\Http\Controllers\PasswordChangeController::class, 'verifyAndChange'])
        ->name('password.verify-change');







    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', function () {
            return view('settings.index');
        })->name('settings');



        Route::get('/rates', function () {
            return view('settings.rates.index');
        })->name('settings.rates');

        Route::get('/rates/calculator', function () {
            $settings = \App\Models\Setting::getSettings();
            return view('settings.rates.rate-caculator', compact('settings'));
        })->name('settings.rates.calculator');

        Route::get('/account', function () {
            return view('settings.account');
        })->name('settings.account');

        Route::get('/security', function () {
            return view('settings.security');
        })->name('settings.security');

        Route::get('/appearance', function () {
            return view('settings.appearance.index');
        })->name('settings.appearance');

        Route::get('/kyc', function () {
            return view('settings.kyc.index');
        })->name('settings.kyc');

        Route::get('/kyc/identity', [App\Http\Controllers\KycController::class, 'identity'])
            ->name('settings.kyc.identity');

        Route::get('/kyc/address-info', function () {
            return view('settings.kyc.address-info');
        })->name('settings.kyc.address-info');

        Route::post('/kyc', [App\Http\Controllers\KycController::class, 'store'])
            ->name('settings.kyc.store');

        Route::get('/withdrawal-bank', function () {
            return view('settings.withdrawal-bank');
        })->name('settings.withdrawal-bank');

        Route::post('/withdrawal-bank', [App\Http\Controllers\UserController::class, 'updateWithdrawalDetails'])
            ->name('settings.withdrawal-bank.update');
    });
    // Theme Management
    Route::post('/user/theme', [UserController::class, 'updateTheme'])
        ->name('user.theme.update');

    // Phone Verification
    Route::post('/user/phone/send-verification', [UserController::class, 'sendPhoneVerification'])
        ->name('user.phone.send-verification');
    Route::post('/user/phone/verify', [UserController::class, 'verifyPhone'])
        ->name('user.phone.verify');

    // Name Update
    Route::post('/user/name', [UserController::class, 'updateName'])
        ->name('name.update');
        
    // Username Update
    Route::post('/user/username', [UserController::class, 'updateUsername'])
        ->name('username.update');
        

    // Phone Update
    Route::post('/user/phone', [UserController::class, 'updatePhone'])
        ->name('user.update-phone');
        
    // Phone Verification
    Route::post('/user/phone/verify', [UserController::class, 'verifyPhone'])
        ->name('user.verify-phone');
        
    // Currency Update
    Route::post('/user/currency', [UserController::class, 'updateCurrency'])
        ->name('user.update-currency');
        
    // Date of Birth Update
    Route::post('/user/date-of-birth', [UserController::class, 'updateDateOfBirth'])
        ->name('user.update-date-of-birth');

    // Two-Factor Authentication
    Route::post('/user/two-factor/enable', [UserController::class, 'enableTwoFactor'])
        ->name('two-factor.enable');
    Route::post('/user/two-factor/confirm', [UserController::class, 'confirmTwoFactor'])
        ->name('two-factor.confirm');
    Route::post('/user/two-factor/disable', [UserController::class, 'disableTwoFactor'])
        ->name('two-factor.disable');
    Route::get('/user/two-factor/recovery-codes', [UserController::class, 'showRecoveryCodes'])
        ->name('two-factor.recovery-codes');
    Route::post('/user/two-factor/recovery-codes', [UserController::class, 'regenerateRecoveryCodes'])
        ->name('two-factor.recovery-codes.regenerate');

    // Browser Sessions
    Route::post('/user/logout-other-sessions', [UserController::class, 'logoutOtherSessions'])
        ->name('logout-other-sessions');
    
    // Profile Photo
    Route::post('/user/profile-photo', [UserController::class, 'updateProfilePhoto'])
        ->name('user.profile-photo.update');
    Route::delete('/user/profile-photo', [UserController::class, 'removeProfilePhoto'])
        ->name('user.profile-photo.remove');
    
    // Delete Account
    Route::delete('/user/delete-account', [UserController::class, 'deleteAccount'])
        ->name('delete-account');

    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])
            ->name('notifications.index');
        Route::get('/unread', [App\Http\Controllers\NotificationController::class, 'getUnread'])
            ->name('notifications.unread');
        Route::post('/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
        Route::post('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
            ->name('notifications.mark-all-read');
    });

    // Inbox/Chat Routes
    Route::get('/inbox', [App\Http\Controllers\ChatController::class, 'index'])
        ->name('inbox.index');
    Route::get('/inbox/unread/count', [App\Http\Controllers\ChatController::class, 'getUnreadCount'])
        ->name('inbox.unread.count');
    Route::get('/inbox/{conversationId}', [App\Http\Controllers\ChatController::class, 'index'])
        ->name('inbox.conversation');
    Route::get('/inbox/{conversationId}/data', [App\Http\Controllers\ChatController::class, 'getConversationData'])
        ->name('inbox.conversation.data');
    Route::post('/inbox/{conversationId}/messages', [App\Http\Controllers\ChatController::class, 'sendMessage'])
        ->name('inbox.send-message');
    
    // Chat API Routes
    Route::get('/api/conversations', [App\Http\Controllers\ChatController::class, 'getConversationsApi'])
        ->name('api.conversations');
    Route::get('/api/conversations/{conversationId}/messages', [App\Http\Controllers\ChatController::class, 'getMessagesApi'])
        ->name('api.conversation.messages');
    
    // Emoji API Routes
    Route::get('/api/emojis/popular', [App\Http\Controllers\EmojiController::class, 'getPopular'])
        ->name('api.emojis.popular');
    Route::get('/api/emojis/search', [App\Http\Controllers\EmojiController::class, 'search'])
        ->name('api.emojis.search');
    Route::get('/api/emojis/categories', [App\Http\Controllers\EmojiController::class, 'getCategories'])
        ->name('api.emojis.categories');

    Route::post('/inbox/start-chat', [App\Http\Controllers\ChatController::class, 'startChat'])
        ->name('inbox.start-chat');
    Route::post('/inbox/{conversationId}/mark-read', [App\Http\Controllers\ChatController::class, 'markAsRead'])
        ->name('inbox.mark-read');
    Route::post('/inbox/block-user', [App\Http\Controllers\ChatController::class, 'blockUser'])
        ->name('inbox.block-user');
    Route::post('/inbox/unblock-user', [App\Http\Controllers\ChatController::class, 'unblockUser'])
        ->name('inbox.unblock-user');
    Route::post('/inbox/block-status', [App\Http\Controllers\ChatController::class, 'checkBlockStatus'])
        ->name('inbox.block-status');

    Route::delete('/inbox/{conversationId}', [App\Http\Controllers\ChatController::class, 'deleteConversation'])
        ->name('inbox.delete-conversation');

    // Follow System
    Route::post('/follow', [App\Http\Controllers\FollowController::class, 'follow'])
        ->name('follow');
    Route::post('/unfollow', [App\Http\Controllers\FollowController::class, 'unfollow'])
        ->name('unfollow');
    Route::get('/follow-status', [App\Http\Controllers\FollowController::class, 'status'])
        ->name('follow.status');
    Route::post('/follow-status', [App\Http\Controllers\FollowController::class, 'batchStatus'])
        ->name('follow.batch-status');








});

// Forgot Password routes (guest)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])
    ->name('password.request');
Route::post('/password/send-reset-code', [ForgotPasswordController::class, 'sendResetCode'])
    ->name('password.send-reset-code');
Route::post('/password/reset-with-code', [ForgotPasswordController::class, 'resetWithCode'])
    ->name('password.reset-with-code');

// Location Detection Route
Route::get('/api/location', [App\Http\Controllers\LocationController::class, 'detect'])
    ->name('api.location');

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])
        ->middleware('auth')
        ->name('cart.index');
    Route::post('/add', [App\Http\Controllers\CartController::class, 'add'])
        ->name('cart.add');
    Route::post('/update-quantity', [App\Http\Controllers\CartController::class, 'updateQuantity'])
        ->name('cart.update-quantity');
    Route::post('/remove', [App\Http\Controllers\CartController::class, 'remove'])
        ->name('cart.remove');
    Route::post('/clear', [App\Http\Controllers\CartController::class, 'clear'])
        ->name('cart.clear');
    Route::get('/count', [App\Http\Controllers\CartController::class, 'count'])
        ->name('cart.count');
    Route::post('/sync', [App\Http\Controllers\CartController::class, 'syncGuestCartToDatabase'])
        ->middleware('auth')
        ->name('cart.sync');
    Route::post('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])
        ->middleware('auth')
        ->name('cart.checkout');
});

Route::post('/email/verification-notification', function (Request $request) {
    $user = $request->user();
    $user->generateNewVerificationCode();
    $user->sendEmailVerificationNotification();

    if ($request->wantsJson()) {
        return response()->json(['message' => 'Verification code sent successfully']);
    }

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Email Change routes
Route::post('/email/change', [App\Http\Controllers\Auth\EmailVerificationController::class, 'initiateChange'])
    ->middleware(['auth'])
    ->name('email.change');
Route::post('/email/verify-change', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verifyChange'])
    ->middleware(['auth'])
    ->name('email.verify-change');

// Custom email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::post('/email/verify-code', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verifyCode'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.verify-code');



// Include affiliate routes
require __DIR__.'/affiliate.php';

// Broadcasting routes
Broadcast::routes(['middleware' => ['web', 'auth']]);
Broadcast::routes(['middleware' => ['web', 'admin'], 'prefix' => 'management/portal/admin', 'as' => 'admin.']);

// Dynamic store routes (must be last to avoid conflicts)
Route::get('/{handle}', [App\Http\Controllers\StoreController::class, 'show'])
    ->where('handle', '^@[a-zA-Z0-9]+$')
    ->name('store.show');

Route::get('/{handle}/product/{product}', [App\Http\Controllers\StoreController::class, 'showProduct'])
    ->where('handle', '^@[a-zA-Z0-9]+$')
    ->name('store.product.show');
