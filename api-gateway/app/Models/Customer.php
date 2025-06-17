<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;



class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "phone",
        "point",
        "member_settings_id",
        "password",
        "city",
        "post_code",
        "address",
        "gender",
        "dob",
        "avatar",
        "last_logined_at",
        "device_token"
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->last_logined_at = now();
        });
    }
}










