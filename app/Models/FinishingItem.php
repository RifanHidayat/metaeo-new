<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishingItem extends Model
{
    use HasFactory;

    public function finishingItemCategory()
    {
        return $this->belongsTo(FinishingItemCategory::class);
    }

    public function v2JobOrders()
    {
        return $this->belongsToMany(V2JobOrder::class)->withPivot('description');
    }
}
