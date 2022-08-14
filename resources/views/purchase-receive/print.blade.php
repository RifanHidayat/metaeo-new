<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUmber</title>
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
            <!-- <div style="margin-top: 5px">
                <span style="display: block;">Nama Perusahaan</span>
                <span style="display: block;">Alamat Perusahaan </span>
                <span style="display: block;">Fax</span>
            </div> -->
            <div style="margin-top: 10px;">
                <table>
                    <tr>
                        <td style="vertical-align: top;"><strong>Kepada</strong> </td>
                    </tr>
                        <tr>
                        <td style="padding-left: 8px; vertical-align: top;">
                            <span>{{$purchase_order->purchaseOrder->supplier==null?"":$purchase_order->purchaseOrder->supplier->name}}</span>
                            <br>
                            <span>{{$purchase_order->purchaseOrder->supplier==null?"":$purchase_order->purchaseOrder->supplier->address}}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="margin-top:100px">
            
            <table  class="table-header" style="margin-top:100px;margin-left: auto;">
                   <tr>
                <td colspan="3">
                       <h1 style="text-align:right">Penerimaan  Barang</h1>

                </td>
    </tr>
            
                <tr>
                    <td>NO.Penerimaan</td>
                    <td>:</td>
                    <td>{{$purchase_order->number}}</td>
                </tr>
                <tr>
                    <td>Tanggal </td>
                    <td>:</td>
                    <td>{{$purchase_order->date}}</td>
                </tr>
                <tr>
                    <td>No. Invoice</td>
                    <td>:</td>
                    <td>{{$purchase_order->invoic_number}}</td>
                </tr>

                 <tr>
                    <td>Tgl. Invoice</td>
                    <td>:</td>
                    <td>{{$purchase_order->invoice_date}}</td>
                </tr>

            </table>
        </div>
    </div>
    <div>
           <table class="bordered-table" style="width: 100%">
            <thead>
                <tr>
                    
                    
                    <th>Kode Barang</th>
                    <th>Nama Barang </th>
                    <th>KTS</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($goods as $item)
                <tr>
                  
                    <td>{{$item->name}}</td>
                    <td style="width: 20%;">{{$item->number}}</td>
                    <td style="width: 20%;">{{$item['pivot']->quantity}}</td>
                    <td style="text-align:right">       <?= number_format($item['pivot']->price, 0, '', '.') ?></td>
                    <td style="text-align:right">       <?= number_format($item['pivot']->discount, 0, '', '.') ?></td>
                    <td style="text-align: right;">       <?= number_format($item['pivot']->total, 0, '', '.') ?></td>
                    <?= number_format($item['pivot']->total, 0, '', '.') ?>
                </tr>
                @endforeach
            </tbody>

                  <tfoot>
                <tr>
                    <td style="border: none; width: 100px;" colspan="4">
                        <span><b>Keterangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="text-transform: capitalize;"></b></span>
                        <br><span>{{$purchase_order->description!=null?$purchase_order->description:""}}</span>
                    </td>
                    <td style="text-align: right;">Subtotal :</td>
                    <td style="text-align: right;"> <?= number_format($purchase_order->subtotal, 0, '', '.') ?></td>
                </tr>
                <tr>
                    <td style="border: none;" colspan="4"></td>
                    <td style="text-align: right;">Diskon :</td>
                    <td style="text-align: right;">  <?= number_format($purchase_order->discount, 0, '', '.') ?></td>
                </tr>
                <?php if ($purchase_order->ppn_amount > 0) : ?>
                <tr>
                    <td style="border: none;" colspan="4"></td>
                    <td style="text-align: right;">PPN 11% :</td>
                    <td style="text-align: right;">  <?= number_format($purchase_order->ppn_amount, 0, '', '.') ?></td>
                </tr>
                <?php endif  ?>
             
                <?php if ($purchase_order->pph_amount > 0) : ?>
                    <tr>
                        <td style="border: none;" colspan="4"></td>
                        <td style="text-align: right;">PPH  :</td>
                        <td style="text-align: right;">  <?= number_format($purchase_order->pph_amount, 0, '', '.') ?></td>
                      
                    </tr>
                      <?php endif  ?>
               
                <tr>
                    <td style="border: none;" colspan="4"></td>
                    <td style="text-align: right;">Total  :</td>
                    <td style="text-align: right;">  <?= number_format($purchase_order->total, 0, '', '.') ?> </td>
                </tr>
            </tfoot>
    </table>
      

    <!-- beignsales order -->
    
   

       
  
        

    </div>
    <!-- <p>Terbilang: Dua Puluh Ribu Rupiah</p> -->
    <div class="footer" style=" margin-top: 5px">
        <div style="width: 60%; float: right">
            <table class="table-footer " style="width: 100%;">
                <tr>
                   <th   align="center">Diterima Oleh,</th>
                   <th>&nbsp;</th>
                    <th   align="center">Disetuji Oleh,</th>
                </tr>
                  
                <tr>
                    
                
                    <th>	&nbsp;<hr  style="margin-top:50px">	&nbsp;</th>
                      <th>&nbsp;</th>
                     
                    <th>	&nbsp;<hr  style="margin-top:50px">	&nbsp;</tr>
                   
                </tr>
            </table>
        </div>
        
    </div>
    
</body>

</html>