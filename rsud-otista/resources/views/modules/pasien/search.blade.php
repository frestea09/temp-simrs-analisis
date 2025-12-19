@extends('master')

@section('header')
  <h1>Pasien </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Hasil Pencarian Pasien &nbsp;
          <div class="pull-right">
            <a href="{{ url('pasien') }}" class="btn btn-primary"><i class="fa fa-step-backward"></i></a>
          </div>
        </h3>
      </div>

      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Kelamin</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pasien as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->kelamin }}</td>
                  <td>{{ hitung_umur($d->tgllahir) }}</td>
                  <td>{{ $d->alamat }}</td>
                  <td>
                    <a href="{{ route('pasien.edit', $d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i></a>
                    <button type="button" class="btn btn-primary btn-sm btn-flat" data-idpasien="{{ $d->id }}" id=pasienshow><i class="fa fa-search"></i></button>
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
@stop
