<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimationOffsetSubItem extends Model
{
    use HasFactory;

    public function offsetItem()
    {
        return $this->belongsTo(EstimationOffsetItem::class);
    }
}
