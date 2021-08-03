<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quotation->number }}</title>
    <style>
        body {
            font-size: 10px;
        }

        .header-left {
            float: left;
            width: 50%;
        }

        .header-left p {
            line-height: 2px;
        }

        .header-right {
            float: right;
            width: 40%;
            text-align: right;
        }

        .header-right p {
            line-height: 2px;
        }

        .header-divider {
            clear: both;
            width: 100%;
            height: 3px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }

        .content {
            clear: both;
        }

        .content-left {
            float: left;
            width: 40%;
        }

        .content-right {
            float: right;
            width: 30%;
        }

        table {
            border-collapse: collapse;
            width: 100%
        }

        table tr td,
        table tr th {
            border: 1px solid #000;
            padding: 3px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <img src="https://karir-production.nos.jkt-1.neo.id/logos/11/1029111/unilabel_magenta.png" alt="Logo" width="150" height="60"><br>
            <span>PT. Magenta Mediatama</span><br>
            <span>Jl. Raya Kebayoran Lama No.15</span><br>
            <span>Jakarta Selatan</span><br>
            <span>Phone (021) 53660077 - 88; Fax (021) 53660099</span>
        </div>
        <div class="header-right">
            <h3>Quotation</h3>
            <p>Jakarta, <strong><?= date_format(date_create($quotation->date), "d-m-Y") ?></strong></p>
            <p>Estimated Number : <strong></strong></p>
            <p>Quotation Number : <strong><?= $quotation->number ?></strong></p>
        </div>
    </div>
    <div class="header-divider"></div>
    <div class="content">
        <div class="content-left">
            <span>Kepada Yth,</span><br>
            <span style="text-transform: capitalize"><strong><?= $customer->name ?></strong></span><br>
            <span>Jakarta</span>
        </div>
        <div class="content-right">
            <span style="text-transform: capitalize">Up : <strong><?= '-' ?></strong></span><br>
            <span>Title : <strong><?= $quotation->title ?></strong></span>
        </div>
    </div>
    <div style="margin-bottom: 10px; clear:both">
        <p style="margin: 15px 0 5px 0;">Dengan Hormat,</p>
        <span>Bersama ini kami Metaprint menyampaikan penawaran harga, dengan spesifikasi cetak sebagai berikut :</span>
    </div>
    <table>
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
            @foreach($quotation->estimations as $estimation)
            <tr>
                <td style="text-align:center">{{ $loop->iteration }}</td>
                <td><?= $estimation->work ?></td>
                <td style="text-align:center"><?= number_format($estimation->quantity, 0, '', '.') . ' pcs' ?></td>
                <td style="text-align:right"><?= number_format($estimation->price_per_unit, 0, '', '.') ?></td>
                <td style="text-align:right"><?= number_format($estimation->quantity * $estimation->price_per_unit, 0, '', '.') ?></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" rowspan="<?= ($quotation->pph > 0) ? '4' : '3' ?>" style="width: 100px;">
                    <span>Note : </span><br>
                    <?= $quotation->note ?>
                </td>
                <td>Netto</td>
                <td style="text-align:right"><?= number_format($quotation->quantity * $quotation->price_per_unit, 0, '', '.') ?></td>
            </tr>
            <tr>
                <td>VAT 10%</td>
                <td style="text-align:right"><?= number_format($quotation->ppn, 0, '', '.') ?></td>
            </tr>
            <?php if ($quotation->pph > 0) : ?>
                <tr>
                    <td>PPH 23</td>
                    <td style="text-align:right"><?= number_format($quotation->pph, 0, '', '.') ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Total</td>
                <td style="text-align:right"><?= number_format($quotation->total_bill, 0, '', '.') ?></td>
            </tr>
        </tfoot>
    </table>
    <div>
        <p>Demikian penawaran kami, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        <span>Hormat kami,</span><br>
        <span>PT. Magenta Mediatama</span><br>
        <span>Tinco</span>
    </div>
</body>

</html>