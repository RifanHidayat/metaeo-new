<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPurchaseOrder extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(CpoItem::class);
    }

    public function v2SalesOrder()
    {
        return $this->hasOne(V2SalesOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
             public function eventQuotations()
    {
        return $this->belongsToMany(EventQuotation::class)->withPivot('event_quotation_id', 'customer_purchase_order_id');
    }
}
