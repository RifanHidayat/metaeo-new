<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Bast;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerPurchaseOrder;
use App\Models\DeliveryOrder;
use App\Models\EventQuotation;
use App\Models\Invoice;
use App\Models\OtherQuotationItem;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\V2Quotation;
use App\Models\V2SalesOrder;
use App\Models\v2SalesOrderItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bast.index');
    }

    /**
     * Send datatable form.
     *
     * @return \Yajra\DataTables\Facades\DataTables
     */
    public function indexData()
    {
        // $salesOrders = V2SalesOrder::with(['v2Quotation', 'customerPurchaseOrder', 'jobOrders', 'invoices', 'deliveryOrders'])->select('v2_sales_orders.*');
        // return $salesOrders;
        // $bast = Bast::with(['v2SalesOrderItem.v2SalesOrder','v2SalesOrderItem.picEvent.customer'])->select('basts.*');

         $bast = Bast::with(['deliveryOrder.v2SalesOrder','deliveryOrder.v2SalesOrder.customer','v2SalesOrderItem.picEvent.customer'])->select('basts.*');
        
       
         //return $bast;
          return DataTables::eloquent($bast)
            ->addIndexColumn()
           
           
            ->addColumn('action', function ($row) {
                $button = '
                <div class="text-center">';

                // if (count($row->jobOrders) < 1 && count($row->invoices) < 1 && count($row->deliveryOrders) < 1) {
                    $button .=    '<a href="/bast/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                    </g>
            </svg> </span> </a>';
                    $button .= '<a href="#" data-id="' . $row->id . '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                  <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                </g>
              </svg> </span> </a>';
               // }

                $button .= '<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                
                               
                                <li class="navi-item">
                                    <a href="/bast/print/' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Print</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>';
                $button .= '</div>
                ';
                return $button;
            })
            ->rawColumns(['quotation_number', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       

        $customers = Customer::all();
        return view('bast.create', [
            'customers' => $customers,
               'number' => 1,
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
       //return $request->all();
      //return $request->selected_data;
        DB::beginTransaction(); 
//v2_sales_order_items
      
        try {
            //return $request->all();

            //$v2SalesOrderItem=v2SalesOrderItem::find($item['id']); 
            if ($request->source=="other"){
            $bast = new Bast();
         
            
            $transactionsByCurrentDateCount = Bast::query()->where('date', $request->date)->get()->count();


            $bast->number = $request->number.'-'.sprintf('%03d', $transactionsByCurrentDateCount + 1);
            $bast->date = $request->bast_date;
            $bast->customer_id = 0;
            $bast->gr_number=$request->bast_gr_number;
            $bast->pic_event=$request->bast_pic_event;
            $bast->pic_event_position=$request->bast_pic_event_position;
            $bast->pic_magenta=$request->bast_pic_magenta;
            $bast->pic_magenta_position=$request->bast_pic_magenta_position;
            $bast->po_file=null;
            $bast->gr_file=null;
            $bast->amount=$request->bast_amount;
             $bast->type="other";
            //$bast->v2_sales_order_item_id=$request->id;
            $bast->delivery_order_id=$request->id;
            $bast->v2_sales_order_id=$request->sales_order_id;

         
            $bast->save();
               $salesOrder = V2SalesOrder::findOrFail($request->sales_order_id);

            $salesOrder->total_bast=$salesOrder->total_bast+$request->bast_amount;
            $salesOrder->save();

            DB::commit();
                
            }else{

            $bast = new Bast();
          
            $transactionsByCurrentDateCount = Bast::query()->where('date', $request->date)->get()->count();

            $bast->number = $request->number.'-'.sprintf('%03d', $transactionsByCurrentDateCount + 1);
            $bast->date = $request->bast_date;
            $bast->customer_id = 0;
            $bast->gr_number=$request->bast_gr_number;
            $bast->pic_event=$request->bast_pic_event;
            $bast->pic_event_position=$request->bast_pic_event_position;
            $bast->pic_magenta=$request->bast_pic_magenta;
            $bast->pic_magenta_position=$request->bast_pic_magenta_position;
            $bast->po_file=null;
            $bast->gr_file=null;
            $bast->type="event";
            $bast->amount=$request->bast_amount;
            //$bast->v2_sales_order_item_id=$request->id;
            $bast->delivery_order_id=$request->id;
            $bast->v2_sales_order_id=$request->sales_order_id;

         
            $bast->save();
              $salesOrder = V2SalesOrder::findOrFail($request->sales_order_id);

            $salesOrder->total_bast=$salesOrder->total_bast+$request->bast_amount;
            $salesOrder->save();

            DB::commit();

                
                
            }

         

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $bast,
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
          $bast = Bast::with(['eventQuotation','customer','eventQuotation.poQuotation'])->findOrFail($id);

             $quotations = EventQuotation::with(['items','subItems' , 'picEvent','picPo','customer','poQuotation'])
        ->where('id',$bast->event_quotation_id)
        ->get();

        $quotations=collect($quotations)->each(function($row){
            $otherQuotationItem=OtherQuotationItem::with('goods')->where('event_quotation_id',$row->id)->get();
            $row['other_quotation_items']=$otherQuotationItem;
            $items=collect($row['items'])->each(function($item) use ($row){ 
                $subitems=collect($row['subItems'])->filter(function($value) use ($item){
                    return $value['item_id']==$item['id'];
                })->values()->all();
                // $sum=collect($quotation['subItems'])->sum('pivot.subtotal');
                 $sum=collect($row['subItems'])->filter(function($value) use ($item){
                    return $value['item_id']==$item['id'];
                })->sum('pivot.subtotal');
                $item['subtotal']=$sum;
                $item['pivot']=$item['pivot'];
                $item['sub_items']=$subitems;
            });

        })->first();
        

        $customers = Customer::all();
        return view('bast.edit', [
            'customers' => $customers,
            'bast'=>$bast,
            'quotation'=>$quotations
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
        
        // $bastNumber = Bast::where('number', $request->number)->first();
        // if ($bastNumber !== null) {
        //     return response()->json([
        //         'message' => 'number or code already used',
        //         'code' => 400,
        //         // 'errors' => $/e,
        //     ], 400);
        // }
        DB::beginTransaction();
        try {

           
            
            $quotations=EventQuotation::findOrFail($request->event_quotation_id);
            $bast = Bast::findOrFail($id);
            $bast->number = $request->number;
            $bast->date = $request->date;
            $bast->customer_id = $request->customer_id;
            $bast->gr_number=$request->gr_number;
            $bast->pic_event=$request->event_pic_name;
            $bast->pic_event_position=$request->event_pic_position;
            $bast->pic_magenta=$request->magenta_pic_name;
            $bast->pic_magenta_position=$request->magenta_pic_position;
            $bast->po_file=null;
            $bast->gr_file=null;
            $bast->amount=$request->amount;
            
            $bast->event_quotation_id=$request->event_quotation_id;
            $bast->save();

            $quotations->total_bast=($quotations->total_bast-$request->amount_previously
            )+$request->amount;
            $quotations->save();
            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $bast,
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
              $bast=Bast::findOrFail($id);
            //   if ($bast!==null){
            //       $eventQuotation=EventQuotation::findOrFail($bast->event_quotation_id);
            //       $eventQuotation->total_bast=$eventQuotation->total_bast-$bast->amount;
            //       $eventQuotation->save();

            //   }
              $bast->delete();

              
   DB::commit();
            return response()->json([
                'message' => 'Data has been deleted',
                'code' => 200,
                'error' => false,
                'data' => null,
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


    public function print($id){
        $bast = Bast::with(['v2SalesOrderItem.picEvent.customer','v2SalesOrder.customerPurchaseOrder','v2SalesOrder.customer'])->findOrFail($id);
        // return $bast['v2SalesOrder'];
        //return $bast;


        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'mode' => 'utf-8',
            'orientation' => 'P',
            'margin_left' => 10,
            'margin_top' => 3,
            'margin_right' => 10,
            'margin_bottom' => 3,
        ]);

       

        $html = view('bast.print', [
            'bast' => $bast,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatablesQuotations(Request $request)
    {
    
            
         $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $quotations = EventQuotation::with(['items','subItems' , 'picEvent','picPo','customer','poQuotation'])
        ->where('po_quotation_id','!=',null)
       
        ->get();
        $quotations=collect($quotations)->each(function($row){
            $otherQuotationItem=OtherQuotationItem::with('goods')->where('event_quotation_id',$row->id)->get();
            $row['other_quotation_items']=$otherQuotationItem;
            $items=collect($row['items'])->each(function($item) use ($row){ 
                $subitems=collect($row['subItems'])->filter(function($value) use ($item){
                    return $value['item_id']==$item['id'];
                })->values()->all();
                // $sum=collect($quotation['subItems'])->sum('pivot.subtotal');
                 $sum=collect($row['subItems'])->filter(function($value) use ($item){
                    return $value['item_id']==$item['id'];
                })->sum('pivot.subtotal');
                $item['subtotal']=$sum;
                $item['pivot']=$item['pivot'];
                $item['sub_items']=$subitems;
            });

        });
        return DataTables::of($quotations)
            ->addIndexColumn()
            ->addColumn('bastRemaining',function(EventQuotation $quotation){
                return $quotation->netto - $quotation->total_bast;
            })
            ->addColumn('action', function (EventQuotation $quotation) {
                if (($quotation->netto-$quotation->total_bast) === 0) {
                  $content = '<button class="btn btn-light-success"><i class="flaticon2-check-mark"></i></button>';
                } else {
                    $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                }
                return $content;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatablesCustomerPurchaseOrders(Request $request)
    {
        $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $customerPurchaseOrders = CustomerPurchaseOrder::with(['items', 'v2SalesOrder', 'customer'])
            ->get();
        // ->filter(function ($quotation) {
        //     return count($quotation->salesOrders) < 1;
        // })->all();

        return DataTables::of($customerPurchaseOrders)
            ->addIndexColumn()
            ->addColumn('action', function (CustomerPurchaseOrder $purchaseOrder) {
                if ($purchaseOrder->v2SalesOrder != null) {
                    $content = '<a href="/sales-order/detail/' . $purchaseOrder->v2SalesOrder->id . '" target="_blank"><span class="label label-success label-inline">#' . $purchaseOrder->v2SalesOrder->number . '</span></a>';
                } else {
                    $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                }
                return $content;
            })
            ->rawColumns(['action'])
            ->make(true);
            
    }

        public function datatablesSalesOrders(Request $request)
    {
        $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        // $salesOrders = V2SalesOrder::with(['deliveryOrders' => function ($query) {
        //     return $query->with(['cpoItems', 'v2QuotationItems', 'invoices']);
        // }])->select('v2_sales_orders.*')->get();
        // ->filter(function ($quotation) {
        //     return count($quotation->salesOrders) < 1;
        // })->all();

        //$salesOrders = V2SalesOrder::select('v2_sales_orders.*');
        // $salesOrders = collect(V2SalesOrder::with(['v2SalesOrderItems','v2SalesOrderItems.picEvent.customer','customerPurchaseOrder'])->select('v2_sales_orders.*')->get())
        // $salesOrders = collect(V2SalesOrder::with(['v2SalesOrderItems','v2SalesOrderItems.picEvent.customer','customerPurchaseOrder'])->select('v2_sales_orders.*')->get())
         $salesOrders = collect(V2SalesOrder::with(['customer','customerPurchaseOrder'])->select('v2_sales_orders.*')->get())
        ->filter(function($item){
           // if ($item->netto-$item->total_bast<0){
                return $item->netto-$item->total_bast>0;
            //}
            // collect($item->v2SalesOrderItems)->filter(function($item){
            //    return (($item->netto)-($item->total_bast)0);

            //     // $item['bast_number']="";
            //     // $item['bast_gr_number']="";
            //     // $item['bast_date']="";
            //     // $item['bast_pic_event']=$item['picEvent']['name'];
            //     // $item['bast_pic_event_position']=$item['picEvent']['position'];
            //     // $item['bast_customer']=$item['picEvent']['customer']['name'];
            //     // $item['bast_pic_magenta']="Myrawati Setiawan";
            //     // $item['bast_pic_magenta_position']="Project Magenta";
            //     // $item['bast_po_file']="";
            //     // $item['bast_gr_file']="";
                
                
            //     // $item['bast_amount']=$item['total']-$item['total_bast'];
            //     // $item['is_checked']=0;
            //     // $item['bast_remaining']=$item['total']-$item['total_bast'];
                  
            // });
            
        });

        return DataTables::of($salesOrders)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                
                $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                return $button;
            })
            ->addColumn('bast_remaining',function($row){
                return $row->netto-$row->total_bast;

            })
            ->rawColumns(['action'])
        
            ->make(true);
    }


          public function datatablesDeliveryOrders(Request $request)
    {
        $customerId = $request->query('customer_id');
       
         $salesOrders = collect(DeliveryOrder::with(['bast','deliveryOrderOtherQuotationItems.otherQuotationItem','v2SalesOrder.customerPurchaseOrder','v2SalesOrder.customer','v2SalesOrder.eventQuotation'])->select('delivery_orders.*')->get());
     

        return DataTables::of($salesOrders)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
               if ($row->bast==null){
                     $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';

               }else{
                     $button = '';

               }
                
              
                return $button;
            })
            ->addColumn('bast_remaining',function($row){
                return $row->netto-$row->total_bast;

            })
            ->rawColumns(['action'])
        
            ->make(true);
    }
}
