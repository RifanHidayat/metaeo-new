<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\SalesOrder;
use App\Models\V2SalesOrder;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice.index');
    }

    public function indexData()
    {
        $invoices = Invoice::with(['v2SalesOrder', 'transactions'])->select('invoices.*');
        return DataTables::of($invoices)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '
                <div class="text-center">
                <a href="/invoice/edit/' . $row->id . '" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit"> <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
              </svg> </span> </a>
              <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi navi-hover">
                                <li class="navi-item">
                                    <a href="/invoice/detail/' . $row->id . '" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon-interface-4"></i>
                                        </span>
                                        <span class="navi-text">Detail</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/invoice/print/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/invoice/print-v2/' . $row->id . '" target="_blank" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="flaticon2-print"></i>
                                        </span>
                                        <span class="navi-text">Cetak Berdasarkan Delivery Order</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                </div>
                ';
                return $button;
            })
            ->rawColumns(['quotation_number', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $invoicesByCurrentDateCount = Invoice::query()->where('date', date("Y-m-d"))->get()->count();
        // $invoiceNumber = 'INV-' . date('d') . date('m') . date("y") . sprintf('%04d', $invoicesByCurrentDateCount + 1);
        $invoicesByCurrentYearCount = Invoice::query()->whereYear('date', date("Y"))->get()->count();
        $currentYear = date("Y");
        $romanYear = $this->numberToRomanRepresentation((int) $currentYear);
        $firstSplitYear = substr($romanYear, 0, 2);
        $secondSplitYear = substr($romanYear, 2);
        // $secondSplitRomanYear = $this->numberToRomanRepresentation((int) $secondSplitYear);
        $invoiceNumber = $firstSplitYear . '-' . $secondSplitYear . '-' . sprintf('%05d', $invoicesByCurrentYearCount + 1);
        // $invoiceNumber = $this->numberToRomanRepresentation(2000);

        // return $salesOrder;

        return view('invoice.v2.create', [
            'number' => $invoiceNumber,
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
        $invoice = new Invoice;
        $invoice->number = $request->number;
        // $invoice->number = getRecordNumber(new Invoice, 'INV');
        $invoice->date = $request->date;
        $invoice->due_date = $request->due_date;
        $invoice->due_date_term = $request->due_date_term;
        $invoice->tax_invoice_series = $request->tax_invoice_series;
        $invoice->terms_of_payment = $request->terms_of_payment;
        $invoice->gr_number = $request->gr_number;
        $invoice->discount = $this->clearThousandFormat($request->discount);
        $invoice->pic_po = $request->pic_po;
        $invoice->pic_po_position = $request->pic_po_position;
        $invoice->note = $request->note;
        $invoice->netto = $request->netto;
        $invoice->ppn = $request->ppn;
        $invoice->pph = $request->pph;
        $invoice->total = $request->total;
        $invoice->terbilang = $request->terbilang;
        $invoice->sales_order_id = $request->sales_order_id;
        $invoice->customer_id = $request->customer_id;

        $quotations = $request->selected_quotations;

        try {
            $invoiceWithNumber = Invoice::query()->where('number', $request->number)->first();
            if ($invoiceWithNumber !== null) {
                return response()->json([
                    'message' => 'Internal error',
                    'code' => 400,
                    'error' => true,
                    'error_type' => 'exist_number',
                    'data' => [
                        'swal' => [
                            'title' => 'Kesalahan',
                            'text' => 'Nomor faktur sudah digunakan',
                            'icon' => 'warning'
                        ],
                    ]
                    // 'errors' => $e,
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $invoice->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        $keyedQuotations = collect($quotations)->mapWithKeys(function ($item) {
            // if (!isset($item['production'])) {
            //     $item['production'] = 0;
            // };

            return [
                $item['id'] => [
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        });

        try {
            $invoice->quotations()->attach($keyedQuotations);
        } catch (Exception $e) {
            $invoice->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation['id']);
                if ($quotationRow == null) {
                    continue;
                }

                $quotationRow->paid = 1;
                $quotationRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $invoice,
            ]);
        } catch (Exception $e) {
            $invoice->quotations()->detach();
            $invoice->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeV2(Request $request)
    {
        $invoiceWithNumber = Invoice::query()->where('number', $request->number)->first();
        if ($invoiceWithNumber !== null) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 400,
                'error' => true,
                'error_type' => 'exist_number',
                'data' => [
                    'swal' => [
                        'title' => 'Kesalahan',
                        'text' => 'Nomor faktur sudah digunakan',
                        'icon' => 'warning'
                    ],
                ]
                // 'errors' => $e,
            ], 400);
        }

        DB::beginTransaction();

        try {

            $invoice = new Invoice;
            $invoice->number = $request->number;
            // $invoice->number = getRecordNumber(new Invoice, 'INV');
            $invoice->date = $request->date;
            $invoice->due_date = $request->due_date;
            $invoice->due_date_term = $request->due_date_term;
            $invoice->tax_invoice_series = $request->tax_invoice_series;
            $invoice->terms_of_payment = $request->terms_of_payment;
            $invoice->gr_number = $request->gr_number;
            $invoice->discount = $this->clearThousandFormat($request->discount);
            $invoice->pic_po = $request->pic_po;
            $invoice->pic_po_position = $request->pic_po_position;
            $invoice->note = $request->note;
            $invoice->netto = $request->netto;
            $invoice->ppn = $request->ppn;
            $invoice->pph = $request->pph;
            $invoice->total = $request->total;
            $invoice->terbilang = $request->terbilang;
            $invoice->sales_order_id = $request->sales_order_id;
            $invoice->customer_id = $request->customer_id;

            $invoice->save();

            $selectedDeliveryOrders = $request->selected_delivery_orders;

            $deliveryOrders = collect($selectedDeliveryOrders)->mapWithKeys(function ($item) {
                return [
                    $item['id'] => [
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]
                ];
            });

            $invoice->deliveryOrders()->attach($deliveryOrders);

            DB::commit();

            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $invoice,
            ]);
        } catch (Exception $e) {
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
        $invoice = Invoice::with(['quotations.selectedEstimation', 'payments.transaction' => function ($q) {
            $q->orderBy('date', 'DESC');
        }, 'customer'])->findOrFail($id);

        $totalPaid = collect($invoice->transactions)->map(function ($transaction) {
            return $transaction->pivot->amount;
        })->sum();
        $totalUnpaid = $invoice->total - $totalPaid;

        $summary = [
            [
                'title' => 'TOTAL FAKTUR',
                'amount' => $invoice->total,
            ],
            [
                'title' => 'TOTAL PAID',
                'amount' => $totalPaid,
            ],
            [
                'title' => 'UNPAID',
                'amount' => $totalUnpaid,
            ],
        ];

        $status = 'incomplete';

        if ($totalUnpaid <= 0) {
            $status = 'complete';
        }

        // return $invoice;
        return view('invoice.detail', [
            'invoice' => $invoice,
            'summary' => $summary,
            'status' => $status,
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
        $invoice = Invoice::with(['quotations', 'salesOrder'])->findOrFail($id);

        $checkedInvoices = collect($invoice->quotations)->pluck('id')->all();

        $salesOrderId = $invoice->sales_order_id;
        $salesOrder = SalesOrder::with(['quotations', 'customer'])->find($salesOrderId);

        if ($salesOrderId == null || $salesOrder == null) {
            // abort(404);
            return view('errors.custom-error', [
                'title' => 'ID Sales Order Tidak Ditemukan',
                'subtitle' => 'Pastikann id sales order atau url telah sesuai'
            ]);
        }

        // return $salesOrder->quotations->pivot->estimation;

        // return 

        // $customerExist = $salesOrder->quotations->filter(function ($item) {
        //     return $item->estimations !== null && count($item->estimations) > 0;
        // })->flatMap(function ($item) {
        //     return $item->estimations;
        // })->filter(function ($item) {
        //     return $item->picPo->customer !== null;
        // })->first();

        // $customer = null;

        // if ($customerExist !== null) {
        //     $customer = $customerExist->picPo->customer;
        // }

        // if ($invoice->quotations !== null) {
        //     if (count($invoice->quotations) > 0) {
        //         foreach ($invoice->quotations as $quotation) {
        //             $quotation->pivot->estimation;
        //         }
        //     }
        // }

        if ($salesOrder->quotations !== null) {
            if (count($salesOrder->quotations) > 0) {
                foreach ($salesOrder->quotations as $quotation) {
                    $quotation->pivot->estimation;
                }
            }
        }

        return view('invoice.edit', [
            'checked_invoices' => $checkedInvoices,
            'invoice' => $invoice,
            // 'customer' => $customer,
            'sales_order' => $salesOrder,
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
        $invoice = Invoice::find($id);
        $invoice->number = $request->number;
        $invoice->date = $request->date;
        $invoice->due_date = $request->due_date;
        $invoice->due_date_term = $request->due_date_term;
        $invoice->tax_invoice_series = $request->tax_invoice_series;
        $invoice->terms_of_payment = $request->terms_of_payment;
        $invoice->gr_number = $request->gr_number;
        $invoice->discount = $this->clearThousandFormat($request->discount);
        $invoice->pic_po = $request->pic_po;
        $invoice->pic_po_position = $request->pic_po_position;
        $invoice->note = $request->note;
        $invoice->netto = $request->netto;
        $invoice->ppn = $request->ppn;
        $invoice->pph = $request->pph;
        $invoice->total = $request->total;
        $invoice->terbilang = $request->terbilang;
        $invoice->sales_order_id = $request->sales_order_id;
        // $invoice->customer_id = $request->customer_id;

        $quotations = $request->selected_quotations;

        try {
            $invoice->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $invoice->quotations()->detach();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        $keyedQuotations = collect($quotations)->mapWithKeys(function ($item) {
            // if (!isset($item['production'])) {
            //     $item['production'] = 0;
            // };

            return [
                $item['id'] => [
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ];
        });

        try {
            $invoice->quotations()->attach($keyedQuotations);
        } catch (Exception $e) {
            $invoice->delete();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation['id']);
                if ($quotationRow == null) {
                    continue;
                }

                $quotationRow->paid = 1;
                $quotationRow->save();
            }
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                'data' => $invoice,
            ]);
        } catch (Exception $e) {
            $invoice->quotations()->detach();
            $invoice->delete();
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
        $invoice = Invoice::find($id);
        $quotations = $invoice->quotations;

        try {
            foreach ($quotations as $quotation) {
                $quotationRow = Quotation::find($quotation->id);
                if ($quotationRow == null) {
                    continue;
                }
                // DIfferent formula with store
                $quotationRow->paid = 0;
                $quotationRow->save();
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }

        try {
            $invoice->quotations()->detach();
            $invoice->delete();
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

    public function print($id)
    {
        $invoice = Invoice::with(['quotations', 'customer', 'salesOrder'])->findOrFail($id);

        $company = Company::all()->first();

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }

        $pdf = PDF::loadView('invoice.print', [
            'invoice' => $invoice,
            'company' => $company,
        ]);
        $pdf->setPaper('a5', 'landscape');
        return $pdf->stream($invoice->number . '.pdf');
    }

    public function printByDeliveryOrder($id)
    {
        $invoice = Invoice::with(['quotations' => function ($q) {
            $q->with(['deliveryOrders', 'selectedEstimation']);
        }, 'customer', 'salesOrder'])->findOrFail($id);

        // return $invoice;
        $company = Company::all()->first();

        if ($company == null) {
            $newCompany = new Company;
            $newCompany->save();
            $company = Company::all()->first();
        }

        $pdf = PDF::loadView('invoice.printv2', [
            'invoice' => $invoice,
            'company' => $company,
        ]);
        $pdf->setPaper('a5', 'landscape');
        return $pdf->stream($invoice->number . '.pdf');
    }

    private function clearThousandFormat($number)
    {
        return str_replace(".", "", $number);
    }

    /**
     * @param int $number
     * @return string
     */
    public function numberToRomanRepresentation($number)
    {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Yajra\DataTables\Facades\DataTables;
     */
    public function datatablesSalesOrders(Request $request)
    {
        $customerId = $request->query('customer_id');
        // $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        $salesOrders = V2SalesOrder::with(['deliveryOrders' => function ($query) {
            return $query->with(['cpoItems', 'v2QuotationItems', 'invoices']);
        }])->select('v2_sales_orders.*')->get();
        // ->filter(function ($quotation) {
        //     return count($quotation->salesOrders) < 1;
        // })->all();

        return DataTables::of($salesOrders)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = '<button class="btn btn-light-primary btn-choose"><i class="flaticon-add-circular-button"></i> Pilih</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
