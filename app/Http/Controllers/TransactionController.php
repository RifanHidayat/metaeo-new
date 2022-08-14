<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    public function indexData()
    {
        $transactions = Transaction::with(['customer', 'invoices'])->select('transactions.*');
        return DataTables::eloquent($transactions)
            ->addIndexColumn()
            ->addColumn('invoice_number', function (Transaction $transaction) {
                return $transaction->invoices->map(function ($invoice) {
                    return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $invoice->number . '</span>';
                })->implode("");
            })
            ->addColumn('action', function ($row) {
                $button = ' <div class="text-center">';
                //     $button .= ' <a href="/quotation/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                //     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                //       <rect x="0" y="0" width="24" height="24"></rect>
                //       <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                //       <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                //     </g>
                //   </svg> </span> </a>';


                $button .= '<a href="#" data-id="' . $row->id . '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24"></rect>
                  <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                  <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                </g>
              </svg> </span> </a>';


                $button .= '<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-item">
                                    <a href="/transaction/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/transaction/detail/' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-indent-dots"></i>
                                        </span>
                                        <span class="navi-text">Detail</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>';

                $button .= '</div>';

                return $button;
            })
            ->rawColumns(['invoice_number', 'action'])
            ->make(true);
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
        // $transaction->number = $request->number;
        $transaction->number = getRecordNumber(new Transaction, 'TR');
        $transaction->date = $request->date;
        $transaction->account_id = $request->account_id;
        $transaction->account_name = $request->account_name;
        // $transaction->total = $request->total;
        $transaction->total = $paymentAmount;
        $transaction->payment_method = $request->payment_method;
        $transaction->other_payment_method = $request->other_payment_method;
        $transaction->note = $request->note;
        $transaction->sender_name = $request->sender_name;
        $transaction->sender_bank = $request->sender_bank;
        $transaction->sender_number = $request->sender_number;
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

        $customerInvoices = Invoice::with(['transactions'])
            ->whereIn('id', $selectedInvoicesIds)
            ->orderBy('date', 'ASC')
            // ->where('paid', 0)
            ->get()
            // ->each(function ($invoice) {
            //     $invoice['total_payment'] = collect($invoice->payments)->sum('amount');
            // })
            // ->filter(function ($invoice) {
            //     return $invoice->total_payment < $invoice->total;
            // })
            ->each(function ($invoice) {
                $invoice['total_payment'] = collect($invoice->transactions)
                    ->map(function ($transaction) {
                        return $transaction->pivot->amount;
                    })->sum();
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
                    'transaction_id' => $transaction->id,
                    'invoice_id' => $invoice->id,
                    'amount' => $amount,
                    // 'created_at' => Carbon::now()->toDateTimeString(),
                    // 'updated_at' => Carbon::now()->toDateTimeString(),
                    // $invoice->id => [
                    //     'amount' => $amount,
                    //     'created_at' => Carbon::now()->toDateTimeString(),
                    //     'updated_at' => Carbon::now()->toDateTimeString(),
                    // ]
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

        $keyedPayments = collect($payments)->mapWithKeys(function ($item) {
            return [
                $item['invoice_id'] => [
                    'amount' => $item['amount'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        });

        // return response()->json([
        //     'message' => 'Data has been saved',
        //     'code' => 200,
        //     'error' => false,
        //     'data' => $payments,
        // ]);

        // $invoicesIds = collect($payments)->map(function ($item) {
        //     return $item['invoice_id'];
        // })->all();

        try {
            $transaction->invoices()->attach($keyedPayments);

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $transaction,
            ]);
        } catch (Exception $e) {
            $transaction->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        // try {
        //     Payment::insert($payments);
        // } catch (Exception $e) {
        //     $transaction->invoices()->detach();
        //     $transaction->delete();
        //     return response()->json([
        //         'message' => 'Internal error',
        //         'code' => 500,
        //         'error' => true,
        //         'errors' => $e,
        //     ], 500);
        // }

        // try {
        //     foreach ($invoices as $invoice) {
        //         $invoiceRow = Invoice::find($invoice['id']);
        //         if ($invoiceRow == null) {
        //             continue;
        //         }

        //         $invoiceRow->paid = 1;
        //         $invoiceRow->save();
        //     }
        //     return response()->json([
        //         'message' => 'Data has been saved',
        //         'code' => 200,
        //         'error' => false,
        //         'data' => $transaction,
        //     ]);
        // } catch (Exception $e) {
        //     $transaction->invoices()->detach();
        //     $transaction->delete();
        //     return response()->json([
        //         'message' => 'Internal error',
        //         'code' => 500,
        //         'error' => true,
        //         'errors' => $e,
        //     ], 500);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::with(['customer', 'invoices'])->findOrFail($id);

        // return $transaction;

        return view('transaction.detail', [
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
        $transaction = Transaction::find($id);
        $deletedData = $transaction;

        try {
            $transaction->invoices()->detach();
            $transaction->delete();
            return [
                'message' => 'data has been deleted',
                'error' => false,
                'data' => [
                    'deleted_data' => $deletedData,
                ],
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

    public function print($id)
    {
        $transaction = Transaction::with(['invoices'])->findOrFail($id);

        // return $transaction;

        $company = Company::all()->first();

        $totalPayment = collect($transaction->invoices)->map(function ($invoice) {
            return $invoice->pivot->amount;
        })->sum();

        // return $totalPayment;

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }

        $pdf = PDF::loadView('transaction.print', [
            'transaction' => $transaction,
            'company' => $company,
            'total_payment' => $totalPayment,
            'terbilang' => $this->terbilang($totalPayment),
        ]);
        $pdf->setPaper('a5', 'landscape');
        return $pdf->stream($transaction->number . '.pdf');
    }

    private function clearThousandFormat($number)
    {
        return str_replace(".", "", $number);
    }

    private function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    private function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }
}
