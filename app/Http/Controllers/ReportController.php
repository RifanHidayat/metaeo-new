<?php

namespace App\Http\Controllers;

use App\Exports\DeliveryOrderExport;
use App\Exports\EstimationExport;
use App\Exports\InvoiceExport;
use App\Exports\JobOrderExport;
use App\Exports\QuotationExport;
use App\Exports\SalesOrderExport;
use App\Exports\SpkExport;
use App\Exports\TransactionExport;
use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\Estimation;
use App\Models\Invoice;
use App\Models\JobOrder;
use App\Models\Quotation;
use App\Models\SalesOrder;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function estimation()
    {
        $customers = Customer::all();

        return view('report.estimation', [
            'customers' => $customers,
        ]);
    }

    public function estimationData(Request $request)
    {
        // $columnSelections = explode(',', $request->query('columns'));
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $customer = $request->query('customer');
        $sortBy = $request->query('sort_by');
        $sortIn = $request->query('sort_in');
        // $estimations = Estimation::with(['customer'])->select('estimations.*');
        $query = Estimation::with(['customer'])->select('estimations.*')->whereBetween('date', [$startDate, $endDate]);

        if ($status !== '' && $status !== null) {
            $query->where('status', $status);
        }

        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $estimations = $query->get();

        return DataTables::of($estimations)
            ->addIndexColumn()
            ->make(true);
    }

    public function estimationSheet(Request $request)
    {
        // $startDate = $request->query('start_date');
        // $endDate = $request->query('end_date');
        // $status = $request->query('status');
        // $customer = $request->query('customer');
        // $columns = $request->query('columns');
        // $sortBy = $request->query('sort_by');
        // $sortIn = $request->query('sort_in');
        // return $request->all();

        return Excel::download(new EstimationExport($request->all()), 'Laporan Estimasi Detail.xlsx');
    }

    // Quotation -----------------

    public function quotation()
    {
        $customers = Customer::all();

        return view('report.quotation', [
            'customers' => $customers,
        ]);
    }

    public function quotationData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $customer = $request->query('customer');
        $sortBy = $request->query('sort_by');
        $sortIn = $request->query('sort_in');

        $query = Quotation::with(['estimations', 'picPo', 'customer'])->select('quotations.*')->whereBetween('date', [$startDate, $endDate]);

        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $quotations = $query->get();

        return DataTables::of($quotations)
            ->addIndexColumn()
            // ->rawColumns(['estimation_number'])
            ->make(true);
        // $quotations = Quotation::with(['customer'])->select('quotations.*');
        // return DataTables::of($quotations)
        //     ->addIndexColumn()
        //     ->make(true);
    }

    public function quotationSheet(Request $request)
    {
        return Excel::download(new QuotationExport($request->all()), 'Laporan Quotation Detail.xlsx');
    }

    // Sales Order -----------------

    public function salesOrder()
    {
        $customers = Customer::all();

        return view('report.sales-order', [
            'customers' => $customers,
        ]);
    }

    public function salesOrderData(Request $request)
    {
        // $salesOrders = SalesOrder::with(['customer'])->select('sales_orders.*');
        // return DataTables::of($salesOrders)
        //     ->addIndexColumn()
        //     ->make(true);
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $customer = $request->query('customer');
        $sortBy = $request->query('sort_by');
        $sortIn = $request->query('sort_in');

        $query = SalesOrder::with(['quotations.selectedEstimation', 'jobOrders', 'invoices', 'deliveryOrders'])->select('sales_orders.*')->whereBetween('date', [$startDate, $endDate]);

        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $salesOrders = $query->get();


        return DataTables::of($salesOrders)
            ->addIndexColumn()
            ->addColumn('quotation_number', function (SalesOrder $salesOrder) {
                return $salesOrder->quotations->map(function ($quotation) {
                    return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $quotation->number . '</span>';
                })->implode("");
            })
            ->rawColumns(['quotation_number'])
            ->make(true);
    }

    public function salesOrderSheet(Request $request)
    {
        return Excel::download(new SalesOrderExport($request->all()), 'Laporan Sales Order Detail.xlsx');
    }

    // SPK -----------------

    public function spk()
    {
        $customers = Customer::all();

        return view('report.spk', [
            'customers' => $customers,
        ]);
    }

    public function spkData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $customer = $request->query('customer');
        $sortBy = $request->query('sort_by');
        $sortIn = $request->query('sort_in');

        $query = JobOrder::with(['quotations', 'salesOrder', 'customer'])->select('job_orders.*')->whereBetween('date', [$startDate, $endDate]);

        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $jobOrders = $query->get();

        return DataTables::of($jobOrders)
            ->addIndexColumn()
            ->addColumn('quotation_number', function (JobOrder $jobOrder) {
                return $jobOrder->quotations->map(function ($quotation) {
                    return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $quotation->number . '</span>';
                })->implode("");
            })
            ->rawColumns(['quotation_number'])
            ->make(true);
        // $jobOrders = JobOrder::with(['customer'])->select('job_orders.*');
        // return DataTables::of($jobOrders)
        //     ->addIndexColumn()
        //     ->make(true);
    }

    public function spkSheet(Request $request)
    {
        return Excel::download(new SpkExport($request->all()), 'Laporan Job Order Detail.xlsx');
    }

    // SPK -----------------

    public function deliveryOrder()
    {
        $customers = Customer::all();

        return view('report.delivery-order', [
            'customers' => $customers,
        ]);
    }

    public function deliveryOrderData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $customer = $request->query('customer');
        $sortBy = $request->query('sort_by');
        $sortIn = $request->query('sort_in');

        $query = DeliveryOrder::with(['quotations', 'salesOrder', 'customer'])->select('delivery_orders.*')->whereBetween('date', [$startDate, $endDate]);

        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $deliveryOrders = $query->get();

        return DataTables::of($deliveryOrders)
            ->addIndexColumn()
            ->addColumn('quotation_number', function (DeliveryOrder $deliveryOrder) {
                return $deliveryOrder->quotations->map(function ($quotation) {
                    return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $quotation->number . '</span>';
                })->implode("");
            })
            ->rawColumns(['quotation_number'])
            ->make(true);
    }

    public function deliveryOrderSheet(Request $request)
    {
        return Excel::download(new DeliveryOrderExport($request->all()), 'Laporan Delivery Order Detail.xlsx');
    }

    // Invoice -----------------

    public function invoice()
    {
        $customers = Customer::all();

        return view('report.invoice', [
            'customers' => $customers,
        ]);
    }

    public function invoiceData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $customer = $request->query('customer');
        $sortBy = $request->query('sort_by');
        $sortIn = $request->query('sort_in');

        $query = Invoice::with(['quotations', 'salesOrder', 'customer', 'transactions'])->select('invoices.*')->whereBetween('date', [$startDate, $endDate]);

        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $invoices = $query->get();


        return DataTables::of($invoices)
            ->addIndexColumn()
            ->addColumn('quotation_number', function (Invoice $invoice) {
                return $invoice->quotations->map(function ($quotation) {
                    return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $quotation->number . '</span>';
                })->implode("");
            })
            ->rawColumns(['quotation_number'])
            ->make(true);
    }

    public function invoiceSheet(Request $request)
    {
        return Excel::download(new InvoiceExport($request->all()), 'Laporan Faktur Detail.xlsx');
    }

    // Transaction -----------------

    public function transaction()
    {
        $customers = Customer::all();

        return view('report.transaction', [
            'customers' => $customers,
        ]);
    }

    public function transactionData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $customer = $request->query('customer');
        $sortBy = $request->query('sort_by');
        $sortIn = $request->query('sort_in');

        $query = Transaction::with(['customer', 'invoices'])->select('transactions.*')->whereBetween('date', [$startDate, $endDate]);

        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $transactions = $query->get();

        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('invoice_number', function (Transaction $transaction) {
                return $transaction->invoices->map(function ($invoice) {
                    return '<span class="label label-light-info label-pill label-inline text-capitalize">' . $invoice->number . '</span>';
                })->implode("");
            })
            ->rawColumns(['invoice_number'])
            ->make(true);
    }

    public function transactionSheet(Request $request)
    {
        return Excel::download(new TransactionExport($request->all()), 'Laporan Transaksi Detail.xlsx');
    }
}
