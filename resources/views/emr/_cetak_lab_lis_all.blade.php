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

      .break {
        page-break-after: always;
      }
    </style>
  </head>
  <body>

    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif

    @foreach ($labs_all as $key => $lab)
      @php
          $labs = $lab;
      @endphp

      <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:17px;">INSTALASI LABORATORIUM PATOLOGI KLINIK</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
          </td>
        </tr>
      </table>
      <hr>
      <h5 class="text-center" style="font-weight: bold;">HASIL PEMERIKSAAN LABORATORIUM</h5>
      <table style="width: 50%;padding-left:25px;">
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
      <table style="width: 100%;padding-left:25px;">
          <tbody style="font-size: 8pt; ">
            <tr>
              <th style="width: 17%">No. RM</th> <td>: {{ $reg->pasien->no_rm }}</td>
            </tr>
            <tr>
              <th>Nomor Lab</th> <td>: {{ $labs->response->no_ref }}</td>
              <th style="width: 17%">Dokter Pengirim</th> <td style="font-size: 11px;">: {{ baca_dokter($reg->dokter_id) }} </td>
            </tr>
            <tr>
              <th>Nama Pasien</th> <td>: {{ $reg->pasien->nama }}</td>
              <th style="width: 17%">Asal Poli/Ruangan</th> 
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
              <th style="width: 17%">Usia</th> <td>: {{ hitung_umur_by_tanggal(@$reg->pasien->tgllahir, date('Y-m-d', strtotime(@$labs->created_at))) }}</td>
              <th style="width: 17%">Tanggal Order</th> <td style="font-size: 11px;">: {{date('d-m-Y H:i',strtotime(@$labs->created_at))}}</td>
            </tr>
            <tr>
              <th>Alamat</th> <td>: {{ $reg->pasien->alamat }}</td>
              <th style="width: 17%">Tanggal Selesai</th> <td style="font-size: 11px;">: {{date('d-m-Y H:i',strtotime($labs->response->tgl_kirim))}}</td>
            </tr>
          </tbody>
      </table>
      <p style="padding-left:20px;">
        =======================================================================================
      </p>
      <table style="width:100%; padding-left:30px; padding-bottom:30px">
        <thead>
          <tr>
            <th class="">PEMERIKSAAN</th>
            <th class="text-center" style="padding-right:50px;">HASIL</th>
            <th class="text-center" style="padding-right:50px;">NILAI RUJUKAN</th>
            <th class="text-center" style="padding-right:50px;">SATUAN</th>
          </tr>
        </thead>

        <tbody>
          @php $kat = 0; @endphp
            @if ($lab->response)    
              @foreach ($labs->hasillab as $group_name => $item)
                <tr class="_border">
                  <td colspan="5" style="padding-top:10px;"> <b> {{$group_name}}</b></td>
                </tr>
                
                @foreach ($item as $lab)
                  <tr>
                    <td>{{ $lab->test_name }}</td>
                    <td class="text-center" style="padding-right:50px;">
                      @if ($lab->flag == "Abnormal")
                        <sup>*</sup>
                      @elseif ($lab->flag == "Critical")
                        <sup>**</sup>
                      @endif
                      {{-- {!! $lab->result !!}  --}}
                      {{-- {!! htmlentities($lab->result) !!} --}}
                      {!! html_entity_decode($lab->result) !!}
                      @if (@$lab->notes)
                          <br/>{{@$lab->notes}}
                      @endif
                    </td>
                    <td class="text-center" style="padding-right:50px;">{{ $lab->nilai_normal }}</td>
                    <td class="text-center" style="padding-right:50px;">{{ $lab->unit }}</td>
                  </tr>
                @endforeach
                
              @endforeach
            @endif
        </tbody>
      </table>
  
      <p style="padding-left:20px;">
        =======================================================================================
      </p>

      <br> <br>

      <p style="padding-left:0px;">
        <i style="padding-left:30px;">Dicetak pada: {{date('d-m-Y H:i',strtotime($labs->response->tgl_kirim))}}</i> 
      </p>
    
      <br>
      <br>
      <br>
      <br>
    <div class="text-center" style="padding: 5px; float:right; min-width: 300px">
      {{ config('app.kota') }}, {{date('d-m-Y H:i',strtotime($labs->response->tgl_kirim))}} <br> <br> <br>
      @if (isset($proses_tte)) 
        <br>
        #
        <br>
        <br>
        <br>
        <br>
      @elseif (isset($tte_nonaktif))
          @php
            $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . date('d-m-Y H:i',strtotime($labs->response->tgl_kirim))))
          @endphp
          <img src="data:image/png;base64, {!! $base64 !!} "> <br>
      @else
      {{-- Hasil lab bulan juli 2024 dan setelahnya dibuat ttd barcode --}}
        @if ($labs->created_at->year > 2024 || ($labs->created_at->year == 2024 && $labs->created_at->month >= 6))
          @php
            if (isset($labs->folio->dokter_pelaksana)) {
              $dokter = \Modules\Pegawai\Entities\Pegawai::find($labs->folio->dokter_pelaksana);
            } else {
              $dokter = \Modules\Pegawai\Entities\Pegawai::find($labs->dokter_id);
            }
            $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . date('d-m-Y H:i:s',strtotime($labs->response->tgl_kirim))))
          @endphp
          <img src="data:image/png;base64, {!! $base64 !!} "> <br>
        @else
          <br>
          <br>
          <br>
          <br>
          <br>
        @endif
      @endif
      <u>
        @if (isset($proses_tte) || isset($tte_nonaktif))
          {{ Auth::user()->pegawai->nama }}
        @else
          @if (isset($labs->folio->dokter_pelaksana))
            {{@baca_dokter($labs->folio->dokter_pelaksana)}}
          @else  
            {{@baca_dokter($labs->dokter_id)}}
          @endif
        @endif
      </u><br>
      <hr>
    </div>
    @if ($key + 1 != count($labs_all))
      <div class="break"></div>
    @endif
    @endforeach
  </body>
</html>