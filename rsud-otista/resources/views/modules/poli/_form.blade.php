<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('politype') ? ' has-error' : '' }}">
    {!! Form::label('politype', 'Jenis Poli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('politype', $poli, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('politype') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('bpjs') ? ' has-error' : '' }}">
    {!! Form::label('bpjs', 'BPJS', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('bpjs', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('bpjs') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('instalasi_id') ? ' has-error' : '' }}">
    {!! Form::label('instalasi_id', 'Instalasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('instalasi_id', $instalasi, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('instalasi_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kelompok') ? ' has-error' : '' }}">
    {!! Form::label('kelompok', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kelompok', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelompok') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('audio') ? ' has-error' : '' }}">
    {!! Form::label('audio', 'Audio', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('audio', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('audio') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('audio') ? ' has-error' : '' }}">
    {!! Form::label('general_code', 'General Code', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('general_code', @$poli_u->general_code, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('audio') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kamar_id') ? ' has-error' : '' }}">
    {!! Form::label('kamar_id', 'Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kamar_id', $kamar, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kamar_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
    {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select name="dokter_id[]" class="form-control select2 multiple" multiple> 
            {{-- <option value="">[ Semua ]</option> --}}
            @foreach ($dokter as $d)
            @if(in_array($d->id, explode(',', @$poli_u->dokter_id)))
                 <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                @else
                 <option value="{{ $d->id }}">{{ $d->nama }}</option>
                @endif
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('perawat_id') ? ' has-error' : '' }}">
    {!! Form::label('perawat_id', 'Perawat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select name="perawat_id[]" class="form-control select2 multiple" multiple> 
            {{-- <option value="">[ Semua ]</option> --}}
            @foreach ($perawat as $d)
            @if(in_array($d->id, explode(',', @$poli_u->perawat_id)))
                 <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                @else
                 <option value="{{ $d->id }}">{{ $d->nama }}</option>
                @endif
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('perawat_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('satusehat_room') ? ' has-error' : '' }}">
    {!! Form::label('satusehat_room', 'Ruangan Satu Sehat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <input name="satusehat_room" {{@$poli_u->satusehat_room == "Y" ? 'checked' : ''}} type="radio" value="Y"><label for="">Ya</label>
        <input name="satusehat_room" type="radio" {{@$poli_u->satusehat_room == "N" ? 'checked' : ''}} value="N"><label for="">Tidak</label>
        <small class="text-danger">{{ $errors->first('satusehat_room') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    {!! Form::reset("Reset", ['class' => 'btn btn-warning btn-flat']) !!}
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
@section('script')
@parent
  <script type="text/javascript">
    
    $('.select2').select2();
  </script>
@endsection
