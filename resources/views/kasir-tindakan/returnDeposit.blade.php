<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <title>Cetak Detail Penjualan</title>
  <style>
    body {
      margin: 5px 10px;
    }

    .table {
      border-collapse: collapse !important;
    }

    .table td,
    .table th {
      background-color: #fff !important;
    }

    .table-bordered th,
    .table-bordered td {
      border: 1px solid #ddd !important;
    }


    }

    table {
      background-color: transparent;
    }

    caption {
      padding-top: 8px;
      padding-bottom: 8px;
      color: #b4bcc2;
      text-align: left;
    }

    th {
      text-align: left;
    }

    .table {
      width: 100%;
      max-width: 100%;
      margin-bottom: 21px;
    }

    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 4px;
      line-height: 1.42857143;
      vertical-align: top;
      border-top: 1px solid #ecf0f1;
    }

    .table>thead>tr>th {
      vertical-align: bottom;
      border-bottom: 1px solid #ecf0f1;
    }

    .table>caption+thead>tr:first-child>th,
    .table>colgroup+thead>tr:first-child>th,
    .table>thead:first-child>tr:first-child>th,
    .table>caption+thead>tr:first-child>td,
    .table>colgroup+thead>tr:first-child>td,
    .table>thead:first-child>tr:first-child>td {
      border-top: 0;
    }

    .table>tbody+tbody {
      border-top: 1px solid #ecf0f1;
    }

    .table .table {
      background-color: #ffffff;
    }

    .table-condensed>thead>tr>th,
    .table-condensed>tbody>tr>th,
    .table-condensed>tfoot>tr>th,
    .table-condensed>thead>tr>td,
    .table-condensed>tbody>tr>td,
    .table-condensed>tfoot>tr>td {
      padding: 2px;
    }

    .table-bordered {
      border: 1px solid #ecf0f1;
    }

    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>tbody>tr>td,
    .table-bordered>tfoot>tr>td {
      border: 1px solid #ecf0f1;
    }

    .table-bordered>thead>tr>th,
    .table-bordered>thead>tr>td {
      border-bottom-width: 1px;
    }

    .table-striped>tbody>tr:nth-of-type(odd) {
      background-color: #f9f9f9;
    }

    .table-hover>tbody>tr:hover {
      background-color: #ecf0f1;
    }
  </style>
</head>

<body onload="print()">

  <table style="width: 100%">
    <tr>
      <td style="width: 50%; vertical-align: top;">
        <b>PEMERINTAH DAERAH KABUPATEN WAJO </b> <br />
        BLUD RSUD LAMADDUKELLENG SENGKANG <br />
        {{ config('app.alamat') }} <br>
        Website: rsudmaddukelleng.com
      </td>
      <td style="width: 50%">
        Resume Data Pasien <br>
        <table style="width: 100%">
          <tr>
            <td style="width: 30%">Nama Lengkap</td>
            <td>:</td>
            <td>{{ $reg->pasien->nama }}</td>
          </tr>
          <tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td>{{ $reg->pasien->no_rm }}</td>
          </tr>
          <tr>
            <td>Usia / Jns Kelamin</td>
            <td>:</td>
            <td>{{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} /
              {{ $reg->pasien->kelamin }}</td>
          </tr>
          <tr>
            <td>Tgl Daftar</td>
            <td>:</td>
            <td>{{ $reg->created_at }}</td>
          </tr>
          <tr>
            <td>Unit yang Order</td>
            <td>:</td>
            <td>
              @if (substr($reg->status_reg, 0,1) == 'J')
                {{ baca_poli($reg->poli_id) }}
              @elseif (substr($reg->status_reg, 0,1) == 'G')
                {{ baca_poli($reg->poli_id) }}
              @elseif (substr($reg->status_reg, 0,1) == 'I')
                {{ baca_kamar($irna->kamar_id) }}
              @endif
            </td>
          </tr>
          <tr>
            <td>Sts. Cara Bayar</td>
            <td>:</td>
            <td>
              {{ baca_carabayar($reg->bayar) }} {{ !empty($reg->tipe_jkn) ? $reg->tipe_jkn : NULL }}
            </td>
          </tr>
          <tr>
            <td>Dokter DPJP</td>
            <td>:</td>
            <td>{{ baca_dokter($reg->dokter_id) }}</td>
          </tr>
          <tr>
            <td>Alamat Lengkap</td>
            <td>:</td>
            <td>{{ $reg->pasien->alamat }} Rt/Rw: {{ $reg->pasien->rt }}/{{ $reg->pasien->rw }}</td>
          </tr>
          <tr>
            <td>Kelurahan</td>
            <td>:</td>
            <td>{{ baca_kelurahan($reg->pasien->village_id) }} </td>
          </tr>
          <tr>
            <td>Kec. / Kab.</td>
            <td>:</td>
            <td>{{ baca_kecamatan($reg->pasien->district_id) }} / {{ baca_kabupaten($reg->pasien->regency_id) }} </td>
          </tr>

        </table>
      </td>
    </tr>
    <tr>
      <th colspan="2" style="text-align: center"><br> KUITANSI DEPOSIT RAWAT INAP</th>
    </tr>

  </table>
  <table class="table table-condensed" style="width: 100%">

    <tr>
      <th>Uraian Pembayaran</th>
      <th style="text-align: center; width: 10%">Qty</th>
      <th style="text-align: center; width: 10%">Deposit</th>
      <th style="text-align: center; width: 10%">Return</th>
    </tr>
    <tr>
      <td>Pembayaran Deposit Rawat Inap</td>
      <td style="text-align: center; width: 10%">1</td>
      <td style="text-align: center; width: 10%">{{ number_format($dp->nominal) }}</td>
      <td style="text-align: center; width: 10%">{{ number_format($dp->nominal) }}</td>
    </tr>
    <tr>
      <td colspan="2"><i>Terbilang: {{ terbilang($dp->nominal) }} Rupiah</i></td>
      <td style="text-align: right; width: 10%"><i><b> Total Return </b></i></td>
      <td style="text-align: center; width: 10%"><i><b> {{ number_format($dp->nominal) }}</b></i></td>
    </tr>

  </table>

  <table style="width: 80%">
    <tr>
      <td>
        Batas waktu pengembalian deposit maksimal 5 (lima) <br> hari kerja dari tanggal penyetoran Deposit tanpa biaya administrasi <br />
        Catatan: <br />
        Lembar 1: Pasien <br />
        Lembar 2: Unit UPF <br />
        Lembar 3: Instalasi Ambulance dan Jenazah <br />
        Lembar 4: Teller BRI <br />
      </td>
      <td style="text-align: center">
        Tanda Tangan Pasien <br /><br /><br /><br />
        ( {{ $reg->pasien->nama }} )
      </td>
      <td style="text-align: center">
        Verifikator Apotik <br /><br /><br /><br />
        ( {{ Auth::user()->name }} )
      </td>
    </tr>
    <tr>
      <td colspan="3"><i> Dicetak pada tanggal {{ date('Y-m-d H:i:s') }}</i></td>
    </tr>
  </table>

  <script type="text/javascript">
    function closeMe() {
          window.close();
    }
    setTimeout(closeMe, 10000);
  </script>
</body>

</html>
