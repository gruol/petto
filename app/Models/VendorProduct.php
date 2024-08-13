<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentTime;
use App\Models\AppointmentDay;
use App\Models\{AppointmentDate,Vendor};
use App\Models\Clinic;
use App\Models\Review;
use App\Models\Appointment;

class VendorProduct extends Model
{
  use HasFactory;
  protected $table = "vendor_products";

  protected $fillable = [
   
    "product_name",
    "category_id",
    "brand",
    "price",
    "quantity",
    "sku",
    "image",
    "colors",
    "description",
    "key_features",
    "ingredients",
    "usage_instructions",
    "weight",
    "dimensions",
    "shipping_cost",
    "shipping_time_days",
    "is_active",

  ];

  public function ProductCategory()
  {
    return $this->belongsTo(ProductCategory::class,'category_id');
  }
  public function Vendor()
  {
    return $this->belongsTo(Vendor::class,'created_by_id');
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }
}
