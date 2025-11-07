<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Etiket</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    <style media="screen">
      body{
        font-size: 4pt;
        /* margin-top: 10px;
        margin-left: 10px; */
      }
      .table{
        width: 5cm;
        text-align: left;
        height: 3.5cm;
        /* margin-bottom: 1cm; */
         line-height:0.5;
      
      }
    </style>
  </head>

  @isset($penjualan->id)
  @php
    $det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->get();
    $no =1;
  @endphp

  @foreach ($det as $key => $d)
  <body>
  {{-- <body onload="print()"> --}}
    {{-- <div> --}}
      {{-- <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive" style="width:20px;position: absolute;margin-top:-10px;  "> --}}
      {{-- <p style="font-size:5pt;"><b>{{ strtoupper(configrs()->nama) }}</b></p> --}}
      {{-- <p style="font-size:5pt;"><b>{{ configrs()->alamat }} {{ configrs()->tlp }} {{ configrs()->kota }}</b></p> --}}
    {{-- </div> --}}
    <table class="table">
      <tr>
        <th  style="text-align: center" colspan="2">
          {{ config('app.nama') }}
        </th>
      </tr>
      <tr>
        <th style="text-align: center" colspan="2">Apoteker:  ( {{ \App\User::find($penjualan->user_id)->name }} )</th>
      </tr>
        <tr>
          <th>Nama Pasien</th>
          <td>: {{ strtoupper(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->nama) }}</td>
        </tr>
        <tr>
          <th>Tanggal Lahir</th>
          <td>: {{ tgl_indo(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->tgllahir) }} </td>
        </tr>
        <tr>
          <th>Nama Obat</th>
          <td>: </td>
        </tr>
        <tr>
          <th>No. RM</th>
          <td>: {{ \Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->no_rm }}</td>
        </tr>
        <tr>
          <th colspan="2" style="font-size:8pt; text-align:center;"> {{ $d->etiket }}</th>
        </tr>
        <tr>
          <th>Pagi</th>
          <td>: 07.00 - 08.00</td>
        </tr>
        <tr>
          <th>Siang</th>
          <td>: 13.00 - 14.00 </td>
        </tr>
        <tr>
          <th>Malam</th>
          <td>: 19.00 - 20.00</td>
        </tr>
        <tr>
          <th colspan="2">Tgl Kadaluarsa: {{ expiredobat($d->logistik_batch_id) }}</th>
        </tr>
    </table>

          {{-- <div class="etiket">
            <h5 class="text-center" style="font-weight: bold; margin-bottom: 8px;">{{ configrs()->nama }} <br> {{ configrs()->alamat }} </h5>
            <div class="row">
              <div class="col-md-5">
                Tgl Lhr: {{ tgl_indo(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->tgllahir) }} <br>
                No. RM: {{ \Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->no_rm }}
              </div>
              <div class="col-md-7 text-right">
                Tgl:{{ tgl_indo(date("Y-m-d")) }} <br>
                {{ baca_dokter(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->dokter_id) }}
              </div>
            </div>

             <div class="text-center" style="margin-top: 10px;">
               <b>{{ strtoupper(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->pasien->nama) }}</b> <br>
             </div>
             <p class="text-center"> {{ $d->etiket }} <br>{{ $d->informasi1 }} <br>{{ $d->informasi2 }} </p>
             <div class="row">
               <div class="col-md-6">
                 {{ strtoupper($d->masterobat->nama) }}
               </div>
               <div class="col-md-6 text-right">
                 Exp: {{ $d->expired }}
               </div>
             </div>
          </div> --}}
  </body>
  @endforeach
  @endisset


</html>
