<?php

namespace App\Models;

use App\Http\Controllers\OtherQuotationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventQuotation extends Model
{

    use HasFactory;

     public function items()
    {
        return $this->belongsToMany(item::class)->withPivot('event_quotation_id', 'item_id');
    }
     public function subitems()
    {
        return $this->belongsToMany(SubItem::class)->withPivot('sub_item_id', 'event_quotation_id','quantity','frequency','is_stock','rate','subtotal',);
    }
      public function goods()
    {
        return $this->belongsToMany(Goods::class)->withPivot('goods_id', 'event_quotation_id','quantity','frequency','is_stock','rate','subtotal','goods_id','item_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function picPo(){
        return $this->belongsTo(PicPo::class);
    }
    public function picEvent(){
        return $this->belongsTo(PicEvent::class);
    }
    public function otherQuotationItems(){
        return $this->belongsTo(OtherQuotationItem::class);
    }
    public function poQuotation(){
        return $this->belongsTo(PoQuotation::class);
    }
      public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('event_quotation_id', 'sales_order_id', 'project_id');
    }
     public function customerPurchaseOrder()
    {
        return $this->belongsToMany(CustomerPurchaseOrder::class)->withPivot('event_quotation_id', 'customer_purchase_order_id');
    }


    public function v2SalesOrder(){
        return $this->hasOne(V2SalesOrder::class);
    }
    // public function deliveryOrders()
    // {
    //     return $this->belongsToMany(DeliveryOrder::class)->withPivot('event_quotation_id', 'delivery_order_id','number','name','quantity','kts','description');
    // }
}
