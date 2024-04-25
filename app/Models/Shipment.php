<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\CustomerPets;

class Shipment extends Model
{
    use HasFactory;

    public function ShipmentBy(){

        return $this->belongsTo(Customer::class, 'customer_id','id');
    }
   

    public function ShipmentPet()
    {
        return $this->hasMany(ShipmentPet::class);
    }
     public function CustomerPets()
    {
        return $this->hasMany(CustomerPets::class,'customer_id','id');
    }
}
