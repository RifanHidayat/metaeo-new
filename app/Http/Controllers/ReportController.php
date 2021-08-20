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

    public function estimationData()
    {
        $estimations = Estimation::with(['customer'])->select('estimations.*');
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

    public function quotationData()
    {
        $quotations = Quotation::with(['customer'])->select('quotations.*');
        return DataTables::of($quotations)
            ->addIndexColumn()
            ->make(true);
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

    public function salesOrderData()
    {
        $salesOrders = SalesOrder::with(['customer'])->select('sales_orders.*');
        return DataTables::of($salesOrders)
            ->addIndexColumn()
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

    public function spkData()
    {
        $jobOrders = JobOrder::with(['customer'])->select('job_orders.*');
        return DataTables::of($jobOrders)
            ->addIndexColumn()
            ->make(true);
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

    public function deliveryOrderData()
    {
        $deliveryOrders = DeliveryOrder::with(['customer'])->select('job_orders.*');
        return DataTables::of($deliveryOrders)
            ->addIndexColumn()
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

    public function invoiceData()
    {
        $invoices = Invoice::with(['customer'])->select('invoices.*');
        return DataTables::of($invoices)
            ->addIndexColumn()
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

    public function transactionData()
    {
        $transactions = Transaction::with(['customer'])->select('transaction.*');
        return DataTables::of($transactions)
            ->addIndexColumn()
            ->make(true);
    }

    public function transactionSheet(Request $request)
    {
        return Excel::download(new TransactionExport($request->all()), 'Laporan Transaksi Detail.xlsx');
    }
}
