<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style>
      ._border th{
        /* border-bottom: 1px solid #000; */
        border-top: 1px solid #000;
      }
      ._border td{
        border-bottom: 1px solid #000;
        border-top: 1px solid #000;
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
      @page {
          padding-bottom: 1cm;
      }

      .footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 1cm;
        text-align: justify;
      }
    </style>
  </head>
  <body>
    
    <table border=0 style="width: 100%;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: center">
          <b style="font-size:15px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
        </td>
      </tr>
    </table>
    <hr>
    <br>
    <table style="width: 100%;">
      <tbody style="font-size: 8pt; ">
        <tr>
          <td style="font-size:15px; font-weight:bold; text-align:center;" colspan="4">DAFTAR KONTROL ISTIMEWA<br></td>
        </tr>
        <tr>
          <td style="font-size:15px; font-weight:bold; text-align:center;" colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td style="width: 15%">NAMA PASIEN</td> <td style="font-size: 11px;">: {{ @$pasien->nama }} </td>
          <td style="width: 15%">UMUR</td>  <td style="font-size: 11px;">: {{ hitung_umur(@$pasien->tgllahir) }} </td>
        </tr>
        <tr>
          <td style="width: 15%">NO RM</td> <td style="font-size: 11px;">: {{ @$pasien->no_rm }} </td>
          <td style="width: 15%">TGL. MASUK</td> <td style="font-size: 11px;">: {{ date('d/m/Y H:i', strtotime(@$reg->created_at)) }} </td>
        </tr>
        <tr>
          <td style="width: 15%">DIAGNOSA</td> <td colspan="3" style="font-size: 11px;">: {{ baca_icd10(@$histori->latest_icd10) }} </td>
        </tr>
      </tbody>
    </table>
    <br>
    
    <table style="width: 100%;" border="0">
      <thead style="font-size: 8pt; ">
        <tr class="_border">
          <th class="text-left" style="vertical-align: middle; width:10%;">Tanggal</th>
          <th class="text-center" style="vertical-align: middle;">SPO2</th>
          <th class="text-center" style="vertical-align: middle;">Tensi</th>
          <th class="text-center" style="vertical-align: middle;">Nadi</th>
          <th class="text-center" style="vertical-align: middle;">Respirasi<br>(x/menit)</th>
          <th class="text-center" style="vertical-align: middle;">Suhu<br>(c)</th>
          <th class="text-center" style="vertical-align: middle;">Tindakan <br>therapi</th>
          <th class="text-center" style="vertical-align: middle;">Intake <br>(cc)</th>
          <th class="text-center" style="vertical-align: middle;">Output <br>(cc)</th>
          <th class="text-center" style="vertical-align: middle;">Ket</th>
        </tr>
      </thead>
      <tbody style="font-size: 8pt; ">
        @if (count($riwayats_kontrol_istimewa) == 0)
            <tr class="_border">
                <td colspan="11" class="text-center">Tidak Ada Riwayat Kontrol Istimewa</td>
            </tr>
        @endif
        @foreach ($riwayats_kontrol_istimewa as $riwayat)
        @php
          @$daftar_kontrol_istimewa = @json_decode(@$riwayat->fisik)->daftar_kontrol_istimewa;
        @endphp
              <tr class="_border">
                <td style="text-align: left; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                    {{@Carbon\Carbon::parse(@$daftar_kontrol_istimewa->tanggal)->format('d-m-Y')}}
                </td>
                <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->spo2}}
                </td>
                <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->tensi}}
                </td>
                <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->nadi}}
                </td>
                <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->respirasi}}
                </td>
                <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->suhu}}
                </td>
                <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->tindakan_therapi}}
                </td>
                <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->intake}}
                </td>
                <td style="text-align: center; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->output}}
                </td>
                <td style="text-align: left; {{ $riwayat->id == request()->daftar_kontrol_istimewa_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                  {{@$daftar_kontrol_istimewa->keterangan}}
                </td>
            </tr>
        @endforeach
      
      </tbody>
    </table>
    
  </body>
</html>