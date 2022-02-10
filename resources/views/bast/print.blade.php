<!DOCTYPE html>
<html>

<head>
  <title><?php echo "bast Number" ?></title>
  <style type="text/css">
    .ttd1 {
      float: right;


      width: 200px;
      /*   border: 1px solid #000;*/
    }
  </style>


</head>

<body>
  <div class="wrapper">

    <section class="invoice">
      <div class="Contaier">
        <div class="header">

          <center>
            <h3 align="center">PT.Magenta Mediatama<br> Berita Acara<br><?php echo $bast->number ?></h3>
          </center>

        </div>
        <div class="sub-header">
          <p><?php

              $daftar_hari = array(
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu'
              );

            //   $namahari = date('l', strtotime($bast->date));





            //   $tanggal = tgl_aja($bast->date);
            //   $bulan = bln_aja($bast->date);
            //   $tahun = thn_aja($bast->date);
            //   $tgl = tgl_indo($bast->date);

            //   echo "Pada hari ini, " . $daftar_hari[$namahari] . "  tanggal " . terbilang($tanggal) . " " . $bulan . " tahun <b>" . terbilang($tahun) . "</b><br> Yang bertanda tangan dibawah ini:";



              ?></p>
          <span></span>



        </div>

        <div class="body">
          <table>
            <tr>
              <td style="width:30px">I</td>
              <td style="width: 30%">Nama</td>
              <td>:</td>
              <td><u><?php echo $bast->pic_event; ?></u></td>


            </tr>
            <tr>
              <td></td>
              <td>Jabatan</td>
              <td>:</td>
              <td><u><?php echo  $bast->pic_event_position ?></u></td>


            </tr>
          </table>
          <br>
          
          <table style="margin-left: 4%">
            <tr>
              <td align="justify"> <span>Dalam hal ini bertindak untuk dan atas nama <?php echo $bast->v2SalesOrderItem->picEvent->customer->name ?> yang berkedudukan di <?php echo $bast->v2SalesOrderItem->picEvent->customer->address. ""; ?> untuk selanjutnya disebut sebagai <b>PIHAK PERTAMA</b></span> </td>
            </tr>
          </table>

          <br>
          
          <table>
            <tr>
              <td style="width: 30px">II</td>
              <td style="width: 20%">Nama</td>
              <td>:</td>
              <td><u><?php echo $bast->pic_magenta ?></u></td>


            </tr>
            <tr>
              <td></td>
              <td>Jabatan</td>
              <td>:</td>
              <td><u><?php echo  $bast->pic_magenta_position ?></u></td>


            </tr>
          </table>
          <br>
        
          <table style="margin-left: 4%">
            <tr>
              <td td align="justify"> <span style="margin-left: 20%;">dalam hal ini bertindak untuk dan atas nama PT. Magenta Mediatama yang berkedudukan di jl. Raya Kebayoran Lama No. 15 Grogol Utara Jakarta Selatan 12210 untuk selanjutnya disebut sebagai <b> PIHAK KEDUA</b></span><br><br>
              </td>
            </tr>
          </table><br>
          <span>Menerangkan bahwa telah dilakukan pekerjaan untuk GR No.<u><?php echo $bast->gr_number. ""; ?></u> dan PO Nomor <u><?php echo $bast->v2SalesOrderItem->v2SalesOrder->customerPurchaseOrder->number. ""; ?></u> </span>

          <br>
          <br>
          <p>&ensp;&ensp;<b><?php echo $bast->v2SalesOrderItem->v2SalesOrder->customerPurchaseOrder->title . ""; ?></b><b><?php echo "" . ""; ?></b> &ensp;&ensp;&ensp;&ensp;<b><?php echo "( IDR " . number_format($bast->amount, 0, ',', '.') . ")"; ?></b> </p>



        </div>

        <div class="footer">
          <br>
          <br>
          <br>
          <span>Demikian berita acara ini dibuat dengan sebenar - benarnya.</span>
          <br>
          <br>

        </div>

        <div class="ttd1">
          <span><br></span><br>
          <span>PIHAK KEDUA,</span><br>
          <span>PT. Magenta Mediatama</span><br>
          <br>
          <br>
          <br>
          <span><?php echo  $bast->pic_magenta ?></span><br>
          <hr style="width: 100%;height: 1px; color: black"><br>
          <span><?php echo $bast->pic_magenta_position; ?></span>


        </div>
        <div border="1" class="ttd2">
          <span>Mengetahui :<br></span><br>
          <span>PIHAK PERTAMA,</span><br>
          <span><?php echo  $bast->v2SalesOrderItem->picEvent->customer->name; ?></span><br>
          <br>
          <br>
          <br>
          <span><?php echo $bast->pic_event ?></span><br>
          <hr style="width: 40%;height: 1px; color: black;text-align: left;background-color: black"><br>
          <span><?php echo $bast->pic_event_position ?></span>


        </div>





      </div>
      <br>
      <br>
      <br>
  </div>






  </section>

  <?php


  function penyebut($nilai)
  {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
      $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
      $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
  }

  function terbilang($nilai)
  {
    if ($nilai < 0) {
      $hasil = "minus " . trim(penyebut($nilai));
    } else {
      $hasil = trim(penyebut($nilai));
    }
    return $hasil;
  }
  //Fungsi ambil tanggal aja
  function tgl_aja($tgl_a)
  {
    $tanggal = substr($tgl_a, 8, 2);
    return $tanggal;
  }

  //Fungsi Ambil bulan aja
  function bln_aja($bulan_a)
  {
    $bulan = getBulan(substr($bulan_a, 5, 2));
    return $bulan;
  }

  //Fungsi Ambil tahun aja
  function thn_aja($thn)
  {
    $tahun = substr($thn, 0, 4);
    return $tahun;
  }

  //Fungsi konversi tanggal bulan dan tahun ke dalam bahasa indonesia
  function tgl_indo($tgl)
  {
    $tanggal = substr($tgl, 8, 2);
    $bulan = getBulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
  }
  //Fungsi konversi nama bulan ke dalam bahasa indonesia
  function getBulan($bln)
  {
    switch ($bln) {
      case 1:
        return "Januari";
        break;
      case 2:
        return "Februari";
        break;
      case 3:
        return "Maret";
        break;
      case 4:
        return "April";
        break;
      case 5:
        return "Mei";
        break;
      case 6:
        return "Juni";
        break;
      case 7:
        return "Juli";
        break;
      case 8:
        return "Agustus";
        break;
      case 9:
        return "September";
        break;
      case 10:
        return "Oktober";
        break;
      case 11:
        return "November";
        break;
      case 12:
        return "Desember";
        break;
    }
  }


  ?>
  <script type="text/javascript">
    $("#bastMainNav").addClass('active');

    $("#openBastNav").addClass('menu-open');
    window.addEventListener("load", window.print());
  </script>