<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">

  </head>
  <body>
    <div id="header">
      {{-- <center> --}}
        <div class="logo">
          <img src="https://stmadyang.id/assets/upload/image/1572563316logo.jpg" class="img img-responsive" style="float:left;margin-right:40px !important;" width="70px;">
        </div>
      <div class="nama">
        <b style="font-size:20px;">{!! config('app.nama').'&nbsp;'.strtoupper(config('app.kota')) !!}</b> <br> <div class="alamat"> {{ configrs()->pt }} <br> {{ configrs()->alamat }} Tlp. {{ configrs()->tlp }}</div>
      </div>
      <div class="tanggal">
        <script type="text/javascript">
          show_hari();
        </script>
      </div>
    {{-- </center> --}}
    </div>
    <div style="float:none;clear:both;"></div>
    <br>
    <hr/>
    <br>
    {{-- <b>No {{$reg->no_sep ? $reg->no_sep : '-'}}</b> --}}
    <table style="width: 100%">
      <tr>
        <td style="width:25%;">No. Resep</td>
        <td>{{$penjualan->no_resep}}</td>
        <td style="width:10%;">Riwayat Alergi Obat</td>
        <td>:</td>
      </tr>
      <tr>
        <td style="width:10%;">Tanggal</td>
        <td>:&nbsp;&nbsp;{{date('d-m-Y',strtotime($penjualan->created_at))}}</td>
        <td><input type="checkbox"/></td>
        <td>:&nbsp;&nbsp;Tidak</td>
      </tr>
      <tr>
        <td>Apoteker</td>
        <td>:&nbsp;&nbsp;{{@$apoteker->nama}}</td>
        <td><input type="checkbox"/></td>
        <td>:&nbsp;&nbsp;Ya</td>
      </tr>
    </table>
    <br/>

    <center>
      <b>COPY RESEP</b>
    </center>

    {{-- <div style="float:left"> --}}
      <b>R/</b>
      <table style="width: 100%;">
        <tr>
          <td style="width:50%;vertical-align:top">
            <table>
              @foreach ($detail as $d)
              <tr>
                <td>
                  {{@baca_obat($d->masterobat_id)}}[{{$d->jumlah}}]<br/>
                  {{@$d->etiket}}<br/>
                  {{-- {{ $d->jumlah }}x{{ number_format((($d->hargajual+$d->hargajual_kronis)/($d->jumlah+$d->jml_kronis))) }}={{ number_format($d->hargajual_kronis+$d->hargajual+$d->uang_racik) }} --}}
                  {{-- <span style="color:red">exp({{@$d->masterobat->logistik_batch->expireddate}})</span> --}}
                </td>
              </tr>
              @endforeach
            </table>
          </td>
        </tr>
        
      </table> 
    <br>

      
    <table style="width: 100%">
      <tr>
        <td style="width:15%;">PRO</td>
        <td>: {{@$reg->pasien->nama}}</td>
        <td style="width:15%;">No. RM</td>
        <td>:&nbsp;&nbsp;{{@$reg->pasien->no_rm}}</td>
        <td>PCC</td>
      </tr>
      <tr>
        <td>Tgl. Lahir</td>
        <td>: {{date('d-m-Y',strtotime($reg->pasien->tgllahir))}}</td>
        <td>Berat Badan</td>
        <td>:</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>: {{@$reg->pasien->alamat}}</td>
        <td>Ruangan</td>
        <td>:&nbsp;&nbsp;{{@$reg->poli->nama}}</td>
      </tr>
    </table>

    {{-- <table style="width: 100%" border="1" cellspacing="0">
      <tr>
        <td>
          <table border="1" cellspacing="0" style="width: 100%">
            <tr >
              <td class="text-center">
                <p>Nama &amp; Tanda Tangan Dokter<br/><br/><br/><br/><br/>
                  {{baca_dokter($reg->dokter_id)}}
                </p>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table border="1" cellspacing="0" style="width: 100%">
            <tr >
              <td class="text-center">
                <p>Nama &amp; Tanda Tangan Penerima<br/> Obat<br/><br/><br/><br/><br/>
                  (.................................)
                </p>
              </td>
            </tr>
          </table>
        </td>
        <td style="vertical-align: top">
          <table border="1" style="width: 100%;font-size:12px;"  cellspacing="0">
            <tr >
              <td>Validasi</td>
              <td>Nama</td>
              <td>Paraf</td>
            </tr>
            <tr>
              <td>ADM.Kasir</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td>Telah R/</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Pemberian Etiket</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Penyiapan Obat</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Verifikasi Obat</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Penyerahan Obat</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
    </table> --}}
  </body>
</html>
