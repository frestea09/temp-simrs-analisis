<div class="form-group{{ $errors->has('kelompokkelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelompokkelas_id', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control select2" name="kelompokkelas_id">
          <option value=""></option>
          @foreach (App\Kelompokkelas::all() as $d)
            @if (isset($bed) && $bed->kelompokkelas_id == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->kelompok }}</option>
            @else
              <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
            @endif

          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('kelompokkelas_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control select2" name="kelas_id">
          @if (isset($bed))
            <option value="{{ $bed->kelas_id }}" selected>{{ Modules\Kelas\Entities\Kelas::find($bed->kelas_id)->nama }}</option>
          @endif
        </select>
        <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kamarid') ? ' has-error' : '' }}">
    {!! Form::label('kamarid', 'Nama Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control select2" name="kamarid">
          @if (isset($bed))
            <option value="{{ @$bed->kamar_id }}" selected>{{ Modules\Kamar\Entities\Kamar::find($bed->kamar_id)->nama }}</option>
          @endif
        </select>
        <small class="text-danger">{{ $errors->first('kamarid') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Bed', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode Bed', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('virtual') ? ' has-error' : '' }}">
    {!! Form::label('virtual', 'JENIS BED', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('virtual', ['N'=>'BED RESMI', 'Y'=>'BED VIRTUAL'], @$bed->virtual, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('virtual') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('hidden') ? ' has-error' : '' }}">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <input type="checkbox" name="hidden" id="hidden" value="Y" {{@$bed->hidden == 'Y' ? 'checked' : ''}}>
        {!! Form::label('hidden', 'Sembunyikan BED di tampilan display') !!}
    </div>
</div>
{{-- <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
    </div>
</div> --}}
{{-- <div class="form-group{{ $errors->has('kode_bed') ? ' has-error' : '' }}">
  {!! Form::label('kode_bed', 'Kode Bed', ['class' => 'col-sm-3 control-label']) !!}
  <div class="col-sm-9">
      {!! Form::text('kode_bed', null, ['class' => 'form-control']) !!}
      <small class="text-danger">{{ $errors->first('kode_bed') }}</small>
  </div>
</div>
<div class="form-group{{ $errors->has('nama_bed') ? ' has-error' : '' }}">
  {!! Form::label('nama_bed', 'Bed', ['class' => 'col-sm-3 control-label']) !!}
  <div class="col-sm-9">
      {!! Form::text('nama_bed', null, ['class' => 'form-control']) !!}
      <small class="text-danger">{{ $errors->first('nama_bed') }}</small>
  </div>
</div>
<div class="form-group{{ $errors->has('id_ss_bed') ? ' has-error' : '' }}">
  {!! Form::label('id_ss_bed', 'ID Satu Sehat Bed', ['class' => 'col-sm-3 control-label']) !!}
  <div class="col-sm-9">
      {!! Form::text('id_ss_bed', null, ['class' => 'form-control']) !!}
      <small class="text-danger">{{ $errors->first('id_ss_bed') }}</small>
  </div>
</div> --}}

<div class="btn-group pull-right">
    <a href="{{ route('bed') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>



