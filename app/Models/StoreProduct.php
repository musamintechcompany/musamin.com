<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoreProduct extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'store_id', 'name', 'description', 'price', 'list_price', 'type',
        'category', 'images', 'file_path', 'stock_quantity', 'is_active',
        'specifications', 'tags'
    ];

    protected $casts = [
        'images' => 'array',
        'specifications' => 'array',
        'tags' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'list_price' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDigital($query)
    {
        return $query->where('type', 'digital');
    }

    public function scopePhysical($query)
    {
        return $query->where('type', 'physical');
    }

    public function getMainImageAttribute()
    {
        return $this->images && count($this->images) > 0 ? $this->images[0] : null;
    }

    public function isInStock()
    {
        return $this->type === 'digital' || ($this->stock_quantity && $this->stock_quantity > 0);
    }
}
