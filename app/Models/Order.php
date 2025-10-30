<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model{
    public function customers(){
        return  $this->belongsTo(Customer::class, 'customer_id');
    }

    public function products(){
        return  $this->belongsTo(Product::class, 'product_id');
    }


    public function order_details(){
        return  $this->hasMany(OrderDetail::class);
    }
}
