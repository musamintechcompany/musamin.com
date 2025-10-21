<?php

namespace App\Http\Controllers;

use App\Models\DeliveryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryDetailController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->deliveryDetails()->latest()->get();
        return response()->json(['success' => true, 'addresses' => $addresses]);
    }
    
    public function show(DeliveryDetail $deliveryDetail)
    {
        if ($deliveryDetail->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        return response()->json(['success' => true, 'address' => $deliveryDetail]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'details' => 'required|array',
            'details.name' => 'required|string|max:255',
            'details.email' => 'required|email',
            'details.address' => 'required|string',
            'details.city' => 'required|string|max:100',
            'details.state' => 'required|string|max:100',
            'details.country' => 'required|string|max:100',
            'is_default' => 'boolean'
        ]);

        $deliveryDetail = DeliveryDetail::create([
            'user_id' => Auth::id(),
            'label' => $validated['label'],
            'details' => $validated['details'],
            'is_default' => $validated['is_default'] ?? false
        ]);

        if ($validated['is_default'] ?? false) {
            $deliveryDetail->setAsDefault();
        }

        return response()->json(['success' => true, 'address' => $deliveryDetail]);
    }

    public function update(Request $request, DeliveryDetail $deliveryDetail)
    {
        if ($deliveryDetail->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'details' => 'required|array',
            'details.name' => 'required|string|max:255',
            'details.email' => 'required|email',
            'details.address' => 'required|string',
            'details.city' => 'required|string|max:100',
            'details.state' => 'required|string|max:100',
            'details.country' => 'required|string|max:100',
            'is_default' => 'boolean'
        ]);

        $deliveryDetail->update([
            'label' => $validated['label'],
            'details' => $validated['details'],
            'is_default' => $validated['is_default'] ?? false
        ]);

        if ($validated['is_default'] ?? false) {
            $deliveryDetail->setAsDefault();
        }

        return response()->json(['success' => true, 'delivery_detail' => $deliveryDetail]);
    }

    public function destroy(DeliveryDetail $deliveryDetail)
    {
        if ($deliveryDetail->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $deliveryDetail->delete();
        return response()->json(['success' => true, 'message' => 'Delivery address deleted']);
    }

    public function setDefault(DeliveryDetail $deliveryDetail)
    {
        if ($deliveryDetail->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $deliveryDetail->setAsDefault();
        return response()->json(['success' => true, 'message' => 'Default address updated']);
    }
}