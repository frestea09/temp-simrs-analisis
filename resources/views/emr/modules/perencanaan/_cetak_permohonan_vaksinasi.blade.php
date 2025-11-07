<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Permohonan Vaksinasi</title>
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
              <h3 style="font-size:17px; margin-bottom: 0; line-height: 1;"><u>FORMULIR PERMOHONAN VAKSINASI</u></h3>
            </td>
          </tr>                    
        </table>              
          <br/>
          <table border="0" style="width: 100%; padding: 20px;">
            <tr>
              <td style="width: 35%;">Nama</td>
              <td>: {{ $pasien->nama }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Nomor Rekam Medis</td>
              <td>: {{ $pasien->no_rm }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Nomor Passport</td>
              <td>: {{ @$data['nomor_passport'] }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Jenis Kelamin</td>
              <td>: {{ $pasien->kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Pekerjaan</td>
              <td>: {{ $pasien->pekerjaan }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Alamat</td>
              {{-- <td>: {{ $pasien->alamat }} Kel.{{baca_kelurahan(@$reg->pasien->village_id)}} Kec.{{baca_kecamatan(@$reg->pasien->district_id)}} Kab.{{baca_kabupaten(@$reg->pasien->regency_id)}}</td> --}}
              <td>: {{ $pasien->alamat }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Nomor HP</td>
              <td>: {{ $pasien->nohp }}</td>
            </tr>
          </table>
          <br>
          <table border="0" style="width: 100%; padding: 20px;">
            <tr>
              <td style="width: 35%;">Negara Tujuan</td>
              <td>: {{ @$data['negara_tujuan'] }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Tanggal Berangkat</td>
              <td>: {{ @$data['tanggal_berangkat'] }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Jenis Vaksinasi</td>
              <td>: {{ @$data['jenis_vaksinasi'] }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Nama Travel/Agen</td>
              <td>: {{ @$data['nama_travel'] }}</td>
            </tr>
            <tr>
              <td style="width: 35%;">Alamat Travel/Agen</td>
              <td>: {{ @$data['alamat_travel'] }}</td>
            </tr>
          </table>
          <br>
          <table border="0" style="width: 100%;">
            <tr>
              <td colspan="2" style="width:100%;">
                Dengan ini memohon kepada Rumah Sakit <b>RSUD OTO ISKANDAR DI NATA</b>, agar dapat memberikan vaksinasi <b>{{@$data['jenis_vaksinasi']}}</b>
                kepada saya. Dengan ini saya juga menyatakan bahwa semua informasi yang berhubungan dengan vaksinasi ini telah saya ketahui, termasuk 
                efek sampingnya atau Kejadian Ikutan Pasca Vaksinasi.
              </td>
            </tr>
            <tr>
              <td colspan="2" style="width:100%; padding-top: 10px;">
                Demikianlah permohonan ini dibuat agar dapat dipergunakan sebagaimana mestinya.
              </td>
            </tr>
          </table>
          <br><br>
          <table border="0" style="width: 100%; border-collapse: collapse;">
              <tr>
                  <td style="width: 50%;"></td>
                  <td style="width: 50%; text-align: center;">
                      Soreang, {{ @$data['tanggal'] }}<br>
                      Pasien
                  </td>
              </tr>
              <tr style="height: 80px;">
                <td style="width: 50%;"></td>                               
                  <td style="width: 50%; vertical-align: bottom; text-align: center;">
                    @if (!empty($pasien->tanda_tangan))
                      <img src="{{public_path('images/upload/ttd/' . $pasien->tanda_tangan)}}" alt="ttd" width="200" height="100">
                    @else
                      <br><br><br><br>
                    @endif
                  </td>
              </tr>
              <tr>
                  <td style="width: 50%;"></td>
                  <td style="width: 50%; vertical-align: bottom; text-align: center;">
                    {{$pasien->nama}}
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

