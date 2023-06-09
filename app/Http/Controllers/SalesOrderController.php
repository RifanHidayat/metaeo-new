<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PicEvent;
use App\Models\Quotation;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        // $salesOrders = SalesOrder::all();
        return view('sales-order.index');
    }

    public function indexData()
    {
        $salesOrders = SalesOrder::with(['quotations.selectedEstimation', 'jobOrders', 'invoices', 'deliveryOrders'])->select('sales_orders.*');
        return DataTables::eloquent($salesOrders)
            ->addIndexColumn()
            ->addColumn('quotation_number', function (SalesOrder $salesOrder) {
                return $salesOrder->quotations->map(function ($quotation) {
                    return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $quotation->number . '</span>';
                })->implode("");
            })
            ->addColumn('action', function ($row) {
                $button = '
                <div class="text-center">';
                $button .=    '<a href="/sales-order/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                        </g>
                </svg> </span> </a>';

                if (count($row->jobOrders) < 1 && count($row->invoices) < 1 && count($row->deliveryOrders) < 1) {
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
                                    <a href="/spk/create?so=' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-reload"></i>
                                        </span>
                                        <span class="navi-text">Buat SPK</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/delivery-order/create?so=' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-lorry"></i>
                                        </span>
                                        <span class="navi-text">Buat Delivery Order</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/invoice/create?so=' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-file"></i>
                                        </span>
                                        <span class="navi-text">Buat Faktur</span>
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
        // return base_pa();
        $salesOrdersByCurrentDateCount = SalesOrder::query()->where('date', date("Y-m-d"))->get()->count();
        // return $estimationsByCurrentDateCount;
        $salesOrderNumber = 'SO-' . date('d') . date('m') . date("y") . sprintf('%04d', $salesOrdersByCurrentDateCount + 1);

        $customers = Customer::all();
        $picEvents=PicEvent::all();

        return view('sales-order.create', [
            'sales_order_number' => $salesOrderNumber,
            'customers' => $customers,
            'pic_event'=>$picEvents
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
      //  return "tes";
        $salesOrder = new SalesOrder;
        // $salesOrder->number = $request->number;
        $salesOrder->number = getRecordNumber(new SalesOrder, 'SO');
        $salesOrder->date = $request->date;
        $salesOrder->customer_id = $request->customer_id;
        $salesOrder->po_number = $request->po_number;
        $salesOrder->po_date = $request->po_date;

        $quotations = json_decode($request->selected_quotations);

        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $filePath = 'files/' . time() . '-attachment-' . $salesOrder->number . '.' . $request->file('file')->extension();
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $salesOrder->file = $filePath;
            } catch (Exception $e) {
                return response()->json([
                    'message' => '[Internal error] Upload file failed',
                    'code' => 500,
                    'error' => true,
                    'errors' => $e,
                ], 500);
            }
        }

        try {
            $salesOrder->save();
        } catch (Exception $e) {
            // Storage::delete($salesOrder->file);
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        $keyedQuotations = collect($quotations)->mapWithKeys(function ($item) {
            return [
                $item->id => [
                    'estimation_id' => $item->selected_estimation,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        })->all();

        try {
            $salesOrder->quotations()->attach($keyedQuotations);
            // return response()->json([
            //     'message' => 'Data has been saved',
            //     'code' => 200,
            //     'error' => false,
            //     'data' => $salesOrder,
            // ]);
        } catch (Exception $e) {
            $salesOrder->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation->id);
                if ($quotationRow == null) {
                    continue;
                }

                $quotationRow->estimation_id = $quotation->selected_estimation;
                $quotationRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $salesOrder,
            ]);
        } catch (Exception $e) {
            $salesOrder->quotations()->detach();
            $salesOrder->delete();
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
        $salesOrder = SalesOrder::with(['quotations.estimations'])->findOrFail($id);

        foreach ($salesOrder->quotations as $quotation) {
            $quotation->selected_estimation = $quotation->pivot->estimation_id;
        }

        $customers = Customer::all();

        return view('sales-order.edit', [
            'sales_order' => $salesOrder,
            'customers' => $customers,
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
        $salesOrder = SalesOrder::find($id);
        $salesOrder->number = $request->number;
        $salesOrder->date = $request->date;
        $salesOrder->po_number = $request->po_number;
        $salesOrder->po_date = $request->po_date;

        $quotations = json_decode($request->selected_quotations);

        // return $request->all();

        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $filePath = 'files/' . time() . '-attachment-' . $salesOrder->number . '.' . $request->file('file')->extension();
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->delete($salesOrder->file);
                $salesOrder->file = $filePath;
            } catch (Exception $e) {
                return response()->json([
                    'message' => '[Internal error] Upload file failed',
                    'code' => 500,
                    'error' => true,
                    'errors' => $e,
                ], 500);
            }
        } else {
            if ($request->old_file == '' || $request->old_file == null) {
                try {
                    Storage::disk('s3')->delete($salesOrder->file);
                    $salesOrder->file = null;
                } catch (Exception $e) {
                    return response()->json([
                        'message' => '[Internal error] Delete file failed',
                        'code' => 500,
                        'error' => true,
                        'errors' => $e,
                    ], 500);
                }
            }
        }

        try {
            $salesOrder->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $salesOrder->quotations()->detach();
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
                $item->id => [
                    'estimation_id' => $item->selected_estimation,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        })->all();

        try {
            $salesOrder->quotations()->attach($keyedQuotations);

            // return response()->json([
            //     'message' => 'Data has been saved',
            //     'code' => 200,
            //     'error' => false,
            //     'data' => $salesOrder,
            // ]);
        } catch (Exception $e) {
            $salesOrder->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation->id);
                if ($quotationRow == null) {
                    continue;
                }

                $quotationRow->estimation_id = $quotation->selected_estimation;
                $quotationRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $salesOrder,
            ]);
        } catch (Exception $e) {
            $salesOrder->quotations()->detach();
            $salesOrder->delete();
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
        $salesOrder = SalesOrder::find($id);
        try {
            $salesOrder->quotations()->detach();
            $salesOrder->delete();
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

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = 'files/' . time() . '-' . $file->getClientOriginalName();
            Storage::disk('s3')->put($filePath, file_get_contents($file));

            return response()->json([
                'file_name' => $file->getClientOriginalName(),
            ]);
            // $employee->photo = $filePath;
        }

        return response()->json('success', 200);
    }

    public function datatablesQuotations(Request $request)
    {
        $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $quotations = Quotation::with(['estimations', 'salesOrders', 'picPo'])
            ->where('customer_id', $customerId)
            ->get()
            ->filter(function ($quotation) {
                return count($quotation->salesOrders) < 1;
            })->all();

        return DataTables::of($quotations)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatablesQuotationsUnfiltered(Request $request)
    {
        $customerId = $request->query('customer_id');
        $salesOrderId = $request->query('sales_order_id');

        // $quotations = SalesOrder::with(['quotations'])->find($salesOrderId);

        // return $quotations;

        $salesOrder = SalesOrder::find($salesOrderId);

        $salesOrderQuotationIds = [];

        if ($salesOrderId !== null) {
            $salesOrderQuotationIds = collect($salesOrder->quotations)->pluck('id')->all();
        }

        // $quotationIds = collect($quotations)->pluck('id')->all();
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);

        $quotations = Quotation::with(['estimations', 'salesOrders', 'customer', 'picPo'])->select('quotations.*')
            ->where('customer_id', $customerId)
            ->get()
            ->filter(function ($quotation) use ($salesOrderQuotationIds) {
                return count($quotation->salesOrders) < 1 || array_search($quotation->id, $salesOrderQuotationIds) !== null;
                // return count($quotation->salesOrders) < 1;
            })->all();

        return DataTables::of($quotations)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
