@extends('master')
@section('header')
  <h1>Registrasi Perjanjian</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Antrian Perjanjian
      </h3>
    </div>
    <div class="box-body">
      <div class="row">
        {!! Form::open(['method' => 'POST', 'url' => 'view-perjanjian', 'class' => 'form-horizontal']) !!}
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('tgl') ? ' has-error' : '' }}">
                {!! Form::label('tgl', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::text('tgl', (!empty(request()->segment(2))) ? tgl_indo(request()->segment(2)) : null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('tgl') }}</small>
                </div>
            </div>
          </div>
          <div class="col-md-6">
             <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
                 {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
                 <div class="col-sm-9">
                     <select class="form-control" name="poli_id">
                       <option value=""></option>
                       @foreach ($poli as $key => $d)
                         @if ($d->id == request()->segment(3))
                           <option value="{{ @$d->id }}" selected>{{ @$d->nama }}</option>
                         @else
                           <option value="{{ @$d->id }}">{{ @$d->nama }}</option>
                         @endif
                       @endforeach
                     </select>
                     <small class="text-danger">{{ $errors->first('poli_id') }}</small>
                 </div>
             </div>
          </div>

          <div class="col-md-6">
             <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                 {!! Form::label('no_rm', 'No RM', ['class' => 'col-sm-3 control-label']) !!}
                 <div class="col-sm-9">
                    {!! Form::text('no_rm', @$no_rm ?? null, ['class' => 'form-control']) !!}
                     <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                 </div>
             </div>
          </div>

          <div class="col-md-1 col-md-offset-1">
            <div class="form-group">
                <input type="submit" name="tampil" class="btn btn-primary btn-flat" value="TAMPILKAN">
            </div>
          </div>

        {!! Form::close() !!}
      </div>

      <div class="row">
        <div class="col-md-12">
          @if ($pasien)
            <hr>
            <div class='table-responsive'>
              <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No. RM</th>
                    <th>Poli Tujuan</th>
                    <th>Dokter</th>
                    {{-- <th>Hapus</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pasien as $key => $d)
                    @php
                        $ranap = \App\Rawatinap::where('registrasi_id',$d->id)
                    @endphp
                    <tr>
                      <td>{{ @$no++ }}</td>
                      <td>{{ @$d->pasien->nama }}</td>
                      <td>{{ @$d->pasien->no_rm }}</td>
                      <td>{{ baca_poli(@$d->poli_id)}}</td>
                      <td>{{ baca_dokter(@$d->dokter_id) }}</td>
                      {{-- <td>
                        <a href="{{ url('hapus-regperjanjian/'.$d->id).'/'.Request::segment(2).'/'.Request::segment(3) }}" class="btn btn-sm btn-danger btn-flat" onclick="return confirm('Yakin akan di hapus?')"><i class="fa fa-trash-o"></i></a>
                      </td> --}}
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>


    </div>
  </div>
@endsection
