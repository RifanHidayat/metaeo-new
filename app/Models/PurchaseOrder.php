<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function goods()
    {
        return $this->belongsToMany(Goods::class)->withPivot('id', 'quantity', 'price', 'discount', 'total', 'description','is_ppn');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function fobItem()
    {
        return $this->belongsTo(FobItem::class);
    }

    public function purchaseTransactions()
    {
        return $this->hasMany(PurchaseTransaction::class);
    }
    
    public function goodsPurchaseOrders(){
        return $this->belongsToMany(Goods::class)->withPivot('quantity','price','discount','total','ppn','pph','is_ppn');

    }
    public function purchaseReturns (){
        return $this->hasMany(PurchaseReturn::class);
    }
     public function purchaseReceives (){
        return $this->hasMany(PurchaseReceive::class);
    }
    

}
