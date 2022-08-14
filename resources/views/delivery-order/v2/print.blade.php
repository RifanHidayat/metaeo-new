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
            width: 120px;
            float: right;
            margin: 0 15px;
        }

        .footer ul li p {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 50px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
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
                        @if($delivery_order->v2SalesOrder !== null)
                        @if($delivery_order->v2SalesOrder->source == 'quotation')
                        @if($delivery_order->v2SalesOrder->v2Quotation !== null)
                        <td style="padding: 3px">Quotation # {{ $delivery_order->v2SalesOrder->v2Quotation->number }}</td>
                        @else
                        <td></td>
                        @endif
                        @elseif($delivery_order->v2SalesOrder->source == 'purchase_order')
                        @if($delivery_order->v2SalesOrder->customerPurchaseOrder !== null)
                        <td style="padding: 3px">PO # {{ $delivery_order->v2SalesOrder->customerPurchaseOrder->number }}</td>
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
                </table>
            </div>
        </div>
    </div>
    <div style="margin-top: 10px;" style="width: 100%;">
        <!-- <div style="float: left; width: 45%;"> -->
        <div style="width: 100%;">
            <div style="float: left; width: 45%;">
                <table class="bordered-table" style="width: 100%;">
                    <tr>
                        <th align="left" >Tagihan Ke</th>
                    </tr>
                    <tr>
                        <td><?= $delivery_order->billing_address ?></td>
                    </tr>
                </table>
            </div>
            <!-- </div> -->
            <!-- <div style="float: right; width: 45%; margin-left: 20px;"> -->
            <div style="float: right; width: 45%;">
                <table class="bordered-table" style="width: 100%;">
                    <tr>
                        <th align="left">Kirim Ke</th>
                    </tr>
                    <tr>
                        <td><?= $delivery_order->shipping_address ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- </div> -->
    </div>
    <div style="width: 100%; height: 5px; clear: both;"></div>
    <div style="clear: both">

    <!-- begin sales order -->
      @if($delivery_order->v2SalesOrder['customerPurchaseOrder']['source']=='metaprint')
        <table class="bordered-table" style="width: 100%">
            <tr>
                <th>No.</th>
                <th>Barang</th>
                <th>Deskripsi Barang</th>
                <th>Keterangan</th>
                <th>Kts</th>
                <th>Satuan</th>
            </tr>
            <?php
            $items = [];
            if ($delivery_order->v2SalesOrder !== null) {
                if ($delivery_order->v2SalesOrder->source == 'quotation') {
                    $items = $delivery_order->v2QuotationItems;
                } else if ($delivery_order->v2SalesOrder->source == 'purchase_order') {
                    $items = $delivery_order->cpoItems;
                }
            }
            ?>
            @foreach($items as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $item->pivot->code }}</td>
                <td>{{ $item->pivot->description }}</td>
                <td>{{ $item->pivot->information }}</td>
                <td class="text-right">{{ number_format($item->pivot->amount, 0, ',', '.') }}</td>
                <td class="text-center">{{ $item->pivot->unit }}</td>
            </tr>
            @endforeach
        </table>
        @endif

        <!-- end sales order -->

         <!-- begin sales order -->
      @if($delivery_order->v2SalesOrder->customerPurchaseOrder->source=='other')
      <table class="bordered-table"  style="width: 100%">
            <tr>
                <th>No.</th>
                <th>Kode Barang</th>
                <th>Barang</th>
                <th>Keterangan</th>
                <th>Kts</th>
                <th>Qty</th>
                <th>Satuan</th>
            </tr>
            
            @foreach($items as $item)
            <tr>
                <td class="text-right">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $item->number }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description }}</td>
                <td class="text-right">{{ $item->frequency }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                   <td class="text-center">{{ $item->unit }}</td>
            </tr>
            @endforeach
       </table>
        @endif

        <!-- end sales order -->


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