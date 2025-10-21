<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $baseQuery = Order::where('user_id', Auth::id());
        
        // Calculate counts for tabs
        $counts = [
            'all' => $baseQuery->count(),
            'active' => (clone $baseQuery)->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped'])->count(),
            'completed' => (clone $baseQuery)->whereIn('status', ['delivered', 'completed'])->count(),
            'cancelled' => (clone $baseQuery)->whereIn('status', ['cancelled', 'refunded'])->count(),
        ];
        
        $query = Order::where('user_id', Auth::id());
        
        if ($status === 'active') {
            $query->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped']);
        } elseif ($status === 'completed') {
            $query->whereIn('status', ['delivered', 'completed']);
        } elseif ($status === 'cancelled') {
            $query->whereIn('status', ['cancelled', 'refunded']);
        }
        
        $orders = $query->latest()->paginate(20);
        
        return view('orders.index', compact('orders', 'status', 'counts'));
    }

    public function view(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.view', compact('order'));
    }

    public function downloadDigitalFiles($orderId, $itemIndex)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $items = $order->order_data['items'] ?? [];
        if (!isset($items[$itemIndex])) {
            abort(404, 'Item not found');
        }

        $item = $items[$itemIndex];
        if (!isset($item['product_snapshot']['type']) || $item['product_snapshot']['type'] !== 'digital') {
            abort(400, 'Not a digital product');
        }

        // Get digital files from snapshot first
        $digitalFiles = $item['product_snapshot']['digital_files'] ?? [];
        
        // Filter out null values and empty strings
        $digitalFiles = array_filter($digitalFiles, function($file) {
            return !empty($file);
        });
        
        // If no digital files in snapshot, try to get from original product
        if (empty($digitalFiles) && isset($item['product_id'])) {
            $product = \App\Models\StoreProduct::find($item['product_id']);
            if ($product && $product->file_path) {
                $digitalFiles = [$product->file_path];
            }
        }
        
        if (empty($digitalFiles)) {
            abort(404, 'No digital files found for this product');
        }

        // If single file, download directly
        if (count($digitalFiles) === 1) {
            // Remove /storage/ prefix if it exists
            $cleanPath = ltrim($digitalFiles[0], '/');
            if (str_starts_with($cleanPath, 'storage/')) {
                $cleanPath = substr($cleanPath, 8);
            }
            
            $filePath = storage_path('app/public/' . $cleanPath);
            if (!file_exists($filePath)) {
                abort(404, 'Digital file not found on server: ' . basename($digitalFiles[0]));
            }
            return response()->download($filePath);
        }

        // Multiple files - create zip
        $zip = new \ZipArchive();
        $zipFileName = 'digital_files_' . $order->order_number . '_item_' . ($itemIndex + 1) . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);
        
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            $filesAdded = 0;
            foreach ($digitalFiles as $file) {
                $filePath = storage_path('app/public/' . $file);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($file));
                    $filesAdded++;
                }
            }
            $zip->close();

            if ($filesAdded === 0) {
                abort(404, 'No digital files found on server');
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        abort(500, 'Could not create download file');
    }


    
    public function cancelOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        // Check if order is digital-only (cannot be cancelled if completed)
        $items = collect($order->order_data['items'] ?? []);
        $isDigitalOnly = $items->every(function($item) {
            return ($item['product_snapshot']['type'] ?? 'physical') === 'digital';
        });
        
        if ($isDigitalOnly && $order->status === 'completed') {
            return response()->json(['success' => false, 'message' => 'Digital orders cannot be cancelled after completion']);
        }
        
        // Only allow cancellation for pending/confirmed orders
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json(['success' => false, 'message' => 'Order cannot be cancelled at this stage']);
        }
        
        try {
            // Update order status to cancelled
            $order->update(['status' => 'cancelled']);
            
            // Refund coins to user
            $user = Auth::user();
            $user->increment('spendable_coins', $order->total_coins_used);
            
            // Remove pending coins from store owner if applicable
            if ($order->isStoreOrder() && isset($order->order_data['store_id'])) {
                $store = \App\Models\Store::find($order->order_data['store_id']);
                if ($store && $store->user) {
                    $store->user->decrement('pending_earned_coins', $order->total_coins_used);
                }
            }
            
            return response()->json(['success' => true, 'message' => 'Order cancelled successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to cancel order']);
        }
    }

    /**
     * Handle bulk action on all physical products in an order
     */
    public function bulkAction(Request $request, $orderId)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->findOrFail($orderId);
        
        $request->validate([
            'action' => 'required|in:cancel,complete'
        ]);
        
        $orderData = $order->order_data;
        $items = $orderData['items'] ?? [];
        $updated = false;
        
        foreach ($items as $index => $item) {
            // Only affect physical products
            if (($item['product_snapshot']['type'] ?? 'physical') === 'physical') {
                $currentStatus = $item['buyer_status'] ?? 'pending';
                
                // For cancel: don't change already completed items
                if ($request->action === 'cancel' && $currentStatus === 'completed') {
                    continue;
                }
                
                $items[$index]['buyer_status'] = $request->action === 'cancel' ? 'cancelled' : 'completed';
                $updated = true;
            }
        }
        
        if ($updated) {
            $orderData['items'] = $items;
            $order->update(['order_data' => $orderData]);
            
            // Check if all products are now completed to update main order status
            $this->checkAndUpdateOrderStatus($order);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Bulk action completed successfully'
        ]);
    }

    /**
     * Handle action on individual product
     */
    public function productAction(Request $request, $orderId)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->findOrFail($orderId);
        
        $request->validate([
            'product_index' => 'required|integer|min:0',
            'action' => 'required|in:cancel,complete'
        ]);
        
        $orderData = $order->order_data;
        $items = $orderData['items'] ?? [];
        $index = $request->product_index;
        
        if (!isset($items[$index])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }
        
        // Only allow actions on physical products
        if (($items[$index]['product_snapshot']['type'] ?? 'physical') !== 'physical') {
            return response()->json([
                'success' => false,
                'message' => 'Action not allowed on digital products'
            ]);
        }
        
        // Check if product is already completed by buyer
        $currentBuyerStatus = $items[$index]['buyer_status'] ?? 'pending';
        if ($currentBuyerStatus === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot modify completed products'
            ]);
        }
        
        // Prevent cancellation if seller has shipped the product
        $currentSellerStatus = $items[$index]['seller_status'] ?? $order->status;
        if ($request->action === 'cancel' && in_array($currentSellerStatus, ['shipped', 'delivered'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot cancel products that have been shipped'
            ]);
        }
        
        $items[$index]['buyer_status'] = $request->action === 'cancel' ? 'cancelled' : 'completed';
        $orderData['items'] = $items;
        $order->update(['order_data' => $orderData]);
        
        // Check if all products are now completed to update main order status
        $this->checkAndUpdateOrderStatus($order);
        
        return response()->json([
            'success' => true,
            'message' => 'Product action completed successfully'
        ]);
    }

    /**
     * Check if all products are completed and update order status accordingly
     */
    private function checkAndUpdateOrderStatus($order)
    {
        $items = collect($order->order_data['items'] ?? []);
        $physicalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'physical');
        
        if ($physicalItems->isEmpty()) {
            return; // No physical products to check
        }
        
        // Check if all physical products are completed by buyer
        $allBuyerCompleted = $physicalItems->every(function($item) {
            $buyerStatus = $item['buyer_status'] ?? 'pending';
            return $buyerStatus === 'completed';
        });
        
        if ($allBuyerCompleted) {
            // Update order status to completed
            $order->update(['status' => 'completed']);
            
            // Transfer coins from pending to earned for store owner
            if ($order->isStoreOrder() && isset($order->order_data['store_id'])) {
                $store = \App\Models\Store::find($order->order_data['store_id']);
                if ($store && $store->user) {
                    $storeOwner = $store->user;
                    if ($storeOwner->pending_earned_coins >= $order->total_coins_used) {
                        $storeOwner->increment('earned_coins', $order->total_coins_used);
                        $storeOwner->decrement('pending_earned_coins', $order->total_coins_used);
                    }
                }
            }
        }
    }
}