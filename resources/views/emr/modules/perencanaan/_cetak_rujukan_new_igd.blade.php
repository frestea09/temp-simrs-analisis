<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Pengantar Rawat Inap</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
   <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 3cm;
          margin-right: 3cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }

      @page {
            padding-bottom: .3cm;
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
    {{-- @if (isset($cetak_tte)) --}}
        <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
        </div>
    {{-- @endif --}}
     <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.@configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
          <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;"><u>SURAT PENGANTAR RAWAT INAP</u></h3>
              </td>
            </tr>
            {{-- <tr>
                <td style="text-align: center">
                    <span style="font-size:12px;">Nomor : {{ $cetak->nomor}} / RSUD-YANMED</span><br/>
                  </td>
            </tr> --}}
          </table>
          <br/>
          <table border=0 style="width: 100%;">
            <tr>
              <td style="width:200px !important;"><span>No.SPRI</span></td>
              <td>: {{ $spri->no_spri ?? '-' }}</td>
            </tr>
            <tr>
              <td style="width:200px !important;"><span>No. CM</span></td>
              <td>: {{$pasien->no_rm}}</td>
            </tr>
            <tr>
              <td><span>Nama Pasien</span></td>
              <td>: {{$pasien->nama}}</td>
            </tr>
            <tr>
              <td style=""><span>Alamat</span></td>
              <td>: {{$pasien->alamat}}</td>
            </tr>
            <tr>
              <td ><span> Tgl. Lahir</span></td>
              <td>: {{ date("d-m-Y", strtotime($pasien->tgllahir)) }}</td>
              <td></td>
            </tr>
            <tr>
              <td ><span> Usia</span></td>
              <td>: {{@hitung_umur($pasien->tgllahir, 'Y')}}</td>
              {{-- <td><span>:</span></td> --}}
              <td></td>
            </tr>
            
            <tr>
              <td ><span> Cara Bayar</span></td>
              <td>: {{baca_carabayar($cetak->registrasi->bayar)}}</td>
              {{-- <td><span>:</span></td> --}}
              <td></td>
            </tr>
            
            {{-- <tr>
                <td ><span> Jenis Kelamin</span></td>
                <td>: {{ ($pasien->kelamin == 'L') ? 'Lk' : 'Pr' }}</td>
                <td></td>
              </tr> --}}
            
            {{-- <tr>
                <td style=""><span>Pekerjaan</span></td>
                <td>: {{ @baca_pekerjaan($pasien->pekerjaan_id)}}</td>
              </tr> --}}
              {{-- <tr>
                <td style=""><span>No BPJS</span></td>
                <td>: {{$pasien->no_jkn}}</td>
              </tr> --}}
              <tr>
                <td style=""><span>Mulai tanggal rawat</span></td>
                <td>: {{ date("d-m-Y", strtotime($cetak->tgl_kontrol)) }}</td>
              </tr>
              {{-- <tr>
                <td style=""><span>Sampai tanggal rawat</span></td>
                <td>:  {{ date("d-m-Y", strtotime($cetak->tgl_selesai)) }}</td>
              </tr> --}}
              <tr>
                <td style=""><span>Kebutuhan ruangan</span></td>
                <td>:  {{ $cetak->kebutuhan_ruangan }}</td>
              </tr>
              <tr>
                <td style=""><span>Dokter Pengirim</span></td>
                <td>:  {{baca_dokter($cetak->dokter_igd_id)}}</td>
              </tr>
              <tr>
                <td style=""><span>Dokter DPJP</span></td>
                <td>:  {{baca_dokter($cetak->dokter_dpjp_id)}}</td>
              </tr>
              {{-- <tr>
                <td style=""><span>Dokter rawat</span></td>
                <td>:  {{baca_dokter($cetak->dokter_id)}}</td>
              </tr> --}}
              <tr>
                <td style=""><span>Diagnosa dan keterangan detail </span></td>
                <td>:  
                  {{$cetak->keterangan}}
                </td>
              </tr>
              
              {{-- <tr>
                <td style=""><span>Dokter yang membuat</span></td>
                <td>:  {{baca_user($cetak->user_id)}}</td>
              </tr> --}}
              <tr>
                <td style=""><span>Rencana Terapi</span></td>
                <td>:  {{($cetak->rencana_terapi)}}</td>
              </tr>
             
          </table>
          
          <br/>
          <br/>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px">
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Kabupaten Bandung, {{date('d-m-Y')}}
            </tr>
            <tr>
              <td colspan="4" scope="row" style="width:200px;padding-left:20px">
              <td style="width:140px;text-align:center;"></td>
              <td style="width:140px;text-align:center;width:170px;"></td>
              <td style="width:140px;text-align:center;"></td>
              <td style="width:140px;text-align:center;">
                @if (isset($cetak_tte))
                <br><br>
                <span style="margin-left: 1rem;">
                    #
                </span>
                    <br>
                    <br>
                    <br>
                @elseif (isset($tte_nonaktif))
                    @php
                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @else
                  <br>
                  <br>
                  <br>
                  <br>
                @endif
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px"> </td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">
                  ({{Auth::user()->pegawai->nama}})</td>
            </tr>

        </table>
      </div>
    </div>
    {{--<p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>--}}
    
  </body>
</html>

