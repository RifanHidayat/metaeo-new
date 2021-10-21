<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quotation->number }}</title>
    <style>
        body {
            font-size: 10px;
            font-family: sans-serif;
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

        .description p,
        .note p {
            margin-top: 0;
        }
    </style>
</head>
<?php

function isValidDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function stringifyDate($date)
{
    if (isValidDate($date)) {
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $expDate = explode('-', $date);
        $newDate = (int) $expDate[2] . ' ' . $months[(int) $expDate[1] - 1] . ' ' . $expDate[0];
        return $newDate;
    }

    return '-';
}
?>

<body>
    <div class="header">
        <div class="header-left">
            <img src="{{ $company->logo !== null ? Storage::disk('s3')->url($company->logo) : '' }}" alt="Logo" height="40"><br>
            <span style="display: block;">{{ $company->name }}</span>
            <span style="display: block;">{{ $company->address }}</span>
            <span style="display: block;">Phone {{ $company->phone }}; Fax {{ $company->fax }}</span>
            <!-- <span>Jl. Raya Kebayoran Lama No.15</span><br>
            <span>Jakarta Selatan</span><br>
            <span>Phone (021) 53660077 - 88; Fax (021) 53660099</span> -->
        </div>
        <div class="header-right">
            <h3>Quotation</h3>
            <!-- <p>Jakarta, <strong><?= date_format(date_create($quotation->date), "d-m-Y") ?></strong></p> -->
            <p>Jakarta, <strong><?= stringifyDate($quotation->date) ?></strong></p>
            <p>Nomor : <strong><?= $quotation->number ?></strong></p>
        </div>
    </div>
    <div class="header-divider"></div>
    <div class="content">
        <div class="content-left">
            <span>Kepada Yth,</span>
            <div style="padding-left: 10px;">
                <span style="text-transform: capitalize; display: block; margin: 3px 0;"><strong><?= $quotation->customer->name ?></strong></span>
                <span>{{ $quotation->customer->address }}</span>
            </div>
        </div>
        <div class="content-right">
            <span style="text-transform: capitalize">Up : <strong><?= $quotation->picPo->name ?></strong></span><br>
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
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->estimations as $estimation)
            <!-- <tr>
                <td style="text-align:center">{{ $loop->iteration }}</td>
                <td><?= $estimation->work ?></td>
                <td style="text-align:center"><?= number_format($estimation->quantity, 0, '', '.') . ' pcs' ?></td>
                <td style="text-align:right"><?= number_format($estimation->price_per_unit, 0, '', '.') ?></td>
                <td style="text-align:right"><?= number_format($estimation->quantity * $estimation->price_per_unit, 0, '', '.') ?></td>
            </tr> -->
            @endforeach

            <tr>
                <td style="text-align:center; vertical-align: top;">1</td>
                <td class="description"><?= $quotation->description ?></td>
                <td style="vertical-align: top;">
                    @foreach($quotation->estimations as $estimation)
                    <div style="width: 100%;">
                        <span style="display: inline-block; width: 70%; text-align: right;"><?= number_format($estimation->quantity, 0, '', '.') ?></span>
                        <span style="display: inline-block;  width: 20%; text-align: right;">pcs</span>
                    </div>
                    @endforeach
                </td>
                <td style="vertical-align: top;">
                    @foreach($quotation->estimations as $estimation)
                    <div style="width: 100%;">
                        <span style="display: inline-block;  width: 20%; text-align: left;">Rp.</span>
                        <span style="display: inline-block; width: 75%; text-align: right;"><?= number_format($estimation->price_per_unit, 0, '', '.') ?></span>
                    </div>
                    @endforeach
                </td>
                <td style="vertical-align: top;">
                    @foreach($quotation->estimations as $estimation)
                    <div style="width: 100%;">
                        <span style="display: inline-block;  width: 20%; text-align: left;">Rp.</span>
                        <span style="display: inline-block; width: 75%; text-align: right;"><?= number_format($estimation->price_per_unit * $estimation->quantity, 0, '', '.') ?></span>
                    </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" rowspan="<?= ($quotation->pph > 0) ? '4' : '3' ?>" style="width: 100px; vertical-align: top;">
                    <span>Note : </span><br>
                    <div class="note">
                        <?= $quotation->note ?>
                    </div>
                </td>
                <td>Netto</td>
                <td style="text-align:right">
                    @if(count($quotation->estimations) == 1)
                    <div style="width: 100%;">
                        <span style="display: inline-block;  width: 20%; text-align: left;">Rp.</span>
                        <span style="display: inline-block; width: 75%; text-align: right;"><?= number_format($quotation->quantity * $quotation->price_per_unit, 0, '', '.') ?></span>
                    </div>
                    @endif
                </td>
            </tr>
            <tr>
                <td>PPN 10%</td>
                <td style="text-align:right">
                    @if(count($quotation->estimations) == 1)
                    <div style="width: 100%;">
                        <span style="display: inline-block;  width: 20%; text-align: left;">Rp.</span>
                        <span style="display: inline-block; width: 75%; text-align: right;"><?= number_format($quotation->ppn, 0, '', '.') ?></span>
                    </div>
                    @endif
                </td>
            </tr>
            <?php if ($quotation->pph > 0) : ?>
                <tr>
                    <td>PPH 23</td>
                    <td style="text-align:right">
                        @if(count($quotation->estimations) == 1)
                        <div style="width: 100%;">
                            <span style="display: inline-block;  width: 20%; text-align: left;">Rp.</span>
                            <span style="display: inline-block; width: 75%; text-align: right;"><?= number_format($quotation->pph, 0, '', '.') ?></span>
                        </div>
                        @endif
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Total</td>
                <td style="text-align:right">
                    @if(count($quotation->estimations) == 1)
                    <div style="width: 100%;">
                        <span style="display: inline-block;  width: 20%; text-align: left;">Rp.</span>
                        <span style="display: inline-block; width: 75%; text-align: right;"><?= number_format($quotation->total_bill, 0, '', '.') ?></span>
                    </div>
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <div>
        <p>Demikian penawaran kami, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        <span>Hormat kami,</span><br>
        <span>{{ $company->name }}</span><br>
        <!-- <span>Tinco</span> -->
    </div>
</body>

</html>