<div class="form-group{{ $errors->has('tipe') ? ' has-error' : '' }}">
    {!! Form::label('tipe', 'Tipe', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('tipe', ['J'=>'Rawat Jalan','G'=>'IGD','I'=>'Rawat Inap'], $jenis, ['class' => 'chosen-select','readonly'=>'readonly']) !!}
        <small class="text-danger">{{ $errors->first('tipe') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('tipe') ? ' has-error' : '' }}">
    {!! Form::label('pasien', 'Untuk Pasien', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('pasien', ['pasien_lama'=>'Pasien Lama','pasien_baru'=>'Pasien Baru'], NULL, ['class' => 'chosen-select','readonly'=>'readonly']) !!}
        <small class="text-danger">{{ $errors->first('tipe') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
    {!! Form::label('tarif_id', 'Tarif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select name="tarif_id" id="" class="chosen-select">
            @foreach ($tarif as $item)
                <option value="{{$item->id}}">{{$item->nama}} - {{number_format($item->total)}}</option>
            @endforeach
        </select>
        {{-- {!! Form::select('tarif_id', $tarif, null, ['class' => 'chosen-select']) !!} --}}
        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
    {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select name="poli_id" id="" class="chosen-select">
            <option value="">Semua</option>
            @foreach ($poli as $key=>$item)
            <option value="{{$key}}">{{$item}}</option>    
            @endforeach
        </select>
        {{-- {!! Form::select('poli_id', $poli, null, ['class' => 'chosen-select']) !!} --}}
        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
    </div>
</div>
{{-- <div class="form-group{{ $errors->has('shift') ? ' has-error' : '' }}">
    {!! Form::label('shift', 'Shift', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('shift', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('shift') }}</small>
    </div>
</div> --}}
