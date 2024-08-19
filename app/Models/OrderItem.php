<?php

namespace App\Models;
use App\Models\{Customer,VendorProduct};

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	protected $table = "order_items";

	protected $fillable = [
		"order_id",
		"product_id",
		"quantity",
		"price",
		"total",

	];
	public function orderProduct()
    {
        return $this->belongsTo(VendorProduct::class,'product_id','id');
    }
	public function order()
	{
		return $this->belongsTo(Order::class);
	}
	public function comments()
    {
        return $this->hasMany(ProcductComment::class,'product_id','product_id');
    }
}
