@extends('master')

@section('header')
  <h1>Laboratorium - Cari Pasien </h1>
  <h6 class="text-right">
    - <span class="color:red !important">*</span> Menu ini hanya digunakan untuk mencari pasien yang sudah <b>Teregistrasi</b><br/>
    - Jika pasien belum diregistrasi terbaru, <b>harus diregistrasi</b> terlebih dahulu, jangan <b>dibilling</b> di registrasi yang tanggal terdahulu</h6>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          Periode Tanggal &nbsp;
        </h4>
      </div>
      <div class="box-body">

        {!! Form::open(['method' => 'POST', 'url' => 'laboratoriumCommon/cari-pasien', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-4">
          <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
            <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor RM</button>
            </span>
            @if (session('no_rm'))
                
            {!! Form::text('no_rm', '', ['class' => 'form-control', 'required' => 'required']) !!}
            @else
            {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required']) !!}
                
            @endif
          </div>
          </div>
          <div class="col-md-4">
            <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
          </div>
        </div>
          {!! Form::close() !!}
        <hr>

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th class="text-center" style="vertical-align: middle;">No</th>
                <th class="text-center" style="vertical-align: middle;">Nama Pasien</th>
                <th class="text-center" style="vertical-align: middle;">No. RM</th>
                <th class="text-center" style="vertical-align: middle;">Tgl Reg</th>
                <th class="text-center" style="vertical-align: middle;">Dokter</th>
                <th class="text-center" style="vertical-align: middle;">Klinik Asal</th>
                <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
                <th class="text-center" style="vertical-align: middle;">Proses</th>
                <th class="text-center" style="vertical-align: middle;">Cetak</th>
                <th class="text-center" style="vertical-align: middle;">Catatan</th>
              </tr>
            </thead>
            <tbody>
              @isset($registrasi)
                  @foreach ($registrasi as $key => $d)
                      @php
                        $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
                      @endphp
                      <td>{{ $no++ }}</td>
                      <td>{{ $pasien ? $d->pasien->nama : '' }}</td>
                      <td>{{ $pasien ? $d->pasien->no_rm : '' }}</td>
                      <td>{{ $d->created_at->format('d-m-Y') }}</td>
                      <td>{{ !(empty($d->dokter_id)) ? baca_dokter($d->dokter_id) : '' }}</td>
                      <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                      <td>{{ baca_carabayar($d->bayar) }}
                        @if (!empty($d->tipe_jkn))
                          - {{ $d->tipe_jkn }}
                        @endif
                      </td>
                      <td>
                        <a href="{{ url('/laboratoriumCommon/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN TINDAKAN LAB? KARENA AKAN MENAMBAH KUNJUNGAN LAB.')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                      </td>
                      <td>
                        @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_id', 43)->where('poli_tipe', 'L')->count() > 0)
                          <a href="{{ url('laboratoriumCommon/cetakRincianLab/irj/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                        @endif
                      </td>
                      <td>
                        <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->id }})"><i class="fa fa-book"></i></button>
                      </td>
                    </tr>
                @endforeach
              @endisset
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
