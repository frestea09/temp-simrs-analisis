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
      <td style="width: 50%; vertical-align: top;">
        <b>{{ config('app.merek') }}</b> <br />
          {{ config('app.nama') }} <br />
          {{ config('app.alamat') }} <br>
          {{-- Website:  --}}
      </td>
      <td style="width: 50%">
        Resume Data Pasien <br>
        <table style="width: 100%">
          <tr> <td style="width: 30%">Nama Lengkap</td> <td>:</td> <td>{{ $reg->pasien->nama }}</td> </tr>
          <tr> <td style="width: 30%">Alamat</td> <td>:</td> <td>{{ $reg->pasien->alamat }}</td> </tr>
          <tr> <td>No. Rekam Medik</td> <td>:</td> <td>{{ $reg->pasien->no_rm }}</td> </tr>
          <tr> <td>Usia / Jns Kelamin</td> <td>:</td> <td>{{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} / {{ $reg->pasien->kelamin }}</td> </tr>
          <tr> <td>Tgl Daftar</td> <td>:</td> <td>{{ $reg->created_at->format('d-m-Y') }}</td> </tr>
          <tr> <td>Sts. Cara Bayar</td> <td>:</td> <td>{{ baca_carabayar($reg->bayar) }}</td> </tr>
        </table>
      </td>
    </tr>
    <tr>
      <th colspan="2" style="text-align: center"><br> Rincian SOAP</th>
    </tr>
  </table>
  <table class="table table-condensed" style="width: 100%">
    <tr>
      <th style="width: 5%; text-align: center">No</th>
      <th>Subject</th>
      <th>Object</th>
      <th>Assesment</th>
      <th>Planing</th>
      <th>Diagnosa</th>
      <th>Tindakan</th>
    </tr>
@foreach ($resume as $d)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{!! $d->subject !!}</td>
        <td>{!! $d->object !!}</td>
        <td>{!! $d->assesment !!}</td>
        <td>{!! $d->planing !!}</td>
        <td>{!! $d->diagnosa !!}</td>
        <td>{!! $d->tindakan !!}</td>
    </tr>
@endforeach
  </table>

  <table style="width: 25%; float: left">
    <tr>
      <td colspan="2">Dicetak pada tanggal {{ date('Y-m-d H:i:s') }}</td>
      </small>
    </tr>
  </table>

  <table style="width: 60%; float: right;">
         <td style="text-align: center">
        Tanda Tangan Pasien <br /><br /><br /><br />
        ( {{ $reg->pasien->nama }} )
      </td>
      <td style="text-align: center">
        Verifikator <br /><br /><br /><br /><br />
      </td>
    </tr>
  </table>

  <script type="text/javascript">
    function closeMe() {
          window.close();
    }
    //setTimeout(closeMe, 10000);
  </script>
  </body>
</html>
