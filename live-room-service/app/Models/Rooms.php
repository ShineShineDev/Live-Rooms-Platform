<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
class Rooms extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image_url',
        'category',
        'date',
        'time',
        'team_a',
        'team_b',
        'commentator',
        'is_live',
        'is_hot',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'is_live' => 'boolean',
        'is_hot' => 'boolean',
    ];

     protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
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
        $redisKey = 'rooms';
        if (Redis::exists($redisKey)) {
            Redis::del($redisKey);
        }
    }
}
