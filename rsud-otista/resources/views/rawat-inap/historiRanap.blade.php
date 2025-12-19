@extends('master')
@section('header')
  <h1>Histori Pasien Rawat Inap</h1>
@endsection
@section('content')
    <div class="box box-primary">
      <div class="box-body">
        <div class='table-responsive'>
          <table id='pasienData' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th class="text-center">No. RM</th>
                <th class="text-center">Nama</th>
                <th class="text-center">NIK</th>
                <th class="text-center">NRP</th>
                <th class="text-center">L/P</th>
                <th class="text-center">Umur</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Kelurahan</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($ranap as $r)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">{{ $r->no_rm }}</td>
                        <td>{{ $r->nama }}</td>
                        <td>{{ $r->nik }}</td>
                        <td>{{ $r->nrp }}</td>
                        <td>{{ $r->kelamin }}</td>
                        <td>{{ hitung_umur($r->tgllahir) }}</td>
                        <td>{{ $r->alamat }}</td>
                        <td>{{ baca_kelurahan($r->village_id) }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success">Aksi</button>
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="{{ url('pasien/'.$r->pasien_id.'/edit') }}" class="btn btn-flat btn-sm">Edit</a></li>
                                    <li><a href="{{ url('frontoffice/histori-pasien/'.$r->pasien_id) }}" class="btn btn-flat btn-sm">Histori</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="pasienModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Data Lengkap Pasien</h4>
          </div>
          <div class="modal-body">
            <div id="dataPasien"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('script')
    <script>

        $('#pasienData').DataTable();
    </script>
@endsection