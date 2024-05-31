<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Doctor;

class Clinic extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        "manager_name",
        "email",
        "contact",
        "clinic_name",
        "address",
        "city",
        "password",
        "otp",
        "is_otp_verified",
        "otp_created_at",
        "token",
        "is_deleted",
        "is_approved",
        "approved_at",

    ];
    public function doctors()
    {
         return $this->hasMany(Doctor::class);
    }
}
