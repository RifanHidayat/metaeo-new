<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V2JobOrder extends Model
{
    use HasFactory;

    public function finishingItems()
    {
        return $this->belongsToMany(FinishingItem::class)->withPivot('description');
    }

    public function cpoItems()
    {
        return $this->belongsTo(CpoItem::class);
    }

    public function v2QuotationItems()
    {
        return $this->belongsTo(V2QuotationItem::class);
    }

    public function v2SalesOrder()
    {
        return $this->belongsTo(V2SalesOrder::class);
    }
}
