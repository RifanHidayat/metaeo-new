<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PicPo extends Model
{
    use HasFactory, SoftDeletes;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function estimations()
    {
        return $this->hasMany(Estimation::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
