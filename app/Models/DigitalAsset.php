<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hashids\Hashids;

class DigitalAsset extends Model
{
    use HasFactory;

    const ASSET_TYPES = [
        'website' => 'Website',
        'app' => 'App',
        'template' => 'Template',
        'plugin' => 'Plugin',
        'ui-kit' => 'UI Kit',
        'service' => 'Service',
        'illustration' => 'Illustration',
        'icon-set' => 'Icon Set',
    ];

    const MARKETPLACE_STATUS_LIVE = 'live';
    const MARKETPLACE_STATUS_REMOVED = 'removed';
    const MARKETPLACE_STATUS_SUSPENDED = 'suspended';

    const DELETION_STATUS_ACTIVE = 'active';
    const DELETION_STATUS_DELETED = 'deleted';

    const INSPECTION_STATUS_PENDING = 'pending';
    const INSPECTION_STATUS_APPROVED = 'approved';
    const INSPECTION_STATUS_REJECTED = 'rejected';
    const INSPECTION_STATUS_FLAGGED = 'flagged';

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'title',
        'slug',
        'asset_type',
        'short_description',
        'details',
        'live_preview_url',
        'readme_file_path',
        'is_buyable',
        'buy_price',
        'slashed_buy_price',
        'is_rentable',
        'daily_rent_price',
        'weekly_rent_price',
        'monthly_rent_price',
        'yearly_rent_price',
        'slashed_rent_price',
        'is_team_work',
        'developer_names',
        'developer_user_ids',
        'system_managed',
        'asset_file_path',
        'is_public',
        'marketplace_status',
        'deletion_status',
        'inspection_status',
        'inspector_id',
        'inspector_comment',
        'inspected_at',
        'is_featured',
        'featured_until',
        'featured_coins_paid',
        'license_info',
        'requirements',
        'views_count',
        'downloads_count',
        'favorites_count',
        'rating_average',
        'rating_count',
        'hashid',
    ];

    protected $casts = [
        'is_buyable' => 'boolean',
        'is_rentable' => 'boolean',
        'is_team_work' => 'boolean',
        'system_managed' => 'boolean',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'developer_names' => 'array',
        'developer_user_ids' => 'array',
        'requirements' => 'array',
        'buy_price' => 'decimal:2',
        'slashed_buy_price' => 'decimal:2',
        'daily_rent_price' => 'decimal:2',
        'weekly_rent_price' => 'decimal:2',
        'monthly_rent_price' => 'decimal:2',
        'yearly_rent_price' => 'decimal:2',
        'slashed_rent_price' => 'decimal:2',
        'rating_average' => 'decimal:2',
        'inspected_at' => 'datetime',
        'featured_until' => 'datetime',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }

            if (empty($model->hashid)) {
                $model->hashid = $model->generateHashid();
            }

            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($model->title);
            }
        });
    }

    public function generateHashid(): string
    {
        $hashids = new Hashids(
            config('hashids.connections.main.salt'),
            config('hashids.connections.main.length'),
            config('hashids.connections.main.alphabet')
        );

        $numericId = crc32($this->id);
        return $hashids->encode($numericId);
    }

    public function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public static function findByHashid(string $hashid): ?DigitalAsset
    {
        return static::where('hashid', $hashid)->first();
    }

    public function getRouteKeyName(): string
    {
        return 'hashid';
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function media()
    {
        return $this->hasMany(AssetMedia::class, 'asset_id')->orderBy('sort_order');
    }

    public function features()
    {
        return $this->hasMany(AssetFeature::class, 'asset_id')->orderBy('sort_order');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'asset_tags');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function favorites()
    {
        return $this->hasMany(AssetFavorite::class, 'asset_id');
    }

    public function orders()
    {
        return $this->hasMany(AssetOrder::class, 'asset_id');
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeLive($query)
    {
        return $query->where('marketplace_status', self::MARKETPLACE_STATUS_LIVE);
    }

    public function scopeActive($query)
    {
        return $query->where('deletion_status', self::DELETION_STATUS_ACTIVE);
    }

    public function scopeMarketplace($query)
    {
        return $query->public()->live()->active()->activeAffiliate();
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where('featured_until', '>', now());
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('asset_type', $type);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActiveAffiliate($query)
    {
        return $query->whereHas('user.affiliate', function($q) {
            $q->where('status', 'active')->where('expires_at', '>', now());
        });
    }

    // Methods
    public function calculateRevenueSplit(float $amount): array
    {
        if ($this->system_managed) {
            // 50% platform, 50% user
            $platformShare = $amount * 0.5;
            $userShare = $amount * 0.5;
        } else {
            // 30% platform, 70% user
            $platformShare = $amount * 0.3;
            $userShare = $amount * 0.7;
        }

        return [
            'platform_share' => round($platformShare, 2),
            'user_share' => round($userShare, 2),
        ];
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementDownloads()
    {
        $this->increment('downloads_count');
    }

    public function updateRating()
    {
        $reviews = $this->reviews()->where('status', 'approved');
        $this->rating_count = $reviews->count();
        $this->rating_average = $reviews->avg('rating') ?? 0;
        $this->save();
    }

    public function isFavoriteBy($userId): bool
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    public function isOwnedBy($userId): bool
    {
        return $this->user_id === $userId;
    }

    public function canBeViewedBy($userId): bool
    {
        // Public assets can be viewed by anyone
        if ($this->is_public && $this->marketplace_status === self::MARKETPLACE_STATUS_LIVE) {
            return true;
        }

        // Owner can always view their assets
        if ($this->isOwnedBy($userId)) {
            return true;
        }

        // Admin can view all assets (you'll need to implement admin check)
        // return User::find($userId)?->isAdmin();

        return false;
    }
}