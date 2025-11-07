@extends('master')

@section('header')
  <h1>Hasil Laboratorium</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">

      </h3>
    </div>
    <div class="box-body">
    <br>
    <div class="table-responsive">

      <table class="table  table-striped table-bordered table-hover table-condensed">
        <tbody>
          <tr>
            <th >No. RM</th> <td>: {{ $registrasi->pasien->no_rm }}</td>
            <th>Tgl Lahir / Kelamin</th> <td>: {{ tgl_indo($registrasi->pasien->tgllahir) }} / {{ $registrasi->pasien->kelamin }}</td>
          </tr>
          <tr>
            <th>Nama Pasien</th> <td>: {{ $registrasi->pasien->nama }}</td>
            <th>Dokter Pengirim</th> <td>: {{ baca_dokter($hasillab->dokter_id) }} </td>
          </tr>
          <tr>
            <th>Alamat</th> <td>: {{ $registrasi->pasien->alamat }}</td>
            <th>Dokter Pemeriksa</th> <td>: {{ baca_dokter($hasillab->penanggungjawab) }}</td>
          </tr>

        </tbody>
      </table>
    </div>
    <div class="table-responsive">

      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
              <th>No.Lab</th>
              <th>Daftar Pemeriksaan</th>
              <th>Waktu Pemeriksaan</th>
              <th>Hasil</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($hasillabs as $p)
              <tr>
                  <td>{{ $p->no_lab }}</td>
                  <td>
                      <ul style="padding: 15px;">
                          @foreach ($p->orderLab->folios as $folio)
                              <li>{{$folio->namatarif}}</li>
                          @endforeach
                      </ul>
                  </td>
                  <td>{{ date('Y-m-d', strtotime($p->tgl_pemeriksaan)) }} {{ $p->jam }}</td>
                  <td>
                      <a href="{{ url('cetak-lis-pdf/' . @$p->no_lab . '/' . @$registrasi_id) }}"
                          target="_blank" class="btn btn-sm btn-danger btn-flat"> <i class="fa fa-print"></i>
                          Lihat </a>
                      {{-- <a href="{{ url('pemeriksaanlab/cetakAll/'.$p->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-print"></i> Lihat </a> --}}
                      {{-- <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$registrasi_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Lihat </a> --}}
                  </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">


</script>
@endsection
