<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\V2SalesOrder;
use Exception;
use Illuminate\Http\Request;

class SalesOrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $salesOrders = V2SalesOrder::with(['v2Quotation', 'customerPurchaseOrder', 'customer'])->get();
            return response()->json([
                'message' => 'OK',
                'data' => $salesOrders,
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to get data',
                'error' => $e,
            ], 500);
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $salesOrder = V2SalesOrder::with(['v2Quotation', 'customerPurchaseOrder', 'customer'])->find($id);

            if ($salesOrder == null) {
                return response()->json([
                    'message' => 'Data with id ' . $id . ' not found',
                ], 400);
            }

            return response()->json([
                'message' => 'OK',
                'data' => $salesOrder,
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to get data',
                'error' => $e,
            ], 500);
        }
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
