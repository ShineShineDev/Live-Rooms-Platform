<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionList extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',"room_id","status"
    ];

    protected $casts = [
    ];

     public function room()
    {
        return $this->belongsTo(Rooms::class);
    }
}
