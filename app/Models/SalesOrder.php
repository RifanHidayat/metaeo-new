<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use HasFactory, SoftDeletes;

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class)->using(QuotationSalesOrder::class)->withPivot('estimation_id');
    }

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }

    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
        public function eventQuotations()
    {
        return $this->belongsToMany(EventQuotation::class)->withPivot('event_quotation_id', 'v2_sales_order_id', 'pic_event_id','total');
    }
}
