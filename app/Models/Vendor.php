<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model implements AuthenticatableContract
{
    use Authenticatable;
    
    protected $fillable = [
        "business_name",
        "vendor_name",
        "email",
        "password",
        "ntn",
        "cnic",
        "contact",
        "address",
        "city",
        "is_approved",
        "web_link",
        "logo",
        "otp",
        "is_otp_verified",
        "otp_created_at",
    ];

    protected $hidden = [
        'password',
             // 'remember_token',
    ];
}