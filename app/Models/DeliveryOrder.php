<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOrder extends Model
{
    use HasFactory, SoftDeletes;

    // public function salesOrder()
    // {
    //     return $this->belongsTo(SalesOrder::class);
    // }

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class)->withPivot('code', 'amount', 'unit', 'description', 'information');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cpoItems()
    {
        return $this->belongsToMany(CpoItem::class)->withPivot('code', 'amount', 'unit', 'description', 'information');
    }

    public function v2QuotationItems()
    {
        return $this->belongsToMany(V2QuotationItem::class)->withPivot('code', 'amount', 'unit', 'description', 'information');
    }

    public function v2SalesOrder()
    {
        return $this->belongsTo(V2SalesOrder::class, 'sales_order_id');
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }
     public function bast(){
        return $this->belongsTo(Bast::class);
    }
}
