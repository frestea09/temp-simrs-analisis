<input type="hidden" name="_method" value="PUT">
<div class="form-group{{ $errors->has('nama_biaya') ? ' has-error' : '' }}">
    {!! Form::label('nama_biaya', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama_biaya', @$biayafarmasi->nama_biaya, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_biaya') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
    {!! Form::label('masterobat_id', 'Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-8" style="padding-right: 0;">
        <select name="masterobat_id" id="" class="chosen-select">
            @foreach ($obat as $item)
                <option value="{{$item->id}}">{{$item->nama}} - {{number_format($item->hargajual)}}</option>
            @endforeach
        </select>
        {{-- {!! Form::select('masterobat_id', $obat, null, ['class' => 'chosen-select']) !!} --}}
        <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('qty') ? ' has-error' : '' }}">
    {!! Form::label('qty', 'Qty', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::number('qty', @$biayafarmasi->qty, ['class' => 'form-control', 'min' => 1]) !!}
        <small class="text-danger">{{ $errors->first('qty') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('cara_minum') ? ' has-error' : '' }}">
    {!! Form::label('cara_minum', 'Signa', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('cara_minum', @$biayafarmasi->cara_minum, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('cara_minum') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('informasi') ? ' has-error' : '' }}">
    {!! Form::label('informasi', 'Informasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('informasi', @$biayafarmasi->informasi, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('informasi') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('obat_racikan') ? ' has-error' : '' }}">
    {!! Form::label('obat_racikan', 'Jenis', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::select('obat_racikan', ['N' => 'NON RACIK', 'Y' => 'RACIKAN'], @$biayafarmasi->obat_racikan, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('obat_racikan') }}</small>
    </div>
    <div class="col-sm-3" style="padding-left: 0;">
        <button class="btn btn-primary" type="button" onclick="saveObatBiayaFarmasi({{ @$biayafarmasi->id }})">Tambah Obat</button>
    </div>
</div>
