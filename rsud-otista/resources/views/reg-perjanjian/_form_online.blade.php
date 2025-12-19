{!! Form::hidden('antrian_id', session('antrian_id')) !!}
{!! Form::hidden('status_reg', 'J1') !!}
{!! Form::hidden('bayar', '1') !!}
{!! Form::hidden('registrasi_dummy_id', $pasien->id) !!}
{!! Form::hidden('nomorantrian', $pasien->kodebooking) !!}
{!! Form::hidden('nomorrujukan', $pasien->nomorrujukan) !!}
@php
    // $pasienBaru = \App\RegistrasiDummy::where('jenis_registrasi','pasien_baru')->where('nik',$pasien->nik)->first();
    $pasienLama = \Modules\Pasien\Entities\Pasien::where('nik',$pasien->nik)->first();

    $tglperiksa = $pasien ? date('d-m-Y',strtotime(@$pasien->tglperiksa)) : date('d-m-Y');
    // dd($pasienBaru);
    // $dokter = $pasien->dokter_id ? $pasien->dokter_id : 
    // dd($pasien);
@endphp
<div class="row">
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
      {!! Form::label('poli_id', 'Poli tujuan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <select class="form-control select2" style="width:100%" name="poli_id" id="poli_id">
          <option value=""></option>
          @foreach ($poli as $key => $d)
            <option value="{{ $d->id }}" {{$pasien->kode_poli == $d->bpjs ? 'selected' :'' }} >{{ $d->nama }}</option>
          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('poli_id') }}</small>
      </div>
    </div>
    @php
        $lengthKodeDokter = strlen($pasien->kode_dokter);
        if($lengthKodeDokter <= 3){
          $kodeDokter =  $pasien->kode_dokter;
        }else{
          $kodeDokter = $pasien->dokter_id;
        }
    @endphp
    <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
        {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" style="width:100%" name="dokter_id">
            <option value=""></option>
            @foreach ($dokter as $key => $d)
              <option value="{{ $d->id }}" {{$kodeDokter == $d->id ? 'selected' :'' }} >{{ $d->nama }}</option>
            @endforeach
          </select>
            {{-- {!! Form::select('dokter_id', $dokter, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!} --}}
            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
        </div>
    </div>

    {{-- @if (request()->segment(1) == 'regperjanjian') --}}
      <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
          {!! Form::label('bayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-4">
              {!! Form::select('bayar', $carabayar, $pasien->kode_cara_bayar, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('bayar') }}</small>
          </div>
          <div class="col-sm-5" id="tipeJKN">
              {!! Form::select('jkn', $jenisjkn, $pasien, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
              <small class="text-danger">{{ $errors->first('bayar') }}</small>
          </div>
      </div>
    {{-- @endif --}}

  </div>
  {{-- =========================Kolom Kanan=========================== --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('pengirim_rujukan') ? ' has-error' : '' }}">
      {!! Form::label('pengirim_rujukan', 'Cara Datang', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
          {!! Form::select('pengirim_rujukan', $pengirim_rujukan, @$pasien->jeniskunjungan, ['class' => 'form-control select2']) !!}
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

    <div class="form-group{{ $errors->has('tipe_layanan') ? ' has-error' : '' }}">
        {!! Form::label('tipe_layanan', 'Tipe Layanan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('tipe_layanan', $tipelayanan, 3, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
            <small class="text-danger">{{ $errors->first('tipe_layanan') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', 'Status Pasien', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          @if (!empty($pasienLama))
            {!! Form::select('status', $status, 2, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
          @else
            {!! Form::select('status', $status, 1, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
          @endif
            <small class="text-danger">{{ $errors->first('status') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('sebabsakit_id') ? ' has-error' : '' }}">
        {!! Form::label('sebabsakit_id', 'Sebab Sakit', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('sebabsakit_id', $sebabsakit, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('sebabsakit_id') }}</small>
        </div>
    </div>
    
    @if (request()->segment(1) == 'regperjanjian')
      <div class="form-group{{ $errors->has('created_at') ? ' has-error' : '' }}">
          {!! Form::label('created_at', 'Tanggal Periksa', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::text('created_at', $tglperiksa, ['class' => 'form-control', 'id'=>'regperjanjian', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('created_at') }}</small>
          </div>
      </div>
    @endif

    <input style="margin-left:100px;" type="checkbox" name="billing" value="1" checked> Dengan Billing Retribusi
    
    <div class="btn-group pull-right">
        <a href="{{ url('antrian/daftarantrian') }}" class="btn btn-warning btn-flat">Batal</a>
        {!! Form::submit("Lanjut ", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}
    </div>
  </div>
</div>


@section('script')

<script type='text/javascript'>
  console.log("A");
  $(document).ready(function(){
     // Cek Poli
     $('#poli_id').change(function(){
        var id     = $(this).val();
        
        $.ajax({
          url: '/registrasi/getDokterPoli/'+id,
          type: 'get',
          dataType: 'json',
          success: function(response){
            
          }
          }).done(function(res) {
              // console.log(res)
                $("select[name='dokter_id']").empty()
                data = res
                if (data[0].metadata.code == 200) {
                  // $('select[name="dokter_id"]').append('<option value="">-- Pilih Dokter --</option>')
                  $('select[name="dokter_id"]').prop("disabled", false);
                  $.each(data[1], function(index, val) {
                      $('select[name="dokter_id"]').append('<option data-jam-praktek="'+val.jadwal+'" value="'+ val.id +'">'+ val.namadokter +' | '+val.jadwal+' </option>');
                  });
              }else{
                  $('#dokter_not_found').removeClass('d-none')
                  $('select[name="dokter_id"]').prop("disabled", true);
              }
            })
     });
    });
  </script>
  
  @endsection