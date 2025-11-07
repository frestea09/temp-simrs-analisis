<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Kir Sehat</title>
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
   

    </style>
  </head>
  <body>
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
              <h3 style="font-size:17px; margin-bottom: 0; line-height: 1;"><u>SURAT KETERANGAN KESEHATAN JASMANI</u></h3>
              {{-- <span style="line-height: 0; margin-top: 3px;">Nomor :</span> {{ @json_decode(@$kir->keterangan, true)['no_surat'] }} <br> --}}
              <span style="line-height: 0; margin-top: 3px;">Nomor :</span> {{ $kir->nomor }} <br>
              {{-- @php
                  $hasil_mcu = App\EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('type', 'hasil_mcu')->orderBy('id', 'DESC')->first();
              @endphp
              <span style="line-height: 0; margin-top: 3px;">Nomor :</span> {{ @$hasil_mcu->nomor }} <br> --}}
            </td>
          </tr>                    
        </table>              
          <br/>
          <table border="0" style="width: 100%;">
            <tr>
              <td colspan="2">Yang bertanda tangan di bawah ini menerangkan bahwa:</td>
            </tr>
            <tr>
              <td style="width: 100px;">Nama</td>
              <td>: {{ $reg->pasien->nama }}</td>
            </tr>
            <tr>
              <td style="width: 100px;">Jenis Kelamin</td>
              <td>: {{ $reg->pasien->kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
              <td style="width: 100px;">Umur</td>
              <td>: {{ \Carbon\Carbon::parse($reg->pasien->tgllahir)->age }} tahun</td>
            </tr>
            <tr>
              <td style="width: 100px;">Alamat</td>
              <td>: {{ @$reg->pasien->alamat }} Kel.{{baca_kelurahan(@$reg->pasien->village_id)}} Kec.{{baca_kecamatan(@$reg->pasien->district_id)}} Kab.{{baca_kabupaten(@$reg->pasien->regency_id)}}</td>
            </tr>
          </table>
          <br>
          <table border="0" style="width: 100%;">
            <tr>
              <td style="text-align: justify;">Telah dilakukan pemeriksaan kesehatan secara fisik dengan hasil :</td>
            </tr>
            <tr>
              <td style="text-align:center;">
                <span style="margin-left:50px;">{{ @json_decode(@$kir->keterangan, true)['hasil'] }}</span>
              </td>
            </tr>
            <tr>
              <td style="text-align: justify;">Keterangan ini diberikan untuk :</td>
            </tr>
            <tr>
              <td style="text-align:center;">
                <span style="margin-left:50px;">{{ @json_decode(@$kir->keterangan, true)['untuk'] }}</span>
              </td>
            </tr>
            <tr>
              <td style="text-align: justify;">Demikian agar yang berkepentingan maklum adanya.</td><br><br>
            </tr>
          </table>
          <table border="0" style="width: 100%; border-collapse: collapse;">
              <tr>
                  <td style="width: 50%;"><u>Data Pendukung</u></td>
                  <td style="width: 50%; text-align: center;">
                      Soreang, {{ date('d-m-Y', strtotime(@$kir->created_at)) }}<br>
                      Dokter Pemeriksa
                  </td>
              </tr>
              <tr style="height: 80px;">
                <td style="width: 50%;">
                    TB : {{
                        !empty(json_decode(@$kir->keterangan, true)['tb'])
                            ? json_decode(@$kir->keterangan, true)['tb'] . ' Cm'
                            : (isset($asesmen['tanda_vital']['TB']) ? $asesmen['tanda_vital']['TB'] . ' Cm' : '-')
                    }}<br>
                    BB : {{
                        !empty(json_decode(@$kir->keterangan, true)['bb'])
                            ? json_decode(@$kir->keterangan, true)['bb'] . ' Kg'
                            : (isset($asesmen['tanda_vital']['BB']) ? $asesmen['tanda_vital']['BB'] . ' Kg' : '-')
                    }}<br>
                    TD : {{
                        !empty(json_decode(@$kir->keterangan, true)['td'])
                            ? json_decode(@$kir->keterangan, true)['td'] . ' mmHG'
                            : (isset($asesmen['tanda_vital']['tekanan_darah']) ? $asesmen['tanda_vital']['tekanan_darah'] . ' mmHG' : '-')
                    }}<br>
                    N : {{
                        !empty(json_decode(@$kir->keterangan, true)['n'])
                            ? json_decode(@$kir->keterangan, true)['n'] . ' x/menit'
                            : (isset($asesmen['tanda_vital']['nadi']) ? $asesmen['tanda_vital']['nadi'] . ' x/menit' : '-')
                    }}<br>
                </td>                               
                  <td style="width: 50%; vertical-align: bottom; text-align: center;">
                      @if (isset($proses_tte))
                      <br><br><br>
                        #
                      <br><br><br>
                      @elseif (isset($tte_nonaktif))
                      @php
                        $dokter = Modules\Pegawai\Entities\Pegawai::where('user_id', Auth::user()->id)->first();
                        $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->sip));
                      @endphp
                        <img src="data:image/png;base64, {!! $base64 !!} ">
                      @else
                        <br><br>
                      @endif
                  </td>
              </tr>
              <tr>
                  <td style="width: 50%;"></td>
                  <td style="width: 50%; vertical-align: bottom; text-align: center;">
                      {{-- {{ baca_user($kir->user_id) }} --}}
                      {{-- dr. Rina Ayu Ekasari <br>
                      NIP. 197104012006042011 --}}
                      {{ Auth::user()->name }} <br>
                      SIP. {{ Auth::user()->pegawai->sip ?? '-' }}
                  </td>
              </tr>
          </table>        
          

        <style>

            .footer{
            padding-top: 20px;
            margin-left: 330px;
        }

        .table-border {
        border: 1px solid black;
        border-collapse: collapse;
        }

        </style>
       
      </div>
    </div>
    {{--<p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>--}}
    
  </body>
</html>

