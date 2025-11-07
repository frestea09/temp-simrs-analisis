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
         @php $kat = 0; @endphp
        @foreach($hasillabs as $labs)
  <body style="padding-left:30px; padding-right:0px;">
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
      <table style="width: 100%;padding-left:30px;">
        <tbody style="font-size: 8pt; ">
          <tr>
            <th style="width: 17%">No. RM</th> <td>: {{ $registrasi->pasien->no_rm }}</td>
            <th>Tgl Lahir / Kelamin</th> <td>: {{ tgl_indo($registrasi->pasien->tgllahir) }} / {{ $registrasi->pasien->kelamin }}</td>
          </tr>
          <tr>
            <th>Nama Pasien</th> <td>: {{ $registrasi->pasien->nama }}</td>
            <th style="width: 17%">Dokter Pengirim</th> <td style="font-size: 11px;">: {{ baca_dokter($hasillab->dokter_id) }} </td>
          </tr>
          <tr>
            <th>Ruang</th> 
            <td>: 
              @if (substr($registrasi->status_reg,0,1) == 'G' || substr($registrasi->status_reg,0,1) == 'J')
              {{ baca_poli($registrasi->poli_id) }}
              @elseif ($registrasi->status_reg == 'I1')
              Antrian Rawat Inap
              @elseif ($registrasi->status_reg == 'I2')
              {{ baca_kamar(\App\Rawatinap::where('registrasi_id',$registrasi->id)->first()->kamar_id) }}
              @endif
            </td>
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
            @php $rincian = App\RincianHasillab::where(['hasillab_id' => $labs->id])->get(); @endphp
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
         <i> PENGAMBILAN: {{ date('d-M-Y',  strtotime($labs->tgl_hasilselesai))}} {{ $labs->jam }}</i>
        </p>
        {{-- <i style="padding-left:30px;">Dicetak pada: {{ date('d-M-Y H:i:s') }}</i>  --}}
      <br>
      <br>
         <div class="text-center" style="padding: 5px; float:right;">
          {{ config('app.kota') }}, {{ date('d-M-Y',  strtotime($labs->tgl_hasilselesai))}}
          <br>
          <br>
          <br>
          <br>
            <u>AMILA MUSTAM, AMAK</u><br>
          <hr>
        </div>
  </body>
        @endforeach

</html>