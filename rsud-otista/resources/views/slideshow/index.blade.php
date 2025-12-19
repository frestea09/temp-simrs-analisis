@extends('master')
@section('header')
  <h1>Slideshow </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Slideshow &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'slideshow.store', 'class' => 'form-horizontal', 'files'=>true]) !!}

            <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
                {!! Form::label('foto', 'Tambah Slideshow', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::file('foto[]', ['class' => 'form-control', 'multiple'=>true]) !!}
                        <p class="help-block">File Foto (bisa langsung lebih dari 1 file)</p>
                        <small class="text-danger">{{ $errors->first('foto') }}</small>
                    </div>
                    <div class="col-sm-2">
                      {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
                    </div>
                  {!! Form::close() !!}
            </div>


      <hr>

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Foto Slideshow</th>
                <th>Aktif</th>
                <th>Hapus</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($slideshow as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>
                    <img src="{{ asset('images/slideshow/'.$d->image) }}" style="height: 200px" class="img img-responsive">
                  </td>
                  <td>
                    @if ($d->publish == 'Y')
                      <a href="{{ url('slideshow/'. $d->id.'/edit') }}" class="btn btn-primary btn-flat"> <i class="fa fa-check"></i> </a>
                    @elseif ($d->publish == 'N')
                      <a href="{{ url('slideshow/'. $d->id.'/edit') }}" class="btn btn-default btn-flat"> <i class="fa fa-remove"></i> </a>
                    @endif
                  </td>
                  <td>
                    <a href="#" class="btn btn-danger btn-flat"> <i class="fa fa-trash"></i> </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="pull-right">
          {{ $slideshow->render() }}
        </div>
      </div>
    </div>
  </div>
@stop
