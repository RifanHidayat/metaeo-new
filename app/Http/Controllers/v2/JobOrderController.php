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

class JobOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            $items = collect($request->items)->flatMap(function ($item) use ($jobOrder) {
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
            }

            $finishingItems = $request->finishing_items;
            $checkedFinishingItems = collect($finishingItems)
                ->where('checked', true)
                ->mapWithKeys(function ($item) {
                    return [
                        $item['id'] => [
                            'description' => $item['description'],
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
        //
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
        $salesOrders = V2SalesOrder::with(['v2Quotation.items', 'customerPurchaseOrder.items'])->select('v2_sales_orders.*')
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
