@extends('master')

@section('header')
  <h1>Daftar Antrian Operasi </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'operasi/pertanggal', 'class' => 'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                {!! Form::label('tanggal', 'Tanggal ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::text('tanggal', (empty(Request::segment(3))) ? date('d-m-Y') : tgl_indo(Request::segment(3)), ['class' => 'form-control datepicker', 'onchange'=>'this.form.submit()']) !!}
                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}

      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Kamar</th>
              <th>Bed</th>
              {{-- <th>Diagnosa</th> --}}
              <th style="text-align: center">EMR</th>
              <th>Tindakan</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody>
            @if ($antrian->count() < 1)
              <tr>
                <td colspan="8">Tidak ada pasien operasi</td>
              </tr>

            @else
              @foreach ($antrian as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ @$d->no_rm }}</td>
                  <td>{{ @$d->namaPasien }}</td>
                  <td>{{ @$d->kelas ?? '' }}</td>
                  <td>{{ @$d->kamar ?? '' }}</td>
                  <td>{{ @$d->bed ?? '' }}</td>
                  {{-- <td>{!! $d->suspect !!}</td> --}}
                  <td>
                    {{-- <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                        <span class="fa fa-book" style="margin-right: 10px;"></span>
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        <li>
                          <a href="{{ url('emr-soap/pemeriksaan/pre-operatif/inap/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}">Pre Operatif</a>
                        </li>
                        <li>
                          <a href="{{ url('emr-soap/pemeriksaan/pra-anestesi/inap/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}">Pra Anestesi</a>
                        </li>
                        <li>
                          <a href="{{ url('emr-soap/pemeriksaan/laporan-operasi/inap/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}">Laporan Operasi</a>
                        </li>
                        <li>
                          <a href="{{ url('emr-soap/pemeriksaan/asesmen-pra-bedah/inap/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}">Asesmen Pra Bedah</a>
                        </li>
                        <li>
                          <a href="{{ url('emr-soap/pemeriksaan/keadaan-pasca-bedah/inap/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}">Keadaan Pasca Bedah</a>
                        </li>
                        <li>
                          <a href="{{ url('emr-soap/pemeriksaan/daftar-tilik-operasi/inap/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}">Daftar Tilik</a>
                        </li>
                        <li>
                          <a href="{{ url('emr-soap/pemeriksaan/kartu-anestesi/inap/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}">Kartu Anestesi</a>
                        </li>
                      </ul>
                    </div> --}}
                    @if (cek_status_reg(@$d->status_reg) == "I")
                      <a href="{{url('emr-soap/operasi/main/inap/' . $d->registrasi_id)}}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-book"></i></a>
                    @elseif (cek_status_reg(@$d->status_reg) == "G")
                      <a href="{{url('emr-soap/operasi/main/igd/' . $d->registrasi_id)}}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-book"></i></a>
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('operasi/tindakan/antrian/'.$d->registrasi_id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-scissors"></i></a>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->registrasi_id }})"><i class="fa fa-book"></i></button>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {{-- {{ $antrian->links() }} --}}
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
@endsection
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
      $('.modal-title').text('Catataan Order Operasi')
      $("#form")[0].reset()
      CKEDITOR.instances['pemeriksaan'].setData('')
      $.ajax({
        url: '/operasi/catatan-pasien/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="waktu"]').val(data.rencana_operasi)
        CKEDITOR.instances['pemeriksaan'].setData(data.suspect)
      })
      .fail(function() {

      });
    }
  </script>
@endsection
