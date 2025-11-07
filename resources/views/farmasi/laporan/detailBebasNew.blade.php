<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        font-size: 11px;
        margin-left: 0.1cm;
        margin-right: 0.1cm;
      }
      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black
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
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">

          </td>
        </tr>
      </table>
      <hr>  

      {{-- @if (substr(@$reg->status_reg, 0, 1) == 'I') --}}
      <table style="width:100%;margin:auto">
        <tbody>
          <tr>
            <td style="width:15%">Nama Pasien</td><td>: {{ $pasien->nama }}</td>
          </tr>
          <tr>
            <td style="width:">Tanggal</td> 
            <td>: {{ $penjualan->created_at->format('d-m-Y H:i:s') }}
            </td>
          </tr>
          <tr>
            <td style="width:">No. Kwitansi</td>
            <td>: {{ $penjualan->no_resep  }}</td>
          </tr>
          <tr>
            <td style="width:">Nama Dokter</td> <td>: {{ $pasien->dokter ?? '-'  }}</td>
          </tr>
 
        </tbody>
      </table>
      @php
        $total_biaya = 0;
      @endphp
      <table style="width:100%; margin-top: 1rem;" cellspacing="1">
        <tr style="margin-top: 1rem;">
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RESUME BIAYA DAN NAMA OBAT</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
        @foreach ($detail as $key => $d)
          <tr>
            <td>{{ $d->masterobat->nama }}</td>
            <td style="text-align: right " colspan="1">Rp.</span><span style="float:right">{{ $d->hargajual+$d->uang_racik / $d->jumlah }}</span></td>
            <td style="text-align: center " colspan="1">{{ $d->jumlah }}</td>
            <td style="text-align: right">Rp.</span><span style="float:right">{{ number_format($d->hargajual+$d->uang_racik) }}</span></td>
            @php
              $total_biaya += $d->hargajual+$d->uang_racik;
            @endphp
          </tr>
        @endforeach

    {{-- Space --}}
    <tr>
      <td>
        <div style="height: 10px"></div>
      </td>
    </tr>

    {{-- Space --}}
    <tr>
      <td>
        <div style="height: 10px"></div>
      </td>
    </tr>
      <tr><th class="dotTop text-right" colspan="3" style="text-align: end; font-weight: 400;">SUB TOTAL</th><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($total_biaya)}}</span></td>
      <tr><th class="dotTop text-right" colspan="3" style="text-align: end; font-weight: 400;">JASA RACIK</th><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($folio->jasa_racik)}}</span></td>
      <tr><th class="dotTop text-right" colspan="3" style="text-align: end; font-weight: 400;">DISKON</th><td class="dotTop"><span style="color:grey">%</span><span style="float:right">{{$folio->diskon}}</span></td>
      <tr><th class="dotTop text-right" colspan="3" style="text-align: end; font-weight: 400;">TOTAL DISKON</th><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format(($total_biaya * ($folio->diskon / 100)))}}</span></td>
      <tr><th class="dotTop text-right" colspan="3" style="text-align: end">TOTAL BIAYA</th><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($folio->total + $folio->jasa_racik)}}</span></td>

        
      </table>
           <table style="width: 100%;">
            <tr>
              <td style="width: 50%; text-align: center" class="text-center">
                Pemberi,
                <br>
                <br>
                <br>
                <br>
                <br>____________________
              </td>
              <td style="width: 50%; text-align: center;" class="text-center">
                Penerima,
                <br>
                <br>
                <br>
                <br>
                <br>____________________
              </td>
            </tr>
          </table> 

  </body>
</html>
