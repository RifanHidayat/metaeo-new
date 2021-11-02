<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V2Quotation extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(V2QuotationItem::class);
    }

    public function v2SalesOrder()
    {
        return $this->hasOne(V2SalesOrder::class);
    }
}
