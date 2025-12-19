<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0;
          /* margin-left: 0.3cm; */
      }
      .border {
        border: 1px solid black;
        border-collapse: collapse;
      }
    </style>

  </head>
  <body>
    @php
    $apgar = @json_decode(@$apgarScore->fisik, true);
  @endphp
  <div class="col-md-12">
    <h5 class="text-center"><b>BALLARD SCORE</b></h5>
    <table style="width:100%">
      <tr>
        <td style="width:100px;">NAMA</td>
        <td>: {{@$reg->pasien->nama}}</td>

        <td>TGLLAHIR/UMUR</td>
        <td>: {{hitung_umur(@$reg->pasien->tgllahir, 'Y')}}</td>
      </tr>
      
      <tr>
        <td>RUANG</td>
        <td>: {{@baca_poli($reg->poli_id)}}</td>
        <td>TANGGAL</td>
        <td>: {{date('d-m-Y',strtotime($reg->created_at))}}</td>
      </tr>
    </table>
    @php
        $ballardScore = @json_decode(@$ballardScore->fisik, true);
        $param = [
        "kulit" => [
            "nama" => "KULIT",
            "nilai" => [
            "_2" => null,
            "_1" => "Lengket friable transparan",
            "0" => "Gelantinus merah translusen",
            "1" => "Merah halus, tampak gambaran vena",
            "2" => "Permukaan terkelupas dan atau ruam tampak vena",
            "3" => "Pecah-pecah daerah gundul, ena sangat sedikit",
            "4" => "Perkamen terbelah dalam, tak terlihat vena",
            "5" => "Seperti kulit, pecah-pecah berkeriput",
            ]
        ],
        "lanugo" => [
            "nama" => "LANUGO",
            "nilai" => [
            "_2" => null,
            "_1" => "Tidak ada",
            "0" => "Jarang",
            "1" => "Banyak",
            "2" => "Halus",
            "3" => "Daerah kebotakan",
            "4" => "Umumnya tanpa lanugo",
            "5" => null,
            ]
        ],
        "permukaan_plantar" => [
            "nama" => "PERMUKAAN PLANTAR",
            "nilai" => [
            "_2" => "Tumit-ibu jari kaki < 40mm",
            "_1" => "Tumit-ibu jari kaki 40-50mm",
            "0" => ">50mm tanpa garis kaki",
            "1" => "Faint bercak kemerahan",
            "2" => "Garis kaki hanya di anterior",
            "3" => "Garis kaki sampai 2/3 anterior",
            "4" => "Garis kaki diseluruh telapak kaki",
            "5" => null,
            ]
        ],
        "payudara" => [
            "nama" => "PAYUDARA",
            "nilai" => [
            "_2" => null,
            "_1" => "Imperceptible",
            "0" => "Sedikit perceptible",
            "1" => "Aerola rata, tanpa bantalan",
            "2" => "Aerola agak menonjol, bantalan 1-2mm",
            "3" => "Aerola menonjol, bantalan 3-4mm",
            "4" => "Aerola sangat menonjol, bantalan 5-10mm",
            "5" => null,
            ]
        ],
        "mata_telinga" => [
            "nama" => "MATA/TELINGA",
            "nilai" => [
            "_2" => "Kelopak menyatu erat",
            "_1" => "Kelopak menyatu longgar",
            "0" => "Kelopak terbuka, pina datar, tetap terlipat",
            "1" => "Pinna sedikit bergelombang, rekoil lambat",
            "2" => "Pinna bergelombang baik, lambek tapi siap rekoil",
            "3" => "Kekerasan dan berbentuk segera rekoil",
            "4" => "Kartilago tebel, daun telinga kaku",
            "5" => null,
            ]
        ],
        "genital" => [
            "nama" => "GENITAL(PRIA)",
            "nilai" => [
            "_2" => null,
            "_1" => "Skrotum datar dan halus",
            "0" => "Skrotum kosong, rugae samar",
            "1" => "Testis di kanal bagian atas, rugae jarang",
            "2" => "Testis menuju kebawah sedikit rugae",
            "3" => "Testis sudah turun, rugae jelas",
            "4" => "Testis tergantung rugae dalam",
            "5" => null,
            ]
        ],
        "genitalia" => [
            "nama" => "GENITALIA(WANITA)",
            "nilai" => [
            "_2" => null,
            "_1" => "Klitoris menonjol, labia rata",
            "0" => "Klitoris menonjol, labia minora kecil",
            "1" => "Klitoris menonjol, labia minora membesar",
            "2" => "Labia mayora dan minora menonjol",
            "3" => "Labia mayora besar, labia minora kecil",
            "4" => "Labia mayora menutupi klitoris dan labia minora",
            "5" => null,
            ]
        ],
        ]
    @endphp
    <div class="col-md-12">
        <table class="border" style="width: 100%;">
          <tr class="border">
              <td style="width: 25%" class="border bold p-1 text-center">Parameter</td>
              <td class="border bold p-1 text-center">Informasi Nilai</td>
              <td style="width: 10%;" class="border bold p-1 text-center">Nilai</td>
          </tr>
          <tr class="border">
              <td style="width: 25%" class="border bold p-1 text-center">Sikap tubuh</td>
              <td rowspan="6" style="text-align: center;">
                <img src="{{ public_path('images/ballard_score.png') }}" alt="Ballard Score" style="width: 700px; height: auto;">
              </td>
              <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$ballardScore['ballard_score']['sikap_tubuh']['nilai']}}
              </td>
          </tr>
          <tr class="border">
              <td style="width: 25%" class="border bold p-1 text-center">Persegi jendela (pergelangan tangan)</td>
              <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$ballardScore['ballard_score']['persegi_jendela']['nilai']}}
              </td>
          </tr>
          <tr class="border">
              <td style="width: 25%" class="border bold p-1 text-center">Rekoli lengan</td>
              <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$ballardScore['ballard_score']['rekoli_lengan']['nilai']}}
              </td>
          </tr>
          <tr class="border">
              <td style="width: 25%" class="border bold p-1 text-center">Sudut popliteal</td>
              <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$ballardScore['ballard_score']['sudut_popliteal']['nilai']}}
              </td>
          </tr>
          <tr class="border">
              <td style="width: 25%" class="border bold p-1 text-center">Tanda selempang</td>
              <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$ballardScore['ballard_score']['tanda_selempang']['nilai']}}
              </td>
          </tr>
          <tr class="border">
              <td style="width: 25%" class="border bold p-1 text-center">Tumit ke kuping</td>
              <td style="width: 10%;" class="border bold p-1 text-center">
                {{@$ballardScore['ballard_score']['tumit_ke_kuping']['nilai']}}
              </td>
          </tr>
        </table>

        <div style="page-break-after: always;"></div>

        <table class="border" style="width: 100%; margin-top: 50px;">
        <tr class="border">
            <td class="border bold p-1 text-center">&nbsp;</td>
            <td class="border bold p-1 text-center">-2</td>
            <td class="border bold p-1 text-center">-1</td>
            <td class="border bold p-1 text-center">0</td>
            <td class="border bold p-1 text-center">1</td>
            <td class="border bold p-1 text-center">2</td>
            <td class="border bold p-1 text-center">3</td>
            <td class="border bold p-1 text-center">4</td>
            <td class="border bold p-1 text-center">5</td>
            <td class="border bold p-1 text-center">Nilai</td>
        </tr>
        @foreach ($param as $key => $score)
            <tr class="border">
                <td class="border p-1 text-center bold" style="width: 10%;">{{$score['nama']}}</td>
                @foreach ($score['nilai'] as $nilai)
                    <td class="border p-1 text-center bold" style="width: 10%;">{{$nilai}}</td>
                @endforeach
                <td class="border bold p-1 text-center" style="width: 10%;">
                    {{@$ballardScore[$key]['nilai']}}
                </td>
            </tr>
        @endforeach
        </table>
    </div>
  </div>
  </body>
</html>