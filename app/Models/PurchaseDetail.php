<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = "purchase_details";

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}






// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// class PurchasesDetail extends Model{
//     protected $table="purchases_details";

//     protected $fillable =['purchases_id', 'product_id', 'quantity', 'price', 'discount'];

//     public function product(){
//         return  $this->belongsTo(Product::class, 'product_id');
//     }

//     public function products(){
//         return  $this->belongsTo(Product::class, 'product_id');
//     }

// }
