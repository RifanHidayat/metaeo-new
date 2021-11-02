<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    use HasFactory;

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class)->withPivot('amount');
    }
}
