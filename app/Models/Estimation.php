<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estimation extends Model
{
    use HasFactory, SoftDeletes;

    public function offsetItems()
    {
        return $this->hasMany(EstimationOffsetItem::class);
    }

    public function digitalItems()
    {
        return $this->hasMany(EstimationDigitalItem::class);
    }

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class);
    }

    public function picPo()
    {
        return $this->belongsTo(PicPo::class);
    }
}
