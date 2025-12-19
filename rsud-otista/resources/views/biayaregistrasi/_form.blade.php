<div class="form-group{{ $errors->has('tipe') ? ' has-error' : '' }}">
    {!! Form::label('tipe', 'Tipe', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('tipe', ['E'=>'E','R'=>'R'], null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('tipe') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
    {!! Form::label('tarif_id', 'Tarif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('tarif_id', $tarif, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tahuntarif_id') ? ' has-error' : '' }}">
    {!! Form::label('tahuntarif_id', 'Tahun Tarif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('tahuntarif_id', $tahuntarif, null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('tahuntarif_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('shift') ? ' has-error' : '' }}">
    {!! Form::label('shift', 'Shift', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('shift', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('shift') }}</small>
    </div>
</div>
