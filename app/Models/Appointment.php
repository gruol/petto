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
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
     public function pet()
    {
        return $this->belongsTo(CustomerPets::class);
    }

}
