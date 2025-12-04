{!! Form::hidden('status_reg', 'J1') !!}
<div class="row">
  <div class="col-md-6">
      <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
        {!! Form::label('poli_id', 'Poli tujuan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" style="width:100%" name="poli_id" id="poli_id" required>
            {{--<option value=""></option>--}}
            <option value=""> -- Pilih Poli --</option>
            @foreach ($poli as $key => $d)
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
          </select>
          <small class="text-danger">{{ $errors->first('poli_id') }}</small>
        </div>
      </div>

      {{-- <div class="form-group{{ $errors->has('rujukan') ? ' has-error' : '' }}">
          {!! Form::label('rujukan', 'Cr Kunjungan', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::select('rujukan', $rujukan, null, ['class' => 'chosen-select']) !!}
              <small class="text-danger">{{ $errors->first('rujukan') }}</small>
          </div>
      </div> --}}

      <div class="form-group{{ $errors->has('kasus') ? ' has-error' : '' }}">
        {!! Form::label('kasus', 'Kunjungan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" id="kasus" name="kasus">
            <option value="1">BARU</option>
            <option value="2">LAMA</option>
         </select>
            <small class="text-danger">{{ $errors->first('kasus') }}</small>
        </div>
      </div>

    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', 'Status Pasien', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">

          @if (request()->segment(3))
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
      
    <div class="form-group">
      {!! Form::label('billing_mcu', 'Billing MCU', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <input style="" type="radio" name="billing_mcu" onchange="paketMcu(this.value)" value="Ya"> Ya <br>
        <input style="" type="radio" name="billing_mcu" onchange="paketMcu(this.value)" value="Tidak" checked> Tidak
      </div>
    </div>

    @php
      $paket_mcu = Modules\Registrasi\Entities\BiayaMcu::all();
    @endphp
    <div class="form-group" style="display: none;" id="paket_mcu">
      {!! Form::label('paket_mcu', 'Paket MCU', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        @forelse ($paket_mcu as $paket)
          <input style="" type="radio" name="paket_mcu" value="{{$paket->id}}"> {{$paket->nama_biaya}} <br>
        @empty
          Tidak ada paket mcu
        @endforelse
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
            {{-- {!! Form::select('dokter_id', $dokter, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!} --}}
            <select class="form-control select2" style="width:100%" id="dokter_id" name="dokter_id" disabled required>
              <option value="">Wajib pilih poli sebelum pilih dokter</option>
            </select>
            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
        </div>
    </div>
    <div class="form-group">
      @php
          $url = '"'.url('/bridgingsep/jadwal-dokter-hfis').'"';
      @endphp
      <label for="poliTujuan" class="col-sm-4 control-label">Jam Praktek<br><a style="cursor: pointer" onclick='javascript:wincal=window.open({{$url}}, width=790,height=400,scrollbars=2)'><i>Lihat jam praktek</i></a></label>
      <div class="col-sm-3">
        {!! Form::text('jam_start', null, ['class' => 'form-control timepicker']) !!}
      </div>
      <label for="jam" class="col-sm-1 control-label">S/D</label>
      <div class="col-sm-3">
        {!! Form::text('jam_end', null, ['class' => 'form-control timepicker']) !!}
      </div>
    </div>
    {{-- <div class="form-group{{ $errors->has('sebabsakit_id') ? ' has-error' : '' }}">
        {!! Form::label('sebabsakit_id', 'Sebab Sakit', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('sebabsakit_id', $sebabsakit, null, ['class' => 'chosen-select']) !!}
            <small class="text-danger">{{ $errors->first('sebabsakit_id') }}</small>
        </div>
    </div> --}}

    <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
        {!! Form::label('bayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" style="width:100%;" name="bayar">
            @foreach ($carabayar as $key => $d)
              <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
            @endforeach
          </select>
            <small class="text-danger">{{ $errors->first('bayar') }}</small>
        </div>
    </div>
    
    {{-- <div class="form-group{{ $errors->has('nomorantrian') ? ' has-error' : '' }}">
      <div class="col-sm-4 control-label">
          <button type="button" id="createAntrian" class="btn btn-info btn-flat"><i class="fa fa-recycle"></i> ANTRIAN BPJS</button>
      </div>
        <div class="col-sm-8 control-label" id="fieldAntrian">
            {!! Form::text('nomorantrian',  !empty($reg->nomorantrian) ? $reg->nomorantrian : '', ['class' => 'form-control readonly','required'=>true,'id'=>'noAntrian','placeholder'=>'Wajib diisi, dengan klik tombol antrian']) !!}
            <small class="text-danger">{{ $errors->first('no_sep') }}</small>
        </div>
    </div> --}}
    <div id="perusahaan">
      <div class="form-group{{ $errors->has('perusahaan_id') ? ' has-error' : '' }}">
          {!! Form::label('perusahaan_id', 'Perusahaan', ['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-9">
              {!! Form::select('perusahaan_id', $perusahaan, null, ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('perusahaan_id') }}</small>
          </div>
      </div>
    </div>
    <input style="margin-left:100px;" type="checkbox" name="billing" value="1" checked> Dengan Billing Retribusi
    <div class="btn-group pull-right">
        <a href="{{ url('antrian/daftarantrian') }}" class="btn btn-warning btn-flat">Batal</a>
        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}
    </div>



  </div>
</div>


<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type='text/javascript'>
  function paketMcu(mcu) {
    if (mcu == "Ya") {
      $('#paket_mcu').show();
    } else {
      $('#paket_mcu').hide();
    }
  }
$(document).ready(function(){

   // Cek Poli
   $('#poli_id').change(function(){
      var id     = $(this).val();
      var pasien = <?= $id; ?>
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
