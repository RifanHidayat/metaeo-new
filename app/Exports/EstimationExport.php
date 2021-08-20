<?php

namespace App\Exports;

use App\Models\Estimation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EstimationExport extends DefaultValueBinder implements WithCustomValueBinder, FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
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
            'id' => 'work',
            'text' => 'Pekerjaan',
        ],
        [
            'id' => 'quantity',
            'text' => 'Quantity',
        ],
        [
            'id' => 'production',
            'text' => 'Production',
        ],
        [
            'id' => 'hpp',
            'text' => 'HPP',
        ],
        [
            'id' => 'hpp_per_unit',
            'text' => 'HPP / Unit',
        ],
        [
            'id' => 'price_per_unit',
            'text' => 'Price / Unit',
        ],
        [
            'id' => 'margin',
            'text' => 'Margin',
        ],
        [
            'id' => 'total_price',
            'text' => 'Total Price',
        ],
        [
            'id' => 'ppn',
            'text' => 'PPN',
        ],
        [
            'id' => 'pph',
            'text' => 'PPH',
        ],
        [
            'id' => 'total_bill',
            'text' => 'Total Piutang',
        ],
        [
            'id' => 'delivery_date',
            'text' => 'Tanggal Kirim',
        ],
        [
            'id' => 'status',
            'text' => 'Status',
        ],
    ];

    public function __construct($request)
    {
        $this->request = $request;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $startDate = $this->request['start_date'];
        $endDate = $this->request['end_date'];
        $status = $this->request['status'];
        $customer = $this->request['customer'];
        $sortBy = $this->request['sort_by'];
        $sortIn = $this->request['sort_in'];
        $query = Estimation::query()->whereBetween('date', [$startDate, $endDate]);

        if ($status !== '' && $status !== null) {
            $query->where('status', $status);
        }

        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        return $query;
    }

    public function map($estimation): array
    {
        // return [
        //     $estimation['date'],
        //     $estimation['number'],
        //     $this->request['start_date'],
        // ];
        return $this->defineColumns($estimation);
    }

    public function headings(): array
    {
        return [
            ['Metaprint'],
            ['Laporan Estimasi Tanggal ' . $this->request['start_date'] . ' - ' . $this->request['end_date']],
            $this->defineHeadings(),
        ];
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'E' => '#,##0.00_-',
    //         'F' => '#,##0.00_-',
    //         'G' => '#,##0.00_-',
    //         'H' => '#,##0.00_-',
    //         'I' => '#,##0.00_-',
    //         'J' => '#,##0.00_-',
    //         'K' => '#,##0.00_-',
    //         'L' => '#,##0.00_-',
    //         'M' => '#,##0.00_-',
    //         'N' => '#,##0.00_-',
    //         'O' => '#,##0.00_-',
    //         'P' => '#,##0.00_-',
    //         'Q' => '#,##0.00_-',
    //         // 'R' => '#,##0.00_-',
    //         'S' => '#,##0.00_-',
    //         'T' => '#,##0.00_-',
    //         'U' => '#,##0.00_-',
    //         'W' => '#,##0.00_-',
    //         'X' => '#,##0.00_-',
    //         'Y' => '#,##0.00_-',
    //     ];
    // }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    private function defineColumns($estimation)
    {
        $columnSelections = explode(',', $this->request['columns']);
        $columns = [];

        foreach ($this->allColumns as $column) {
            if ($column['id'] !== 'customer') {
                if (in_array($column['id'], $columnSelections)) {
                    array_push($columns, $estimation->{$column['id']});
                }
            } else {
                if (in_array($column['id'], $columnSelections)) {
                    array_push($columns, $estimation->customer->name);
                }
            }
        }

        return $columns;
    }

    private function defineHeadings()
    {
        $columnSelections = explode(',', $this->request['columns']);
        $headings = [];

        foreach ($this->allColumns as $column) {
            if (in_array($column['id'], $columnSelections)) {
                array_push($headings, $column['text']);
            }
        }

        return $headings;
    }
}
