<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Hasil Radiologi</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ public_path('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 2cm;
          margin-right: 2cm;
          padding-bottom: 1cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
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

    <table style="width: 100%; margin-left: 10px;">
      <tr>
        <td style="width:30%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 80px; float: left;">
        </td>
      </tr>
    </table>

    <div class="row">
      <div class="col-sm-12 text-center">
          <h4>{{config('app.nama_rs')}}</h4>
          <h5>INSTALASI RADIOLOGI</h5>
          <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
          <hr>
          <h5>HASIL PEMERIKSAAN RADIOLOGI</h5>
      </div>
        <table style="width: 100%;font-family: Times New Roman, serif !important;font-size: 15px;" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td> Nomer RM</td>
              <td>:</td>
              <td> {{ @$radiologi->no_rm }} </td>

              <td>Umur </td>
              <td>:</td>
              <td> {{ hitung_umur(@$radiologi->tgllahir) }} </td>
            </tr>
            <tr>
              <td> Nama Pasien</td>
              <td>:</td>
              <td> {{ @$radiologi->nama }} </td>

              <td> Pemeriksaan </td>
              <td>:</td>
              <td>

                @if ($count == 2)
                  @foreach (@$tindakan as $item)
                    - {{ @$item->namatarif }}<br/>
                  @endforeach
                @else
                  {{@$tindakan->namatarif}}
                @endif
              </td>
              {{-- <td> No.Foto </td>
              <td>:</td>
              <td>
                @if ($count == 2)
                    @foreach ($tindakan as $item)
                      - {{ @$item->no_foto }}<br/>
                    @endforeach
                  @else
                    {{@$tindakan->no_foto}}
                  @endif
              </td> --}}
            </tr>
            <tr>
              <td> Alamat </td>
              <td>:</td>
              <td> {{ @$radiologi->alamat }} </td>

              @if (@$radiologi->pengirim)
              <td> Kepada Yth.</td>
              <td>:</td>
              <td>  {{  baca_dokter(@$radiologi->pengirim)}} </td>
              @endif
            </tr>
            {{-- <tr>
              <td> Diagnosa </td>
              <td>:</td>
              <td> 
                @if ($count == 2)
                  @foreach ($tindakan as $item)
                    - {{ $item->diagnosa }}<br/>
                  @endforeach
                @else
                  {{$tindakan->diagnosa}}
                @endif
              </td>
            </tr> --}}
          </tbody>
        </table>
        <hr>
          {{-- <h5 style="margin-bottom: 0; margin-top: 10px;">Tindakan :
            @foreach ($folio as $item)
              {{ !empty($item->tarif_id) ? baca_tarif($item->tarif_id) : '' }},
            @endforeach
           </h5> --}}
          {{-- <h5 style="margin-bottom: 0; margin-top: 10px;font-family: Times New Roman, serif !important">Ekpertise :</h5> --}}
          <div style=" padding: 0px 5px; font-family: Times New Roman, serif !important;font-size: 15px; margin: 0px 5px;">
            <span>Kepada Yth TS</span><br><br>
            {!! nl2br(@$radiologi->ekspertise) !!}
            {{-- {{ html_entity_decode( @$radiologi->ekspertise ) }} --}}
          </div>




          <div class="text-center" style="padding: 5px; float:right;">
            <br>
            <table>
              <tr>
                <td><u>Bandung,  {{ \Carbon\Carbon::parse(@$radiologi->tanggal_eksp)->format('d-m-Y') }}</u></td>
              </tr>
              <tr>
                <td> Dokter Yang Memeriksa</td>
              </tr>
            </table>
            @if (isset($proses_tte))
              {{-- <img src="{{public_path('barcode-tte-kominfo.jpeg')}}" style="width: 80px;" alt=""><br> --}}
              <br><br><br>#!<br><br><br><br><br>
            @elseif (isset($tte_nonaktif))
              @php
                $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
              @endphp
              <img src="data:image/png;base64, {!! $base64 !!} "> <br>
            @else
              <br>
              <br>
              <br>
              <br>
            @endif
            <u>{{ @$dokter ? @$dokter->nama : Auth::user()->name }}</u><br>
            {{-- <u>{{ @Auth::user()->name }}</u><br> --}}
              NIP {{ !empty($dokter) ? $dokter->nip : '' }}
          </div>
          <div class="text-left" style="padding: 5px; float:left;">
            <br>
            Terima kasih atas kepercayaan Rekan Sejawat
            <br>
            <br>
            <table>
              <tr>
                <td>Tanggal Pemeriksaan</td>
                <td>: {{ @$folio->waktu_periksa ? date('d-m-Y H:i:s', strtotime(@$folio->waktu_periksa)) : @$folio->created_at->format('d-m-Y H:i:s') }}</td>
              </tr>
              <tr>
                <td>Tanggal Hasil</td>
                <td>: {{ date('d-m-Y H:i:s', strtotime(@$radiologi->created_at)) }}</td>
              </tr>
            </table>
            <br>
            <br>
            <br>
            <br>
          </div>




    </div>
  </body>
</html>
