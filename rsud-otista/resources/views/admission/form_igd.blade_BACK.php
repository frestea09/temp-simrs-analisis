@extends('master')
@section('header')
  <h1>Form SEP Susulan - Rawat Darurat<small></small></h1>
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
            <label for="judul" class="col-sm-3 control-label text-right">Cari Pasien berdasarkan</label>
            <div class="col-sm-9 btn-group">
              <button type="button" onclick="nomorKartu()" class="btn btn-primary btn-flat">NOMOR KARTU </button>
              <button type="button" onclick="nomorNik()" class="btn btn-danger btn-flat">NOMOR NIK</button>
            </div>
          </div>
        </div>
      </div>

      {{--  --}}
    <hr>
      {!! Form::open(['method' => 'POST', 'url' => 'admission/save-sep/irj-igd', 'class' => 'form-horizontal', 'id'=>'formSEP']) !!}
          <input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
        
          <div class="row">
            <div class="col-md-6">
               <div class="form-group{{ $errors->has('namapasien') ? ' has-error' : '' }}">
                  {!! Form::label('namapasien', 'Nama Pasien', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="namapasien" value="{{ !empty($nama) ? $nama : $reg->pasien->nama }}" readonly="true" class="form-control">
                      <small class="text-danger">Nama Sesuai Data Rekam Medis</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                  {!! Form::label('nama', 'Nama (sesuai Kartu)', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="nama" value="" readonly="true" class="form-control">
                      <small class="text-success">Nama Sesuai Nomor Kartu BPJS</small>
                      <small class="text-danger">{{ $errors->first('nama') }}</small>
                  </div>
              </div>
              
              <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                  {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      <input type="text" name="no_rm" value="{{ !empty($no_rm) ? $no_rm : $reg->pasien->no_rm }}" readonly="true" class="form-control">
                      <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('no_bpjs', 'No. Kartu', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_bpjs', NULL, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_bpjs') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
                  {!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_tlp', !empty($reg->pasien->nohp) ? $reg->pasien->nohp : '', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('no_tlp') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('tgl_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_rujukan', 'Tgl Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('tgl_rujukan', null, ['class' => 'form-control tanggalSEP']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('no_rujukan', null, ['class' => 'form-control', 'readonly' => true]) !!}
                      <small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('ppk_rujukan') ? ' has-error' : '' }}">
                  {!! Form::label('ppk_rujukan', 'PPK Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('ppk_rujukan', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('ppk_rujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('catatan_bpjs') ? ' has-error' : '' }}">
                  {!! Form::label('catatan_bpjs', 'Catatan BPJS', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('catatan_bpjs', !empty($no_rm) ? $no_rm :session('no_rm'), ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('catatan_bpjs') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
                  {!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('diagnosa_awal', null, ['class' => 'form-control', 'id'=>'diagnosa_awal']) !!}
                      <small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('jenis_layanan') ? ' has-error' : '' }}">
                  {!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('jenis_layanan', ['2'=>'Rawat Jalan', '1'=>'Rawat Inap'], NULL, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('jenis_layanan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('asalRujukan') ? ' has-error' : '' }}">
                  {!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('asalRujukan', ['1'=>'PPK 1', '2'=>'RS'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('asalRujukan') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('hak_kelas_inap') ? ' has-error' : '' }}">
                  {!! Form::label('hak_kelas_inap', 'Hak Kelas Inap', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::text('hak_kelas_inap', !empty($hak_kelas) ? $hak_kelas : null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('hak_kelas_inap') }}</small>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('cob') ? ' has-error' : '' }}">
                  {!! Form::label('cob', 'COB', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('cob', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('cob') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('katarak') ? ' has-error' : '' }}">
                  {!! Form::label('katarak', 'Katarak', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('katarak', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('katarak') }}</small>
                  </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Tgl SEP</label>
                <div class="col-sm-8">
                  <input type="text" name="tglSep" class="form-control tanggalSEP" value="{{ date('Y-m-d') }}">
                </div>
              </div>

            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tipejkn" class="col-sm-4 control-label">Tipe JKN</label>
                <div class="col-sm-8">
                  <input type="text" name="tipe_jkn" value="{{ !empty($reg->tipe_jkn) ? $reg->tipe_jkn : NULL }}" readonly="true" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Klinik Tujuan</label>
                <div class="col-sm-8">
                  <select name="poli_bpjs" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $d)
                      @if ($d->bpjs == $poli_bpjs)
                         <option value="{{ $d->bpjs }}" selected="true">{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->bpjs }}">{{ $d->nama }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">No. SKDP</label>
                <div class="col-sm-8">
                  <input type="text" name="noSurat" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="poliTujuan" class="col-sm-4 control-label">Dokter DPJP </label>
                <div class="col-sm-8">
                  <select name="kodeDPJP" class="form-control select2" style="width: 100%">
                    @foreach ($dokter as $d)
                      @if ($d->kode_bpjs == $dokter_bpjs)
                        <option value="{{ $d->kode_bpjs }}" selected="true">{{ $d->nama }}</option>
                      @else
                        <option value="{{ $d->kode_bpjs }}">{{ $d->nama }}</option>
                      @endif
                      <option value="{{ $d->kode_bpjs }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group{{ $errors->has('laka_lantas') ? ' has-error' : '' }}">
                  {!! Form::label('laka_lantas', 'Laka Lantas', ['class' => 'col-sm-4 control-label']) !!}
                  <div class="col-sm-8">
                      {!! Form::select('laka_lantas', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('laka_lantas') }}</small>
                  </div>
              </div>
              <div class="laka hidden">
                  <div class="form-group{{ $errors->has('penjamin') ? ' has-error' : '' }}">
                      {!! Form::label('penjamin', 'Penjamin', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('penjamin', ['1'=>'Jasa Raharja', '2'=>'BPJS Ketenagakerjaan', '3'=>'TASPEN', '4'=>'ASABRI'], null, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                          <small class="text-danger">{{ $errors->first('penjamin') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('tglKejadian') ? ' has-error' : '' }}">
                      {!! Form::label('tglKejadian', 'Tanggal Kejadian Laka', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('tglKejadian', null, ['class' => 'form-control datepicker', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('tglKejadian') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kll') ? ' has-error' : '' }}">
                      {!! Form::label('kll', 'Ket Laka', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('kll', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('kll') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('suplesi') ? ' has-error' : '' }}">
                      {!! Form::label('suplesi', 'Suplesi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('suplesi', ['0'=>'Tidak', '1'=>'Ya'], 0, ['class' => 'form-control select2', 'style'=>'width:100%;']) !!}
                          <small class="text-danger">{{ $errors->first('suplesi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('noSepSuplesi') ? ' has-error' : '' }}">
                      {!! Form::label('noSepSuplesi', 'No. SEP Suplesi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::text('noSepSuplesi', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                          <small class="text-danger">{{ $errors->first('noSepSuplesi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kdPropinsi') ? ' has-error' : '' }}">
                      {!! Form::label('kdPropinsi', 'Propinsi', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdPropinsi" id="regency_id" style="width:100%">
                            <option value=""></option>
                            @foreach ($bpjsprov as $i)
                            <option value="{{ $i->kode }}"> {{ $i->propinsi }}</option>
                                
                            @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('kdPropinsi') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kdKabupaten') ? ' has-error' : '' }}">
                      {!! Form::label('kdKabupaten', 'Kabupaten', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdKabupaten" id="regency_id" style="width:100%">
                            <option value=""></option>
                        </select>
                          <small class="text-danger">{{ $errors->first('kdKabupaten') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('kdKecamatan') ? ' has-error' : '' }}">
                      {!! Form::label('kdKecamatan', 'Kecamatan', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                        <select class="form-control select2" name="kdKecamatan" id="regency_id" style="width:100%">
                            <option value=""></option>
                        </select>
                          <small class="text-danger">{{ $errors->first('kdKecamatan') }}</small>
                      </div>
                  </div>
              </div>

              <div class="form-group{{ $errors->has('no_sep') ? ' has-error' : '' }}">
                  <div class="col-sm-4 control-label">
                    <button type="button" id="createSEP" class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT SEP</button>
                  </div>
                  <div class="col-sm-8" id="fieldSEP">
                      {!! Form::text('no_sep', null, ['class' => 'form-control', 'id'=>'noSEP']) !!}
                      <small class="text-danger">{{ $errors->first('no_sep') }}</small>
                  </div>
              </div>
              <div class="btn-group pull-right">
                  <a href="{{ URL::previous() }}" class="btn btn-warning btn-flat">Batal</a>
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

  {{-- MODAL PENGECEKAN NOMOR KARTU --}}
  <div class="modal fade" id="modalPencarian">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" class="form-horizontal" id="formPencarian">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group">
              <label for="judul" class="col-sm-3 control-label judul"></label>
              <div class="col-sm-9 formInput">

              </div>
            </div>
          </form>
            {{-- progress bar --}}
          <div class="progress progress-sm active hidden">
            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
              <span class="sr-only">97% Complete</span>
            </div>
          </div>
          <table class="table table-bordered table-condensed tableStatus hidden">
            <tbody>
              <tr>
                <th>Nama Pasien</th><td class="nama"></td>
              </tr>
              <tr>
                <th>Tgl Lahir</th><td class="tglLahir"></td>
              </tr>
              <tr>
                <th>NIK</th><td class="nik"></td>
              </tr>
              <tr>
                <th>No. Kartu</th><td class="noka"></td>
              </tr>
              <tr>
                <th>No. Telepon</th><td class="noTelepon"></td>
              </tr>
              <tr>
                <th>Status</th><td class="status"></td>
              </tr>
              <tr class="rujukan hidden">
                <th>PPK Perujuk</th><td class="ppkPerujuk"></td>
              </tr>
              <tr>
                <th>Dinsos</th><td class="dinsos"></td>
              </tr>
              <tr>
                <th>No. SKTM</th><td class="noSKTM"></td>
              </tr>
              <tr>
                <th>Prolanis</th><td class="prolanisPRB"></td>
              </tr>
            </tbody>
          </table>
          <p class="text-center text-danger statusError" style="font-weight: bold"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">TUTUP</button>
          <button type="button" class="btn btn-primary btn-flat save">CARI</button>
          <button type="button" class="btn btn-success btn-flat lanjut hidden" data-dismiss="modal">LANJUT</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
  <script type="text/javascript">
    $('select[name="ppk_rujukan"]').on('change', function () {
        var kode = $(this).val();
        if (kode) {
            $.ajax({
                url: '/faskeslanjutan/' + kode,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="nama_perujuk"]').empty();
                    $.each(data, function (key, value) {
                        $('input[name="nama_perujuk"]').val(''+value+'');
                    });
                }
            });
        } else {
            $('select[name="ppk_rujukan"]').hide();
        }
    });
    $('.datepicker').datepicker({ endDate: new Date(), autoclose: true,format: "yyyy-mm-dd" });

    $( function() {
      $( ".tanggalSEP" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });

      // //POLI BPJS
      // $('select[name="poli_bpjs"]').change(function(e) {
      //   e.preventDefault();
      //   $.ajax({
      //     url: '/bridgingsep/dokter-bpjs/'+$(this).val(),
      //     type: 'GET',
      //     dataType: 'json',
      //     success: function(data, textStatus, xhr) {
      //       $('select[name="kodeDPJP"]').empty()
      //       $.each(data.response.list, function(index, val) {
      //          $('select[name="kodeDPJP"]').append('<option value='+val.kode+'>'+val.nama+'</option>')
      //       });
      //     },
      //   });


      // });
    });




    function nomorKartu() {
      $('#modalPencarian').modal('show')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Pencarian Peserta Berdasar Nomor Kartu')
      $('.judul').text('Nomor Kartu')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="no_kartu" class="form-control">')
      $('.save').attr('onclick', 'cariNoKartu()');
    }

    function nomorNik() {
      $('#modalPencarian').modal('show')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Pencarian Peserta Berdasar Nomor NIK')
      $('.judul').text('Nomor NIK')
      $('.formInput').empty()
      $('.formInput').append('<input type="text" name="nik" class="form-control">')
      $('.save').attr('onclick', 'cariNIK()');
    }
    function compressData(string){
      data = LZString.compressToEncodedURIComponent(string)
      return data
    }
    function cariNoKartu() {
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden');
      $('.progress').removeClass('hidden')
      $('.statusError').text('')
      $.ajax({
        url: '/cari-sep/noka-igd',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data:{
          no_kartu : compressData($('input[name="no_kartu"]').val()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
        },
        beforeSend: function () {
          // body...
        }
      })
      .done(function(res) {
        var decompressData = LZString.decompressFromBase64(res); 
        data = JSON.parse(decompressData); 

        $('.progress').addClass('hidden')
        if (data.metaData.code == 201) {
          $('.statusError').text(data.metaData.message)
        }
        if (data.metaData.code == 200) {
          $('.tableStatus').removeClass('hidden')
          $('.nama').text(data.response.peserta.nama)
          $('.tglLahir').text(data.response.peserta.tglLahir)
          $('.nik').text(data.response.peserta.nik)
          $('.noTelepon').text(data.response.peserta.mr.noTelepon)
          $('.noka').text(data.response.peserta.noKartu)
          $('.status').text(data.response.peserta.statusPeserta.keterangan)
          $('.dinsos').text(data.response.peserta.informasi.dinsos)
          $('.noSKTM').text(data.response.peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data.response.peserta.informasi.prolanisPRB)
          //FORM
          $('input[name="nama"]').val(data.response.peserta.nama)
          $('input[name="no_bpjs"]').val(data.response.peserta.noKartu)
          $('input[name="no_tlp"]').val(data.response.peserta.mr.noTelepon)
          $('input[name="ppk_rujukan"]').val(data.response.peserta.provUmum.kdProvider)
          $('input[name="hak_kelas_inap"]').val(data.response.peserta.hakKelas.kode)
          $('input[name="no_rujukan"]').val(data.response.noKunjungan)
          $('input[name="tgl_rujukan"]').val(data.response.tglKunjungan)
          $('.lanjut').removeClass('hidden')
        }
      });
    }


    function cariNIK() {

      $.ajax({
        url: '/cari-nik',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data:{
          nik : compressData($('input[name="nik"]').val()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
        },
      })
      .done(function(res) {
        var decompressData = LZString.decompressFromBase64(res); 
        data = JSON.parse(decompressData); 

        $('.progress').addClass('hidden')
        if (data.metaData.code == 201) {
          $('.statusError').text(data.metaData.message)
        }
        if (data.metaData.code == 200) {
          $('.tableStatus').removeClass('hidden')
          $('.statusError').text('')
          $('.nama').text(data.response.peserta.nama)
          $('.tglLahir').text(data.response.peserta.tglLahir)
          $('.nik').text(data.response.peserta.nik)
          $('.noTelepon').text(data.response.peserta.mr.noTelepon)
          $('.noka').text(data.response.peserta.noKartu)
          $('.status').text(data.response.peserta.statusPeserta.keterangan)
          $('.dinsos').text(data.response.peserta.informasi.dinsos)
          $('.noSKTM').text(data.response.peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data.response.peserta.informasi.prolanisPRB)
          //FORM
          $('input[name="nama"]').val(data.response.peserta.nama)
          $('input[name="no_bpjs"]').val(data.response.peserta.noKartu)
          $('input[name="no_tlp"]').val(data.response.peserta.mr.noTelepon)
          $('input[name="hak_kelas_inap"]').val(data.response.peserta.hakKelas.kode)
          $('input[name="ppk_rujukan"]').val(data.response.peserta.provUmum.kdProvider)
          $('.lanjut').removeClass('hidden')
        }

      });

    }

    //Laka lantas
    $('select[name="laka_lantas"]').change(function(e) {
      if($(this).val() == 1){
        $('.laka').removeClass('hidden')
      } else {
        $('.laka').addClass('hidden')
      }
    });

    $('.select2').select2()

    //CARI RUJUKAN PPK2
    function cariNoRujukanPPK2() {
      $.ajax({
        url: '/bridgingsep/insert-rujukan-rs',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data:{
          no_kartu : compressData($('input[name="no_kartu"]').val()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
        },
      })
      .done(function(res) {
        var decompressData = LZString.decompressFromBase64(res); 
        data = JSON.parse(decompressData)
        
        $('.progress').addClass('hidden')
        if (data.metaData.code == 201) {
          $('.statusError').text(data.metaData.message)
        }
        if (data.metaData.code == 200) {
          $('.tableStatus').removeClass('hidden')
          $('.nama').text(data.response.rujukan.peserta.nama)
          $('.noka').text(data.response.rujukan.peserta.noKartu)
          $('.status').text(data.response.rujukan.peserta.statusPeserta.keterangan)
          $('.rujukan').removeClass('hidden');
          $('.ppkPerujuk').text(data.response.rujukan.provPerujuk.nama)
          $('.dinsos').text(data.response.rujukan.peserta.informasi.dinsos)
          $('.noSKTM').text(data.response.rujukan.peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data.response.rujukan.peserta.informasi.prolanisPRB)
          //FORM
          $('input[name="nama"]').val(data.response.rujukan.peserta.nama)
          $('input[name="no_bpjs"]').val(data.response.rujukan.peserta.noKartu)
          $('input[name="no_tlp"]').val(data.response.rujukan.peserta.mr.noTelepon)
          $('input[name="no_rujukan"]').val(data.response.rujukan.noKunjungan)
          $('input[name="tgl_rujukan"]').val(data.response.rujukan.tglKunjungan)
          $('input[name="ppk_rujukan"]').val(data.response.rujukan.peserta.provUmum.kdProvider)
          $('input[name="diagnosa_awal"]').val(data.response.rujukan.diagnosa.kode)
          $('input[name="hak_kelas_inap"]').val(data.response.rujukan.peserta.hakKelas.kode)
          $('select[name="poli_bpjs"]').val(data.response.rujukan.poliRujukan.kode).trigger('change')
        }
      });

    }

    $(document).ready(function() {
      //SET LAKA LANTAS
      if ($('select[name="laka_lantas"]').val() == 1) {
        $('.laka').removeClass('hidden')
      } else {
        $('.laka').addClass('hidden')
      }

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


      $('#createSEP').on('click', function () {
        $("input[name='no_sep']").val( ' ' );
        $.ajax({
          url : '{{ url('/buat-sep') }}',
          type: 'POST',
          // data: $("#formSEP").serialize(),
          data:{
            data : LZString.compressToBase64($('#formSEP').serialize()),
            _token : $('input[name="_token"]').val(),
            _method : 'POST'
          },
          processing: true,
          beforeSend: function () {
            $('.overlay').removeClass('hidden')
          },
          complete: function () {
            $('.overlay').addClass('hidden')
          },
          success:function(data){
            if(data.error){
              if(data.error.tglKejadian){
                alert(data.error.tglKejadian);
                return false;
              }
              if(data.error.kll){
                alert(data.error.kll);
                return false;
              }
              if(data.error.suplesi){
                alert(data.error.suplesi);
                return false;
              }
              if(data.error.noSepSuplesi){
                alert(data.error.noSepSuplesi);
                return false;
              }
              if(data.error.kdPropinsi){
                alert(data.error.kdPropinsi);
                return false;
              }
              if(data.error.kdKabupaten){
                alert(data.error.kdKabupaten);
                return false;
              }
              if(data.error.kdKecamatan){
                alert(data.error.kdKecamatan);
                return false;
              }
            }else if(data.sukses){
              $('#fieldSEP').removeClass('has-error');
              $("input[name='no_sep']").val( data.sukses );
            } else if (data.msg) {
              // $('#fieldSEP').addClass('has-error');
              // $("input[name='no_sep']").val( data.msg );
              $('.overlay').addClass('hidden')
              alert(data.msg)
            }
          }
        });
      });

    });


  </script>
@endsection
