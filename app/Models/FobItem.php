<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FobItem extends Model
{
    use HasFactory;

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
