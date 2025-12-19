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
  <body onload="window.print()">
  {{-- <body> --}}

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
                  {{ "Rawat Inap / " }} {{baca_kelompok(@$ranap->kelompokkelas_id)}} -  {{baca_kelas(@$ranap->kelas_id)}}
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
            @if (substr(@$reg->status_reg, 0, 1) == 'G')
              @php
                  $igd = App\HistorikunjunganIGD::where('registrasi_id', $reg->id)->first();
              @endphp
              <td>Tanggal Masuk</td><td>: {{ @date('d-m-Y',strtotime(@$igd->created_at)) }}</td>
            @else
              <td>Tanggal Masuk</td><td>: {{ @$ranap ? @date('d-m-Y',strtotime(@$ranap->tgl_masuk)) :@date('d-m-Y',strtotime(@$reg->created_at)) }}</td>
            @endif
            {{-- @endif --}}
          </tr>
          <tr>
            @php
                $emr = App\Emr::where('registrasi_id', $reg->id)
            @endphp
            <td style="width:">Tanggal Lahir</td> <td>: {{ date('d/m/Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
            @if (isset($ranap->tgl_keluar))
            <td>Tanggal Keluar</td><td>: {{ @date('d-m-Y',strtotime(@$ranap->tgl_keluar))}}</td>
            @else
            <td>Tanggal Keluar</td><td>: </td>
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
       
   

      {{-- TINDAKAN KAMAR --}}
      {{-- <tr><th class="dotTop" colspan="4">TINDAKAN</th></tr> --}}
      @php
          $tindakan_igd = 0;
          $tindakan_rajal = 0;
          $tindakan_inap = 0;
          $tindakan_operasi = 0;
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
            // @$jml = @floor(@$item->total / @$item->tarif->total);
            if($item->verif_kasa_user =='tarif_new'){
              @$jml = @floor(@$item->total / @$item->tarif_baru->total);
            }else{
              @$jml = @floor(@$item->total / @$item->tarif->total);
            }
          @endphp
          <tr>
            <td><span style="text-align:start;">{{$item->namatarif}}
              @if (@$item->tarif->is_show_dokter == 'Y')
                - {!!'<b>'.baca_dokter($item->dokter_pelaksana).'</b>'!!}
              @endif
              @if (@$item->cyto != null)
              - {!!'<b>Cito</b>'!!}
               @endif
            </span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
            <td style="text-align: center;">{{@$jml}}</td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
          </tr>
          
        @endforeach
        @endif
        @if ($rad_igd >0) {{-- RAD IGD --}}
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Radiologi
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
        @if ($lab_igd >0 || $tindakan_igd > 0 || $rad_igd > 0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Total IGD</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$tindakan_igd+@$lab_igd+@$rad_igd)}}</b></span></td>
        </tr>
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
      {{-- END FOLIO IGD --}}

      

      {{-- FOLIO INAP --}}
      {{-- <tr>
        <td class="" colspan="4"><span style="text-align:start;font-weight:900">Rawat Inap</span></td>
      </tr> --}}
      @php
        $total_biaya_ranap = 0;
      @endphp
      @if (count($folio_irna) > 0 || $total_ranap >0 || $lab_inap >0 || $rad_inap > 0)
        <tr>
          {{-- <th style="text-align:start; border-bottom:1px solid;border-top:1 px solid black !important:">RINCIAN BIAYA RAWAT INAP<br/></th> --}}
          <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN BIAYA RAWAT INAP</th>
          <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black">HARGA</th>
          <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black">JUMLAH</th>
          <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
        </tr>
        
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
            // @$jml = @floor(@$item->total / @$item->tarif->total);
            if($item->verif_kasa_user =='tarif_new'){
              @$jml = @floor(@$item->total / @$item->tarif_baru->total);
            }else{
              @$jml = @floor(@$item->total / @$item->tarif->total);
            }
            // @$tindakan_irj_ina += $item->total;
          @endphp
          <tr>
            <td>
              <span style="text-align:start;">{{$item->namatarif}}
                @if (@$item->tarif->is_show_dokter == 'Y')
                - {!!'<b>'.baca_dokter($item->dokter_pelaksana).'</b>'!!}
                @endif
                @if (@$item->cyto != null)
                - {!!'<b>Cito</b>'!!}
                @endif
              </span>
            </td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
            <td style="text-align: center;">{{@$jml}}</td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            @php $total_biaya_ranap += $item->total @endphp
          </tr>
          @endforeach
          {{-- <tr>
            <td colspan="3"><span style="margin-left:80px;font-weight:900">SUB TOTAL</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_perkamar)}}</b></span></td>
          </tr>     --}}

        @endforeach
        @endif
        @if ($rad_inap >0) {{-- RAD INAP --}}
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Radiologi RANAP
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
        
        @if ($total_biaya_ranap >0 || $lab_inap >0 || $rad_inap > 0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Total RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_biaya_ranap+@$lab_inap+@$rad_inap)}}</b></span></td>
        </tr>
        @endif
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        
        {{-- JIKA ADA BANK DARAH INAP --}}
        @if (count($tindakan_bank_darah_all) > 0)
          <tr>
            <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">BANK DARAH</th>
            <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black">HARGA</th>
            <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black">JUMLAH</th>
            <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
          </tr>
          @php
            @$total_tindakan_bank_darah_all = 0
          @endphp
          @foreach ($tindakan_bank_darah_all as $key => $item)
            @php
              @$total_tindakan_bank_darah_all += $item->total;
              if($item->verif_kasa_user =='tarif_new'){
                @$jml = @floor(@$item->total / @$item->tarif_baru->total);
              }else{
                @$jml = @floor(@$item->total / @$item->tarif->total);
              }
              // @$jml = @floor(@$item->total / @$item->tarif->total);
            @endphp
            <tr>
              <td><span style="text-align:start;">{{$item->namatarif}}</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td style="text-align: center;">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
            
          @endforeach
          @if ($total_tindakan_bank_darah_all >0)
            <tr>
              <td colspan="3"><span style="text-align:start;font-weight:900">Total Bank Darah</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_tindakan_bank_darah_all)}}</b></span></td>
            </tr>
          @endif
        @endif

        {{-- JIKA ADA LAB INAP PATOLOGI --}}
        @if (count($tindakan_lab_inap_patologi) > 0)
          <tr>
            <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">Lab Patologi Anatomi RANAP</th>
            <th class="text-right" style="border-top:1px solid black;border-bottom:1px solid black">HARGA</th>
            <th class="text-center" style="border-top:1px solid black;border-bottom:1px solid black">JUMLAH</th>
            <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
          </tr>
          @php
            @$total_tindakan_lab_pa = 0
          @endphp
          @foreach ($tindakan_lab_inap_patologi as $key => $item)
            @php
              @$total_tindakan_lab_pa += $item->total;
              if($item->verif_kasa_user =='tarif_new'){
                @$jml = @floor(@$item->total / @$item->tarif_baru->total);
              }else{
                @$jml = @floor(@$item->total / @$item->tarif->total);
              }
              // @$jml = @floor(@$item->total / @$item->tarif->total);
            @endphp
            <tr>
              <td><span style="text-align:start;">{{$item->namatarif}}</span></td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($item->total/$jml)}}</span></td>
              <td style="text-align: center;">{{@$jml}}</td>
              <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
            
          @endforeach
          @if (@$total_tindakan_lab_pa > 0)
          <tr>
            <td colspan="3"><span style="text-align:start;font-weight:900">Total Lab Patologi Anatomi</span></td>
            <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format(@$total_tindakan_lab_pa)}}</span></td>
          </tr>
          @endif
        @endif
        {{-- @if (@$bank_darah_inap >0)
        <tr>
          <td colspan="3"><span style="text-align:start;font-weight:900">Bank Darah RANAP</span></td>
          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format(@$bank_darah_inap)}}</span></td>
        </tr>
        @endif --}}
        <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
        {{-- END FOLIO INAP --}}
      

      {{-- BIAYA TINDAKAN OPERASI --}}
      @php
          $total_operasi = 0
      @endphp
      @if (count($operasi) > 0)
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


                $tarif = Modules\Tarif\Entities\Tarif::find($item->tarif_id);
                $tahunTarif = Modules\Kategoritarif\Entities\Kategoritarif::find($tarif->kategoritarif_id);

            @endphp
            <tr>
              <td colspan="3">
                <span style="text-align:start;">
                @php
                  if ($item->user_id == 614 || $item->user_id == 613 || $item->user_id == 671 || $item->user_id == 800 || $item->user_id == 801 || $item->user_id == 711) {
                  echo str_replace("FRI", "FRO", $item->namatarif);
                  }
                @endphp
                </span><br>
                @if($item->verif_kasa_user =='tarif_new')
                  @if ($item->tarif_baru->bedah == 'Y')
                    <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }})&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                    @if ($item->tarif_baru->kategoritarif->namatarif == 'Tindakan perawatan pada tindakan medik operatif')
                      <span style="">Perawat Bedah</span>
                    @elseif (@$item->tarif_baru->kategoritarif->namatarif == 'Jasa Rumah Sakit Tindakan Operatif' || @$item->namatarif  == 'Tindakan Keperawatan Kat. V')

                    @else
                      <span style="">Dokter Bedah&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span>
                    @endif
                    {{-- Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}  --}}
                    @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} @endif
                    {{-- @if (@$item->perawat_ibs1 == 1) - {!!'<b>Perawat Bedah</b>'!!}  --}}
                    {{-- @elseif(@$item->perawat_ibs1 == 2)  {!!'<b>Perawat Anestesi</b>'!!}   --}}
                    {{-- @endif </span><br/> --}}
                  @elseif($item->tarif_baru->anestesi == 'Y') 
                    <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }})&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                      @if ($item->tarif_baru->kategoritarif->namatarif == 'Tindakan perawatan Anestesi')
                        <span style="">Perawat Anestesi</span>
                      @else  
                        <span style="">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                      @endif
                      @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} | 
                      @endif   
                      @if (@$item->perawat_ibs1 == 1) - {!!'<b>Perawat Bedah</b>'!!} 
                      {{-- @elseif(@$item->perawat_ibs1 == 2)  {!!'<b>Perawat Anestesi</b>'!!}   --}}
                      @endif</span>
                  @else
                    <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }}) &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                    @if (@$item->tarif_baru->nama == 'Ruang Pemulihan' || @$item->tarif_baru->kategoritarif->namatarif == 'Jasa Rumah Sakit Tindakan Operatif' || @$item->tarif->nama == 'Tindakan Keperawatan Kat. V')
                      
                    @else  
                      <span style="">Dokter Bedah&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span>
                    @endif
                    @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} @endif
                  @endif
                @else
                  @if ($item->tarif->bedah == 'Y')
                    <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }})&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                      @if ($item->tarif->kategoritarif->namatarif == 'Tindakan perawatan pada tindakan medik operatif')
                        <span style="">Perawat Bedah</span>
                      @elseif (@$item->tarif->kategoritarif->namatarif == 'Jasa Rumah Sakit Tindakan Operatif' || @$item->namatarif  == 'Tindakan Keperawatan Kat. V')

                      @else
                        <span style="">Dokter Bedah&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span>
                      @endif
                      {{-- Dokter Bedah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}  --}}
                      @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} @endif
                      {{-- @if (@$item->perawat_ibs1 == 1) - {!!'<b>Perawat Bedah</b>'!!}  --}}
                      {{-- @elseif(@$item->perawat_ibs1 == 2)  {!!'<b>Perawat Anestesi</b>'!!}   --}}
                      {{-- @endif </span><br/> --}}
                  @elseif($item->tarif->anestesi == 'Y') 
                    <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }})&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                      @if ($item->tarif->kategoritarif->namatarif == 'Tindakan perawatan Anestesi')
                        <span style="">Perawat Anestesi</span>
                      @else  
                        <span style="">Dokter Anestesi&nbsp;&nbsp;: {{baca_dokter($item->dokter_anestesi)}}</span>
                      @endif
                      @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} | 
                      @endif   
                      @if (@$item->perawat_ibs1 == 1) - {!!'<b>Perawat Bedah</b>'!!} 
                      {{-- @elseif(@$item->perawat_ibs1 == 2)  {!!'<b>Perawat Anestesi</b>'!!}   --}}
                      @endif</span>
                  @else
                    <span style="">{{ $item->namatarif }} ({{ @$tahunTarif->namatarif }}) &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
                    @if (@$item->tarif->nama == 'Ruang Pemulihan' || @$item->tarif->kategoritarif->namatarif == 'Jasa Rumah Sakit Tindakan Operatif' || @$item->tarif->nama == 'Tindakan Keperawatan Kat. V')
                      
                    @else  
                      <span style="">Dokter Bedah&nbsp;&nbsp;: {{baca_dokter($item->dokter_id)}}</span>
                    @endif
                    @if (@$item->cyto != null) - {!!'<b>Cito</b>'!!} @endif
                  @endif
                @endif 
              </td>
              <td style="vertical-align:top;"><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td>
            </tr>
        @endforeach
        
      @endif
      
      @if ($total_operasi >0)
      <tr>
        <td colspan="3"><span style="text-align:start;font-weight:900">Total Operasi</span></td>
        <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_operasi)}}</b></span></td>
      </tr>
      @endif

               {{-- OBAT OPERASI --}}
                @php
                    $total_obat_operasi = 0;
                @endphp
               @if (count($detail_obat_gudang_operasi) > 0) {{-- OPERASI --}}
               <tr>
                 <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT OPERASI</th>
                 <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
                 <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
                 <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
               </tr>
                 @foreach ($detail_obat_gudang_operasi as $key => $item)
                   @if (count($item->obat) > 0)
                    <tr>
                      <td colspan="4"><span style="text-align:start;font-weight:900">
                      
                          @php
                          $resep = substr($item->namatarif, 0, 3);
                          @endphp
                          @if ($item->user_id == 614 || $item->user_id == 613 || $item->user_id == 671 || $item->user_id == 800 || $item->user_id == 801 || $item->user_id == 711)
                          @if ($resep == 'FRD')
                            {{ str_replace('FRD', 'FRO', $item->namatarif) }}
                          @elseif($resep == 'FRI') 
                            {{ str_replace('FRI', 'FRO', $item->namatarif) }}
                          @endif  
                          @else
                              {{  $item->namatarif }}
                          @endif
                        
                      
                      </span></td>
                    {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
                    </tr>
                    @foreach ($item->obat as $items)
                      <tr>
                          <td>{{$items->masterobat->nama}}</td>
                          <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
                          <td style="text-align: center;">{{@$items->jumlah}}</td>
                          <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td>
                        </tr>
                        @php
                          $total_obat_operasi += @$items->hargajual;
                      @endphp
                    @endforeach
                   @endif
                 @endforeach
               @endif
               @if ($total_obat_operasi >0) {{-- OBAT IGD --}}
                 <tr>
                   <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat Operasi</span></td>
                   <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_obat_operasi)}}</b></span></td>
                 </tr>    
               @endif
               <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
      {{-- BIAYA LABOR --}}
      {{-- <tr><th class="dotTop" colspan="2">LABORATORIUM</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($lab)}}</b></span></td> --}}
      {{-- <tr><th class="dotTop" colspan="2">RADIOLOGI</th><td class="text-right dotTop"><td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($rad)}}</b></span></td> --}}
      
         {{-- BIAYA OBAT --}}
         @php
              $total_obat_igd = 0;
          @endphp
         @if (count($detail_obat_gudang_igd) > 0) {{-- IGD --}}
         <tr>
           <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT IGD</th>
           <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
           <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
           <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
         </tr>
           @foreach ($detail_obat_gudang_igd as $key => $item)
             {{-- @php
               @$tindakan_igd += $item->total;
               @$jml = @floor(@$item->total / @$item->tarif->total);
             @endphp --}}
             @if (count($item->obat) > 0)
              <tr>
                <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
              {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
              </tr>
              @foreach ($item->obat as $items)
              <tr>
                <td>{{$items->masterobat->nama}}</td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
               <td style="text-align: center;">{{@$items->jumlah}}</td>
               <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td> --}}
              </tr>
              @php
                  $total_obat_igd += @$items->hargajual;
              @endphp
              @endforeach
             @endif
             
           @endforeach
         @endif
         @if ($total_obat_igd >0) {{-- OBAT IGD --}}
           <tr>
             <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat IGD</span></td>
             <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_obat_igd)}}</b></span></td>
           </tr>    
         @endif
         <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
         {{--END OBAT IGD--}}


   
   
         {{-- OBAT IGD --}}
         @php
              $total_obat_inap = 0;
          @endphp
         @if (count($detail_obat_gudang_inap_null) > 0 || count($detail_obat_gudang_inap) > 0) {{-- IGD --}}
         <tr>
           <th style="border-bottom:1px solid black;border-top:1px solid black; text-align:start;">RINCIAN PEMAKAIAN OBAT RANAP</th>
           <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">HARGA</th>
           <th class="text-center" style="border-bottom:1px solid black;border-top:1px solid black">JUMLAH</th>
           <th class="text-right" style="border-bottom:1px solid black;border-top:1px solid black">TOTAL</th>
         </tr>
           @foreach ($detail_obat_gudang_inap_null as $key => $item)
              @if (count($item->obat) > 0)
                <tr>
                  <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
                </tr>
                @foreach ($item->obat as $items)
                <tr>
                    <td>{{$items->masterobat->nama}}</td>
                    {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                    <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                    <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td> --}}
                    <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
               <td style="text-align: center;">{{@$items->jumlah}}</td>
               <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td>
                  </tr>
                  @php
                      $total_obat_inap += $items->jumlahHarga;
                  @endphp
                @endforeach
              @endif
           @endforeach
           @foreach ($detail_obat_gudang_inap as $key => $item)
              @if (count($item->obat) > 0)
                <tr>
                  <td colspan="4"><span style="text-align:start;font-weight:900">{{$item->namatarif}}</span></td>
                {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($item->total)}}</span></td> --}}
                </tr>
                @foreach ($item->obat as $items)
                <tr>
                    <td>{{$items->masterobat->nama}}</td>
                    {{-- <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->jumlahHarga/$items->jumlahTotal)}}</span></td>
                    <td class="text-center"><center>{{@$items->jumlahTotal}}</center></td>
                    <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->jumlahHarga)}}</span></td> --}}
                    <td><span style="color:grey">Rp.</span><span style="float:right">{{@number_format($items->hargajual/$items->jumlah)}}</span></td>
               <td style="text-align: center;">{{@$items->jumlah}}</td>
               <td><span style="color:grey">Rp.</span><span style="float:right">{{number_format($items->hargajual)}}</span></td>
                  </tr>
                  @php
                      $total_obat_inap += @$items->hargajual;
                  @endphp
                @endforeach
              @endif
           @endforeach
         @endif
         @if ($total_obat_inap >0) 
           <tr>
             <td colspan="3"><span style="text-align:start;font-weight:900">Total Obat RANAP</span></td>
             <td><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format($total_obat_inap)}}</b></span></td>
           </tr>    
         @endif
         <tr><td colspan="4"><div style="height:5px;"></div></td></tr>
         {{-- END OBAT INAP --}}
      
      
        <tr>
        <th class="dotTop text-right"colspan="3"><div style="float:right !important;text-align:right !important;">TOTAL BIAYA</div></th>
        <td class="dotTop"><span style="color:grey">Rp.</span><span style="float:right"><b>{{number_format(@$total_obat_operasi+@$total_obat_igd+@$total_obat_inap+@$rad_inap+@$lab_inap+@$total_biaya_ranap+@$total_tindakan_bank_darah_all+@$total_tindakan_lab_pa+@$total_operasi+$tindakan_igd+@$lab_igd+@$rad_igd)}}</b></span></td>
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
                <img src="{{ asset('/images/'. @$norah->tanda_tangan) }}" style="width: 60px;" alt="">
                <br>
                {{@$norah->nama}}
              </td>
              <td style="width: 50%;" class="text-center">
                Petugas Administrasi
                {{-- {{ configrs()->kota }}, {{ date('d-m-Y') }} --}}
                <br>
                <img src="{{ asset('/images/'. @Auth::user()->pegawai->tanda_tangan) }}" style="width: 60px;" alt="">
                <br>
                <br>
                <br>
                <br>
                {{ Auth::user()->name }}<br>
              </td>
            </tr>
          </table> 

  </body>
</html>
