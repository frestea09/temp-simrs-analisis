<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SURAT RUJUKAN</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        font-size: 12pt;
        line-height: 1.5;
        /* margin: 30px; */
      }
      .header {
        text-align: center;
      }
      .header img {
        position: absolute;
        left: 40px;
        top: 30px;
        width: 70px;
      }
      .double-line {
        border-top: 2px solid black;
        border-bottom: 4px double black;
        margin-top: 5px;
        margin-bottom: 10px;
      }
      .content {
        margin-top: 20px;
      }
      .label {
        /* display: inline-block; */
        width: 180px;
      }
      .dotted {
        border-bottom: 1px dotted #000;
        display: inline-block;
        width: 400px;
      }
      .footer {
        margin-top: 50px;
        text-align: right;
        margin-right: 40px;
      }
    </style>
  </head>
  <body>
    @php
      $content = json_decode($cetak->rujukan_rs);
    @endphp

    <!-- Header -->
    <div class="header">
      <img src="{{ public_path('images/'.configrs()->logo) }}">
      <b style="font-size:14pt;">PEMERINTAH KABUPATEN BANDUNG</b><br>
      <b style="font-size:14pt;">{{ strtoupper(configrs()->nama) }}</b><br>
      <span style="font-size:10pt;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</span><br>
      <span style="font-size:10pt;">Email : {{ configrs()->email }}</span>
    </div>
    <div class="double-line"></div>

    <!-- Judul --> 
    <br/>
    <h3 style="text-align:center; text-decoration: underline;">SURAT RUJUKAN</h3>
    <p style="text-align:center;">Nomor : {{ @$cetak->nomor }}</p>

    <!-- Isi -->
    <div class="content">
      <p>Kepada Yth.<br>
      Ts / Dokter Poli {{ @$content->dokter_penerima }}<br>
      Di RS {{ @$content->rumah_sakit_tujuan }}</p>

      <p>Dengan Hormat,</p>
      <p>Mohon pemeriksaan pengobatan lebih lanjut / pemeriksaan penunjang diagnostik</p>

      <table style="width:100%;">
        <tr><td class="label">Nama</td><td>: {{ @$pasien->nama }}</td></tr>
        <tr><td class="label">Tempat &amp; Tgl lahir (Umur)</td><td>: {{ $pasien->tmplahir.', '.date('d-m-Y', strtotime($pasien->tgllahir)) }} ({{ hitung_umur($pasien->tgllahir,'Y') }} Th)</td></tr>
        <tr><td class="label">Pekerjaan</td><td>: {{ @baca_pekerjaan($pasien->pekerjaan) }}</td></tr>
        <tr><td class="label">Alamat</td><td>: {{ $pasien->alamat }}</td></tr>
        <tr><td class="label">No Jaminan</td><td>: {{ @$pasien->no_jkn }}</td></tr>
        <tr><td class="label">Dengan Diagnosa</td><td>: {{ @$content->diagnosa }}</td></tr>
        <tr><td class="label">Telah diberikan</td><td>: {{ @$content->pengobatan }}</td></tr>
      </table>

      <p>Demikian atas bantuannya, kami ucapkan terima kasih.</p>
    </div>

    <!-- Footer -->
    <div class="footer">
      Soreang, {{ date('d-m-Y', strtotime(@$cetak->created_at)) }}<br>
      Salam sejawat
      @php
        @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(baca_dokter($registrasi->dokter_id) . ' | ' . @$registrasi->created_at));
        @$dokter = Modules\Pegawai\Entities\Pegawai::find($registrasi->dokter_id);
      @endphp
      <img src="data:image/png;base64, {!! @$base64 !!} ">
      {{@baca_dokter($registrasi->dokter_id)}} <br>
      {{-- NIP. {{$registrasi->dokter->sip}} --}}
    </div>

  </body>
</html>
