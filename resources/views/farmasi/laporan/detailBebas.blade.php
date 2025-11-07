<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Detail Penjualan</title>
    <style>
      body{
        margin: 5px 10px;
        font-size: 8pt;
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
    /* padding-top: 8px; */
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
    /* padding: 4px; */
    line-height: 0.90;
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
  @if ($total > 0)
    <body onload="print()">
  @else
    <body>
  @endif
    
  <table style="width: 100%">
    <tr>
      <td style="width: 50%; vertical-align: top;">
        {{-- <b>{{ config('app.merek') }}</b> <br /> --}}
          {{ config('app.nama') }} <br />
          {{ config('app.alamat') }}
          {{-- Website:  --}}
          <table style="width: 100%;line-height: 0.60;">
            <tr> 
              <td>Tanggal</td> <td>:</td> <td>{{ $penjualan->created_at->format('d-m-Y H:i:s') }}</td> 
              <td style="width: 30%">Nama Lengkap</td> <td>:</td> <td>{{ $pasien->nama }}
            </tr>
            <tr> 
              <td>No. Kwitansi</td> <td>:</td> <td>{{ $penjualan->no_resep  }}</td>
              <td>Nama Dokter </td> <td>:</td> <td>{{ $pasien->dokter  }}</td> 
            </tr>
            <tr> 
            </tr>
            <tr> 
            </tr>
          </table>
      </td>
  
  
  </table>
  <table class="table table-condensed" style="width: 100%">
    <tr>
      <th colspan="5">Penjualan Bebas</th>
    </tr>
    <tr>
      <th style="width: 5%; text-align: center">No</th>
      <th>Resume Biaya dan Nama Obat</th>
      <th style="text-align: right; width: 10%" colspan="1">Qty</th>
      <th style="text-align: right; width: 10%">Total</th>
    </tr>
  @foreach ($detail as $key => $d)
    <tr>
      <td style="text-align: center">{{ $no++ }}</td>
      <td>{{ $d->masterobat->nama }}</td>
      <td style="text-align: right " colspan="1">{{ $d->jumlah }}</td>
      <td style="text-align: right">{{ number_format($d->hargajual+$d->uang_racik) }}</td>
    </tr>
  @endforeach
    <tr>
      <th style="text-align: right" colspan="3">Sub Harga</th>
      <th style="text-align: right">{{ number_format($total+$total_uang_racik) }}</th>
    </tr>
    <tr>
      <th style="text-align: right" colspan="3">Jasa</th>
      <th style="text-align: right">{{ !empty($folio->jasa_racik) ? number_format($folio->jasa_racik) : 0 }}</th>
    </tr>
    <tr>
      <th>
       <td style="text-align: left" colspan="1"> <i> Terbilang: {{ terbilang($total+(!empty($folio->jasa_racik) ? $folio->jasa_racik : 0)+$total_uang_racik) }} Rupiah</b></i></td> 
       <th style="text-align: right">Harga Total</th>
       <th style="text-align: right">{{ number_format($total+ (!empty($folio->jasa_racik) ? $folio->jasa_racik : 0)+$total_uang_racik)}}</th>
      </th>
    </tr>  
     <th>
        <td class="text-center">
            Pembeli,
            <br>
            <br>
            <br>____________________
        </td>
        <td class="text-center">
            Penerima,
            <br>
            <br>
            <br>____________________
        </td>
    </th>
  </table>

      <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('penjualanbebas') }}">



  <script type="text/javascript">
    function closeMe() {
          window.close();
       }
       //setTimeout(closeMe, 10000);
  </script>
  </body>
</html>
