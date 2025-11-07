<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Barcode</title>
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

    <div class="row">
      <div class="col-sm-12 text-center">
        <h4><b>{{ strtoupper( config('app.nama') ) }} </b></h4>
        <h5>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h5>
        <hr>
          <h5><b>IDENTITAS PASIEN</b></h5>
        <hr> <br>
        <b>NO. REKAM MEDIK <br> {{ no_rm($pasien->no_rm) }} </b><br> <br> <br>

        <table class="table table-borderless">
          <tr>
            <td>Nama</td> <td>: {{ $pasien->nama }}</td>
          </tr>
          
          <tr>
            <td>No. NIK</td> <td>: {{ $pasien->nik }}</td>
          </tr>
          <tr>
            <td>Jenis Kelamin</td> 
            <td>: 
              @if ($pasien->kelamin == 'L')
                Laki - Laki
              @elseif ($pasien->kelamin == 'P')
                Perempuan
              @endif
            </td>
          </tr>
          <tr>
            <td>Tempat Lahir</td> <td>: {{ $pasien->tmplahir }}</td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td> <td>: {{ tgl_indo($pasien->tgllahir) }}</td>
          </tr>
          
          <tr>
            <td>Alamat</td> <td colspan="3">: {{ $pasien->alamat }} RT {{ $pasien->rt }} RW {{ $pasien->rw }}</td>
          </tr>
          <tr>
            <td>Propinsi</td> <td>: {{ baca_propinsi($pasien->province_id) }}</td>
            <td>Kodya/Kabupaten</td> <td>: {{ baca_kabupaten($pasien->regency_id) }}</td>
          </tr>
          <tr>
            <td>Kecamatan</td> <td>: {{ baca_kecamatan($pasien->district_id) }}</td>
            <td>Kelurahan</td> <td>: {{ baca_kelurahan($pasien->village_id) }}</td>
          </tr>
          <tr>
            <td>No. HP/Telp.</td> <td>: {{ $pasien->nohp }}</td>
          </tr>
          <tr>
            <td>Status</td> <td>: {{ $pasien->status_marital }}</td>
            <td>Agama</td> <td>: {{ Modules\Pasien\Entities\Agama::find($pasien->agama_id)->agama }}</td>
          </tr>
          <tr>
            <td>Pendidikan</td> <td>: {{ Modules\Pendidikan\Entities\Pendidikan::find($pasien->pendidikan_id)->pendidikan }}</td>
            <td>Pekerjaan</td> <td>: {{ Modules\Pekerjaan\Entities\Pekerjaan::find($pasien->pekerjaan_id)->pekerjaan }}</td>
          </tr>
          <tr>
            <td>Nama Ibu Kandung </td> <td>: {{ $pasien->ibu_kandung }}</td>
          </tr>
          
        </table>
        <hr>
      </div>
    </div>
    <p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>
    
  </body>
</html>
