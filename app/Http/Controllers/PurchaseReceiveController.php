<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Goods;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceive;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchaseReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase-receive.index');
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
       // return "tes";
        $purchaseReceives = PurchaseReceive::with('purchaseOrder')->select('purchase_receives.*');
        return DataTables::eloquent($purchaseReceives)
            ->addIndexColumn()
            ->addColumn('purchase_order_number',function($row){
                return $row->purchaseOrder!=null?$row->purchaseOrder->number:"";
            })
            ->addColumn('action', function ($row) {
                $button = '<div class="text-center">';
                $button .= '<a href="/purchase-receive/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                                    <a href="/purchase-receive/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak</span>
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
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();

        DB::beginTransaction();
        
        $date=$request->date;
        $transactionsByCurrentDateCount = PurchaseReceive::query()->where('date', $date)->get()->count();
        $number = 'PR'.'-' . $this->formatDate($date, "d") . $this->formatDate($date, "m") . $this->formatDate($date, "y") . '-' . sprintf('%04d', $transactionsByCurrentDateCount + 1);
        $purchaseReceiveWithNumber = PurchaseReceive::where('number', $number)->first();

        


        if ($purchaseReceiveWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        try {
            // Create Purchase Order
            

            $purchaseReceive = new PurchaseReceive();
            
            
            // $purchaseOrder=PurchaseOrder::find($request->purchase_order_id);
            $purchaseReceive->number = $number;
            $purchaseReceive->date = $request->date;
            $purchaseReceive->shipper = $request->shipper;
            $purchaseReceive->recipient = $request->recipient;
            $purchaseReceive->description = $request->description;
            $purchaseReceive->send_number = $request->send_number;
            $purchaseReceive->invoice_number = $request->invoice_number;
            $purchaseReceive->invoice_date = $request->invoice_date;
            $purchaseReceive->purchase_order_id = $request->purchase_order_id;
            $purchaseReceive->quantity = $request->quantity;
            $purchaseReceive->subtotal = $request->subtotal;
            $purchaseReceive->discount = $request->discount;
            $purchaseReceive->ppn = $request->ppn;
            $purchaseReceive->pph = $request->pph;
            $purchaseReceive->total = $request->subtotal+$request->ppn-$request->pph-$request->discount;

            $purchaseReceive->save();
            // Attach Goods
            $selectedGoods = $request->selected_goods;
            $goods = collect($selectedGoods)->map(function ($item) use ($purchaseReceive) {
                return [
                    'purchase_receive_id' => $purchaseReceive->id,
                    'goods_id' => $item['id'],
                    'quantity' => $item['receive_quantity'],
                    // 'description' => $item['description'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

            // $purchaseReceive->goods()->attach($goods);
            if (count($goods) > 0) {
                DB::table('goods_purchase_receive')->insert($goods);

                foreach ($selectedGoods as $good) {
                    $goodsData = Goods::find($good['id']);
                    if ($goodsData == null) {
                        continue;
                    }

                    $goodsData->stock = $goodsData->stock + $good['receive_quantity'];
                    $goodsData->save();
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchaseReceive,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
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

    public function print($id){
        $purchaseReceive=PurchaseReceive::with(['goods','purchaseOrder.supplier'])->findOrfail($id);
       /// return $purchaseReceive;
        
    // $purchaseOrder=PurchaseOrder::with(['goodsPurchaseOrders','supplier'])->findOrFail($id);
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

        $html = view('purchase-receive.print', [
            'goods' => $purchaseReceive->goods,
            'purchase_order'=>$purchaseReceive,
            'company'=>$compny
        ]);

        // return $jobOrder;
        $mpdf->WriteHTML($html);
        $mpdf->Output();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseReceive=PurchaseReceive::with(['goods'])->findOrFail($id);

              $purchaseOrder = PurchaseOrder::with(['goods.pphRates', 'supplier', 'fobItem', 'shipment'])->findOrFail($purchaseReceive->purchase_order_id);
        //return $purchaseOrder;
       // return $purchaseOrder->goods;
        $purchaseReceiveGoods = PurchaseReceive::with(['goods'])
            ->where('purchase_order_id', $purchaseReceive->purchase_order_id)
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
            $good['finish'] =  0;
           // $good['finish'] = $good['received_quantity'] >= $good['pivot']['quantity'] ? 1 : 0;
            
            return $good;
        })->each(function($item){
            

        })->sortBy('finish')->all();

     //   return $selectedGoods;
     $selectedGoods=collect($selectedGoods)->map(function($goods) use ($purchaseReceive){
         $quantity=collect($purchaseReceive->goods)->filter(function($item) use ($goods){
             return $item->id==$goods['id'];
         })->sum('pivot.quantity');

        
        $goods['received_quantity']=$goods['received_quantity']-$quantity;
        $goods['receive_quantity']=$quantity;
        $goods['previous_quantity']=$quantity;
      
        return $goods;

     })->values()->all();

     
 // return $selectedGoods;
          
      

        return view('purchase-receive.edit', [
            'purchase_order' => $purchaseOrder,
            'selected_goods' => $selectedGoods,
            'purchase_receive'=>$purchaseReceive
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
        
              //return $request->all();
        DB::beginTransaction();
        try {
            // Create Purchase Order
            
            $purchaseReceive = PurchaseReceive::findOrFail($id);
           

            // $purchaseOrder=PurchaseOrder::find($request->purchase_order_id);

           
            $purchaseReceive->date = $request->date;
            $purchaseReceive->shipper = $request->shipper;
            $purchaseReceive->recipient = $request->recipient;
            $purchaseReceive->description = $request->description;
            $purchaseReceive->send_number = $request->send_number;
            $purchaseReceive->invoice_number = $request->invoice_number;
            $purchaseReceive->invoice_date = $request->invoice_date;
            $purchaseReceive->purchase_order_id = $request->purchase_order_id;
            $purchaseReceive->quantity = $request->quantity;
            $purchaseReceive->subtotal = $request->subtotal;
            $purchaseReceive->discount = $request->discount;
            $purchaseReceive->ppn = $request->ppn;
            $purchaseReceive->pph = $request->pph;
            $purchaseReceive->total = $request->subtotal+$request->ppn-$request->pph-$request->discount;

            $purchaseReceive->save();
             DB::table('goods_purchase_receive')->where('purchase_receive_id',$purchaseReceive->id)->delete();

            // Attach Goods
            $selectedGoods = $request->selected_goods;
            $goods = collect($selectedGoods)->map(function ($item) use ($purchaseReceive) {
                return [
                    'purchase_receive_id' => $purchaseReceive->id,
                    'goods_id' => $item['id'],
                    'quantity' => $item['receive_quantity'],
                    // 'description' => $item['description'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

            // $purchaseReceive->goods()->attach($goods);
            if (count($goods) > 0) {
                DB::table('goods_purchase_receive')->insert($goods);

                foreach ($selectedGoods as $good) {
                    $goodsData = Goods::find($good['id']);
                    if ($goodsData == null) {
                        continue;
                    }
                    

                    $goodsData->stock = ($goodsData->stock- $good['previous_quantity']) + $good['receive_quantity'];
                    $goodsData->save();
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchaseReceive,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
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

             //
    DB::beginTransaction();
    
    try{
        $purchase=PurchaseReceive::findOrFail($id);
        DB::table('purchase_transaction_purchase_receive')->where('purchase_receive_id',$purchase->id)->delete();
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

   
}
