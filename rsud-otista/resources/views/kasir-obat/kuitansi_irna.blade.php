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

  <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/rawatinap') }}">

  </head>

  <body onload="window.print()">
    <table>
      <tr>
        <td style="width:20%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="width:75px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size: 135%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
          <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
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
          <h5 style="margin-left:15%;"><b>FAKTUR PEMBAYARAN <br>No. KRJ: {{ $kuitansi->no_kwitansi }}</h5> </b>
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
      <tr>
        <td colspan="2"><b>Rincian Pembayaran</b></td>
      </tr>
      @foreach ($folio as $key => $d)
        @php
          $det = App\Penjualandetail::where('no_resep', 'like', '%'.$d->namatarif.'%')->get();
        @endphp
        <tr>
          <td style="width: 50%">{{ $d->namatarif }} <br>
            <table>
              @foreach ($det as $key => $r)
                <tr>
                  <td> &nbsp;&nbsp; {{ strtolower($r->masterobat->nama) }} </td>
                  <td>{{ $r->jumlah }}</td>
                  <td>x {{ number_format($r->hargajual / $r->jumlah) }}</td>
                  <td> {{ number_format($r->hargajual) }}</td>
                </tr>
              @endforeach
            </table>
          </td>
          <td valign="bottom">: Rp. {{ number_format($d->total) }}</td>
        </tr>
      @endforeach
      <tr>
        <th>Jumlah Tagihan RS</th>
        <th>: Rp. {{ number_format($jml) }}  </th>
      </tr>
      @if ($bayar->bayar == 1)
        <tr>
          <th>Kode Grouper</th>
          <th>: {{ !empty(\App\Inacbg::where('registrasi_id', $kuitansi->registrasi_id)->first()->kode) ? \App\Inacbg::where('registrasi_id', $kuitansi->registrasi_id)->first()->kode : ' '  }}</th>
        </tr>
        <tr>
          <th>Dijamin INACBG</th>
          <th>: Rp. {{ !empty(\App\Inacbg::where('registrasi_id', $kuitansi->registrasi_id)->first()->dijamin) ? number_format(App\Inacbg::where('registrasi_id', $kuitansi->registrasi_id)->first()->dijamin) : '' }}</th>
        </tr>
      @endif
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      @if ($bayar->bayar <> 1)
        <tr>
          <th colspan="2"><i>"{{ terbilang($jml) }} Rupiah"</i></th>
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
          <th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('Y-m-d')) }}<br><br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>
        </tr>
    </table>

  </body>
</html>
