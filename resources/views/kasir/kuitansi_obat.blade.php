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
          <td style="font-size:17px">Nama / JK</td> 
          <td style="font-size:17px">: {{ $kuitansi->pasien->nama }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/  &nbsp;&nbsp;&nbsp; {{ $kuitansi->pasien->kelamin }}</td>
          <td  style="padding-left:170px"></td>
          <td style="font-size:17px">Cara Bayar</td>
           <td style="font-size:17px">:
            @php
              $bayar = Modules\Registrasi\Entities\Registrasi::where('id', $kuitansi->registrasi_id)->first();
            @endphp
            {{ baca_carabayar($bayar->bayar) }} {{ $bayar->tipe_jkn }}
          </td>
        </tr>
        <tr>
          <td style="font-size:17px">Umur </td> 
          <td style="font-size:17px">: {{ hitung_umur($kuitansi->pasien->tgllahir) }}</td>
          <td  style="padding-left:170px;font-size:17px"></td>
          <td style="font-size:17px">Dokter</td>
          <td style="font-size:17px">: {{ baca_dokter(@$folio[0]->dokter_id) }}</td>
        </tr>
        <tr>
          <td style="font-size:17px">No.RM</td> 
          <td style="font-size:17px">: {{ $kuitansi->pasien->no_rm }}</td>
          <td  style="padding-left:170px"></td>
          <td style="font-size:17px">Poli</td>
          <td style="font-size:17px">: {{ baca_poli($bayar->poli_id) }}</td>
        </tr>
        <tr>
          <td style="font-size:17px">Alamat</td> 
          <td style="font-size:17px">: {{ $kuitansi->pasien->alamat }} </td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        </table>

      <table>

      <table>
      @if($penjualan->count() > 0)
      @if (baca_carabayar($reg->bayar) == 'UMUM' )
      <div class="table-responsive">
        <table class="table table-bordered" style="width: 100%">
          <thead>
          <tr>
            <th colspan="3" class="text-left"> Obat & BHP</th>
          </tr>
            {{-- <tr>
              <th class="text-center">No</th>
              <th class="text-center" style="text-align:center; width:30%;">Obat</th>
              <th class="text-center">qty</th>
            </tr> --}}
          </thead>
          <tbody>
            @foreach ($penjualan as $nopen => $d)
              <tr>
                <td>{{ ++$nopen }}</td>
                <td style="text-align:center; width:30%;">{{ baca_obat($d->masterobat_id) }}</td>
                {{-- <td>{{ number_format($d->hargajual/$d->jumlah) }}</td> --}}
                <td>{{ $d->jumlah }}</td>
                {{-- <td>{{ number_format($d->hargajual) }}</td> --}}
              </tr>
              {{-- <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $d->namatarif }}</td>
                <td class="text-right">{{ ($d->total) }}</td>
                <td class="text-right">{{ ($d->total) }}</td>
                <td class="text-right">{{ number_format($d->total) }}</td>
              </tr> --}}
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-right">Total</th>
              <th class="text-right">{{ number_format($jml_obat) }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      
      @else
      
      <div class="table-responsive">
        <table class="table table-bordered" style="width: 100%">
          <thead>
          <tr>
            <th colspan="6" class="text-left"> Obat & BHP</th>
          </tr>
            {{-- <tr>
            
              <th class="text-center" style="text-align:center; width:30%;">Obat</th>
              <th class="text-center">Biaya @</th>
              <th class="text-center">Qty</th>
              <th class="text-center">Total</th>
            </tr> --}}
          </thead>
          <tbody>
            @foreach ($penjualan as $nopenn => $d)
              <tr>
                <td style="text-align:left; width:30%;">{{ substr(strtoupper(baca_obat($d->masterobat_id)),0,40) }}</td>
                <td class="text-right">{{ $d->jumlah !== 0 ? number_format($d->hargajual/$d->jumlah) : number_format($d->hargajual)  }}</td>
                <td class="text-right">{{ $d->jumlah }}</td>
                <td style="text-align:right; width:30%;">{{ number_format($d->hargajual) }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            @foreach ($jenisracik as $u) 
              <tr>
                <th colspan="1"  style="text-align:left; width:30%;">{{ $u->nama }}</th>
                <td class="text-right">{{ $u->uang_racik}}</td>
                <td class="text-right">{{ $u->jmlracik}}</td>
                <td class="text-right">{{ $u->uracik}}</td>
              </tr>
            @endforeach
            @if ($kuitansi)
            <tr>
              <th  style="font-size: 20px" colspan="3" class="text-right">Total </th>
              <td style="font-size: 20px" class="text-right"><b>{{ number_format($jml_obat+$uangracik) }}</b></td>
            </tr>
              <tr>
                <th  style="font-size: 20px" colspan="3" class="text-right">Diskon</th>
                <td style="font-size: 20px" class="text-right"><b>{{ @number_format($kuitansi->diskon_persen) }}%</b></td>
              </tr>
              <tr>
                <th  style="font-size: 20px" colspan="3" class="text-right">Jumlah Biaya Perawatan </th>
                <td  style="font-size: 20px" class="text-right"><b>{{ number_format($jml_irj+$jml_obat+$uangracik-$kuitansi->diskon_rupiah) }}</b></td>
              </tr>
            @else
            <tr>
              <th  style="font-size: 20px" colspan="3" class="text-right">Total </th>
              <td style="font-size: 20px" class="text-right"><b>{{ number_format($jml_obat+$uangracik) }}</b></td>
            </tr>
            <tr>
              <th  style="font-size: 20px" colspan="3" class="text-right">Jumlah Biaya Perawatan </th>
              <td  style="font-size: 20px" class="text-right"><b>{{ number_format($jml_irj+$jml_obat+$uangracik) }}</b></td>
            </tr>
            @endif

          </tfoot>
        </table>
      </div>
      @endif
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
        @if (($jml_obat+$uangracik) !== 0)
          <tr>
            <th colspan="2"><i>"{{ terbilang($jml_obat+$uangracik) }} Rupiah"</i></th>
          </tr>
        @endif
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
