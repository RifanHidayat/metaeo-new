<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\FobItem;
use App\Models\Goods;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceive;
use App\Models\PurchaseReturn;
use App\Models\Shipment;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   
        return view('purchase-order.index');
    }

      private function formatDate($date = "", $format = "Y-m-d")
    {
        return date_format(date_create($date), $format);
    }


    /**
     * Send datatable form.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexData()
    {
        $purchaseOrders = PurchaseOrder::with('supplier','purchaseReceives')->select('purchase_orders.*');
        
        return DataTables::eloquent($purchaseOrders)
            ->addIndexColumn()
            ->addColumn('supplier_name',function($row){
                return $row->supplier!=null?$row->supplier->name:"";
            })
             ->addColumn('payment_amount',function($row){
                return $row->purchaseReceives->sum('payment');
            })
            ->addColumn('receives_quantity',function($row){
                 return $row->purchaseReceives->sum('quantity');
            })
             

            
            ->addColumn('action', function ($row) {
                $button = '<div class="text-center">';
                $button .= '<a href="/purchase-order/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                </g>
              </svg> </span> </a>
              <a href="#" data-id="' . $row->id . '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                  <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                </g>
              </svg> </span> </a>';

                $button .= '<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-item">
                                    <a href="/purchase-order/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak</span>
                                    </a>
                                </li>
                                 <li class="navi-item">
                                    <a href="/purchase-order/detail/' . $row->id . '"  class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon-open-box"></i>
                                        </span>
                                        <span class="navi-text">Detail</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/purchase-order/receive/' . $row->id . '"  class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon-open-box"></i>
                                        </span>
                                        <span class="navi-text">Penerimaan</span>
                                    </a>
                                </li>
                              
                                 <li class="navi-item">
                                    <a href="/purchase-order/transaction/' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon-logout"></i>
                                        </span>
                                        <span class="navi-text">Pembayaran</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>';

                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $goods = Goods::with(['goodsCategory','pphRates'])->get();
       // return $goods;
        $shipments = Shipment::all();
        $fobItems = FobItem::all();
        $suppliers = Supplier::with('division')->get();

        return view('purchase-order.create', [
            'goods' => $goods,
            'shipments' => $shipments,
            'fob_items' => $fobItems,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       // return $request->selected_goods;

      //  return $request->all();

        $supplier = Supplier::findOrFail($request->supplier_id);
        // return $supplier;
      
        DB::beginTransaction();
        try {
       // $supplier = Supplier::with('division')->findOrFail($request->supplier_id);

        $date = $request->date;
        
        $transactionsByCurrentDateCount = PurchaseOrder::query()->where('date', $date)->get()->count();
        
          $number = "PO"."".'-' . $this->formatDate($date, "d") . $this->formatDate($date, "m") . $this->formatDate($date, "y") . '-' . sprintf('%04d', $transactionsByCurrentDateCount + 1);

        $purchaseOrderWithNumber = PurchaseOrder::where('number', $request->number)->first();
        if ($purchaseOrderWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

            // Create Purchase Order
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->number = $number;
            
            $purchaseOrder->date = $request->date;
            $purchaseOrder->supplier_id = $request->supplier_id;
            $purchaseOrder->delivery_address = $request->delivery_address;
            $purchaseOrder->delivery_date = $request->delivery_date;
            $purchaseOrder->shipment_id = $request->shipment_id;
            $purchaseOrder->payment_term = $request->payment_term;
            $purchaseOrder->fob_item_id = $request->fob_item_id;
            $purchaseOrder->description = $request->description;
            $purchaseOrder->subtotal = $request->subtotal;
            $purchaseOrder->discount = $request->discount;
            $purchaseOrder->ppn = $request->ppn;
            $purchaseOrder->ppn_value = $request->ppn_value;
            $purchaseOrder->ppn_amount = $request->ppn_amount;
            $purchaseOrder->pph_amount = $request->pph_amount;
            $purchaseOrder->shipping_cost = $request->shipping_cost;
            $purchaseOrder->other_cost = $request->other_cost;
            $purchaseOrder->other_cost_description = $request->other_cost_description;
            $purchaseOrder->total = $request->total;
            $purchaseOrder->save();

            // Attach Goods
            $selectedGoods = $request->selected_goods;
            $goods = collect($selectedGoods)->map(function ($item) use ($purchaseOrder) {
                return [
                    'purchase_order_id' => $purchaseOrder->id,
                    'goods_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'total' => $item['total'],
                    'is_ppn' => $item['isPpn'],
                    'ppn' =>$item['isPpn']==1? $item['total']*0.1:0,
                    'pph' => $item['total']*$item['pph'],
                    // 'description' => $item['description'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

            // $purchaseOrder->goods()->attach($goods);
            DB::table('goods_purchase_order')->insert($goods);

            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchaseOrder,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $purchaseOrder=PurchaseOrder::with('goods.pphRates')->findOrFail($id);
        //http://127.0.0.1:8000/purchase-order/edit/24return $purchaseOrder;
       // return $purchaseOrder;

        $purchaseGoods=collect($purchaseOrder->goods)->each(function($item){
            $item['quantity']=$item['pivot']['quantity'];
            $item['discount']=$item['pivot']['discount'];
            $item['total']=$item['pivot']['total'];
            $item['ppn']=$item['pivot']['ppn'];
            $item['isPpn']=$item['pivot']['is_ppn'];
            $item['price']=$item['pivot']['price'];

        });
    //  return $purchaseGoods;
        
        $goods = Goods::with(['goodsCategory','pphRates'])->get();
       // return $goods;
       // return $goods;
        $shipments = Shipment::all();
        $fobItems = FobItem::all();
        $suppliers = Supplier::with('division')->get();

        return view('purchase-order.edit', [
            'goods' => $goods,
            'shipments' => $shipments,
            'fob_items' => $fobItems,
            'suppliers' => $suppliers,
            'purchase_order'=>$purchaseOrder,
            'purhase_goods'=>$purchaseGoods 
        ]);
        //
    }
    public function print($id){
        //return "tes";
    //    return $id;
    $purchaseOrder=PurchaseOrder::with(['goodsPurchaseOrders','supplier'])->findOrFail($id);
    //return  $purchaseOrder->goodsPurchaseOrders[0]['pivot']->quantity;
    //return $purchaseOrder;
    // $purchaseOrder=PurchaseOrder::with('goodsPurchaseOrders')->get();
    // return $purchaseOrder->goodsPurchaseOrders;
    $compny=Company::first();

            $mpdf = new \Mpdf\Mpdf([
            'format' => 'A5',
            'mode' => 'utf-8',
            'orientation' => 'L',
            'margin_left' => 3,
            'margin_top' => 3,
            'margin_right' => 3,
            'margin_bottom' => 3,
        ]);

        // return $finishingItems;

        $html = view('purchase-order.print', [
            'goods' => $purchaseOrder->goodsPurchaseOrders,
            'purchase_order'=>$purchaseOrder,
            'company'=>$compny
        ]);

        // return $jobOrder;
        $mpdf->WriteHTML($html);
        $mpdf->Output();


    
    

    }

    public function detail($id){
    $purchaseOrder=PurchaseOrder::with(['goods','purchaseReturns.goods','purchaseReceives.goods','purchaseTransactions'])->findOrFail($id);  
    $purchaseReceives=collect($purchaseOrder->purchaseReceives)->each(function($item){
        $item['total']=$item['goods']->sum('pivot.quantity');
    });
  
  // return $purchaseReceives->sum('total')   ;

    $goods = Goods::with(['goodsCategory'])->get();
        $shipments = Shipment::all();
        $fobItems = FobItem::all();
        $suppliers = Supplier::with('division')->get();
        return view('purchase-order.detail', [
            'goods' => $goods,
            'shipments' => $shipments,
            'fob_items' => $fobItems,
            'suppliers' => $suppliers,
            'purchase_order'=>$purchaseOrder,
            'purchase_receives_total'=>$purchaseReceives->sum('total')
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //return $id;

            $supplier = Supplier::findOrFail($request->supplier_id);
          //  return $supplier;
        // return $supplier;
      
        DB::beginTransaction();
        try {
       // $supplier = Supplier::with('division')->findOrFail($request->supplier_id);

        $date = $request->date;
        
        $transactionsByCurrentDateCount = PurchaseOrder::query()->where('date', $date)->get()->count();
        // $code=$supplier->division!=null?$supplier->division->code:"";
          $number = "PO"."".'-' . $this->formatDate($date, "d") . $this->formatDate($date, "m") . $this->formatDate($date, "y") . '-' . sprintf('%04d', $transactionsByCurrentDateCount + 1);

        // $purchaseOrderWithNumber = PurchaseOrder::where('number', $request->number)->first();
        // if ($purchaseOrderWithNumber !== null) {
        //     return response()->json([
        //         'message' => 'number or code already used',
        //         'code' => 400,
        //         // 'errors' => $/e,
        //     ], 400);
        // }
           // return ""
            // Create Purchase Order
        
            $purchaseOrder = PurchaseOrder::findOrFail($id);
           // return $purchaseOrder;
            $purchaseOrder->number = $number;
            
            $purchaseOrder->date = $request->date;
            $purchaseOrder->supplier_id = $request->supplier_id;
            $purchaseOrder->delivery_address = $request->delivery_address;
            $purchaseOrder->delivery_date = $request->delivery_date;
            $purchaseOrder->shipment_id = $request->shipment_id;
            $purchaseOrder->payment_term = $request->payment_term;
            $purchaseOrder->fob_item_id = $request->fob_item_id;
            $purchaseOrder->description = $request->description;
            $purchaseOrder->subtotal = $request->subtotal;
            $purchaseOrder->discount = $request->discount;
            $purchaseOrder->ppn = $request->ppn;
            $purchaseOrder->ppn_value = $request->ppn_value;
            $purchaseOrder->ppn_amount = $request->ppn_amount;
            $purchaseOrder->pph_amount = $request->pph_amount;
            $purchaseOrder->shipping_cost = $request->shipping_cost;
            $purchaseOrder->other_cost = $request->other_cost;
            $purchaseOrder->other_cost_description = $request->other_cost_description;
            $purchaseOrder->total = $request->total;
            $purchaseOrder->save();

            // Attach Goods
            $selectedGoods = $request->selected_goods;
             DB::table('goods_purchase_order')->where('purchase_order_id',$purchaseOrder->id)->delete();
            $goods = collect($selectedGoods)->map(function ($item) use ($purchaseOrder) {
                return [
                    'purchase_order_id' => $purchaseOrder->id,
                    'goods_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'total' => $item['total'],
                    'is_ppn' => $item['isPpn'],
                    'ppn' =>$item['isPpn']==1? $item['total']*0.1:0,
                    'pph' => $item['total']*$item['pph'],
                    // 'description' => $item['description'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

            // $purchaseOrder->goods()->attach($goods);
            DB::table('goods_purchase_order')->insert($goods);

            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchaseOrder,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    DB::beginTransaction();


    
    try{
        $purchase=PurchaseOrder::findOrFail($id);
        $purchase->delete();
        DB::commit();
        return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchase,
            ]);

    
    }catch(Exception $e){
        DB::rollBack();
          return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);

    }

    }

    /**
     * Receive goods from specific purchase order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receive($id)
    {
        $purchaseOrder = PurchaseOrder::with(['goods.pphRates', 'supplier', 'fobItem', 'shipment'])->findOrFail($id);
        //return $purchaseOrder;
       // return $purchaseOrder->goods;
        $purchaseReceiveGoods = PurchaseReceive::with(['goods'])
            ->where('purchase_order_id', $id)
            ->get()
            ->flatMap(function ($purchaseReceive) {
                return $purchaseReceive->goods;
            })
            ->groupBy('id')
            ->map(function ($group, $id) {
                $receivedQuantity = collect($group)->map(function ($goods) {
                    return $goods->pivot->quantity;
                })->sum();
                return [
                    'id' => $id,
                    'received_quantity' => $receivedQuantity,
                ];
            })
            ->all();

        // return $purchaseReceiveGoods;

        // $selectedGoods = collect($purchaseOrder->goods)->each(function ($good) use ($purchaseReceiveGoods) {
        //     $purchaseReceive = collect($purchaseReceiveGoods)->where('id', $good->id)->first();
        //     $good['received_quantity'] = 0;
        //     if ($purchaseReceive !== null) {
        //         $good['received_quantity'] = $purchaseReceive['received_quantity'];
        //     }
        //     $availableQuantity = $good->pivot->quantity - $good['received_quantity'];

        //     $good['receive_quantity'] = $availableQuantity;
        //     // $good['cause'] = 'defective';
        //     $good['finish'] = $good['received_quantity'] >= $good->pivot->quantity ? 1 : 0;
        // })->sortBy('finish')->values()->all();
        $selectedGoods = collect($purchaseOrder->goods)->groupBy('id')->map(function ($group, $goodsId) {
            // return $goodsId;
            // return $group;
            $totalQuantity = collect($group)->sum(function ($item) {
                return $item->pivot->quantity;
            });
            return [
                'id' => $group[0]->id,
                'number' => $group[0]->number,
                'name' => $group[0]->name,
                'unit' => $group[0]->unit,
                'purchase_price' => $group[0]->purchase_price,
                'discount' => $group[0]->discount,
                'stock' => $group[0]->stock,
                'type' => $group[0]->type,
                'pph_rates' => $group[0]->pphRates,

                'pivot' => [
                    'quantity' => $totalQuantity,
                    'price' => $group[0]->pivot->price,
                    'discount'=>$group[0]->pivot->discount,
                    'pphRates'=>$group[0]->pivot->discount,
                    'ppn'=>$group[0]->pivot->is_ppn
                ],
                // 'id' => $group[0]->id,
            ];
        })->values()->map(function ($good) use ($purchaseReceiveGoods) {
            $purchaseReceive = collect($purchaseReceiveGoods)->where('id', $good['id'])->first();
            $good['received_quantity'] = 0;
            if ($purchaseReceive !== null) {
                $good['received_quantity'] = $purchaseReceive['received_quantity'];
            }
            $availableQuantity = $good['pivot']['quantity'] - $good['received_quantity'];

            $good['receive_quantity'] = $availableQuantity;
            // $good['cause'] = 'defective';
            $good['finish'] = $good['received_quantity'] >= $good['pivot']['quantity'] ? 1 : 0;
            return $good;
        })->sortBy('finish')->values()->all();

 //return $selectedGoods;

;

        return view('purchase-order.receive', [
            'purchase_order' => $purchaseOrder,
            'selected_goods' => $selectedGoods,
        ]);
    }

  

    /**
     * Return goods from specific purchase order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function return($id)
    {
       
        $purchaseOrder = PurchaseOrder::with(['goods', 'supplier', 'fobItem', 'shipment'])->findOrFail($id);



        $purchaseReturnGoods = PurchaseReturn::with(['goods'])
            ->where('purchase_order_id', $id)
            ->get()
            ->flatMap(function ($purchaseReturn) {
                return $purchaseReturn->goods;
            })->groupBy('id')
            ->map(function ($group, $id) {
                $returnedQuantity = collect($group)->map(function ($goods) {
                    return $goods->pivot->quantity;
                })->sum();
                return [
                    'id' => $id,
                    'returned_quantity' => $returnedQuantity,
                ];
            })
            ->all();

        $purchaseReceiveGoods = PurchaseReceive::with(['goods'])
            ->where('purchase_order_id', $id)
            ->get()
            ->flatMap(function ($purchaseReceive) {
                return $purchaseReceive->goods;
            })->groupBy('id')
            ->map(function ($group, $id) {
                $receivedQuantity = collect($group)->map(function ($goods) {
                    return $goods->pivot->quantity;
                })->sum();
                return [
                    'id' => $id,
                    'received_quantity' => $receivedQuantity,
                ];
            })
            ->all();

        // return $saleReturnProducts;

        $selectedGoods = collect($purchaseOrder->goods)->each(function ($good) use ($purchaseReturnGoods, $purchaseReceiveGoods) {
            $purchaseReturn = collect($purchaseReturnGoods)->where('id', $good->id)->first();
            $purchaseReceive = collect($purchaseReceiveGoods)->where('id', $good->id)->first();
            $good['returned_quantity'] = 0;
            if ($purchaseReturn !== null) {
                $good['returned_quantity'] = $purchaseReturn['returned_quantity'];
            }
            $availableQuantity = $good->pivot->quantity - $good['returned_quantity'];

            $good['return_quantity'] = 0;
            $good['cause'] = 'defective';
            $good['finish'] = $good['returned_quantity'] >= $good->pivot->quantity ? 1 : 0;

            $good['received_quantity'] = $purchaseReceive !== null ? $purchaseReceive['received_quantity'] : 0;
        })->sortBy('finish')->values()->all();

       //  return $selectedGoods;

        return view('purchase-order.return', [
            'purchase_order' => $purchaseOrder,
            'selected_goods' => $selectedGoods,
        ]);
    }

        public function transaction($id)
    {
        
        $purchaseOrder = PurchaseOrder::with(['goods', 'supplier', 'fobItem', 'shipment','goods','purchaseTransactions'])->findOrFail($id);
        //return $purchaseOrder
        

        $purchaseReturnGoods = PurchaseReturn::with(['goods'])
            ->where('purchase_order_id', $id)
            ->get()
            ->flatMap(function ($purchaseReturn) {
                return $purchaseReturn->goods;
            })->groupBy('id')
            ->map(function ($group, $id) {
                $returnedQuantity = collect($group)->map(function ($goods) {
                    return $goods->pivot->quantity;
                })->sum();
                return [
                    'id' => $id,
                    'returned_quantity' => $returnedQuantity,
                ];
            })
            ->all();

        $purchaseReceiveGoods = PurchaseReceive::with(['goods'])
            ->where('purchase_order_id', $id)
            ->get()
            ->flatMap(function ($purchaseReceive) {
                return $purchaseReceive->goods;
            })->groupBy('id')
            ->map(function ($group, $id) {
                $receivedQuantity = collect($group)->map(function ($goods) {
                    return $goods->pivot->quantity;
                })->sum();
                return [
                    'id' => $id,
                    'received_quantity' => $receivedQuantity,
                ];
            })
            ->all();

        // return $saleReturnProducts;

        $selectedGoods = collect($purchaseOrder->goods)->each(function ($good) use ($purchaseReturnGoods, $purchaseReceiveGoods) {
            $purchaseReturn = collect($purchaseReturnGoods)->where('id', $good->id)->first();
            $purchaseReceive = collect($purchaseReceiveGoods)->where('id', $good->id)->first();
            $good['returned_quantity'] = 0;
            if ($purchaseReturn !== null) {
                $good['returned_quantity'] = $purchaseReturn['returned_quantity'];
            }
            $availableQuantity = $good->pivot->quantity - $good['returned_quantity'];

            $good['return_quantity'] = $availableQuantity;
            $good['cause'] = 'defective';
            $good['finish'] = $good['returned_quantity'] >= $good->pivot->quantity ? 1 : 0;

            $good['received_quantity'] = $purchaseReceive !== null ? $purchaseReceive['received_quantity'] : 0;
        })->sortBy('finish')->values()->all();

        // return $selectedGoods;
       // return $purchaseOrder->purchaseTransaction;

        return view('purchase-order.transaction', [
            'purchase_order' => $purchaseOrder,
            'selected_goods' => $selectedGoods,
            'purchase_transaction'=>$purchaseOrder->purchaseTransactions,
        
        ]);
    }
}
