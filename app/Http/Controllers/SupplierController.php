<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Division;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierAccount;

use App\Models\SupplierTax;
use App\Models\SupplierTaxItem;
use Carbon\Carbon;
use CreateSuppliersTable;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all()->sortByDesc('id');
        return view('supplier.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function indexData()
    {
        $supplier = Supplier::with(['purchaseReceives'])->select('suppliers.*');
        
        
        return DataTables::eloquent($supplier)
            ->addIndexColumn()
            ->addColumn('hutang',function($row){
                $total=collect($row->purchaseReceives)->sum('total');
                $payment=collect($row->purchaseReives)->sum('payment');
                return $total-$payment;

            })
           

            
            ->addColumn('action', function ($row) {
                $button = '<div class="text-center">';
                $button .= '<a href="/supplier/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                  <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                </g>
              </svg> </span> </a>
              <a href="#" data-id="' . $row->id . '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                  <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                </g>
              </svg> </span> </a>';

             
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        

        $kode = Supplier::max('id');
        $number = "S" . sprintf("%03d", $kode + 1);
        $divisions=Division::all();
        $supplierTax=SupplierTax::all();
        $supplierTaxItem=SupplierTaxItem::all();
        $accounts=Account::all();
       // $supplierAccount=SupplierAccount::all();

        return view('supplier.create', [
            'number' => $number,
            'divisions'=>$divisions,
            'supplier_tax'=>$supplierTax,
            'supplier_tax_item'=>$supplierTaxItem,
            'accounts'=>$accounts,
           // 'supplier_accounts'=>$supplierAccount
        ]);

    }

    public function store(Request $request)
    {
//return $request->division_ids;  
        DB::beginTransaction();
        try {
        $supplier = new Supplier;
         if ($request->number == null) {
            $maxSupplier = Supplier::max('id');
            $number = "S" . sprintf("%03d", $maxSupplier + 1);
            $supplier->number = $number;
        }

        $divisionIds=$request->division_ids;
        $supplierAccounts=$request->supplier_accounts;
        $supplier->number = $request->number;
        $supplier->division_id=0;
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
        $supplier->is_individual = $request->is_individual;
        $supplier->supplier_tax_id=$request->supplier_tax_id;
        $supplier->supplier_tax_item_id=$request->supplier_tax_item_id;
        $supplier->hutang_id=$request->hutang_id;
        $supplier->piutang_id=$request->piutang_id;
        $supplier->is_active=1;
        $supplier->save();

        $suplierDivsions = collect($divisionIds)->map(function ($item) use($supplier){
        return [
            'supplier_id' =>$supplier->id ,
             'division_id' => $item,
              'created_at' => Carbon::now()->toDateTimeString(),
               'updated_at' => Carbon::now()->toDateTimeString(),    
                ]; 
    })->all();
  //  return ;
       DB::table('supplier_division')->insert($suplierDivsions);

        $suplierAccounts = collect($supplierAccounts)->map(function ($item) use($supplier){
        return [
            'number' =>$item[   'number'] ,
             'name' => $item['name'],
              'bank_name' => $item['bank_name'],
               'supplier_id' => $supplier->id,
              'created_at' => Carbon::now()->toDateTimeString(),
               'updated_at' => Carbon::now()->toDateTimeString(),    
                ]; 
    })->all();
       DB::table('supplier_accounts')->insert($suplierAccounts);
       DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $supplier,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);
        }
    }

    public function edit($id)
    {
       // return "tes";
        $divisions=Division::all();
        $supplier = Supplier::with('supplierAccounts')->findOrFail($id);
       // return $supplier;
        $accounts=Account::all();
        $supplierTax=SupplierTax::all();
        $supplierTaxItem=SupplierTaxItem::all();
       // return $supplier;
        return view('supplier.edit', [
        'supplier' => $supplier,
        'divisions'=>$divisions,'accounts'=>$accounts,
        'supplier_tax'=>$supplierTax,
        'supplier_tax_item'=>$supplierTaxItem,
        'supplier_account'=>$supplier->supplierAccounts
    ]);
    }

    public function update(Request $request, $id)
    {
       // return $request->all();

                // return $request->division_ids;  
        DB::beginTransaction();
        try {
        $supplier = Supplier::findOrFail($id);
        //  if ($request->number == null) {
        //     $maxSupplier = Supplier::max('id');
        //     $number = "S" . sprintf("%03d", $maxSupplier + 1);
        //     $supplier->number = $number;
        // }

        $divisionIds=$request->division_ids;
        $supplierAccounts=$request->supplier_accounts;
        
        $supplier->division_id=0;
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
        $supplier->is_individual = $request->is_individual;
        $supplier->supplier_tax_id=$request->supplier_tax_id;
        $supplier->supplier_tax_item_id=$request->supplier_tax_item_id;
        $supplier->hutang_id=$request->hutang_id;
        $supplier->piutang_id=$request->piutang_id;
        $supplier->is_active=$request->is_active;
        $supplier->save();

        DB::table('supplier_division')->where('supplier_id', $id)->delete();
        DB::table('supplier_accounts')->where('supplier_id', $id)->delete();

        $suplierDivsions = collect($divisionIds)->map(function ($item) use($supplier){
        return [
            'supplier_id' =>$supplier->id ,
             'division_id' => $item,
              'created_at' => Carbon::now()->toDateTimeString(),
               'updated_at' => Carbon::now()->toDateTimeString(),    
                ]; 
    })->all();
  //  return ;
       DB::table('supplier_division')->insert($suplierDivsions);

        $suplierAccounts = collect($supplierAccounts)->map(function ($item) use($supplier){
        return [
            'number' =>$item['number'] ,
             'name' => $item['name'],
              'bank_name' => $item['bank_name'],
               'supplier_id' => $supplier->id,
              'created_at' => Carbon::now()->toDateTimeString(),
               'updated_at' => Carbon::now()->toDateTimeString(),    
                ]; 
    })->all();
       DB::table('supplier_accounts')->insert($suplierAccounts);
       DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $supplier,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e.'',
            ], 500);
        }
    //   //  return $request->all();

    //         $supplier = Supplier::findOrFail($id);
        
    //     $supplier->division_id=$request->division_id;
    //     $supplier->name = $request->name;
    //     $supplier->address = $request->address;
    //     $supplier->telephone = $request->telephone;
    //     $supplier->handphone = $request->handphone;
    //     $supplier->email = $request->email;
    //     $supplier->npwp_number=$request->npwp_number;
    //     $supplier->npwp_address=$request->npwp_address;
    //     $supplier->contact_name = $request->contact_name;
    //     $supplier->contact_address = $request->contact_address;
    //     $supplier->contact_number = $request->contact_number;
    //     $supplier->contact_position = $request->contact_position;
    //     $supplier->contact_email = $request->contact_email;
    //       $supplier->is_individual = $request->is_individual;


        

    //     try {
    //         $supplier->save();
    //         return response()->json([
    //             'message' => 'Data has been saved',
    //             'code' => 200,
    //             'error' => false,
    //             'data' => $supplier,
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'message' => 'Internal error',
    //             'code' => 500,
    //             'error' => true,
    //             'errors' => $e,
    //         ], 500);
    //     }
   
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
