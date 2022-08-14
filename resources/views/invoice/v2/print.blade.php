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
    <div class="header" style="float: left; margin-bottom: 10;">
        <div style="width: 50%; float: left;">
            <img src="{{ $company->logo !== null ? Storage::disk('s3')->url($company->logo) : '' }}" alt="Logo" height="40">
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
        <div style="width: 36.5%; float: right; margin-bottom: 10px;">
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
                    @if($invoice->v2SalesOrder !== null)
                    @if($invoice->v2SalesOrder->source == 'quotation')
                    @if($invoice->v2SalesOrder->v2Quotation !== null)
                    <td>Quotation # {{ $invoice->v2SalesOrder->v2Quotation->number }}</td>
                    @else
                    <td></td>
                    @endif
                    @elseif($invoice->v2SalesOrder->source == 'purchase_order')
                    @if($invoice->v2SalesOrder->customerPurchaseOrder !== null)
                    <td>PO # {{ $invoice->v2SalesOrder->customerPurchaseOrder->number }}</td>
                    @else
                    <td></td>
                    @endif
                    @else
                    <td></td>
                    @endif
                    @else
                    <td></td>
                    @endif
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

    <!-- beignsales order -->
    
       @if($invoice->sales_order_id!=0)
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
                @foreach($items as $item)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td>{{ $item->pivot->code }}</td>
                    <td style="width: 20%;">{{ $item->pivot->description }}</td>
                    <td style="width: 20%;">{{ $item->pivot->information }}</td>
                    <td style="text-align:center"><?= number_format($item->pivot->amount, 0, '', '.') . ' ' . $item->pivot->unit ?></td>
                    <td style="text-align: right;"><?= number_format($item->price, 0, '', '.') ?></td>
                    <td style="text-align: right;"><?= number_format($item->pivot->amount * $item->price, 0, '', '.') ?></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: none; width: 100px;" colspan="5">
                        <span>Terbilang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="text-transform: capitalize;"><?= $invoice->terbilang ?></span>
                    </td>
                    <td style="text-align: right;">Subtotal :</td>
                    <td style="text-align: right;"><?= number_format($invoice->netto, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="5"></td>
                    <td style="text-align: right;">Diskon :</td>
                    <td style="text-align: right;"><?= number_format($invoice->discount, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="5"></td>
                    <td style="text-align: right;">PPN :</td>
                    <td style="text-align: right;"><?= number_format($invoice->ppn, 0, '', '.') ?></td>
                </tr>
                <?php if ($invoice->pph > 0) : ?>
                    <tr>
                        <td style="border: none;" colspan="5"></td>
                        <td style="text-align: right;">PPH 23 :</td>
                        <td style="text-align: right;">(<?= number_format($invoice->pph, 0, '', '.') ?>)</td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td style="border: none;" colspan="5"></td>
                    <td style="text-align: right;">Total Faktur :</td>
                    <td style="text-align: right;"><?= number_format($invoice->total, 0, '', '.') ?></td>
                </tr>
            </tfoot>
        </table>
        @endif

         @if($invoice->bast_id!=0)
         @if ($invoice->bast->v2SalesOrder->customerPurchaseOrder->source=="event")
        <table class="bordered-table" style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 30px">No.</th>
                    <th style="width: 70%;"  colspan="2">Description</th>
                    <th>Total</th>
                    
                </tr>
            </thead>
            <tbody>
               
                <tr>
                    <td style="text-align:center">1</td>
                    <td colspan="2">Material -  {{$invoice->bast->v2SalesOrder->customerPurchaseOrder->title}}</td>
                    <td align="right" class="text-right" style="width: 20%;"><?= number_format($invoice->material, 0, '', '.') ?></td>
                    
                </tr>
                   <tr>
                    <td style="text-align:center">2</td>
                    <td   colspan="2">Jasa - ASF</td>
                    <td align="right" ><?= number_format($invoice->asf, 0, '', '.') ?></td>
                   
                    
                </tr>
               
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: none; width: 100px;" colspan="2">
                        <span>Terbilang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="text-transform: capitalize;"><?= $invoice->terbilang ?></span>
                    </td>
                   
                    
                    <td style="text-align: right;">Diskon :</td>
                    <td style="text-align: right;"><?= number_format($invoice->discount, 0, '', '.') ?></td>
                    
                </tr>
                <tr>
                    <td style="border: none;" colspan="2"></td>
                     <td style="text-align: right;">netto :</td>
                    <td style="text-align: right;"><?= number_format($invoice->netto, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: right;">PPN :</td>
                    <td style="text-align: right;"><?= number_format($invoice->ppn, 0, '', '.') ?></td>
                </tr>
                <?php if ($invoice->pph > 0) : ?>
                    <tr>
                        <td style="border: none;" colspan="2"></td>
                        <td style="text-align: right;">PPH 23 :</td>
                        <td style="text-align: right;">(<?= number_format($invoice->pph, 0, '', '.') ?>)</td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: right;">Total Faktur :</td>
                    <td style="text-align: right;"><?= number_format($invoice->total, 0, '', '.') ?></td>
                </tr>
            </tfoot>
        </table>
        @endif
         @if ($invoice->bast->v2SalesOrder->customerPurchaseOrder->source=="other")
        <table class="bordered-table" style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 30px">No.</th>
                    <th style="width: 10%;">Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                    <th>Qty</th>
                    <th>Kts</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->bast->deliveryOrder->deliveryOrderOtherQuotationItems as $item)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td>{{ $item->number }}</td>
                    <td style="width: 20%;">{{ $item->name }}</td>
                    <td style="width: 20%;">{{ $item->description }}</td>
                    <td style="text-align:center">{{$item->quantity}}</td>
                    <td style="text-align:center">{{$item->frequency}}</td>
                    <td style="text-align: right;"><?= number_format($item->otherQuotationItem->price, 0, '', '.') ?></td>
                    <td style="text-align: right;"><?= number_format(($item->otherQuotationItem->price*$item->quantity*$item->frequency) , 0, '', '.') ?></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: none; width: 100px;" colspan="6">
                        <span>Terbilang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="text-transform: capitalize;"><?= $invoice->terbilang ?></span>
                    </td>
                    <td style="text-align: right;">Subtotal :</td>
                    <td style="text-align: right;"><?= number_format($invoice->netto, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="6"></td>
                    <td style="text-align: right;">Diskon :</td>
                    <td style="text-align: right;"><?= number_format($invoice->discount, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="6"></td>
                    <td style="text-align: right;">PPN :</td>
                    <td style="text-align: right;"><?= number_format($invoice->ppn, 0, '', '.') ?></td>
                </tr>
                <?php if ($invoice->pph > 0) : ?>
                    <tr>
                        <td style="border: none;" colspan="6"></td>
                        <td style="text-align: right;">PPH 23 :</td>
                        <td style="text-align: right;">(<?= number_format($invoice->pph, 0, '', '.') ?>)</td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td style="border: none;" colspan="6"></td>
                    <td style="text-align: right;">Total Faktur :</td>
                    <td style="text-align: right;"><?= number_format($invoice->total, 0, '', '.') ?></td>
                </tr>
            </tfoot>
        </table>
        @endif
        @endif

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