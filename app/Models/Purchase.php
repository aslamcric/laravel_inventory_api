<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}


// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// class Purchase extends Model{

//     public function supplier() {
//         return $this->belongsTo(Supplier::class);
//     }

//     public function products(){
//         return  $this->belongsTo(Product::class, 'product_id');
//     }

//     public function purchase_details() {
//         return $this->hasMany(PurchasesDetail::class, 'purchases_id');
//     }
// }
// ?>
