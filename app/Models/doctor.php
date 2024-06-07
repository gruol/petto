<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentTime;
use App\Models\AppointmentDay;
use App\Models\AppointmentDate;
use App\Models\Clinic;
use App\Models\Review;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'picture',
        'clinic_id',
        'contact',
        'email',
        'education',
        'experience',
        'expertise',
        'about',
        'charges',
        'is_approved',
        'approved_at'
    ];
    public function AppointmentTime()
    {
       return $this->hasMany(AppointmentTime::class);
   }
   public function AppointmentDay()
    {
       return $this->hasMany(AppointmentDay::class);
   }
   public function AppointmentDate()
    {
       return $this->hasMany(AppointmentDate::class);
   }
   public function clinic()
    {
       return $this->belongsTo(Clinic::class);
   }
   public function rating()
    {  
        return $this->hasMany(Review::class);
    }
    public function review()
    {  
        return $this->hasMany(Review::class);
    }
}
