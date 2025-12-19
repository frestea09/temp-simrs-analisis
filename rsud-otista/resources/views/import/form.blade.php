
<div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }}">
    {!! Form::label('jenis', 'Jenis ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {{-- @php
          $def = ($kategori_header == 1) ? 'TA' : 'TG';
        @endphp --}}
        {!! Form::select('jenis', ['TA'=>'TA', 'TG'=>'TG'], null, ['class' => 'chosen-select']) !!}
        <small class="text-danger">{{ $errors->first('jenis') }}</small>
    </div>
</div>

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
