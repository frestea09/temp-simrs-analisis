<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Rawat Jalan</title>

    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0.5cm;
          margin-left: 1cm;
          width: 9.5cm;
          height: 20cm;
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
        {{-- <td style="width:20%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="width:75px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size: 135%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
          <p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
        </td>
      </tr> --}}
      <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
        </tr>
      </table>
    </table>
      <hr>
      <table>
        <tr>
          <td colspan="4">
            @php
              $kwitansi = str_replace("RJ-", "", @$kuitansi->no_kwitansi);
            @endphp
            <h5 style="margin-left:15%;"><b>KWITANSI<br>No. {{ $kwitansi }}</h5> </b>
          </td>
          <td></td>
        </tr>
        <tr>
          <td style="font-size:17px">Nama / JK</td> 
          <td style="font-size:17px">: {{ $reg->pasien->nama }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/  &nbsp;&nbsp;&nbsp; {{ $reg->pasien->kelamin }}</td>
          <td  style="padding-left:170px"></td>
          <td style="font-size:17px">Cara Bayar</td>
           <td style="font-size:17px">:
            {{ baca_carabayar($reg->bayar) }} {{ $reg->tipe_jkn }}
          </td>
        </tr>
        <tr>
          <td style="font-size:17px">Umur </td> 
          <td style="font-size:17px">: {{ hitung_umur($reg->pasien->tgllahir) }}</td>
          <td  style="padding-left:170px;font-size:17px"></td>
          <td style="font-size:17px">Dokter</td>
          <td style="font-size:17px">: {{ baca_dokter(@$reg->dokter_id) }}</td>
        </tr>
        <tr>
          <td style="font-size:17px">No.RM</td> 
          <td style="font-size:17px">: {{ $reg->pasien->no_rm }}</td>
          <td  style="padding-left:170px"></td>
          <td style="font-size:17px">Poli</td>
          <td style="font-size:17px">: {{ baca_poli($reg->poli_id) }}</td>
        </tr>
        <tr>
          <td style="font-size:17px">Alamat</td> 
          <td style="font-size:17px">: {{ $reg->pasien->alamat }} </td>
          <td  style="padding-left:170px"></td>
          <td style="font-size:17px">Tgl. Reg</td>
          <td style="font-size:17px">: {{ date('d-m-Y H:i:s', strtotime($reg->created_at)) }}</td>
          
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
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
      @if ($reg->bayar <> 1)
        <tr>
          {{-- <th colspan="2"><i>"{{ terbilang($jml_irj+$jml_obat+$uangracik) }} Rupiah"</i></th> --}}
          <th colspan="2"><i>"{{ terbilang($jml) }} Rupiah"</i></th>
        </tr>
      @endif

    </tbody>
    </table>
    <br>
    <table style="width:100%;">
        <tr>

        

            <th class="text-center">Petugas
            <br><br><br>
            <br><br><br>
            <i><u></u></i>{{ Auth::user()->name }}</th>
        </tr>
    </table>

  </body>
</html>
