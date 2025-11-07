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
        {{-- <td style="width:20%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="width:75px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size: 135%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
          <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
        </td>
      </tr> --}}
      <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
        </tr>
      </table>
    </table>
      <hr>
      <table>
      <tr>
        <td colspan="4">
          <h5 style="margin-left:15%;"><b>KWITANSI<br>No. KRJ: {{ $kuitansi->no_kwitansi }}</h5> </b>
        </td>
        <td></td>
      </tr>
      <tr>
        <td style="width:25%">Nama / JK</td> <td>: {{ $kuitansi->pasien->nama }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/  &nbsp;&nbsp;&nbsp; {{ $kuitansi->pasien->kelamin }}</td>
      </tr>
      <tr>
        <td>Umur </td> <td>: {{ hitung_umur($kuitansi->pasien->tgllahir) }}</td>
      </tr>
      <tr>
        <td>No.RM</td> <td>: {{ $kuitansi->pasien->no_rm }}</td>
      </tr>
      <tr>
        <td>Alamat</td> <td>: {{ $kuitansi->pasien->alamat }} </td>
      </tr>
      <tr>
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

      <table>
      {{-- <tr>
        <td colspan="2"><b>Tindakan</b></td>
      </tr> --}}
      @php
          $total = 0;
      @endphp
      @if($folio->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered" >
          <thead>
            <tr>
              <th colspan="6" class="text-left"> Tindakan</th>
            </tr>
          {{-- <tr>
           
            <th class="text-center">Nama Tindakan</th>
            <th class="text-center">Biaya @</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Total</th>
          </tr> --}}
          {{-- <tr>
            <th colspan="5" class="text-left">Rawat Jalan</th>
          </tr> --}}
          </thead>
          <tbody>
            
            @foreach ($folio as $noirj => $d)
            @php
                $total += $d->total
            @endphp
              <tr>
             
                <td style="max-width:200px">{{ $d->tarif->nama }}</td>
                <td class="text-right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : NULL }}</td>
                <td class="text-center">{{ ($d->tarif->total <> 0) ? ($d->total / $d->tarif->total) : NULL }}</td>
                <td class="text-left">{{ number_format($d->total) }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="text-right"><b>Total : </b></td>
              <td colspan="2" class="text-left"><b>{{number_format($total)}}</b></td>
            </tr>
          </tfoot>
        </table>
      </div>
    @endif
      {{-- @if ($bayar->bayar == 1)
        <tr>
          <th>Kode Grouper</th>
          <th>: {{ !empty(\App\Inacbg::where('registrasi_id', $kuitansi->registrasi_id)->first()->kode) ? \App\Inacbg::where('registrasi_id', $kuitansi->registrasi_id)->first()->kode : ' '  }}</th>
        </tr>
        <tr>
          <th>Dijamin INACBG</th>
          <th>: Rp. {{ !empty(\App\Inacbg::where('registrasi_id', $kuitansi->registrasi_id)->first()->dijamin) ? number_format(App\Inacbg::where('registrasi_id', $kuitansi->registrasi_id)->first()->dijamin) : '' }}</th>
        </tr>
      @endif --}}
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      @if ($bayar->bayar <> 1)
        <tr>
          @if ($total !== 0)
            <th colspan="2"><i>"{{ terbilang(@$total) }} Rupiah"</i></th>  
          @endif
        </tr>
      @endif

    </tbody>
    </table>
    <br>
    <table>
        <tr>
          {{--  @if (($bayar->bayar == '1') || ($bayar->bayar == '3') )
            <th class="text-center">Keluarga Pasien,<br><br><br><br><i><u>___________________</u></i></th>
          @endif  --}}

          <th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}<br><br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>
        </tr>
    </table>

  </body>
</html>
