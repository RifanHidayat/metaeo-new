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
             <span>Venue : <strong><?= $quotation->venue     ?></strong></span><br>
               <span style="text-transform: capitalize">To : <strong><?= $quotation->picEvent->name ?></strong></span><br>
               <span style="text-transform: capitalize">Date Event: <strong><?= $quotation->event_date ?></strong></span><br>
            
        </div>
    </div>
    <div style="margin-bottom: 10px; clear:both">
        <p style="margin: 15px 0 5px 0;">Dengan Hormat,</p>
        <span>Bersama ini kami Magenta menyampaikan penawaran harga sebgai berikut:</span>
    </div>
    <table  style="page-break-after:always">
        <thead>
            <tr>
                <th style="width: 30px">No.</th>
                <th style="width: 70%">Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
        

            <?php $subtotalNon=0?>
            @foreach($all as $nonfee)
            <tr>
                <td class="align-top text-center">{{ $loop->iteration }}</td>
                <td class="align-top">
                    
                    <p>{{ $nonfee->name }}</p>
                </td>
                
                <td class="text-right align-top">{{ rupiahFormat($nonfee->subtotal) }}</td>
            </tr>
            <?php $subtotalNon+=$nonfee->subtotal ?>
            @endforeach
             <!-- <tr>
             
            <td colspan="2"><span>Total</span></td>
             <td  class="text-right" ><span><strong>{{ rupiahFormat($subtotalNon) }}</strong></span></td>
             </tr> -->
            
        </tr>
            <?php
            $rowspan = 2;
            $colspan=2;
            if ($quotation->is_show_ppn == 1) {
                $rowspan += 1;
            }
            if ($quotation->is_show_pph == 1) {
                $rowspan += 1;
            }
            ?>
            @php
            $total=$quotation->netto;
            if ($quotation->is_show_discount==1){
                $total=$total-$quotation->discount;
            }
            if ($quotation->is_show_ppn==1){
                $total=$total+$quotation->ppn_amount;
            }
            if ($quotation->is_show_pph==1){
                $total=$total-$quotation->pph23_amount;
            }
            if ($quotation->is_show_pphfinal==1){
                $total=$total-$quotation->pphfinal_amount;
            }
            @endphp
            <tr>
              
                <td colspan="{{$colspan}}">Subtotal</td>
                <td class="text-right">{{ rupiahFormat($subtotalNon) }}</td>
            </tr>
             <tr>
                <td colspan="{{$colspan}}">ASF </td>
                <td class="text-right"> {{ rupiahFormat($quotation->asf) }}</td>
            </tr>
            
         
            <tr>
                <td colspan="{{$colspan}}"  >Netto</td>
                <td class="text-right">Rp {{ rupiahFormat($quotation->netto) }}</td>
            </tr>
            @if($quotation->is_show_discount==1):
            <tr>
                <td colspan="{{$colspan}}">Discount </td>
                <td class="text-right"> {{ rupiahFormat($quotation->discount) }}</td>
            </tr>
            @endif
            @if($quotation->is_show_ppn==1):
             <tr>
                <td colspan="{{$colspan}}"  >PPN 11%</td>
                <td class="text-right">Rp {{ rupiahFormat($quotation->ppn_amount) }}</td>
            </tr>
            @endif
            @if($quotation->is_show_pph==1):
             <tr>
                <td colspan="{{$colspan}}"  >PPh23 </td>
                <td class="text-right">Rp {{ rupiahFormat($quotation->pph23_amount) }}</td>
            </tr>
            @endif

            @if($quotation->is_show_pphfinal==1):
             <tr>
                <td colspan="{{$colspan}}"  >PPh Pasal 4 </td>
                <td class="text-right">Rp {{ rupiahFormat($quotation->pphfinal_amount) }}</td>
            </tr>
            @endif
            
             <tr>
                <td colspan="{{$colspan}}"  >Total</td>
                <td class="text-right"><strong>Rp @php echo rupiahFormat($total)@endphp
                </strong>
                </td>
            </tr>
        </tbody>
    </table>
    <div>
    <br>
    <br>
    <div class="mt-5" >
    
    @foreach ($all as $nonfee)

    <table border="1">
     <tr>
     <th class="text-left" align="left" colspan="7">
     <strong>{{$nonfee->name}}</strong>
     <tr>
            
     </th>
     <thead>
     <tr>
            <th style="width: 5%;">
                No
            </th>
             <th style="width: 20%;">
                Description
            </th>
              <th style="width: 15%;">
                Quantity
            </th>
            <th style="width: 15%;">
                Duration
            </th>
             <th style="width: 15%;">
                Frequency
            </th>
              <th style="width: 20%;">
                Rate
              <th style="width: 25%;">
            
                Subtotal
            </th>
            <tr>
     </thead>
     <tbody>
     @foreach ($nonfee->sub_items as $subitem)
    <tr>
     <td align="right">{{ $loop->iteration }}</td>
     <td>
    {{$subitem->name}}
     <br>
     <!-- <span>{{$subitem->pivot->is_stock==1?"Barang":""}}</span> -->
     </td>
      <td align="center"> {{$subitem->pivot->quantity}} {{$subitem->pivot->is_stock==0?$subitem->unit_quantity:$subitem->unit}} </td>
      <td align="right" >{{rupiahFormat($subitem->pivot->duration)}} </td>
       <td align="center"> {{$subitem->pivot->is_stock==0?$subitem->pivot->frequency:""}} {{$subitem->pivot->is_stock==0?$subitem->unit_frequency:"0"}} </td>
     
       <td align="right" >{{rupiahFormat($subitem->pivot->rate)}} </td>
       <td align="right"> {{rupiahFormat($subitem->pivot->subtotal)}}</td>
    
    <tr>
     @endforeach
     <tr>
     <th colspan="6" align="left">Total</th>
      <th align="right">{{rupiahFormat($nonfee->subtotal)}}</th>
     </tr>
      <tr>
     <th style="border:none" colspan="6" align="left"><br></th> 
     </tr>
    
     </tbody>
     </tr>

    </table>
    @endforeach

    </div>
     <br>
    <br>
    <div>


    <span><strong>{{$cost_length>0?"Commissionable Cost":""}}</strong><span>
    @foreach ($cost as $nonfee)

    <table border="1">
     <tr>
     <th class="text-left" align="left" colspan="7">
     <strong>{{$nonfee->name}}</strong>
     <tr>
            
     </th>
     <thead>
 <tr>
            <th style="width: 5%;">
                No
            </th>
             <th style="width: 20%;">
                Description
            </th>
              <th style="width: 15%;">
                Quantity
            </th>
            <th style="width: 15%;">
               Duration
            </th>
             <th style="width: 15%;">
                Frequency
            </th>
              <th style="width: 20%;">
                Rate
              <th style="width: 25%;">
            
                Subtotal
            </th>
            <tr>
     </thead>
     <tbody>
     @foreach ($nonfee->sub_items as $subitem)
     <tr>
     <td align="right">{{ $loop->iteration }}</td>
     <td>{{$subitem->name}}</td>
        <td align="center"> {{$subitem->pivot->quantity}} {{$subitem->unit_quantity}} </td>
        <td align="right" >{{rupiahFormat($subitem->pivot->duration)}} </td>
       <td align="center"> {{$subitem->pivot->frequency}} {{$subitem->unit_frequency}} </td>
  
       <td align="right" >{{rupiahFormat($subitem->pivot->rate)}} </td>
       <td align="right"> {{rupiahFormat($subitem->pivot->subtotal)}}</td>
    
    <tr>
     @endforeach
    <tr>
     <th colspan="6" align="left">Total</th>
     <th align="right">{{rupiahFormat($nonfee->subtotal)}}</th>
     </tr>

          <tr>
     <th style="border:none" colspan="6" align="left"><br></th> 
     </tr>
    
    
     </tbody>
     </tr>

    </table>
    @endforeach
    </div>
    
    <div>
        <p>Demikian penawaran kami, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        <span>Hormat kami,</span><br>
        <span>Magenta Mediatama</span><br>
        <!-- <span>Tinco</span> -->
    </div>
</body>

</html>