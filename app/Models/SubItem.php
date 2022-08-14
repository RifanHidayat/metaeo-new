<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
    use HasFactory;

    public function item(){
         return $this->belongsTo(Item::class);

    }
    public function goods(){
         return $this->belongsTo(Goods::class,'product_id');
    
        }


}
