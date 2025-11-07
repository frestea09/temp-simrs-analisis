<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Rawat Jalan</title>

    {{-- <link href="{{ asset('css/pdf.css') }}" rel="stylesheet"> --}}
    <style>
      body{
        margin: 5px 10px;
        /* font-size: 8pt; */

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


    @if ($kuitansi)
      @if (substr(@$kuitansi->no_kwitansi,0,2) == 'RD')
        <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/igd') }}">
      @else
        <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('kasir/rawatjalan') }}">
      @endif
    @else
          <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url()->previous() }}">
    @endif
  </head>
  <body onload="window.print()">
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
                <td>: {{ $reg->id }}</td> 
            </tr>   
            <tr style="font-size: 18px;" >
              <td style="padding-left: 100px"></td>
              <td style="width:15%">No Kwitansi</td>
              @php
                  $kwitansi = @str_replace("RD-", "", @$folio[0]->no_kuitansi);
              @endphp
              <td>: {{ @$kwitansi }}</td> 
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
      <hr>
      <table>
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
             <td>: {{ $kuitansi->jenis }}</td> 
          </tr>  
        </table>

      <table>
      {{-- <tr>
        <td colspan="2"><b>Tindakan</b></td>
      </tr> --}}

      @if($folio->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered" >
          <thead>
            {{--<tr>
              <th colspan="6" class="text-left"> Tindakan</th>
            </tr>--}}
            <tr>
            
              <th class="text-center">Nama Tindakan</th>
              <th class="text-center">Biaya @</th>
              <th class="text-center">Qty</th>
              <th class="text-center">Total</th>
            </tr>
          {{-- <tr>
            <th colspan="5" class="text-left">Rawat Jalan</th>
          </tr> --}}
          </thead>
          <tbody>
            @foreach ($folio as $noirj => $d)
              <tr>
                @if(date('Y-m-d H:i', strtotime($d->created_at)) < config('app.tarif_new'))
                    <td>{{ $d->tarif_lama->nama }}</td>
                    <td class="text-right">{{ ($d->tarif_lama->total <> 0) ? number_format($d->tarif_lama->total) : NULL }}</td>
                    <td class="text-center">{{ ($d->tarif_lama->total <> 0) ? ($d->total / $d->tarif_lama->total) : NULL }}</td>
                    <td class="text-right">{{ number_format($d->total) }}</td>
                @else
                  <td>{{ $d->tarif_baru->nama }}</td>
                  <td class="text-right">{{ ($d->tarif_baru->total <> 0) ? number_format($d->tarif_baru->total) : NULL }}</td>
                  <td class="text-center">{{ ($d->tarif_baru->total <> 0) ? ($d->total / $d->tarif_baru->total) : NULL }}</td>
                  <td class="text-right">{{ number_format($d->total) }}</td>
                @endif
              </tr>
            @endforeach
            <tr>
              <td colspan="3" class="text-center"><b>Total Biaya Pemeriksaan</b></td>
              {{-- <td class="text-right"><b>Rp. {{ $jml_irj+$jml_obat+$uangracik }}</b></td> --}}
              <td class="text-right"><b>Rp. {{ $jml }}</b></td>
            </tr>
          </tbody>
        </table>
      </div>
    @endif
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
    

    </tbody>
    </table>
    <br>
    <table style="width:100%;">
      <tr style="font-size: 20px;"> 
             <td style="width:15%">Terbilang </td>
             {{-- <td>: <b>{{ terbilang($jml_igd+$obat+$jml_igd_rad+$jml_igd_lab+$jml)}} Rupiah</b></td>  --}}
             <td>: <b>{{ terbilang($jml)}} Rupiah</b></td> 
          </tr>
        <tr>

        

            <th class="text-center">Petugas
            <br><br><br>
            <br><br><br>
            <i><u></u></i>{{ Auth::user()->name }}</th>
        </tr>
        
    </table>

  </body>
</html>
