<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->number }}</title>
    <style>
        body {
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

        .table-footer th,
        .table-footer td {
            padding: 3px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div style="width: 50%; float: left;">
            <img src="https://karir-production.nos.jkt-1.neo.id/logos/11/1029111/unilabel_magenta.png" alt="Logo" width="150" height="60">
            <div style="margin-top: 10px">
                <span>PT. Magenta Mediatama</span><br>
                <span>Jl. Raya Kebayoran Lama No. 15 RT.04 RW.03 Grogol Utara,</span><br>
                <span>Kebayoran Lama, Jakarta Selatan DKI Jakarta-12210</span><br>
                <span>Phone (021)53660077 - 88; Fax (021)5366099</span>
            </div>
            <div style="margin-top: 30px;">
                <table>
                    <tr>
                        <td>Tagihan Ke</td>
                        <td style="white-space: pre; width: 200px;">Wirasindo</td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="width: 36.5%; float: right">
            <h1 style="text-align:right">Faktur Penjualan</h1>
            <table class="table-header" style="margin-right:0px; margin-left: auto">
                <tr>
                    <td>No. Faktur</td>
                    <td>:</td>
                    <td><?= $invoice->number ?></td>
                </tr>
                <tr>
                    <td>No. Seri Faktur Pajak</td>
                    <td>:</td>
                    <td><?= $invoice->tax_invoice_series ?></td>
                </tr>
                <tr>
                    <td>Tanggal Faktur</td>
                    <td>:</td>
                    <td><?= $invoice->date ?></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td>NPWP</td>
                    <td>:</td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>Syarat Pembelian</td>
                    <td>:</td>
                    <td><?= $invoice->terms_of_payment ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div style="margin-top: 10px; clear: both">
        <table class="bordered-table" style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 30px">No.</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->quotations as $quotation)
                <tr>
                    <td style="text-align:center">1</td>
                    <td><?= $quotation->description ?></td>
                    <td style="text-align:center"><?= number_format($quotation->quantity, 0, '', '.') . ' pcs' ?></td>
                    <td style="text-align: right;"><?= number_format($quotation->price_per_unit, 0, '', '.') ?></td>
                    <td style="text-align: right;"><?= number_format($quotation->total_bill, 0, '', '.') ?></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: none; width: 100px;" colspan="3">
                        <span>Terbilang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="text-transform: capitalize;"># <?= $invoice->terbilang ?> #</span>
                    </td>
                    <td>Netto</td>
                    <td style="text-align: right;"><?= number_format($invoice->netto, 0, '', '.') ?></td>
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
                        <td style="text-align: right;"><?= number_format($invoice->pph, 0, '', '.') ?></td>
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
                    <td>Nama Account</td>
                    <td>:</td>
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
                        PT. Magenta Mediatama
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px 0">&nbsp;</td>
                </tr>
                <tr>
                    <td>Yo Tinco</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>