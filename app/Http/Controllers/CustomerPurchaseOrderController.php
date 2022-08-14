<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CpoItem;
use App\Models\Customer;
use App\Models\CustomerPurchaseOrder;
use App\Models\EventQuotation;
use App\Models\FobItem;
use App\Models\Goods;
use App\Models\OtherQuotationItem;
use App\Models\Shipment;
use App\Models\Supplier;
use App\Models\V2Quotation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomerPurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer-purchase-order.index');
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
        $purchaseOrders = CustomerPurchaseOrder::with(['items', 'v2SalesOrder'])->select('customer_purchase_orders.*');
        return DataTables::eloquent($purchaseOrders)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                
            
                $button = ' <div class="text-center">';
                if ($row->v2SalesOrder == null) {
                    $button .= ' <a href="/customer-purchase-order/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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

                $button .= '<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-item">
                                    <a href="/customer-purchase-order/print/' . $row->id . '" target="_blank" class="navi-link">
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
        $customers = Customer::all();

        return view('customer-purchase-order.create', [
            'customers' => $customers,
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
        $cpoWithNumber = CustomerPurchaseOrder::where('number', $request->number)->first();
        if ($cpoWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

    
        DB::beginTransaction();

        try {

            $cpo = new CustomerPurchaseOrder();
            
            $cpo->number = $request->number;
            $cpo->date = $request->date;
            $cpo->description = $request->description;
            $cpo->subtotal = $request->subtotal;
            $cpo->ppn = $request->ppn;
            $cpo->ppn_value = $request->ppn_value;
            $cpo->ppn_amount = $request->ppn_amount;
            $cpo->pph23 = $request->pph23;
            $cpo->pph23_value = $request->pph23_value;
            $cpo->pph23_amount = $request->pph23_amount;
            $cpo->other_cost = $request->other_cost;
            $cpo->other_cost_description = $request->other_cost_description;
            $cpo->total = $request->total;
            $cpo->customer_id = $request->customer_id;
            $cpo->title=$request->title;
            $cpo->save();

            $items = collect($request->items)->map(function ($item) use ($cpo) {
                return [
                    'customer_purchase_order_id' => $cpo->id,
                    'code' => $item['code'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'delivery_date' => $item['deliveryDate'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'amount' => $item['amount'],
                    'tax_code' => $item['taxCode'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

            DB::table('cpo_items')->insert($items);

            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $cpo,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseOrder = CustomerPurchaseOrder::with(['items'])->findOrFail($id);
        $customers = Customer::all();

        $items = collect($purchaseOrder->items)->map(function ($item) {
            return [
                'code' => $item->code,
                'name' => $item->name,
                'description' => $item->description,
                'deliveryDate' => $item->delivery_date,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'amount' => $item->amount,
                'taxCode' => $item->tax_code,
            ];
        })->all();

        return view('customer-purchase-order.edit', [
            'purchase_order' => $purchaseOrder,
            'customers' => $customers,
            'items' => $items,
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
        $cpoWithNumber = CustomerPurchaseOrder::whereNotIn('id', [$id])->where('number', $request->number)->first();
        if ($cpoWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        DB::beginTransaction();

        try {

            $cpo = CustomerPurchaseOrder::find($id);
            $cpo->number = $request->number;
            $cpo->date = $request->date;
            $cpo->description = $request->description;
            $cpo->subtotal = $request->subtotal;
            $cpo->ppn = $request->ppn;
            $cpo->ppn_value = $request->ppn_value;
            $cpo->ppn_amount = $request->ppn_amount;
            $cpo->pph23 = $request->pph23;
            $cpo->pph23_value = $request->pph23_value;
            $cpo->pph23_amount = $request->pph23_amount;
            $cpo->other_cost = $request->other_cost;
            $cpo->other_cost_description = $request->other_cost_description;
            $cpo->total = $request->total;
            $cpo->customer_id = $request->customer_id;
            $cpo->save();

            $items = collect($request->items)->map(function ($item) use ($cpo) {
                return [
                    'customer_purchase_order_id' => $cpo->id,
                    'code' => $item['code'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'delivery_date' => $item['deliveryDate'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'amount' => $item['amount'],
                    'tax_code' => $item['taxCode'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

            $cpo->items()->delete();

            DB::table('cpo_items')->insert($items);

            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $cpo,
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

        public function updateQuotation(Request $request, $id)
    {
              // return $request->items;
        // $cpoWithNumber = CustomerPurchaseOrder::where('number', $request->number)->first();
        // if ($cpoWithNumber !== null) {
        //     return response()->json([
        //         'message' => 'number or code already used',
        //         'code' => 400,
        //         // 'errors' => $/e,
        //     ], 400);
        // }

        DB::beginTransaction();

        try {


            $cpo = CustomerPurchaseOrder::findOrFail($id);
            $cpo->number = $request->number;
            $cpo->date = $request->date;
            $cpo->description = $request->description;
            $cpo->subtotal = $request->subtotal;
            $cpo->ppn = $request->ppn;
            $cpo->ppn_value = $request->ppn_value;
            $cpo->ppn_amount = $request->ppn_amount;
            $cpo->pph23 = $request->pph23;
            $cpo->pph23_value = $request->pph23_value;
            $cpo->pph23_amount = $request->pph23_amount;
            $cpo->other_cost = $request->other_cost;
            $cpo->other_cost_description = $request->other_cost_description;
            $cpo->total = $request->total;
             $cpo->source = 'quotation';
            $cpo->customer_id = 0;
            $cpo->save();
            $cpo->eventQuotations()->detach();

            // $items = collect($request->items)->map(function ($item) use ($cpo) {
            //     return [
            //         'customer_purchase_order_id' => $cpo->id,
            //         'code' => $item['code'],
            //         'name' => $item['name'],
            //         'description' => $item['description'],
            //         'delivery_date' => $item['deliveryDate'],
            //         'quantity' => $item['quantity'],
            //         'price' => $item['price'],
            //         'amount' => $item['amount'],
            //         'tax_code' => $item['taxCode'],
            //         'created_at' => Carbon::now()->toDateTimeString(),
            //         'updated_at' => Carbon::now()->toDateTimeString(),
            //     ];
            // })->all();

                 $keyedQuotations = collect($request->items)->mapWithKeys(function ($item) use($cpo) {
            return [
                $item['id']=>[
                    'customer_purchase_order_id' => $cpo->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]    
            ];
        })->all();
             $cpo->eventQuotations()->attach($keyedQuotations);

            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $cpo,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'1',
            ], 500);
        }
    }

    public function storeQuotation(Request $request)
    {
       //return $request->all();
       // return $request->items;

        // $cpoWithNumber = CustomerPurchaseOrder::where('number', $request->number)->first();
        // if ($cpoWithNumber !== null) {
        //     return response()->json([
        //         'message' => 'number or code already used',
        //         'code' => 400,
        //         // 'errors' => $/e,
        //     ], 400);
        // }
            

            
            $transactionsByCurrentDateCount = CustomerPurchaseOrder::query()->where('date', $request->date)->get()->count();
            $number = 'PO-' . $this->formatDate($request->date, "d") . $this->formatDate($request->date, "m") . $this->formatDate($request->date, "y") . '-' . sprintf('%04d', $transactionsByCurrentDateCount + 1);

    
        DB::beginTransaction();

        try {
         
            $cpo = new CustomerPurchaseOrder();
            // $cpo->number = $request->number;
            $cpo->number = $number;
            $cpo->title = $request->title;
            $cpo->date = $request->date;
            $cpo->description = $request->description;
            $cpo->subtotal = $request->subtotal;
            $cpo->ppn = $request->ppn;
            $cpo->ppn_value = $request->ppn_value;
            $cpo->ppn_amount = $request->ppn_amount;
            $cpo->pph23 = $request->pph23;
            $cpo->pph23_value = $request->pph23_value;
            $cpo->pph23_amount = $request->pph23_amount;
            $cpo->other_cost = $request->other_cost;
            $cpo->other_cost_description = $request->other_cost_description;
            $cpo->total = $request->total;
            $cpo->source = $request->source;
            $cpo->customer_id = 0;
            $cpo->save();

            // $items = collect($request->items)->map(function ($item) use ($cpo) {
            //     return [
            //         'customer_purchase_order_id' => $cpo->id,
            //         'code' => $item['code'],
            //         'name' => $item['name'],
            //         'description' => $item['description'],
            //         'delivery_date' => $item['deliveryDate'],
            //         'quantity' => $item['quantity'],
            //         'price' => $item['price'],
            //         'amount' => $item['amount'],
            //         'tax_code' => $item['taxCode'],
            //         'created_at' => Carbon::now()->toDateTimeString(),
            //         'updated_at' => Carbon::now()->toDateTimeString(),
            //     ];
            // })->all();

                 $keyedQuotations = collect($request->items)->mapWithKeys(function ($item) use($cpo) {
            return [
                $item['id']=>[
                    	
                    'customer_purchase_order_id' => $cpo->id,
               
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),

                ]
                  
            ];
        })->all();
             $cpo->eventQuotations()->attach($keyedQuotations);

            

            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $cpo,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'1',
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
        DB::beginTransaction();
        $customerPurchaseOrder=CustomerPurchaseOrder::findOrFail($id);


        
        try{
            if (($customerPurchaseOrder->source=="event") || ($customerPurchaseOrder->source=="other")){
                $customerPurchaseOrder->eventQuotations()->detach();
            $customerPurchaseOrder->delete();

             DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' =>[],
            ]);

            }else{
                  $customerPurchaseOrder->delete();
                
            }
            
         
            
        }catch(Exception $e){
             DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'1',
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $cpo = CustomerPurchaseOrder::with(['items', 'customer','eventQuotations'])->findOrFail($id);
        // /return $cpo;
      
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A5',
            'mode' => 'utf-8',
            'orientation' => 'L',
            'margin_left' => 3,
            'margin_top' => 3,
            'margin_right' => 3,
            'margin_bottom' => 3,
        ]);

        $company = Company::all()->first();

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }

        if ($cpo->source=="event"){
            $html = view('customer-purchase-order.quotation.print', [
            'company' => $company,
            'cpo' => $cpo,
        ]);
        }
         if ($cpo->source=="metaprint"){
             $html = view('customer-purchase-order.quotation.print', [
            'company' => $company,
            'cpo' => $cpo,
        ]);

        }
         if ($cpo->source=="other"){
             $html = view('customer-purchase-order.quotation.print', [
            'company' => $company,
            'cpo' => $cpo,
        ]);

        }
        

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    //customer Purchase order quotati'

    public function createQuotation(){
       
        

        return view('customer-purchase-order.quotation.create', [
           
        ]);

    }

    public function editQuotation($id){
       // return $id;

        $customerPurchaseOrder=CustomerPurchaseOrder::with(['eventQuotations.customer','eventQuotations.picEvent'])->findOrFail($id);
       // return $customerPurchaseOrder->eventQuotations;
        return view('customer-purchase-order.quotation.edit', [
            "customer_purchase_order"=>$customerPurchaseOrder,
            "selected_data"=>$customerPurchaseOrder->eventQuotations,
            "id"=>$id
        ]);


    }
    
    

      public function datatablesQuotations(Request $request)
    {
        //return "tes";
    
            
        $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        // $quotations = EventQuotation::with(['items','subItems' , 'picEvent','picPo','customer','poQuotation','customerPurchaseOrder'])
       
       
        // ->get();
         $quotations = EventQuotation::with(['picEvent','picPo','customer','poQuotation','customerPurchaseOrder','v2SalesOrder'])
       
       
        ->get()->where('v2SalesOrder','==',null);
        //return $quotations;

        return DataTables::of($quotations)
            ->addIndexColumn()
            ->addColumn('bastRemaining',function(EventQuotation $quotation){
                return $quotation->netto - $quotation->total_bast;
            })
            ->addColumn('customer_name', function ($row) {
               $name=$row->customer->name!=null?$row->customer->name:"";
                return $name;
            })
             ->addColumn('action', function ($row) {
                if (count($row->customerPurchaseOrder) > 0) {
                  
                     $content = '<button class="btn btn-light-success"><i class="flaticon2-check-mark"></i></button>';
                   
                } else {
                   
                     $content = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                  
                }
                return $content;
            })
            ->rawColumns(['action'])
            ->make(true);
    }




}


  