<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\DigitalAsset;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    public function index()
    {
        $assets = DigitalAsset::with(['category', 'subcategory', 'media'])
            ->byUser(Auth::id())
            ->active()
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => DigitalAsset::byUser(Auth::id())->active()->count(),
            'published' => DigitalAsset::byUser(Auth::id())->active()->live()->count(),
            'draft' => DigitalAsset::byUser(Auth::id())->active()->where('marketplace_status', 'removed')->count(),
            'sales' => DigitalAsset::byUser(Auth::id())->withCount('orders')->get()->sum('orders_count'),
        ];

        return view('affiliate.asset-manager.index', compact('assets', 'stats'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $assetTypes = DigitalAsset::ASSET_TYPES;
        
        return view('affiliate.asset-manager.create', compact('categories', 'assetTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'asset_type' => 'required|in:' . implode(',', array_keys(DigitalAsset::ASSET_TYPES)),
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'new_subcategory' => 'nullable|string|max:255',
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
            'developer_names.*' => 'string|max:255',
            'system_managed' => 'boolean',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'license_info' => 'nullable|string',
            'requirements' => 'nullable|array',
            'requirements.*' => 'string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'tags' => 'nullable|string',
            'asset_file' => 'nullable|file|mimes:zip|max:102400', // 100MB
            'readme_file' => 'nullable|file|mimes:txt,md|max:2048', // 2MB
            'media_files' => 'nullable|array',
            'media_files.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:51200', // 50MB
        ]);

        // Handle subcategory creation
        if ($request->filled('new_subcategory') && !$request->filled('subcategory_id')) {
            $subcategory = Subcategory::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['new_subcategory'],
                'slug' => Str::slug($validated['new_subcategory']),
            ]);
            $validated['subcategory_id'] = $subcategory->id;
        }

        // Handle file uploads
        if ($request->hasFile('asset_file')) {
            $validated['asset_file_path'] = $request->file('asset_file')->store('assets/files', 'public');
        }

        if ($request->hasFile('readme_file')) {
            $validated['readme_file_path'] = $request->file('readme_file')->store('assets/readme', 'public');
        }

        // Create the asset
        $asset = DigitalAsset::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        // Handle tags
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

        // Handle features
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

        // Handle media files
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $index => $file) {
                $mediaType = in_array($file->getClientOriginalExtension(), ['mp4', 'mov', 'avi']) ? 'video' : 'image';
                $filePath = $file->store('assets/media', 'public');
                
                $asset->media()->create([
                    'media_type' => $mediaType,
                    'file_path' => $filePath,
                    'sort_order' => $index,
                ]);
            }
        }

        // Handle featuring (deduct coins if requested)
        if ($request->boolean('is_featured')) {
            $user = Auth::user();
            $featuringCost = 50; // coins
            
            if ($user->spendable_coins >= $featuringCost) {
                $user->decrement('spendable_coins', $featuringCost);
                $asset->update([
                    'is_featured' => true,
                    'featured_until' => now()->addDays(30),
                    'featured_coins_paid' => $featuringCost,
                ]);
            }
        }

        return redirect()->route('affiliate.assets.index')
            ->with('success', 'Asset created successfully!');
    }

    public function show(DigitalAsset $asset)
    {
        // Check if user owns this asset
        if (!$asset->isOwnedBy(Auth::id())) {
            abort(403, 'Unauthorized access to this asset.');
        }

        $asset->load(['category', 'subcategory', 'media', 'features', 'tags', 'reviews.user']);
        
        return view('affiliate.asset-manager.show', compact('asset'));
    }

    public function edit(DigitalAsset $asset)
    {
        // Check if user owns this asset
        if (!$asset->isOwnedBy(Auth::id())) {
            abort(403, 'Unauthorized access to this asset.');
        }

        $categories = Category::active()->ordered()->get();
        $assetTypes = DigitalAsset::ASSET_TYPES;
        
        return view('affiliate.asset-manager.edit', compact('asset', 'categories', 'assetTypes'));
    }

    public function update(Request $request, DigitalAsset $asset)
    {
        // Check if user owns this asset
        if (!$asset->isOwnedBy(Auth::id())) {
            abort(403, 'Unauthorized access to this asset.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'asset_type' => 'required|in:' . implode(',', array_keys(DigitalAsset::ASSET_TYPES)),
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'new_subcategory' => 'nullable|string|max:255',
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
            'developer_names.*' => 'string|max:255',
            'system_managed' => 'boolean',
            'is_public' => 'boolean',
            'license_info' => 'nullable|string',
            'requirements' => 'nullable|array',
            'requirements.*' => 'string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'tags' => 'nullable|string',
        ]);

        // Handle subcategory creation
        if ($request->filled('new_subcategory') && !$request->filled('subcategory_id')) {
            $subcategory = Subcategory::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['new_subcategory'],
                'slug' => Str::slug($validated['new_subcategory']),
            ]);
            $validated['subcategory_id'] = $subcategory->id;
        }

        $asset->update($validated);

        // Handle tags
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

        // Handle features
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

        return redirect()->route('affiliate.assets.show', $asset)
            ->with('success', 'Asset updated successfully!');
    }

    public function destroy(DigitalAsset $asset)
    {
        // Check if user owns this asset
        if (!$asset->isOwnedBy(Auth::id())) {
            abort(403, 'Unauthorized access to this asset.');
        }

        // Soft delete - just mark as deleted
        $asset->update(['deletion_status' => DigitalAsset::DELETION_STATUS_DELETED]);

        return redirect()->route('affiliate.assets.index')
            ->with('success', 'Asset deleted successfully!');
    }

    public function getSubcategories(Category $category)
    {
        return response()->json([
            'subcategories' => $category->subcategories()->active()->ordered()->get()
        ]);
    }
}