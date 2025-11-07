@extends('master')

@section('header')
  <h1>
      Entry Ekpertise Radiologi - Rawat IGD
  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        {{-- <h3 class="box-title">
          Data Rekam Medis &nbsp;
        </h3> --}}
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active" style="height: 180px;">
              <div class="row">
                <div class="col-md-2">
                  <h4 class="widget-user-username">Nama</h4>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Umur</h5>
                </div>
                <div class="col-md-7">
                  <h4 class="widget-user-username">:{{ $pasien->nama}}</h4>
                  <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: {{ hitung_umur($pasien->tgllahir) }} </h5>
                </div>
                <div class="col-md-3 text-center">
                  
                </div>
              </div>


            </div>
            <div class="widget-user-image">

            </div>

          </div>
          <!-- /.widget-user -->
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class="box box-info">
          <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'radiologi-gigi/save-ekspertise', 'class' => 'form-horizontal']) !!}
              <input type="hidden" name="jenis" value="IGD">
              <input type="hidden" name="registrasi_id" value="{{ !empty($reg) ? $reg->id : NULL }}">
              <input type="hidden" name="tarif_id" value="{{ !empty($tindakan) ? $tindakan->tarif_id : NULL }}">
              <input type="hidden" name="ekspertise_id" value="{{ !empty($eksp1) ? $eksp1->id : NULL }}">
              <div class="row">
                <div class="col-md-7">
                  <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                      {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          <select class="form-control select2" style="width: 100%" name="dokter_id">
                            @foreach ($dokter as $key => $d)
                                @if (!empty($eksp->dokter_id) ? $d->id == $eksp->dokter_id : '')
                                    <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                                @else
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endif
                            @endforeach
                          </select>
                          <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('dokter_pengirim') ? ' has-error' : '' }}">
                      {!! Form::label('dokter_pengirim', 'Dokter Pengirim', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          <select class="form-control select2" style="width: 100%" name="dokter_pengirim">
                            @foreach ($dokter as $key => $d)
                                @if (!empty($eksp->dokter_pengirim) ? $d->id == $eksp->dokter_pengirim : '')
                                    <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                                @else
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endif
                            @endforeach
                          </select>
                          <small class="text-danger">{{ $errors->first('dokter_pengirim') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('klinis') ? ' has-error' : '' }}">
                      {!! Form::label('klinis', 'Klinis', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                      <input type="text" name="klinis" value="{{ !empty($eksp1->klinis) ? $eksp1->klinis :NULL }}" class="form-control">
                          <small class="text-danger">{{ $errors->first('klinis') }}</small>
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('tindakan') ? ' has-error' : '' }}">
                      {!! Form::label('tindakan', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                        <ul style="padding-left: 15px;padding-top: 10px;">
                            <li>{{ $tindakan->namatarif }}</li>
                        </ul> 
                      </div>
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="form-group{{ $errors->has('no_dokument') ? ' has-error' : '' }}">
                      {!! Form::label('no_dokument', 'No Dokument', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                      <input type="text" name="no_dokument" value="{{ !empty($eksp1->no_dokument) ? $eksp1->no_dokument :NULL }}" class="form-control">
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('tanggal_eksp') ? ' has-error' : '' }}">
                      {!! Form::label('tanggal_eksp', 'Tanggal Ekspertise', ['class' => 'col-sm-3 control-label']) !!}
                      <div class="col-sm-9">
                          <input type="text" name="tanggal_eksp" value="{{ $tanggal }}" class="form-control datepicker">
                          <small class="text-danger">{{ $errors->first('tanggal_eksp') }}</small>
                      </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      {!! Form::label('ekspertise', 'Ekspertise', ['class' => 'col-sm-6 control-label text-center']) !!}
                      <div class="col-sm-12">
                          <textarea name="ekspertise" class="form-control wysiwyg">
                          {{ !empty($eksp1->ekspertise) ? $eksp1->ekspertise :NULL }}
                          </textarea>
                      </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                      <div class="col-md-9 col-md-offset-3">
                        {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                      </div>
                  </div>
                </div>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
        {{-- ======================================================================================================================= --}}

      </div>
    </div>
@stop

@section('script')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
  
  CKEDITOR.replace( 'ekspertise', {
    height: 200,
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
  });

  $('.select2').select2()

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
