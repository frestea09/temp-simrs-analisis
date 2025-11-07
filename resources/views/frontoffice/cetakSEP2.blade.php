<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak </title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
      body{
        margin-top: 50px;
        margin-left: 15%;
        margin-right: 15%;
        font-size: 10pt;
      }

      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
          padding: 0;
          margin: 0;
      }

    </style>
  </head>
  <body onload="print()">
    <table style="width: 100%;">
      <tr>
        <td style="width:60%;">
          <img src="{{ asset('images/logo_bpjs.png') }}" style="width: 170px;">
        </td>
        <td class="text-center" style="width:50%;">
          SURAT ELIGIBILITAS PESERTA <br>
          {{ config('app.name') }}
        </td>
      </tr>
      {{-- <tr>
        <td colspan="2">&nbsp;</td>
      </tr> --}}
      <tr>
        <td>
          <table>
            <tr>
              <td>No. SEP</td><td>: {{ $reg->no_sep }}</td>
            </tr>
            <tr>
              <td>Tgl. SEP</td><td>: {{ tgl_indo($reg->tgl_sep) }}</td>
            </tr>
            <tr>
              <td>No. Kartu</td><td>: {{ $reg->no_jkn }}</td>
            </tr>
            <tr>
              <td>Nama Peserta</td><td>: {{ $reg->pasien->nama }}</td>
            </tr>
            <tr>
              <td>Tgl Lahir</td><td>: {{ tgl_indo($reg->pasien->tgllahir) }}</td>
            </tr>
            <tr>
              <td>Jenis Kelamin</td><td>: {{ $reg->pasien->kelamin }}</td>
            </tr>
            <tr>
              <td>Poli Tujuan</td><td>: {{ baca_poli($reg->poli_id) }}</td>
            </tr>
            <tr>
              <td>Asal Faskes Tk. 1</td><td>: {{ $reg->ppk_rujukan }}</td>
            </tr>
            <tr>
              <td>Diagnosa Awal</td><td>: {{ !empty($reg->diagnosa_awal) ? Modules\Icd10\Entities\Icd10::where('nomor', $reg->diagnosa_awal)->first()->nama : '' }}</td>
            </tr>
            <tr>
              <td>Catatan</td><td>:  &nbsp; </td>
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
            <tr>
              <td>No. RM</td> <td>: <b>{{ $reg->pasien->no_rm }}</b></td>
            </tr>
            <tr>
              <td>Peserta</td> <td>: </td>
            </tr>
            <tr>
              <td>COB</td> <td>: </td>
            </tr>
            <tr>
              <td>Jenis Rawat</td> <td>: Rawat Jalan</td>
            </tr>
            <tr>
              <td>Kelas Rawat</td> <td>: {{ $reg->hakkelas }}</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
              <td class="text-center">
                Pasien/Keluarga Pasien <br><br><br><br>_____________________
              </td>
              <td class="text-center">
                Petugas BPJS Kesehatan <br><br><br><br>_______________________
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    @php
      DB::table('registrasis')->where('id', $reg->id)->update(['cetak_sep'=>'1']);
    @endphp
    <META HTTP-EQUIV="REFRESH" CONTENT="15; URL={{ url('/frontoffice/data-sep2') }}">
  </body>
</html>
