@extends('master')
@section('header')
  <h1>Import File IGD <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <br>
        <div class="row">
          <div class="col-md-8">
            @php
              $kategori_header = 2;
            @endphp
            {!! Form::open(['method' => 'POST', 'route' => 'import-igd', 'class' => 'form-horizontal','files'=>true]) !!}
              <div class="form-group">
                  {!! Form::label('inputname', 'Download Template', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                    <a href="{{ route('template-igd') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cloud-download"></i> DOWNLOAD </a>
                  </div>
              </div>
          <div class="form-group{{ $errors->has('carabayar') ? ' has-error' : '' }}">
                {!! Form::label('carabayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label','style'=>'color:green;']) !!}
                <div class="col-sm-9">
                    {{-- {!! Form::select('carabayar', Modules\Registrasi\Entities\Carabayar::pluck('carabayar', 'id'), null, ['class' => 'chosen-select']) !!} --}}
                    <select name="carabayar" class="form-control chosen-select">
                        <option value=""></option>
                        @foreach (Modules\Registrasi\Entities\Carabayar::whereIn('carabayar',['JKN','umum'])->get() as $d)
                            <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('carabayar') }}</small>
                </div>
            </div>

               <div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }}">
                  {!! Form::label('jenis', 'Jenis ', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {{-- @php
                        $def = ($kategori_header == 1) ? 'TA' : 'TG';
                      @endphp --}}
                      {!! Form::select('jenis', ['TG'=>'TG'], null, ['class' => 'chosen-select']) !!}
                      <small class="text-danger">{{ $errors->first('jenis') }}</small>
                  </div>
              </div>
              
              <div class="form-group{{ $errors->has('kategoriheader') ? ' has-error' : '' }}">
                  {!! Form::label('kategoriheader', 'Kategori Header', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {{-- {!! Form::select('kategoriheader', Modules\Kategoriheader\Entities\Kategoriheader::pluck('nama', 'id'), null, ['class' => 'chosen-select']) !!} --}}
                      <select name="kategoriheader" class="form-control chosen-select">
                        <option value=""></option>
                        @foreach (Modules\Kategoriheader\Entities\Kategoriheader::all() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                      </select>
                      <small class="text-danger">{{ $errors->first('kategoriheader') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('kategoritarif_id') ? ' has-error' : '' }}">
                  {!! Form::label('kategoritarif_id', 'Kategori Tarif', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {{-- {!! Form::select('kategoritarif_id', Modules\Kategoritarif\Entities\Kategoritarif::pluck('namatarif', 'id'), null, ['class' => 'chosen-select']) !!} --}}
                      <select name="kategoritarif_id" class="form-control chosen-select">
                        <option value=""></option>
                        @foreach (Modules\Kategoritarif\Entities\Kategoritarif::all() as $d)
                            <option value="{{ $d->id }}">{{ $d->namatarif }}</option>
                        @endforeach
                      </select>
                      <small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
                  </div>
              </div>
              {{-- @include('import.form') --}}
              {{--<div class="form-group{{ $errors->has('kelompok') ? ' has-error' : '' }}">
                {!! Form::label('kelompok', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                   
                    <select name="kelompok" class="form-control chosen-select">
                      <option value="KL1">Kelompok 1</option>
                      <option value="KL2">Kelompok 2</option>
                      <option value="KL3">Kelompok 3</option>
                      <option value="KLK">Kelompok Khusus</option>
                      <option value="TM1">Tindakan Medis 1</option>
                      <option value="TM2">Tindakan Medis 2</option>
                      <option value="TM3">Tindakan Medis 3</option>
                      <option value="TMK">Tindakan Medis Khusus</option>
                      <option value="AMB">Ambulance</option>
                      <option value="MCU">MCU</option>
                      <option value="RM">Rehab Medik</option>
                      <option value="LL">Lain-Lain</option>
                      <option value="LB">Lab+Radiologi</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('kelompok') }}</small>
                </div>
              </div>--}}
              @for ($i=1; $i <= 2; $i++)
                <div class="form-group{{ $errors->has('nama'.$i) ? ' has-error' : '' }}">
                    {!! Form::label('nama'.$i, 'Split-'.$i, ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                      @php
                        $data = App\Mastersplit::where('kategoriheader_id',4)->where('tahuntarif_id', configrs()->tahuntarif)->get();
                      @endphp
                        <select class="chosen-select" name="nama{{ $i }}">
                          <option value=""></option>
                          @foreach ($data as $key => $d)
                            <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                        {{-- {!! Form::select('nama'.$i, App\Mastersplit::pluck('nama', 'nama'), null, ['class' => 'chosen-select']) !!} --}}
                        <small class="text-danger">{{ $errors->first('nama'.$i) }}</small>
                    </div>
                </div>
              @endfor

              <div class="form-group{{ $errors->has('excel') ? ' has-error' : '' }}">
                  {!! Form::label('excel', 'File Excel', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          {!! Form::file('excel', ['class' => 'form-control']) !!}
                          <p class="help-block">File Excel: xls, xlsx</p>
                          <small class="text-danger">{{ $errors->first('excel') }}</small>
                      </div>
              </div>

              <div class="btn-group pull-right">
                  <a href="{{ URL::previous() }}" class="btn btn-warning btn-flat">Batal</a>
                  {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
              </div>


            {!! Form::close() !!}
          </div>
        </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
