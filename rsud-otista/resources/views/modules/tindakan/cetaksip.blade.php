<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak SIP</title>
    <!-- Bootstrap 3.3.7 -->
    {{--<link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">--}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
    <style type="text/css">
    @page {
          margin-top: 1cm;
          margin-left: 3cm;
          margin-right: 3cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }
   

    </style>
  </head>
  <body onload="print()">
     <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">SURAT IZIN PULANG PASIEN</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
 
          <table border=0 class="table table-borderless" style="text-align:start;" >
            <tr>
              <td>NOMOR</td> 
              <td style="padding-left:28px">: {{ @$reg->reg_id }}-{{@$reg->id}}</td>
            </tr>

            {{-- <tr>
              <td>Kepada Yth</td> 
              <td td style="padding-left:28px">: Kp Satpam</td>
            </tr> --}}

            <tr>
              <td>Kepala Ruangan</td> 
              <td td style="padding-left:28px">: {{ @$ranap->kamar->nama }}</td>
            </tr>

            <tr>
              <td>Nama Pasien</td> <td style="padding-left:28px">: {{ @$reg->pasien->nama }} </td>
            </tr>

            <tr>
              <td>No. RM</td> <td style="padding-left:28px">: {{ @$reg->pasien->no_rm }}</td>
            </tr>
            
            <tr>
              <td>Diizinkan Pulang Tgl</td> <td style="padding-left:28px">: {{ \Carbon\Carbon::parse(@$ranap->tgl_keluar)->format('d-m-Y') }}</td>
            </tr>
            <tr>
              <td>Cara Pulang</td>
              <td style="padding-left:28px">: {{ @$reg->kondisiAkhir->namakondisi }}</td>
            </tr>
            <tr>
              <td>Jumlah Pembayaran</td>
              <td style="padding-left:28px">
                @if (@$sip->pembayaran)
                  : Rp. {{ number_format(@$sip->pembayaran) }}
                @else
                  @if(@$reg->bayar == 1)
                    : Rp. 0
                  @else
                    : Rp. {{number_format(@$pembayaran->dibayar)}}
                  @endif
                @endif
              </td>
            </tr>
            <tr>
              @if (@$reg->bayar == 1)
              <td>Ditanggung Oleh</td> 
              <td style="padding-left:28px">: {{baca_carabayar(@$reg->bayar).' - '.$reg->tipe_jkn}}</td>
              @else
              <td>Cara Bayar</td> 
              <td style="padding-left:28px">: {{baca_carabayar(@$reg->bayar)}}</td>
              @endif
            </tr>
            <tr>
              <td>Status</td>
              <td style="padding-left:28px">: {{ @$sip->status ?? '-' }}</td>
            </tr>
            {{-- <tr>
              <td>No. Kwit</td>
              <td style="padding-left:28px">: {{@$pembayaran->no_kwitansi}}</td>
            </tr>
            <tr>
              <td>No. Kartu / SEP</td>
              <td style="padding-left:28px">: {{ $reg->no_sep }}</td>
            </tr> --}}
        
  </table>


  <table style="width: 100%">
      <td>
        <br><br>
        Keterangan      : <br />
        {{ @$reg->keterangan_sip }} <br /><br/>
        Putih     (Asli): Untuk Ke Satpam <br />
        Pink   (Salinan): Untuk Ke Ruangan <br />
        Kuning (Salinan): Untuk Kasir <br />
      </td>
      
      <td style="text-align: center">
        <br><br>
        Kasir Rawat Inap <br /><br />
        <img src="{{ asset('/images/'. @Auth::user()->pegawai->tanda_tangan) }}" style="width: 60px;" alt="">
        <br><br>
        ( {{ Auth::user()->name }} ) 
      </td>
    </tr>
  </table>

  <p style="padding-left:0px;">
    <i>Dicetak pada: {{ date('d-M-Y H:i:s') }}</i>
  </p>
          
    <br>
        

        <style>

            .footer{
            padding-top: 20px;
            margin-left: 330px;
        }

        .table-border {
        border: 1px solid black;
        border-collapse: collapse;
        }

        </style>
       
      </div>
    </div>
    {{--<p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>--}}
    
  </body>
  <script>
    document.designMode = 'on';
  </script>
</html>

