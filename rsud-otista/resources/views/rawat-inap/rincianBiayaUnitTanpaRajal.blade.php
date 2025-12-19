<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rincian Biaya Perawatan</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        font-size: 10pt;
        margin-left: 0.1cm;
        margin-right: 0.1cm;
      }
      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black
      }
    </style>
  </head>
  {{-- <body> --}}
    <body onload="window.print()">
    {{-- <table style="width:95%; margin-bottom: -10px;">
            <tbody>
              <tr>
                <th style="width:20%">
                  <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:95px;">
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
      <table border=0 style="width:95%;font-size:12px;"> 
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
      <table style="width:95%;margin:auto;font-size:11px;">
        <tbody>
          <tr>
            <td style="width:">No. RM</td> <td>: {{ $reg->pasien->no_rm }}</td>
            <td style="width:15%">No. SEP</td><td>: {{ optional(\App\HistoriSep::where('registrasi_id',$reg->id)->first())->no_sep ?? $reg->no_sep }}</td>
          </tr>
          <tr>
            <td style="width:15%">Nama Peserta</td><td>: {{ @$reg->pasien->nama }}</td>
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
          <tr>
            <td style="width:">Umur Tahun</td> 
            <td>: 


              @if (@$reg->pasien->tgllahir != null)
              {{hitung_umur(@$reg->pasien->tgllahir)}}
              @else
                {{ "-" }}
              @endif



            </td>
            <td>Penjamin</td><td>: {{@baca_carabayar($reg->bayar)}} {{' - '.@baca_jkn(@$reg->id)}}</td>
            
            
          </tr>
          <tr>
            <td style="width:">No. Telp</td>
            <td>:  {{$reg->pasien->nohp ? @$reg->pasien->nohp : @$reg->pasien->notlp}}</td>
            {{-- @if ($ranap) --}}
            <td>Tanggal Masuk</td><td>: {{ @$ranap ? @date('d-m-Y',strtotime(@$ranap->tgl_masuk)) :@date('d-m-Y',strtotime(@$reg->created_at)) }}</td>
            {{-- @endif --}}
          </tr>
          <tr>
            @php
                $emr = App\Emr::where('registrasi_id', $reg->id)
            @endphp
            <td style="width:">Tanggal Lahir</td> <td>: {{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
            @if ($ranap)
            <td>Tanggal Keluar</td><td>: {{ @date('d-m-Y',strtotime(@$ranap->tgl_keluar))}}</td>
            @endif
            
            
          </tr>
          <tr>

            

            <td style="width:">Jenis Kelamin</td> 
                <td>: 

                  @if (@$reg->pasien->kelamin == "L")
                        {{ "Laki-laki" }}
                  @else
                        {{ "Perempuan" }}      
                  @endif

                </td>
                @if (@$ranap)
                <td>LOS</td>
                <td>:
                  @if (@$ranap->tgl_keluar != null)
                          
                    <?php
                      $tglMasuk = \Carbon\Carbon::parse(@$ranap->tgl_masuk)->format('d-m-Y');
                      $tglKeluar = \Carbon\Carbon::parse(@$ranap->tgl_keluar)->format('d-m-Y');
                      $tgl1 = new DateTime($tglMasuk);
                      $tgl2 = new DateTime($tglKeluar);
                      $d = $tgl2->diff($tgl1)->days + 1;
                      echo $d." hari";
                    ?>
                  @else
                    {{ "-" }};  
                  @endif
                </td>
                @endif
          </tr>
          <tr>
            <td>Alamat</td> <td>: {{ @$reg->pasien->alamat }}</td>
            @if (@$ranap)
              <td>Cara Pulang</td><td>: {{ $reg->pulang ? @baca_carapulang($reg->pulang) :'' }} - {{ $reg->kondisi_akhir_pasien ? @baca_carapulang($reg->kondisi_akhir_pasien) :'' }}</td>
            @endif
          </tr>
        </tbody>
      </table>
      <br/>
      {{-- <hr/> --}}
      {{-- <h6 style="text-center"><b>RINCIAN BIAYA</b></h6> --}}
      <table style="width:95%;font-size:11px;" cellspacing="1">
       
      {{-- BIAYA OBAT --}}
      {{-- @if (count($obat_gudang) > 0)
        <tr><th colspan="4">PEMAKAIAN OBAT</th></tr>
        @foreach ($obat_gudang as $item)
        <tr>
          <td colspan="2"><span style="text-align:start;">{{$item->gudang ? $item->gudang->nama : 'Obat Farmasi'}}</span></td>
          <td class="text-right"><td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->sum)}}</span></td>
        </tr>

        @endforeach
        <tr>
          <td colspan="2"><span style="text-align:start;font-weight:900">SUB TOTAL</span></td>
          <td class="text-right"><td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($obat)}}</b></span></td>
        </tr>
      @endif --}}
      {{-- @if (count($obat_gudang) > 0)
        <tr><th colspan="4">PEMAKAIAN OBAT</th></tr>
        <tr>
          <td colspan="2"><span style="text-align:start;">Obat Farmasi</span></td>
          <td class="text-right"><td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($obat_gudang_tanpa_gudang)}}</span></td>
        </tr>
        <tr>
          <td colspan="2"><span style="text-align:start;font-weight:900">SUB TOTAL</span></td>
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
          $total_igd_keseluruhan = 0;
          $total_ranap_keseluruhan = 0;
          $total_operasi_keseluruhan = 0;
      @endphp
    

      {{-- FOLIO IGD --}}
      {{-- <tr> 
        <td><span style="text-align:start;font-weight:900">IGD</span></td>
      </tr> --}}
      @if (count($folio_igd) > 0 || $obat_gudang_igd >0 || $rad_igd >0 || $lab_igd >0)
      <tr>
        <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA IGD</th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
        <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
      </tr>
      @endif
      
      @if (count($folio_igd) > 0)

          @foreach ($folio_igd as $key => $item)
            @php
              @$tindakan_igd += $item->total;
              if($item->verif_kasa_user =='tarif_new'){
                @$jml = @floor(@$item->total / @$item->tarif_baru->total);
              }else{
                @$jml = @floor(@$item->total / @$item->tarif->total);

              }
            @endphp
            <tr>
              <td><span style="text-align:start;">{{@$item->namatarif}}
                
                @if (@$item->tarif->is_show_dokter == 'Y' || @munculkanDokterTarif($item->namatarif,'Konsultasi') || @munculkanDokterTarif($item->namatarif,'konsultasi'))
                  - {!!'<b>'.baca_dokter($item->dokter_pelaksana).'</b>'!!}
                @endif
              </span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td class="text-center">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
            
          @endforeach
        @endif
        
        @if ($obat_gudang_igd >0) {{-- Farmasi IGD --}}
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Farmasi IGD</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($obat_gudang_igd)}}</span></td>
        </tr>    
        @endif
        {{-- {{dd("A")}} --}}
        @if ($rad_igd >0) {{-- RAD IGD --}}
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Radiologi
            {{-- NAMA DOKTER RADIOLOGI MUNCULKAN --}}
            @if (count(@$dokter_rad_igd) > 0)
              @foreach (@$dokter_rad_igd as $item)
                - {!!'<b>'.baca_dokter(@$item->dokter_radiologi).'</b>'!!}
              @endforeach
            @endif
          </span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($rad_igd)}}</span></td>
        </tr>    
        @endif
        {{-- JIKA ADA LAB IGD --}}
        @if ($lab_igd >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Laboratorium IGD</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($lab_igd)}}</span></td>
        </tr>
        
        @endif
        @if ($lab_igd >0 || $tindakan_igd > 0 || $rad_igd > 0 ||$obat_gudang_igd>0)
          @php $total_igd_keseluruhan = @$tindakan_igd+@$lab_igd+@$rad_igd+@$obat_gudang_igd @endphp
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Total IGD</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_igd_keseluruhan)}}</b></span></td>
        </tr>
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
      {{-- END FOLIO IGD --}}

      

      {{-- FOLIO INAP --}}
      <tr>
        <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA RAWAT INAP</th>
        <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black">HARGA</th>
        <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black">JUMLAH</th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
      </tr>
      {{-- <tr>
        <td class="" colspan="4"><span style="text-align:start;font-weight:900">Rawat Inap</span></td>
      </tr> --}}
      @if (count($folio_irna) > 0)
        
        @foreach ($folio_irna as $kamar => $tindakan)
        
          <tr>
            <td><span style="text-align:start;font-weight:900">{!!$kamar ? baca_kamar($kamar) : '-'!!}</span></td>
          </tr>
          @php
              @$total_perkamar = 0;
          @endphp
          @foreach ($tindakan as $item)
          @php
            @$total_perkamar += $item->total;
            if($item->verif_kasa_user =='tarif_new'){
              @$jml = @floor(@$item->total / @$item->tarif_baru->total);
            }else{
              @$jml = @floor(@$item->total / @$item->tarif->total);
            }
            // @$tindakan_irj_ina += $item->total;
          @endphp
          <tr>
            <td>
              <span style="text-align:start;">{{@$item->namatarif}}
                @if (@$item->tarif->is_show_dokter == 'Y' || @munculkanDokterTarif($item->namatarif,'Konsultasi') || @munculkanDokterTarif($item->namatarif,'konsultasi'))
                - {!!'<b>'.baca_dokter($item->dokter_pelaksana).'</b>'!!}
                @endif
                
              </span>
            </td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
            <td class="text-center">{{@$jml}}</td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
          </tr>
          @endforeach
          {{-- <tr>
            <td colspan="3"><span style="margin-left:80px;font-weight:900">SUB TOTAL</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_perkamar)}}</b></span></td>
          </tr>     --}}

        @endforeach
        @endif
        @if ($obat_gudang_inap >0) {{-- RAD INAP --}}
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Farmasi RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($obat_gudang_inap)}}</span></td>
        </tr>    
        @endif
        @if ($rad_inap >0) {{-- RAD INAP --}}
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Radiologi RANAP
            {{-- NAMA DOKTER RADIOLOGI MUNCULKAN --}}
            @if (count(@$dokter_rad_inap) > 0)
              @foreach (@$dokter_rad_inap as $item)
                - {!!'<b>'.baca_dokter(@$item->dokter_radiologi).'</b>'!!}
              @endforeach
            @endif
          </span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($rad_inap)}}</span></td>
        </tr>    
        @endif
        {{-- JIKA ADA LAB INAP --}}
        @if ($lab_inap >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Laboratorium RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($lab_inap)}}</span></td>
        </tr>
        @endif
        {{-- JIKA ADA LAB INAP PATOLOGI --}}
        @if (@$lab_inap_patologi >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Laboratorium Patologi</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format(@$lab_inap_patologi)}}</span></td>
        </tr>
        @endif
        {{-- JIKA ADA BANK DARAH INAP --}}
        @if (@$bank_darah >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Bank Darah RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($bank_darah)}}</span></td>
        </tr>
        @endif
        @if ($total_ranap >0 || $lab_inap >0 || $rad_inap > 0 || $obat_gudang_inap >0)
        @php $total_ranap_keseluruhan = @$total_ranap+@$lab_inap+@$rad_inap+@$obat_gudang_inap+@$bank_darah+@$lab_inap_patologi @endphp
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Total RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_ranap_keseluruhan)}}</b></span></td>
        </tr>
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        {{-- END FOLIO INAP --}}
      

      {{-- BIAYA TINDAKAN OPERASI --}}
      @php
          $total_operasi = 0
      @endphp
      @if (count($operasi) > 0 || $obat_gudang_operasi > 0)
      <tr>
        <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA OPERASI</th>
        <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black"></th>
        <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black"></th>
        <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
      </tr>
          
        @foreach ($operasi as $item)
        @php
            // @$jml_operasi = @floor(@$item->total / @$item->tarif->total);
            @$total_operasi += $item->total;
        @endphp
            <tr>
              <td colspan="3">
                <span style="text-align:start;">{{@$item->tarif->kategoritarif->namatarif}} - {{@$item->namatarif}}  
                
                  
                  @if (isset($item->cyto))
                    <b> - <i>Cyto</i> </b>
                  @endif
                  
                </span><br>
                @if($item->verif_kasa_user =='tarif_new')
                  @if ($item->tarif_baru->bedah == 'Y')
                    @if (@$item->tarif_baru->kategoritarif->namatarif == 'Tindakan perawatan pada tindakan medik operatif')
                      <span style="margin-left:80px;font-weight:800">Perawat Bedah</span>
                    @else  
                      <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_bedah)}}</span><br/>
                    @endif
                    
                  @elseif($item->tarif_baru->anestesi == 'Y') 
                    @if (@$item->tarif_baru->kategoritarif->namatarif == 'Tindakan perawatan Anestesi')
                      <span style="margin-left:80px;font-weight:800">Perawat Anestesi</span>
                    @else  
                    <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                    @endif
                  @else
                      @if (@$item->tarif_baru->kategoritarif->namatarif == 'Tindakan perawatan pada tindakan medik operatif')
                      <span style="margin-left:80px;font-weight:800">Perawat Bedah</span>
                      @elseif (@$item->tarif_baru->kategoritarif->namatarif == 'Tindakan perawatan Anestesi')
                      <span style="margin-left:80px;font-weight:800">Perawat Anestesi</span>
                      @else
                      <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                    @endif
                    {{-- <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/> --}}
                    {{-- <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span> --}}
                  @endif
                @else
                  @if ($item->tarif->bedah == 'Y')
                    @if (@$item->tarif->kategoritarif->namatarif == 'Tindakan perawatan pada tindakan medik operatif')
                      <span style="margin-left:80px;font-weight:800">Perawat Bedah</span>
                    @else  
                      <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_bedah)}}</span><br/>
                    @endif
                    
                  @elseif($item->tarif->anestesi == 'Y') 
                    @if (@$item->tarif->kategoritarif->namatarif == 'Tindakan perawatan Anestesi')
                      <span style="margin-left:80px;font-weight:800">Perawat Anestesi</span>
                    @else  
                    <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                    @endif
                  @else
                      @if (@$item->tarif->kategoritarif->namatarif == 'Tindakan perawatan pada tindakan medik operatif')
                      <span style="margin-left:80px;font-weight:800">Perawat Bedah</span>
                      @elseif (@$item->tarif->kategoritarif->namatarif == 'Tindakan perawatan Anestesi')
                      <span style="margin-left:80px;font-weight:800">Perawat Anestesi</span>
                      @else
                      <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/>
                    @endif
                    {{-- <span style="margin-left:80px;font-weight:800">Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span><br/> --}}
                    {{-- <span style="margin-left:80px;font-weight:800">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span> --}}
                  @endif
                @endif
              </td>
              <td style="vertical-align:top;"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
        @endforeach
        
      @endif
      @if ($obat_gudang_operasi >0) {{-- OBAT OPERASI --}}
      <tr>
        <td colspan="3"><span style="text-align:start;font-weight:900">Obat Operasi</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($obat_gudang_operasi)}}</span></td>
      </tr>    
      @endif
      @if ($obat_gudang_operasi >0 || $total_operasi >0)
      @php $total_operasi_keseluruhan = @$total_operasi+@$obat_gudang_operasi @endphp
      <tr>
        <td colspan="3"><span style="text-align:start;font-weight:900">Total Operasi</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_operasi_keseluruhan)}}</b></span></td>
      </tr>
      @endif
      {{-- BIAYA LABOR --}}
      {{-- <tr><th class="dotTop" colspan="2">LABORATORIUM</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($lab)}}</b></span></td> --}}
      {{-- <tr><th class="dotTop" colspan="2">RADIOLOGI</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($rad)}}</b></span></td> --}}
        <tr>
          <th class="dotTop text-right"colspan="3"><div style="float:right !important;text-align:right !important;">TOTAL BIAYA</div></th>
          <td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_igd_keseluruhan+@$total_ranap_keseluruhan+@$total_operasi_keseluruhan)}}</b></span></td>
        </tr>
      {{-- <tr><th class="dotTop text-right" colspan="3">TOTAL BIAYA</th><td class="text-right dotTop">{{number_format($tindakan+$rad)}}</td> --}}
      </table>
          {{-- <p style="text-align:right;"><b> Total Biaya Perawatan: {{ number_format($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }}</b></p>
          
          <p><i>Terbilang: {{ terbilang($jml_irj+$jml_irj_lab+$jml_irj_rad+$jml_igd+$jml_igd_lab+$jml_igd_rad+$jml_irna+$jml_irna_lab+$jml_irna_rad+$obat+$uangracik) }} Rupiah</i></p> --}}
      <br/>
           <table style="width:95%; margin-left:70px;">
            <tr>
              @php
              $norah = Modules\Pegawai\Entities\Pegawai::where('id', '=', 390)->first();
              @endphp
              <td style="width: 50%;" class="text-center">
                Manager Administrasi
                <br>
                <img src="{{ asset('/images/'. $norah->tanda_tangan) }}" style="width: 60px;" alt="">
                <br>
                {{$norah->nama}}
              </td>
              <td style="width: 50%;" class="text-center">
                Petugas Administrasi
                {{-- {{ configrs()->kota }}, {{ date('d-m-Y') }} --}}
                <br>
                <img src="{{ asset('/images/'. @Auth::user()->pegawai->tanda_tangan) }}" style="width: 60px;" alt="">
                <br>
                {{ Auth::user()->name }}<br>
              </td>
            </tr>
          </table> 

  </body>
</html>
