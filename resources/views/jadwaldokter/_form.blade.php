<div class="row">
  <div class="col-md-5">
    <div class="form-group{{ $errors->has('poli') ? ' has-error' : '' }}">
        {!! Form::label('poli', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('poli', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('poli') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('dokter') ? ' has-error' : '' }}">
        {!! Form::label('dokter', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('dokter', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('dokter') }}</small>
        </div>
    </div>

  </div>
  <div class="col-md-5">
    <div class="form-group{{ $errors->has('hari') ? ' has-error' : '' }}">
        {!! Form::label('hari', 'Hari', ['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-11">
            {!! Form::select('hari', ['Senin'=>'Senin', 'Selasa'=>'Selasa', 'Rabu'=>'Rabu', 'Kamis'=>'Kamis', 'Jumat'=>'Jumat', 'Sabtu'=>'Sabtu', 'Minggu'=>'Minggu'], null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('hari') }}</small>
        </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group{{ $errors->has('jam_mulai') ? ' has-error' : '' }}">
            {!! Form::label('jam_mulai', 'Jam', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('jam_mulai', null, ['class' => 'form-control timepicker']) !!}
                <small class="text-danger">{{ $errors->first('jam_mulai') }}</small>
            </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group{{ $errors->has('jam_berakhir') ? ' has-error' : '' }}">
            {!! Form::label('jam_berakhir', 'Sampai', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('jam_berakhir', null, ['class' => 'form-control timepicker']) !!}
                <small class="text-danger">{{ $errors->first('jam_berakhir') }}</small>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
  </div>
</div>
