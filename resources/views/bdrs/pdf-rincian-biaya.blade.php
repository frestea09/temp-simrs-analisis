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
    <table border=0 style="width: 100%;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:17px;">PATOLOGI ANATOMY</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
        </td>
      </tr>
    </table>
    <hr>
    <table style="width: 100%;padding-left:25px;">
      <tbody style="font-size: 8pt; ">
        <tr>
          <th style="width: 17%">No Sample</th> <td style="font-size: 11px;">: {{ $bdrs->no_sample }} </td>
        </tr>
        <tr>
          <th style="width: 17%; vertical-align: top;">Tindakan</th> <td style="font-size: 11px;">: @foreach ($bdrs->detail as $detail) - {{$detail->namatarif}} <br>@endforeach </td>
        </tr>
        <tr>
          <th style="width: 17%">Dokter</th> <td style="font-size: 11px;">: {{ @baca_dokter($bdrs->detail->first()->dokter_id) }} </td>
        </tr>
        <tr>
          <th style="width: 17%">Pelaksana Lab</th> <td style="font-size: 11px;">: {{ @baca_pegawai($bdrs->detail->first()->pelaksana_lab_id) }} </td>
        </tr>
        <tr>
          <th style="width: 17%">Cara Bayar</th> <td style="font-size: 11px;">: {{ @baca_carabayar($bdrs->detail->first()->cara_bayar_id) }} </td>
        </tr>
        <tr>
          <th style="width: 17%">Tanggal</th> <td style="font-size: 11px;">: {{ date('d-m-Y', strtotime($bdrs->tanggal)) }} </td>
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
            <th class="">RINCIAN BIAYA BDRS</th>
            <th class="text-center" style="padding-right:50px;">HARGA</th>
            <th class="text-center" style="padding-right:50px;">JUMLAH</th>
            <th class="text-center" style="padding-right:50px;">TOTAL</th>
          </tr>
        </thead>

        <tbody>
            @foreach ($bdrs->detail as $item)
              <tr>
                <td class="" style="padding-right:50px;">{{ $item->namatarif }}</td>
                <td class="text-center" style="padding-right:50px;">Rp. {{ $item->tarif->total }}</td>
                <td class="text-center" style="padding-right:50px;">{{ $item->total / $item->tarif->total }}</td>
                <td class="text-center" style="padding-right:50px;">Rp. {{ number_format($item->total) }}</td>
              </tr>
            @endforeach
              <tr>
                <td class="text-right" colspan="3" style="padding-right:50px;"><b>TOTAL</b></td>
                <td class="text-center" style="padding-right:50px;"><b>Rp. {{number_format($bdrs->detail->sum('total'))}}</b></td>
              </tr>
        </tbody>
      </table>
      
      <p style="padding-left:20px;">
        =======================================================================================
      </p>
      <br> <br>
        <i style="padding-left:30px;">Dicetak pada: {{ date('d-M-Y H:i:s') }}</i> 
      <br>
      <br>
         <div class="text-center" style="padding: 5px; float:right;">
          {{ config('app.kota') }}, {{ date('d-M-Y',  strtotime($bdrs->created_at))}}
          <br>
          <br>
          <br>
          <br>
          <u>{{ baca_user($bdrs->created_by) }}</u><br>
          <hr>
        </div>
  </body>
</html>