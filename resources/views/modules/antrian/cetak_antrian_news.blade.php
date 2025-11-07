<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Antrian</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">

  </head>
  {{-- <body> --}}
  <body onload="print()" style="margin:0;">

          {{-- <table class="table  table-condensed">
            <tr>
              <td class="text-center" colspan="2">
                <h5>Antrian Pendaftaran Rawat Jalan</h5>
                <h4 style="font-size:13pt; font-weight:bold; margin-top: -5px;">{{ configrs()->nama }}</h4>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">
                  <b>
                    ANTRIAN RAWAT JALAN
                  </b>
                <br>
                <p>Nomor Antrian Anda:</p>
                <p style="font-size: 65pt; margin-top: -30px; margin-bottom: -20px">
                  {{ $kelompok }}{{ $nomor }}<br/>
                </p>
                @if (@$antrian_polis)
                <p style="font-size: 14pt;">
                  Antrian Poli : <b>{{@$antrian_polis->kelompok}}{{@$antrian_polis->nomor}}</b>
                </p>
                @endif
                {{@baca_poli(@$poli_id)}}
                <p>

                  {{ date('d-m-Y H:i:s' ) }}
                  <br>
                </p>

              </td>
            </tr>
          </table>
          <br> --}}
          <table style="width:100%;">
            <tr>
              <td style="width: 50%">
                {{-- <img src="{{asset('/images/'.$config->logo)}}" style="width: 50px;float:left;margin-right:30px;" alt=""> --}}
                <p style="color:red">{{config('app.nama')}}</p>
                {{-- <p style="color:green">{{config('app.alamat')}}</p> --}}
              </td>
              <td class="text-right" style="width: 50%;color:green">RESUME RESERVASI PASIEN</td>
            </tr>
          </table>
        <div class="box">
          <div class="text-left">
          </div>
        </div>
        <hr/>
        <table style="width:100%" cellpadding="5">
            <tr>
               <td style="width:50px;font-weight:bold;">Nama</td><td style="width:10px;">:</td> <td>{{ $pasien->nama }}</td>
            </tr>
            <tr>
               <td style="width:50px;font-weight:bold;">RM</td><td style="width:20px;">:</td> <td>{{ $pasien->no_rm }}</td>
            </tr>
            <tr>
               <td style="width:50px;font-weight:bold;">Tgl.Periksa</td><td style="width:20px;">:</td> <td>{{ date('d-m-Y', strtotime($tanggal)) }}</td>
            </tr>
            <tr>
               <td style="width:50px;font-weight:bold;">Poli</td><td style="width:20px;">:</td> <td><b style="font-size:15px;">{{@baca_poli(@$poli_id)}}</b></td>
            </tr>
            <tr>
               <td style="width:50px;font-weight:bold;">Nomor Antrian</td><td style="width:20px;">:</td> <td><b style="color:green;font-size:25px;">
                  {{$antrian_polis->kelompok}}{{$antrian_polis->nomor}}
                  </b>
               </td>
            </tr>
         </table>
        <br/>
        <br/>
        <table style="width:100%;">
          <tr>
            <td style="width: 50%">
              {{-- <img src="{{asset('/images/'.$config->logo)}}" style="width: 50px;float:left;margin-right:30px;" alt=""> --}}
              <p style="color:red">{{config('app.nama')}}</p>
              {{-- <p style="color:green">{{config('app.alamat')}}</p> --}}
            </td>
            <td class="text-right" style="width: 50%;color:green">RESUME RESERVASI PASIEN</td>
          </tr>
        </table>
      <div class="box">
        <div class="text-left">
        </div>
      </div>
      <hr/>
      <table style="width:100%" cellpadding="5">
         <tr>
            <td style="width:50px;font-weight:bold;">Nama</td><td style="width:10px;">:</td> <td>{{ $pasien->nama }}</td>
         </tr>
         <tr>
            <td style="width:50px;font-weight:bold;">RM</td><td style="width:20px;">:</td> <td>{{ $pasien->no_rm }}</td>
         </tr>
         <tr>
            <td style="width:50px;font-weight:bold;">Tgl.Periksa</td><td style="width:20px;">:</td> <td>{{ date('d-m-Y', strtotime($tanggal)) }}</td>
         </tr>
         <tr>
            <td style="width:50px;font-weight:bold;">Poli</td><td style="width:20px;">:</td> <td><b style="font-size:15px;">{{@baca_poli(@$poli_id)}}</b></td>
         </tr>
         <tr>
            <td style="width:50px;font-weight:bold;">Nomor Antrian</td><td style="width:20px;">:</td> <td><b style="color:green;font-size:25px;">
               {{$antrian_polis->kelompok}}{{$antrian_polis->nomor}}
               </b>
            </td>
         </tr>
        
      </table>

      <META HTTP-EQUIV="REFRESH" CONTENT="2; URL=http://172.168.1.175:8000/v2">
      <!-- <META HTTP-EQUIV="REFRESH" CONTENT="2; URL=http://daftar-online.test/v2"> -->

  </body>
</html>
