<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style>
      ._border td{
        border-bottom: 1px dashed #000;
        border-top: 1px dashed #000;
      }
      body{
        font-size: 10pt;  
      }
      hr{ 
        display: block;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
        /* margin-left: auto;
        margin-right: auto; */
        border-style: inset;
        border-width: 1px;
        padding-left: :30px;
      } 
    </style>
  </head>
  <body style="padding-left:25px; padding-right:0px;" >
    <div>
      <div>
          <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive" style="width: 70px;position: absolute;margin-top:-10px;padding-left:120px">
          <h6 class="text-center" style="font-size: 17pt; font-weight: bold; margin-top: -5px;">{{ strtoupper(configrs()->nama) }}</h6>
          <h4 class="text-center" style="font-weight: bold; margin-top: -5px; margin-bottom: -1px;">INSTALASI LABORATORIUM</h4>
          <p class="text-center">{{ configrs()->alamat }} {{ configrs()->tlp }} {{ configrs()->kota }}</p>
          <div style="padding-left:20px">
            <hr>
          </div>
      </div>
    </div>
    <br>
        <table style="width: 100%;padding-left:25px;">
        <tbody style="font-size: 8pt; ">
          <tr>
            <th>Nama Pasien</th> <td>: {{ $pasien->nama }}</td>
          </tr>
          <tr>
            <th style="width: 17%">Dokter Pemeriksa</th> <td style="font-size: 11px;">: {{ baca_dokter($hasillab->penanggungjawab) }}</td>
          </tr>

        </tbody>
      </table>
      <br>
      <p style="padding-left:20px;">
        =======================================================================================
      </p>
      <table style="width:100%; padding-left:30px;">
        <thead>
          <tr>
            <th class="">PEMERIKSAAN</th>
            <th class="text-center" style="padding-right:50px;">HASIL</th>
            {{-- <th class="text-center">PENGAMBILAN</th> --}}
            <th class="text-center" style="padding-right:50px;">STANDART</th>
            <th class="text-center" style="padding-right:50px;">SATUAN</th>
          </tr>
        </thead>

        <tbody>
          @php $kat = 0; @endphp
            @foreach ($rincian as $item)
              @if($item->labkategori_id != $kat)
              <tr class="_border">
                <td colspan="5" style="padding-top:10px;"> <b> {{ App\Labkategori::where('id',$item->labkategori_id)->first()->nama }}</b></td>
              </tr>
              @else
                =
              @endif

              @if($kat != 0 && $item->labkategori_id != $kat)
              <tr class="">
               <td>{{ $item->laboratoria->nama }}</td>
              @else
              <tr>
                <td>{{ $item->laboratoria->nama }}</td>
              @endif
              <td class="text-center" style="padding-right:50px;">{{ $item->hasil }}</td>
              <td class="text-center" style="padding-right:50px;">{{ $item->laboratoria->nilairujukanbawah }} - {{ $item->laboratoria->nilairujukanatas }}</td>
              <td class="text-center" style="padding-right:50px;">{{ $item->laboratoria->satuan }}</td>
            </tr>
                @php $kat = $item->labkategori_id; @endphp
            @endforeach
        </tbody>
      </table>
      
      <p style="padding-left:20px;">
        =======================================================================================
      </p>
      <br> <br>
        
        <p style="padding-left:30px;">
         <i> PENGAMBILAN: {{ date('d-M-Y',  strtotime($hasillab->tgl_hasilselesai))}} {{ $hasillab->jam }}</i>
        </p>
        <i style="padding-left:30px;">Dicetak pada: {{ date('d-M-Y H:i:s') }}</i> 
      <br>
      <br>
         <div class="text-center" style="padding: 5px; float:right;">
          {{ config('app.kota') }}, {{ date('d-M-Y',  strtotime($hasillab->tgl_hasilselesai))}}
          <br>
          <br>
          <br>
          <br>
          <u>{{ Auth::user()->name }}</u><br>
          {{-- SIP {{ $dokter->sip }} --}}
          <hr>
        </div>
  </body>
</html>