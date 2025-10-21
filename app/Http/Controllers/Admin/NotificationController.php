<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        
        // Get allowed notification types based on permissions
        $allowedTypes = [];
        if ($admin->hasPermissionTo('receive-user-registered-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\UserRegisteredNotification';
        }
        if ($admin->hasPermissionTo('receive-affiliate-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\UserJoinedAffiliateNotification';
            $allowedTypes[] = 'App\Notifications\Admin\UserRenewedAffiliateNotification';
        }
        if ($admin->hasPermissionTo('receive-coin-transaction-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\CoinTransactionNotification';
            $allowedTypes[] = 'App\Notifications\Admin\CoinTransactionPendingNotification';
        }
        if ($admin->hasPermissionTo('receive-kyc-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\KycSubmissionNotification';
        }
        if ($admin->hasPermissionTo('receive-idea-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\IdeaSubmittedNotification';
        }
        
        if (empty($allowedTypes)) {
            abort(403, 'Access denied');
        }
        
        $notifications = $admin->notifications()
            ->whereIn('type', $allowedTypes)
            ->paginate(20);
            
        return view('management.portal.admin.notifications.index', compact('notifications'));
    }

    public function getUnread()
    {
        $admin = Auth::guard('admin')->user();
        
        // Get allowed notification types
        $allowedTypes = [];
        if ($admin->hasPermissionTo('receive-user-registered-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\UserRegisteredNotification';
        }
        if ($admin->hasPermissionTo('receive-affiliate-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\UserJoinedAffiliateNotification';
            $allowedTypes[] = 'App\Notifications\Admin\UserRenewedAffiliateNotification';
        }
        if ($admin->hasPermissionTo('receive-coin-transaction-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\CoinTransactionNotification';
            $allowedTypes[] = 'App\Notifications\Admin\CoinTransactionPendingNotification';
        }
        if ($admin->hasPermissionTo('receive-kyc-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\KycSubmissionNotification';
        }
        if ($admin->hasPermissionTo('receive-idea-notifications') || !$admin->roles()->exists()) {
            $allowedTypes[] = 'App\Notifications\Admin\IdeaSubmittedNotification';
        }
        
        $notifications = $admin->unreadNotifications()
            ->whereIn('type', $allowedTypes)
            ->take(10)->get();
            
        $count = $admin->unreadNotifications()
            ->whereIn('type', $allowedTypes)
            ->count();
        
        return response()->json([
            'notifications' => $notifications,
            'count' => $count
        ]);
    }

    public function markAsRead($id)
    {
        $admin = Auth::guard('admin')->user();
        // Find and mark notification as read
        $notification = $admin->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $admin = Auth::guard('admin')->user();
        $admin->unreadNotifications()->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function clearAll()
    {
        $admin = Auth::guard('admin')->user();
        // Delete all notifications for this admin
        $admin->notifications()->delete();
        return response()->json(['success' => true]);
    }
}