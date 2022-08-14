<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $delivery_order->number }}</title>
    <style>
        body {
            font-size: 10px;
            font-family: sans-serif;
        }

        table {
            border-collapse: collapse;
        }

        .bordered-table th,
        .bordered-table td {
            border: 1px solid #000;
            padding: 3px;
        }

        .table-header {
            width: 180px;
            text-align: center;
        }

        .footer ul {
            list-style: none;
        }

        .footer ul li {
            width: 60px;
            float: right;
            margin: 0 15px;
        }

        .footer ul li p {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 50px;
        }
    </style>
</head>

<body>
    <div class="header" style="clear: both; margin-bottom: 10px;">
        <div style="width: 50%; float: left; clear: both">
            <img src="{{ $company->logo !== null ? Storage::disk('s3')->url($company->logo) : '' }}" alt="Logo" height="40">
            <div style="margin-top: 10px">
                <span style="display: block;">{{ $company->name }}</span>
                <span style="display: block;">{{ $company->address }}</span>
                <span style="display: block;">Phone {{ $company->phone }}; Fax {{ $company->fax }}</span>
            </div>
        </div>
        <div style="width: 36.5%; float: right">
            <div style="width: 200px; margin: 0 auto; text-align: center;">
                <span style="font-size: 20px; text-align: center"><strong style="border-bottom: 1px solid #000;">Kirim Pesanan</strong></span>
            </div>
            <div>
                <table style="margin: 0 auto; margin-top: 10px;">
                    <tr>
                        <td style="padding: 3px">Delivery Order No</td>
                        <td style="padding: 3px">:</td>
                        <td style="padding: 3px"><?= $delivery_order->number ?></td>
                    </tr>

                    <tr>
                        <td style="padding: 3px">Tanggal Pengiriman</td>
                        <td style="padding: 3px">:</td>
                        <td style="padding: 3px"><?= date_format(date_create($delivery_order->date), "d-m-Y") ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px">Pengirim</td>
                        <td style="padding: 3px">:</td>
                        <td style="padding: 3px"><?= $delivery_order->shipper ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px">Gudang</td>
                        <td style="padding: 3px">:</td>
                        <td style="padding: 3px"><?= $delivery_order->warehouse ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px">PO No.</td>
                        <td style="padding: 3px">:</td>
                        <td style="padding: 3px"><?= $delivery_order->salesOrder->po_number ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div style="margin-top: 10px; clear: both" style="width: 100%;">
        <!-- <div style="float: left; width: 45%;"> -->
        <div style="width: 100%;">
            <table class="bordered-table" style="float: left; width: 45%; margin-top: 5px;">
                <tr>
                    <th>Tagihan Ke</th>
                </tr>
                <tr>
                    <td><?= $delivery_order->billing_address ?></td>
                </tr>
            </table>
            <!-- </div> -->
            <!-- <div style="float: right; width: 45%; margin-left: 20px;"> -->
            <table class="bordered-table" style="float: right; width: 45%; position:absolute; right: 0;">
                <tr>
                    <th>Kirim Ke</th>
                </tr>
                <tr>
                    <td><?= $delivery_order->shipping_address ?></td>
                </tr>
            </table>
        </div>
        <!-- </div> -->
    </div>
    <div style="width: 100%; height: 5px; clear: both;"></div>
    <div style="clear: both">
        <table class="bordered-table" style="width: 100%">
            <tr>
                <th>No.</th>
                <th>Barang</th>
                <th>Deskripsi Barang</th>
                <th>Keterangan</th>
                <th>Kts</th>
                <th>Satuan</th>
            </tr>
            @foreach($delivery_order->quotations as $quotation)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: center;"><?= $quotation->pivot->code ?></td>
                <td><?= $quotation->pivot->description ?></td>
                <td><?= $quotation->pivot->information ?></td>
                <td style="text-align: center;"><?= number_format($quotation->pivot->amount, 0, '', '.') ?></td>
                <td style="text-align: center;"><?= $quotation->pivot->unit ?></td>
            </tr>
            @endforeach
        </table>
    </div>
    <p style="margin-bottom: 0px"><strong><em>Barang diterima dalam keadaan baik dan cukup</em></strong></p>
    <div class="footer">
        <ul>
            <li>
                <p>Received By</p>
            </li>
            <li>
                <p>Shipped By</p>
            </li>
            <li>
                <p>Approved By</p>
            </li>
            <li>
                <p>Prepared By</p>
            </li>
        </ul>
    </div>
</body>

</html>