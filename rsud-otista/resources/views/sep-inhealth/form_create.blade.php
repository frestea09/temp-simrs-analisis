@extends('master')
@section('header')
  <h1>Bridging SJP Mandiri Inhealth<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {{-- CEK SEP --}}
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="judul" class="col-sm-2 control-label text-right">Cari Rujukan:</label>
            <div class="col-sm-10 btn-group">
              <button type="button" onclick="nomorKartu()" class="btn btn-primary btn-flat">NOMOR KARTU </button>
              <button type="button" onclick="CetakSJP()" id="cetak-sjp" class="btn btn-success btn-flat" style="display:none;">CETAK SJP </button>
            </div>
          </div>
        </div>
      </div>

      {{--  --}}
    <hr>
      {!! Form::open(['method' => 'POST', 'url' => 'simpan-no-sjp', 'class' => 'form-horizontal', 'id'=>'formSEP']) !!}
          {{-- <input type="hidden" name="no_rm" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->no_rm }}"> --}}
          <input type="hidden" name="nama_ppk_perujuk" value="">
          <input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="no_rm" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->no_rm }}" readonly="true" class="form-control">
                      <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('nama', 'Nama', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="nama" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->nama }}" readonly="true" class="form-control">
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_kartu') ? ' has-error' : '' }}">
                  {!! Form::label('no_kartu', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_kartu', NULL, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_kartu') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
                  {!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_tlp', !empty($reg->pasien->nohp) ? $reg->pasien->nohp : '', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_tlp') }}</small>
                  </div>
              </div>
              <input type="hidden" name="nik" value="{{ !empty($reg->pasien->nik) ? $reg->pasien->nik : NULL }}">
              <div class="form-group{{ $errors->has('tgl_pelayanan') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_pelayanan', 'Tgl Pelayanan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_pelayanan', null, ['class' => 'form-control tanggalSEP']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_pelayanan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('tgl_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_rujukan', 'Tgl Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_rujukan', null, ['class' => 'form-control tanggalSEP']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_rujukan') }}</small>
                  </div>
              </div>
              {{-- <div class="form-group{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_rujukan', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
                  </div>
              </div> --}}
              {{-- <div class="form-group{{ $errors->has('ppk_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('ppk_rujukan', 'PPK Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-3">
                      {!! Form::text('ppk_rujukan', !empty($kd_ppk) ? $kd_ppk : null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('ppk_rujukan') }}</small>
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="nama_perujuk" value="" class="form-control">
                  </div>
              </div> --}}
              
              {{-- <div class="form-group{{ $errors->has('asalRujukan') ? ' has-error' : '' }}">
                  {!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('asalRujukan', ['1'=>'PPK 1', '2'=>'RS'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('asalRujukan') }}</small>
                  </div>
              </div> --}}

              {{-- <div class="form-group{{ $errors->has('hak_kelas_inap') ? ' has-error' : '' }}">
                  {!! Form::label('hak_kelas_inap', 'Hak Kelas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('hak_kelas_inap', !empty($hak_kelas) ? $hak_kelas : null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('hak_kelas_inap') }}</small>
                  </div>
              </div> --}}

              {{-- <div class="form-group{{ $errors->has('cob') ? ' has-error' : '' }}">
                  {!! Form::label('cob', 'COB', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('cob', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('cob') }}</small>
                  </div>
              </div> --}}
              {{-- <div class="form-group{{ $errors->has('katarak') ? ' has-error' : '' }}">
                  {!! Form::label('katarak', 'Katarak', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('katarak', ['1'=>'Tidak', '0'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('katarak') }}</small>
                  </div>
              </div> --}}
              {{-- <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Tgl SEP</label>
                <div class="col-sm-8">
                  <input type="text" name="tglSep" class="form-control tanggalSEP" value="{{ date('Y-m-d') }}">
                </div>
              </div> --}}

            </div>
            <div class="col-md-6">
              {{-- <div class="form-group">
                <label for="tipejkn" class="col-sm-4 control-label">Tipe JKN</label>
                <div class="col-sm-8">
                  <input type="text" name="tipe_jkn" value="{{ !empty($reg->tipe_jkn) ? $reg->tipe_jkn : NULL }}" readonly="true" class="form-control">
                </div>
              </div> --}}
              <div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
                {!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('diagnosa_awal', null, ['class' => 'form-control', 'id'=>'diagnosa_awal']) !!}
                    <small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
                </div>
            </div>
            <div class="form-group{{ $errors->has('informasi_tambahan') ? ' has-error' : '' }}">
              {!! Form::label('informasi_tambahan', 'Informasi Tambahan', ['class' => 'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                  {!! Form::text('informasi_tambahan', '-', ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('informasi_tambahan') }}</small>
              </div>
          </div>
            <div class="form-group{{ $errors->has('jenis_layanan') ? ' has-error' : '' }}">
                {!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::select('jenis_layanan', ['3'=>'Rawat Jalan Tingkat Lanjut (RJTL)', '4'=>'Rawat Inap Tingkat Lanjut (RITL)'], NULL, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                    <small class="text-danger">{{ $errors->first('jenis_layanan') }}</small>
                </div>
            </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Klinik Tujuan </label>
                <div class="col-sm-8">
                  <select name="poli_inhealth" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $d)
                      @if ($d->inhealth == $poli_inhealth)
                         <option value="{{ $d->inhealth }}" selected="true">{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->inhealth }}">{{ $d->nama }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              {{-- <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">No. SKDP</label>
                <div class="col-sm-8">
                  <input type="text" name="noSurat" class="form-control">
                </div>
              </div> --}}
              {{-- <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Kode DPJP </label>
                <div class="col-sm-8">
                  <select name="kodeDPJP" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                      @if ($d->kode_bpjs == $dokter_bpjs)
                        <option value="{{ $d->kode_bpjs }}" selected="true">{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->kode_bpjs }}">{{ $d->nama }}</option>
                      @endif

                    @endforeach
                  </select>
                </div>
              </div> --}}
              <div class="form-group{{ $errors->has('kecelakaan') ? ' has-error' : '' }}">
                  {!! Form::label('kecelakaan', 'Kecelakaan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('kecelakaan', ['0'=>'Tidak', '1'=>'Kecelakaan Kerja', '2'=>'Kecelakaan Lalu Lintas'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('kecelakaan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_sep') ? ' has-error' : '' }}">
                  <div class="col-sm-4 control-label">
                    <button type="button" id="createSJP" class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT SJP</button>
                  </div>
                  <div class="col-sm-8">
                      {!! Form::text('no_sjp', null, ['class' => 'form-control', 'id'=>'no_sjp', 'readonly']) !!}
                      {!! Form::hidden('tkp', null, ['class' => 'form-control', 'id'=>'tkp']) !!}
                      <small class="text-danger">{{ $errors->first('no_sjp') }}</small>
                  </div>
              </div>
              <div class="btn-group pull-right">
                  {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
              </div>

            </div>
          </div>


      {!! Form::close() !!}
            {{-- State loading --}}
            <div class="overlay hidden">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
    <div class="box-footer">
    </div>
  </div>

  <div class="modal fade" id="ICD10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Add</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <form method="POST" class="form-horizontal" id="form-eligibilitas">
      {{ csrf_field() }} {{ method_field('POST') }}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pencarian Peserta Berdasar Nomor Kartu INHEALTH</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="judul" class="col-sm-3 control-label">Nomor Kartu</label>
            <div class="col-sm-6">
              <input type="text" name="no_kartu" class="form-control">
            </div>
          </div>
          {{-- <div class="form-group">
            <label for="judul" class="col-sm-3 control-label">Tanggal Pelayanan</label>
            <div class="col-sm-6">
              <input type="text" name="tgl_pelayanan" class="form-control tgl_pelayanan">
            </div>
          </div> --}}
          <div class="form-group">
            <label for="judul" class="col-sm-3 control-label">Poli</label>
            <div class="col-sm-6">
              <select name="poli" class="form-control select2" style="width: 100%">
                @foreach ($poli as $d)
                  @if ($d->inhealth == $poli_inhealth)
                     <option value="{{ $d->inhealth }}" selected="true">{{ $d->nama }}</option>
                  @else
                    <option value="{{ $d->inhealth }}">{{ $d->nama }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="col-sm-3"><button type="button" class="btn btn-primary btn-flat cari-inhealth" onclick="">CARI</button></div>
          </div>
          <hr>
          <div class="table-responsive">
            <table class="table table-bordered table-condensed tableMultipleRujukan">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Plan</th>
                  <th>Dokter Keluarga</th>
                  <th>Poli Tujuan</th>
                  <th>Tgl Pelayanan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="data-inhealth">
              </tbody>
            </table>
          </div>
          <p class="text-center text-danger statusError" style="font-weight: bold"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">TUTUP</button>
          {{-- <button type="button" class="btn btn-primary btn-flat cari-inhealth" onclick="">CARI</button> --}}
        </div>
      </div>
      </form>
  
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    $('.datepicker').datepicker({ endDate: new Date(), autoclose: true, format: "yyyy-mm-dd" });

    $( function() {
      $( ".tanggalSEP" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });
      $( ".tgl_pelayanan" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });
      $('input[name="tgl_pelayanan"]').datepicker({dateFormat:"yyyy-mm-dd"}).datepicker("setDate", new Date());
    });
    
    // start
    let base_url = "{{ url('/') }}";
    function nomorKartu() {
      $('#myModal').modal('show')
    }

    function CetakSJP(){
      let nosjp = $('input[name="no_sjp"]').val();
      let tkp = $('input[name="tkp"]').val();
      $.ajax({
        url: base_url+'/cetak-sjp',
        type: 'POST',
        dataType: 'json',
        data: { _token : "{{ csrf_token() }}", nosjp : nosjp, tkp : tkp },
        beforeSend: function () {
          $('button#cetak-sjp').html('Tunggu Sebentar...');
          $('button#cetak-sjp').prop('disabled', true);
        }
      }).done(function(res) {
        $('button#cetak-sjp').html('CETAK SJP');
        $('button#cetak-sjp').prop('disabled', false);
        if(res.status == false){
          alert(res.msg);
        }else{
          window.open(res.file, '_blank');
        }
      });
    }

    $(document).on('click','.cari-inhealth',function(){
      $.ajax({
        url: base_url+'/cari-sep-inhealth/noka',
        type: 'POST',
        dataType: 'json',
        data: $('#form-eligibilitas').serialize(),
        beforeSend: function () {
          $('tbody#data-inhealth').html("<tr class='text-center'><td colspan='6'>Tunggu Sebentar...</td></tr>");
        }
      }).done(function(res) {
        $('tbody#data-inhealth').html('');
        $('tbody#data-inhealth').html(res.html);
      });
    })

    $(document).on('click','#pilih-inhealth', function(){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-nama');
      // let tgl_pelayanan = $(this).attr('data-tgl-pelayanan');
      if( confirm("Apakah Anda Yakin?") ){
        $('input[name="no_kartu"]').val(id);
        $('input[name="nama"]').val(nama);
        // $('input[name="tgl_pelayanan"]').datepicker("setDate", new Date(tgl_pelayanan));
        $('#myModal').modal('hide')
      }
    })

    $(document).on('click','#createSJP', function(){
      $.ajax({
        url: base_url+'/buat-sjp',
        type: 'POST',
        dataType: 'json',
        data: $('#formSEP').serialize(),
        beforeSend: function () {
          $('button#createSJP').html("Tunggu Sebentar...");
          $('button#createSJP').prop('disabled', true);
        }
      }).done(function(res) {
        $('button#createSJP').prop('disabled', false);
        $('button#createSJP').html('<i class="fa fa-recycle"></i>BUAT SJP');
        if( res.status == true ){
          $('input[name="no_sjp"]').val(res.nosjp);
          $('input[name="tkp"]').val(res.tkp);
          $('button#cetak-sjp').show();
        }else{
          alert(res.msg)
        }
      });
    })
    // end

    // function rujukanRS() {
    //   $('#modalPencarian').modal('show')
    //   $('.modal-dialog').addClass('modal-lg')
    //   $('.tableMultipleRujukan').addClass('hidden')
    //   $('.tableStatus').addClass('hidden')
    //   $('.rujukan').addClass('hidden')
    //   $('.lanjut').addClass('hidden')
    //   $('.statusError').text('')
    //   $('.modal-title').text('Pencarian Rujukan PPK2 Berdasar Nomor Kartu')
    //   $('.judul').text('Nomor Kartu')
    //   $('.formInput').empty()
    //   $('.formInput').append('<input type="text" name="no_kartu" class="form-control">')
    //   $('.save').attr('onclick', 'cariNoRujukanPPK2()');
    // }

    // function rujukanRSbyRujukan() {
    //   $('#modalPencarian').modal('show')
    //   $('.modal-dialog').removeClass('modal-lg')
    //   $('.tableMultipleRujukan').addClass('hidden')
    //   $('.tableStatus').addClass('hidden')
    //   $('.rujukan').addClass('hidden')
    //   $('.lanjut').addClass('hidden')
    //   $('.statusError').text('')
    //   $('.modal-title').text('Pencarian Peserta Berdasar Nomor Rujukan PPK 2')
    //   $('.judul').text('Nomor Rujukan')
    //   $('.formInput').empty()
    //   $('.formInput').append('<input type="text" name="no_rujukan" class="form-control">')
    //   $('.save').attr('onclick', 'cariNoRujukanPPK2byRujukan()');
    // }

    // function nomorNik() {
    //   $('#modalPencarian').modal('show')
    //   $('.modal-dialog').removeClass('modal-lg')
    //   $('.tableMultipleRujukan').addClass('hidden')
    //   $('.tableStatus').addClass('hidden')
    //   $('.rujukan').addClass('hidden')
    //   $('.lanjut').addClass('hidden')
    //   $('.statusError').text('')
    //   $('.modal-title').text('Pencarian Peserta Berdasar Nomor NIK')
    //   $('.judul').text('Nomor NIK')
    //   $('.formInput').empty()
    //   $('.formInput').append('<input type="text" name="nik" class="form-control">')
    //   $('.save').attr('onclick', 'cariNIK()');
    // }

    // function nomorRujukan() {
    //   $('#modalPencarian').modal('show')
    //   $('.modal-dialog').removeClass('modal-lg')
    //   $('.tableMultipleRujukan').addClass('hidden')
    //   $('.tableStatus').addClass('hidden')
    //   $('.rujukan').addClass('hidden')
    //   $('.lanjut').addClass('hidden')
    //   $('.statusError').text('')
    //   $('.modal-title').text('Pencarian Peserta Berdasar Nomor Rujukan')
    //   $('.judul').text('Nomor Rujukan')
    //   $('.formInput').empty()
    //   $('.formInput').append('<input type="text" name="no_rujukan" class="form-control">')
    //   $('.save').attr('onclick', 'cariNoRujukan()');
    // }

    // function postRawat() {
    //   $('#modalPencarian').modal('show')
    //   $('.modal-dialog').removeClass('modal-lg')
    //   $('.tableMultipleRujukan').addClass('hidden')
    //   $('.tableStatus').addClass('hidden')
    //   $('.rujukan').addClass('hidden')
    //   $('.lanjut').addClass('hidden')
    //   $('.statusError').text('')
    //   $('.modal-title').text('Pos Rawat Inap')
    //   $('.judul').text('Nomor Kartu')
    //   $('.formInput').empty()
    //   $('.formInput').append('<input type="text" name="no_kartu" class="form-control">')
    //   $('.save').attr('onclick', 'savePosRawatInap()');
    // }

    // function postHD() {
    //   $('#modalPencarian').modal('show')
    //   $('.tableStatus').addClass('hidden')
    //   $('.rujukan').addClass('hidden')
    //   $('.lanjut').addClass('hidden')
    //   $('.statusError').text('')
    //   $('.modal-title').text('Post HD')
    //   $('.judul').text('Nomor Kartu')
    //   $('.formInput').empty()
    //   $('.formInput').append('<input type="text" name="no_kartu" class="form-control">')
    //   $('.save').attr('onclick', 'savePosHD()');
    // }

// ================================== AJAX =============================================
    // function cariNoKartu() {
    //   $('.tableStatus').addClass('hidden')
    //   $('.rujukan').addClass('hidden');
    //   $('.tableMultipleRujukan').addClass('hidden')
    //   $('.statusError').text('')
    //   $.ajax({
    //     url: '/cari-sep-inhealth/noka',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: $('#formPencarian').serialize(),
    //     beforeSend: function () {
    //       $('.progress').removeClass('hidden')
    //     },
    //     complete: function () {
    //       $('.progress').addClass('hidden')
    //     }
    //   })
    //   .done(function(data) {
    //     if (data.metaData.code == 201) {
    //       $('.statusError').text(data.metaData.message)
    //     }
    //     if (data.metaData.code == 200) {
    //       $('.tableMultipleRujukan').removeClass('hidden')
    //       $('#dataMultipleRujukan').empty()
    //       $.each(data.response.rujukan, function(index, val) {
    //          $('#dataMultipleRujukan').append('<tr> <td>'+val.peserta.mr.noMR+'</td> <td>'+val.peserta.noKartu+'</td> <td><button class="btn btn-default btn-flat btn-xs" onclick="getDataRujukan(\''+val.noKunjungan+'\')">'+val.noKunjungan+'</button></td> <td>'+val.pelayanan.nama+'</td> <td>'+val.poliRujukan.nama+'</td> <td>'+val.tglKunjungan+'</td> </tr>')
    //       });
    //     }
    //   });
    // }

    //GET RUJUKAN FROM MULTIPLE
    // function getDataRujukan(noKunjungan) {
    //   var token = $('input[name="_token"]').val()
    //   if (confirm('Yakin Nomor Rujukan '+ noKunjungan +' akan di buat SJP?')) {
    //     $.ajax({
    //       url: '/get-data-by-rujukan',
    //       type: 'POST',
    //       dataType: 'json',
    //       data: { '_token' : token, 'no_rujukan' : noKunjungan},
    //     })
    //     .done(function(data) {
    //       $('.tableMultipleRujukan').removeClass('hidden')
    //       $('.statusError').text('')
    //       $('#modalPencarian').modal('hide')
    //       //FORM
    //       $('input[name="nama"]').val(data.response.rujukan.peserta.nama)
    //       $('input[name="no_bpjs"]').val(data.response.rujukan.peserta.noKartu)
    //       $('input[name="no_tlp"]').val(data.response.rujukan.peserta.mr.noTelepon)
    //       $('input[name="ppk_rujukan"]').val(data.response.rujukan.peserta.provUmum.kdProvider)
    //       $('input[name="nik"]').val(data.response.rujukan.peserta.nik)
    //       $('input[name="nama_perujuk"]').val(data.response.rujukan.peserta.provUmum.nmProvider)
    //       $('input[name="hak_kelas_inap"]').val(data.response.rujukan.peserta.hakKelas.kode)
    //       $('input[name="no_rujukan"]').val(data.response.rujukan.noKunjungan)
    //       $('input[name="tgl_rujukan"]').val(data.response.rujukan.tglKunjungan)
    //       $('input[name="diagnosa_awal"]').val(data.response.rujukan.diagnosa.kode)
    //     });
    //   }


    // }

    // function cariNoRujukan() {
    //   $('.tableStatus').addClass('hidden')
    //   $.ajax({
    //     url: '/get-data-by-rujukan',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: $('#formPencarian').serialize(),
    //     beforeSend: function () {
    //       $('.progress').removeClass('hidden')
    //     },
    //     complete: function () {
    //       $('.progress').addClass('hidden')
    //     }
    //   })
    //   .done(function(data) {
    //     if (data.metaData.code == 201) {
    //       $('.statusError').text(data.metaData.message)
    //     }
    //     if (data.metaData.code == 200) {
    //       $('.statusError').text('')
    //       $('.tableStatus').removeClass('hidden')
    //       $('.lanjut').removeClass('hidden')
    //       $('.statusError').text('')
    //       $('.nama').text(data.response.rujukan.peserta.nama)
    //       $('.noka').text(data.response.rujukan.peserta.noKartu)
    //       $('.status').text(data.response.rujukan.peserta.statusPeserta.keterangan)
    //       $('.rujukan').removeClass('hidden');
    //       $('.ppkPerujuk').text(data.response.rujukan.provPerujuk.nama)
    //       $('.dinsos').text(data.response.rujukan.peserta.informasi.dinsos)
    //       $('.noSKTM').text(data.response.rujukan.peserta.informasi.noSKTM)
    //       $('.prolanisPRB').text(data.response.rujukan.peserta.informasi.prolanisPRB)
    //       //FORM
    //       $('input[name="nama"]').val(data.response.rujukan.peserta.nama)
    //       $('input[name="no_bpjs"]').val(data.response.rujukan.peserta.noKartu)
    //       $('input[name="no_tlp"]').val(data.response.rujukan.peserta.mr.noTelepon)
    //       $('input[name="no_rujukan"]').val(data.response.rujukan.noKunjungan)
    //       $('input[name="tgl_rujukan"]').val(data.response.rujukan.tglKunjungan)
    //       $('input[name="ppk_rujukan"]').val(data.response.rujukan.provPerujuk.kode)
    //       $('input[name="nik"]').val(data.response.rujukan.peserta.nik)
    //       $('input[name="nama_perujuk"]').val(data.response.rujukan.peserta.provUmum.nmProvider)
    //       $('input[name="diagnosa_awal"]').val(data.response.rujukan.diagnosa.kode)
    //       $('input[name="hak_kelas_inap"]').val(data.response.rujukan.peserta.hakKelas.kode)
    //       $('select[name="poli_bpjs"]').val(data.response.rujukan.poliRujukan.kode).trigger('change')
    //     }

    //   });

    // }

    // function cariNIK() {
    //   $('.tableStatus').addClass('hidden')
    //   $.ajax({
    //     url: '/cari-nik',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: $('#formPencarian').serialize(),
    //     beforeSend: function () {
    //       $('.progress').removeClass('hidden')
    //     },
    //     complete: function () {
    //       $('.progress').addClass('hidden')
    //     }
    //   })
    //   .done(function(data) {
    //     if (data.metaData.code == 201) {
    //       $('.statusError').text(data.metaData.message)
    //     }
    //     if (data.metaData.code == 200) {
    //       $('.statusError').text('')
    //       $('.tableStatus').removeClass('hidden')
    //       $('.lanjut').removeClass('hidden')
    //       $('.statusError').text('')
    //       $('.nama').text(data.response.peserta.nama)
    //       $('.nik').text(data.response.peserta.nik)
    //       $('.tglLahir').text(data.response.peserta.tglLahir)
    //       $('.noTelepon').text(data.response.peserta.mr.noTelepon)
    //       $('.noka').text(data.response.peserta.noKartu)
    //       $('.status').text(data.response.peserta.statusPeserta.keterangan)
    //       $('.rujukan').removeClass('hidden');
    //       $('.ppkPerujuk').text(data.response.peserta.provUmum.kode)
    //       //FORM
    //       $('input[name="nama"]').val(data.response.peserta.nama)
    //       $('input[name="no_bpjs"]').val(data.response.peserta.noKartu)
    //       $('input[name="no_tlp"]').val(data.response.peserta.mr.noTelepon)
    //       $('input[name="hak_kelas_inap"]').val(data.response.peserta.hakKelas.kode)
    //       $('input[name="ppk_rujukan"]').val(data.response.peserta.provUmum.kdProvider)

    //     }

    //   });

    // }

    //CARI RUJUKAN PPK2
    // function cariNoRujukanPPK2() {
    //   $('.tableStatus').addClass('hidden')
    //   $.ajax({
    //     url: '/bridgingsep/insert-rujukan-rs',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: $('#formPencarian').serialize(),
    //     beforeSend: function () {
    //       $('.progress').removeClass('hidden')
    //     },
    //     complete: function () {
    //       $('.progress').addClass('hidden')
    //     }
    //   })
    //   .done(function(data) {
    //     if (data.metaData.code == 201) {
    //       $('.statusError').text(data.metaData.message)
    //     }
    //     if (data.metaData.code == 200) {
    //       $('.tableMultipleRujukan').removeClass('hidden')
    //       $('#dataMultipleRujukan').empty()
    //       $.each(data.response.rujukan, function(index, val) {
    //          $('#dataMultipleRujukan').append('<tr> <td>'+val.peserta.mr.noMR+'</td> <td>'+val.peserta.noKartu+'</td> <td><button class="btn btn-default btn-flat btn-xs" onclick="getDataRujukanPPK2(\''+val.noKunjungan+'\')">'+val.noKunjungan+'</button></td> <td>'+val.pelayanan.nama+'</td> <td>'+val.poliRujukan.nama+'</td> <td>'+val.tglKunjungan+'</td> </tr>')
    //       });
    //     }
    //   });
    // }

    // function getDataRujukanPPK2(noKunjungan) {
    //   if (confirm('Yakin Nomor Rujukan '+noKunjungan+' akan di buat SEP?')) {
    //     $.ajax({
    //       url: '/bridgingsep/insert-rujukan-rs-byrujukan',
    //       type: 'POST',
    //       dataType: 'json',
    //       data: {'_token': $('input[name="_token"]').val(), 'no_rujukan' : noKunjungan},
    //     })
    //     .done(function(data) {
    //       $('.tableMultipleRujukan').removeClass('hidden')
    //       $('.statusError').text('')
    //       $('#modalPencarian').modal('hide')
    //       // //FORM
    //       $('input[name="nama"]').val(data.response.rujukan.peserta.nama)
    //       $('input[name="no_bpjs"]').val(data.response.rujukan.peserta.noKartu)
    //       $('input[name="no_tlp"]').val(data.response.rujukan.peserta.mr.noTelepon)
    //       $('input[name="no_rujukan"]').val(data.response.rujukan.noKunjungan)
    //       $('input[name="tgl_rujukan"]').val(data.response.rujukan.tglKunjungan)
    //       $('input[name="ppk_rujukan"]').val(data.response.rujukan.provPerujuk.kode)
    //       $('input[name="nik"]').val(data.response.rujukan.peserta.nik)
    //       $('input[name="nama_perujuk"]').val(data.response.rujukan.peserta.provUmum.nmProvider)
    //       $('input[name="diagnosa_awal"]').val(data.response.rujukan.diagnosa.kode)
    //       $('input[name="hak_kelas_inap"]').val(data.response.rujukan.peserta.hakKelas.kode)
    //       $('select[name="poli_bpjs"]').val(data.response.rujukan.poliRujukan.kode).trigger('change')
    //       $('select[name="asalRujukan"]').val('2').trigger('change')
    //     });
    //   }
    // }

    // //Rujukan PPK2 By Nomor Rujukan
    // function cariNoRujukanPPK2byRujukan() {
    //   $('.tableStatus').addClass('hidden')
    //   $.ajax({
    //     url: '/bridgingsep/insert-rujukan-rs-byrujukan',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: $('#formPencarian').serialize(),
    //     beforeSend: function () {
    //       $('.progress').removeClass('hidden')
    //     },
    //     complete: function () {
    //       $('.progress').addClass('hidden')
    //     }
    //   })
    //   .done(function(data) {
    //     if (data.metaData.code == 201) {
    //       $('.statusError').text(data.metaData.message)
    //     }
    //     if (data.metaData.code == 200) {
    //       $('.tableStatus').removeClass('hidden')
    //       $('.lanjut').removeClass('hidden')
    //       $('.nama').text(data.response.rujukan.peserta.nama)
    //       $('.tglLahir').text(data.response.rujukan.peserta.tglLahir)
    //       $('.nik').text(data.response.rujukan.peserta.nik)
    //       $('.noTelepon').text(data.response.rujukan.peserta.mr.noTelepon)
    //       $('.noka').text(data.response.rujukan.peserta.noKartu)
    //       $('.status').text(data.response.rujukan.peserta.statusPeserta.keterangan)
    //       $('.rujukan').removeClass('hidden');
    //       $('.ppkPerujuk').text(data.response.rujukan.provPerujuk.nama)
    //       $('.dinsos').text(data.response.rujukan.peserta.informasi.dinsos)
    //       $('.noSKTM').text(data.response.rujukan.peserta.informasi.noSKTM)
    //       $('.prolanisPRB').text(data.response.rujukan.peserta.informasi.prolanisPRB)
    //       //FORM
    //       $('input[name="nama"]').val(data.response.rujukan.peserta.nama)
    //       $('input[name="no_bpjs"]').val(data.response.rujukan.peserta.noKartu)
    //       $('input[name="no_tlp"]').val(data.response.rujukan.peserta.mr.noTelepon)
    //       $('input[name="no_rujukan"]').val(data.response.rujukan.noKunjungan)
    //       $('input[name="tgl_rujukan"]').val(data.response.rujukan.tglKunjungan)
    //       $('input[name="ppk_rujukan"]').val(data.response.rujukan.provPerujuk.kode)
    //       $('input[name="nik"]').val(data.response.rujukan.peserta.nik)
    //       $('input[name="nama_perujuk"]').val(data.response.rujukan.peserta.provUmum.nmProvider)
    //       $('input[name="diagnosa_awal"]').val(data.response.rujukan.diagnosa.kode)
    //       $('input[name="hak_kelas_inap"]').val(data.response.rujukan.peserta.hakKelas.kode)
    //       $('select[name="poli_bpjs"]').val(data.response.rujukan.poliRujukan.kode).trigger('change')
    //       $('select[name="asalRujukan"]').val('2').trigger('change')
    //     }
    //   });
    // }

    // function savePosRawatInap() {
    //   $('.progress').removeClass('hidden')
    //   $('.tableStatus').addClass('hidden')
    //   $.ajax({
    //     url: '/cari-sep/noka-igd',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: $('#formPencarian').serialize(),
    //     beforeSend: function () {
    //       $('.progress').removeClass('hidden')
    //     },
    //     complete: function () {
    //       $('.progress').addClass('hidden')
    //     }
    //   })
    //   .done(function(data) {
    //     $('.progress').addClass('hidden')
    //     $('.tableStatus').removeClass('hidden')
    //     $('.lanjut').removeClass('hidden')
    //     $('.nama').text(data.response.peserta.nama)
    //     $('.tglLahir').text(data.response.peserta.tglLahir)
    //     $('.nik').text(data.response.peserta.nik)
    //     $('.noTelepon').text(data.response.peserta.mr.noTelepon)
    //     $('.noka').text(data.response.peserta.noKartu)
    //     $('.status').text(data.response.peserta.statusPeserta.keterangan)
    //     $('.rujukan').removeClass('hidden');
    //     $('.dinsos').text(data.response.peserta.informasi.dinsos)
    //     $('.noSKTM').text(data.response.peserta.informasi.noSKTM)
    //     $('.prolanisPRB').text(data.response.peserta.informasi.prolanisPRB)
    //     $('input[name="nama"]').val(data.response.peserta.nama)
    //     $('input[name="no_bpjs"]').val(data.response.peserta.noKartu)
    //     $('select[name="asalRujukan"]').val('2').trigger('change')
    //     $('input[name="ppk_rujukan"]').val('{{ config('app.sep_ppkLayanan') }}')
    //     $('input[name="hak_kelas_inap"]').val(data.response.peserta.hakKelas.kode)

    //   });

    // }

    // function savePosHD() {
    //   $('.tableStatus').addClass('hidden')
    //   $.ajax({
    //     url: '/bridgingsep/pos-hd',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: $('#formPencarian').serialize(),
    //     beforeSend: function () {
    //       $('.progress').removeClass('hidden')
    //     },
    //     complete: function () {
    //       $('.progress').addClass('hidden')
    //     }
    //   })
    //   .done(function(data) {
    //     if (data.metaData.code == 201) {
    //       $('.statusError').text(data.metaData.message)
    //     }
    //     if (data.metaData.code == 200) {

    //     }
    //   });

    // }

// ======================================================================================================================

    //Laka lantas
    // $('select[name="laka_lantas"]').change(function(e) {
    //   if($(this).val() == 1){
    //     $('.laka').removeClass('hidden')
    //   } else {
    //     $('.laka').addClass('hidden')
    //   }
    // });

    $('.select2').select2()


    $(document).ready(function() {
      //SET LAKA LANTAS
      // if ($('select[name="laka_lantas"]').val() == 1) {
      //   $('.laka').removeClass('hidden')
      // } else {
      //   $('.laka').addClass('hidden')
      // }

      //ICD 10
      $("input[name='diagnosa_awal']").on('focus', function () {
        $("#dataICD10").DataTable().destroy()
        $("#ICD10").modal('show');
        $('#dataICD10').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },

            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/sep/geticd10',
            columns: [
                // {data: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'nomor'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
      });

      $(document).on('click', '.addICD', function (e) {
        document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
        $('#ICD10').modal('hide');
      });


      // $('#createSEP').on('click', function () {
      //   $("input[name='no_sep']").val( ' ' );
      //   $.ajax({
      //     url : '{{ url('/buat-sep') }}',
      //     type: 'POST',
      //     data: $("#formSEP").serialize(),
      //     processing: true,
      //     beforeSend: function () {
      //       $('.overlay').removeClass('hidden')
      //     },
      //     complete: function () {
      //       $('.overlay').addClass('hidden')
      //     },
      //     success:function(data){
      //       if(data.error){
      //         if(data.error.tglKejadian){
      //           alert(data.error.tglKejadian);
      //           return false;
      //         }
      //         if(data.error.kll){
      //           alert(data.error.kll);
      //           return false;
      //         }
      //         if(data.error.suplesi){
      //           alert(data.error.suplesi);
      //           return false;
      //         }
      //         if(data.error.noSepSuplesi){
      //           alert(data.error.noSepSuplesi);
      //           return false;
      //         }
      //         if(data.error.kdPropinsi){
      //           alert(data.error.kdPropinsi);
      //           return false;
      //         }
      //         if(data.error.kdKabupaten){
      //           alert(data.error.kdKabupaten);
      //           return false;
      //         }
      //         if(data.error.kdKecamatan){
      //           alert(data.error.kdKecamatan);
      //           return false;
      //         }
      //       }else if(data.sukses){
      //         $('#fieldSEP').removeClass('has-error');
      //         $("input[name='no_sep']").val( data.sukses );
      //       } else if (data.msg) {
      //         // $('#fieldSEP').addClass('has-error');
      //         // $("input[name='no_sep']").val( data.msg );
      //         $('.overlay').addClass('hidden')
      //         alert(data.msg)
      //       }
      //     }
      //   });
      // });

    });


  </script>
@endsection
