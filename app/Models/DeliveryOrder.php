<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOrder extends Model
{
    use HasFactory, SoftDeletes;

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class)->withPivot('code', 'amount', 'unit', 'description', 'information');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
