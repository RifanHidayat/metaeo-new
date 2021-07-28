<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstimationDigitalItem extends Model
{
    use HasFactory;

    public function estimation()
    {
        return $this->belongsTo(Estimation::class);
    }

    public function subItems()
    {
        return $this->hasMany(EstimationDigitalSubItem::class);
    }
}
