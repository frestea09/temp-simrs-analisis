@php
// header('Content-Type: application/json');
  $ID = config('app.sep_id');
    $t = time();
    $data = "$ID&$t";
    $secretKey = config('app.sep_key');
    date_default_timezone_set('UTC');
    $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

    $completeurl = config('app.sep_url_web_service')."/SEP/" . $reg->no_sep;

    $session = curl_init($completeurl);
    $arrheader = array(
      'X-cons-id: ' . $ID,
      'X-timestamp: ' . $t,
      'X-signature: ' . $signature,
      'Content-Type: application/x-www-form-urlencoded',
    );
    curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
    curl_setopt($session, CURLOPT_HTTPGET, 1);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($session);
    $sml = json_decode($response, true);
    $json = json_encode($sml);

    //echo $json; die;

    //echo $sml['response']['peserta']['noKartu']; die;

@endphp
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak </title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style>
      body{
        font-family: sans-serif;
        font-size: 10pt;
      }
    </style>
  </head>
  <body>
    <table style="width: 100%; margin-left: 20px;">
      <tr>
        <td style="width:30%;">
          <img src="{{ public_path('images/logo_bpjs.png') }}"style="height: 20px;">
        </td>
        <td class="text-center" style="width:16%; font-weight: bold; padding-left:30px">
          SURAT ELIGIBILITAS PESERTA<br> {{ config('app.nama') }}
        </td>
        <td class="text-center" style="width:15%; font-weight: bold;">
        </td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td>No. SEP</td><td>: {{ $reg->no_sep }}</td>
            </tr>
            <tr>
              <td>Tgl. SEP</td><td>: {{ $sml['response']['tglSep'] }}</td>
            </tr>
            <tr>
              <td>No. Kartu</td><td>: {{ $sml['response']['peserta']['noKartu']  }} (MR. {{ $reg->pasien->no_rm }})</td>
            </tr>
            <tr>
              <td>Nama Peserta</td><td>: {{ $sml['response']['peserta']['nama']  }} </td>
            </tr>
            <tr>
              <td>Tgl Lahir</td><td>: {{ $sml['response']['peserta']['tglLahir']  }}, Kelamin : {{ $sml['response']['peserta']['kelamin']  }} </td>
            </tr>
            <tr>
              <td>No. Telepon</td><td>: {{ $reg->pasien->nohp }}</td>
            </tr>
            <tr>
              <td>Sub / Spesialis</td><td>: {{ baca_poli($reg->poli_id) }}</td>
            </tr>
            <tr>
              <td>Faskes Perujuk</td><td>: {{ (substr($reg->status_reg, 0,1) == 'G') ? NULL : $perujuk }}</td>
            </tr>
            <tr>
              <td>Diagnosa Awal</td>
              <td style="font-size:8.5pt">:
                @php
                  $diagnosa = Modules\Icd10\Entities\Icd10::where('nomor', $reg->diagnosa_awal)->first();
                @endphp
                {{ $diagnosa ? $diagnosa->nama : $sml['response']['diagnosa'] }}
              </td>
            </tr>
            <tr>
              <td>Catatan</td><td>:  {{ $sml['response']['catatan'] }} </td>
            </tr>
            <tr>
              <td colspan="2">
                <p class="text-left small" style="font-size: 60%;">
                  <i>
                  * Saya Menyetujui BPJS Kesehatan menggunakan informasi medis Pasien jika diperlukan. <br>
                  * SEP bukan sebagai bukti penjaminan peserta.
                Cetakan Ke 1
                </i>
              </p>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table>
            @if(strpos($sml['response']['diagnosa'], 'cataract') == true && strpos(baca_poli($reg->poli_id), 'Mata') == true)
            @endif
            <tr>
              <td style="padding-left:30px">Peserta</td> <td style="">: {{ $sml['response']['peserta']['jnsPeserta'] }}</td>
            </tr>
            <tr>
              <td style="padding-left:30px">COB</td> <td>: {{ ($sml['response']['penjamin'] != '') ? 'Ya' : '' }}</td>
            </tr>
            <tr>
              <td style="padding-left:30px">Jenis Rawat</td>
              <td>:
                {{ $sml['response']['jnsPelayanan'] }}
                {{-- @if (substr($reg->status_reg, 0,1) == 'I')
                  Rawat Inap
                @else
                  Rawat Jalan
                @endif --}}
              </td>
            </tr>
            <tr>
              <td style="padding-left:30px">Kelas Rawat</td>
              <td>:
                @if (substr($reg->status_reg, 0,1) == 'I')
                  {{--  {{ $reg->hakkelas }}  --}}
                  {{ $sml['response']['kelasRawat'] }}
                @else
                  -
                @endif
                </td>
            </tr>
            <tr>
              <td style="padding-left:30px">Penjamin</td> <td>: {{ $sml['response']['penjamin'] }}</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
              <td style="padding-left:30px" colspan="2" class="text-center">
                Pasien/Keluarga Pasien <br><br><br><br>_____________________
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

  </body>
</html>

