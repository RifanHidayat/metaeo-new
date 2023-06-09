<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\CustomerTax;
use App\Models\CustomerTaxItem;
use App\Models\Division;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\SupplierTax;
use App\Models\SupplierTaxItem;
use App\Models\Transaction;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with(['invoices.transactions'])->get()
            // ->flatMap(function ($customer) {
            //     return $customer->invoices;
            // })
            // ->flatMap(function ($invoice) {
            //     return $invoice->transactions;
            // })
            // ->map(function ($transaction) {
            //     return $transaction->pivot->amount;
            // })
            // ->all();
            ->each(function ($customer) {
                $customer['paid'] = collect($customer->invoices)->flatMap(function ($invoice) {
                    return $invoice->transactions;
                })->map(function ($transaction) {
                    return $transaction->pivot->amount;
                })->sum();
                $customer['total_invoice'] = collect($customer->invoices)->sum('total');

                $customer['unpaid'] = $customer->total_invoice - $customer->paid;
            });

        // return $customers;
        return view('customer.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kode = Supplier::max('id');
        $number = "S" . sprintf("%03d", $kode + 1);
        $divisions=Division::all();
        $supplierTax=CustomerTax::all();
        $supplierTaxItem=CustomerTaxItem::all();
        $accounts=Account::all();
        return view('customer.create',[
             'number' => $number,
            'divisions'=>$divisions,
            'supplier_tax'=>$supplierTax,
            'accounts'=>$accounts,
            'supplier_tax_item'=>$supplierTaxItem,
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
      //  return $request->all();

        DB::beginTransaction();
        $customer = new Customer;
        // $maxSupplier = Cus::max('id');
        // $number = "S" . sprintf("%03d", $maxSupplier + 1);
        // $customer->number = $number;

        $supplierAccounts=$request->supplier_accounts;
        // $customer->number = $request->number;
    
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->telephone = $request->telephone;
        $customer->handphone = $request->handphone;
        $customer->email = $request->email;
        $customer->npwp =$request->npwp_number;
        $customer->npwp_address=$request->npwp_address;
        $customer->contact_name = $request->contact_name;
        $customer->contact_address = $request->contact_address;
        $customer->contact_number = $request->contact_number;
        $customer->contact_position = $request->contact_position;
        $customer->contact_email = $request->contact_email;
        
        $customer->customer_tax_id=$request->supplier_tax_id;
        $customer->customer_tax_item_id=$request->supplier_tax_item_id;
        $customer->advanced_account=$request->advanced_account;
        $customer->piutang_id=$request->piutang_id;
        $customer->ktp_number=$request->ktp_number;
        $customer->ref_pajak=$request->ref_pajak;
        $customer->is_active=1;
        // $customer->name = $request->name;
        // $customer->phone = $request->phone;
        // $customer->npwp = $request->npwp;
        // $customer->with_ppn = $request->with_ppn;
        // $customer->with_pph = $request->with_pph;
        // $customer->address = $request->address;

        try {
            $customer->save();
            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $customer,
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
        $customer = Customer::findOrFail($id);
         $kode = Supplier::max('id');
        $number = "S" . sprintf("%03d", $kode + 1);
        $divisions=Division::all();
        $supplierTax=CustomerTax::all();
        $supplierTaxItem=CustomerTaxItem::all();
        $accounts=Account::all();

        return view('customer.edit', ['customer' => $customer,
          'number' => $number,
            'divisions'=>$divisions,
            'supplier_tax'=>$supplierTax,
            'accounts'=>$accounts,
            'supplier_tax_item'=>$supplierTaxItem,

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
              //  return $request->all();

        DB::beginTransaction();
        $customer = Customer::findOrFail($id);
        // $maxSupplier = Cus::max('id');
        // $number = "S" . sprintf("%03d", $maxSupplier + 1);
        // $customer->number = $number;

        $supplierAccounts=$request->supplier_accounts;
        // $customer->number = $request->number;
    
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->telephone = $request->telephone;
        $customer->handphone = $request->handphone;
        $customer->email = $request->email;
        $customer->npwp =$request->npwp_number;
        $customer->npwp_address=$request->npwp_address;
        $customer->contact_name = $request->contact_name;
        $customer->contact_address = $request->contact_address;
        $customer->contact_number = $request->contact_number;
        $customer->contact_position = $request->contact_position;
        $customer->contact_email = $request->contact_email;
        
        $customer->customer_tax_id=$request->supplier_tax_id;
        $customer->customer_tax_item_id=$request->supplier_tax_item_id;
        $customer->advanced_account=$request->advanced_account;
        $customer->piutang_id=$request->piutang_id;
        $customer->is_active=$request->is_active;
        // $customer->name = $request->name;
        // $customer->phone = $request->phone;
        // $customer->npwp = $request->npwp;
        // $customer->with_ppn = $request->with_ppn;
        // $customer->with_pph = $request->with_pph;
        // $customer->address = $request->address;

        try {
            $customer->save();
            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $customer,
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


        // $customer = Customer::find($id);
        // $customer->name = $request->name;
        // $customer->phone = $request->phone;
        // $customer->npwp = $request->npwp;
        // $customer->with_ppn = $request->with_ppn;
        // $customer->with_pph = $request->with_pph;
        // $customer->address = $request->address;

        // try {
        //     $customer->save();
        //     return response()->json([
        //         'message' => 'Data has been saved',
        //         'code' => 200,
        //         'error' => false,
        //         'data' => $customer,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        try {
            $customer->delete();
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

    public function getAllPicPos($id)
    {
        try {
            $customer = Customer::find($id);
            $picPos = $customer->picpos;
            return [
                'message' => 'data has been deleted',
                'error' => false,
                'code' => 200,
                'data' => $picPos,
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

    public function payment($id)
    {
        $customer = Customer::findOrFail($id);
        $invoices = Invoice::with(['transactions'])
            ->where('customer_id', $id)
            ->orderBy('date', 'DESC')
            // ->where('paid', 0)
            ->get()
            // ->each(function ($invoice) {
            //     $invoice['total_payment'] = collect($invoice->payments)->sum('amount');
            // })
            // ->filter(function ($invoice) {
            //     return $invoice->total_payment < $invoice->total;
            // })
            // // ->map(function ($invoice) {
            // //     return $invoice->total_payment;
            // // })
            // ->values()->all();
            ->each(function ($invoice) {
                $invoice['total_payment'] = collect($invoice->transactions)
                    ->map(function ($transaction) {
                        return $transaction->pivot->amount;
                    })->sum();
            })
            ->filter(function ($invoice) {
                return $invoice->total_payment < $invoice->total;
            })
            // ->map(function ($invoice) {
            //     return $invoice->total_payment;
            // })
            ->values()->all();

        // return $invoices;

        $transactionsByCurrentDateCount = Transaction::query()->where('date', date("Y-m-d"))->get()->count();
        // return $estimationsByCurrentDateCount;
        $transactionNumber = 'TR-' . date('d') . date('m') . date("y") . sprintf('%04d', $transactionsByCurrentDateCount + 1);

        return view('customer.payment', [
            'transaction_number' => $transactionNumber,
            'customer' => $customer,
            'invoices' => $invoices,
        ]);
    }

    public function warehouse($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customer.warehouse', [
            'customer' => $customer,
        ]);
    }
}
