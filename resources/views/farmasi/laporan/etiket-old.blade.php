<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Etiket</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <style media="screen">
      body{
        font-size: 8pt;
        margin-top: 10px;
        margin-left: 10px;
      }
      .etiket{
        width: 8cm;
        height: 5cm;
        margin-bottom: 1cm;
      }
    </style>
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="{{ $det->count() }}; URL={{ url('penjualan') }}"> --}}
  </head>
  <body onload="print()">
      @isset($penjualan->id)
        @php
          $det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->get();
          $no =1;
        @endphp

        @foreach ($det as $key => $d)
          <div class="etiket">
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



          </div>

        @endforeach

        {{-- @if (URL::previous() == url('farmasi/laporan/penjualan'))
          <META HTTP-EQUIV="REFRESH" CONTENT="{{ $det->count() }}; URL={{ URL::previous() }}">
        @else
          @if ( substr(\Modules\Registrasi\Entities\Registrasi::find($penjualan->registrasi_id)->status_reg,0,1) == 'I' )
            <META HTTP-EQUIV="REFRESH" CONTENT="{{ $det->count() }}; URL={{ url('penjualan/irna') }}">
          @else
            <META HTTP-EQUIV="REFRESH" CONTENT="{{ $det->count() }}; URL={{ url('penjualan') }}">
          @endif
        @endif --}}

      @endisset



  </body>
</html>
