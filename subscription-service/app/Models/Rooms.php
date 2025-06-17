<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
