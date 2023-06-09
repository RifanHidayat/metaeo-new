<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherQuotationItem extends Model
{
    use HasFactory;
    public function goods(){
         return $this->belongsTo(Goods::class);
    
        }

         public function deliveryOrderOtherQuotationItems(){
         return $this->hasMany(DeliveryOrderOtherQuotationItem::class);
    
        }

    
}
