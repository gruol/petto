<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\{Customer,VendorProduct,Vendor};

class ProcductComment extends Model
{
    use HasFactory;
    protected $table = "procduct_comments";
    protected $fillable = [
        "body",
        "product_id",
        "customer_id",
        "vendor_id",
        "parent_id",

    ];

    public function VendorProduct()
    {
        return $this->belongsTo(VendorProduct::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
    public function product()
    {
        return $this->belongsTo(VendorProduct::class);
    }
    public function parent()
    {
        return $this->belongsTo(ProcductComment::class, 'parent_id');
    }
    public function replies()
    {
        return $this->hasMany(ProcductComment::class, 'parent_id')->with('replies');
    }

}
