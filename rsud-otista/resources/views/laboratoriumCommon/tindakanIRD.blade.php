@extends('master')

@section('header')
  <h1>Billing System Laboratorium - Rawat Darurat </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          Periode Tanggal &nbsp;
        </h4>
      </div>
      <div class="box-body">

        {!! Form::open(['method' => 'POST', 'url' => 'laboratoriumCommon/tindakan-ird', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off', 'onchange'=>'this.form.submit()']) !!}
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
                <th>Poli Tujuan</th>
                <th>Cara Bayar</th>
                <th class="text-center" style="vertical-align: middle;">SEP</th>
                <th>Billing</th>
                <th>Cetak</th>
                <th>Catatan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty( @$d->pasien->id) ?  @$d->pasien->nama: '-' }}</td>
                  <td>{{ @$d->pasien->no_rm }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ !empty( @$d->poli->id) ?  @$d->poli->nama: '-' }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td>{{ @$d->no_sep }}</td>
                  <td>
                    <a href="{{ url('laboratoriumCommon/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN TINDAKAN LAB? KARENA AKAN MENAMBAH KUNJUNGAN LAB.')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td>
                  <td>
                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_id', 43)->where('poli_tipe', 'L')->count() > 0)
                      <a href="{{ url('laboratoriumCommon/cetakRincianLab/ird/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->id }})"><i class="fa fa-book"></i></button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
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
      $('.modal-title').text('Catataan Order Laboratorium')
      $("#form")[0].reset()
      CKEDITOR.instances['pemeriksaan'].setData('')
      $.ajax({
        url: '/laboratoriumCommon/catatan-pasien/'+registrasi_id,
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
  </script>
@endsection
