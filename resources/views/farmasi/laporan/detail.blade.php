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
  @if ($total > 0)
    <body onload="print()">
  @else
    <body>
  @endif
  <table style="width:100%;">
    <tr style="font-size: 14px;">
      <th style="text-align: center;">
          {{ config('app.nama') }} <br />
          {{ config('app.alamat') }}
      </th>
    </tr>      
  </table>       
  <table style="width: 100%">
    <tr style="line-height:0.75; font-size: 14px;">
      <td style="width: 50%; vertical-align: top;">
        {{-- <b>{{ config('app.merek') }}</b> <br /> --}}
          {{-- Website:  --}}
          <table style="width: 100%;">
            <tr> <td style="width: 30%">Nama Lengkap</td> <td>:</td> <td>{{ $reg->pasien->nama }}</td> </tr>
            <tr> <td>No. SEP</td> <td>:</td> <td>{{ $reg->no_sep }}</td> </tr>
            <tr> <td>No. Rekam Medik</td> <td>:</td> <td>{{ $reg->pasien->no_rm }}</td> </tr>
            <tr> <td>Usia / Jns Kelamin</td> <td>:</td> <td>{{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : NULL }} / {{ $reg->pasien->kelamin }}</td> </tr>
            <tr> <td>Tgl Daftar</td> <td>:</td> <td>{{ $reg->created_at }}</td> </tr>
          </table>
      </td>
      <td style="width: 50%;">
        {{-- Resume Data Pasien <br> --}}
        <table style="width: 100%; ">
          <tr style="font-size: 14px;"> <td>Unit yang Order</td> <td>:</td> 
                <td>
                @if (substr($reg->status_reg, 0,1) == 'J')
                    Instalasi Rawat Jalan / {{ baca_poli($reg->poli_id) }}
                @elseif (substr($reg->status_reg, 0,1) == 'G')
                    Instalasi Rawat Darurat / {{ baca_poli($reg->poli_id) }}
                @elseif ($reg->status_reg == 'I2') 
                    Instalasi Rawat Inap / {{ baca_kamar(App\Rawatinap::where('registrasi_id', $reg->id)->first()->kamar_id) }}
                @elseif ($reg->status_reg == 'I1') 
                    Instalasi Rawat Inap / {{ baca_poli($reg->poli_id) }}
                @endif
                </td> 
          </tr>
          <tr> <td>Sts. Cara Bayar</td> <td>:</td> <td>{{ baca_carabayar($reg->bayar) }} / {{ $reg->tipe_jkn }}</td> </tr>
          <tr> <td>Dokter DPJP</td> <td>:</td> <td>{{ baca_dokter($reg->dokter_id) }}</td> </tr>
          <tr> <td>Pembuat Resep</td> <td>:</td> <td>{{ baca_pegawai($penjualan->pembuat_resep) }}</td> </tr>
          {{--  <tr><td>Dokter</td><td>:</td><td>{{ ($penjualan->dokter_id != null) ? baca_dokter($penjualan->dokter_id) : '' }}</td></tr>  --}}
          <tr> <td>Tanggal Input</td> <td>:</td> <td>{{ date('d-m-Y' ,strtotime($penjualan->created_at)) }}</td> </tr>
        </table>
      </td>
    </tr>
    <tr style="line-height:0.5; font-size: 14px;">
      @if (substr($reg->status_reg, 0,1) == 'J')
        <th colspan="2" style="text-align: center"><br> Faktur Penjualan Apotik Rawat Jalan</th>            
      @elseif (substr($reg->status_reg, 0,1) == 'G')
        <th colspan="2" style="text-align: center"><br> Faktur Penjualan Apotik Rawat Darurat</th>  
      @elseif (substr($reg->status_reg, 0,1) == 'I') 
        <th colspan="2" style="text-align: center"><br> Faktur Penjualan Apotik Rawat Inap</th>
      @endif
    </tr>
  
  </table>
  <table class="" style="width: 90%;">
    <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
      <td colspan="5"><i> No. Resep : {{ $penjualan->no_resep }} </i></td>
    </tr>
    <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
      <th style="width: 5%; text-align: center">No</th>
      <th>Resume Biaya dan Nama Obat</th>
      <th style="text-align: center; width: 10%" colspan="2">Qty</th>
      {{-- <th style="text-align: center; width: 10%">Uang Racik</th> --}}
      {{-- <th style="text-align: center; width: 10%">Harga</th> --}}
      <th style="text-align: center; width: 10%">Total</th>
    </tr>
  @foreach ($detail as $d)
    <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
      <td style="text-align: center">{{ $no++ }}</td>
      <td>{{ $d->masterobat->nama }}</td>
      <td style="text-align: center " colspan="2">{{ $d->jumlahTotal }}</td>
      {{-- <td style="text-align: right">{{ number_format($d->uang_racik)  }}</td> --}}
      {{-- <td style="text-align: right">{{ number_format(($d->hargajual / $d->jumlah)+$d->uang_racik)  }}</td> --}}
      <td style="text-align: right">{{ number_format($d->hargaTotal+$d->uang_racik) }}</td>
    </tr>
  @endforeach
    <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
      <td colspan="2"><i>Terbilang: {{ terbilang($total+@$folio->jasa_racik+$uang_racik) }} rupiah</i></td>
      <th style="text-align: right" colspan="2">Sub Total</th>
      <th style="text-align: right">{{ number_format($total+$uang_racik) }}</th>
    </tr>
    <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
      {{-- <th colspan="2">Total Obat : {{ number_format($obat) }}</th> --}}
      <th colspan="2"></th>
      <th style="text-align: right" colspan="2">Jasa</th>
      <th style="text-align: right">{{ number_format(@$folio->jasa_racik) }}</th>
    </tr>
    <tr style="line-height:1; font-family: Times New Roman; font-size: 14px;">
      <th colspan="2">Total Alkes : {{ number_format($alkes) }}</th>
      <th style="text-align: right" colspan="2">Total Tagihan</th>
      <th style="text-align: right">{{ number_format($total+@$folio->jasa_racik+$uang_racik) }}</th>
    </tr>
  </table>

  <table>
    <tr>
      <td>
        Petugas <br/><br/>
        {{ Auth::user()->ttd }} <br/><br/>
        {{ Auth::user()->name }}
      </td>
    </tr>
  </table>

  {{-- <table style="width: 80%">
    <tr>
      <td>
        ** Semoga Cepat Sembuh** <br />
        Catatan: <br />
        Lembar 1: Pasien <br />
        Lembar 2: Apotik <br />
        Lembar 3: Keuangan <br />
      </td>
      
      <td style="text-align: center">
        Tanda Tangan Pasien <br /><br /><br /><br />
        ( {{ $reg->pasien->nama }} )
      </td>
      <td style="text-align: center">
        Verifikator Apotik <br /><br /><br /><br />
        ( {{ \App\User::find($penjualan->user_id)->name }} )
      </td>
    </tr>
    <tr>
      <td colspan="3">Dicetak oleh apotik; sebanyak [3 rangkap tanggal {{ date('Y-m-d H:i:s') }}]</td>
    </tr>
  </table> --}}

  <script type="text/javascript">
    function closeMe() {
          window.close();
       }
       //setTimeout(closeMe, 10000);
  </script>
  </body>
</html>
