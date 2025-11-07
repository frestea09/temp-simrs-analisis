<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Rencana Kontrol</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ public_path('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 2cm;
          margin-right: 2cm;
          padding-bottom: 2cm;
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
  {{-- @foreach ($rencana_kontrol as $rencana_kontrol) --}}
    <body> 
      @if (isset($proses_tte))
        <div class="footer">
          Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
        </div>
      @endif
      <div class="row">
        <div style="text-align: center;">
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
        </div>
        <hr>
        <div class="col-sm-12 text-center"> 
          <h5><u><b>SURAT KONTROL</b></u></h5>
        <br>
      </div>
      <div class="row">
        <div class="col-sm-12 text-left"> 
          <p> 
            Bersama ini kami kirimkan kembali penderita :
          </p>
        <br>
      </div>
          <table style="width: 100%;">
            <tbody class="table table-borderless">
            <tr> 
                <td> <b>No. Rencana Kontrol</b> </td>
                <td>:</td>
                <td> {{ @$rencana_kontrol->no_surat_kontrol }} </td>
            </tr>
            <tr> 
                <td> <b>No. SEP</b> </td>
                <td>:</td>
                <td> {{ @$rencana_kontrol->no_sep }} </td>
            </tr>
            <tr>
                <td> <b>Tgl.Rencana Kontrol</b> </td>
                <td>:</td>
                <td> {{ tgl_indo(@$rencana_kontrol->tgl_rencana_kontrol) }} </td>
            </tr>
            <tr>
                <td> Nama </td>
                <td>:</td>
                <td> {{ @$rencana_kontrol->registrasi->pasien->nama}} </td>
            </tr>
            <tr>
                <td> Jenis Klamin / Umur</td>
                <td>:</td>
                <td> {{ @$rencana_kontrol->registrasi->pasien->kelamin }} / {{ hitung_umur(@$rencana_kontrol->registrasi->pasien->tgllahir) }}</td>
            </tr>
            <tr>
                <td>Poli Tujuan</td>
                <td>:</td>
                <td>{{ baca_poli(@$rencana_kontrol->poli_id) }}</td>
            </tr>
            <tr>
                <td> No. RM </td>
                <td>:</td>
                <td> {{ @$rencana_kontrol->registrasi->pasien->no_rm }} </td>
            </tr>
            <tr>
                <td> No. BPJS </td>
                <td>:</td>
                <td> {{ @$rencana_kontrol->registrasi->pasien->no_jkn }} </td>
            </tr>
            <tr>
                <td> Alamat </td>
                <td>:</td>
                <td> {{ @$rencana_kontrol->registrasi->pasien->alamat }} </td>
            </tr>
            <tr>
                <td> Pasien masuk tanggal </td>
                <td>:</td>
                <td> {{ @tanggal($rencana_kontrol->registrasi->created_at) }} </td>
            </tr>
            <tr>
                <td> Diagnosa </td>
                <td>:</td>
                {{-- <td> {!! @Modules\Icd10\Entities\Icd10::where('nomor', $rencana_kontrol->diagnosa_awal)->first()->nama; !!} </td> --}}
                <td> {!! @Modules\Icd10\Entities\Icd10::where('nomor', $rencana_kontrol->diagnosa_awal)->first() ? @Modules\Icd10\Entities\Icd10::where('nomor', $rencana_kontrol->diagnosa_awal)->first()->nama : $rencana_kontrol->diagnosa_awal; !!} </td>
            </tr>
            {{--<tr>
                <td style="vertical-align:top"> Telah dilakukan pengobatan/tindakan </td>
                <td style="vertical-align:top">:</td>
                <td>....................................................................................<br/>
                  ....................................................................................<br/>
                  ....................................................................................<br/>
                  ....................................................................................
                </td>
            </tr>--}}
            {{--<tr>
                <td style="vertical-align:top"> Kontrol Pada hari/tgl </td>
                <td style="vertical-align:top">:</td>
                <td>1.............................../...............................Jam : ..........<br/>
                    2.............................../...............................Jam : ..........<br/>
                    3.............................../...............................Jam : ..........<br/>
                    4.............................../...............................Jam : ..........<br/>
                </td>
            </tr>--}}
            {{-- <tr>
                <td> Dokter Pengirim </td>
                <td>:</td>
                <td> {{ baca_dokter($rencana_kontrol->dokter_pengirim) }} </td>
            </tr> --}}
            {{-- <tr>
                <td> Pasien Memerlukan Kamar Perawatan </td>
                <td>:</td>
                <td> {{ $rencana_kontrol->jenis_kamar }} </td>
            </tr> --}}
            {{-- <tr>
                <td> Penjamin Pasien Selama Perawatan </td>
                <td>:</td>
                <td> {{ baca_carabayar($rencana_kontrol->carabayar) }} </td>
            </tr> --}}
            </tbody>
          </table>
          <br>
          <br>
        <div class="text-center" style="padding: 5px; float:right;">
          {{--{{configrs()->kota}}, {{ date('d-m-Y') }}<br>--}}
          Mengetahui DPJP <br>
          <br>
          <br>
          @if (isset($proses_tte))
              <br>
              #
              <br>
              <br>
              <br>
              <br>
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
              <br>
          @endif
            {{ baca_dokter($rencana_kontrol->dokter_id) }}
          <hr>
        </div>
      </div>
    </body>
  {{-- @endforeach --}}
</html>
