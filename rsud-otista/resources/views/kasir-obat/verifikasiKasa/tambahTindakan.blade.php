<table class="table table-bordered table-condensed">
  <tr>
    <th>Nama Pasien</th><td>{{ $pasien->nama }}</td>
  </tr>
  <tr>
    <th>Nomor RM</th><td>{{ $pasien->no_rm }}</td>
  </tr>
</table>

<hr>
<form method="POST" id="formTambahTindakan" class="form-horizontal">
{{ csrf_field() }} {{ method_field('POST') }}
{!! Form::hidden('registrasi_id', $reg_id) !!}
{!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
{!! Form::hidden('pasien_id', $pasien->id) !!}
<div class="row">
  <div class="col-md-7">
    <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
        {!! Form::label('dokter_id', 'Dokter Pemeriksa', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('dokter_id', $dokter, session('dokter'), ['class' => 'form-control select2', 'placeholder'=>'', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
        {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select class="form-control select2" name="tarif_id" style="width:100%">
              {{-- @foreach(Modules\Tarif\Entities\Tarif::where('jenis', 'TA')->get() as $d) --}}
              <option value=""></option>
              @foreach($tindakan as $d)
                <option value="{{ $d->id }}">{{ $d->nama }} | {{ number_format($d->total) }}</option>
              @endforeach
            </select>
            <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
        {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('pelaksana', $perawat, session('pelaksana'), ['class' => 'form-control select2', 'placeholder'=>'', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
        </div>
    </div>
  </div>

  <div class="col-md-5">
    {{-- @if (substr($jenis->status_reg, 0, 1) == 'G')
      <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
          {!! Form::label('perawat', 'Perawat', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::select('perawat', $perawat, session('perawat'), ['class' => 'form-control select2', 'placeholder'=>'', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('perawat') }}</small>
          </div>
      </div>
    @endif --}}

    <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
        {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('jumlah') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
        {!! Form::label('poli_id', 'Poli', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select class="form-control select2" name="poli_id" style="width:100%">
              @foreach ($opt_poli as $key => $d)
                @if ($d->id == $jenis->poli_id)
                  <option value="{{ $d->id }}" selected="true">{{ $d->nama }}</option>
                @else
                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                @endif
                
              @endforeach
            </select>
            <small class="text-danger">{{ $errors->first('poli_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
        {!! Form::label('jumlah', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('tanggal', null, ['class' => 'form-control datepicker']) !!}
            <small class="text-danger">{{ $errors->first('tanggal') }}</small>
        </div>
    </div>
  </div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
  $('.select2').select2();
  $('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    todayHighlight: true,
    autoclose: true
  });
</script>