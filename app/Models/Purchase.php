<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'invoice_no',
        'purchase_date',
        'total_amount',
        'paid_amount',
        'discount',
        'vat',
        'status',
        'remark'
    ];

    // Relation to Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
