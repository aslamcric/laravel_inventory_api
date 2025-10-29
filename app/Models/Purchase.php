<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'product_id', 'quantity', 'price'];

    // Relations
    public function supplier()
    {
        return $this->belongsTo(supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
