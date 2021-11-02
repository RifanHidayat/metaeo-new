<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Exception;
use Illuminate\Http\Request;

class PurchaseOrderApiController extends Controller
{
    public function getAll()
    {
        try {
            $purchaseOrders = PurchaseOrder::with(['goods'])->get();

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
