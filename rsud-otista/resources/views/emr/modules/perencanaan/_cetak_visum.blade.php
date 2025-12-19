<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Visum</title>
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
  @php
    $day = date('D', strtotime(@$visum['tglPemeriksaan']));
    $dayList = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );
  @endphp
  <body onload="print()">
     <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%; text-align: end;" class="pull-right">
            <img src="{{ asset('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          {{-- <td style="width:10%;">
            <img src="{{ public_path('images/'.@configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td> --}}
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 ">
        <hr>
          <table border=0 style="width: 100%;">
            <tr>
              <td style="padding: 0px 35px 0px 35px;">Justitia</td>
            </tr>
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px; font-weight: bold;">
                  <u>VISUM ET REPERTUM</u>
                  <br>
                  <span style="font-size:12px;">Nomor : {{ @$visum['nomorVisum'] }}</span>
                </h3>
              </td>
            </tr>
          </table>
          <br/>
          <table border=0 style="width: 100%; padding: 0px 35px 0px 35px;">
            <tr style="text-align: justify;">
              <td>
                Menindaklanjuti surat dari {{ @$visum['asalSurat'] }}, 
                Nomor : {{ @$visum['nomorSurat'] }}, 
                Tanggal : {{ \Carbon\Carbon::parse(@$visum['tglSurat'])->formatLocalized('%d %b %Y') }}, 
                Perihal : {{ @$visum['perihalSurat'] }}, 
                yang ditandatangani oleh : {{ @$visum['penandaTanganSurat'] }}, 
                Pangkat : {{ @$visum['pangkat'] }}, 
                NRP : {{ @$visum['nrp'] }}, 
                atas nama {{ @$visum['atasNama'] }}, 
                yang kami terima suratnya pada tanggal : {{ \Carbon\Carbon::parse(@$visum['tglPemeriksaan'])->formatLocalized('%d %b %Y') }}.
              </td>
            </tr>
            <tr style="text-align: justify;">
              <td>
                Dengan ini <b>{{ baca_dokter(@$cetak->dokter_id) }} ({{ @$dokter->nip }})</b>, 
                dokter pada Rumah Sakit Umum Daerah Oto Iskandar Di Nata Kabupaten Bandung atas nama tim, 
                menerangkan bahwa telah dilakukan pemeriksaan pada hari {{ @$dayList[$day] }}, 
                tanggal {{ \Carbon\Carbon::parse(@$visum['tglPemeriksaan'])->formatLocalized('%d %b %Y') }}, 
                terhadap korban yang menurut surat tersebut :
              </td>
            </tr>
          </table>

          <table style="width: 100%; padding: 0px 35px 0px 35px;">
            <tr>
              <td style="width: 30%;">Nama</td>
              <td>: {{ @$pasien->nama }}</td>
            </tr>
            <tr>
              <td>Tempat, Tanggal Lahir</td>
              <td>: {{ @$pasien->tmplahir }}, {{ \Carbon\Carbon::parse(@$pasien->tgllahir)->format('d/m/Y') }}</td>
            </tr>
            <tr>
              <td>Umur</td>
              <td>: {{ hitung_umur(@$pasien->tgllahir) }}</td>
            </tr>
            <tr>
              <td>Jenis Kelamin</td>
              <td>: {{ @$pasien->kelamin }}</td>
            </tr>
            <tr>
              <td>Agama</td>
              <td>: {{ @$pasien->agama->agama }}</td>
            </tr>
            <tr>
              <td>Pekerjaan</td>
              <td>: {{ @$pasien->pekerjaan->nama }}</td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>: {{ @$pasien->alamat }}</td>
            </tr>
          </table>

          <table style="width: 100%; padding: 0px 35px 0px 35px;">
            <tr>
              <td><b>Hasil Pemeriksaan : </b></td>
            </tr>
            <tr>
              <td>
                {{ @$visum['pemeriksaanDokter'] != null ? @$visum['pemeriksaanDokter'].'<br>' : '' }}
                
                {{ @$visum['pemeriksaanPetugas'] }}
              </td>
            </tr>
          </table>

          <table style="width: 100%; padding: 0px 35px 0px 35px;">
            <tr>
              <td><b>Kesimpulan : </b></td>
            </tr>
            <tr style="text-align: justify;">
              <td>
                {{ @$visum['kesimpulan'] }}
              </td>
            </tr>
          </table>

          <table style="width: 100%; padding: 0px 35px 0px 35px;">
            <tr style="text-align: justify;">
              <td>Demikian Visum et Repertum ini dibuat dengan sebenar-benarnya mengingat Sumpah Jabatan Dokter dan Keilmuan saya.</td>
            </tr>
          </table>

          <table style="width: 100%; padding: 0px 35px 0px 35px;">
            <tr>
              <td colspan="2" style="width: 65%;">&nbsp;</td>
              <td style="text-align: center;">Dokter tersebut diatas</td>
            </tr>
            <tr>
              <td colspan="2" style="width: 65%;">&nbsp;</td>
              <td style="text-align: center;">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" style="width: 65%;">&nbsp;</td>
              <td style="text-align: center;">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" style="width: 65%;">&nbsp;</td>
              <td style="text-align: center;">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" style="width: 65%;">&nbsp;</td>
              <td style="text-align: center;">
                <u>{{ baca_dokter(@$cetak->dokter_id) }}</u><br>
                {{ @$dokter->sip != null ? @$dokter->sip : @$dokter->nip }}
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

