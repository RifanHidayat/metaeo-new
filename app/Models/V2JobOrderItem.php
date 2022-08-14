<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V2JobOrderItem extends Model
{
    use HasFactory;

    public function v2JobOrders()
    {
        return $this->belongsTo(V2JobOrder::class);
    }

    public function goods()
    {
        return $this->belongsTo(Goods::class, 'paper');
    }
}
