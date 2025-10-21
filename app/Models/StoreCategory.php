<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoreCategory extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['store_id', 'name', 'slug', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    
    public function products()
    {
        return $this->hasMany(StoreProduct::class, 'category', 'name');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
