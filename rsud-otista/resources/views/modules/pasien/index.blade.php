@extends('master')

@section('header')
  <h1>Pasien </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Pasien &nbsp;
        </h3>
      </div>
      <div class="box-header with-border">
        {!! Form::open(['method' => 'POST', 'route' => 'pasien.search', 'class' => 'form-search']) !!}
        <label for="keyword" class="text text-primary">Cari Pasien: </label>
        <div class="input-group input-group-md {{ $errors->has('keyword') ? ' has-error' : '' }}">
              <input type="text" name="keyword" id="keyword" class="typeahead form-control" placeholder="Ketik nama, alamat, atau Nomor RM">
                <small class="text-danger">{{ $errors->first('keyword') }}</small>
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> CARI</button>
                </span>
            </div>
        {!! Form::close() !!}
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>No. Kartu</th>
                <th>Nama</th>
                <th>Kelamin</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Edit / View</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pasien as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ @$d->no_jkn }}</td>
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
        <div class="pull-right">
          {{ $pasien->render() }}
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
