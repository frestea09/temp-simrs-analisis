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
          width: 15cm;
          height: 30cm;
      }
    </style>

  <META HTTP-EQUIV="REFRESH" CONTENT="3; URL={{ url('kasir/cetak') }}">
  <head>
  <body onload="window.print();">
    <table>
      <tr>
        <td style="width:20%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="padding-left:90px;width:50px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size: 120%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
          <p>{{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          =======================================================================================
        </td>
      </tr>
        </table>
        
      <table style="margin-left:10%;">
      <tr>
        <td colspan="2">
          <h5 style="margin-left:20%;"><b>K W I T A N S I <br>Nomor : {{ $kuitansi->no_kwitansi }}</h5> </b>
        </td>
        <td></td>
      </tr>
      <tr>
        <td style="width:20%">Sudah terima dari</td> <td>: {{ $kuitansi->pasien->nama }}</td>
      </tr>
      <tr>
        {{-- <td>Uang sebesar </td> <td>: <b># {{ terbilang($kuitansi->dibayar) }} Rupiah #</b></td> --}}
        <td>Uang sebesar </td> <td>: <b># {{ terbilang($jml+$jasa_racik) }} Rupiah #</b></td>
      </tr>
      <tr>
        <td>Untuk</td>
        <td>:
          @if ($kuitansi->iur > 0)
              Pembayaran Pasien Naik Kelas
          @else
            @if (substr($reg->status_reg, 0,1) == 'I')
              Biaya Perawatan
            @else
              @if ($jasa > 0)
                Biaya Pendaftaran dan Pemerikasaan
              @elseif($konsul->count() > 0)
                Biaya
                @foreach ($konsul as $d)
                  {{ substr($d->namatarif, 5, 100) }}
                @endforeach
              @elseif($obat->count() > 0)
                Pembayaran Obat
              @else
                Biaya Tindakan di
                @foreach ($folio as $d)
                  {{ baca_poli($d->poli_id) }},
                @endforeach
              @endif
            @endif
          @endif

        </td>
      </tr>
      <tr>
        <td>Nama</td> <td>: {{ $kuitansi->pasien->nama }}</td>
      </tr>
      <tr>
        <td>Metode Bayar</td> <td>: {{ @$kuitansi->metode->name }}</td>
      </tr>
      <tr>
        <td>No Medrec</td> <td>: {{ $kuitansi->pasien->no_rm }}</td>
      </tr>
      @if ($kuitansi->diskon_persen !== 0  || $kuitansi->diskon_rupiah !== 0)
      <tr>
        <td>Diskon Rupiah</td> <td>: Rp. {{ number_format($kuitansi->diskon_rupiah) }}  </td>
      </tr>
      <tr>
        <td>Diskon Persen</td> <td>: {{ $kuitansi->diskon_persen }} %  </td>
      </tr>    
      @endif 
      <tr>
        {{-- <td>Jumlah</td> <td>: Rp. {{ number_format($kuitansi->dibayar) }}  </td> --}}
        <td>Jumlah</td> <td>: Rp. {{ number_format($jml+$jasa_racik) }}  </td>
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
        <td>Pelayanan  </td>
        <td>:
          @if (substr($reg->status_reg, 0,1) == 'I')
            Rawat Inap di {{ configrs()->nama }}
          @else
            {{ baca_poli($reg->poli_id) }}
            {{-- @foreach ($folio as $d)
              {{ baca_poli($d->poli_id) }},
            @endforeach --}}
          @endif

        </td>
      </tr>
      @if (substr($reg->status_reg, 0,1) == 'I')
        <tr>
          <td>Kamar</td><td>: {{ baca_kamar($kamar->kamar_id) }}</td>
        </tr>
      @endif
      <tr>
        <td>Dokter DPJP</td>
        <td>: {{ baca_dokter($bayar->dokter_id) }}</td>
      </tr>
      @if (substr($reg->status_reg, 0,1) != 'I')
        @if ($dokter->count() > 0)
          @foreach ($dokter as $d)
            <tr>
              <td>Dokter Konsultasi </td>
              <td>: {{ baca_dokter($d->dokter_pelaksana) }}</td>
            </tr>
          @endforeach
        @endif
      @endif
      </table>

    <table  style="margin-left:10%;">
      <tr>
        <th class="text-center">Keluarga Pasien,<br><br><br><br><i><u>___________________</u></i></th>
        <th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}<br><br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>
      </tr>
    </table>


    <script>

    </script>

  </body>
</html>
