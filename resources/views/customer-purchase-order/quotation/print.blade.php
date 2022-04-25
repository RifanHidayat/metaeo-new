<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order {{ $cpo->number }}</title>
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
            <span style="display: block;"></span>
            <div style="display: block;">{{ $company->address }}</div>
            <span style="display: block;">Phone {{ $company->phone }}; Fax {{ $company->fax }}</span>
            <!-- <span>Jl. Raya Kebayoran Lama No.15</span><br>
            <span>Jakarta Selatan</span><br>
            <span>Phone (021) 53660077 - 88; Fax (021) 53660099</span> -->
        </div>
        <div class="header-right">
            <h3>Purchase Order</h3>
            <!-- <p>Jakarta, <strong><?= date_format(date_create($cpo->date), "d-m-Y") ?></strong></p> -->
            <p>Tanggal : <strong><?= stringifyDate($cpo->date) ?></strong></p>
            <p>Nomor : <strong><?= $cpo->number ?></strong></p>
        </div>
    </div>
    <div class="header-divider"></div>
    <div class="content">
        <div class="content-left">
            <span>Customer</span>
            <div style="padding-left: 10px;">
                <span style="text-transform: capitalize; display: block; margin: 3px 0;"><strong>
                     <?php echo $cpo->eventQuotations!=null? $cpo->eventQuotations[0]->customer->name:"" ?></strong></span>
                <p style="margin: 0;"><?php echo $cpo->eventQuotations!=null? $cpo->eventQuotations[0]->customer->address:"" ?></p>
            </div>
        </div>
        <!-- <div class="content-right">
            <span style="text-transform: capitalize">Up : <strong><?= $cpo->up ?></strong></span><br>
            <span>Title : <strong><?= $cpo->title ?></strong></span>
        </div> -->
    </div>
    <div style="margin-bottom: 10px; clear:both">
        <!-- <p style="margin: 15px 0 5px 0;">Dengan Hormat,</p> -->
        <!-- <span>Bersama ini kami Metaprint menyampaikan penawaran harga, dengan spesifikasi cetak sebagai berikut :</span> -->
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 30px">No.</th>
                <th>No.Quotation</th>
                <th>Tanggal</th>
                <th>Title</th>
                <th>Net Total</th>
            </tr>
        </thead>
        <tbody>
           @php
           $ppn=0;  
           $pph=0;
           $total=0; 

           @endphp
            @foreach($cpo->eventQuotations as $item)
           @php
            $ppn=+(int)$item->ppn_amount!=null?$item->ppn_amount:0;  
            $pph=+(int)$item->pph23_amount!=null?$item->pph23_amount:0; 
            $total=+(int)$item->total!=null?$item->total:0; 
            
              
           @endphp
        
            <tr>
                <td class="align-top text-center">{{ $loop->iteration }}</td>
                <td class="align-top">
                    <strong>{{ $item->number }}</strong>

                </td>
                <td class="text-center align-top">{{ $item->date }}</td>
                <td class="text-right align-top">{{ $item->title}}</td>
                <td class="text-right align-top">{{ rupiahFormat($item->netto) }}</td>
            </tr>

            @endforeach
            <?php
             $rowspan = 4;
            // if ($cpo->ppn == 1) {
            //     $rowspan += 1;
            // }
            // if ($cpo->pph23 == 1) {
            //     $rowspan += 1;
            // }
            ?>


            <tr>
                <td colspan="3" rowspan="{{ $rowspan }}" class="align-top">
                    <span>Keterangan: </span>
                    <p>{{ $cpo->description }}</p>
                </td>
                <td>Subtotal</td>
                <td class="text-right">Rp {{ rupiahFormat($cpo->subtotal) }}</td>
            </tr>
            <tr>
                <td>PPN </td>
                <td class="text-right">Rp{{rupiahFormat($ppn)}} </td>
            </tr>
           
           
            <tr>
                <td>PPh </td>
                <td class="text-right">Rp {{ rupiahFormat($pph) }}</td>
            </tr>
         
            <tr>
                <td>Total</td>
                <td class="text-right">Rp {{ rupiahFormat($total) }}</td>
            </tr>
        </tbody>
    </table>
    <!-- <div>
        <p>Demikian penawaran kami, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        <span>Hormat kami,</span><br>
        <span>{{ $company->name }}</span><br>
    </div> -->
</body>

</html>