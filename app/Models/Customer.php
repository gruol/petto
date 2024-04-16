<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
	use HasFactory,HasApiTokens;
	protected $fillable = [
		"name",
		"password",
		"contact_no",
		"email",
		"dob",
		"pet_category",
		"pet_name",
		"pet_age",
		"pet_breed",
		"country",
		"otp",
		"is_otp_verified",
		"otp_created_at",
		"token",
		"is_deleted",
	];
}
