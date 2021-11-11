<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FinishingItem;
use App\Models\FinishingItemCategory;
use App\Models\Goods;
use App\Models\V2JobOrder;
use App\Models\V2SalesOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use \Mpdf\Mpdf;

// use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

class JobOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('job-order.index');
    }

    /**
     * Send datatable form.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexData()
    {
        $jobOrders = V2JobOrder::with(['v2SalesOrder'])->select('v2_job_orders.*');
        return DataTables::eloquent($jobOrders)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<div class="text-center">';
                $button .= '<a href="/job-order/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                                    <a href="/job-order/print/' . $row->id . '" target="_blank" class="navi-link">
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
        $goods = Goods::with(['goodsCategory'])->get();
        $finishingItemCategories = FinishingItemCategory::with(['finishingItems'])->get();
        return view('job-order.create', [
            'goods' => $goods,
            'customers' => $customers,
            'finishing_item_categories' => $finishingItemCategories,
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
        $jobOrderWithNumber = V2JobOrder::where('number', $request->number)->first();
        if ($jobOrderWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        DB::beginTransaction();

        try {

            $jobOrder = new V2JobOrder();
            $jobOrder->number = $request->number;
            $jobOrder->date = $request->date;
            $jobOrder->estimation_number = $request->estimation_number;
            $jobOrder->title = $request->title;
            $jobOrder->order_amount = $request->order_amount;
            $jobOrder->delivery_date = $request->delivery_date;
            $jobOrder->print_type = $request->print_type;
            $jobOrder->dummy = $request->dummy;
            $jobOrder->okl = $request->okl;
            $jobOrder->okl_nth = $request->okl_nth;
            $jobOrder->designer = $request->designer;
            $jobOrder->preparer = $request->preparer;
            $jobOrder->examiner = $request->examiner;
            $jobOrder->production = $request->production;
            $jobOrder->finishing = $request->finishing;
            $jobOrder->warehouse = $request->warehouse;
            $jobOrder->description = $request->description;
            $jobOrder->v2_sales_order_id = $request->sales_order_id;
            $jobOrder->cpo_item_id = $request->cpo_item_id;
            $jobOrder->v2_quotation_item_id = $request->quotation_item_id;
            $jobOrder->customer_id = $request->customer_id;
            $jobOrder->save();

            $jobOrderItems = $request->items;

            $items = collect($jobOrderItems)->map(function ($item) use ($jobOrder) {
                return [
                    'v2_job_order_id' => $jobOrder->id,
                    'item' => $item['item'],
                    'paper' => $item['paper'],
                    'plano_size' => $item['planoSize'],
                    'plano_amount' => $item['planoAmount'],
                    'cutting_size' => $item['cuttingSize'],
                    'cutting_amount' => $item['cuttingAmount'],
                    'order_amount' => $item['orderAmount'],
                    'print_amount' => $item['printAmount'],
                    'color' => $item['color'],
                    'film_set' => $item['filmSet'],
                    'film_total' => $item['filmTotal'],
                    'print_type' => $item['printType'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

            if (count($items) > 0) {
                DB::table('v2_job_order_items')->insert($items);

                foreach ($jobOrderItems as $item) {
                    $goods = Goods::find($item['paper']);
                    if ($goods == null) {
                        continue;
                    }

                    $goods->stock = $goods->stock - $item['planoAmount'];
                    $goods->save();
                }
            }

            $finishingItems = $request->finishing_items;
            $checkedFinishingItems = collect($finishingItems)
                ->where('checked', true)
                ->mapWithKeys(function ($item) {
                    return [
                        $item['id'] => [
                            'description' => isset($item['description']) ? $item['description'] : '',
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]
                    ];
                });

            $jobOrder->finishingItems()->attach($checkedFinishingItems);

            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $jobOrder,
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
        $jobOrder = V2JobOrder::with(['v2SalesOrder' => function ($query) {
            $query->with(['v2Quotation.items.jobOrders', 'customerPurchaseOrder.items.jobOrders']);
        }, 'cpoItem', 'v2QuotationItem', 'items.goods'])->findOrFail($id);
        $customers = Customer::all();
        $goods = Goods::with(['goodsCategory'])->get();

        $selectedData = null;
        $selectedItem = null;
        if ($jobOrder->v2SalesOrder !== null) {
            $selectedData = [
                'data' => $jobOrder->v2SalesOrder,
                'source' => 'sales_order',
            ];

            if ($jobOrder->v2SalesOrder->source == 'quotation') {
                if ($jobOrder->v2QuotationItem !== null) {
                    $selectedItem = $jobOrder->v2QuotationItem;
                }
            } else if ($jobOrder->v2SalesOrder->source == 'purchase_order') {
                if ($jobOrder->cpoItem !== null) {
                    $selectedItem = $jobOrder->cpoItem;
                }
            }
        }

        $items = collect($jobOrder->items)->map(function ($item) {
            return [
                'item' => $item['item'],
                'paper' => $item['paper'],
                'planoSize' => $item['plano_size'],
                'planoAmount' => $item['plano_amount'],
                'cuttingSize' => $item['cutting_size'],
                'cuttingAmount' => $item['cutting_amount'],
                'orderAmount' => $item['order_amount'],
                'printAmount' => $item['print_amount'],
                'color' => $item['color'],
                'filmSet' => $item['film_set'],
                'filmTotal' => $item['film_total'],
                'printType' => $item['print_type'],
            ];
        })->all();

        $takenStocks = collect($jobOrder->items)->map(function ($item) {
            return [
                'goods_id' => $item['goods']['id'],
                'quantity' => $item['plano_amount'],
            ];
        })->all();
        // return $takenStocks;

        $selectedFinishingItem = $jobOrder->finishingItems;

        $finishingItemCategories = FinishingItemCategory::with(['finishingItems'])->get()
            ->map(function ($category) use ($selectedFinishingItem) {
                $finishingItems = collect($category->finishingItems)->map(function ($item) use ($selectedFinishingItem) {
                    $checked = false;
                    $description = '';

                    $exist = collect($selectedFinishingItem)->where('id', $item->id)->first();

                    if ($exist !== null) {
                        $checked = true;
                        $description = $exist['pivot']['description'];
                    }

                    $item['checked'] = $checked;
                    $item['description'] = $description;

                    return $item;
                })->all();

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                    'finishing_items' => $finishingItems,
                ];
            })->all();

        // return $finishingItemCategories;
        return view('job-order.edit', [
            'job_order' => $jobOrder,
            'selected_data' => $selectedData,
            'selected_item' => $selectedItem,
            'items' => $items,
            'taken_stocks' => $takenStocks,
            'goods' => $goods,
            'customers' => $customers,
            'finishing_item_categories' => $finishingItemCategories,
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
        $jobOrderWithNumber = V2JobOrder::whereNotIn('id', [$id])->where('number', $request->number)->first();
        if ($jobOrderWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        DB::beginTransaction();

        try {

            $jobOrder = V2JobOrder::find($id);
            $jobOrder->number = $request->number;
            $jobOrder->date = $request->date;
            $jobOrder->estimation_number = $request->estimation_number;
            $jobOrder->title = $request->title;
            $jobOrder->order_amount = $request->order_amount;
            $jobOrder->delivery_date = $request->delivery_date;
            $jobOrder->print_type = $request->print_type;
            $jobOrder->dummy = $request->dummy;
            $jobOrder->okl = $request->okl;
            $jobOrder->okl_nth = $request->okl_nth;
            $jobOrder->designer = $request->designer;
            $jobOrder->preparer = $request->preparer;
            $jobOrder->examiner = $request->examiner;
            $jobOrder->production = $request->production;
            $jobOrder->finishing = $request->finishing;
            $jobOrder->warehouse = $request->warehouse;
            $jobOrder->description = $request->description;
            $jobOrder->v2_sales_order_id = $request->sales_order_id;
            $jobOrder->cpo_item_id = $request->cpo_item_id;
            $jobOrder->v2_quotation_item_id = $request->quotation_item_id;
            $jobOrder->customer_id = $request->customer_id;
            $jobOrder->save();

            $jobOrderItems = $request->items;

            $items = collect($jobOrderItems)->map(function ($item) use ($jobOrder) {
                return [
                    'v2_job_order_id' => $jobOrder->id,
                    'item' => $item['item'],
                    'paper' => $item['paper'],
                    'plano_size' => $item['planoSize'],
                    'plano_amount' => $item['planoAmount'],
                    'cutting_size' => $item['cuttingSize'],
                    'cutting_amount' => $item['cuttingAmount'],
                    'order_amount' => $item['orderAmount'],
                    'print_amount' => $item['printAmount'],
                    'color' => $item['color'],
                    'film_set' => $item['filmSet'],
                    'film_total' => $item['filmTotal'],
                    'print_type' => $item['printType'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
            })->all();

            $jobOrder->items()->delete();

            if (count($items) > 0) {
                DB::table('v2_job_order_items')->insert($items);

                $takenStocks = $request->taken_stocks;
                $addedGoods = [];
                foreach ($jobOrderItems as $item) {
                    $goods = Goods::find($item['paper']);
                    if ($goods == null) {
                        continue;
                    }

                    $oldTaken = collect($takenStocks)->whereNotIn('goods_id', $addedGoods)->where('goods_id', $item['paper'])->sum('quantity');
                    array_push($addedGoods, $item['paper']);

                    $goods->stock = ($goods->stock + $oldTaken) - $item['planoAmount'];
                    $goods->save();
                }
            }

            $finishingItems = $request->finishing_items;
            $checkedFinishingItems = collect($finishingItems)
                ->where('checked', true)
                ->mapWithKeys(function ($item) {
                    return [
                        $item['id'] => [
                            'description' => isset($item['description']) ? $item['description'] : '',
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]
                    ];
                });

            $jobOrder->finishingItems()->detach();
            $jobOrder->finishingItems()->attach($checkedFinishingItems);

            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $jobOrder,
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $jobOrder = V2JobOrder::with(['items', 'finishingItems.finishingItemCategory', 'v2SalesOrder' => function ($query) {
            $query->with(['v2Quotation', 'customerPurchaseOrder']);
        }, 'customer'])->findOrFail($id);
        $mpdf = new Mpdf([
            'format' => 'A4',
            'mode' => 'utf-8',
            'orientation' => 'L',
            'margin_left' => 3,
            'margin_top' => 3,
            'margin_right' => 3,
            'margin_bottom' => 3,
        ]);

        $finishingItems = collect($jobOrder->finishingItems)->groupBy(function ($item) {
            return $item->finishingItemCategory->name;
        })->all();

        // return $finishingItems;

        $html = view('job-order.print', [
            'id' => $id,
            'job_order' => $jobOrder,
            'finishing_items' => $finishingItems,
        ]);

        // return $jobOrder;
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatablesSalesOrders(Request $request)
    {
        $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $salesOrders = V2SalesOrder::with(['v2Quotation.items.jobOrders', 'customerPurchaseOrder.items.jobOrders'])->select('v2_sales_orders.*')
            ->get();
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
