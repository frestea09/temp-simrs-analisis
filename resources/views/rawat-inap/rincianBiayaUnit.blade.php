<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        margin-left: 0.1cm;
        margin-right: 0.1cm;
      }
      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black;
      }
    </style>
  </head>
  <body onload="print()">

    {{-- <table style="width:100%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:100px;">
                </th>
                <th class="text-left">
                  <h4 style="font-size: 150%;">{{ configrs()->nama }} </h4>
                  <p>{{ configrs()->alamat }} {{ configrs()->tlp }} </p>

                </th>
              </tr>
            </tbody>
          </table> <br> --}}
          @php
              // $obat = 0;
              @$ranap = App\Rawatinap::where('registrasi_id', $reg->id)->first();
          @endphp
      <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            {{--<b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>--}}
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ asset('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
    
      <hr>
      {{-- @if (substr(@$reg->status_reg, 0, 1) == 'I') --}}
      <table style="width:100%;margin:auto;">
        <tbody>
          <tr style="font-size:17px;">
            <td style="width:">No. RM</td> <td>: {{ $reg->pasien->no_rm }}</td>
            <td style="width:15%">No. SEP</td><td>: {{ @\App\HistoriSep::where('registrasi_id',$reg->id)->first()->no_sep }}</td>
          </tr>
          <tr style="font-size:17px;">
            <td style="width:15%">Nama Peserta</td><td>: {{ @$reg->pasien->nama }} 
            @if (@$reg->pasien->kelamin == "L")
                        ({{ "Laki-laki" }})
                  @else
                        ({{ "Perempuan" }})      
                  @endif
            </td>
            <td>Jenis Perawatan</td><td>:  
              @if (substr(@$reg->status_reg, 0, 1) == 'J')
                  {{ "Rawat Jalan" }}
              @elseif(substr(@$reg->status_reg, 0, 1) == 'I')   
                  {{ "Rawat Inap / " }} {{baca_kelompok(@$ranap->kelompokkelas_id)}}
              @elseif(substr(@$reg->status_reg, 0, 1) == 'G')   
                  {{ "Gawat Darurat" }}    
              @elseif(substr(@$reg->status_reg, 0, 1) == null)   
                  {{ "-" }} 
              @endif
           </td>
          </tr>
          <tr style="font-size:17px;">
            <td style="width:">Umur Tahun</td> 
            <td>: 


              @if (@$reg->pasien->tgllahir != null)
              {{hitung_umur(@$reg->pasien->tgllahir)}} ({{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }})
              @else
                {{ "-" }}
              @endif



            </td>
            <td>Penjamin</td><td>: {{@baca_carabayar($reg->bayar)}} {{' - '.@baca_jkn(@$reg->id)}}</td>
            
            
          </tr>
          <tr style="font-size:17px;">
            <td style="width:">No. Telp</td>
            <td>:  {{$reg->pasien->nohp ? @$reg->pasien->nohp : @$reg->pasien->notlp}}</td>
            <td>Alamat</td> <td>: {{ @$reg->pasien->alamat }}</td>
          </tr>
          <tr>
            <td>Tanggal Registrasi</td><td>: {{ @date('d-m-Y',strtotime(@$reg->created_at)) }}</td>
          </tr>
        </tbody>
      </table>
      <br/>
      {{-- <hr/> --}}
      {{-- <h6 style="text-center"><b>RINCIAN BIAYA</b></h6> --}}
      <table style="width:100%" cellspacing="1">
       
      {{-- BIAYA OBAT --}}
      {{-- @if (count($obat_gudang) > 0)
        <tr><th colspan="4">PEMAKAIAN OBAT</th></tr>
        @foreach ($obat_gudang as $item)
        <tr>
          <td colspan="2"><span style="margin-left:40px;">{{$item->gudang ? $item->gudang->nama : 'Obat Farmasi'}}</span></td>
          <td class="text-right"><td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->sum)}}</span></td>
        </tr>

        @endforeach
        <tr>
          <td colspan="2"><span style="margin-left:40px;font-weight:900">SUB TOTAL</span></td>
          <td class="text-right"><td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($obat)}}</b></span></td>
        </tr>
      @endif --}}
      {{-- @if (count($obat_gudang) > 0)
        <tr><th colspan="4">PEMAKAIAN OBAT</th></tr>
        <tr>
          <td colspan="2"><span style="margin-left:40px;">Obat Farmasi</span></td>
          <td class="text-right"><td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($obat_gudang_tanpa_gudang)}}</span></td>
        </tr>
        <tr>
          <td colspan="2"><span style="margin-left:40px;font-weight:900">SUB TOTAL</span></td>
          <td class="text-right"><td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($obat_gudang_tanpa_gudang)}}</b></span></td>
        </tr>
      @endif --}}

      {{-- TINDAKAN KAMAR --}}
      {{-- <tr><th class="dotTop" colspan="4">TINDAKAN</th></tr> --}}
      @php
          $tindakan_igd = 0;
          $tindakan_rajal = 0;
          $tindakan_inap = 0;
          $tindakan_operasi = 0;
      @endphp
      {{-- FOLIO RAJAL --}}


      {{-- @if (substr($reg->status_reg, 0, 1) !== 'I') --}}
      @if (count($folio_rajal) > 0 || $rad_irj >0 || $lab_irj>0 || $obat_gudang_rajal > 0)
      <tr>
        <th style="text-align: start;">RINCIAN BIAYA RAJAL</th>
        <th>HARGA</th>
        <th>JUMLAH</th>
        <th>TOTAL</th>
      </tr>
        @foreach ($folio_rajal as $key => $item)
          @php
            $tindakan_rajal += $item->total;
            // @$jml = @floor(@$item->total / @$item->tarif->total);
            if($item->verif_kasa_user =='tarif_new'){
              @$jml = @floor(@$item->total / @$item->tarif_baru->total);
            }else{
              @$jml = @floor(@$item->total / @$item->tarif->total);
            }
          @endphp
          <tr style="font-size:17px;">
            <td class="text-center" ><span>{{@$item->namatarif}}
              @if ($item->tarif->visite == 'Y')
                @php
                   @$ran = \App\Rawatinap::where('registrasi_id',$item->registrasi_id)->first();
                @endphp
                - {!!'<b>'.baca_dokter(@$ran->dokter_id).'</b>'!!}
                @endif
            </span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
            <td class="text-center">{{@$jml}}</td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
          </tr>

        @endforeach
        @endif
        @if ($obat_gudang_rajal >0) {{-- RAD INAP --}}
        <tr style="font-size:17px;">
          <td colspan="3"><span style="margin-left:40px;font-weight:900">Farmasi Rajal</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($obat_gudang_rajal)}}</span></td>
        </tr>    
        @endif
        @if ($rad_irj >0) {{-- RAD RAJAL --}}
        <tr style="font-size:17px;">
          <td colspan="3"><span style="margin-left:40px;font-weight:900">Radiologi</span></td>
          <td><span style="color:grey;"><center>Rp. {{number_format($rad_irj)}}</center></span></td>
        </tr>    
        @endif
        @if ($lab_irj >0) {{-- LAB RAJAL --}}
        <tr style="font-size:17px;">
          <td colspan="3"><span style="margin-left:40px;font-weight:900">Laboratorium RAJAL</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($lab_irj)}}</span></td>
        </tr>    
        @endif
        @if ($lab_irj >0 || $tindakan_rajal>0 || $rad_irj > 0) {{--JIKA ADA FOLIO RAJAL ATAU LAB--}}
        {{--<tr style="font-size:17px;">
          <td colspan="3"><span style="margin-left:40px;font-weight:900">Total Rajal</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$tindakan_rajal+@$lab_irj+@$rad_irj+@$obat_gudang_rajal)}}</b></span></td>
        </tr>--}}
        <tr><td colspan="4"><div style="height:15px;"></div></td></tr>
        @endif
        {{-- END FOLIO RAJAL --}}
      {{-- @endif --}}
      {{-- BIAYA TINDAKAN OPERASI --}}
      @php
          $total_operasi = 0
      @endphp
      @if (count($operasi) > 0 || $obat_gudang_operasi > 0)
      <tr style="font-size:17px;">
        <th style="border-bottom:1px solid;border-top:1px solid black; text-align:star;">RINCIAN BIAYA OPERASI<br/></th>
        <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black"></th>
        <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black"></th>
        <th class="text-right">TOTAL</th>
      </tr>
          
        @foreach ($operasi as $item)
        @php
            // @$jml_operasi = @floor(@$item->total / @$item->tarif->total);
            @$total_operasi += $item->total;
        @endphp
            <tr>
              <td colspan="3">
                <span style="margin-left:40px;">{{@$item->tarif->kategoritarif->namatarif}} - {{$item->namatarif}}</span><br>
                @if ($item->tarif->bedah == 'Y')
                  <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                @elseif($item->tarif->anestesi == 'Y') 
                  <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                @else
                  <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                  {{-- <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span> --}}
                @endif
              </td>
              <td style="vertical-align:top;"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
        @endforeach
        
      @endif
      @if ($obat_gudang_operasi >0) {{-- OBAT OPERASI --}}
      <tr>
        <td colspan="3"><span style="margin-left:40px;font-weight:900">Obat Operasi</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($obat_gudang_operasi)}}</span></td>
      </tr>    
      @endif

      <br>
      @if ($obat_gudang_operasi >0 || $total_operasi >0)
      <tr style="font-size:17px;">
        <td colspan="3"><span style="margin-left:40px;font-weight:900">Total Operasi</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_operasi+@$obat_gudang_operasi)}}</b></span></td>
      </tr>
      @endif
      {{-- BIAYA LABOR --}}
      {{-- <tr><th class="dotTop" colspan="2">LABORATORIUM</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($lab)}}</b></span></td> --}}
      {{-- <tr><th class="dotTop" colspan="2">RADIOLOGI</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($rad)}}</b></span></td> --}}
      <tr><th class="dotTop text-right" colspan="3">TOTAL BIAYA</th><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$tindakan_rajal+@$lab_irj+@$rad_irj+@$obat_gudang_rajal+$total_operasi+@$obat_gudang_operasi)}}</b></span></td>
      {{-- <tr><th class="dotTop text-right" colspan="3">TOTAL BIAYA</th><td class="text-right dotTop">{{number_format($tindakan+$rad)}}</td> --}}
      </table>
          {{-- <p style="text-align:right;"><b> Total Biaya Perawatan: {{ number_format($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }}</b></p>
          
          <p><i>Terbilang: {{ terbilang($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }} Rupiah</i></p> --}}
      <br/>
           <table style="width: 100%;">
            {{-- <th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}
              <br><br>
              @php
                  $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
              @endphp
              <img src="{{ asset('/images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt="">
              <br><br>
              <i><u>{{ $norah->nama }}</u></i></th> --}}
        
            <tr>
              @php
              $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
              @endphp
              <td style="width: 50%;" class="text-center">
                Manager Administrasi
                <br>
                <img src="{{ asset('/images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt="">
                <br>
                {{baca_pegawai(390)}}
              </td>
              <td style="width: 50%;" class="text-center">
                Petugas Administrasi
                {{-- {{ configrs()->kota }}, {{ date('d-m-Y') }} --}}
                <br><br><br><br><br>
                {{ Auth::user()->name }}<br>
              </td>
            </tr>
          </table> 

  </body>
</html>
