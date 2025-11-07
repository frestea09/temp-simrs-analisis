@extends('master')

@section('header')
  <h1>One Day Care</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'operasi/odcPerTanggal', 'class' => 'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                {!! Form::label('tanggal', 'Tanggal ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::text('tanggal', (empty(Request::segment(3))) ? date('d-m-Y') : tgl_indo(Request::segment(3)), ['class' => 'form-control datepicker', 'onchange'=>'this.form.submit()']) !!}
                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama</th>
              {{-- <th>Diagnosa</th> --}}
              <th>Tindakan</th>
              <th style="text-align: center">EMR</th>
            </tr>
          </thead>
          <tbody>
            @if ($antrian->count() < 1)
              <tr>
                <td colspan="8">Tidak ada pasien operasi</td>
              </tr>

            @else
              @foreach ($antrian as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ @$d->pasien->no_rm }}</td>
                  <td>{{ @$d->pasien->nama }}</td>
                  {{-- <td>{!! $d->suspect !!}</td> --}}
                  <td>
                    @if (@$d->pasien)
                      <a href="{{ url('operasi/tindakan/odc/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-scissors"></i></a>                      
                    @endif
                  </td>
                  <td class="text-center">
                      <a href="{{url('emr-soap/operasi/main/jalan/' . $d->id)}}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-book"></i></a>
                  </td>
                </tr>
              @endforeach
            @endif


          </tbody>
        </table>
      </div>

    </div>
  </div>
@endsection
