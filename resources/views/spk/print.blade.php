<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job_order->number }}</title>
    <style>
        body {
            font-size: 10px;
        }

        .header {
            float: right;
            width: 25%;
        }

        .header p {
            line-height: 10px;
        }

        .content {
            clear: right;
            margin-top: 10px
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr th,
        table tr td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .table-info {
            width: 50%;
        }

        .finishing {
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .finishing-left {
            width: 50%;
            float: left;
        }

        .finishing-right {
            width: 50%;
            float: right;
        }

        .finishing-item {
            border: 1px solid #000;
            padding: 3px;
            margin-right: 5px;
            background-color: rgba(0, 0, 0, .15);
        }

        .finishing-right table {
            border-collapse: collapse;
        }

        .summary {
            margin-top: 30px;
        }

        .summary table {
            border-collapse: collapse;
            width: 100%;
        }

        .divider {
            height: 3px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p>Job Order Number <strong>#<?= $job_order->number ?></strong></p>
        <p>SO Number <strong>#<?= $job_order->salesOrder->number ?></strong></p>
        <p>PO Number <strong>#<?= $job_order->salesOrder->po_number ?></strong></p>
        <p>Customer <strong>#<?= $job_order->customer->name ?></strong></p>
        <p>Designer <strong>#<?= $job_order->designer ?></strong></p>
    </div>
    <div class="content">
        @foreach($job_order->quotations as $quotation)
        @if($loop->first)
        <div>
            @else
            <div style="margin-top: 30px;">
                <div class="divider"></div>
                @endif
                <table class="table-info">
                    <thead>
                        <tr>
                            <th>Nomor Quotation</th>
                            <th>Jenis Pesanan</th>
                            <th>Jumlah Pesanan</th>
                            <!-- <th>Customer</th> -->
                            <!-- <th>Jenis Pesanan</th>
                    <th>Jumlah Pesanan</th> -->
                            <!-- <th>Designer</th>
                    <th>Tanggal Finish</th>
                    <th>Tanggal Kirim</th>
                    <th>Cara Cetak</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $quotation->number ?></td>
                            <td><?= $quotation->title ?></td>
                            <td><?= $quotation->pivot->produced ?></td>
                            <!-- <td></td> -->
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">Cara Cetak</th>
                            <th rowspan="2">Item</th>
                            <th rowspan="2">Paper</th>
                            <th colspan="2">Plano</th>
                            <th colspan="2">Ukuran Potong</th>
                            <th rowspan="2">Warna</th>
                            <th colspan="2">Film/CTP</th>
                            <th rowspan="2">Type Cetak</th>
                        </tr>
                        <tr>
                            <th>Ukuran</th>
                            <th>Jumlah</th>
                            <th>Ukuran</th>
                            <th>Jumlah</th>
                            <th>Set</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotation->selectedEstimation->offsetItems as $offsetItem)
                        <tr>
                            <td>Offset</td>
                            <td><?= $offsetItem->item ?></td>
                            <td><?= $offsetItem->paper_id ?></td>
                            <td><?= round($offsetItem->paper_size_plano_p, 2) . ' x ' . round($offsetItem->paper_size_plano_l, 2) ?></td>
                            <td><?= number_format($offsetItem->paper_quantity_plano, 0, '', '.') ?></td>
                            <td><?= round($offsetItem->paper_cutting_size_plano_p, 2) . ' x ' . round($offsetItem->paper_cutting_size_plano_l, 2) ?></td>
                            <td><?= number_format($offsetItem->paper_quantity, 0, '', '.') ?></td>
                            <td><?= $offsetItem->color_1 . '/' . $offsetItem->color_2 ?></td>
                            <td><?= number_format($offsetItem->plat_film_quantity_set, 0, '', '.') ?></td>
                            <td><?= number_format($offsetItem->plat_film_total, 0, '', '.') ?></td>
                            <td><?= $offsetItem->print_type_id ?></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Finishing Offset -->
                <div class="finishing">
                    <div class="finishing-left">
                        <span><strong>Finishing</strong></span><br><br>
                        <!-- <div style="float:left; width: 80%; border: 1px solid #000; padding: 5px; height: 100px;">
                            <span>Type Finishing</span><br>
                            @foreach($quotation->selectedEstimation->offsetItems as $offsetItem)
                            <div style="padding: 2px; float: left; width: 95px">
                                <div class="finishing-item"><span><?= $offsetItem->finishing_item ?></span></div>
                            </div>
                            @endforeach
                        </div> -->
                        <ul style="margin: 0; margin-bottom: 30px;">
                            @foreach($quotation->selectedEstimation->offsetItems as $offsetItem)
                            <li><?= $offsetItem->finishing_item ?></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="finishing-right">
                        <span><strong>Cutting Pola :</strong></span><br><br>

                    </div>
                </div>

                <div style="margin-top: 100px; clear: both;">
                    <table>
                        <thead>
                            <tr>
                                <th rowspan="2">Cara Cetak</th>
                                <th rowspan="2">Item</th>
                                <th rowspan="2">Paper</th>
                                <th colspan="2">Plano</th>
                                <th colspan="2">Ukuran Potong</th>
                                <th rowspan="2">Warna</th>
                                <th colspan="2">Film/CTP</th>
                                <th rowspan="2">Type Cetak</th>
                            </tr>
                            <tr>
                                <th>Ukuran</th>
                                <th>Jumlah</th>
                                <th>Ukuran</th>
                                <th>Jumlah</th>
                                <th>Set</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotation->selectedEstimation->digitalItems as $digitalItem)
                            <tr>
                                <td>Digital</td>
                                <td><?= $digitalItem->item ?></td>
                                <td><?= $digitalItem->paper_id ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?= $digitalItem->color_1 . '/' . $digitalItem->color_2 ?></td>
                                <td></td>
                                <td></td>
                                <td>BBL</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Finishing Digital -->
                <div class="finishing" style="margin-bottom: 60px;">
                    <div class="finishing-left">
                        <span><strong>Finishing</strong></span><br><br>
                        <!-- <div style="float:left; width: 80%; border: 1px solid #000; padding: 5px; height: 100px;">
                            <span>Type Finishing</span><br>
                            @foreach($quotation->selectedEstimation->offsetItems as $offsetItem)
                            <div style="padding: 2px; float: left; width: 95px">
                                <div class="finishing-item"><span><?= $offsetItem->finishing_item ?></span></div>
                            </div>
                            @endforeach
                        </div> -->
                        <ul style="margin: 0; margin-bottom: 30px;">
                            @foreach($quotation->selectedEstimation->offsetItems as $offsetItem)
                            <li><?= $offsetItem->finishing_item ?></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="finishing-right">
                        <span><strong>Cutting Pola :</strong></span><br><br>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="summary">
            <table>
                <thead>
                    <tr>
                        <th>Disiapkan</th>
                        <th>Diperiksa</th>
                        <th>Produksi</th>
                        <th>Finishing</th>
                        <th>Gudang</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-top: 30px;"><?= $job_order->preparer ?></td>
                        <td style="padding-top: 30px;"><?= $job_order->examiner ?></td>
                        <td style="padding-top: 30px;"><?= $job_order->production ?></td>
                        <td style="padding-top: 30px;"><?= $job_order->finishing ?></td>
                        <td style="padding-top: 30px;"><?= $job_order->warehouse ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- FInishing -->
</body>

</html>