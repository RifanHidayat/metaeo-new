<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class)->withPivot('amount');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function deliveryOrders()
    {
        return $this->belongsToMany(DeliveryOrder::class);
    }

    public function v2SalesOrder()
    {
        return $this->belongsTo(V2SalesOrder::class, 'sales_order_id');
    }
}
