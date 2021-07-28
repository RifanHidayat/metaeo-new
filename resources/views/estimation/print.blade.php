<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <title>Estimation {{ $estimation->number }}</title>
    <style>
        body {
            font-size: 6px;
        }

        .header-table tr td {
            padding: 0 30px;
        }

        .main-table {
            border-collapse: collapse;
            width: 100%;
        }

        .main-table td,
        .main-table th {
            border: 0.5px solid #000;
            padding: 2px;
        }

        .main-table td.no-border {
            border: none;
        }

        .table-summary {
            border-collapse: 'collapse';
            width: 100%;
        }

        .table-summary tr th {
            text-align: 'left';
            padding: 3px 0;
            /* border: 1px solid #000; */
        }

        .table-summary tr td {
            padding: 3px 0;
            /* border: 1px solid #000; */
        }
    </style>
</head>

<body>
    <table class="header-table" style="border-collapse: collapse; margin-bottom: 5px;">
        <tr>
            <td style="text-align: left">Customer : <?= $estimation->picPo->customer->name ?></td>
            <td style="text-align: left">Pekerjaan : <?= $estimation->work ?></td>
            <td>Qty : <?= number_format($estimation->quantity, 0, '', '.') ?> pcs</td>
            <td>Tanggal Estimasi : <?= date_format(date_create($estimation->date), "d-m-Y") ?></td>
            <td>No. Estimasi : <?= $estimation->number ?></td>
        </tr>
    </table>
    <table class="main-table">
        <thead>
            <tr class="top-table-header">
                <th rowspan="2">No.</th>
                <th rowspan="2">Item</th>
                <th colspan="2">Size</th>
                <th rowspan="2">Color</th>
                <th rowspan="2">Qty Mata</th>
                <th colspan="2">Type</th>
                <th colspan="12">Paper</th>
                <th colspan="2">Plat/Film</th>
                <th rowspan="2">Total Cetak</th>
                <th colspan="4">Finishing</th>
            </tr>
            <tr>
                <th>Open</th>
                <th>Close</th>
                <th>Type Cetak</th>
                <th>Type Mesin</th>
                <th>Paper Type</th>
                <th>Paper Grm</th>
                <th>Paper Size Plano P</th>
                <th>Paper Size Plano L</th>
                <th>Paper Hrg/Kg</th>
                <th>Paper Qty Plano</th>
                <th>Paper Cutting Size P</th>
                <th>Paper Cutting Size L</th>
                <th>Paper Qty Cutting Mata</th>
                <th>Paper Qty Cutting Item</th>
                <th>Paper Hrg/Plano</th>
                <th>Paper Total</th>
                <th>Set</th>
                <th>Total</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estimation->offsetItems as $offsetItem) : ?>
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- No -->
                <td><?= $offsetItem->item ?></td> <!-- Item -->
                <td><?= ($offsetItem->size_opened_p + 0) . ' x ' . ($offsetItem->size_opened_l + 0) ?></td> <!-- Size Open -->
                <td><?= ($offsetItem->size_closed_p + 0) . ' x ' . ($offsetItem->size_closed_l + 0) ?></td> <!-- Size Close -->
                <td><?= $offsetItem->color_1 . '/' . $offsetItem->color_2 ?></td> <!-- Color -->
                <td style="background-color: red">?</td> <!-- Qty Mata -->
                <td><?= $offsetItem->type_cetak ?></td> <!-- Type Cetak -->
                <td><?= $offsetItem->machine_id ?></td> <!-- Type Mesin -->
                <td><?= $offsetItem->print_type_id ?></td> <!-- Paper Type -->
                <td><?= $offsetItem->paper_gramasi + 0 ?></td> <!-- Paper Grm -->
                <td><?= $offsetItem->paper_size_plano_p + 0 ?></td> <!-- Ppr Size Plano P -->
                <td><?= $offsetItem->paper_size_plano_l + 0 ?></td> <!-- Ppr Size Plano L -->
                <td><?= number_format($offsetItem->paper_price, 0, '', '.') ?></td> <!-- Paper Hrg/kg -->
                <td><?= number_format($offsetItem->paper_quantity_plano, 0, '', '.') ?></td> <!-- Ppr Qty Plano -->
                <td><?= $offsetItem->paper_cutting_size_p + 0 ?></td> <!-- Ppr Cutting Size P -->
                <td><?= $offsetItem->paper_cutting_size_l + 0 ?></td> <!-- Ppr Cutting Size L -->
                <td style="background-color: red">?</td> <!-- Ppr Qty Cutting Mata -->
                <td><?= number_format($offsetItem->paper_quantity, 0, '', '.') ?></td> <!-- Ppr Qty Cutting Item -->
                <td><?= number_format($offsetItem->paper_unit_price, 0, '', '.') ?></td> <!-- Paper Hrg/plano -->
                <td><?= number_format($offsetItem->paper_total, 0, '', '.') ?></td> <!-- Paper Total -->
                <td><?= number_format($offsetItem->plat_film_quantity_set, 0, '', '.') ?></td> <!-- Film Set -->
                <td><?= number_format($offsetItem->plat_film_total, 0, '', '.') ?></td> <!-- Film Total -->
                <td><?= number_format($offsetItem->print_total, 0, '', '.') ?></td> <!-- Total Cetak -->
                <td><?= $offsetItem->finishing_item ?></td> <!-- Finishing item -->
                <td><?= number_format($offsetItem->finishing_qty, 0, '', '.') ?></td> <!-- Finishing qty -->
                <td><?= $offsetItem->finishing_unit_price ?></td> <!-- Finishing unit -->
                <td><?= number_format($offsetItem->finishing_total, 0, '', '.') ?></td> <!-- Finishing total -->

            </tr>

            @if(count($offsetItem->subItems) > 0)
            @foreach($offsetItem->subItems as $offsetSubitem)
            <tr>
                <td colspan="23" class="no-border"></td>
                <td><?= $offsetSubitem->finishing_item ?></td>
                <td><?= number_format($offsetSubitem->finishing_qty, 0, '', '.') ?></td>
                <td><?= $offsetSubitem->finishing_unit_price ?></td>
                <td><?= number_format($offsetSubitem->finishing_total, 0, '', '.') ?></td>
            </tr>
            @endforeach
            @endif
            @endforeach
        </tbody>
    </table>
    <div style="float: right; width: 15%; margin-top: 20px">
        <table class="table-summary">
            <tr>
                <th>Total Produksi</th>
                <td style="text-align: right"><?= number_format($estimation->production, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>Design/Approval</th>
                <td style="text-align: right"><?= number_format($app_set_design, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>HPP</th>
                <td style="text-align: right"><?= number_format($estimation->hpp, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>HPP/Unit</th>
                <td style="text-align: right"><?= number_format($estimation->hpp_per_unit, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>Harga Jual/Unit</th>
                <td style="text-align: right"><?= number_format($estimation->price_per_unit, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>Margin %</th>
                <td style="text-align: right"><?= number_format($estimation->margin, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>Total Harga Jual</th>
                <td style="text-align: right"><?= number_format($estimation->total_price, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>PPN 10%</th>
                <td style="text-align: right"><?= number_format($estimation->ppn, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>PPH</th>
                <td style="text-align: right"><?= number_format($estimation->pph, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>Total Piutang</th>
                <td style="text-align: right"><?= number_format($estimation->total_bill, 0, '', '.') ?></td>
            </tr>
        </table>
    </div>
</body>

</html>