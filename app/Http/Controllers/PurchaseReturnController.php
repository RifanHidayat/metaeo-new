<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReceive;
use App\Models\PurchaseReturn;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
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
        $purchaseReturnWithNumber = PurchaseReturn::where('number', $request->number)->first();
        if ($purchaseReturnWithNumber !== null) {
            return response()->json([
                'message' => 'number or code already used',
                'code' => 400,
                // 'errors' => $/e,
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Create Purchase Order
            $purchaseReturn = new PurchaseReturn();
            $purchaseReturn->purchase_order_id = $request->purchase_order_id;
            $purchaseReturn->number = $request->number;
            $purchaseReturn->date = $request->date;
            // $purchaseReturn->shipper = $request->shipper;
            // $purchaseReturn->recipient = $request->recipient;
            $purchaseReturn->description = $request->description;
            $purchaseReturn->save();

            // Attach Goods
            $selectedGoods = $request->selected_goods;
            $goods = collect($selectedGoods)->mapWithKeys(function ($item) {
                return [
                    $item['id'] => [
                        'quantity' => $item['return_quantity'],
                        'cause' => $item['cause'],
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]
                ];
            });

            $purchaseReturn->goods()->attach($goods);

            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $purchaseReturn,
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
