<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Pemeriksaan Laboratorium</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style>
      ._border td{
        border-bottom: 1px dashed #000;
        border-top: 1px dashed #000;
      }
      body{
        font-size: 10pt;  
      }
      hr{ 
        display: block;
        /* margin-top: 0.5em; */
        /* margin-bottom: 0.5em; */
        /* margin-left: auto;
        margin-right: auto; */
        border-style: inset;
        border-width: 1px;
        padding-left: :30px;
      } 
      
      @page {
          padding-bottom: 1cm;
      }

      .footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 1cm;
        text-align: justify;
      }
    </style>
  </head>
  <body>
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif
    {{-- <div>
      <div>
          <img src="{{ asset('images/'.configrs()->logo) }}" class="img img-responsive" style="width: 70px;position: absolute;margin-top:-10px;padding-left:120px">
          <h6 class="text-center" style="font-size: 17pt; font-weight: bold; margin-top: -5px;">{{ strtoupper(configrs()->nama) }}</h6>
          <h4 class="text-center" style="font-weight: bold; margin-top: -5px; margin-bottom: -1px;">INSTALASI LABORATORIUM</h4>
          <p class="text-center">{{ configrs()->alamat }} {{ configrs()->tlp }} {{ configrs()->kota }}</p>
          <div style="padding-left:20px">
            
          </div>
      </div>
    </div> --}}
   
   
        
      @php
          @$lastIndex = count($hasilLab) - 1;
      @endphp
      @foreach ($hasilLab as $keys=>$itemhlab)
      <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            {{-- <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/> --}}
            {{-- <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/> --}}
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:17px;">INSTALASI LABORATORIUM PATOLOGI KLINIK</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            {{-- <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px"> --}}
          </td>
        </tr>
      </table>

      <hr>
      <h5 class="text-center" style="font-weight: bold;">HASIL PEMERIKSAAN LABORATORIUM</h5>
      <table style="width: 50%;">
          <tbody>
            <tr>
              <td style="font-size:12px;width: 40%; font-weight: bold;">Dokter Penanggungjawab</td>
              <td style="font-size:12px;font-weight: bold;">: dr. Hj. Jenny, Sp. PK</td>
            </tr>
          </tbody>
      </table>
      <p style="padding-left:20px;">
        =======================================================================================
      </p>
      <table style="width: 100%;">
        <tbody style="font-size: 8pt; ">
          <tr>
            <th style="font-weight:400;">Nama Pasien</th> <td>: {{ $reg->pasien->nama }}</td>
            <th style="width: 17%; font-weight:400;">Asal Poli/Ruangan</th> 
            <td>: 
              @if (substr($reg->status_reg,0,1) == 'G' || substr($reg->status_reg,0,1) == 'J')
              {{ baca_poli($reg->poli_id) }}
              @elseif ($reg->status_reg == 'I1')
              Antrian Rawat Inap
              @elseif ($reg->status_reg == 'I2')
              {{ baca_kamar(\App\Rawatinap::where('registrasi_id',$reg->id)->first()->kamar_id) }}
              @endif
            </td>
          </tr>
          <tr>
            <th style="font-weight:400;">No. Med Rec</th> <td>: {{ $reg->pasien->no_rm }}</td>
            <th style="font-weight:400;">Jenis Kelamin</th> <td>: {{ $reg->pasien->kelamin == 'P' ? 'Perempuan' : 'Laki - laki' }}</td>
            
          </tr>
          <tr>
            <th style="font-weight:400;">Alamat</th> <td>: {{ $reg->pasien->alamat }}</td>
            <th style="width: 17%; font-weight:400;">Dokter Pengirim</th> <td style="font-size: 11px;">: {{ baca_dokter($reg->dokter_id) }} </td>
          </tr>
          
          <tr>
            <th style="width: 17%; font-weight:400;">Usia</th> <td>: {{ hitung_umur(@$reg->pasien->tgllahir) }}</td>
            <th style="width: 17%; font-weight:400;">Tanggal Order</th> <td style="font-size: 11px;">: {{date('d-m-Y H:i',strtotime(@$lab->created_at))}}</td>
            @php
                $tgl_order = date('d-m-Y H:i:s',strtotime(@$lab->created_at));
            @endphp
          </tr>
          {{-- <tr>
            <th>Ket. Klinis</th> <td>: </td>
            
          </tr> --}}

        </tbody>
      </table>
    <p style="padding-left:20px;">
      =======================================================================================
    </p>

      <table style="width:100%;padding-bottom:30px">
        @if(is_iterable($itemhlab->jenis_pemeriksaan) && $itemhlab->total_pemeriksaan > 0)
        <thead>
            <tr><td colspan="5" class="text-center"><span>Nomor Lab: <i>{{$itemhlab->no_lab}} ({{$itemhlab->total_pemeriksaan}})</i></span></td></tr>
            <tr>
                <th class="">PEMERIKSAAN</th>
                <th class="text-center" style="padding-right:50px;">HASIL</th>
                <th class="text-center" style="padding-right:50px;">SATUAN</th>
                <th class="text-center" style="padding-right:50px;">NILAI RUJUKAN</th>
                <th class="text-center" style="padding-right:50px;">KET</th>
            </tr>
        </thead>
    
        <tbody>
            @php 
                $kat = 0;
                $groupedData = []; // Array untuk menampung data yang dikelompokkan berdasarkan sub_group
                // Mengelompokkan data berdasarkan group_test dan sub_group
                foreach ($itemhlab->jenis_pemeriksaan as $item) {
                    foreach ($item as $lab) {
                        @$groupedData[$lab->group_test][$lab->sub_group][] = $lab;
                    }
                }
            @endphp
            
            @foreach ($groupedData as $groupName => $subGroups)
                <tr class="_border">
                    <td colspan="5" style="padding-top:10px;"><b>{{ $groupName }}</b></td>
                </tr>
    
                @foreach ($subGroups as $subGroupName => $tests)
                    @if ($subGroupName)
                        
                    <tr class="_border">
                        <td colspan="5" style="padding-top:10px;"><b>{{ $subGroupName }}</b></td>
                    </tr>
                    @endif
    
                    @foreach ($tests as $lab)
                        <tr>
                            <td valign="top">{{ $lab->test_name }}</td>
                            <td class="text-center" style="padding-right:50px;">
                                @if ($lab->flag == "Abnormal")
                                    <sup>*</sup>
                                @elseif ($lab->flag == "Critical")
                                    <sup>**</sup>
                                @endif
                                {!! htmlentities($lab->result) !!}
                                {{-- {!! $lab->result !!}  --}}
                                @if (@$lab->notes)
                                    <br/>{{@$lab->notes}}
                                @endif
                            </td>
                            <td class="text-center" style="padding-right:50px;">{{ $lab->unit }}</td>
                            <td class="text-center" style="padding-right:50px;">
                                {!! (function($s){
                                  while(($d=html_entity_decode($s,ENT_QUOTES,'UTF-8'))!==$s)$s=$d;                         
                                  $s=preg_replace(['#</?(table|thead|tbody|tfoot|tr|th|td)[^>]*>#i','#<\s*br\s*/?\s*>#i',
                                                  '#<\s*p\s*>#i','#</\s*p\s*>#i'],['','[[BR]]','[[P]]','[[/P]]'],$s);      
                                  $s=preg_replace('/&(?!#\d+;|#x[0-9a-f]+;|[a-z0-9]+;)/i','&amp;',$s);                  
                                  $s=str_replace(['<','>'],['&lt;','&gt;'],$s);                                             
                                  return str_replace(['[[BR]]','[[P]]','[[/P]]'],['<br>','<p>','</p>'],$s);
                                })($lab->nilai_normal ?? '') !!}
                            </td>
                            <td class="text-center" style="padding-right:50px;">{{ $lab->flag }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
    
            <tr>
                <td colspan="5">
                    =======================================================================================
                </td>
            </tr>
        </tbody>
    @endif
          </table>
            <p style="padding-left:0px;">
              <i style="padding-left:30px;">Dicetak pada: {{$tgl_order}}</i> 
            </p>
            
            <br>
          <br>
          <div class="text-center" style="padding: 5px; float:right;">
            {{ config('app.kota') }}, {{$tgl_order}}<br/><br/><br/>
            @php
                $pegawai = \Modules\Pegawai\Entities\Pegawai::find(17); // Hj. Jenny
                $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($pegawai->nama . ' | ' . $tgl_order));
                // $base64 = '';
            @endphp
            @if ($base64)
            <br>
              <img src="data:image/png;base64, {!! $base64 !!} ">
            <br>
            @else
              <br/><br/><br/>
            @endif
            <u>{{$pegawai->nama}}</u><br>
  
            <hr>
          </div>
          <div style="float:none;clear:both"></div>
          @if ($keys !== $lastIndex)
            <div style="page-break-after: always"></div>
         @endif
          @endforeach
      
    
      {{-- <p style="padding-left:30px;">
       </p> --}}
     
         
  </body>
</html>