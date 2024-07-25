<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
         protected $table = "reviews";

	public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
