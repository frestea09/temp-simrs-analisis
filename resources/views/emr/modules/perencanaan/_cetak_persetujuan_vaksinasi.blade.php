<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Persetujuan Vaksinasi</title>
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
              <h3 style="font-size:17px; margin-bottom: 0; line-height: 1;"><u>FORMULIR PERSETUJUAN/IZIN TINDAKAN VAKSINASI</u></h3>
            </td>
          </tr>                    
        </table>              
          <br/>
          <table border="0" style="width: 100%;">
            <tr>
              <td colspan="2"><b>Saya yang bertanda tangan dibawah ini,</b></td>
            </tr>
            <tr>
              <td style="width: 30%; padding-left: 30px;">Nama Pemberi Cosent</td>
              <td style="width: 70%;">: {{ @$data['pemberi_consent'] }}</td>
            </tr>
            <tr>
              <td style="width: 30%; padding-left: 30px;">Alamat</td>
              <td>: {{ @$data['alamat_pemberi_consent'] }}</td>
            </tr>
            <tr>
              <td style="width: 30%; padding-left: 30px;">Nomor Passport</td>
              <td>: {{ @$data['nomor_passport'] }}</td>
            </tr>
            <tr>
              <td style="width: 30%; padding-left: 30px;">Nomor HP</td>
              <td>: {{ @$data['no_pemberi_consent'] }}</td>
            </tr>
            <tr>
              <td colspan="2" style="padding-bottom: 10px; padding-top: 10px;"><b>Dengan ini menyatakan dengan sesungguhnya telah memberikan</b></td>
            </tr>
            <tr>
              <td colspan="2" style="width: 100%; text-align: center; padding-bottom: 10px;"><b>PERSETUJUAN/IZIN</b></td>
            </tr>
            <tr>
              <td style="width: 30%;">Untuk diberikan vaksinasi</td>
              <td>:</td>
            </tr>
            <tr>
              <td style="width: 30%;">Nama</td>
              <td>: {{@$pasien->nama}}</td>
            </tr>
            <tr>
              <td style="width: 30%;">Umur</td>
              <td>: {{hitung_umur(@$pasien->tgllahir)}}</td>
            </tr>
            <tr>
              <td style="width: 30%;">Nomor Passport</td>
              <td>: {{@$data['nomor_passport']}}</td>
            </tr>
            <tr>
              <td style="width: 30%;">Tempat Tanggal Lahir</td>
              <td>: {{@$pasien->tmplahir}}, {{@$pasien->tgllahir}}</td>
            </tr>
            <tr>
              <td style="width: 30%;">Jenis Kelamin</td>
              <td>: {{ $pasien->kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
              <td style="width: 30%;">Pekerjaan</td>
              <td>: {{@$pasien->pekerjaan}}</td>
            </tr>
            <tr>
              <td style="width: 30%;">Alamat</td>
              <td>: {{@$pasien->alamat}}</td>
            </tr>
            <tr>
              <td style="width: 30%;">Nomor HP</td>
              <td>: {{@$pasien->nohp}}</td>
            </tr>
          </table>
          <br><br>
          <table border="0" style="width: 100%; border-collapse: collapse;">
              <tr>
                  <td style="width: 25%;"></td>
                  <td style="width: 25%;"></td>
                  <td colspan="2" style="width: 50%; text-align: center; padding-bottom: 10px;">
                      Soreang, {{ @$data['tanggal'] }}
                  </td>
              </tr>
              <tr>
                <td style="width: 25%; text-align: center;">Saksi dari Pihak Pasien</td>
                <td style="width: 25%; text-align: center;">Dokter</td>
                <td style="width: 25%; text-align: center;">yang membuat keterangan</td>
                <td style="width: 25%; text-align: center;">Perawat</td>
              </tr>
              <tr>
                <td style="width: 25%; vertical-align: bottom; text-align: center;">
                  @if (!empty($saksi_pasien->tanda_tangan))
                    <img src="{{public_path('images/upload/ttd/' . $saksi_pasien->tanda_tangan)}}" alt="ttd" width="100" height="50">
                  @else
                    <br><br><br><br>
                  @endif
                </td>
                <td style="width: 25%; vertical-align: bottom; text-align: center;">
                  @php
                    $dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
                  @endphp
                  <img src="data:image/png;base64, {!! $base64 !!} ">
                </td>
                <td style="width: 25%; vertical-align: bottom; text-align: center;">
                  @if (!empty($pembuat_keterangan->tanda_tangan))
                    <img src="{{public_path('images/upload/ttd/' . $pembuat_keterangan->tanda_tangan)}}" alt="ttd" width="100" height="50">
                  @else
                    <br><br><br><br>
                  @endif
                </td>
                <td style="width: 25%; vertical-align: bottom; text-align: center;">
                  @php
                      $perawat = Modules\Pegawai\Entities\Pegawai::find(@$data['perawat']);
                  @endphp
                  @if (!empty($perawat->tanda_tangan))
                    <img src="{{public_path('images/upload/ttd/' . $perawat->tanda_tangan)}}" alt="ttd" width="100" height="50">
                  @else
                    <br><br><br><br>
                  @endif
                </td>
              </tr>
              <tr>
                  <td style="width: 25%; text-align: center;">{{@$data['nama_saksi']}}</td>
                  <td style="width: 25%; text-align: center;">{{@$dokter->nama}}</td>
                  <td style="width: 25%; text-align: center;">{{@$data['pemberi_consent']}}</td>
                  <td style="width: 25%; text-align: center;">{{@$perawat->nama}}</td>
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

