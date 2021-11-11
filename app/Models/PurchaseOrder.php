<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function goods()
    {
        return $this->belongsToMany(Goods::class)->withPivot('id', 'quantity', 'price', 'discount', 'total', 'description');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function fobItem()
    {
        return $this->belongsTo(FobItem::class);
    }

    public function purchaseTransactions()
    {
        return $this->belongsToMany(PurchaseTransaction::class)->withPivot('amount');
    }
}
