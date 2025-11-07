  
<div class="form-group{{ $errors->has('import') ? ' has-error' : '' }}">
    {!! Form::label('excel', 'File', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::file('excel', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="btn-group pull-right">
    {!! Form::submit("Upload", ['class' => 'btn btn-success btn-flat']) !!}
</div>
