<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Lab : {{$hasillab->no_lab}}</title>
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
  <body>
    {{-- <div>
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
    <br> --}}
    <table border=0 style="width: 100%;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        {{-- <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
        </td> --}}
      </tr>
    </table>
    <hr>
    <br>
      <table style="width: 100%;padding-left:30px;">
        <tbody style="font-size: 8pt; ">
          <tr>
            <th style="width: 17%">No. LAB</th> <td>: {{ @$hasillab->no_lab }}</td>
            <th>Tgl Lahir / Kelamin</th> <td>: {{ isset($registrasi->pasien->tgllahir) ? tgl_indo($registrasi->pasien->tgllahir) : '-' }} / {{ isset($registrasi->pasien->kelamin) ? $registrasi->pasien->kelamin : '-' }}</td>
            {{-- <th>Tgl Lahir / Kelamin</th> <td>: {{ isset($registrasi->pasien->tgllahir) ? tgl_indo($registrasi->pasien->tgllahir) : '-' }} / {{ isset($registrasi->pasien->kelamin) ? $registrasi->pasien->kelamin : '-' }}</td> --}}
          </tr>
          <tr>
            <th style="width: 17%">No. RM</th> <td>: {{ isset($registrasi->pasien->no_rm) ? $registrasi->pasien->no_rm : '-' }}</td>
            <th style="width: 17%">Dokter Pengirim</th> <td style="font-size: 11px;">: {{ baca_dokter($hasillab->dokter_id) }} </td>
          </tr>
          <tr>
            <th>Nama Pasien</th> <td>: {{ isset($registrasi->pasien->nama) ? $registrasi->pasien->nama : '-' }}</td>
            <th style="width: 17%">Dokter Pemeriksa</th> <td style="font-size: 11px;">: {{ baca_dokter($hasillab->penanggungjawab) }}</td>
          </tr>
          <tr>
            <th>Alamat</th> <td>: {{ isset($registrasi->pasien->alamat) ? $registrasi->pasien->alamat : '-' }}</td>
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
          </tr>
          <tr>
          </tr>

        </tbody>
      </table>
      <br>
      <p style="padding-left:20px;">
        ===========================================================================================
      </p>
      <table style="width:100%; padding-left:30px;">
        <thead>
          <tr>
            <th class="">PEMERIKSAAN</th>
            <th class="text-center" style="padding-right:50px;">HASIL</th>
            <th class="text-center" style="padding-right:50px;">SATUAN</th>
            <th class="text-center" style="padding-right:50px;">NILAI RUJUKAN</th>
            <th class="text-center" style="padding-right:50px;">KET</th>
          </tr>
        </thead>

        <tbody>
          @php $kat = 0; @endphp
          @foreach ($lis as $group_name => $item)
          {{-- @if($item->labkategori_id != $kat) --}}
          <tr class="_border">
            <td colspan="5" style="padding-top:10px;"> <b> {{$group_name}}</b></td>
          </tr>
          
          @foreach ($item as $lab)
            <tr>
              <td>{{ $lab['test_name'] }}</td>
              <td class="text-center" style="padding-right:50px;">{{ $lab['result'] }}</td>
              <td class="text-center" style="padding-right:50px;">{{ $lab['unit'] }}</td>
              <td class="text-center" style="padding-right:50px;">{{ $lab['nilai_normal'] }}</td>
              <td class="text-center" style="padding-right:50px;">{{ $lab['flag'] }}</td>
            </tr>
             @if (@$lab['report_critical'])
                  <tr>
                    <td colspan="4">{{@$lab['report_critical']}}</td>
                  </tr>
              @endif
          @endforeach
           
        @endforeach
        </tbody>
      </table>
      
      <p style="padding-left:20px;">
        ===========================================================================================
      </p>
      <br> <br>
        {{-- <p style="padding-left:30px;">
        <i> HASIL KELUAR: {{ @$labs->jamkeluar }} </i>, <i> PENGAMBILAN: {{ date('d-M-Y',  strtotime(@$labs->tgl_hasilselesai))}} {{ @$labs->jam }}</i>
       </p>
        <p style="padding-left:0px;">
          <i style="padding-left:30px;">Dicetak pada: {{ date('d-M-Y H:i:s') }}</i>
        </p> --}}
       
        {{-- <i style="padding-left:30px;">Dicetak pada: {{ date('d-M-Y H:i:s') }}</i>  --}}
      <br>
      <br>
         {{-- <div class="text-center" style="padding: 5px; float:right;">
          {{ config('app.kota') }}, {{ date('d-M-Y',  strtotime($labs->tgl_hasilselesai))}}
          <br>
          <br>
          <br>
          <br>
         <u>{{ Auth::user()->name}}</u><br>
          <hr>
        </div> --}}

        <table border=0 style="width:100%">
          <tr>
              <td colspan="4" scope="row" style="width:200px;padding-left:20px"><b>Pesan :</b> @if($hasillab->pesan ){{ $hasillab->pesan }} @else <i> tidak ada pesan </i> @endif</td>
              <td style="text-align:left;"></td>
              <td style="text-align:left;"></td>
              <td style="text-align:left;"></td>
              <td style="text-align:left;"><br><br></td>
          </tr>
      
          <tr>
              <td colspan="4" scope="row" style="width:200px;padding-left:20px"><b>Kesan :</b> @if($hasillab->kesan ){{ $hasillab->kesan }} @else <i> tidak ada kesan </i> @endif</td>
              <td style="width:140px;text-align:center;"></td>
              <td style="width:140px;text-align:center;width:170px;"></td>
              <td style="width:140px;text-align:center;"></td>
              <td style="width:140px;text-align:center;">{{ config('app.kota') }}, {{ date('d-M-Y',  strtotime(@$labs->tgl_hasilselesai))}}</td>
          </tr>

          <tr>
              <td colspan="4" scope="row" style="width:170px;font-size: 7px;"> </td>
              <td></td>
              <td style="width:140px;text-align:center;width:170px;"></td>
              <td></td>
              <td></td>
          </tr>
          <tr>
          {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
              <td colspan="4" scope="row" style="width:170px;"><br><br><br><br><br></td>
              <td style="width:80px;text-align:center;"></td>
              <td style="width:140px;text-align:center;"></td>
              <td style="width:80px;text-align:center;"></td>
              <td style="width:80px;text-align:center;"><br><br><br><br><br>({{ "Pemeriksa"}})</td>
          </tr>
          <tr>
              <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
              <td></td>
              <td></td>
              <td><div style='margin-top:10px; text-align:center;'></div></td>
          </tr>
  </table>
  </body>
</html>