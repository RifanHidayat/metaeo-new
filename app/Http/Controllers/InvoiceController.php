<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\SalesOrder;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
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
        $invoices = Invoice::with(['quotations', 'salesOrder']);
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
                </div>
                ';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $salesOrderId = $request->query('so');
        $salesOrder = SalesOrder::with(['quotations.selectedEstimation', 'customer'])->find($salesOrderId);

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

        if ($salesOrder->quotations !== null) {
            if (count($salesOrder->quotations) > 0) {
                foreach ($salesOrder->quotations as $quotation) {
                    $quotation->pivot->estimation;
                }
            }
        }

        // return $salesOrder;

        // return $customer;

        // return $salesOrder;

        $invoicesByCurrentDateCount = Invoice::query()->where('date', date("Y-m-d"))->get()->count();
        // return $estimationsByCurrentDateCount;
        $invoiceNumber = 'INV-' . date('d') . date('m') . date("y") . sprintf('%04d', $invoicesByCurrentDateCount + 1);

        // return $salesOrder;

        return view('invoice.create', [
            // 'customer' => $customer,
            'sales_order' => $salesOrder,
            'invoice_number' => $invoiceNumber,
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
        $invoice->date = $request->date;
        $invoice->tax_invoice_series = $request->tax_invoice_series;
        $invoice->terms_of_payment = $request->terms_of_payment;
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
        $invoice->tax_invoice_series = $request->tax_invoice_series;
        $invoice->terms_of_payment = $request->terms_of_payment;
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
        //
    }

    public function print($id)
    {
        $invoice = Invoice::with(['quotations'])->findOrFail($id);

        $pdf = PDF::loadView('invoice.print', [
            'invoice' => $invoice,
        ]);
        return $pdf->stream($invoice->number . '.pdf');
    }
}
