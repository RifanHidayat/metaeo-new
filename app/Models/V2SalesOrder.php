<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V2SalesOrder extends Model
{
    use HasFactory;

    public function v2Quotation()
    {
        return $this->belongsTo(V2Quotation::class);
    }

    public function customerPurchaseOrder()
    {
        return $this->belongsTo(CustomerPurchaseOrder::class);
    }

    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class, 'sales_order_id');
    }

    public function jobOrders()
    {
        return $this->hasMany(V2JobOrder::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'sales_order_id');
    }
}
