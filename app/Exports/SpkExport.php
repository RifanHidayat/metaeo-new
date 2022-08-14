<?php

namespace App\Exports;

use App\Models\JobOrder;
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

class SpkExport implements FromView, ShouldAutoSize
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
            'id' => 'customer',
            'text' => 'Customer'
        ],
        [
            'id' => 'finish_date',
            'text' => 'Tanggal Finish'
        ],
        [
            'id' => 'delivery_date',
            'text' => 'Tanggal Kirim'
        ],
        [
            'id' => 'designer',
            'text' => 'Desainer'
        ],
        [
            'id' => 'preparer',
            'text' => 'Penyiap'
        ],
        [
            'id' => 'examiner',
            'text' => 'Pemeriksa'
        ],
        [
            'id' => 'production',
            'text' => 'Produksi'
        ],
        [
            'id' => 'finishing',
            'text' => 'Finishing'
        ],
        [
            'id' => 'warehouse',
            'text' => 'Gudang'
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
            'id' => 'total_production',
            'text' => 'Total Produksi'
        ],
    ];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        // $allColumns = json_decode($this->request['all_columns']);
        $columnSelections = explode(',', $this->request['columns']);
        $startDate = $this->request['start_date'];
        $endDate = $this->request['end_date'];
        $customer = $this->request['customer'];
        $sortBy = $this->request['sort_by'];
        $sortIn = $this->request['sort_in'];
        $query = JobOrder::query()->with(['customer', 'quotations', 'salesOrder'])->whereBetween('date', [$startDate, $endDate]);
        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $jobOrders = $query->get();

        return view('report.sheet.spk', [
            'job_orders' => $jobOrders,
            'column_selections' => $columnSelections,
            'all_columns' => $this->allColumns,
        ]);
    }
}
