<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Rawat Jalan</title>

    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0.5cm;
          margin-left: 1cm;
          width: 9.5cm;
          height: 20cm;
      }
    </style>


    @if (substr($kuitansi->no_kwitansi,0,2) == 'RD')
      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/igd') }}">
    @else
      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/rawatjalan') }}">
    @endif

  </head>

  <body onload="window.print()">
    <table>
      <tr>
        <td style="width:20%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="width:75px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size: 135%; font-weight: bold; margin-bottom: -3px;">{{ @configrs()->nama }} </h4>
          <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ @configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          ===========================================
        </td>
      </tr>
        </table>

      <table>
      <tr>
        <td colspan="2">
          <h5 style="margin-left:15%;"><b>KWITANSI <br>No. KRJ: {{ $kuitansi->no_kwitansi }}</h5> </b>
        </td>
        <td></td>
      </tr>
      <tr>
        <td style="width:25%">Nama / JK</td> <td>: {{ @$kuitansi->pasien->nama }} &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; {{ $kuitansi->pasien->kelamin }}</td>
        <td>Umur </td> <td>: {{ hitung_umur($kuitansi->pasien->tgllahir) }}</td>
      </tr>
      <tr>
        <td>No.RM</td> <td>: {{ $kuitansi->pasien->no_rm }}</td>
        <td>Alamat</td> <td>: {{ $kuitansi->pasien->alamat }} </td>
      </tr>
      
      <tr>
        <td>No. HP</td> <td>: {{ $kuitansi->pasien->nohp }} </td>
        <td>Cara Bayar</td>
        <td>:
          @php
            $bayar = Modules\Registrasi\Entities\Registrasi::where('id', $kuitansi->registrasi_id)->first();
          @endphp
          {{ baca_carabayar($bayar->bayar) }} {{ $bayar->tipe_jkn }}
        </td>
      </tr>
      <tr>
        <td>Dokter</td>
        <td>: {{ baca_dokter($bayar->dokter_id) }}</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      </table>
      <hr/>
      {{-- <h6 style="text-center"><b>RINCIAN BIAYA</b></h6> --}}
      <table style="width:100%" cellspacing="1">
        <tr>
          <th style="border-bottom:1px solid black">BIAYA</th>
          <th class="text-right" style="border-bottom:1px solid black">HARGA</th>
          <th class="text-center" style="border-bottom:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black">TOTAL</th>
        </tr>
      {{-- BIAYA OBAT --}}
      <tr><th colspan="2">PEMAKAIAN OBAT</th><td class="text-right"><td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($obat)}}</span></td>
      {{-- BIAYA TINDAKAN --}}
      <tr><th class="dotTop" colspan="4">TINDAKAN</th></tr>
      @php
          $tindakan_igd = 0;
          $tindakan_irj_ina = 0;
      @endphp
      @if (count($folio) > 0)
          
        @foreach ($folio as $item)
        @php
            @$jml = @floor(@$item->total / @$item->tarif->total);
            @$tindakan_igd += $item->total;
        @endphp
            <tr>
              <td><span style="margin-left:40px;">{{$item->namatarif}}</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td class="text-center">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
        @endforeach
      @endif
      @if (count($folio_null_tipe) > 0)
          
        @foreach ($folio_null_tipe as $item)
        @php
            @$jml = @floor(@$item->total / @$item->tarif->total);
            @$tindakan_irj_ina += $item->total;
        @endphp
            <tr>
              <td><span style="margin-left:40px;">{{$item->namatarif}}</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td class="text-center">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
        @endforeach
      @endif
      {{-- BIAYA LABOR --}}
      <tr><th class="dotTop" colspan="2">LABORATORIUM</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($lab)}}</span></td>
      <tr><th class="dotTop" colspan="2">RADIOLOGI</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($rad)}}</span></td>
      <tr><th class="dotTop text-right" colspan="3">TOTAL BIAYA</th><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($tindakan_igd+$tindakan_irj_ina+$rad+$lab+$obat)}}</span></td>
      {{-- <tr><th class="dotTop text-right" colspan="3">TOTAL BIAYA</th><td class="text-right dotTop">{{number_format($tindakan+$rad)}}</td> --}}
      </table>
        <table> 
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          {{-- @if ($bayar->bayar <> 1) --}}
            <tr>
              <th colspan="2"><i>"{{ terbilang($total_biaya) }} Rupiah"</i></th>
            </tr>
          {{-- @endif --}}
    
        </tbody>
        </table>
        <br>
        <table>
            <tr>
              {{--  @if (($bayar->bayar == '1') || ($bayar->bayar == '3') )
                <th class="text-center">Keluarga Pasien,<br><br><br><br><i><u>___________________</u></i></th>
              @endif  --}}
    
              <th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}
                <br><br>
                @php
                $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
                @endphp
                <img src="{{ asset('/images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt="">
                <br><br>
                <i><u>{{ $norah->nama }}</u></i></th>
            </tr>
        </table>

  </body>
</html>
