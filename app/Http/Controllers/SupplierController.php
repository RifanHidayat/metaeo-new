<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Exception;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all()->sortByDesc('id');
        return view('supplier.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function create()
    {

        $kode = Supplier::max('id');
        $number = "S" . sprintf("%03d", $kode + 1);
        $divisions=Division::all();
        //return $divisions;
        return view('supplier.create', [
            'number' => $number,
            'divisions'=>$divisions,
        ]);
    }

    public function store(Request $request)
    {

        $supplier = new Supplier;
        $supplier->number = $request->number;
        $supplier->division_id=$request->division_id;
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->telephone = $request->telephone;
        $supplier->handphone = $request->handphone;
        $supplier->email = $request->email;
        $supplier->npwp_number=$request->npwp_number;
        $supplier->npwp_address=$request->npwp_address;
        $supplier->contact_name = $request->contact_name;
        $supplier->contact_address = $request->contact_address;
        $supplier->contact_number = $request->contact_number;
        $supplier->contact_position = $request->contact_position;
        $supplier->contact_email = $request->contact_email;


        if ($request->number == null) {
            $maxSupplier = Supplier::max('id');
            $number = "S" . sprintf("%03d", $maxSupplier + 1);
            $supplier->number = $number;
        }

        try {
            $supplier->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $supplier,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
    }

    public function edit($id)
    {
        $divisions=Division::all();
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', ['supplier' => $supplier,'divisions'=>$divisions]);
    }

    public function update(Request $request, $id)
    {

            $supplier = Supplier::findOrFail($id);
        
        $supplier->division_id=$request->division_id;
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->telephone = $request->telephone;
        $supplier->handphone = $request->handphone;
        $supplier->email = $request->email;
        $supplier->npwp_number=$request->npwp_number;
        $supplier->npwp_address=$request->npwp_address;
        $supplier->contact_name = $request->contact_name;
        $supplier->contact_address = $request->contact_address;
        $supplier->contact_number = $request->contact_number;
        $supplier->contact_position = $request->contact_position;
        $supplier->contact_email = $request->contact_email;


        

        try {
            $supplier->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $supplier,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
        // $supplier = Supplier::find($id);
        // $supplier->number = $request->number;
        // $supplier->name = $request->name;
        // $supplier->address = $request->address;
        // $supplier->telephone = $request->telephone;
        // $supplier->handphone = $request->handphone;
        // $supplier->email = $request->email;


        // try {
        //     $supplier->save();
        //     return response()->json([
        //         'message' => 'Data has been saved',
        //         'code' => 200,
        //         'error' => false,
        //         'data' => $supplier,
        //     ]);
        // } catch (Exception $e) {
        //     return response()->json([
        //         'message' => 'Internal error',
        //         'code' => 500,
        //         'error' => true,
        //         'errors' => $e,
        //     ], 500);
        // }
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        try {
            $supplier->delete();
            return [
                'message' => 'data has been deleted',
                'error' => false,
                'code' => 200,
            ];
        } catch (Exception $e) {
            return [
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e,
            ];
        }
    }

    // public function kode(){
    //     $this->db->select('RIGHT(supplier.number,2) as number', FALSE);
    //     $this->db->order_by('number','DESC');    
    //     $this->db->limit(1);    
    //     $query = $this->db->get('supplier');  //cek dulu apakah ada sudah ada kode di tabel.    
    //     if($query->num_rows() <> 0){      
    //          //cek kode jika telah tersedia    
    //          $data = $query->row();      
    //          $kode = intval($data->number) + 1; 
    //     }
    //     else{      
    //          $kode = 1;  //cek jika kode belum terdapat pada table
    //     }
    //         $tgl=date('dmY'); 
    //         $batas = str_pad($kode, 3, "0", STR_PAD_LEFT);    
    //         $kodetampil = "BR"."5".$tgl.$batas;  //format kode
    //         return $kodetampil;
    //    }

    // public function kode(Request $request){
    //     $numeric_id = intval(substr($request('id'), 1)); //retrieve numeric value of 'V001' (1)
    //     $numeric_id++; //increment
    //     if(mb_strlen($numeric_id) == 1)
    //         {
    //         $zero_string = '00';
    //     }elseif(mb_strlen($numeric_id) == 2)
    //     {
    //         $zero_string = '0';
    //     }else{
    //         $zero_string = '';
    //     }
    //     $new_id = 'S'.$zero_string.$numeric_id;
    // }
}
