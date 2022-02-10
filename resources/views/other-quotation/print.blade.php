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

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .align-top {
            vertical-align: top;
        }
    </style>
</head>
<?php

function rupiahFormat($number)
{
    return number_format($number, 0, ',', '.');
}

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
            <div style="display: block;">{{ $company->address }}</div>
            <span style="display: block;">Phone {{ $company->phone }}; Fax {{ $company->fax }}</span>
            <!-- <span>Jl. Raya Kebayoran Lama No.15</span><br>
            <span>Jakarta Selatan</span><br>
            <span>Phone (021) 53660077 - 88; Fax (021) 53660099</span> -->
        </div>
        <div class="header-right">
            <h3>Quotation</h3>
            <!-- <p>Jakarta, <strong><?= date_format(date_create($quotation->date), "d-m-Y") ?></strong></p> -->
            <p>Jakarta, <strong><?= stringifyDate($quotation->date) ?></strong></p>
            <p>Ref : <strong><?= $quotation->number ?></strong></p>
        </div>
    </div>
    <div class="header-divider"></div>
    <div class="content">
        <div class="content-left">
            <span>Kepada Yth,</span>
            <div style="padding-left: 10px;">
                <span style="text-transform: capitalize; display: block; margin: 3px 0;"><strong><?= $quotation->customer->name ?></strong></span>
                <p style="margin: 0;">{{ $quotation->customer->address }}</p>
            </div>
        </div>
        <div class="content-right">
          
            <span>Title : <strong><?= $quotation->title ?></strong></span><br>
              <span style="text-transform: capitalize">To : <strong><?= $quotation->picEvent->name ?></strong></span><br>
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
                <th style="width: 100px">Qty</th>
                <th style="width: 100px">Frequency</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $item)
            <tr>
                <td class="align-top text-center">{{ $loop->iteration }}</td>
                <td class="align-top">
                    <strong>{{ $item->name }}</strong>
                    <p>{{ $item->goods['number']}}</p>
                </td>
                <td class="text-center align-top">{{ rupiahFormat($item->quantity) }}</td>
                 <td class="text-center align-top">{{ rupiahFormat($item->frequency) }}</td>
                <td class="text-right align-top">{{ rupiahFormat($item->price) }}</td>
                <td class="text-right align-top">{{ rupiahFormat($item->amount) }}</td>
            </tr>
            @endforeach
            <?php
            $rowspan = 4;
            if ($quotation->ppn == 1) {
                $rowspan += 1;
            }
            if ($quotation->pph23 == 1) {
                $rowspan += 1;
            }
            ?>
            <tr>
                <td colspan="4" rowspan="{{ $rowspan }}" class="align-top">
                    <span>Note: </span>
                    <p>{{ $quotation->note }}</p>
                </td>
                <td>Subtotal</td>
                <td class="text-right">{{ rupiahFormat($quotation->subtotal) }}</td>
            </tr>
              <tr>
                <td>ASF {{ $quotation->asf_percent }}% </td>
                <td class="text-right">{{ rupiahFormat($quotation->asf)}} </td>
            </tr>
             <tr>
                <td>Discount {{ $quotation->discount_percent }}% </td>
                <td class="text-right">{{ rupiahFormat($quotation->discount) }}</td>
            </tr>
              <tr>
                <td><span><strong>Netto</strong></span></td>
                <td class="text-right" ><span><strong>Rp {{ rupiahFormat($quotation->netto) }}</strong></span></td>
            </tr>
               
        </tbody>
    </table>
    <div>
        <p>Demikian penawaran kami, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        <span>Hormat kami,</span><br>
        <span>{{ $company->name }}</span><br>
        <!-- <span>Tinco</span> -->
    </div>
</body>

</html>