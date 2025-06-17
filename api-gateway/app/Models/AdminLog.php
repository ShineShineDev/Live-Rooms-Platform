<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "ip",
        "url",
        "method",
        "req_data"
    ];
}