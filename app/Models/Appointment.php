<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Appointment extends Model
{
    use HasFactory;
         protected $table = "appointments";
         public function review()
         {
            return $this->hasOne(Review::class,'appointment_id');
         }
}
