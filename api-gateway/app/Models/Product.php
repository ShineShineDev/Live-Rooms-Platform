<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;

class Product extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'uuid',
        'name',
        'desc',
        'category_id',
        'brand_id',
        'thumbnail',
        'base_price',
        'compare_at_price',
        "discount_value",
        "discount_type",
        'has_tax',
        'cost_per_item',
        "qty",
        'track_quantity',
        'cswofs',
        'sku',
        'barcode',
        'status',
        'unit_id',
        'unit_value'
    ];

    public function tags()
    {
        // return $this->belongsToMany(Tag::class);
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id','id','id'); 
    }
    public function tagsFroSync()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'product_collections', 'product_uuid', 'collection_uuid', 'uuid', 'uuid');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function medias()
    {
        return $this->hasMany(ProductMedia::class, "products_id");
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, "product_id");
    }
     public function comment()
    {
        return $this->hasMany(Comment::class, "product_id");
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->deleteCache();
        });
        static::updating(function ($cls) {
            $cls->deleteCache();
        });
        static::deleting(function ($cls) {
            $cls->deleteCache();
        });
    }

    private function deleteCache(){
        $redisKey = 'products';
        if (Redis::exists($redisKey)) {
            Redis::del($redisKey);
        }
    }
}
