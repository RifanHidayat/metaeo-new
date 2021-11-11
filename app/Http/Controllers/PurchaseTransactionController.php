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
use Yajra\DataTables\Facades\DataTables;

class PurchaseTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase-transaction.index');
    }

    /**
     * Send datatable form.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexData()
    {
        $purchaseTransactions = PurchaseTransaction::select('purchase_transactions.*');
        return DataTables::eloquent($purchaseTransactions)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<div class="text-center">';
                $button .= '<a href="/purchase-transaction/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                                    <a href="/purchase-transaction/print/' . $row->id . '" target="_blank" class="navi-link">
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
