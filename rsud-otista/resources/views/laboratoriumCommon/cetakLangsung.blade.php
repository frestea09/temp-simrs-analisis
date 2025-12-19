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
          <tr> <td style="width: 30%">Nama Lengkap</td> <td>:</td> <td>{{ $pasienLangsung->nama }}</td> </tr>
          <tr> <td style="width: 30%">Alamat</td> <td>:</td> <td>{{ $pasienLangsung->alamat }}</td> </tr>
          <tr> <td>Tgl Daftar</td> <td>:</td> <td>{{ $reg->created_at->format('d-m-Y') }}</td> </tr>
          <tr> <td>Unit yang Order</td> <td>:</td>
                <td>Pasien Langsung / Laboratorium</td>
          </tr>
          <tr> <td>Sts. Cara Bayar</td> <td>:</td> <td>{{ baca_carabayar($reg->bayar) }}</td> </tr>
          <tr> <td>DPJP</td> <td>:</td> <td>{{ baca_dokter($reg->dokter_id) }}</td> </tr>
        </table>
      </td>
    </tr>
    <tr>
      <th colspan="2" style="text-align: center"><br> Rincian Tindakan</th>
    </tr>
  </table>
  <table class="table table-condensed" style="width: 100%">
    <tr>
      <th style="width: 5%; text-align: center">No</th>
      <th style="text-align: center; width: 10%">Tanggal</th>
      <th>Resume Biaya dan Nama Obat</th>
      <th style="text-align: center; width: 10%">Cara Bayar</th>
      <th style="text-align: center; width: 10%">Qty</th>
      <th style="text-align: center; width: 10%">Harga</th>
      <th style="text-align: center; width: 10%">Total</th>
    </tr>
    @foreach ($tindakan as $d)
      @php
          $penj = \App\Penjualan::where('registrasi_id', $d->registrasi_id)->first();
          if($penj){
            $det = \App\Penjualandetail::where('penjualan_id', $penj->id)->sum('hargajual');
          }
      @endphp
        <tr>
          <td style="text-align: center">{{ $no++ }}</td>
          <td>{{ $d->created_at->format('d-m-Y') }}</td>
          <td>{{ $d->namatarif }}</td>
          <td style="text-align: center">{{ baca_carabayar($d->cara_bayar_id) }}</td>
          <td style="text-align: center">{{ ($d->tarif->total <> 0) ? ($d->total + $d->diskon) / $d->tarif->total : NULL }}</td>
          <td style="text-align: right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : number_format($det) }}</td>
          <td style="text-align: right">{{ ($d->total <> 0) ? number_format($d->total - $d->dijamin) : number_format($det) }}</td>
        </tr>
    @endforeach
    <tr>
      <td colspan="8"></td>
    </tr>
    <tr>
      <td colspan="4"><i>Terbilang: {{ terbilang($sisaTagihan->sum('total')) }} rupiah</i></td>
      <th style="text-align: right" colspan="2">Total Tagihan</th>
      <th style="text-align: right">{{ number_format($tindakan->sum('total')) }}</th>
    </tr>
    <tr>
      <td colspan="4"></td>
      <th style="text-align: right" colspan="2">Sisa Tagihan</th>
      <th style="text-align: right">{{ number_format($sisaTagihan->sum('total')) }}</th>
    </tr>
  </table>

  <table style="width: 25%; float: left">
    <tr>
      <td>
        <small style="font-size: 11pt;">
        <br>** Semoga Cepat Sembuh** <br />
        Catatan: <br />
        Lembar 1: Pasien <br />
        {{-- Lembar 2: Teler BRI <br /> --}}
        Lembar 2: Keuangan <br />
        Lembar 3: Billing RI <br />
        
      </td>
      <td></td>
    </tr>
    <tr>
      <td colspan="2">Dicetak pada tanggal {{ date('Y-m-d H:i:s') }}</td>
      </small>
    </tr>
  </table>

  <table style="width: 60%; float: right;">
         <td style="text-align: center">
        Tanda Tangan Pasien <br /><br /><br /><br />
        ( {{ $pasienLangsung->nama }} )
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
