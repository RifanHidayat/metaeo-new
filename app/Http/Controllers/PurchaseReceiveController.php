<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReceive;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReceiveController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $purchaseReceiveWithNumber = PurchaseReceive::where('number', $request->number)->first();
        if ($purchaseReceiveWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Create Purchase Order
            $purchaseReceive = new PurchaseReceive();
            $purchaseReceive->purchase_order_id = $request->purchase_order_id;
            $purchaseReceive->number = $request->number;
            $purchaseReceive->date = $request->date;
            $purchaseReceive->shipper = $request->shipper;
            $purchaseReceive->recipient = $request->recipient;
            $purchaseReceive->description = $request->description;
            $purchaseReceive->save();

            // Attach Goods
            $selectedGoods = $request->selected_goods;
            $goods = collect($selectedGoods)->mapWithKeys(function ($item) {
                return [
                    $item['id'] => [
                        'quantity' => $item['receive_quantity'],
                        // 'description' => $item['description'],
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]
                ];
            });

            $purchaseReceive->goods()->attach($goods);

            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchaseReceive,
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
}
