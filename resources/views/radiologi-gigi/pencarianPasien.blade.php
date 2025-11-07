@extends('master')

@section('header')
  <h1>Billing System Radiologi - Pencarian Pasien</h1>
@endsection

@section('content')
  <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
        </h4>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'radiologi-gigi/pencarian-pasien', 'class'=>'form-hosizontal']) !!}
		<div class="row">
			<div class="col-md-6">
			<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
				<span class="input-group-btn">
				<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
				</span>
				{!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
			</div>
			</div>
		</div>
		{!! Form::close() !!}
		<hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>No. RM</th>
                <th>Dokter</th>
                <th>Cara Bayar</th>
                <th>Ekpertise</th>
                <th>Cetak</th>
                <th class="text-center" style="vertical-align: middle;">Catatan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                  @if (Auth::user()->role()->first()->name == 'radiologi')
                      @if ( cek_tindakan($d->id, 18) > 0 )
                        <tr class="success">
                      @else
                        <tr>
                      @endif
                  @endif

                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="ekspertise({{ $d->id }})"><i class="fa fa-edit"></i></button>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('radiologi-gigi/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('YAKIN AKAN DIMASUKKAN TINDAKAN? KARENA AKAN MENAMBAH KUNJUNGAN RADIOLOGI')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td> --}}
                  <td class="text-center">
                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'R')->count() > 0)
                      <a href="{{ url('radiologi-gigi/cetakRincianRad/irna/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->id }})"><i class="fa fa-book"></i></button>
                  </td>
                  <td>
                    @if ($d->status_reg == 'G1' || $d->status_reg == 'G2') 
                        <small class="label bg-green">Gawat Darurat</small>
                    @elseif ($d->status_reg == 'J1' || $d->status_reg == 'J2')
                        <small class="label bg-blue">Rawat Jalan</small>
                    @elseif ($d->status_reg == 'I1')
                        <small class="label bg-black">Belum Punya Bed</small>
                    @elseif ($d->status_reg == 'I2')
                        <small class="label bg-yellow">Rawat Inap</small>
                    @elseif ($d->status_reg == 'I3')
                        <small class="label bg-red">Sudah Pulang</small>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>


      </div>
    </div>

  <div class="modal fade" id="ekspertiseModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" class="form-horizontal" id="formEkspertise">
            {{ csrf_field() }}
            <input type="hidden" name="registrasi_id" value="">
            <input type="hidden" name="ekspertise_id" value="">

          <div class="table-responsive">
            <table class="table table-condensed table-bordered">
              <tbody>
                <tr>
                  <th>Nama Pasien </th> <td class="nama"></td>
                  <th>Jenis Kelamin </th><td class="jk"></td>
                </tr>
                <tr>
                  <th>Umur </th><td class="umur"></td>
                  <th>No. RM </th><td class="no_rm"></td>
                </tr>
                <tr>
                  <th>Pemeriksaan</th><td><ol class="pemeriksaan"></ol>  </td>
                  <th>Tanggal Pemeriksaan </th>
                  <td>
                    <td class="tgl_priksa"></td>
                  </td>
                </tr>
                <tr>
                  <th>Dokter</th>
                  <td>
                      <select name="dokter_id" class="form-control select2" style="width: 100%">
                        @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                      </select>
                  </td>
                  <th>Dokter Pengirim</th>
                  <td>
                      <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                        @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                      </select>
                  </td>
                </tr>
                <tr>
                  <th>No. Dokumen</th>
                  <td>
                    <input type="text" name="no_dokument" class="form-control">
                  </td>
                  <th>Tanggal Ekspertise </th>
                  <td colspan="3">
                    {!! Form::text('tanggal_eksp', null, ['class' => 'form-control datepicker ', 'required' => 'required']) !!}
                  </td>
                </tr>
                <tr>
                  <th>Klinis </th>
                  <td colspan="3">
                    <input type="text" name="klinis" class="form-control">
                  </td>
                </tr>
                <tr>
                  <th>Ekspertise</th>
                  <td colspan="3">
                    <textarea name="ekspertise" class="form-control wysiwyg"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="pemeriksaanModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-horizontal" id="form">
          <table class="table table-condensed table-bordered">
            <tbody>
                <tr>
                  <th>Tanggal Order :<input class="form-control" name="waktu" redonly> </th> 
                </tr>
                <tr>
                  <td>
                    <textarea name="pemeriksaan" class="form-control wysiwyg"></textarea>
                  </td>
                </tr>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@stop

@section('script')
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
  <script type="text/javascript">
    //CKEDITOR
    $('.select2').select2();

    CKEDITOR.replace( 'pemeriksaan', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function coba(registrasi_id) {
      $('#pemeriksaanModel').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('.modal-title').text('Catataan Order Radiologi')
      $("#form")[0].reset()
      CKEDITOR.instances['pemeriksaan'].setData('')
      $.ajax({
        url: '/radiologi-gigi/catatan-pasien/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="waktu"]').val(data.created_at)
        CKEDITOR.instances['pemeriksaan'].setData(data.pemeriksaan)
      })
      .fail(function() {

      });
    }
    
    CKEDITOR.replace( 'ekspertise', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function ekspertise(id) {
      $('#ekspertiseModal').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('.modal-title').text('Input Ekpertise')
      $("#formEkspertise")[0].reset()
      CKEDITOR.instances['ekspertise'].setData('')
      $.ajax({
        url: '/radiologi-gigi/ekspertise/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('.nama').text(data.reg.pasien.nama)
        $('.no_rm').text(data.reg.pasien.no_rm)
        $('.umur').text(data.umur)
        $('.jk').text(data.reg.pasien.kelamin)
        $('.tgl_priksa').text(data.tindakan.created_at)
        $('input[name="registrasi_id"]').val(data.reg.id)
        $('input[name="klinis"]').val(data.ep.klinis)
        $('input[name="tanggal_eksp"]').val(data.tanggal)
        $('select[name="dokter_id"]').val(data.ep.dokter_id).trigger('change')
        $('select[name="dokter_pengirim"]').val(data.ep.dokter_pengirim).trigger('change')
        $('.pemeriksaan').empty()
        $.each(data.tindakan, function(index, val) {
          $('.pemeriksaan').append('<li>'+val.namatarif+'</li>')
        });
        if (data.ep != '') {
          $('input[name="ekspertise_id"]').val(data.ep.id)
          $('input[name="no_dokument"]').val(data.ep.no_dokument)
          CKEDITOR.instances['ekspertise'].setData(data.ep.ekspertise)
        }
      })
      .fail(function() {

      });
    }


    function saveEkpertise() {
      var token = $('input[name="_token"]').val();
      var ekspertise = CKEDITOR.instances['ekspertise'].getData();
      var form_data = new FormData($("#formEkspertise")[0])
      form_data.append('ekspertise', ekspertise)

      $.ajax({
        url: '/radiologi-gigi/ekspertise',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('input[name="ekspertise_id"]').val(resp.data.id)
          alert('Ekspertise berhasil disimpan.')
        }

      });


    }
  </script>
@endsection
