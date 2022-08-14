<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Deviation;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index()
    {
        $suppliers = Supplier::all()->sortByDesc('id');
        $divisions=Division::all()->sortByDesc('id');
      //  return $divisions;
        return view('division.index', [
            'suppliers' => $suppliers,
            'divisions'=>$divisions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {

 
      
        return view('division.create', [
        
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
        
        //
        try{
            DB::beginTransaction();

            $devision=new  Division();
            $devision->name=$request->name;
            $devision->code=$request->code;
            $devision->save();
             DB::commit();
             return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $devision,
            ]);

           

            
        }catch(Exception $e){

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
    $division=Division::findOrFail($id);
    
        return view('division.edit', [
        'division'=>$division
        ]);
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

              //
        try{
            DB::beginTransaction();

            $devision=Division::findOrFail($id);
            $devision->name=$request->name;
            $devision->code=$request->code;
            $devision->save();
             DB::commit();
             return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $devision,
            ]);

          
        }catch(Exception $e){

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
           DB::beginTransaction();
        $devision=Division::findOrfail($id);
        //
     
        try{
            $devision->delete();
            DB::commit();
             return response()->json([
                'message' => 'Data has been deleted',
                'code' => 200,
                'error' => false,
                'data' => $devision,
            ]);







        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);






        }

    }
}
