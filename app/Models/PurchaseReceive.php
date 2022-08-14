<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReceive extends Model
{
    use HasFactory;

    public function goods()
    {
        return $this->belongsToMany(Goods::class)->withPivot('quantity', 'description');
    }

      public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

         public function purchaseTransactions()
    {
        return $this->belongsToMany(PurchaseTransaction::class)->withPivot('purchase_receive_id','purchase_transaction_id','amount');
    }
    
}
