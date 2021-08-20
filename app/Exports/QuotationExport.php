<?php

namespace App\Exports;

use App\Models\Quotation;
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

class QuotationExport implements FromView, ShouldAutoSize
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
            'id' => 'up',
            'text' => 'Up'
        ],
        [
            'id' => 'title',
            'text' => 'Title'
        ],
        [
            'id' => 'quantity',
            'text' => 'Quantity'
        ],
        [
            'id' => 'price_per_unit',
            'text' => 'Price / Unit'
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
            'id' => 'total_bill',
            'text' => 'Total Piutang'
        ],
        [
            'id' => 'produced',
            'text' => 'Diproduksi'
        ],
        [
            'id' => 'shipped',
            'text' => 'Dikirim'
        ],
        [
            'id' => 'paid',
            'text' => 'Dibayar'
        ],
    ];

    public function __construct($request)
    {
        $this->request = $request;
    }


    /**
     * @return \Illuminate\Support\Query
     */
    // public function query()
    // {
    //     $startDate = $this->request['start_date'];
    //     $endDate = $this->request['end_date'];
    //     // $status = $this->request['status'];
    //     $customer = $this->request['customer'];
    //     $sortBy = $this->request['sort_by'];
    //     $sortIn = $this->request['sort_in'];
    //     $query = Quotation::query()->whereBetween('date', [$startDate, $endDate]);

    //     // if ($status !== '' && $status !== null) {
    //     //     $query->where('status', $status);
    //     // }

    //     if ($customer !== '' && $customer !== null) {
    //         $query->where('customer_id', $customer);
    //     }

    //     if ($sortBy !== '' && $sortBy !== null) {
    //         $query->orderBy($sortBy, $sortIn);
    //     }

    //     return $query;
    // }
    public function view(): View
    {
        $columnSelections = explode(',', $this->request['columns']);
        $startDate = $this->request['start_date'];
        $endDate = $this->request['end_date'];
        $customer = $this->request['customer'];
        $sortBy = $this->request['sort_by'];
        $sortIn = $this->request['sort_in'];
        $query = Quotation::query()->with(['customer', 'picPo'])->whereBetween('date', [$startDate, $endDate]);
        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $quotations = $query->get();

        return view('report.sheet.quotation', [
            'quotations' => $quotations,
            'column_selections' => $columnSelections,
            'all_columns' => $this->allColumns,
        ]);
    }

    // public function map($quotation): array
    // {
    //     // return [
    //     //     $quotation['date'],
    //     //     $quotation['number'],
    //     //     $this->request['start_date'],
    //     // ];
    //     return $this->defineColumns($quotation);
    // }

    // public function headings(): array
    // {
    //     return [
    //         ['Metaprint'],
    //         ['Laporan Quotation Tanggal ' . $this->request['start_date'] . ' - ' . $this->request['end_date']],
    //         $this->defineHeadings(),
    //     ];
    // }

    // public function bindValue(Cell $cell, $value)
    // {
    //     if (is_numeric($value)) {
    //         $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

    //         return true;
    //     }

    //     // else return default behavior
    //     return parent::bindValue($cell, $value);
    // }

    // private function defineColumns($quotation)
    // {
    //     $columnSelections = explode(',', $this->request['columns']);
    //     $columns = [];

    //     foreach ($this->allColumns as $column) {
    //         if ($column['id'] !== 'customer') {
    //             if (in_array($column['id'], $columnSelections)) {
    //                 array_push($columns, $quotation->{$column['id']});
    //             }
    //         } else {
    //             if (in_array($column['id'], $columnSelections)) {
    //                 array_push($columns, $quotation->customer->name);
    //             }
    //         }
    //     }

    //     return $columns;
    // }

    // private function defineHeadings()
    // {
    //     $columnSelections = explode(',', $this->request['columns']);
    //     $headings = [];

    //     foreach ($this->allColumns as $column) {
    //         if (in_array($column['id'], $columnSelections)) {
    //             array_push($headings, $column['text']);
    //         }
    //     }

    //     return $headings;
    // }
}
