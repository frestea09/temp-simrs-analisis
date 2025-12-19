<div class="form-group{{ $errors->has('nomer') ? ' has-error' : '' }}">
    {!! Form::label('nomer', 'Nomor', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nomer', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nomer') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kegiatan') ? ' has-error' : '' }}">
    {!! Form::label('kegiatan', 'Kegiatan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kegiatan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kegiatan') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kamar_id') ? ' has-error' : '' }}">
    {!! Form::label('kamar_id', 'Master Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        @foreach ($kamar as $item)
            <div class="row">
                <div class="offset-sm-2 col-sm-1">
                    {!! Form::checkbox('kamar_id[]', $item->id, (isset($conf31) && $conf31->id_conf_rl31 == $item->conf_rl31_id)) !!}
                </div>
                <div class="col-sm-9">
                    {!! Form::label($item->id, $item->nama) !!}
                </div>
            </div>
        @endforeach
        <small class="text-danger">{{ $errors->first('kamar_id') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    {!! Form::reset("Reset", ['class' => 'btn btn-warning btn-flat']) !!}
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
