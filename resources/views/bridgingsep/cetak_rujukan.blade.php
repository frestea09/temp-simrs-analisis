<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak </title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style>
      body{
        font-family: sans-serif;
        font-size: 11pt;
      }
    </style>
  </head>
  <body>
    <table style="width: 100%; margin-left: 30px;">
      <tr>
        <td style="width:60%;">
          <img src="{{ public_path('images/logo_bpjs.png') }}"style="width: 200px; float: left; margin-right: 20px;">
          <div>
            SURAT RUJUKAN <br>
            {{ configrs()->nama }}
          </div>
        </td>
        <td class="text-center" style="width:40%; ">
          No. {{ $data->noRujukan }}<br>
          <small>Tgl. {{ tanggalkuitansi($data->tglRujukan) }}</small>
        </td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td>Kepada Yth</td><td>: {{ $data->poliTujuan_nama }}</td>
            </tr>
            <tr>
              <td></td><td> &nbsp; {{ $data->tujuanRujukan_nama }} </td>
            </tr>
            <tr>
              <td colspan="2">
                Mohon Pemeriksaan dan Penanganan Lebih Lanjut :
              </td>
            </tr>
            <tr>
              <td>No. Kartu</td><td>: {{ $data->noKartu }}</td>
            </tr>
            <tr>
              <td>Nama Peserta</td><td>: {{ $data->nama }}</td>
            </tr>
            <tr>
              <td>Tgl Lahir</td><td>: {{ $data->tglLahir }}</td>
            </tr>
            <tr>
              <td>Diagnosa Awal</td><td>:
                {{ \Modules\Icd10\Entities\Icd10::where('nomor', $data->diagnosa)->first()->nama }}
              </td>
            </tr>
            <tr>
              <td>Keterangan</td><td>:  {{ $data->catatan }}</td>
            </tr>
            <tr>
              <td colspan="2">
                Demikian atas bantuannya diucapkan banyak terima kasih.
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p class="text-left small" style="font-size: 60%;">
                  <i>
                  * Rujukan Berlaku Sampai Dengan {{ \Carbon\Carbon::parse(date($data->tglRujukan))->addDays(90)->format('d-m-Y') }}<br>
                  * Tgl Rencana Berkunjung {{ tanggalkuitansi($data->tglRujukan) }}
                </i>
              </p>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table>

            <tr>
              <td colspan="2">== Rujukan Penuh ==</td>
            </tr>
            <tr>
              <td colspan="2">Rawat Jalan</td>
            </tr>
            <tr>
              <td colspan="2"> </td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
              <td colspan="2" class="text-center">
                Mengetahui, <br><br><br><br>_____________________
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
