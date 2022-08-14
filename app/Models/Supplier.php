<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function supplierAccounts(){
        return $this->hasMany(SupplierAccount::class);
    }
    public function purchaseReceives(){
      return $this->hasMany(PurchaseReceive::class);
     }
}
