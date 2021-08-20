<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
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
    </style>
</head>

<body>
    <div class="header" style="float: left; margin-bottom: 100px;">
        <div style="width: 50%; float: left;">
            <img src="https://karir-production.nos.jkt-1.neo.id/logos/11/1029111/unilabel_magenta.png" alt="Logo" width="150" height="60">
            <div style="margin-top: 10px">
                <span style="display: block;">{{ $company->name }}</span>
                <span style="display: block;">{{ $company->address }}</span>
                <span style="display: block;">Phone {{ $company->phone }}; Fax {{ $company->fax }}</span>
            </div>
            <div style="margin-top: 20px;">
                <table>
                    <tr>
                        <td style="vertical-align: top;">Tagihan Ke</td>
                        <td style="padding-left: 8px; vertical-align: top;">
                            <span style="display: block;">{{ $invoice->customer->name }}</span>
                            <span>{{ $invoice->customer->address }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="width: 36.5%; float: right; margin-bottom: 100px;">
            <h1 style="text-align:right">Faktur Penjualan</h1>
            <table class="table-header" style="margin-right:0px; margin-left: auto">
                <tr>
                    <td>No. Faktur</td>
                    <td>:</td>
                    <td><?= $invoice->number ?></td>
                </tr>
                <tr>
                    <td>No. Faktur Pajak</td>
                    <td>:</td>
                    <td><?= $invoice->tax_invoice_series ?></td>
                </tr>
                <tr>
                    <td>Tanggal Faktur</td>
                    <td>:</td>
                    <td><?= $invoice->date ?></td>
                </tr>
                <tr>
                    <td>NPWP</td>
                    <td>:</td>
                    <td><?= $invoice->customer->npwp ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="padding: 0;">&nbsp;</td>
                </tr>
                <tr>
                    <td>PO Number</td>
                    <td>:</td>
                    <td><?= $invoice->salesOrder->po_number ?></td>
                </tr>
                <tr>
                    <td>GR Number</td>
                    <td>:</td>
                    <td><?= $invoice->gr_number ?></td>
                </tr>
                <tr>
                    <td>Syarat Pembelian</td>
                    <td>:</td>
                    <td><?= $invoice->terms_of_payment ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div style="margin-top: 60px; clear: both">
        <table class="bordered-table" style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 30px">No.</th>
                    <th>Item</th>
                    <th>Kts</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->quotations as $quotation)
                <tr>
                    <td style="text-align:center">1</td>
                    <td><?= $quotation->description ?></td>
                    <td style="text-align:center"><?= number_format($quotation->quantity, 0, '', '.') . ' pcs' ?></td>
                    <td style="text-align: right;"><?= number_format($quotation->price_per_unit, 0, '', '.') ?></td>
                    <td style="text-align: right;"><?= number_format($quotation->quantity * $quotation->price_per_unit, 0, '', '.') ?></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: none; width: 100px;" colspan="3">
                        <span>Terbilang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="text-transform: capitalize;"><?= $invoice->terbilang ?></span>
                    </td>
                    <td>Total Sub</td>
                    <td style="text-align: right;"><?= number_format($invoice->netto, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="3"></td>
                    <td>Diskon</td>
                    <td style="text-align: right;"><?= number_format($invoice->discount, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="3"></td>
                    <td>PPN</td>
                    <td style="text-align: right;"><?= number_format($invoice->ppn, 0, '', '.') ?></td>
                </tr>
                <?php if ($invoice->pph > 0) : ?>
                    <tr>
                        <td style="border: none;" colspan="3"></td>
                        <td>PPH 23</td>
                        <td style="text-align: right;">(<?= number_format($invoice->pph, 0, '', '.') ?>)</td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td style="border: none;" colspan="3"></td>
                    <td>Total Faktur</td>
                    <td style="text-align: right;"><?= number_format($invoice->total, 0, '', '.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- <p>Terbilang: Dua Puluh Ribu Rupiah</p> -->
    <div class="footer" style=" margin-top: 30px">
        <div style="width: 50%; float: left">
            <table class="table-footer">
                <tr>
                    <td colspan="3">Pembayaran dapat ditransfer ke rekening:</td>
                </tr>
                <tr>
                    <td style="width: 80px;">Nama Account</td>
                    <td style="width: 5px;">:</td>
                    <td>PT. Magenta Mediatama</td>
                </tr>
                <tr>
                    <td>Nama Bank</td>
                    <td>:</td>
                    <td>BCA KCP Mangga Dua ITC</td>
                </tr>
                <tr>
                    <td>Alamat Bank</td>
                    <td>:</td>
                    <td>Jl. Mangga Dua Raya, Kom. ITC Mangga Dua Lt.IV JKT</td>
                </tr>
                <tr>
                    <td>Account Number</td>
                    <td>:</td>
                    <td>4801789999</td>
                </tr>
            </table>
        </div>
        <div style="width: 50%; float: right">
            <table style="text-align: center; margin-right:30px; margin-left: auto">
                <tr>
                    <td>
                        Hormat Kami,<br>
                        {{ $company->name }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px 0">&nbsp;</td>
                </tr>
                <tr>
                    <td>{{ $company->head }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>