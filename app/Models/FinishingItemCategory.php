<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishingItemCategory extends Model
{
    use HasFactory;

    public function finishingItems()
    {
        return $this->hasMany(FinishingItem::class);
    }
}
