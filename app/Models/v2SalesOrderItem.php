<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class v2SalesOrderItem extends Model
{
    use HasFactory;

    public function picEvent(){
        return $this->BelongsTo(PicEvent::class);
    }
    public function v2SalesOrder(){
        return $this->belongsTo(v2SalesOrder::class);

    }
}
