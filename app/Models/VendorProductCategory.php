<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use App\Models\ProductCategory;

class VendorProductCategory extends Model
{
	use HasFactory;

    protected $table = "vendor_product_category";

    protected $fillable = [
        "vendor_id",
        "category_id",
    ];

    public function ProductCategory()
    {
        return $this->belongsTo(ProductCategory::class,'category_id');
    }
    
}
