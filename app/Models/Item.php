<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
     public function subitems(){
         return $this->hasMany(SubItem::class);

    }
    public function goods(){
         return $this->belongsTo(Goods::class);
    
        }
    use HasFactory;
}
