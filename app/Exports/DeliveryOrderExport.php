<?php

namespace App\Exports;

use App\Models\DeliveryOrder;
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

class DeliveryOrderExport implements FromView, ShouldAutoSize
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
            'id' => 'warehouse',
            'text' => 'Gudang'
        ],
        [
            'id' => 'shipper',
            'text' => 'Pengirim'
        ],
        [
            'id' => 'number_of_vehicle',
            'text' => 'Nomor Kendaraan'
        ],
        [
            'id' => 'billing_address',
            'text' => 'Alamat Penagihan'
        ],
        [
            'id' => 'shipping_address',
            'text' => 'Alamat Pengiriman'
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
            'id' => 'total_shipping',
            'text' => 'Total Kirim'
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
        $query = DeliveryOrder::query()->with(['customer', 'quotations', 'salesOrder'])->whereBetween('date', [$startDate, $endDate]);
        if ($customer !== '' && $customer !== null) {
            $query->where('customer_id', $customer);
        }

        if ($sortBy !== '' && $sortBy !== null) {
            $query->orderBy($sortBy, $sortIn);
        }

        $deliveryOrders = $query->get();

        return view('report.sheet.delivery-order', [
            'delivery_orders' => $deliveryOrders,
            'column_selections' => $columnSelections,
            'all_columns' => $this->allColumns,
        ]);
    }
}
