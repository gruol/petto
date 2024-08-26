<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
         protected $table = "product_reviews";

	public function vendor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function VendorProduct()
    {
        return $this->belongsTo(VendorProduct::class,'product_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
