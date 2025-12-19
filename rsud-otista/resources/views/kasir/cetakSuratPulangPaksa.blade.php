<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pulang Paksa</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
      *{
        font-family: 'Times New Roman';
      }
      h2{
        font-weight: bold;
        text-align: center;
        margin-bottom: -10px;
      }
      body{
        font-size: 10pt;
        margin-left: 0.1cm;
        margin-right: 0.1cm;
      }
      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black
      }
    </style>
  </head>
  <body>
    <table border=0 style="width:95%;font-size:12px;"> 
      <tr>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
        </td>
        <td style="text-align: center">
          <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
          {{--<b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>--}}
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
        </td>
      </tr>
    </table>
    <hr>
    <table style="width: 95%;">
      <tr>
        <td class="text-center">
          <b>
            SURAT PERNYATAAN PERSETUJUAN ADMINISTRASI PASIEN PULANG PAKSA
          </b>
        </td>
      </tr>
    </table>
    <table style="width: 95%;">
      <tr >
        <td colspan="3">
          <b>
            Yang bertanda tangan dibawah ini
          </b>
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">Nama</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ @$registrasi->pasien->nama_keluarga != null ? @$registrasi->pasien->nama_keluarga : '' }}</td>
      </tr>
      <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ @$registrasi->pasien->nik_penanggung_jawab }}</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ @$registrasi->pasien->alamat_penanggung_jawab }}</td>
      </tr>
      <tr>
        <td>No Tlp</td>
        <td>:</td>
        <td>{{ @$registrasi->pasien->nodarurat != null ? $registrasi->pasien->nodarurat : $registrasi->pasien->nohp }}</td>
      </tr>
      <tr>
        <td>Hubungan dengan pasien</td>
        <td>:</td>
        <td>{{ @$registrasi->pasien->hub_keluarga }}</td>
      </tr>
    </table>
    <table style="width: 95%;">
      <tr >
        <td colspan="3">
          <b>
            Bahwa pasien sebagai berikut :
          </b>
        </td>
      </tr>
      <tr>
        <td style="width: 30%;">No RM</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ @$registrasi->pasien->no_rm }}</td>
      </tr>
      <tr>
        <td style="width: 30%;">Nama</td>
        <td style="width: 2%;">:</td>
        <td style="width: 68%;">{{ @$registrasi->pasien->nama }}</td>
      </tr>
      <tr>
        <td>Umur</td>
        <td>:</td>
        <td>{{ hitung_umur($registrasi->pasien->tgllahir) }}</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $registrasi->pasien->alamat }}</td>
      </tr>
      <tr>
        <td>Ruang Rawat Inap</td>
        <td>:</td>
        <td>{{ @$registrasi->rawat_inap ? @$registrasi->rawat_inap->kamar->nama : '' }}</td>
      </tr>
      <tr>
        @if (@$registrasi->bayar == 1)
        <td>Peserta BPJS Kesehatan</td>
        <td>:</td>
        <td>{{ @$registrasi->cara_bayar->carabayar }} {{ @$registrasi->tipe_jkn }}</td>
        @else
        <td>Cara Bayar</td>
        <td>:</td>
        <td>{{ @$registrasi->cara_bayar->carabayar }}</td>
        @endif
      </tr>
    </table>
    <table style="width: 85%;">
      <tr>
        <td class="text-justify">
          Menyatakan dengan sungguh bahwa saya selaku pasien BPJS Kesehatan, 
          telah mendapatkan penjelasan dari pihak RSUD Soreang terkait aturan / kertentuan dari BPJS Kesehatan, 
          mengenai pasien Pulang Rawat atas permintaan sendiri, Bahwa jika:
        </td>
      </tr>
    </table>
    <div class="text-justify" style="width: 85%;">
      <ol>
        <li>
          Pasien pulang paksa / pulang di rawat atas permintaan sendiri, 
          jika datang dirawat kembali  dalam tempo waktu kurang dari 2 minggu, 
          dengan Diagnosa yang sama bukan Jaminan BPJS Kesehatan (JKN)
        </li>
        <li>
          Jika datang dirawat kembali sebelum tempo 2 minggu 
          maka diberlakukan menjadi pasien umum / bayar sendiri.
        </li>
      </ol>
    </div>
    <table style="width: 95%;">
      <tr>
        <td colspan="3">Demikian pernyataan ini saya buat</td>
      </tr>
      <tr>
        <td colspan="3">Soreang, {{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="text-center">
        <td style="width: 40%;">Petugas Kasir Rawat Inap</td>
        <td style="width: 20%;">&nbsp;</td>
        <td style="width: 40%;">Yang Membuat Pernyataan</td>
      </tr>
      <tr>
        <td style="width: 40%;">&nbsp;</td>
        <td style="width: 20%;">&nbsp;</td>
        <td style="width: 40%;">&nbsp;</td>
      </tr>
      <tr class="text-center">
        <td style="width: 40%;">
          @if (@Auth::user()->pegawai->tanda_tangan)
          <img src="{{ public_path('/images/'. @Auth::user()->pegawai->tanda_tangan) }}" style="width: 80px;" alt="">
          @endif
        </td>
        <td style="width: 20%;">&nbsp;</td>
        <td style="width: 40%;">
          @php
            $ttd = \App\TandaTangan::where('registrasi_id', $registrasi->id)->where('jenis_dokumen', 'surat-pulang-paksa')->first();
          @endphp
          @if ($ttd)
            <img src="{{ public_path('/images/upload/ttd/'. $ttd->tanda_tangan) }}" style="width: 80px;" alt="">
          @else
            &nbsp;
          @endif
        </td>
      </tr>
      
      <tr class="text-center">
        <td style="width: 40%;">{{ @Auth::user()->name }}</td>
        <td style="width: 20%;">&nbsp;</td>
        <td style="width: 40%;">{{ @$registrasi->pasien->nama_keluarga }}</td>
      </tr>
    </table>
  </body>
</html>