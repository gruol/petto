<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                            'availability',
                            'charges',
                            'is_approved',
                            'approved_at'
                            ];
}
