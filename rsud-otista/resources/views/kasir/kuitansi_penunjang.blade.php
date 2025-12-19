<!DOCTYPE html>

<html>
  <head>
    <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url()->previous() }}">
    <meta charset="utf-8">
    <title>Cetak Kwitansi Rawat Inap</title>
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
  {{-- </head>
  @if ($total > 0)
    <body onload="print()">
  @else
    <body>
  @endif --}}
  <body onload="print()">
    <table>
      <tr>
        <td style="width:20%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="width:75px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size: 135%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
          <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
        </td>
      </tr>    
  </table>       
  <table style="width: 100%" class="mt-3">
    <tr style="line-height:0.75; font-size: 14px;">
      <td class="text-right">
        <table style="width: 100%;">
          <tr style="font-size: 18px;"> 
              <td style="padding-left: 100px"></td>
              <td  style="width:15%">No Registrasi </td>
              <td>: {{ @$reg->reg_id }}</td> 
          </tr>   
          <tr style="font-size: 18px;" >
             <td style="padding-left: 100px"></td>
             <td style="width:15%">No Kwitansi</td>
             <td>: {{ App\Pembayaran::where('registrasi_id', $folio->get()[0]->registrasi_id)->first()->no_kwitansi ?? '-' }}</td> 
          </tr>  
          <tr style="font-size: 18px;"> 
             <td style="padding-left: 100px"></td>
             <td  style="width:15%">Kode Bayar</td>
             <td>: -</td> 
          </tr>  
          <tr style="font-size: 18px;"> 
             <td style="padding-left: 100px"></td>
             <td style="width:15%">No RM </td>
             <td>: {{ $reg->pasien->no_rm }}</td> 
          </tr>  
        </table>
      </td>
    </tr>
  </table>
  <table style="width: 100%" class="mt-3">
    <tr style="line-height:0.75; font-size: 20px;">
      <td class="text-right">
        <table style="width: 100%;">
          <tr style="font-size: 20px;"> 
            <td  style="width:15%"></td>
            <td><i><b>KWITANSI</b></i></td> 
          </tr> 
          <tr style="font-size: 20px;"> 
              <td  style="width:15%">Nama </td>
              <td>: {{ $reg->pasien->nama }}</td> 
          </tr>   
          <tr style="font-size: 20px;">
             <td style="width:15%">Alamat</td>
             <td>: {{ $reg->pasien->alamat }}</td> 
          </tr>  
          <tr style="font-size: 20px;"> 
             <td  style="width:15%">Jenis Biaya</td>
             <td>: {{ baca_carabayar($reg->bayar) }}</td> 
             {{-- <td>: Umum</td>  --}}
          </tr>  
       

          <tr style="font-size: 20px;"> 
             <td style="width:15%">Terbilang </td>
             <td>: <b>{{ terbilang($total_biaya)}} Rupiah</b></td> 
          </tr>
          <tr style="font-size: 20px;"> 
            <td style="width:15%">Untuk Pembayaran</td>
            <td>: 
              @if (count($folio->get()) > 0)
                @foreach ($folio->get() as $item => $d)
                  {{ $d->namatarif }},
                @endforeach
              @endif
            </td> 
         </tr>
         <tr style="font-size: 20px;"> 
          <td style="width:15%"></td>
          <td></td> 
       </tr>
         <tr style="font-size: 20px;"> 
          <td style="width:15%;padding-top: 100px;"></td>
          <td><b>Rp.{{ number_format($total_biaya) }}</b></td> 
       </tr>
        </table>
      </td>
    </tr>
  </table>

  <table style="padding-top: 30px; width:100%">
    <tr>
      <td style="font-size: 20px;" class="text-left">
        <b>Dicetak : </b><br>
        {{ date('d-m-Y H:i:s') }}
      </td>
      <td style="font-size: 20px;padding-left:500px" class="text-left">
        <b>Petugas</b>
        <br>
        <img src="{{ asset('/images/'. @Auth::user()->pegawai->tanda_tangan) }}" style="width: 60px;" alt="">
        <br>
        <b> {{ Auth::user()->name }}</b>
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
