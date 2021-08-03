<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::with(['customer'])->get();

        return view('transaction.index', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $customerId = $request->customer_id;
        $paymentAmount = $this->clearThousandFormat($request->payment_amount);

        $transaction = new Transaction;
        $transaction->number = $request->number;
        $transaction->date = $request->date;
        $transaction->account_id = $request->account_id;
        $transaction->account_name = $request->account_name;
        // $transaction->total = $request->total;
        $transaction->total = $paymentAmount;
        $transaction->payment_method = $request->payment_method;
        $transaction->other_payment_method = $request->other_payment_method;
        $transaction->note = $request->note;
        $transaction->customer_id = $customerId;

        $invoices = $request->selected_invoices;

        try {
            $transaction->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        $payments = [];
        $totalInvoices = 0;

        // $customerInvoices = Invoice::with(['payments'])
        //     ->where('customer_id', $customerId)
        //     ->orderBy('date', 'ASC')
        //     // ->where('paid', 0)
        //     ->get()
        //     ->each(function ($invoice) {
        //         $invoice['total_payment'] = collect($invoice->payments)->sum('amount');
        //     })
        //     ->filter(function ($invoice) {
        //         return $invoice->total_payment < $invoice->total;
        //     })
        //     ->each(function ($invoice) use ($paymentAmount, &$totalInvoices, &$payments, $transaction) {
        //         // Remaining Debt Has To Pay Per Invoice
        //         $remainingInvoiceTotal = $invoice->total - $invoice->total_payment;
        //         // 248_400_000 - 0 = 248_400_000
        //         // 32_400_000 - 0 = 32_400_000

        //         $amount = $remainingInvoiceTotal;
        //         // 248_400_000
        //         // 32_400_000

        //         $remainingPaymentAmount = $paymentAmount - $totalInvoices;
        //         // 250_000_000 - 0 = 250_000_000
        //         // 250_000_000 - 248_400_000 = 1_600_000

        //         // 248_400_000 > 250_000_000 = FALSE
        //         // 32_400_000 > 1_600_000 = TRUE
        //         if ($remainingInvoiceTotal > $remainingPaymentAmount) {
        //             $amount = $remainingPaymentAmount;
        //         }

        //         $payment = [
        //             'amount' => $amount,
        //             'transaction_id' => $transaction->id,
        //             'invoice_id' => $invoice->id,
        //             'created_at' => Carbon::now()->toDateTimeString(),
        //             'updated_at' => Carbon::now()->toDateTimeString(),
        //         ];

        //         array_push($payments, $payment);

        //         $totalInvoices = $totalInvoices + $remainingInvoiceTotal;
        //         // 0 + 248_400_000 = 248_400_000
        //         // 248_400_000 + 1_600_000 = 250_000_000

        //         // $invoice['x_remaining_invoice_total'] = $remainingInvoiceTotal;
        //         // $invoice['x_remaining_payment_amount'] = $remainingPaymentAmount;
        //         // $invoice['x_amount'] = $amount;
        //         // $invoice['x_total_invoices'] = $totalInvoices;

        //         // 250_000_000 - 248_000_000 > 0
        //         // 250_000_000 - 250_000_000 <= 0
        //         if (($paymentAmount - $totalInvoices) <= 0) {
        //             return false;
        //         }
        //     });


        // $customerInvoices = collect($invoices)
        $selectedInvoicesIds = collect($invoices)->pluck('id')->all();

        $customerInvoices = Invoice::with(['payments'])
            ->whereIn('id', $selectedInvoicesIds)
            ->orderBy('date', 'ASC')
            // ->where('paid', 0)
            ->get()
            ->each(function ($invoice) {
                $invoice['total_payment'] = collect($invoice->payments)->sum('amount');
            })
            ->filter(function ($invoice) {
                return $invoice->total_payment < $invoice->total;
            })
            ->each(function ($invoice) use ($paymentAmount, &$totalInvoices, &$payments, $transaction) {
                // Remaining Debt Has To Pay Per Invoice
                $remainingInvoiceTotal = $invoice->total - $invoice->total_payment;
                // 248_400_000 - 0 = 248_400_000
                // 32_400_000 - 0 = 32_400_000

                $amount = $remainingInvoiceTotal;
                // 248_400_000
                // 32_400_000

                $remainingPaymentAmount = $paymentAmount - $totalInvoices;
                // 250_000_000 - 0 = 250_000_000
                // 250_000_000 - 248_400_000 = 1_600_000

                // 248_400_000 > 250_000_000 = FALSE
                // 32_400_000 > 1_600_000 = TRUE
                if ($remainingInvoiceTotal > $remainingPaymentAmount) {
                    $amount = $remainingPaymentAmount;
                }

                $payment = [
                    'amount' => $amount,
                    'transaction_id' => $transaction->id,
                    'invoice_id' => $invoice->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];

                array_push($payments, $payment);

                $totalInvoices = $totalInvoices + $remainingInvoiceTotal;
                // 0 + 248_400_000 = 248_400_000
                // 248_400_000 + 1_600_000 = 250_000_000

                // $invoice['x_remaining_invoice_total'] = $remainingInvoiceTotal;
                // $invoice['x_remaining_payment_amount'] = $remainingPaymentAmount;
                // $invoice['x_amount'] = $amount;
                // $invoice['x_total_invoices'] = $totalInvoices;

                // 250_000_000 - 248_000_000 > 0
                // 250_000_000 - 250_000_000 <= 0
                if (($paymentAmount - $totalInvoices) <= 0) {
                    return false;
                }
            });

        // return response()->json([
        //     'message' => 'Data has been saved',
        //     'code' => 200,
        //     'error' => false,
        //     'data' => $payments,
        //     'invoices' => $customerInvoices
        // ]);

        // $invoicesIds = collect($invoices)->map(function ($item) {
        //     return $item['id'];
        // })->all();
        $invoicesIds = collect($payments)->map(function ($item) {
            return $item['invoice_id'];
        })->all();

        try {
            $transaction->invoices()->attach($invoicesIds);

            // return response()->json([
            //     'message' => 'Data has been saved',
            //     'code' => 200,
            //     'error' => false,
            //     'data' => $transaction,
            // ]);
        } catch (Exception $e) {
            $transaction->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            Payment::insert($payments);
        } catch (Exception $e) {
            $transaction->invoices()->detach();
            $transaction->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($invoices as $invoice) {
                $invoiceRow = Invoice::find($invoice['id']);
                if ($invoiceRow == null) {
                    continue;
                }

                $invoiceRow->paid = 1;
                $invoiceRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $transaction,
            ]);
        } catch (Exception $e) {
            $transaction->invoices()->detach();
            $transaction->delete();
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
        $transaction = Transaction::with(['customer', 'payments.invoice'])->findOrFail($id);

        // return $transaction;

        return view('transaction.show', [
            'transaction' => $transaction,
        ]);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function clearThousandFormat($number)
    {
        return str_replace(".", "", $number);
    }
}
