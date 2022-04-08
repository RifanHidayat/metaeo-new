<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrderOtherQuotationItem extends Model
{
    use HasFactory;

    public function otherQuotationItem(){
    return $this->belongsTo(OtherQuotationItem::class);
    }
}
