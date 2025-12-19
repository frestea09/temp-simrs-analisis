<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Detail Penjualan</title>
    <style>
      body{
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
      <td style="width: 65%; vertical-align: top;">
        <b>{{ config('app.merek') }}</b> <br />
          {{ config('app.nama') }} <br />
          {{ config('app.alamat') }} <br>
          {{-- Website:  --}}
      </td>
      <td style="width: 35%">
        Resume Data Pasien <br>
        <table style="width: 100%">
          <tr><td style="width: 40%">Nama Lengkap</td> <td>:</td> <td>{{ $pasienLangsung->nama }}</td></tr>
          <tr><td>Alamat</td> <td>:</td> <td>{{ $pasienLangsung->alamat }}</td></tr>
          <tr><td>Order</td> <td>:</td> <td>Radiologi</td></tr>
          <tr><td>Tgl Daftar</td> <td>:</td> <td>{{ $pasienLangsung->created_at }}</td></tr>
        </table>
      </td>
    </tr>
    <tr>
      <th colspan="2" style="text-align: center"><br> Rincian Order</th>
    </tr>
  
  </table>
  <table class="table table-condensed" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Tindakan</th>
            <th>Order</th>
            {{--  <th>Dokter Radiologi</th>
            <th>Pelaksana</th>  --}}
            <th>Waktu</th>
            <th>Biaya</th>
            <th>Jml</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($folio as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ ($d->tarif_id <> 0 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
              <td>{{ $d->poli->nama }}</td>
              {{--  <td>{{ baca_dokter($d->dokter_radiologi) }}</td>
              <td>{{ baca_dokter($d->radiografer) }}</td>  --}}
              <td>{{ $d->created_at->format('Y-m-d') }}</td>
              <td style="text-align: right">{{ ($d->tarif_id <> 0 ) ? number_format($d->tarif->total,0,',','.') : '' }}</td>
              <td style="text-align:center">{{ ($d->tarif_id <> 0 ) ? ($d->total / $d->tarif->total) : '' }}</td>
              <td style="text-align: right">{{ number_format($d->total,0,',','.') }}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="3"><i>Terbilang: {{ terbilang($tindakan->sum('total')) }} rupiah</i></td>
            <th style="text-align: right" colspan="3">Total Tagihan</th>
            <th style="text-align: right">{{ number_format($tindakan->sum('total')) }}</th>
          </tr>
        </tbody>
  </table>

  <table style="width: 100%">
    <tr>
      <td>
        ** Semoga Cepat Sembuh** <br />
        Catatan: <br />
        Lembar 1: Pasien <br />
        {{-- Lembar 2: Teller BRI <br /> --}}
        Lembar 2: Keuangan <br />
      </td>
      <td style="text-align: center">
        Tanda Tangan Pasien <br /><br /><br /><br />
        ( {{ $pasienLangsung->nama }} )
      </td>
      <td style="text-align: center">
        Verifikator Unit <br /><br /><br /><br /><br />
      </td>
    </tr>
    <tr>
      <td colspan="3">Dicetak pada  tanggal {{ date('Y-m-d H:i:s') }}</td>
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
