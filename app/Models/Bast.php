<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bast extends Model
{
    use HasFactory;

    public function eventQuotation(){
        return $this->belongsTo(EventQuotation::class);
    }

    public function customer(){
         return $this->belongsTo(customer::class);
    }
    public function invoice(){
        return $this->hasOne(Invoice::class);
    }
     public function deliveryOrder(){
        return $this->belongsTo(DeliveryOrder::class,'delivery_order_id');
    }

    public function v2SalesOrderItem(){
        return $this->belongsTo(v2SalesOrderItem::class);
    }

     public function v2SalesOrder(){
        return $this->belongsTo(v2SalesOrder::class);
    }
     
    
}
