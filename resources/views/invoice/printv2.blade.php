<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->number }}</title>
    <style>
        @page {
            margin: 20px;
            /* padding: 0px 0px 0px 0px !important; */
        }

        body {
            font-size: 10px;
            font-family: sans-serif;
        }

        table {
            border-collapse: collapse;
        }

        .table-header th,
        .table-header td {
            padding: 1px;
        }

        .bordered-table th,
        .bordered-table td {
            border: 1px solid #000;
            padding: 1px;
        }
    </style>
</head>

<body>
    <div class="header" style="float: left; margin-bottom: 100px;">
        <div style="width: 50%; float: left;">
            <img src="{{ $company->logo !== null ? Storage::disk('s3')->url($company->logo) : '' }}" alt="Logo" height="35">
            <div style="margin-top: 5px">
                <span style="display: block;">{{ $company->name }}</span>
                <span style="display: block;">{{ $company->address }}</span>
                <span style="display: block;">Phone {{ $company->phone }}; Fax {{ $company->fax }}</span>
            </div>
            <div style="margin-top: 10px;">
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
            <h1 style="text-align:right; margin: 0px;">Faktur Penjualan</h1>
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
    <div style="margin-top: 10px; clear: both">
        <table class="bordered-table" style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 30px">No.</th>
                    <th>Kode Barang</th>
                    <th>Deskripsi Barang</th>
                    <th>Keterangan</th>
                    <th>Kts</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $subTotal = 0; ?>
                @foreach($invoice->quotations as $quotation)
                @foreach($quotation->deliveryOrders as $do)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td><?= $do->pivot->code ?></td>
                    <td><?= $do->pivot->description ?></td>
                    <td><?= $do->pivot->information ?></td>
                    <td style="text-align: center;"><?= number_format($do->pivot->amount, 0, '', '.') ?> <?= $do->pivot->unit ?></td>
                    <?php
                    $pricePerUnit = ($quotation->selectedEstimation == null) ? $quotation->price_per_unit : $quotation->selectedEstimation->price_per_unit;
                    ?>
                    <td style="text-align: right;"><?= number_format($pricePerUnit, 0, '', '.') ?></td>
                    <?php $amount = $do->pivot->amount * $pricePerUnit; ?>
                    <td style="text-align: right;"><?= number_format($amount, 0, '', '.') ?></td>
                </tr>
                <?php $subTotal += $amount ?>
                @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: none; width: 100px;" colspan="5">
                        <span>Terbilang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="text-transform: capitalize;"><?= $invoice->terbilang ?></span>
                    </td>
                    <td style="text-align: right;">Total Sub :</td>
                    <td style="text-align: right;"><?= number_format($subTotal, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="5"></td>
                    <td style="text-align: right;">Diskon :</td>
                    <td style="text-align: right;"><?= number_format($invoice->discount, 0, '', '.') ?></td>
                </tr>
                <?php $ppn = ($subTotal - $invoice->discount) * 0.10; ?>
                <tr>
                    <td style="border: none;" colspan="5"></td>
                    <td style="text-align: right;">PPN :</td>
                    <td style="text-align: right;"><?= number_format($ppn, 0, '', '.') ?></td>
                </tr>
                <?php
                $pph = 0;
                if ($invoice->customer->with_pph == 1) {
                    $pph = ($subTotal - $invoice->discount) * 0.02;
                }
                ?>
                <?php if ($pph > 0) : ?>
                    <tr>
                        <td style="border: none;" colspan="5"></td>
                        <td style="text-align: right;">PPH 23 :</td>
                        <td style="text-align: right;">(<?= number_format($pph, 0, '', '.') ?>)</td>
                    </tr>
                <?php endif; ?>
                <?php
                $total = $subTotal - $invoice->discount + $ppn - $pph;
                ?>
                <tr>
                    <td style="border: none;" colspan="5"></td>
                    <td style="text-align: right;">Total Faktur :</td>
                    <td style="text-align: right;"><?= number_format($total, 0, '', '.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- <p>Terbilang: Dua Puluh Ribu Rupiah</p> -->
    <div class="footer" style=" margin-top: 5px">
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
                    <td style="padding: 30px 0">&nbsp;</td>
                </tr>
                <tr>
                    <td>{{ $company->head }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>