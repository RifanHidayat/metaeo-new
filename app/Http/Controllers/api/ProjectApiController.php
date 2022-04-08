<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectBudget;
use App\Models\PurchaseOrder;
use Exception;
use Illuminate\Http\Request;

class ProjectApiController extends Controller
{
    public function index()
    {
     //   return "tes";
        $projects=Project::with(['tasks','budgets','members'])->get();
        return response()->json([
                'status' => 'OK',
            
                'code' => 200,
                'data'=>$projects
            ]);
       
    }

     public function show($id)
    {
     //   return "tes";
        $projects=Project::with(['tasks','budgets','members'])->findOrFail($id);
        return response()->json([
                'status' => 'OK',
            
                'code' => 200,
                'data'=>$projects
            ]);
       
    }

        public function budgets($id)
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
