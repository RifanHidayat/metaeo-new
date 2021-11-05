<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpoItem extends Model
{
    use HasFactory;

    public function customerPurchaseOrder()
    {
        return $this->belongsTo(CustomerPurchaseOrder::class);
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
