<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOB ORDER {{ $job_order->number }}</title>
    <style>
        body {
            font-size: 11px;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        .w-100 {
            width: 100%;
        }

        .w-70 {
            width: 68%;
        }

        .w-50 {
            width: 50%;
        }

        .w-30 {
            width: 30%;
        }

        .w-33 {
            width: 33%;
        }

        .table {
            border-collapse: collapse;
        }

        .table tr td {
            padding: 3px;
        }

        .table-bordered tr td {
            border: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right;
        }

        .text-underline {
            text-decoration: underline;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .row-center td {
            text-align: center;
        }

        .row-bold td {
            font-weight: bold;
        }

        .mock-checkbox-group {
            display: inline-block;
            margin-left: 10px;
        }

        .mock-checkbox {
            display: inline-block;
            padding: 10px;
            border: 1px solid #000;
        }

        .mock-checkbox.checked {
            background-color: #000;
        }

        .float-right {
            float: right;
        }

        .float-left {
            float: left;
        }

        .clear-both {
            clear: both;
        }
    </style>
</head>

<body>
    <div>
        <p class="text-right">JOB ORDER # <strong>{{ $job_order->number }}</strong></p>
        <p class="text-right">Estimated # <strong>{{ $job_order->estimation_number }}</strong></p>
    </div>
    <table class="w-100 table table-bordered">
        <tr class="row-center">
            <td>Tanggal</td>
            <td>PO / SO #</td>
            <td>Customer</td>
            <td>Jenis Pesanan</td>
            <td>Jumlah Pesanan</td>
            <td>Designer</td>
            <td>Tanggal Kirim</td>
        </tr>
        <tr class="row-center">
            <td rowspan="2">{{ $job_order->date }}</td>
            @if($job_order->v2SalesOrder !== null)
            <td>SO # {{ $job_order->v2SalesOrder->number }}</td>
            @else
            <td></td>
            @endif
            <td rowspan="2">
                @if($job_order->customer !== null)
                <span>{{ $job_order->customer->name }}</span>
                @endif
            </td>
            <td class="text-left">{{ $job_order->title }}</td>
            <td rowspan="2">{{ $job_order->order_amount }} PCS</td>
            <td rowspan="2">{{ $job_order->designer }}</td>
            <td>{{ $job_order->delivery_date }}</td>
        </tr>
        <tr>
            @if($job_order->v2SalesOrder !== null)
            @if($job_order->v2SalesOrder->source == 'quotation')
            @if($job_order->v2SalesOrder->v2Quotation !== null)
            <td class="text-center">Quotation # {{ $job_order->v2SalesOrder->v2Quotation->number }}</td>
            @else
            <td></td>
            @endif
            @elseif($job_order->v2SalesOrder->source == 'purchase_order')
            @if($job_order->v2SalesOrder->customerPurchaseOrder !== null)
            <td class="text-center">PO # {{ $job_order->v2SalesOrder->customerPurchaseOrder->number }}</td>
            @else
            <td></td>
            @endif
            @else
            <td></td>
            @endif
            @else
            <td></td>
            @endif
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table class="w-100 table table-bordered">
        <tr>
            <?php
            $printTypes = [
                [
                    'value' => 'offset',
                    'text' => 'Offset',
                ],
                [
                    'value' => 'digital',
                    'text' => 'Digital',
                ],
                [
                    'value' => 'indigo',
                    'text' => 'Indigo',
                ],
                [
                    'value' => 'sablon',
                    'text' => 'Sablon',
                ],
            ]
            ?>
            <td>
                <span>Cara Cetak :</span>
                @foreach($printTypes as $type)
                <span class="mock-checkbox-group">
                    <span class="mock-checkbox {{ $type['value'] == $job_order->print_type ? 'checked' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class="mock-checkbox-text">{{ $type['text'] }}</span>
                </span>
                @endforeach
            </td>
            <td>
                <?php
                $dummies = [
                    [
                        'value' => 'warna',
                        'text' => 'Warna',
                    ],
                    [
                        'value' => 'bw',
                        'text' => 'BW',
                    ],
                ]
                ?>
                <span>Dummy : </span>
                @foreach($dummies as $dummy)
                <span class="mock-checkbox-group">
                    <span class="mock-checkbox {{ $dummy['value'] == $job_order->dummy ? 'checked' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class="mock-checkbox-text">{{ $dummy['text'] }}</span>
                </span>
                @endforeach
            </td>
            <td>
                <?php
                $okls = [
                    [
                        'value' => '0',
                        'text' => 'Tidak',
                    ],
                    [
                        'value' => '1',
                        'text' => 'Ya',
                    ],
                ]
                ?>
                <span>OKL : </span>
                @foreach($okls as $okl)
                <span class="mock-checkbox-group">
                    <span class="mock-checkbox {{ $okl['value'] == $job_order->okl ? 'checked' : '' }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class="mock-checkbox-text">{{ $okl['text'] }}</span>
                </span>
                @endforeach
                <span>Ke: {{ $job_order->okl_nth }}</span>
            </td>
        </tr>
    </table>
    <table class="w-100 table table-bordered">
        <tr class="row-center">
            <td rowspan="2">Item</td>
            <td rowspan="2">Paper</td>
            <td colspan="2">Plano</td>
            <td colspan="2">Ukuran Potong</td>
            <td colspan="2">Jumlah</td>
            <td rowspan="2">Warna</td>
            <td colspan="2">Film / CTP</td>
            <td rowspan="2">Tipe Cetak</td>
        </tr>
        <tr class="row-center">
            <td>Ukuran</td>
            <td>Jumlah</td>
            <td>Ukuran</td>
            <td>Jumlah</td>
            <td>Pesanan</td>
            <td>Cetakan</td>
            <td>Set</td>
            <td>Total</td>
        </tr>
        @foreach($job_order->items as $item)
        <tr class="row-bold">
            <td style="width: 20%;">{{ $item->item }}</td>
            <td style="width: 10%;">{{ $item->paper }}</td>
            <td style="width: 10%;" class="text-center">{{ $item->plano_size }}</td>
            <td style="width: 5%;" class="text-right">{{ $item->plano_amount }}</td>
            <td style="width: 10%;" class="text-center">{{ $item->cutting_size }}</td>
            <td style="width: 5%;" class="text-right">{{ $item->cutting_amount }}</td>
            <td style="width: 10%;">{{ $item->order_amount }}</td>
            <td style="width: 10%;">{{ $item->print_amount }}</td>
            <td style="width: 5%;" class="text-center">{{ $item->color }}</td>
            <td style="width: 5%;" class="text-center">{{ $item->film_set }}</td>
            <td style="width: 5%;" class="text-center">{{ $item->film_total }}</td>
            <td style="width: 5%;" class="text-center text-uppercase">{{ $item->print_type }}</td>
        </tr>
        @endforeach
    </table>
    <div style="margin-top: 5px;">
        <div class="w-70 float-left">
            <p><strong>FINISHING</strong></p>
            @foreach($finishing_items as $category => $items)
            <div style="margin-bottom: 10px">
                <strong>{{ $category }}</strong>
                <ul class="w-100" style="margin: 0;">
                    @foreach($items as $item)
                    <li class="w-33 float-left" style="margin: 2px 0;">
                        <span>{{ $item->name }}</span>
                        @if($item->pivot->description !== null)
                        <span class="text-underline text-uppercase">{{ $item->pivot->description }}</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        <div class="w-30 float-left">
            <p><strong>CUTTING POLA :</strong></p>
        </div>
    </div>
    <div class="clear-both" style="margin-top: 30px;">
        <table class="table table-bordered w-100">
            <tr>
                <td class="text-center">Disiapkan Oleh</td>
                <td class="text-center">Diperiksa Oleh</td>
                <td class="text-center">Ka. Produksi</td>
                <td class="text-center">Ka. Finishing</td>
                <td class="text-center">Gudang</td>
            </tr>
            <tr>
                <td class="text-center" style="padding-top: 20px;">{{ $job_order->preparer }}</td>
                <td class="text-center" style="padding-top: 20px;">{{ $job_order->examiner }}</td>
                <td class="text-center" style="padding-top: 20px;">{{ $job_order->production }}</td>
                <td class="text-center" style="padding-top: 20px;">{{ $job_order->finishing }}</td>
                <td class="text-center" style="padding-top: 20px;">{{ $job_order->warehouse }}</td>
            </tr>
        </table>
    </div>
</body>

</html>