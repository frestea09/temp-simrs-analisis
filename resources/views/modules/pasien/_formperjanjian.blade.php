<div class="row">
  {{-- kolom kiri --}}

  <div class="col-md-6">
    <div class="hidden" id="blmTerdata">
      <div class="form-group has-success">
        {!! Form::label('no_rm', 'Nomor RM', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('no_rm', null, ['class' => 'form-control','disabled'=>true]) !!}
          <small class="text-danger">{{ $errors->first('no_rm') }}</small>
        </div>
      </div>
    </div>

    <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
      {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()'])
        !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }}">
      {!! Form::label('nik', 'NIK', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <div class="input-group">
          {!! Form::input('number','nik', null, ['class' => 'form-control','required'=>true,'min'=>"6"]) !!}
          <span class="input-group-btn">
            <button onclick="nomorNIK()" type="button" class="btn btn-danger btn-flat">
              <i class="fa fa-search"></i>
            </button>
          </span>
          <small class="text-danger">{{ $errors->first('nik') }}</small>

        </div>
      </div>
    </div>
    <div class="form-group{{ $errors->has('tmplahir') ? ' has-error' : '' }}">
      {!! Form::label('tmplahir', 'Tmp, tgl lahir,Umur', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <div class="row">
          <div class="col-md-5">
            {!! Form::text('tmplahir', null, ['class' => 'form-control', 'onkeyup'=>'this.value =
            this.value.toUpperCase()']) !!}
            <small class="text-danger">{{ $errors->first('tmplahir') }}</small>
          </div>
          <div class="col-md-5">
            {!! Form::text('tgllahir', (!empty($pasien->tgllahir)) ? tgl_indo($pasien->tgllahir) : null, ['class' =>
            'form-control', 'id'=>'tgllahir']) !!}
            <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
          </div>
          <div class="col-md-2" style='padding-left:0px !important'>
            {!! Form::text('umr', null, ['class' => 'form-control', 'readonly'=>true,'style'=>'padding:2px !important'])
            !!}
            <small class="text-danger">{{ $errors->first('tmplahir') }}</small>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
      {!! Form::label('alamat', 'Dsn, RT, RW', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-5">
        {!! Form::text('alamat', null, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()'])
        !!}
        <small class="text-danger">{{ $errors->first('alamat') }}</small>
      </div>
      <div class="col-sm-2">
        {!! Form::text('rt', null, ['class' => 'form-control', 'placeholder'=>'RT']) !!}
        <small class="text-danger">{{ $errors->first('rt') }}</small>
      </div>
      <div class="col-sm-2">
        {!! Form::text('rw', null, ['class' => 'form-control', 'placeholder'=>'RW']) !!}
        <small class="text-danger">{{ $errors->first('rw') }}</small>
      </div>
    </div>

    <div class="form-group{{ $errors->has('province_id') ? ' has-error' : '' }}">
      {!! Form::label('province_id', 'Propinsi', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::select('province_id', $provinsi, null,['class' => 'form-control select2', 'style'=>'width:100%',
        'placeholder'=>' ']) !!}
        <small class="text-danger">{{ $errors->first('province_id') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('regency_id') ? ' has-error' : '' }}">
      {!! Form::label('regency_id', 'Kabupaten', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <select class="form-control select2" name="regency_id" id="regency_id">
          @if (!empty ($pasien->regency_id))
          <option value="{{ $pasien->regency_id }}">{{ baca_kabupaten($pasien->regency_id) }}</option>
          @endif
        </select>
        <small class="text-danger">{{ $errors->first('regency_id') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('district_id') ? ' has-error' : '' }}">
      {!! Form::label('district_id', 'Kecamatan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <select class="form-control select2" name="district_id" id="district_id">
          @if (!empty ($pasien->district_id))
          <option value="{{ $pasien->district_id }}">{{ baca_kecamatan($pasien->district_id) }}</option>
          @endif
        </select>
        <small class="text-danger">{{ $errors->first('district_id') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('village_id') ? ' has-error' : '' }}">
      {!! Form::label('village_id', 'Kelurahan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <select class="form-control select2" name="village_id" id="village_id">
          @if (!empty ($pasien->village_id))
          <option value="{{ $pasien->village_id }}">{{ baca_kelurahan($pasien->village_id) }}</option>
          @endif
        </select>
        <small class="text-danger">{{ $errors->first('village_id') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
      {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
      </div>
    </div>

  </div>
  {{-- kolom kanan =================================================================== --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
      {!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::select('kelamin', ['L'=>'Laki-laki', 'P'=>'Perempuan'], null, ['class' => 'form-control select2',
        'style'=>'width:100%']) !!}
        <small class="text-danger">{{ $errors->first('kelamin') }}</small>
      </div>
    </div>

    <div class="form-group{{ $errors->has('nohp') ? ' has-error' : '' }}">
      {!! Form::label('nohp', 'No. HP / Tlp', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::text('nohp', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nohp') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('pekerjaan_id') ? ' has-error' : '' }}">
      {!! Form::label('pekerjaan_id', 'Pekerjaan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::select('pekerjaan_id', $pekerjaan, null, ['class' => 'form-control select2', 'style'=>'width:100%'])
        !!}
        <small class="text-danger">{{ $errors->first('pekerjaan_id') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('agama_id') ? ' has-error' : '' }}">
      {!! Form::label('agama_id', 'Agama', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::select('agama_id', $agama, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
        <small class="text-danger">{{ $errors->first('agama_id') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('pendidikan_id') ? ' has-error' : '' }}">
      {!! Form::label('pendidikan_id', 'Pendidikan', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::select('pendidikan_id', $pendidikan, null, ['class' => 'form-control select2', 'style'=>'width:100%'])
        !!}
        <small class="text-danger">{{ $errors->first('pendidikan_id') }}</small>
      </div>
    </div>

    <div class="form-group{{ $errors->has('ibu_kandung') ? ' has-error' : '' }}">
      {!! Form::label('ibu_kandung', 'Ibu Kandung', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        {!! Form::text('ibu_kandung', null, ['class' => 'form-control', 'onkeyup'=>'this.value =
        this.value.toUpperCase()']) !!}
        <small class="text-danger">{{ $errors->first('ibu_kandung') }}</small>
      </div>
    </div>

    <div class="form-group{{ $errors->has('status_marital') ? ' has-error' : '' }}">
      {!! Form::label('status_marital', 'Status Marital', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        @if (!empty($pasien->status_marital))
        <select class="form-control select2" style="width:100%" name="status_marital">
          @if ($pasien->status_marital == 'Blm Menikah')
          <option value="Blm Menikah" selected="true">Blm Menikah</option>
          <option value="Menikah">Menikah</option>
          <option value="Janda">Janda</option>
          <option value="Duda">Duda</option>
          @elseif ($pasien->status_marital == 'Menikah')
          <option value="Blm Menikah">Blm Menikah</option>
          <option value="Menikah" selected="true">Menikah</option>
          <option value="Janda">Janda</option>
          <option value="Duda">Duda</option>
          @elseif ($pasien->status_marital == 'Janda')
          <option value="Blm Menikah">Blm Menikah</option>
          <option value="Menikah">Menikah</option>
          <option value="Janda" selected="true">Janda</option>
          <option value="Duda">Duda</option>
          @elseif ($pasien->status_marital == 'Duda')
          <option value="Blm Menikah">Blm Menikah</option>
          <option value="Menikah">Menikah</option>
          <option value="Janda">Janda</option>
          <option value="Duda" selected="true">Duda</option>
          @else
          <option value="Blm Menikah">Blm Menikah</option>
          <option value="Menikah">Menikah</option>
          <option value="Janda">Janda</option>
          <option value="Duda">Duda</option>
          @endif
        </select>
        @else
        <select class="form-control select2" style="width:100%" name="status_marital">
          <option value="Blm Meninkah">Blm Menikah</option>
          <option value="Menikah">Menikah</option>
          <option value="Janda">Janda</option>
          <option value="Duda">Duda</option>
        </select>
        @endif

        <small class="text-danger">{{ $errors->first('status_marital') }}</small>
      </div>
    </div>
    <div class="form-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
      {!! Form::label('no_jkn', 'Nomor JKN', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-9">
        <div class="input-group">
          {!! Form::text('no_jkn', null, ['class' => 'form-control', 'onkeyup'=>'this.value =
          this.value.toUpperCase()']) !!}
          <span class="input-group-btn">
            <button onclick="nomorKartu()" type="button" class="btn btn-success btn-flat">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
        <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
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
        {{-- <form method="POST" id="formPencarian"> --}}
          {{ csrf_field() }}
          <div class="form-group">
            <label for="judul" class="col-sm-3 control-label judul"></label>
            <div class="col-sm-9 formInput">

            </div>
          </div>
          {{--
        </form> --}}
        {{-- progress bar --}}
        <div class="progress progress-sm active hidden">
          <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100"
            aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">97% Complete</span>
          </div>
        </div>
        <table class="table table-bordered table-condensed tableStatus hidden">
          <tbody>
            <tr>
              <th>Nama Pasien</th>
              <td class="nama"></td>
            </tr>
            <tr>
              <th>Tgl Lahir</th>
              <td class="tglLahir"></td>
            </tr>
            <tr>
              <th>NIK</th>
              <td class="nik"></td>
            </tr>
            <tr>
              <th>No. Kartu</th>
              <td class="noka"></td>
            </tr>
            <tr>
              <th>No. Telepon</th>
              <td class="noTelepon"></td>
            </tr>
            <tr>
              <th>Status</th>
              <td class="status" style="font-weight:900;"></td>
            </tr>
            <tr>
              <th>Peserta</th>
              <td class="jenisPeserta"></td>
            </tr>
            <tr class="rujukan hidden">
              <th>PPK Perujuk</th>
              <td class="ppkPerujuk"></td>
            </tr>
            <tr>
              <th>Dinsos</th>
              <td class="dinsos"></td>
            </tr>
            <tr>
              <th>No. SKTM</th>
              <td class="noSKTM"></td>
            </tr>
            <tr>
              <th>Prolanis</th>
              <td class="prolanisPRB"></td>
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

{{-- <div class="btn-group pull-right">
  <a href="{{ route('pasien') }}" class="btn btn-warning btn-flat">Batal</a>
  {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div> --}}
@section('script')
<script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
<script type="text/javascript">
  $('.select2').select2();
    function compressData(string){
      data = LZString.compressToEncodedURIComponent(string)
      return data
    }
    now = $.datepicker.formatDate('yy', new Date())
    
    if($('input[name="tgllahir"]').val() !== ''){
      umur = now - $('input[name="tgllahir"]').val().substr(6, 4)
      $('input[name="umr"]').val(umur)
    }

    $('input[name="tgllahir"]').on('change', function() {
      if($('input[name="tgllahir"]').val() !== ''){
        umur = now - this.value.substr(6, 4)
        $('input[name="umr"]').val(umur)
      }else{
        $('input[name="umr"]').val('')
      }
      
    });

    function viewFormRM(){
      $('#blmTerdata').removeClass('hidden');
      $('input[name="no_rm"]').removeAttr('disabled')
    }

    @if ($pasien)
      $('#blmTerdata').removeClass('hidden');
      $('input[name="nama"]').attr('readonly', true);
    @endif

    function nomorKartu() {

      if($('input[name="no_jkn"]').val() == '' ){
        return swal("Gagal", 'NO. JKN Wajib diisi untuk cek PREMI', "error");
      }
      $('#modalPencarian').modal('show')
      $('.modal-dialog').removeClass('modal-lg')
      $('.tableMultipleRujukan').addClass('hidden')
      $('.tableStatus').addClass('hidden')
      $('.rujukan').addClass('hidden')
      $('.lanjut').addClass('hidden')
      $('.statusError').text('')
      $('.modal-title').text('Cek Premi Peserta berdasarkan Nomor Kartu')
      // $('.judul').text('Nomor NIK')
      $('.formInput').empty()
      // $('.formInput').append('<input type="text" name="no_nik" class="form-control" value="'+niks+'">')
      $('.tableStatus').addClass('hidden')
      // alert($('input[name="no_jkn"]').val());
      // return
      $.ajax({
        url: '/cari-sep/noka-igd',
        type: 'POST',
        dataType: 'json',
        // data: $('#formPencarian').serialize(),
        data:{
          no_kartu : compressData($('input[name="no_jkn"]').val()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
        },
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        
        data = JSON.parse(res); 
        console.log(data)
        if (data[0].metaData.code == 201) {
          $('.statusError').text(data[0].metaData.message)
        }
        if (data[0].metaData.code == 200) {
          $('.statusError').text('')
          $('.tableStatus').removeClass('hidden')
          $('.lanjut').removeClass('hidden')
          $('.statusError').text('')
          $('.nama').text(data[1].peserta.nama)
          $('.nik').text(data[1].peserta.nik)
          $('.tglLahir').text(data[1].peserta.tglLahir)
          $('.noTelepon').text(data[1].peserta.mr.noTelepon)
          $('.noka').text(data[1].peserta.noKartu)
          $('.status').text(data[1].peserta.statusPeserta.keterangan)
          $('.jenisPeserta').text(data[1].peserta.jenisPeserta.keterangan)
          $('.rujukan').removeClass('hidden');
          $('.ppkPerujuk').text(data[1].peserta.provUmum.kode)
          //FORM
          $('input[name="nama"]').val(data[1].peserta.nama)
          $('input[name="no_jkn"]').val(data[1].peserta.noKartu)
          $('input[name="nik"]').val(data[1].peserta.nik)
          $('input[name="nohp"]').val(data[1].peserta.mr.noTelepon)
          $('input[name="umr"]').val(data[1].peserta.umur.umurSekarang)
          $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
          $('input[name="ppk_rujukan"]').val(data[1].peserta.provUmum.kdProvider)
          $('select[name="kelamin"]').val(data[1].peserta.sex).trigger('change')
          $('select[name="jkn"]').val(data[1].peserta.jenisPeserta.keterangan).trigger('change')
          $('input[name="tgllahir"]').val($.datepicker.formatDate('dd-mm-yy', new Date(data[1].peserta.tglLahir)))
          
        }

      });
      $('.save').attr('onclick', 'cariNIK()');
      }

      function nomorNIK() {

        if($('input[name="nik"]').val() == '' ){
          return swal("Gagal", 'NIK Wajib diisi untuk cek PREMI', "error");
        }
        $('#modalPencarian').modal('show')
        $('.modal-dialog').removeClass('modal-lg')
        $('.tableMultipleRujukan').addClass('hidden')
        $('.tableStatus').addClass('hidden')
        $('.rujukan').addClass('hidden')
        $('.lanjut').addClass('hidden')
        $('.statusError').text('')
        $('.modal-title').text('Cek Premi Peserta berdasarkan Nomor Kartu')
        // $('.judul').text('Nomor NIK')
        $('.formInput').empty()
        // $('.formInput').append('<input type="text" name="no_nik" class="form-control" value="'+niks+'">')
        $('.tableStatus').addClass('hidden')
        // alert($('input[name="no_jkn"]').val());
        // return
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
          beforeSend: function () {
            $('.progress').removeClass('hidden')
          },
          complete: function () {
            $('.progress').addClass('hidden')
          }
        })
        .done(function(res) {
          
          data = JSON.parse(res); 
          console.log(data)
          if (data[0].metaData.code == 201) {
            $('.statusError').text(data[0].metaData.message)
          }
          if (data[0].metaData.code == 200) {
            $('.statusError').text('')
            $('.tableStatus').removeClass('hidden')
            $('.lanjut').removeClass('hidden')
            $('.statusError').text('')
            $('.nama').text(data[1].peserta.nama)
            $('.nik').text(data[1].peserta.nik)
            $('.tglLahir').text(data[1].peserta.tglLahir)
            $('.noTelepon').text(data[1].peserta.mr.noTelepon)
            $('.noka').text(data[1].peserta.noKartu)
            $('.status').text(data[1].peserta.statusPeserta.keterangan)
            $('.jenisPeserta').text(data[1].peserta.jenisPeserta.keterangan)
            $('.rujukan').removeClass('hidden');
            $('.ppkPerujuk').text(data[1].peserta.provUmum.kode)
            //FORM
            $('input[name="nama"]').val(data[1].peserta.nama)
            $('input[name="no_jkn"]').val(data[1].peserta.noKartu)
            $('input[name="nik"]').val(data[1].peserta.nik)
            $('input[name="nohp"]').val(data[1].peserta.mr.noTelepon)
            $('input[name="umr"]').val(data[1].peserta.umur.umurSekarang)
            $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
            $('input[name="ppk_rujukan"]').val(data[1].peserta.provUmum.kdProvider)
            $('select[name="kelamin"]').val(data[1].peserta.sex).trigger('change')
            $('select[name="jkn"]').val(data[1].peserta.jenisPeserta.keterangan).trigger('change')
            $('input[name="tgllahir"]').val($.datepicker.formatDate('dd-mm-yy', new Date(data[1].peserta.tglLahir)))
            
          }

        });
        $('.save').attr('onclick', 'cariNIK()');
        }
</script>
@endsection