<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Resume Pendaftaran Online</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="print">
    *{
      font-family: 'Times New Roman', Times, serif !important
    }
    @page {
          font-family: 'Times New Roman', Times, serif !important
          width: 8cm;
          /* margin-left: 2.5cm; */
          /* margin-top: 0.1cm; */
          height: 2.5;
          font-size: 8pt;
          size: landscape;
      }
      .box{
        width: 7.5cm;
        height: 2 cm;
        margin: 0.2cm;
        margin-bottom: 0.3cm;
      }
      #content {
        display: table;
      }
    </style>

  </head>
  <body onload="print()">
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
          <td style="width:100px;font-weight:bold;">Kode Booking</td><td>:</td> <td>{{$data->nomorantrian}}</td>
        </tr>
        {{-- <tr>
          <td style="width:100px;font-weight:bold;">ANTRIAN POLI</td><td>:</td> 
          <td><b>
            {{@\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->poli->kelompok }}{{ @\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->nomor }}
          </b></td>
        </tr> --}}
        {{-- <tr>
          <td style="width:100px;font-weight:bold;">Angka Antrian<td><td style="width:20px;">:</td> <td><b>{{$data->angkaantrian}}</b></td>
        </tr> --}}
        <tr>
          <td style="width:50px;font-weight:bold;">Nama</td><td style="width:10px;">:</td> <td>{{$nama_pasien}}</td>
        </tr>
        <tr>
          <td style="width:50px;font-weight:bold;">RM</td><td style="width:20px;">:</td> <td>{{$data->no_rm}}</td>
        </tr>
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">NIK<td><td style="width:20px;">:</td> <td>{{$data->nik}}</td>
        </tr> --}}
        <tr>
          <td style="width:50px;font-weight:bold;">Tgl.Periksa</td><td style="width:20px;">:</td> <td>{{date('d-m-Y',strtotime($data->tglperiksa))}}</td>
        </tr>
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">Alamat<td><td style="width:20px;">:</td> <td>{{$data->alamat}}</td>
        </tr> --}}
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">No.HP<td><td style="width:20px;">:</td> <td>{{$data->no_hp}}</td>
        </tr> --}}
        {{-- @if ($data->jenis_registrasi !=='pasien_baru')
          <tr>
            <td style="width:50px;font-weight:bold;">No. RM<td><td style="width:20px;">:</td> <td>{{$data->no_rm}}</td>
          </tr>
        @endif --}}
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">No.Kartu<td><td style="width:20px;">:</td> <td>{{$data->nomorkartu}}</td>
        </tr> --}}
        <tr>
          <td style="width:50px;font-weight:bold;">Poli</td><td style="width:20px;">:</td> <td><b style="font-size:15px;">{{@baca_kode_poli(@$data->kode_poli)}}</b></td>
        </tr>

        @if ($data->status == 'checkin')
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">Status<td><td style="width:20px;">:</td> <td><b style="color:blue">SUDAH CHECKIN</b></td>
        </tr> --}}
        {{-- {{dd($data->registrasi)}} --}}
        <tr>
          <td style="width:50px;font-weight:bold;">KODE BPJS</td><td style="width:20px;">:</td> <td><b style="color:green;font-size:25px;">
            {{substr(@$data->nomorantrian,8,6)}}
            {{-- {{@\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->poli->bpjs }}{{ @\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->nomor }} --}}
            {{-- {{ @\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->nomor }} --}}
            {{-- {{@\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->kelompok }}{{ @\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->nomor }} --}}
          </b></td>
        </tr>
        @endif
        
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
          <td style="width:100px;font-weight:bold;">Kode Booking</td><td>:</td> <td>{{$data->nomorantrian}}</td>
        </tr>
        {{-- <tr>
          <td style="width:100px;font-weight:bold;">ANTRIAN POLI</td><td>:</td> 
          <td><b>
            {{@\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->poli->kelompok }}{{ @\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->nomor }}
          </b></td>
        </tr> --}}
        {{-- <tr>
          <td style="width:100px;font-weight:bold;">Angka Antrian<td><td style="width:20px;">:</td> <td><b>{{$data->angkaantrian}}</b></td>
        </tr> --}}
        <tr>
          <td style="width:50px;font-weight:bold;">Nama</td><td style="width:10px;">:</td> <td>{{$nama_pasien}}</td>
        </tr>
        <tr>
          <td style="width:50px;font-weight:bold;">RM</td><td style="width:20px;">:</td> <td>{{$data->no_rm}}</td>
        </tr>
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">NIK<td><td style="width:20px;">:</td> <td>{{$data->nik}}</td>
        </tr> --}}
        <tr>
          <td style="width:50px;font-weight:bold;">Tgl.Periksa</td><td style="width:20px;">:</td> <td>{{date('d-m-Y',strtotime($data->tglperiksa))}}</td>
        </tr>
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">Alamat<td><td style="width:20px;">:</td> <td>{{$data->alamat}}</td>
        </tr> --}}
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">No.HP<td><td style="width:20px;">:</td> <td>{{$data->no_hp}}</td>
        </tr> --}}
        {{-- @if ($data->jenis_registrasi !=='pasien_baru')
          <tr>
            <td style="width:50px;font-weight:bold;">No. RM<td><td style="width:20px;">:</td> <td>{{$data->no_rm}}</td>
          </tr>
        @endif --}}
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">No.Kartu<td><td style="width:20px;">:</td> <td>{{$data->nomorkartu}}</td>
        </tr> --}}
        <tr>
          <td style="width:50px;font-weight:bold;">Poli</td><td style="width:20px;">:</td> <td><b style="font-size:15px;">{{@baca_kode_poli(@$data->kode_poli)}}</b></td>
        </tr>

        @if ($data->status == 'checkin')
        {{-- <tr>
          <td style="width:50px;font-weight:bold;">Status<td><td style="width:20px;">:</td> <td><b style="color:blue">SUDAH CHECKIN</b></td>
        </tr> --}}
        {{-- {{dd($data->registrasi)}} --}}
        <tr>
          <td style="width:50px;font-weight:bold;">KODE BPJS</td><td style="width:20px;">:</td> <td><b style="color:green;font-size:25px;">
            {{substr(@$data->nomorantrian,8,6)}}
            {{-- {{@\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->poli->bpjs }}{{ @\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->nomor }} --}}
            {{-- {{ @\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->nomor }} --}}
            {{-- {{@\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->kelompok }}{{ @\App\Models\AntrianPoli::where('id',@$data->registrasi->antrian_poli_id)->first()->nomor }} --}}
          </b></td>
        </tr>
        @endif
        
      </table>


      {{-- <table class="table table-condensed" style="width:100%">
        <tr>
          <td class="text-center" colspan="2">
            <h5>Antrian Pendaftaran Rawat Jalan</h5>
            <h4 style="font-size:13pt; font-weight:bold; margin-top: -5px;">{{ @configrs()->nama }}</h4>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-center">
              <b>
                ANTRIAN RAWAT JALAN
              </b>
            <br>
            <p>Nomor Antrian Anda:</p>
            <p style="font-size: 70pt; margin-top: -30px; margin-bottom: -20px">
              {{ @$antrian->kelompok }}{{ @$antrian->nomor }}
            </p>
            <p>
              {{ date('d-m-Y H:i:s' ) }}
              <br>
            </p>
          </td>
        </tr>
      </table>  --}}
      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('/') }}">
  </body>
</html>
