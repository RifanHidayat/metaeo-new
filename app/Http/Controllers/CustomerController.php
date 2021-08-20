<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with(['invoices.payments'])->get()
            ->each(function ($customer) {
                $customer['paid'] = collect($customer->invoices)->flatMap(function ($invoice) {
                    return $invoice->payments;
                })->sum('amount');
                $customer['total_invoice'] = collect($customer->invoices)->sum('total');

                $customer['unpaid'] = $customer->total_invoice - $customer->paid;
            })->all();

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
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->npwp = $request->npwp;
        $customer->with_ppn = $request->with_ppn;
        $customer->with_pph = $request->with_pph;
        $customer->address = $request->address;

        try {
            $customer->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $customer,
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
        return view('customer.edit', ['customer' => $customer]);
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
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->npwp = $request->npwp;
        $customer->with_ppn = $request->with_ppn;
        $customer->with_pph = $request->with_pph;
        $customer->address = $request->address;

        try {
            $customer->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $customer,
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
        $invoices = Invoice::with(['payments'])
            ->where('customer_id', $id)
            ->orderBy('date', 'DESC')
            // ->where('paid', 0)
            ->get()
            ->each(function ($invoice) {
                $invoice['total_payment'] = collect($invoice->payments)->sum('amount');
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
