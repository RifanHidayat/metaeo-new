<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectBudget;
use App\Models\PurchaseOrder;
use Exception;
use Illuminate\Http\Request;

class BudgetProjectApiController extends Controller
{
    public function index()
    {
 
       
    }

     public function show($id)
    {
         // return "tes";
        $budget=ProjectBudget::with(['transactions'])->findOrFail($id);
        return response()->json([
                'status' => 'OK',
            
                'code' => 200,
                'data'=>$budget
            ]);
   
       
    }

         public function showStatus($id)
    {
         // return "tes";
        $budget=ProjectBudget::with(['transactions'])->findOrFail($id);
        return response()->json([
                'status' => 'OK',
            
                'code' => 200,
                'data'=>$budget
            ]);
   
       
    }

  
}
