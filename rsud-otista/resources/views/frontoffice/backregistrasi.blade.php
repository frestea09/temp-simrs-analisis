@extends('master')
@section('header')
  <h1>Data Restore Registrasi Pasien</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/supervisor/backregistrasibytanggal', 'class' => 'form-horizontal']) !!}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                  {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::text('tanggal', (!empty(Request::segment(4))) ? Request::segment(4) : null, ['class' => 'form-control datepicker', 'onchange'=>'this.form.submit()']) !!}
                      <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                  </div>
              </div>
            </div>
          </div>

      {!! Form::close() !!}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Cara Bayar</th>
              <th>Tanggal Registrasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($registrasi as $key => $d)
              @if (!empty($d->pasien_id))
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty(@$d->pasien_id) ? @$d->pasien->no_rm : '' }}</td>
                  <td>{{ !empty(@$d->pasien_id) ? @$d->pasien->nama : '' }}</td>
                  <td>{{ !empty(@$d->pasien_id) ? @$d->pasien->alamat : '' }}</td>
                  <td>{{ !empty(@$d->pasien_id) ? baca_carabayar(@$d->bayar) : '' }} {{ !empty(@$d->tipe_jkn) ? ' - '.@$d->tipe_jkn : '' }}</td>
                  <td>{{ @$d->created_at->format('d-m-Y H:i:s') }}</td>
                  <td>
                    @if (@$d->lunas == 'N' )
                      {{-- Hapus Versi 1 --}}
                      {{-- <a href="{{ url('frontoffice/supervisor/save-hapus-registrasi/'.@$d->id) }}" onclick="return confirm('Yakin pasien: {{ @$d->pasien->nama }} akan di hapus?')" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-trash-o"></i> </a> --}}
                      {{-- Hapus Versi 2 SoftDelete --}}
                      <a href="{{ url('frontoffice/supervisor/kembalikan-registrasi/'.@$d->id) }}" onclick="return confirm('Yakin pasien: {{ @$d->pasien->nama }} ingin dikembalikan??...')" class="btn btn-success btn-flat btn-sm"> <i class="fa fa-undo"></i> Restore </a>
                      {{-- <a href="{{ url('frontoffice/supervisor/save-hapus-registrasi/'.@$d->id) }}" onclick="return confirm('Warning!!! Yakin pasien: {{ @$d->pasien->nama }} akan di hapus permanen maka akan kehilangan data selamanya!!!!')" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-trash-o"></i> Hapus Permanen </a> --}}
                    @endif
                  </td>
                </tr>
              @endif
              
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>


@endsection
