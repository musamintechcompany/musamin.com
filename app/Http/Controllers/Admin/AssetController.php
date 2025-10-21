<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalAsset;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = DigitalAsset::with(['user', 'category', 'subcategory', 'media'])
            ->active();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('marketplace_status', $request->status);
        }

        // Filter by inspection status
        if ($request->filled('inspection_status')) {
            $query->where('inspection_status', $request->inspection_status);
        }

        // Filter by asset type
        if ($request->filled('asset_type')) {
            $query->where('asset_type', $request->asset_type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $assets = $query->latest()->paginate(15);

        $stats = [
            'total' => DigitalAsset::active()->count(),
            'pending_inspection' => DigitalAsset::active()->where('inspection_status', 'pending')->count(),
            'live' => DigitalAsset::active()->live()->count(),
            'flagged' => DigitalAsset::active()->where('inspection_status', 'flagged')->count(),
        ];

        return view('management.portal.admin.assets.index', compact('assets', 'stats'));
    }

    public function show(DigitalAsset $asset)
    {
        $asset->load([
            'user', 
            'category', 
            'subcategory', 
            'inspector',
            'media', 
            'features', 
            'tags', 
            'reviews.user',
            'orders'
        ]);
        
        return view('management.portal.admin.assets.view', compact('asset'));
    }

    public function inspect(Request $request, DigitalAsset $asset)
    {
        $validated = $request->validate([
            'inspection_status' => 'required|in:approved,rejected,flagged',
            'inspector_comment' => 'nullable|string|max:1000',
            'marketplace_action' => 'nullable|in:live,removed,suspended',
        ]);

        $asset->update([
            'inspection_status' => $validated['inspection_status'],
            'inspector_id' => Auth::id(),
            'inspector_comment' => $validated['inspector_comment'],
            'inspected_at' => now(),
        ]);

        // Update marketplace status if provided
        if ($request->filled('marketplace_action')) {
            $asset->update(['marketplace_status' => $validated['marketplace_action']]);
        }

        $action = $validated['inspection_status'];
        return redirect()->back()
            ->with('success', "Asset has been {$action} successfully!");
    }

    public function toggleMarketplace(DigitalAsset $asset)
    {
        $newStatus = $asset->marketplace_status === 'live' ? 'removed' : 'live';
        
        $asset->update(['marketplace_status' => $newStatus]);

        $message = $newStatus === 'live' ? 'Asset is now live on marketplace' : 'Asset removed from marketplace';
        
        return redirect()->back()->with('success', $message);
    }

    public function toggleFeatured(DigitalAsset $asset)
    {
        if ($asset->is_featured) {
            $asset->update([
                'is_featured' => false,
                'featured_until' => null,
            ]);
            $message = 'Asset removed from featured';
        } else {
            $asset->update([
                'is_featured' => true,
                'featured_until' => now()->addDays(30),
                'featured_coins_paid' => 0, // Admin featuring is free
            ]);
            $message = 'Asset featured for 30 days';
        }

        return redirect()->back()->with('success', $message);
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $assetTypes = DigitalAsset::ASSET_TYPES;
        $affiliateUsers = User::whereHas('affiliate', function($query) {
            $query->where('status', 'active')->where('expires_at', '>', now());
        })->orderBy('name')->get();
        
        return view('management.portal.admin.assets.create', compact('categories', 'assetTypes', 'affiliateUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'asset_type' => 'required|in:' . implode(',', array_keys(DigitalAsset::ASSET_TYPES)),
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'short_description' => 'required|string|max:500',
            'details' => 'required|string',
            'live_preview_url' => 'nullable|url',
            'is_buyable' => 'boolean',
            'buy_price' => 'nullable|numeric|min:0',
            'slashed_buy_price' => 'nullable|numeric|min:0',
            'is_rentable' => 'boolean',
            'daily_rent_price' => 'nullable|numeric|min:0',
            'weekly_rent_price' => 'nullable|numeric|min:0',
            'monthly_rent_price' => 'nullable|numeric|min:0',
            'yearly_rent_price' => 'nullable|numeric|min:0',
            'slashed_rent_price' => 'nullable|numeric|min:0',
            'is_team_work' => 'boolean',
            'developer_names' => 'nullable|array',
            'system_managed' => 'boolean',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'license_info' => 'nullable|string',
            'requirements' => 'nullable|array',
            'features' => 'nullable|array',
            'tags' => 'nullable|string',
        ]);

        // Admin creates assets as approved and live by default
        $validated['inspection_status'] = 'approved';
        $validated['inspector_id'] = Auth::id();
        $validated['inspected_at'] = now();
        $validated['marketplace_status'] = 'live';

        if ($validated['is_featured']) {
            $validated['featured_until'] = now()->addDays(30);
            $validated['featured_coins_paid'] = 0; // Admin featuring is free
        }

        $asset = DigitalAsset::create($validated);

        // Handle tags, features, etc. (similar to affiliate controller)
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::findOrCreateByName($tagName);
                    $tag->incrementUsage();
                    $tagIds[] = $tag->id;
                }
            }
            
            $asset->tags()->sync($tagIds);
        }

        if ($request->filled('features')) {
            foreach ($request->features as $index => $featureText) {
                if (!empty($featureText)) {
                    $asset->features()->create([
                        'feature_text' => $featureText,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset created successfully!');
    }

    public function edit(DigitalAsset $asset)
    {
        $categories = Category::active()->ordered()->get();
        $assetTypes = DigitalAsset::ASSET_TYPES;
        $affiliateUsers = User::whereHas('affiliate', function($query) {
            $query->where('status', 'active')->where('expires_at', '>', now());
        })->orderBy('name')->get();
        
        return view('management.portal.admin.assets.edit', compact('asset', 'categories', 'assetTypes', 'affiliateUsers'));
    }

    public function update(Request $request, DigitalAsset $asset)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'asset_type' => 'required|in:' . implode(',', array_keys(DigitalAsset::ASSET_TYPES)),
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'short_description' => 'required|string|max:500',
            'details' => 'required|string',
            'live_preview_url' => 'nullable|url',
            'is_buyable' => 'boolean',
            'buy_price' => 'nullable|numeric|min:0',
            'slashed_buy_price' => 'nullable|numeric|min:0',
            'is_rentable' => 'boolean',
            'daily_rent_price' => 'nullable|numeric|min:0',
            'weekly_rent_price' => 'nullable|numeric|min:0',
            'monthly_rent_price' => 'nullable|numeric|min:0',
            'yearly_rent_price' => 'nullable|numeric|min:0',
            'slashed_rent_price' => 'nullable|numeric|min:0',
            'is_team_work' => 'boolean',
            'developer_names' => 'nullable|array',
            'system_managed' => 'boolean',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'marketplace_status' => 'required|in:live,removed,suspended',
            'license_info' => 'nullable|string',
            'requirements' => 'nullable|array',
            'features' => 'nullable|array',
            'tags' => 'nullable|string',
        ]);

        if ($validated['is_featured'] && !$asset->is_featured) {
            $validated['featured_until'] = now()->addDays(30);
            $validated['featured_coins_paid'] = 0;
        } elseif (!$validated['is_featured']) {
            $validated['featured_until'] = null;
        }

        $asset->update($validated);

        // Handle tags and features (similar to create method)
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::findOrCreateByName($tagName);
                    $tag->incrementUsage();
                    $tagIds[] = $tag->id;
                }
            }
            
            $asset->tags()->sync($tagIds);
        } else {
            $asset->tags()->detach();
        }

        $asset->features()->delete();
        if ($request->filled('features')) {
            foreach ($request->features as $index => $featureText) {
                if (!empty($featureText)) {
                    $asset->features()->create([
                        'feature_text' => $featureText,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.assets.view', $asset)
            ->with('success', 'Asset updated successfully!');
    }

    public function destroy(DigitalAsset $asset)
    {
        // Admin can permanently delete or soft delete
        $asset->update(['deletion_status' => DigitalAsset::DELETION_STATUS_DELETED]);

        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset deleted successfully!');
    }
}