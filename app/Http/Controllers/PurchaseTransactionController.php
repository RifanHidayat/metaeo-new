<?php

namespace App\Http\Controllers;

use App\Models\FobItem;
use App\Models\Goods;
use App\Models\PurchaseOrder;
use App\Models\PurchaseTransaction;
use App\Models\Shipment;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseTransactionController extends Controller
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
        $goods = Goods::with(['goodsCategory'])->get();
        $shipments = Shipment::all();
        $fobItems = FobItem::all();
        $suppliers = Supplier::all();

        return view('purchase-transaction.create', [
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
        $purchaseTransactionWithNumber = PurchaseTransaction::where('number', $request->number)->first();
        if ($purchaseTransactionWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        $progress = '';
        DB::beginTransaction();

        try {
            $paymentAmount = $this->clearThousandFormat($request->payment_amount);

            // $progress = 'saving data...';

            $purchaseTransaction = new PurchaseTransaction();
            $purchaseTransaction->number = $request->number;
            $purchaseTransaction->date = $request->date;
            $purchaseTransaction->payment_amount = $request->payment_amount;
            $purchaseTransaction->supplier_id = $request->supplier_id;
            $purchaseTransaction->description = $request->description;
            $purchaseTransaction->total = $request->total;
            $purchaseTransaction->save();

            $purchaseOrders = $request->selected_purchase_orders;
            $selectedPurchaseOrdersIds = collect($purchaseOrders)->pluck('id')->all();

            $payments = [];
            $totalPurchaseOrders = 0;

            $progress = 'saving calculate distribution...';

            PurchaseOrder::with(['purchaseTransactions'])
                ->whereIn('id', $selectedPurchaseOrdersIds)
                ->orderBy('date', 'ASC')
                // ->where('paid', 0)
                ->get()
                ->each(function ($po) {
                    $po['total_payment'] = collect($po->purchaseTransactions)
                        ->map(function ($transaction) {
                            return $transaction->pivot->amount;
                        })->sum();
                })
                ->filter(function ($po) {
                    return $po->total_payment < $po->total;
                })
                ->each(function ($po) use ($paymentAmount, &$totalPurchaseOrders, &$payments, $purchaseTransaction) {
                    // Remaining Debt Has To Pay Per Invoice
                    $remainingPOTotal = $po->total - $po->total_payment;

                    $amount = $remainingPOTotal;

                    $remainingPaymentAmount = $paymentAmount - $totalPurchaseOrders;

                    if ($remainingPOTotal > $remainingPaymentAmount) {
                        $amount = $remainingPaymentAmount;
                    }

                    $payment = [
                        'purchase_transaction_id' => $purchaseTransaction->id,
                        'purchase_order_id' => $po->id,
                        'amount' => $amount,
                    ];

                    array_push($payments, $payment);

                    $totalPurchaseOrders = $totalPurchaseOrders + $remainingPOTotal;
                    if (($paymentAmount - $totalPurchaseOrders) <= 0) {
                        return false;
                    }
                });

            $progress = 'mapping with keys...';
            $keyedPayments = collect($payments)->mapWithKeys(function ($item) {
                return [
                    $item['purchase_order_id'] => [
                        'amount' => $item['amount'],
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]
                ];
            });

            $progress = 'attaching purchase orders';
            $purchaseTransaction->purchaseOrders()->attach($keyedPayments);

            $progress = 'commiting query...';
            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchaseTransaction,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'progress' => $progress,
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
     * Clear thousand format (remove dot from string).
     *
     * @param  int  $number
     * @return string
     */
    private function clearThousandFormat($number)
    {
        return str_replace(".", "", $number);
    }
}
