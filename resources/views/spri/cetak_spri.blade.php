<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Perintah Rawat Inap</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ public_path('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 1cm;
          margin-left: 2cm;
          margin-right: 2cm;
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
  @foreach ($spri as $d)
    <body>
      @php
          $cppt = App\Emr::where('registrasi_id', $d->registrasi_id)->whereIn('unit', ['igd', 'jalan'])->orderBy('id','DESC')->first();
      @endphp
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
                  <h3 style="font-size:17px;"><u><b>SURAT PENGANTAR RAWAT INAP</b></u></h3>
                </td>
              </tr>
             
            </table>
            <br/>

            <table border=0 style="width: 100%;">
              <tr>
                <td style="width:200px !important;"><span>No.SPRI</span></td>
                <td>: {{ @$d->no_spri ?? '-' }}</td>
              </tr>
              <tr>
                <td style="width:200px !important;"><span>No. CM</span></td>
                <td>: {{@$d->no_rm}}</td>
              </tr>
              <tr>
                <td><span>Nama Pasien</span></td>
                <td>: {{@$d->nama}}</td>
              </tr>
              <tr>
                <td style=""><span>Alamat</span></td>
                <td>: {{@$d->alamat}}</td>
              </tr>
              <tr>
                <td ><span> Tgl. Lahir</span></td>
                <td>: {{ date("d-m-Y", strtotime(@$d->tgllahir)) }}</td>
              </tr>
              <tr>
                <td ><span> Usia</span></td>
                <td>: {{@hitung_umur(@$d->tgllahir, 'Y')}}</td>
              </tr>
              
              <tr>
                <td ><span> Cara Bayar</span></td>
                <td>: {{ baca_carabayar(@$d->carabayar) }}</td>
              </tr>
              <tr>
                <td style=""><span>Mulai tanggal rawat</span></td>
                <td>: {{ date("d-m-Y", strtotime(@$d->tgl_rencana_kontrol)) }}</td>
              </tr>
              <tr>
                <td style=""><span>Kebutuhan ruangan</span></td>
                <td>:  {{baca_kamar(@$d->jenis_kamar)}}</td>
              </tr>
              <tr>
                <td style=""><span>Dokter Pengirim</span></td>
                <td>:  {{baca_dokter(@$d->dokter_pengirim)}}</td>
              </tr>
              <tr>
                <td style=""><span>Dokter DPJP</span></td>
                <td>:  {{baca_dokter(@$d->dokter_rawat)}}</td>
              </tr>
              <tr>
                <td style=""><span>Diagnosa dan keterangan detail </span></td>
                <td>:  
                  {{ strip_tags(@$d->diagnosa) }}
                </td>
              </tr>
              <tr>
                <td style="vertical-align: top;"><span>Rencana Terapi</span></td>
                <td style="">:  {{(@$cppt->planning)}}</td>
              </tr>
          </table>
          <br>
          <br>
        <div class="text-center" style="padding: 5px; float:right;">
          {{configrs()->kota}}, {{ date("d-m-Y", strtotime(@$d->created_at)) }}
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <u>({{baca_dokter($d->dokter_pengirim)}})</u><br>
          <hr>
        </div>
      </div>
    </body>
  @endforeach
</html>
