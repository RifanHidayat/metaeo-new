<?php

namespace App\Exports;

use App\Models\DeliveryOrder;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\SalesOrder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class InvoiceExport implements FromView, ShouldAutoSize
{

    // private $fileName = 'Quotation';

    private $request;
    private $allColumns = [
        [
            'id' => 'number',
            'text' => 'Nomor'
        ],
        [
            'id' => 'date',
            'text' => 'Tanggal'
        ],
        [
            'id' => 'due_date',
            'text' => 'Due Date'
        ],
        [
            'id' => 'customer',
            'text' => 'Customer'
        ],
        [
            'id' => 'gr_number',
            'text' => 'GR Number'
        ],
        [
            'id' => 'tax_invoice_series',
            'text' => 'Seri Faktur Pajak'
        ],
        [
            'id' => 'terms_of_payment',
            'text' => 'Syarat Pembayaran'
        ],
        [
            'id' => 'sales_order',
            'text' => 'Sales Order'
        ],
        [
            'id' => 'quotations',
            'text' => 'Quotation'
        ],
        [
            'id' => 'netto',
            'text' => 'Total Sub'
        ],
        [
            'id' => 'discount',
            'text' => 'Diskon'
        ],
        [
            'id' => 'ppn',
            'text' => 'PPN'
        ],
        [
            'id' => 'pph',
            'text' => 'PPH'
        ],
        [
            'id' => 'total',
            'text' => 'Total'
        ],
    ];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $columnSelections = explode(',', $this->request['columns']);
        $startDate = $this->request['start_date'];
        $endDate = $this->request['end_date'];
        $customer = $this->request['customer'];
        $sortBy = $this->request['sort_by'];
        $sortIn = $this->request['sort_in'];
        $query = Invoice::query()->with(['customer', 'quotations', 'salesOrder'])->whereBetween('date', [$startDate, $endDate]);
        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $invoices = $query->get();

        return view('report.sheet.invoice', [
            'invoices' => $invoices,
            'column_selections' => $columnSelections,
            'all_columns' => $this->allColumns,
        ]);
    }
}
