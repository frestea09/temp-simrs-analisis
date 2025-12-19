<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Rawat Jalan</title>

    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="print">
    @page {
          margin-top: 0.5cm;
          margin-left: 1cm;
          width: 9.5cm;
          height: 20cm;
      }
    </style>


  </head>

  <body onload="window.print()">
    <table style="width:100%">
      <tr>
        <td style="width:25%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="width:75px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size: 135%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
          <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          =============================================================================================
        </td>
      </tr>
        </table>

      <table style="width:100%;">
      <tr>
        <td colspan="2">
          <h5><b>FAKTUR PEMBAYARAN <br>No. KRJ: {{ $kuitansi->no_kwitansi }}</h5> </b>
        </td>
        <td></td>
      </tr>
      <tr>
        <td style="width:35%">Nama </td> <td>: {{ $pasien->nama }} </td>
      </tr>
      <tr>
        <td>Alamat</td> <td>: {{ $pasien->alamat }} </td>
      </tr>

      <tr>
        <td>Dokter</td>
        <td>: {{ $pasien->dokter }}</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      </table>

      <table style="width:100%;">
      <tr>
        <td colspan="4"><b>Rincian Pembayaran</b></td>
      </tr>

      @foreach ($folio as $key => $d)
        @php
          $det = App\Penjualandetail::where('no_resep', 'like', '%'.$d->namatarif.'%')->get();
        @endphp
        @if ($det->count() > 0)
          @foreach ($det as $key => $r)
            @php
              $uang_jasa_racik = @$d->jasa_racik
            @endphp
            <tr>
              <td> &nbsp; {{ strtolower($r->masterobat->nama) }} </td>
              <td class="col-md-3"> {{ $r->jumlah }} x {{ number_format($r->hargajual / $r->jumlah) }}</td>
              <td class="text-left" style="width: 4px;">:</td>
              {{-- <td class="text-right"> {{ number_format($r->hargajual+!empty($r->uang_racik) ? $r->uang_racik : 0) }}</td> --}}
              @if( empty(@$r->uang_racik) )
                <td class="text-right"> {{ number_format(@$r->hargajual) }}</td>
              @else
                <td class="text-right"> {{ number_format(@$r->hargajual+$r->uang_racik) }}</td>
              @endif
            </tr>
          @endforeach
        @else
          <tr>
            <td> &nbsp; {{ $d->namatarif }} </td>
            <td class="col-md-3"> &nbsp; </td>
            <td class="text-left" style="width: 4px;">:</td>
            <td class="text-right"> {{ number_format($d->total) }}</td>
          </tr>
        @endif
      @endforeach
      <tr>
        <th></th>
        <th>Total Pembayaran</th>
        <th>:</th>
        <th class="text-right">{{ number_format($jml+$uang_racik+$jasa_racik) }}  </th>
      </tr>

      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>

      <tr>
        <th colspan="4"><i>Terbilang: <br>"{{ terbilang($jml+$uang_racik+$jasa_racik) }} Rupiah"</i></th>
      </tr>


    </tbody>
    </table>
    <br>
    <table  style="width:100%;">
        <tr>
        {{--  <th class="text-center">Keluarga / Pasien,<br><br><br><br><i><u>___________________</u></i></th>  --}}
        <th colspan="2">&nbsp; &nbsp; &nbsp;</th>
        <th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}<br><br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>
        </tr>
    </table>

      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/lain-lain') }}">
  </body>
</html>
