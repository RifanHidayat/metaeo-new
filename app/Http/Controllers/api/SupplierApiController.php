<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Exception;
use Illuminate\Http\Request;

class SupplierApiController extends Controller
{
    public function getAllPurchaseOrders($id)
    {

        try {
            $purchaseOrders = PurchaseOrder::with(['goods'])->where('supplier_id', $id)->get()
                ->map(function ($po) {
                    // $po['injected'] = 'asdad';
                    $po['total_payment'] = collect($po->purchaseTransactions)
                        ->map(function ($transaction) {
                            return $transaction->pivot->amount;
                        })->sum();
                    return $po;
                })->all();

            return response()->json([
                'message' => 'OK',
                'data' => $purchaseOrders,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'errors' => $e,
            ]);
        }
    }
}
