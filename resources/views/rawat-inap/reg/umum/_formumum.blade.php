
{!! Form::hidden('status_reg', 'G1') !!}
<div class="row">
  <div class="col-md-6">
      <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
        {!! Form::label('poli_id', 'Poli tujuan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" style="width:100%"  name="poli_id">
            @foreach ($poli as $key => $d)
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
          </select>
          {{-- <select class="form-control select2" style="width:100%" name="poli_id" id="poli_id" required>
              <option value=""> -- Pilih Poli --</option>
            @foreach ($poli as $key => $d)
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
          </select> --}}
          <small class="text-danger">{{ $errors->first('poli_id') }}</small>
        </div>
      </div>
      <div class="form-group{{ $errors->has('rujukan') ? ' has-error' : '' }}">
          {!! Form::label('rujukan', 'Cr Kunjungan', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::select('rujukan', $rujukan, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('rujukan') }}</small>
          </div>
      </div>
    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', 'Status Pasien', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          @if ($pasien && !empty($pasien->id))
            {!! Form::select('status', $status, 2, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
          @else
            {!! Form::select('status', $status, 1, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
          @endif
            <small class="text-danger">{{ $errors->first('status') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
        {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('keterangan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kasus') ? ' has-error' : '' }}">
      {!! Form::label('kasus', 'Kasus', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <select class="form-control select2" id="kasus" name="kasus">
          <option value="1">BARU</option>
          <option value="2">LAMA</option>
       </select>
          <small class="text-danger">{{ $errors->first('kasus') }}</small>
      </div>
    </div>


    {!! Form::hidden('antrian_id', session('antrian_id')) !!}



  </div>
  {{-- =========================================================== --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('pengirim_rujukan') ? ' has-error' : '' }}">
      {!! Form::label('pengirim_rujukan', 'Cara Datang', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
          {!! Form::select('pengirim_rujukan', $pengirim_rujukan, null, ['class' => 'form-control select2']) !!}
          <small class="text-danger">{{ $errors->first('pengirim_rujukan') }}</small>
      </div>
  </div>

  <section class="form-add-puskesmas" style="display: none;">
    <div class="form-group{{ $errors->has('puskesmas_id') ? ' has-error' : '' }}">
        {!! Form::label('puskesmas_id', 'Nama Puskesmas', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <p id="textPuskesmas" style="margin-top:6px;"></p>
            {!! Form::hidden('puskesmas_id', null, ['class' => 'form-control']) !!}
            <button type="button" class="btn btn-default btn-block btn-puskesmas">Pilih Puskesmas</button>
        </div>
    </div>
  </section>

  <section class="form-add-dokter">
    <div class="form-group{{ $errors->has('dokter_perujuk_id') ? ' has-error' : '' }}">
        {!! Form::label('dokter_perujuk_id', 'Nama Dokter Perujuk', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <p id="textPerujuk" style="margin-top:6px;"></p>
            {!! Form::hidden('dokter_perujuk_id', null, ['class' => 'form-control']) !!}
            <button type="button" class="btn btn-default btn-block btn-dokter-perujuk">Pilih Dokter Perujuk</button>
        </div>
    </div>
  </section>
  
    <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
        {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('dokter_id', $dokter, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('sebabsakit_id') ? ' has-error' : '' }}">
        {!! Form::label('sebabsakit_id', 'Sebab Sakit', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('sebabsakit_id', $sebabsakit, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('sebabsakit_id') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
        {!! Form::label('bayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" style="width:100%" name="bayar">
            @foreach ($carabayar as $key => $d)
              @if ($d->id == '2')
                <option value="{{ $d->id }}" selected>{{ $d->carabayar }}</option>
              @else
                <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
              @endif
            @endforeach
          </select>
            <small class="text-danger">{{ $errors->first('bayar') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
        {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <input type="text" name="tanggal" class="form-control datepicker">
        </div>
    </div>
    <div id="perusahaan" class="hide">
      <div class="form-group{{ $errors->has('perusahaan_id') ? ' has-error' : '' }}">
          {!! Form::label('perusahaan_id', 'Perusahaan', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::select('perusahaan_id', $perusahaan, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('perusahaan_id') }}</small>
          </div>
      </div>
    </div>

    <div class="btn-group pull-right">
        {{-- <a href="{{ url('antrian/daftarantrian') }}" class="btn btn-warning btn-flat">Batal</a> --}}
        {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}
    </div>
  </div>
</div>
@php
    if($pasien != null){
		  $id       = $pasien->id;
		}else{
		  $id       ='';
		}
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type='text/javascript'>

$(document).ready(function(){

   // Cek Poli
   $('#poli_id').change(function(){
      var id     = $(this).val();
      var pasien = <?= $id ?>;
        //console.log(pasien);
      $.ajax({
        url: '/registrasi/getkasus/'+id+'/'+pasien,
        type: 'get',
        dataType: 'json',
        success: function(response){
          var len = 0;
          if(response['data'] != null){
             len = response['data'].length;
          }
          if(len > 0){
            $('select[name="kasus"]').val(2).trigger('change')
          }else{
            $('select[name="kasus"]').val(1).trigger('change')
          }
        }
      });
   });
  });
</script>

