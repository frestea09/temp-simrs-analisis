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

  <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
  <table class="table table-condensed" style="width: 100%">
    <tr>
      <th style="width: 5%; text-align: center">No</th>
      <th style="text-align: center; width: 10%">Tanggal</th>
      <th style="text-align: center; width: 10%">Unit</th>
      <th style="text-align: center">Resume Biaya dan Nama Obat</th>
    @if($reg->bayar == 2)
      <th style="text-align: center; width: 15px">Bayar</th>
    @endif
      <th style="text-align: center; width: 10%">Cara Bayar</th>
      {{-- <th style="text-align: center; width: 10%">Qty</th> --}}
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
          <td style="text-align: center">{{ $d->created_at->format('d-m-Y') }}</td>
          <td style="text-align: left">{{ !empty($d->poli_tipe) ? \Modules\Politype\Entities\Politype::where('kode', $d->poli_tipe)->first()->nama : baca_kamar($d->kamar_id) }}</td>
          <td>{{ $d->namatarif }}</td>
        @if($reg->bayar == 2)
          <td style="text-align: center">{{ ($d->lunas == 'N') ? 'Belum' : 'Lunas' }}</td>
        @endif
          <td style="text-align: center">{{ baca_carabayar($d->cara_bayar_id) }}{{ ($d->cara_bayar_id == 1) ? ' - '.baca_jkn($d->registrasi_id) : '' }}</td>
          {{-- <td style="text-align: center">{{ ($d->tarif->total != 0) ? ($d->total + $d->diskon) / $d->tarif->total : NULL }}</td> --}}
          {{-- @if($d->tarif_id == 10000)
            <td style="text-align: right">Penjulan Obat</td>
          @else
            <td style="text-align: right">{{ ($d->tarif->total != 0) ? number_format($d->total/$d->tarif->total) : number_format($det) }}</td>
          @endif --}}
          {{-- <td style="text-align: center">{{ $d->tarif->jumlah }}</td> --}}
          {{-- <td style="text-align: center">hmammm</td> --}}
          @if($d->tarif_id == 10000)
            <td style="text-align: right">{{ number_format($d->total) }}</td>
          @else
            <td style="text-align: right">{{ ($d->tarif->total != 0) ? number_format($d->tarif->total) : number_format($det) }}</td>
          @endif
          <td style="text-align: right">{{ ($d->total != 0) ? number_format($d->total - $d->dijamin) : number_format($det) }}</td>
        </tr>
    @endforeach
  </table>
  @if($reg->bayar == 4)
  <h4 style="text-align: center">Rincian Obat & Alkes</h4>
  <table class="table table-condensed" style="width: 100%">
    <thead>
      <tr>
        <th style="text-align: center; width: 15px">No</th>
        <th style="text-align: center;">Tanggal</th>
        <th style="text-align: center;">No Resep</th>
        <th style="text-align: center;">Nama</th>
        <th style="text-align: center;">Jumlah</th>
        <th style="text-align: center;">Tarif</th>
        <th style="text-align: center;">Total</th>
      </tr>
    </thead>
    <tbody>
      @php $_no = 1; @endphp
      @foreach($orj as $o)
        <tr>
          <td style="text-align: center;">{{ $_no++ }}</td>
          <td style="text-align: center;">{{ date('d-m-Y', strtotime($o->created_at)) }}</td>
          <td style="text-align: center;">{{ $o->namatarif }}</td>
          <td>{{ $o->nama }}</td>
          <td style="text-align: center;">{{ $o->jumlah }}</td>
          <td style="text-align: right;">{{ $o->hargajual_kesda }}</td>
          <td style="text-align: right;">{{ $o->hargajual }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
  <table style="float:left; width: 60%">
    <tr>
      @if($reg->bayar == 4)
        <td colspan="2"><i>Terbilang: {{ terbilang($tindakan->sum('total') + $orj->sum('hargajual')) }} rupiah</i></td>
      @else
        <td colspan="2"><i>Terbilang: {{ terbilang($tindakan->sum('total')) }} rupiah</i></td>
      @endif
    </tr>
    <tr><th colspan="2">Rincian Tagihan</th></tr>
    @php $totalRincian = 0; @endphp
    @foreach($detail as $d)
      <tr>
        <td style="width: 350px">Total {{ ($d->nama != null) ? $d->nama : 'null' }}</td>
        <td>: Rp. {{ number_format($d->total) }}</td>
      </tr>
      @php $totalRincian += $d->total; @endphp
    @endforeach
    @foreach($obat as $o)
      <tr>
      @if($o->jenis == 'ORJ')
        <td>Total Obat</td>
      @endif
        <td>: Rp. {{ number_format($o->total) }}</td>
      </tr>
      @php $totalRincian += $o->total; @endphp
    @endforeach
    <tr><th>Total</th><td>: Rp. {{ number_format($totalRincian) }}</td></tr>
  </table>
  @php
    $ina = [0, 0] ;$inc = [];
    if($inacbgs != null){
      if($inacbgs->ket != null){
        $inc = explode(';', $inacbgs->ket);
        $ina[0] = ($inc[0] == 'inacbgs_vip') ? $inacbgs[$inc[1]] * $inacbgs[$inc[0]] / 100 : $inacbgs[$inc[0]];
        $ina[1] = $inacbgs[$inc[1]];
      }else{
        $ina[0] = 0;
        $ina[1] = 0;
        $inc[0] = 'INACBGS';
        $inc[1] = 'INACBGS';
      }
    }else{
      $inc[0] = 'INACBGS';
      $inc[1] = 'INACBGS';
    }
  @endphp
  <table style="float:right; width: 40%">
    <tr>
      <th style="text-align: right" colspan="2">Total Tagihan</th>
    @if($reg->bayar == 4)
      <th style="text-align: right">{{ number_format($tindakan->sum('total') + $orj->sum('hargajual')) }}</th>
    @else
      <th style="text-align: right">{{ number_format($tindakan->sum('total')) }}</th>
    @endif
    </tr>
    <tr>
      <th style="text-align: right" colspan="2">Dibayar</th>
      <th style="text-align: right">{{ number_format($dibayar) }}</th>
    </tr>
    <tr>
      <th style="text-align: right" colspan="2">Deposit</th>
      <th style="text-align: right">{{ number_format($deposit - $return) }}</th>
    </tr>
    <tr>
      <th style="text-align: right" colspan="2">Dijamin</th>
      <th style="text-align: right">{{ number_format($dijamin) }}</th>
    </tr>
    <tr>
      @if($inc[0] == 'inacbgs_vip')
        <th style="text-align: right" colspan="2">Selisih VIP {{ $inacbgs[$inc[0]] }} % x KLS 1</th>
      @else
        <th style="text-align: right" colspan="2">{{ strtoupper(str_replace('_', ' ', $inc[0])) }}</th>
      @endif
        <th style="text-align: right">{{ number_format($ina[0]) }}</th>
    </tr>
    <tr>
      <th style="text-align: right" colspan="2">{{ strtoupper(str_replace('_', ' ', $inc[1])) }}</th>
      <th style="text-align: right">{{ number_format($ina[1]) }}</th>
    </tr>
    <tr>
      <th style="text-align: right" colspan="2">Sisa Tagihan</th>
    @if($inc[0] == 'inacbgs_vip')
      <th style="text-align: right">{{ number_format($ina[0]) }}</th>
    @else 
      <th style="text-align: right">{{ number_format($sisaTagihan->sum('total') - $deposit + $return - $sisaTagihan->sum('dijamin') + ($ina[0] - $ina[1])) }}</th>
    @endif
    </tr>
  </table>
  <div style="width: 100%; float:left; padding-top:20px;">
    <div style="float:left; width: 40%;">
      <small style="font-size: 11pt; margin-left: 50px">
          <br>** Semoga Cepat Sembuh** <br />
          Catatan: <br />
          Lembar 1: Pasien <br />
          Lembar 2: Keuangan <br />
          Lembar 3: Billing RI <br />
          Dicetak pada tanggal {{ date('Y-m-d H:i:s') }}
      </small>
    </div>
    <table style="width: 60%; float: right;">
        <td style="text-align: center">
          Tanda Tangan Pasien <br /><br /><br /><br />
          ( {{ $reg->pasien->nama }} )
        </td>
        <td style="text-align: center">
          Verifikator <br /><br /><br /><br /><br />
          (..................................)
        </td>
      </tr>
    </table>
  </div>

  <script type="text/javascript">
    function closeMe() {
      window.close();
    }
  </script>
  </body>
</html>
