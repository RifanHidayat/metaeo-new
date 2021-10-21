<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $transaction->number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        table {
            border-collapse: collapse;
        }

        .table-header th,
        .table-header td {
            padding: 3px;
        }

        .bordered-table th,
        .bordered-table td {
            border: 1px solid #000;
            padding: 3px;
        }

        .bordered-table tfoot th,
        .bordered-table tfoot td {
            border: none;
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
            margin-bottom: 0;
        }

        .footer ul li span {
            display: block;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <div class="header" style="float: left; margin-bottom: 100px;">
            <div style="width: 50%; float: left;">
                <img src="{{ $company->logo !== null ? Storage::disk('s3')->url($company->logo) : '' }}" alt="Logo" height="35">
                <!-- <div style="margin-top: 10px">
                <span style="display: block;">{{ $company->name }}</span>
                <span style="display: block;">{{ $company->address }}</span>
                <span style="display: block;">Phone {{ $company->phone }}; Fax {{ $company->fax }}</span>
            </div> -->
                <div style="margin-top: 20px;">
                    <table>
                        <tr>
                            <td style="vertical-align: top;">Received</td>
                            <td style="padding-left: 8px; vertical-align: top;">
                                <span style="display: block;">{{ $transaction->customer->name }}</span>
                                <span>{{ $transaction->customer->address }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div style="width: 36.5%; float: right; margin-bottom: 100px;">
                <h1 style="text-align:right">Penerimaan Pelanggan</h1>
                <table class="table-header" style="margin-right:0px; margin-left: auto">
                    <tr>
                        <td>Form No.</td>
                        <td>:</td>
                        <td><?= $transaction->number ?></td>
                    </tr>
                    <tr>
                        <td>Cheque Date</td>
                        <td>:</td>
                        <td><?= $transaction->date ?></td>
                    </tr>
                    <tr>
                        <td>Cheque No.</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Bank</td>
                        <td>:</td>
                        <td><?= $transaction->account_name ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </header>
    <div style="margin-top: 10px; clear: both">
        <table class="bordered-table" style="width: 100%">
            <thead>
                <tr>
                    <th>Invoice No.</th>
                    <th>Date</th>
                    <th>Due</th>
                    <th>Amount</th>
                    <th>Payment Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->invoices as $invoice)
                <tr>
                    <td style="text-align:center">{{ $invoice->number }}</td>
                    <td style="text-align:center"><?= $invoice->date ?></td>
                    <td style="text-align:center"><?= $invoice->due_date ?></td>
                    <td style="text-align:right"><?= number_format($invoice->total, 0, '', '.') ?></td>
                    <td style="text-align:right"><?= number_format($invoice->pivot->amount, 0, '', '.') ?></td>
                </tr>

                @endforeach
            </tbody>
            <tfoot>
                <td style="text-align: right;" colspan="4">Total Payment:</td>
                <td style="text-align: right;">{{ number_format($total_payment, 0, '', '.') }}</td>
            </tfoot>
        </table>
    </div>
    <!-- <p>Terbilang: Dua Puluh Ribu Rupiah</p> -->
    <p style="text-transform: capitalize;">Say: # {{ $terbilang }}</p>
    <div class="footer">
        <ul>
            <li>
                <p>Received By</p>
                <span>Tanggal</span>
            </li>
            <li>
                <p>Reviewed By</p>
                <span>Tanggal</span>
            </li>
            <li>
                <p>Prepared By</p>
                <span>Tanggal</span>
            </li>
        </ul>
    </div>
</body>

</html>