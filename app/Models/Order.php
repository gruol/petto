<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProcductComment;

class Order extends Model
{
     protected $table = "orders";
    
    protected $fillable = [
        "customer_id",
        "vendor_id",
        "order_date",
        "status",
        "total_amount",
        "shipping_address",
        "billing_address",
        "province",
        "country",
        "city",
        "name",
        "email",
        "contact_number",

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
   
}
