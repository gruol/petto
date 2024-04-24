<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerPets;

class ShipmentPet extends Model
{
    use HasFactory;

    public function Pets(){

        return $this->belongsTo(CustomerPets::class, 'pet_id','id');
    }
}
