<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    public function goodsCategory()
    {
        return $this->belongsTo(GoodsCategory::class);
    }

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class)->withPivot('quantity', 'price', 'discount', 'total', 'description');
    }

    public function purchaseReceives()
    {
        return $this->belongsToMany(PurchaseReceive::class)->withPivot('quantity', 'description');
    }

    public function purchaseReturns()
    {
        return $this->belongsToMany(PurchaseReturn::class)->withPivot('quantity', 'cause', 'description');
    }
}
