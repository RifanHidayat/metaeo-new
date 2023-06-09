<?php




namespace App\Http\Controllers\v2;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPurchaseOrder;
use App\Models\EventQuotation;
use App\Models\OtherQuotationItem;
use App\Models\PicEvent;
use App\Models\PurchaseOrder;
use App\Models\V2Quotation;
use App\Models\V2SalesOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales-order.v2.index');
    }

        private function formatDate($date = "", $format = "Y-m-d")
    {
        return date_format(date_create($date), $format);
    }

    /**
     * Send datatable form.
     *
     * @return \Yajra\DataTables\Facades\DataTables
     */
    public function indexData()
    {
        $salesOrders = V2SalesOrder::with(['v2Quotation', 'customerPurchaseOrder.eventQuotations', 'jobOrders', 'invoices', 'deliveryOrders','eventQuotation'])->select('v2_sales_orders.*');
        //return $salesOrders->get();
        
        return DataTables::eloquent($salesOrders)
            ->addIndexColumn()
            ->addColumn('quotation_po_number', function (V2SalesOrder $salesOrder) {
               
                if ($salesOrder->source == 'quotation') {
                    // return $salesOrder->v2Quotation->number;
                    if ($salesOrder->v2Quotation !== null) {
                        return $salesOrder->v2Quotation->number;
                    } else {
                        return '';
                    }
                } else if ($salesOrder->source == 'purchase_order') {
                    if ($salesOrder->customerPurchaseOrder != null) {
                        return  $salesOrder->customerPurchaseOrder->number;
                    } else {
                        return '';
                    }
                } else {
                    return '';
                }

            })
            ->addColumn('quotation_po_date', function (V2SalesOrder $salesOrder) {
                // return $salesOrder->v2Quotation->map(function ($quotation) {
                //     return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $quotation->number . '</span>';
                // })->implode("");
                if ($salesOrder->source == 'quotation') {
                    // return $salesOrder->v2Quotation->number;
                    if ($salesOrder->v2Quotation !== null) {
                        return $salesOrder->v2Quotation->date;
                    } else {
                        return '';
                    }
                } else if ($salesOrder->source == 'purchase_order') {
                    if ($salesOrder->customerPurchaseOrder !== null) {
                        return  $salesOrder->customerPurchaseOrder->date;
                    } else {
                        return '';
                    }
                } else {
                    return '';
                }
            })
            ->addColumn('other_number',function($row){
               if ($row->source=="quotation"){
                    if ($row->v2Quotation!=null){
                    return $row->v2Quotation->number;
                }
                 if ($row->eventQuotation!=null){
                    return $row->eventQuotation->number;
                }
                return "";
               }else if ($row->source=="purchase_order"){
                   return $row->customerPurchaseOrder->number;

               }
        

            })
             ->addColumn('other_date',function($row){
                    if ($row->source=="quotation"){
                     if ($row->v2Quotation!=null){
                    return $row->v2Quotation->date;
                }
                 if ($row->eventQuotation!=null){
                    return $row->eventQuotation->date;
                }
              
               }else if ($row->source=="purchase_order"){
                   return $row->customerPurchaseOrder->date;

               }
               
                return "";
        

            })
            ->addColumn('netto',function($row){
                if ($row->source=="quotation"){
                      
                    if ($row->eventQuotation!=null){
                    return $row->eventQuotation->netto;
                }else{
                    return $row->netto;
                }
              
                }else{
                    return collect($row->customerPurchaseOrder->eventQuotations)->sum('netto');
                }
              
            })
            ->addColumn('payment',function($row){
                return $row->payment;
            })
             ->addColumn('remaining_payment',function($row){
                

                 if ($row->source=="quotation"){
                      
                      if ($row->eventQuotation!=null){
                   return $row->eventQuotation->netto-$row->payment;
                   

                }else{
                    return "0";
                }
              
                }else{
                   return collect($row->customerPurchaseOrder->eventQuotations)->sum('netto')-$row->payment;
                }
            })
            
            ->addColumn('action', function ($row) {
                $button = '
                <div class="text-center">';

                if (count($row->jobOrders) < 1 && count($row->invoices) < 1 && count($row->deliveryOrders) < 1) {
                    $button .=    '<a href="/sales-order/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                }

                // $button .= '<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                //         <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                //             <i class="ki ki-bold-more-hor"></i>
                //         </a>
                //         <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                //             <!--begin::Navigation-->
                //             <ul class="navi navi-hover">
                //                 <li class="navi-item">
                //                     <a href="/spk/create?so=' . $row->id . '" class="navi-link">
                //                         <span class="navi-icon">
                //                             <i class="flaticon2-reload"></i>
                //                         </span>
                //                         <span class="navi-text">Buat SPK</span>
                //                     </a>
                //                 </li>
                //                 <li class="navi-item">
                //                     <a href="/delivery-order/create?so=' . $row->id . '" class="navi-link">
                //                         <span class="navi-icon">
                //                             <i class="flaticon2-lorry"></i>
                //                         </span>
                //                         <span class="navi-text">Buat Delivery Order</span>
                //                     </a>
                //                 </li>
                //                 <li class="navi-item">
                //                     <a href="/invoice/create?so=' . $row->id . '" class="navi-link">
                //                         <span class="navi-icon">
                //                             <i class="flaticon2-file"></i>
                //                         </span>
                //                         <span class="navi-text">Buat Faktur</span>
                //                     </a>
                //                 </li>
                //             </ul>
                //             <!--end::Navigation-->
                //         </div>
                //     </div>';
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
        $picEvents=PicEvent::with('customer')->get();
      
        return view('sales-order.v2.create', [
            'customers' => $customers,
            'pic_events'=>$picEvents
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
      
        DB::beginTransaction();
        // return $request->selected_data['data']['event_quotations'];
        // $salesOrderWithNumber = V2SalesOrder::where('number', $request->number)->first();

        // if ($salesOrderWithNumber !== null) {
        //     return response()->json([
        //         'message' => 'number or code already used',
        //         'code' => 400,
        //         // 'errors' => $/e,
        //     ], 400);
        // }
        $transactionsByCurrentDateCount = CustomerPurchaseOrder::query()->where('date', $request->date)->get()->count();
            $number = 'SO-' . $this->formatDate($request->date, "d") . $this->formatDate($request->date, "m") . $this->formatDate($request->date, "y") . '-' . sprintf('%04d', $transactionsByCurrentDateCount + 1);


        try {

            $salesOrder = new V2SalesOrder();
            // $salesOrder->number = $request->number;
            $salesOrder->date = $request->date;
            $salesOrder->number = $number;
         
            $salesOrder->source = $request->source;
            $salesOrder->quotation_number = $request->quotation_number;
            $salesOrder->quotation_date = $request->quotation_date;
            $salesOrder->v2_quotation_id = $request->quotation_id;
            $salesOrder->customer_purchase_order_number = $request->purchase_order_number;
            $salesOrder->customer_purchase_order_date = $request->purchase_order_date;
            $salesOrder->netto= $request->netto;
            $salesOrder->total_bast= 0;
            
           
            $salesOrder->description = $request->description;
            $salesOrder->term_of_payment = $request->term_of_payment;
            $salesOrder->due_date = $request->due_date;

           if ($request->source=="quotation"){
                $salesOrder->customer_id=$request->customer_id_event;
               if (($request->selected_data['data']['source']=="event") || ($request->selected_data['data']['source']=="other")){
                   $salesOrder->event_quotation_id=$request->selected_data['data']['id'];
                   

               }else{
                   $salesOrder->v2_quotation_id=$request->selected_data['data']['id'];

               }
            


           }else{
                if (($request->selected_data['data']['source']=="event") || ($request->selected_data['data']['source']=="other")){
                $salesOrder->customer_purchase_order_id = $request->selected_data['data']['id'];
                $salesOrder->customer_id=$request->customer_id_event;
            }else{
                $salesOrder->customer_id = $request->customer_id;
                $salesOrder->customer_purchase_order_id = $request->purchase_order_id;

            }
           }
           
        //     if ($request->selected_data['data']['source']=="quotation"){
        //          $salesOrder->customer_id= $request->customer_id_event;


        // //           $keyedQuotations = collect($request->selected_data['data']['event_quotations'])->mapWithKeys(function ($item) use($salesOrder) {
        // //     return [
        // //         $item['id']=>[

        // //             'v2_sales_order_id' => $salesOrder->id,
                
        // //             'pic_event_id'=>$item['pic_event']['id'],
        // //             'total'=>$item['netto'],
        // //             'created_at' => Carbon::now()->toDateTimeString(),
        // //             'updated_at' => Carbon::now()->toDateTimeString(),

        // //         ]
                  
        // //     ];
        // // })->all();
        // //      $salesOrder->eventQuotations()->attach($keyedQuotations);

        // //   $items = collect($request->selected_data['data']['event_quotations'])->map(function ($item) use ($salesOrder) {
        // //         return [
        // //             'v2_sales_order_id' => $salesOrder['id'],
        // //             'total'=>$item['netto'],
        // //             'pic_event_id'=>$item['pic_event_id'],
        // //             'created_at' => Carbon::now()->toDateTimeString(),
        // //             'updated_at' => Carbon::now()->toDateTimeString(),
        // //         ];
        // //     })->all();

        // //      DB::table('v2_sales_order_items')->insert($items);
      
                

        //      }
              $salesOrder->save();

 DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $salesOrder,
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
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return "Tes";
         DB::beginTransaction();
        //
        try{
             $salesOrder = V2SalesOrder::findOrFail($id);
         if ($salesOrder->source=='purchase_order'){
              DB::table('v2_sales_order_items')->where('id', '==', $salesOrder)->delete();
                $salesOrder->delete();
               DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
             
            ]);
             
         }else{
             
               $salesOrder->delete();
         }
          DB::commit();

             return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $salesOrder,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatablesQuotations(Request $request)
    {
        $customerId = $request->query('customer_id');
        $otherQuotationItems=OtherQuotationItem::all();
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $quotations = collect(V2Quotation::with(['items', 'v2SalesOrder', 'customer'])
            ->get())->each(function($item){
                $item['source']='metaprint';
            });
        $eo_quotations = collect(EventQuotation::with(['v2SalesOrder','customerPurchaseOrder','otherQuotationItems','subItems.item','customer'])
            ->get())->each(function($item) use($otherQuotationItems){

                $number=substr($item['number'],0,2);
                if ($number=="QE"){
                    $item['source']="event";
                }else{
                     $item['source']="other";
                     $item['other_quotation_item']=$otherQuotationItems->where('event_quotation_id','=',$item['id'])->values()->all();

                }
                
            })->filter(function($item){
                return count($item->customerPurchaseOrder)<=0;
            })->values()->all();
         $quotations=$quotations->concat($eo_quotations);
       
       

        return DataTables::of($quotations)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->source=="metaprint"){
                    if ($row->v2SalesOrder !== null) {
                    $content = '<a href="/sales-order/detail/.' . $row->v2SalesOrder->id . '" target="_blank"><span class="label label-info label-inline">#' . $row->v2SalesOrder->number . '</span></a>';
                } else {
                    $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                }
                }else if (($row->source=="event") ||($row->source=="other")){
                     if ($row->v2SalesOrder !== null) {
                    $content = '<a href="/sales-order/detail/.' . $row->v2SalesOrder->id . '" target="_blank"><span class="label label-info label-inline">#' . $row->v2SalesOrder->number . '</span></a>';
                } else {
                    $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                }
                }else{
                    $content="";
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
        $customerPurchaseOrders = CustomerPurchaseOrder::with(['items', 'v2SalesOrder', 'customer','eventQuotations','eventQuotations.customer','eventQuotations.picEvent.customer'])
            ->get();
         //   return "tes";
            
        // ->filter(function ($quotation) {
        //     return count($quotation->salesOrders) < 1;
        // })->all();

        return DataTables::of($customerPurchaseOrders)
            ->addIndexColumn()
            ->addColumn('action', function (CustomerPurchaseOrder $purchaseOrder) {
                if ($purchaseOrder->v2SalesOrder !== null) {
                    $content = '<a href="/sales-order/detail/' . $purchaseOrder->v2SalesOrder->id . '" target="_blank"><span class="label label-success label-inline">#' . $purchaseOrder->v2SalesOrder->number . '</span></a>';
                }else {
                    $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                }
                return $content;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
