<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\PurchaseOrder;
use Exception;
use Illuminate\Http\Request;

class EmployeeApiController extends Controller
{
    public function index($id)
    {
     //   return "tes";
        $projects=Project::with(['tasks','budgets','members'])->whereHas('members', function($q) use($id) {
       // Query the name field in status table
       $q->where('employee_id', '=',$id); // '=' is optional
})->get();
        return $projects;
       
    }

       public function projects($id,Request $request)
    {
     //   return "tes";
     $status=$request->query('status');
        $projects=Project::with(['tasks','budgets','members'])->whereHas('members', function($q) use($id) {
       // Query the name field in status table
       $q->where('employee_id', '=',$id); // '=' is optional
        })->where('status',$status)->get();
       return response()->json([
                'status' => 'OK',
            
                'code' => 200,
                'data'=>$projects
            ]);
       
    }
}
