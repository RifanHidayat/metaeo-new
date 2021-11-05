<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V2QuotationItem extends Model
{
    use HasFactory;

    public function v2Quotation()
    {
        return $this->belongsTo(V2Quotation::class);
    }

    public function jobOrders()
    {
        return $this->hasMany(V2JobOrder::class);
    }

    public function deliveryOrders()
    {
        return $this->belongsToMany(DeliveryOrder::class)->withPivot('code', 'amount', 'unit', 'description', 'information');
    }
}
