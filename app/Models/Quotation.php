<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    public function estimations()
    {
        return $this->belongsToMany(Estimation::class);
    }

    public function salesOrders()
    {
        return $this->belongsToMany(SalesOrder::class)->using(QuotationSalesOrder::class)->withPivot('estimation_id');
    }

    public function jobOrders()
    {
        return $this->belongsToMany(JobOrder::class);
    }

    public function picPo()
    {
        return $this->belongsTo(PicPo::class, 'up');
    }

    public function deliveryOrders()
    {
        return $this->belongsToMany(DeliveryOrder::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }
}
