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
      <td style="width: 60%; vertical-align: top;">
        <b>{{ config('app.merek') }}</b> <br />
          {{ config('app.nama') }} <br />
          {{ config('app.alamat') }} <br>
          {{-- Website:  --}}
      </td>
      <td style="width: 40%">
        Resume Data Pasien <br>
        <table style="width: 100%">
          <tr> <td style="width: 30%">Nama Lengkap</td> <td>:</td> <td>{{ $reg->pasien->nama }}</td> </tr>
          <tr> <td>No. Rekam Medik</td> <td>:</td> <td>{{ $reg->pasien->no_rm }}</td> </tr>
          <tr> <td>Tgl. Lahir / Usia</td> <td>:</td> <td>{{ !empty($reg->pasien->tgllahir) ? $reg->pasien->tgllahir : ''}} / {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }}</td> </tr>
          <tr><td>Jenis Kelamin</td><td>:</td><td> {{ ($reg->pasien->kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td></tr>
          <tr> <td>Tgl Daftar</td> <td>:</td> <td>{{ $reg->created_at->format('d-m-Y') }}</td> </tr>
          <tr> <td>Unit yang Order</td> <td>:</td>
                <td>
                @if (substr($reg->status_reg, 0,1) == 'J')
                    Instalasi Rawat Jalan
                @elseif (substr($reg->status_reg, 0,1) == 'G')
                    Instalasi Rawat Darurat
                @elseif (substr($reg->status_reg, 0,1) == 'I')
                     Instalasi Rawat Inap
                @endif
                </td>
          </tr>
          <tr> <td>Sts. Cara Bayar</td> <td>:</td> <td>{{ baca_carabayar($reg->bayar) }}{{ ($reg->bayar == 1) ? ' - '.$reg->tipe_jkn : '' }}</td> </tr>
          <tr> <td>Dokter Pengirim</td> <td>:</td> <td>{{ baca_dokter($reg->dokter_id) }}</td> </tr>
          {{--  <tr> <td>Tanggal Input</td> <td>:</td> <td>{{ $reg->created_at->format('d-m-Y') }}</td> </tr>  --}}
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
      <th style="text-align: center; width: 10%">Unit</th>
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
            <td>{{ !empty($d->poli_tipe) ? \Modules\Politype\Entities\Politype::where('kode', $d->poli_tipe)->first()->nama : baca_kamar($d->kamar_id) }}</td>
            <td>{{ $d->namatarif }}</td>
            <td style="text-align: center">{{ baca_carabayar($d->cara_bayar_id) }}{{ ($d->cara_bayar_id == 1) ? ' - '.baca_jkn($d->registrasi_id) : '' }}</td>
            <td style="text-align: center">{{ ($d->tarif->total <> 0) ? $d->total / $d->tarif->total : NULL }}</td>
            <td style="text-align: right">{{ ($d->tarif->total <> 0) ? number_format($d->tarif->total) : number_format($det) }}</td>
            <td style="text-align: right">{{ ($d->total <> 0) ? number_format($d->total) : number_format($det) }}</td>
          </tr>
    @endforeach
    <tr>
      <td colspan="5"><i>Terbilang: {{ terbilang($tindakan->sum('total')) }} rupiah</i></td>
      <th style="text-align: right" colspan="2">Total Tagihan</th>
      <th style="text-align: right">{{ number_format($tindakan->sum('total')) }}</th>
    </tr>
  @if($status == 'irj')
    <tr>
      <td colspan="5"></td>
      <th style="text-align: right" colspan="2">Dibayar</th>
      <th style="text-align: right">{{ number_format($dibayar) }}</th>
    </tr>
    <tr>
      <td colspan="2">Total Visite</td>
      {{-- <td style="text-align: right;">{{ number_format($visite) }}</td> --}}
      <td style="text-align: right;">0</td>
      <td colspan="2"></td>
      <th style="text-align: right" colspan="2">Deposit</th>
      <th style="text-align: right">{{ number_format($deposit - $return) }}</th>
    </tr>
    <tr>
      <td colspan="2">Total Laboratorium</td>
      {{-- <td style="text-align: right;">{{ number_format($lab) }}</td> --}}
      <td style="text-align: right;">0</td>
      <td colspan="2"></td>
      <th style="text-align: right" colspan="2">JKN</th>
      <th style="text-align: right">{{ number_format($jkn) }}</th>
    </tr>
    <tr>
      <td colspan="2">Total Radiologi</td>
      {{-- <td style="text-align: right;">{{ number_format($rad) }}</td> --}}
      <td style="text-align: right;">0</td>
      <td colspan="2"></td>
      <th style="text-align: right" colspan="2">Dijamin</th>
      <th style="text-align: right">{{ number_format($dijamin) }}</th>
    </tr>
    <tr>
      <td colspan="2">Total IGD</td>
      {{-- <td style="text-align: right;">{{ number_format($igd) }}</td> --}}
      <td style="text-align: right;">0</td>
      <td colspan="2"></td>
      <th style="text-align: right" colspan="2">Jamkesda</th>
      <th style="text-align: right">{{ number_format($jamkesda) }}</th>
    </tr>
    <tr>
      <td colspan="5"></td>
      <th style="text-align: right" colspan="2">Sisa Tagihan</th>
      <th style="text-align: right">{{ number_format($sisaTagihan->sum('total') - $sisaTagihan->sum('dijamin') - $deposit + $return + (($inacbgs != null) ?  (($inacbgs->inacbgs2 > 0 ) ? $inacbgs->inacbgs2 - $inacbgs->inacbgs1 : $inacbgs->inacbgs1) : 0) ) }}</th>
    </tr>
  @else
    <tr>
      <td colspan="5"></td>
      <th style="text-align: right" colspan="2">Dibayar</th>
      <th style="text-align: right">{{ number_format($dibayar) }}</th>
    </tr>
    <tr>
      <td colspan="5"></td>
      <th style="text-align: right" colspan="2">Deposit</th>
      <th style="text-align: right">{{ number_format($deposit - $return) }}</th>
    </tr>
    <tr>
      <td colspan="5"></td>
      <th style="text-align: right" colspan="2">JKN</th>
      <th style="text-align: right">{{ number_format($jkn) }}</th>
    </tr>
    <tr>
      <td colspan="5"></td>
      <th style="text-align: right" colspan="2">Dijamin</th>
      <th style="text-align: right">{{ number_format($dijamin) }}</th>
    </tr>
    <tr>
      <td colspan="5"></td>
      <th style="text-align: right" colspan="2">Jamkesda</th>
      <th style="text-align: right">{{ number_format($jamkesda) }}</th>
    </tr>
    <tr>
      <td colspan="5"></td>
      <th style="text-align: right" colspan="2">Sisa Tagihan</th>
      <th style="text-align: right">{{ number_format($sisaTagihan->sum('total') - $deposit + $return - $sisaTagihan->sum('dijamin') + (($inacbgs != null) ?  (($inacbgs->inacbgs2 > 0 ) ? $inacbgs->inacbgs2 - $inacbgs->inacbgs1 : $inacbgs->inacbgs1) : 0) ) }}</th>
    </tr>
  @endif
  </table>
  <table style="width: 100%">
    <tr>
      <td>
        ** Semoga Cepat Sembuh** <br />
        Catatan: <br />
        Lembar 1: Pasien <br />
        Lembar 2: Teller BRI <br />
        Lembar 3: Keuangan <br />
      </td>
      <td style="text-align: center">
        Tanda Tangan Pasien <br /><br /><br /><br />
        ( {{ $reg->pasien->nama }} )
      </td>
      <td style="text-align: center">
        Verifikator<br /><br /><br /><br /><br />
        {{--  ( {{ Auth::user()->name }} )  --}}
        (.....................)
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
    //setTimeout(closeMe, 10000);
  </script>
  </body>
</html>
