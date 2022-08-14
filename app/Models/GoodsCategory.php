<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    use HasFactory;

    public function goods()
    {
        $this->hasMany(Goods::class);
    }
}
