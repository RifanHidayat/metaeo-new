<?php

namespace App\Http\Controllers;

use App\Models\FobItem;
use App\Models\Goods;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceive;
use App\Models\PurchaseReturn;
use App\Models\Shipment;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
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

        return view('purchase-order.create', [
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
        $purchaseOrderWithNumber = PurchaseOrder::where('number', $request->number)->first();
        if ($purchaseOrderWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Create Purchase Order
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->number = $request->number;
            $purchaseOrder->date = $request->date;
            $purchaseOrder->supplier_id = $request->supplier_id;
            $purchaseOrder->delivery_address = $request->delivery_address;
            $purchaseOrder->delivery_date = $request->delivery_date;
            $purchaseOrder->shipment_id = $request->shipment_id;
            $purchaseOrder->payment_term = $request->payment_term;
            $purchaseOrder->fob_item_id = $request->fob_item_id;
            $purchaseOrder->description = $request->description;
            $purchaseOrder->subtotal = $request->subtotal;
            $purchaseOrder->discount = $request->discount;
            $purchaseOrder->total = $request->total;
            $purchaseOrder->save();

            // Attach Goods
            $selectedGoods = $request->selected_goods;
            $goods = collect($selectedGoods)->mapWithKeys(function ($item) {
                return [
                    $item['id'] => [
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'discount' => $item['discount'],
                        'total' => $item['total'],
                        // 'description' => $item['description'],
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]
                ];
            });

            $purchaseOrder->goods()->attach($goods);

            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchaseOrder,
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
     * Receive goods from specific purchase order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receive($id)
    {
        $purchaseOrder = PurchaseOrder::with(['goods', 'supplier', 'fobItem', 'shipment'])->findOrFail($id);

        $purchaseReceiveGoods = PurchaseReceive::with(['goods'])
            ->where('purchase_order_id', $id)
            ->get()
            ->flatMap(function ($purchaseReceive) {
                return $purchaseReceive->goods;
            })->groupBy('id')
            ->map(function ($group, $id) {
                $receivedQuantity = collect($group)->map(function ($goods) {
                    return $goods->pivot->quantity;
                })->sum();
                return [
                    'id' => $id,
                    'received_quantity' => $receivedQuantity,
                ];
            })
            ->all();

        // return $saleReturnProducts;

        $selectedGoods = collect($purchaseOrder->goods)->each(function ($good) use ($purchaseReceiveGoods) {
            $purchaseReceive = collect($purchaseReceiveGoods)->where('id', $good->id)->first();
            $good['received_quantity'] = 0;
            if ($purchaseReceive !== null) {
                $good['received_quantity'] = $purchaseReceive['received_quantity'];
            }
            $availableQuantity = $good->pivot->quantity - $good['received_quantity'];

            $good['receive_quantity'] = $availableQuantity;
            // $good['cause'] = 'defective';
            $good['finish'] = $good['received_quantity'] >= $good->pivot->quantity ? 1 : 0;
        })->sortBy('finish')->values()->all();

        // return $selectedGoods;

        return view('purchase-order.receive', [
            'purchase_order' => $purchaseOrder,
            'selected_goods' => $selectedGoods,
        ]);
    }

    /**
     * Return goods from specific purchase order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function return($id)
    {
        $purchaseOrder = PurchaseOrder::with(['goods', 'supplier', 'fobItem', 'shipment'])->findOrFail($id);

        $purchaseReturnGoods = PurchaseReturn::with(['goods'])
            ->where('purchase_order_id', $id)
            ->get()
            ->flatMap(function ($purchaseReturn) {
                return $purchaseReturn->goods;
            })->groupBy('id')
            ->map(function ($group, $id) {
                $returnedQuantity = collect($group)->map(function ($goods) {
                    return $goods->pivot->quantity;
                })->sum();
                return [
                    'id' => $id,
                    'returned_quantity' => $returnedQuantity,
                ];
            })
            ->all();

        $purchaseReceiveGoods = PurchaseReceive::with(['goods'])
            ->where('purchase_order_id', $id)
            ->get()
            ->flatMap(function ($purchaseReceive) {
                return $purchaseReceive->goods;
            })->groupBy('id')
            ->map(function ($group, $id) {
                $receivedQuantity = collect($group)->map(function ($goods) {
                    return $goods->pivot->quantity;
                })->sum();
                return [
                    'id' => $id,
                    'received_quantity' => $receivedQuantity,
                ];
            })
            ->all();

        // return $saleReturnProducts;

        $selectedGoods = collect($purchaseOrder->goods)->each(function ($good) use ($purchaseReturnGoods, $purchaseReceiveGoods) {
            $purchaseReturn = collect($purchaseReturnGoods)->where('id', $good->id)->first();
            $purchaseReceive = collect($purchaseReceiveGoods)->where('id', $good->id)->first();
            $good['returned_quantity'] = 0;
            if ($purchaseReturn !== null) {
                $good['returned_quantity'] = $purchaseReturn['returned_quantity'];
            }
            $availableQuantity = $good->pivot->quantity - $good['returned_quantity'];

            $good['return_quantity'] = $availableQuantity;
            $good['cause'] = 'defective';
            $good['finish'] = $good['returned_quantity'] >= $good->pivot->quantity ? 1 : 0;

            $good['received_quantity'] = $purchaseReceive !== null ? $purchaseReceive['received_quantity'] : 0;
        })->sortBy('finish')->values()->all();

        // return $selectedGoods;

        return view('purchase-order.return', [
            'purchase_order' => $purchaseOrder,
            'selected_goods' => $selectedGoods,
        ]);
    }
}
