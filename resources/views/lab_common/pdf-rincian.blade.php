<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
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
        margin-top: 0.5em;
        margin-bottom: 0.5em;
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
    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif
    <table border=0 style="width: 100%;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:17px;">LABORATORIUM PATOLOGI ANATOMIK</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
        </td>
      </tr>
    </table>
    <hr>
    <br>
    <table style="width: 100%;padding-left:25px;">
      <tbody style="font-size: 8pt; ">
        <tr>
          <th style="width: 17%">Kepada Yth</th> <td style="font-size: 11px;">: {{ baca_dokter($hasillab->dokter_id) }} </td>
        </tr>
        <tr>
          <th style="width: 17%">Bagian</th> <td style="font-size: 11px;">: {{ baca_poli(@$reg->poli_id) }} </td>
        </tr>
        <tr>
          <th style="width: 17%">Rs/Praktek</th> <td style="font-size: 11px;">: {{ strtoupper(configrs()->nama) }} </td>
        </tr>
      </tbody>
    </table>
    <br>
    {{-- <p style="padding-left:20px;">
      =======================================================================================
    </p> --}}
        <table style="width: 100%;padding-left:25px;">
        <tbody style="font-size: 8pt; ">
          <tr>
            <th>No Sediaan</th>
            <td>: {{ $hasillab->no_sediaan ?? '-' }}</td>
            <th>Di Terima Tanggal</th>
            <td>:
              {{ date('d-M-Y',  strtotime($hasillab->tgl_pemeriksaan))}} {{ $hasillab->jam }}
            </td>
          </tr>
          <tr>
            <th>Nama Pasien</th> <td>: {{ $reg->pasien->nama }}</td>
            <th>Di Jawab Tanggal</th>
            <td>:
              {{ date('d-M-Y',  strtotime($hasillab->tgl_hasilselesai))}} {{ $hasillab->jamkeluar }}
            </td>
          </tr>
          <tr>
            <th style="width: 17%">No. RM</th> <td>: {{ $reg->pasien->no_rm }}</td>
            <th>Keterangan Klinis</th> <td>: {{ @$reg->keterangan_klinis}}</td>
          </tr>
          {{-- <tr>
            <th>Ruang</th> 
            <td>: 
              @if (substr($reg->status_reg,0,1) == 'G' || substr($reg->status_reg,0,1) == 'J')
              {{ baca_poli($reg->poli_id) }}
              @elseif ($reg->status_reg == 'I1')
              Antrian Rawat Inap
              @elseif ($reg->status_reg == 'I2')
              {{ baca_kamar(\App\Rawatinap::where('registrasi_id',$reg->id)->first()->kamar_id) }}
              @endif
            </td>
            <th style="width: 17%">Dokter Pemeriksa</th> <td style="font-size: 11px;">: {{ baca_dokter($hasillab->penanggungjawab) }}</td>
          </tr> --}}
          {{-- <tr>
            <th>Alamat</th> <td>: {{ isset($reg->pasien->alamat) ? $reg->pasien->alamat : '-' }}</td>
            <th style="width: 17%">Dokter Pemeriksa</th> <td style="font-size: 11px;">: {{ baca_dokter(@$hasillab->penanggungjawab) }}</td>
          </tr> --}}
          <tr>
            <th>Usia</th> <td>: {{ hitung_umur($reg->pasien->tgllahir) }}</td>
          </tr>
        </tbody>
      </table>
      <br>
      {{-- <p style="padding-left:20px;">
        =======================================================================================
      </p> --}}
      <table style="width:100%; padding-left:30px;">
        {{-- <thead> --}}
          {{-- <tr> --}}
            {{-- <th style="width: 30%;">PEMERIKSAAN</th> --}}
            {{-- <th class="text-center" style="padding-right:50px; width: 70%;">HASIL</th> --}}
            {{-- <th class="text-center">PENGAMBILAN</th> --}}
            {{-- <th class="text-center" style="padding-right:50px;">STANDART</th> --}}
            {{-- <th class="text-center" style="padding-right:50px;">SATUAN</th> --}}
          {{-- </tr> --}}
        {{-- </thead> --}}

        <tbody>
          @php $kat = 0; @endphp
            @foreach ($rincian as $item)
              @if($item->labkategori_id != $kat)
              <tr class="_border">
                <td style="padding-top:10px;"> <b> {{ App\Labkategori::where('id',$item->labkategori_id)->first()->nama }}</b></td>
              </tr>
              @else
                =
              @endif

              @if($kat != 0 && $item->labkategori_id != $kat)
              <tr class="">
               <td style="font-weight: bold;"><br/>{{ $item->laboratoria->nama }} :</td>
              @else
              <tr>
                <td style="font-weight: bold;"><br/>{{ $item->laboratoria->nama }} :</td>
              @endif
              </tr>
              <tr>
                <td style=" word-wrap: break-word;">{!! nl2br(str_replace('<', '&lt;', $item->hasiltext)) !!}</td>
              </tr>
                @php $kat = $item->labkategori_id; @endphp
            @endforeach
        </tbody>
      </table>

      {{-- <p style="padding-left:30px; margin-top: 10px;"> --}}
        <br>
        <b style="padding-left:35px; margin-top: 50px">Kesimpulan :</b> 
        <div style="padding-left:35px;">
          @if($hasillab->pesan ){!! $hasillab->pesan !!} @else <i> Tidak Ada Kesimpulan </i> @endif
        </div>
      {{-- </p> --}}
      <br>

      {{-- <p style="padding-left:30px;"> --}}
        <div style="padding-left:35px;">
          <b>Saran :</b>
          @if($hasillab->saran ){!! $hasillab->saran !!} @else <i> Tidak Ada Saran </i> @endif
        </div>
      {{-- </p> --}}
        <br>
      {{-- <p style="padding-left:30px;"> --}}
        <div style="padding-left:35px;">
          <b>Catatan :</b> 
          @if($hasillab->kesan ){!! $hasillab->kesan !!} @else <i> Tidak Ada Catatan </i> @endif
        </div>
      {{-- </p> --}}
      
      {{-- <p style="padding-left:20px;">
        =======================================================================================
      </p> --}}
      {{-- <br>  --}}
      {{-- <p style="padding-left:30px;">
        <i> HASIL KELUAR: {{ $hasillab->jamkeluar }} </i> , <i> PENGAMBILAN: {{ date('d-M-Y',  strtotime($hasillab->tgl_hasilselesai))}} {{ $hasillab->jam }}</i>
       </p> --}}
        {{-- <p style="padding-left:0px;">
          <i style="padding-left:30px;">Dicetak pada: {{ date('d-M-Y H:i:s') }}</i> 
        </p> --}}
        
        {{-- <br> <br> --}}
{{--         
        <p style="padding-left:30px;">
         <i> PENGAMBILAN: {{ date('d-M-Y',  strtotime($hasillab->tgl_hasilselesai))}} {{ $hasillab->jam }}</i>
        </p>
        <i style="padding-left:30px;">Dicetak pada: {{ date('d-M-Y H:i:s') }}</i> 
      <br>
      <br>
         <div class="text-center" style="padding: 5px; float:right;">
          {{ config('app.kota') }}, {{ date('d-M-Y',  strtotime($hasillab->tgl_hasilselesai))}}
          <br>
          <br>
          <br>
          <br>
          <u>{{ Auth::user()->name }}</u><br>

          <hr>
        </div> --}}
        <table border=0 style="width:100%">
          <tr>
              <td colspan="4" scope="row" style="width:200px;padding-left:20px"></td>
              <td style="text-align:left;"></td>
              <td style="text-align:left;"></td>
              <td style="text-align:left;"></td>
              <td style="text-align:left;"><br><br></td>
          </tr>
      
          <tr>
              <td colspan="4" scope="row" style="width:200px;padding-left:20px"></td>
              <td style="width:140px;text-align:center;"></td>
              <td style="width:140px;text-align:center;width:170px;"></td>
              <td style="width:140px;text-align:center;"></td>
              {{-- <td style="width:140px;text-align:center;">{{ config('app.kota') }}, {{ date('d-M-Y',  strtotime($hasillab->tgl_hasilselesai))}}</td> --}}
              <td style="width:140px;text-align:center;">Terimakasih atas kepercayaan TS</td>
          </tr>

          <tr style="border: 1px solid black">
              <td colspan="4"> </td>
              <td></td>
              <td></td>
              <td></td>
              <td style="text-align: center;">
                  @if (isset($proses_tte))
                    <br><br><br>
                      #
                      <br><br><br>
                  @elseif (isset($tte_nonaktif))
                      @php
                          $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                      @endphp
                      <img src="data:image/png;base64, {!! $base64 !!} ">
                  @else
                    <br><br><br>
                      &nbsp;
                      <br><br><br>
                  @endif
              </td>
          </tr>
          <tr>
          {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
              <td colspan="4" scope="row" style="width:170px;">
              <td style="width:80px;text-align:center;"></td>
              <td style="width:140px;text-align:center;"></td>
              <td style="width:80px;text-align:center;"></td>
              @if (isset($proses_tte) || isset($tte_nonaktif))
                <td style="width:80px;text-align:center;">({{ Auth::user()->pegawai->nama  }})</td>
              @else
                <td style="width:80px;text-align:center;">({{ baca_dokter($dokter_id) }})</td>
              @endif
          </tr>
          <tr>
              <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
              <td></td>
              <td></td>
              <td><div style='margin-top:10px; text-align:center;'></div></td>
          </tr>
  </table>
  </body>
</html>