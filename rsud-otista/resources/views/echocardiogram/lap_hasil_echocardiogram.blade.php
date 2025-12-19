<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Hasil Echocardiogram</title>
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
  {{-- @foreach ($radiologi as $d) --}}
  @php
    $d = $radiologi;
  @endphp
      <table style="width: 100%; margin-left: 10px;">
        <tr>
          <td style="width:30%;">
            {{--<img src="{{ public_path('images/logorsud-old.png') }}"style="width: 80px; float: left;">--}}
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 80px; float: left;">
          </td>
        </tr>
      </table>

      <div class="row">
        <div class="col-sm-12 text-center">
          <h4>{{config('app.nama_rs')}}</h4>
          {{-- <h5>UNIT RADIOLOGI</h5> --}}
          <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
          <hr>
          <h5><u>ECHOCARDIOGRAPHY</u><br/>HASIL PEMERIKSAAN</h5>
        <br>
      </div>
          <table style="width: 100%;">
            <tbody class="table table-borderless">
              <tr>
                <td> Tanggal Pemeriksaan </td>
                <td>:</td>
                <td>  {{  $d->created_at->format('d-m-Y') }} </td>
              </tr>
              <tr>
                <td> Nama </td>
                <td>:</td>
                <td> {{ $d->nama }} </td>

                <td> Jenis Klamin / Umur</td>
                <td>:</td>
                <td> {{ $d->kelamin }} / {{ hitung_umur($d->tgllahir) }}</td>
              </tr>
              <tr>
                <td> Cara Bayar </td>
                <td>:</td>
                <td> {{ baca_carabayar($d->bayar) }} </td>

                <td> Alamat </td>
                <td>:</td>
                <td> {{ $d->alamat }} </td>
              </tr>
              <tr>
                <td> Klinik / Ruangan </td>
                <td>:</td>
                <td> 
                @if (substr($d->status_reg, 0,1) == 'I' )
                    @php
                        $irna = \App\Rawatinap::where('registrasi_id', $d->registrasi_id)->first();
                    @endphp
                    {{ $irna ? baca_kamar($irna->kamar_id) : null}}
                @else
                    {{ baca_poli($d->poli_id) }}
                @endif
                </td>
                <td> No. Rm </td>
                <td>:</td>
                <td> {{ $d->no_rm }} </td>
              </tr>
              {{-- <tr>
                  <td>Dokter Pengirim </td>
                  <td>:</td>
                  <td> {{ baca_dokter($d->dokter_pengirim) }} </td>
                  <td> Tanggal Ekpertise </td>
                  <td>:</td>
                  <td> {{ $d->tgl_ekspertises }} </td>
              </tr>
              <tr>
                <td>Dokter Radiologi</td>
                <td>:</td>
                <td> {{ baca_dokter($d->dokter_id) }} </td>
                <td>Klinis </td>
                <td>:</td>
                <td> {{ $d->klinis }} </td>
              </tr> --}}
            </tbody>
          </table>
          <hr>
          <table style="width: 100%;" border="1" cellspacing="0" cellpadding="1">
            <thead>
              <tr>
                <th class="text-center">Pengukuran</th>
                <th class="text-center">Hasil</th>
                <th class="text-center">Normal</th>
                <th class="text-center">Pengukuran</th>
                <th class="text-center">Hasil</th>
                <th class="text-center">Normal</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Aorta</td>
                <td>{{@$d->katup_katup_jantung_aorta}}</td>
                <td>20-37 mm</td>
                <td>LVEDD</td>
                <td>{{@$d->lvedd}}</td>
                <td>35-52 mm</td>
              </tr>
              <tr>
                <td>Atrium Kiri</td>
                <td>{{@$d->atrium_kiri}}</td>
                <td>15-40mm</td>
                <td>LVESD</td>
                <td>{{@$d->lvesd}}</td>
                <td>26-36mm</td>
              </tr>
              <tr>
                <td>LAVI</td>
                <td>{{@$d->global}}</td>
                <td></td>
                <td>IVSd</td>
                <td>{{@$d->ivsd}}</td>
                <td>7-11mm</td>
              </tr>
              <tr>
                <td>Ventrikel Kanan</td>
                <td>{{@$d->ventrikel_kanan}}</td>
                <td> &lt; 42mm </td>
                <td>IVSs</td>
                <td>{{@$d->ivss}}</td>
                <td></td>
              </tr>
              <tr>
                <td>Ejeksi Fraksi</td>
                <td>{{@$d->ejeksi_fraksi}}</td>
                <td> 53-77% </td>
                <td>PWd</td>
                <td>{{@$d->pwd}}</td>
                <td>7-11mm</td>
              </tr>
              <tr>
                <td>E/A</td>
                <td>{{@$d->ea}}</td>
                <td> </td>
                <td>PWs</td>
                <td>{{@$d->pws}}</td>
                <td></td>
              </tr>
              <tr>
                <td>E/e</td>
                <td>{{@$d->ee}}</td>
                <td> </td>
                <td>LVMI</td>
                <td>{{@$d->lvmi}}</td>
                <td></td>
              </tr>
              <tr>
                <td>TAPSE</td>
                <td>{{@$d->ee}}</td>
                <td> &gt; 17mm</td>
                <td>RWT</td>
                <td>{{@$d->rwt}}</td>
                <td></td>
              </tr>
            </tbody>
          </table>

          <table style="width: 100%">
          <tr>
            <td><b>Kesimpulan</b> : {!!@$d->kesimpulan!!}</td>
          </tr>
          <tr>
            <td><b>Catatan Dokter</b> : {!!@$d->catatan_dokter!!}</td>
          </tr>
          </table>
          <div class="text-center" style="padding: 5px; float:right;">
            Pemeriksa
            <br>
            @if (isset($proses_tte))
                <br>
                <br>
                <br>
                #
                <br>
                <br>
                <br>
                <br>
            @elseif (isset($tte_nonaktif))
                <br>
                <br>
                @php
                  $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                @endphp
                <img src="data:image/png;base64, {!! $base64 !!} ">
                <br>
            @else
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            @endif
            {{-- <u>{{ !empty($dokter) ? $dokter->nama : '' }}</u><br> --}}
            <u>{{ @baca_user(@$d->user_id) }}</u><br>
            {{-- SIP {{ !empty($dokter) ? $dokter->sip : '' }} --}}
            {{-- <hr> --}}
          </div>
      </div>
      {{-- @endforeach --}}
    </body>
</html>
