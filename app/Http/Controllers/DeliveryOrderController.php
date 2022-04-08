<?php

namespace App\Http\Controllers;

use App\Models\Bast;
use App\Models\Company;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderOtherQuotationItem;
use App\Models\OtherQuotationItem;
use App\Models\Quotation;
use App\Models\SalesOrder;
use App\Models\V2SalesOrder;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

use function GuzzleHttp\Promise\each;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('delivery-order.index');
    }
       private function formatDate($date = "", $format = "Y-m-d")
    {
        return date_format(date_create($date), $format);
    }

    public function indexData()
    {
        $deliveryOrders = DeliveryOrder::with(['v2SalesOrder','bast'])->select('delivery_orders.*');
        return DataTables::eloquent($deliveryOrders)
            ->addIndexColumn()
              ->addColumn('source_number',function($row){
                if ($row->sales_order_id!==0){
                    return $row->v2SalesOrder==null?"":$row->v2SalesOrder->number;

                }else{
                        return $row->bast==null?"":$row->bast->number;

                }

            })
            // ->addColumn('quotation_number', function (DeliveryOrder $deliveryOrder) {
            //     return $deliveryOrder->quotations->map(function ($quotation) {
            //         return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $quotation->number . '</span>';
            //     })->implode("");
            // })
            ->addColumn('action', function ($row) {
                $button = '
                <div class="text-center">
                <a href="/delivery-order/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
              </svg> </span> </a>
              <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-item">
                                    <a href="/delivery-order/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                </div>
                
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
    public function create(Request $request)
    {
        $salesOrderId = $request->query('so');
        $salesOrder = SalesOrder::with(['quotations.selectedEstimation', 'customer.warehouses', 'quotations.customer'])->find($salesOrderId);

        if ($salesOrderId == null || $salesOrder == null) {
            // abort(404);
            return view('errors.custom-error', [
                'title' => 'ID Sales Order Tidak Ditemukan',
                'subtitle' => 'Pastikann id sales order atau url telah sesuai'
            ]);
        }

        // return 

        // $customerExist = $salesOrder->quotations->filter(function ($item) {
        //     return $item->estimations !== null && count($item->estimations) > 0;
        // })->flatMap(function ($item) {
        //     return $item->estimations;
        // })->filter(function ($item) {
        //     return $item->picPo->customer !== null;
        // })->first();

        // $customer = null;

        // if ($customerExist !== null) {
        //     $customer = $customerExist->picPo->customer;
        // }

        if ($salesOrder->quotations !== null) {
            if (count($salesOrder->quotations) > 0) {
                foreach ($salesOrder->quotations as $quotation) {
                    $quotation['shipping_code'] = 'D002';
                    $quotation['shipping_description'] = strip_tags($quotation['description']);
                    $quotation['shipping_information'] = '';
                    $quotation['shipping_amount'] = 0;
                    $quotation['shipping_unit'] = 'Pcs';
                }
            }
        }

        // return $customer;

        // return $salesOrder;

        $deliveryOrdersByCurrentDateCount = DeliveryOrder::query()->where('date', date("Y-m-d"))->get()->count();
        // return $estimationsByCurrentDateCount;
        $deliveryOrderNumber = 'DO-' . date('d') . date('m') . date("y") . sprintf('%04d', $deliveryOrdersByCurrentDateCount + 1);

        // return $salesOrder;

        return view('delivery-order.create', [
            // 'customer' => $customer,
            'sales_order' => $salesOrder,
            'delivery_order_number' => $deliveryOrderNumber,
        ]);

        // return view('delivery-order.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createV2(Request $request)
    {
        $deliveryOrdersByCurrentDateCount = DeliveryOrder::query()->where('date', date("Y-m-d"))->get()->count();
        // return $estimationsByCurrentDateCount;
        $deliveryOrderNumber = 'DO-' . date('d') . date('m') . date("y") . sprintf('%04d', $deliveryOrdersByCurrentDateCount + 1);

        return view('delivery-order.v2.create', [
            'delivery_order_number' => $deliveryOrderNumber,
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
        return $request->all();
        $deliveryOrder = new DeliveryOrder;
        // $deliveryOrder->number = $request->number;
        $deliveryOrder->number = getRecordNumber(new DeliveryOrder, 'DO');
        $deliveryOrder->date = $request->date;
        $deliveryOrder->customer_id = $request->customer_id;
        $deliveryOrder->warehouse = $request->warehouse;
        $deliveryOrder->shipper = $request->shipper;
        $deliveryOrder->number_of_vehicle = $request->number_of_vehicle;
        $deliveryOrder->billing_address = $request->billing_address;
        $deliveryOrder->shipping_address = $request->shipping_address;
        $deliveryOrder->sales_order_id = $request->sales_order_id;
        $deliveryOrder->bast_id=$request->id;
        $quotations = $request->selected_quotations;

        
        try {
            //$deliveryOrder->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        $keyedQuotations = collect($quotations)->mapWithKeys(function ($item) {
            return [
                $item['id'] => [
                    'code' => $item['shipping_code'],
                    'amount' => $item['shipping_amount'],
                    'unit' => $item['shipping_unit'],
                    'description' => $item['shipping_description'],
                    'information' => $item['shipping_information'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        });

        try {
          //  $deliveryOrder->quotations()->attach($keyedQuotations);
        } catch (Exception $e) {
            $deliveryOrder->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation['id']);
                if ($quotationRow == null) {
                    continue;
                }

                $quotationRow->shipped = $quotationRow->shipped + $quotation['shipping_amount'];
                $quotationRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $deliveryOrder,
            ]);
        } catch (Exception $e) {
            $deliveryOrder->quotations()->detach();
            $deliveryOrder->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeV2(Request $request)
    {
       // return $request->event_quotations;
        // return $request->event_quotations;

        // $deliveryOrderWithNumber = DeliveryOrder::where('number', $request->number)->first();
        // if ($deliveryOrderWithNumber !== null) {
        //     return response()->json([
        //         'message' => 'number or code already used',
        //         'code' => 400,
        //         // 'errors' => $/e,
        //     ], 400);
        // }
 

        $transactionsByCurrentDateCount = DeliveryOrder::query()->where('date', $request->date)->get()->count();
        $number = 'DO'.'' . $this->formatDate($request->date, "d") . $this->formatDate($request->date, "m") . $this->formatDate($request->date, "y") . '-' . sprintf('%05d', $transactionsByCurrentDateCount + 1);

        DB::beginTransaction();

        try {
            $deliveryOrder = new DeliveryOrder;
            $source=$request->source;
            // $deliveryOrder->number = $request->number;
            $deliveryOrder->number = $number;
            $deliveryOrder->date = $request->date;
            $deliveryOrder->customer_id = $request->customer_id;
            $deliveryOrder->warehouse = $request->warehouse;
            $deliveryOrder->shipper = $request->shipper;
            $deliveryOrder->number_of_vehicle = $request->number_of_vehicle;
            $deliveryOrder->billing_address = $request->billing_address;
            $deliveryOrder->shipping_address = $request->shipping_address;
            $deliveryOrder->sales_order_id = $request->sales_order_id;
            $deliveryOrder->description = $request->description;
            $deliveryOrder->bast_id=$request->bast_id;

            $source = $request->source;
            $items = $request->selected_items;
            


            $deliveryOrder->save();

            if ($source=='event'){
                
            }else if ($source=="other"){
                foreach ($request->event_quotations as $quotation){
                    foreach($quotation['other_quotation_items'] as $item){
                        if ( ($item['isSent']==true)){
                            $item=[
                                "number"=>$item['number'],
                                  "unit"=>$item['unit'],
                                "name"=>$item['name'],
                                "quantity"=>$item['quantity'],
                                "frequency"=>$item['frequency'],
                                "description"=>$item['description'],
                                "note"=>$item['note'],
                                "delivery_order_id"=>$deliveryOrder->id,
                                "other_quotation_item_id"=>$item['id'],
                            ];
                            DB::table('delivery_order_other_quotation_items')->insert($item);
                        }
                         
                    }   
                }

            

            //     $newItems = collect($quotations)->mapWithKeys(function ($item) {
            //     return [
            //         $item['id'] => [
            //             'code' => $item['shipping_code'],
            //             'amount' => $item['shipping_amount'],
            //             'unit' => $item['shipping_unit'],
            //             'description' => $item['shipping_description'],
            //             'information' => $item['shipping_information'],
            //             'created_at' => Carbon::now()->toDateTimeString(),
            //             'updated_at' => Carbon::now()->toDateTimeString(),
            //         ]
            //     ];
            // });
                




            }else {
                $newItems = collect($items)->mapWithKeys(function ($item) {
                return [
                    $item['id'] => [
                        'code' => $item['shipping_code'],
                        'amount' => $item['shipping_amount'],
                        'unit' => $item['shipping_unit'],
                        'description' => $item['shipping_description'],
                        'information' => $item['shipping_information'],
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]
                ];
            });

            if ($source == 'quotation') {
                $deliveryOrder->v2QuotationItems()->attach($newItems);
            } else if ($source == 'purchase_order') {
                $deliveryOrder->cpoItems()->attach($newItems);
            } 
            }
            DB::commit();


            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $deliveryOrder,
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
        $deliveryOrder = DeliveryOrder::with(['quotations.selectedEstimation', 'salesOrder', 'customer.warehouses'])->findOrFail($id);

        $checkedQuotations = collect($deliveryOrder->quotations)->pluck('id')->all();

        $salesOrderId = $deliveryOrder->sales_order_id;
        $salesOrder = SalesOrder::with(['quotations.estimations.picPo.customer'])->find($salesOrderId);

        if ($salesOrderId == null || $salesOrder == null) {
            // abort(404);
            return view('errors.custom-error', [
                'title' => 'ID Sales Order Tidak Ditemukan',
                'subtitle' => 'Pastikann id sales order atau url telah sesuai'
            ]);
        }

        // return 

        // $customerExist = $salesOrder->quotations->filter(function ($item) {
        //     return $item->estimations !== null && count($item->estimations) > 0;
        // })->flatMap(function ($item) {
        //     return $item->estimations;
        // })->filter(function ($item) {
        //     return $item->picPo->customer !== null;
        // })->first();

        // $customer = null;

        // if ($customerExist !== null) {
        //     $customer = $customerExist->picPo->customer;
        // }

        if ($deliveryOrder->quotations !== null) {
            if (count($deliveryOrder->quotations) > 0) {
                foreach ($deliveryOrder->quotations as $quotation) {
                    $quotation->shipped = $quotation->shipped - $quotation->pivot->amount;
                    $quotation['old_shipped'] = $quotation->pivot->amount;
                    $quotation['shipping_code'] = $quotation->pivot->code;
                    $quotation['shipping_description'] = $quotation->pivot->description;
                    $quotation['shipping_information'] = $quotation->pivot->information;
                    $quotation['shipping_amount'] = $quotation->pivot->amount;
                    $quotation['shipping_unit'] = $quotation->pivot->unit;
                }
            }
        }

        return view('delivery-order.edit', [
            'checked_quotations' => $checkedQuotations,
            'delivery_order' => $deliveryOrder,
            // 'customer' => $customer,
            'sales_order' => $salesOrder,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editV2($id)
    {
        // $deliveryOrdersByCurrentDateCount = DeliveryOrder::query()->where('date', date("Y-m-d"))->get()->count();
        // $deliveryOrderNumber = 'DO-' . date('d') . date('m') . date("y") . sprintf('%04d', $deliveryOrdersByCurrentDateCount + 1);
        $deliveryOrder = DeliveryOrder::with(['v2SalesOrder' => function ($query) {
            $query->with(['v2Quotation.items' => function ($query) {
                $query->with(['deliveryOrders', 'jobOrders']);
            }, 'customerPurchaseOrder.items' => function ($query) {
                $query->with(['deliveryOrders', 'jobOrders']);
            }]);
        }])->findOrFail($id);

        $selectedData = null;
        if ($deliveryOrder->v2SalesOrder !== null) {
            $selectedData = [
                'data' => $deliveryOrder->v2SalesOrder,
                'source' => $deliveryOrder->v2SalesOrder->source,
            ];
        }

        return view('delivery-order.v2.edit', [
            'delivery_order' => $deliveryOrder,
            'selected_data' => $selectedData,
            // 'delivery_order_number' => $deliveryOrderNumber,
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
        $deliveryOrder = DeliveryOrder::find($id);
        $deliveryOrder->number = $request->number;
        $deliveryOrder->date = $request->date;
        $deliveryOrder->warehouse = $request->warehouse;
        $deliveryOrder->shipper = $request->shipper;
        $deliveryOrder->number_of_vehicle = $request->number_of_vehicle;
        $deliveryOrder->billing_address = $request->billing_address;
        $deliveryOrder->shipping_address = $request->shipping_address;
        $deliveryOrder->sales_order_id = $request->sales_order_id;

        $quotations = $request->selected_quotations;

        try {
            $deliveryOrder->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $deliveryOrder->quotations()->detach();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        $keyedQuotations = collect($quotations)->mapWithKeys(function ($item) {
            return [
                $item['id'] => [
                    'code' => $item['shipping_code'],
                    'amount' => $item['shipping_amount'],
                    'unit' => $item['shipping_unit'],
                    'description' => $item['shipping_description'],
                    'information' => $item['shipping_information'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        });

        try {
            $deliveryOrder->quotations()->attach($keyedQuotations);
        } catch (Exception $e) {
            $deliveryOrder->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation['id']);
                if ($quotationRow == null) {
                    continue;
                }

                $quotationRow->shipped = $quotationRow->shipped + $quotation['shipping_amount'] - $quotation['old_shipped'];
                $quotationRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $deliveryOrder,
            ]);
        } catch (Exception $e) {
            // $deliveryOrder->quotations()->detach();
            // $deliveryOrder->delete();
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
        $deliveryOrder = DeliveryOrder::find($id);
        $quotations = $deliveryOrder->quotations;

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation->id);
                if ($quotationRow == null) {
                    continue;
                }
                // DIfferent formula with store
                $quotationRow->shipped = $quotationRow->shipped - $quotation->pivot->amount;
                $quotationRow->save();
            }
             DB::table('delivery_order_other_quotation_items')->where('delivery_order_id', $id)->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $deliveryOrder->quotations()->detach();
            $deliveryOrder->delete();
            return [
                'message' => 'data has been deleted',
                'error' => false,
                'code' => 200,
            ];
        } catch (Exception $e) {
            return [
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e,
            ];
        }
    }

    // public function print($id)
    // {
    //     $deliveryOrder = DeliveryOrder::with(['quotations', 'salesOrder'])->findOrFail($id);

    //     $company = Company::all()->first();

    //     if ($company == null) {
    //         $newCompany = new Company;
    //         $newCompany->save();
    //         $company = Company::all()->first();
    //     }

    //     $pdf = PDF::loadView('delivery-order.print', [
    //         'delivery_order' => $deliveryOrder,
    //         'company' => $company,
    //     ]);
    //     $pdf->setPaper('a5', 'landscape');
    //     return $pdf->stream($deliveryOrder->number . '.pdf');
    // }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $deliveryOrder = DeliveryOrder::with(['v2SalesOrder' => function ($query) {
            $query->with(['v2Quotation', 'customerPurchaseOrder']);
        }, 'cpoItems', 'v2QuotationItems','bast','bast.eventQuotation','bast.eventQuotation.poQuotation'])->findOrFail($id);

        $deliveryOrderOtherQuotationItem=DeliveryOrderOtherQuotationItem::where('delivery_order_id',$id)->get();

       // return $deliveryOrder;
        //return $deliveryOrder;
       //return $deliveryOrderOtherQuotationItem;
    //   return

 

        $company = Company::all()->first();

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }

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

        $html = view('delivery-order.v2.print', [
            'delivery_order' => $deliveryOrder,
            'company' => $company,
            'items'=>$deliveryOrderOtherQuotationItem
        ]);

        // return $jobOrder;
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Yajra\DataTables\Facades\DataTables;
     */
    public function datatablesSalesOrders(Request $request)
    {
        $customerId = $request->query('customer_id');
          $otherQuotationItems=OtherQuotationItem::all();
          
            $otherQuotationItems=collect($otherQuotationItems)->each(function($item){
            $item['description']="";
            $item['number']="";
            $item['unit']="";
            $item['isSent']=false;
        });

        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $salesOrders = V2SalesOrder::with(['deliveryOrders.deliveryOrderOtherQuotationItems'=>function($query){
          
        },'customerPurchaseOrder.eventQuotations','v2Quotation.items' => function ($query) {
            $query->with(['jobOrders', 'deliveryOrders']);
        }, 'customerPurchaseOrder.items' => function ($query) {
            $query->with(['jobOrders', 'deliveryOrders']);
        }, 'customer.warehouses'])->select('v2_sales_orders.*')->get();
        // return $salesOrders;



          $salesOrders=collect($salesOrders)->each(function($bast) use ($otherQuotationItems){
              if ($bast['customerPurchaseOrder']['source']=='other'){
                  collect($bast['customerPurchaseOrder']->eventQuotations)->each(function($bast) use($otherQuotationItems){
              
                  $items=collect($otherQuotationItems)->filter(function($item) use ($bast){                    
                return $item->event_quotation_id==$bast->id;
            })->values()->all();
                     $bast['other_quotation_items']=$items;
                      $bast['isShow']=0;
              });
              }  
           });
          //  return $salesOrders;
            // $salesOrder=collect($alesorder->delivery_orders)->each(function($item){})

            $salesOrders=collect($salesOrders)->each(function($salesOrder) {
              if ($salesOrder['customerPurchaseOrder']['source']=='other'){
                  collect($salesOrder['customerPurchaseOrder']->eventQuotations)->each(function($quotation) use($salesOrder){
                  collect($quotation->other_quotation_items)->each(function($otherQuotationItems) use ($salesOrder,){
                   
                    $otherQuotationItems['delivery_order']=collect($salesOrder['deliveryOrders'])->filter(function($item) use($otherQuotationItems){
                    
                    return count(collect($item['deliveryOrderOtherQuotationItems'])->filter(function($item) use($otherQuotationItems){

                    return $item->other_quotation_item_id==$otherQuotationItems->id?$item:[];
                    }));
                   })->values()->all();    
                    


                     
             //$item['deliveryOrder']=$items;              
                // return $item->event_quotation_id==$bast->id;
            });
                    
                    //   $bast['isShow']=0;
              });
              }  
           });
           //return $salesOrders;
           



           
           return DataTables::of($salesOrders)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                 $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
              
                // if (count($row->deliveryOrders)>0){
                //     $button = '<button class="btn btn-light-success"><i class="flaticon2-check-mark"></i></button>';
                // }else{
                     

              //  }
            //   if ($row['customerPurchaseOrder']['source']=='event'){
            //       if (($row->deliveryOrders)>0){
            //           $button = '<button class="btn btn-light-success"><i class="flaticon2-check-mark"></i></button>';

            //       }else{
            //           $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                      
                      

            //       }
    

            //   }else{
            //        $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';

            //   }
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
       public function datatablesBast(Request $request)
    {
        $otherQuotationItems=OtherQuotationItem::all();
        $otherQuotationItems=collect($otherQuotationItems)->each(function($item){
          
            $item['description']="";
            $item['number']="";
            $item['unit']="";
        });
        //   $basts = Bast::with(['eventQuotation','eventQuotation.poQuotation','deliveryOrder'])->select('basts.*')->get();
        //   $basts=collect($basts)->each(function($bast) use ($otherQuotationItems){
        //     $items=collect($otherQuotationItems)->filter(function($item) use ($bast){
        //         return $item->event_quotation_id==$bast->event_quotation_id;
        //     })->values()->all();
        //     $bast['other_quotation_items']=$items;
        
        //   })->where('eventQuotation.type','other');
         // return $basts;


           $basts = Bast::with(['v2SalesOrder.customerPurchaseOrder.eventQuotations',])->select('basts.*')->get();
        //  return $basts[0]['v2SalesOrder']['customerPurchaseOrder'];
     
          
          $basts=collect($basts)->each(function($bast) use ($otherQuotationItems){
              collect($bast['v2SalesOrder']['customerPurchaseOrder']->eventQuotations)->each(function($bast) use($otherQuotationItems){
                  $items=collect($otherQuotationItems)->filter(function($item) use ($bast){
                return $item->event_quotation_id==$bast->id;
            })->values()->all();
                     $bast['other_quotation_items']=$items;

              });
           });
        return DataTables::of($basts)
            ->addIndexColumn()
            ->addColumn('po_quotation_number',function($row){
                return $row['v2SalesOrder']['customerPurchaseOrder']->number;
            })
            ->addColumn('action', function ($row) {
              

                   if ($row->deliveryOrder==null){
               $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';

                }else{
                      $button = '<button class="btn btn-light-success"><i class="flaticon2-check-mark"></i></button>';

                }
                return $button;
            })
            ->rawColumns(['action'])
        
            ->make(true);
    }
}
