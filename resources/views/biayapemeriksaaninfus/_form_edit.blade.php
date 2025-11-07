<input type="hidden" name="_method" value="PUT">
<div class="form-group{{ $errors->has('nama_biaya') ? ' has-error' : '' }}">
    {!! Form::label('nama_biaya', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama_biaya', @$biayainfus->nama_biaya, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_biaya') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
    {!! Form::label('tarif_id', 'Tarif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6" style="padding-right: 0;">
        <select name="tarif_id" id="" class="chosen-select">
            @foreach ($tarif as $item)
                <option value="{{$item->id}}">{{$item->nama}} - {{number_format($item->total)}}</option>
            @endforeach
        </select>
        {{-- {!! Form::select('tarif_id', $tarif, null, ['class' => 'chosen-select']) !!} --}}
        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
    </div>
    <div class="col-sm-3" style="padding-left: 0;">
        <button class="btn btn-primary" type="button" onclick="saveTarifBiayaInfus({{@$biayainfus->id}})">Tambah Tarif</button>
    </div>
</div>
