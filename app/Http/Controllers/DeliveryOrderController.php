<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DeliveryOrder;
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

    public function indexData()
    {
        $deliveryOrders = DeliveryOrder::with(['v2SalesOrder'])->select('delivery_orders.*');
        return DataTables::eloquent($deliveryOrders)
            ->addIndexColumn()
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

        $deliveryOrderWithNumber = DeliveryOrder::where('number', $request->number)->first();
        if ($deliveryOrderWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        DB::beginTransaction();

        try {
            $deliveryOrder = new DeliveryOrder;
            // $deliveryOrder->number = $request->number;
            $deliveryOrder->number = $request->number;
            $deliveryOrder->date = $request->date;
            $deliveryOrder->customer_id = $request->customer_id;
            $deliveryOrder->warehouse = $request->warehouse;
            $deliveryOrder->shipper = $request->shipper;
            $deliveryOrder->number_of_vehicle = $request->number_of_vehicle;
            $deliveryOrder->billing_address = $request->billing_address;
            $deliveryOrder->shipping_address = $request->shipping_address;
            $deliveryOrder->sales_order_id = $request->sales_order_id;
            $deliveryOrder->description = $request->description;

            $source = $request->source;

            $items = $request->selected_items;

            $deliveryOrder->save();

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

    public function print($id)
    {
        $deliveryOrder = DeliveryOrder::with(['quotations', 'salesOrder'])->findOrFail($id);

        $company = Company::all()->first();

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }

        $pdf = PDF::loadView('delivery-order.print', [
            'delivery_order' => $deliveryOrder,
            'company' => $company,
        ]);
        $pdf->setPaper('a5', 'landscape');
        return $pdf->stream($deliveryOrder->number . '.pdf');
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
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $salesOrders = V2SalesOrder::with(['v2Quotation.items' => function ($query) {
            $query->with(['jobOrders', 'deliveryOrders']);
        }, 'customerPurchaseOrder.items' => function ($query) {
            $query->with(['jobOrders', 'deliveryOrders']);
        }])->select('v2_sales_orders.*')->get();
        // ->filter(function ($quotation) {
        //     return count($quotation->salesOrders) < 1;
        // })->all();

        return DataTables::of($salesOrders)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
