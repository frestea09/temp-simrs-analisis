@extends('master')
@section('header')
  <h1>Rawat Inap - Mutasi<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">

    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th colspan="4">Data Pasien</th>
            </tr>
            <tr>
              <th>Nama</th>
              <th>No. RM</th>
              <th>Alamat</th>
              <th>Dokter DPJP</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $reg->pasien->nama }}</td>
              <td>{{ $reg->pasien->no_rm }}</td>
              <td>{{ $reg->pasien->alamat }}</td>
              <td>{{ baca_dokter($reg->dokter_id) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>Kelompok Kelas</th>
              <th>Kelas</th>
              <th>Kamar</th>
              <th>Bed</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              {{-- <td>{{ App\Kelompokkelas::find($irna->kelompokkelas_id)->kelompok }}</td>
              <td>{{ $irna->kelas->nama }}</td>
              <td>{{ $irna->kamar->nama }}</td>
              <td>{{ $irna->bed->nama }}</td> --}}
              <td>{{ baca_kelompok($irna->kelompokkelas_id) }}</td>
              <td>{{ baca_kelas($irna->kelas_id) }}</td>
              <td>{{ baca_kamar($irna->kamar_id) }}</td>
              <td>{{ baca_bed($irna->bed_id) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <h4>Mutasi Kamar</h4>
      <hr>
      <div class="row">
        <div class="col-md-6">
          {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/simpan-mutasi', 'class' => 'form-horizontal']) !!}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('carabayar_id', $reg->bayar) !!}
              {!! Form::hidden('rawatinap_id', $irna->id) !!}
              {!! Form::hidden('bed_lama', $irna->bed_id) !!}
              <div class="form-group" id="kelompokkelas_idGroup">
                  {!! Form::label('kelompokkelas_id', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="form-control select2" name="kelompokkelas_id">
                        <option value=""></option>
                        @foreach (App\Kelompokkelas::all() as $d)
                          <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
                        @endforeach
                      </select>
                      <small class="text-danger" id="">{{ $errors->first('kelompokkelas_id') }}</small>
                  </div>
              </div>
              <div class="form-group" id="kelas_idGroup">
                  {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="form-control select2" name="kelas_id">
                      </select>
                      <small class="text-danger" id="">{{ $errors->first('kelas_id') }}</small>
                  </div>
              </div>
              <div class="form-group" id="kamaridGroup">
                  {!! Form::label('kamarid', 'Kamar', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="form-control select2" name="kamarid">
                      </select>
                      <small class="text-danger">{{ $errors->first('kamarid') }}</small>
                  </div>
              </div>
              <div class="form-group " id="bedID">
                  {!! Form::label('bed_id', 'Bed', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      <select class="form-control select2" name="bed_id">
                      </select>
                      <small class="text-danger">{{ $errors->first('bed_id') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('virtual') ? ' has-error' : '' }}">
                  {!! Form::label('virtual', 'JENIS BED', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('virtual', ['N'=>'BED RESMI', 'Y'=>'BED VIRTUAL'], null, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('virtual') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                  {!! Form::label('dokter_id', 'Dokter Ranap', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::select('dokter_id', $dokter, $irna->dokter_id, ['class' => 'select2', 'style' => 'width:100%']) !!}
                      <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                  </div>
              </div>
              <div class="form-group{{ $errors->has('pengirim') ? ' has-error' : '' }}">
                {!! Form::label('pengirim', 'Pengirim', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::select('pengirim', $pengirim, $irna->pengirim, ['class' => 'select2', 'style' => 'width:100%'], ['required']) !!}
                    <small class="text-danger">{{ $errors->first('pengirim') }}</small>
                </div>
            </div>
              <div class="form-group{{ $errors->has('tgl_masuk') ? ' has-error' : '' }}">
                  {!! Form::label('tgl_masuk', 'Tanggal Mutasi', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::text('tgl_masuk', NULL, ['class' => 'form-control datepicker']) !!}
                      <small class="text-danger">{{ $errors->first('tgl_masuk') }}</small>
                  </div>
              </div>

              <div class="btn-group pull-right">
                  <a href="{{ url('rawatinap/antrian') }}" class="btn btn-warning btn-flat">Batal</a>
                  {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Yakin data yang Anda masukkan sdh benar?")']) !!}
              </div>
          {!! Form::close() !!}
        </div>
      </div>

      {{-- HISTORI MUTASI --}}
      @if (count($histori))
        <b>HISTORI MUTASI</b><br/>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Kelompok Kelas</th>
                <th>Kelas</th>
                <th>Kamar</th>
                <th>Bed</th>
                <th>Cara Bayar</th>
                <th>Tgl.Mutasi</th>
                <th>User</th>
                <th>Pengirim</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($histori as $key=>$item)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ baca_kelompok($item->kelompokkelas_id) }}</td>
                  <td>{{ baca_kelas($item->kelas_id) }}</td>
                  <td>{{ baca_kamar($item->kamar_id) }}</td>
                  <td>{{ baca_bed($item->bed_id) }}</td>
                  <td>{{ @baca_carabayar(@$item->carabayar_id) }}</td>
                  <td>{{ date('d-m-Y, H:i',strtotime($item->created_at)) }} WIB</td>
                  <td>{{ baca_user($item->user_id) }}</td>
                  <td>{{ baca_pegawai($item->pengirim) }}</td>
                  <td>
                    <button class="btn btn-sm btn-success" onclick="editMutasi({{$item->id}})"><i class="fa fa-pencil"></i></button>
                  </td>
                </tr>
                  
              @endforeach
            </tbody>
          </table>
        </div>
          
      @endif

    </div>
  </div>

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <form id="form-update" method="POST" action="{{url('rawat-inap/update-mutasi')}}">
      <input type="hidden" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Mutasi</h4>
        </div>
        <div class="modal-body row" style="display: grid;">
                {{ csrf_field() }}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('mutasi_id', null) !!}
                <div class="form-group" id="kelompokkelas_id_editGroup">
                    {!! Form::label('kelompokkelas_id_edit', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control" name="kelompokkelas_id_edit">
                          <option value=""></option>
                          @foreach (App\Kelompokkelas::all() as $d)
                            <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger" id="">{{ $errors->first('kelompokkelas_id_edit') }}</small>
                    </div>
                </div>
                <div class="form-group" id="kelas_id_editGroup">
                    {!! Form::label('kelas_id_edit', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control" name="kelas_id_edit">
                        </select>
                        <small class="text-danger" id="">{{ $errors->first('kelas_id_edit') }}</small>
                    </div>
                </div>
                <div class="form-group" id="kamarid_editGroup">
                    {!! Form::label('kamarid_edit', 'Kamar', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control" name="kamarid_edit">
                        </select>
                        <small class="text-danger">{{ $errors->first('kamarid_edit') }}</small>
                    </div>
                </div>
                <div class="form-group " id="bedID_edit">
                    {!! Form::label('bed_id_edit', 'Bed', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control" name="bed_id_edit">
                        </select>
                        <small class="text-danger">{{ $errors->first('bed_id_edit') }}</small>
                    </div>
                </div>
          </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary" id="button-update-mutasi">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('script')
  {{-- Pengaturan Kelas --}}
  <script type="text/javascript">
    $('.select2').select2()
    $('select[name="kelompokkelas_id"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $(this).val();
      $.ajax({
        url: '/kamar/getkelas/'+kelompokkelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('select[name="kamarid"]').empty()
          $('select[name="kelas_id"]').empty()
          $('select[name="bed_id"]').empty()
          $('select[name="kelas_id"]').append('<option value=""></option>');
          $.each(data, function(key, value) {
              $('select[name="kelas_id"]').append('<option value="'+ value.id +'">'+ value.kelas +'</option>');
          });
        }
      })
    })

    $('select[name="kelas_id"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
      var kelas_id = $(this).val();
      $.ajax({
        url: '/kamar/getkamar/'+kelompokkelas_id+'/'+kelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('select[name="bed_id"]').empty()
          $('select[name="kamarid"]').empty()
          $('select[name="kamarid"]').append('<option value=""></option>');
          $.each(data, function(key, value) {
              $('select[name="kamarid"]').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
          });
        }
      })
    })

    $('select[name="kamarid"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
      var kelas_id = $('select[name="kelas_id"]').val()
      var kamar_id = $(this).val()
      $.ajax({
        url: '/getbed/'+kelompokkelas_id+'/'+kelas_id+'/'+kamar_id+'/',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('select[name="bed_id"]').empty()
          $.each(data, function(key, value) {
            $('select[name="bed_id"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      })
    })

    $('select[name="kelompokkelas_id_edit"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $(this).val();
      $.ajax({
        url: '/kamar/getkelas/'+kelompokkelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('select[name="kamarid_edit"]').empty()
          $('select[name="kelas_id_edit"]').empty()
          $('select[name="bed_id_edit"]').empty()
          $('select[name="kelas_id_edit"]').append('<option value=""></option>');
          $.each(data, function(key, value) {
              $('select[name="kelas_id_edit"]').append('<option value="'+ value.id +'">'+ value.kelas +'</option>');
          });
        }
      })
    })

    $('select[name="kelas_id_edit"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $('select[name="kelompokkelas_id_edit"]').val()
      var kelas_id = $(this).val();
      $.ajax({
        url: '/kamar/getkamar/'+kelompokkelas_id+'/'+kelas_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('select[name="bed_id_edit"]').empty()
          $('select[name="kamarid_edit"]').empty()
          $('select[name="kamarid_edit"]').append('<option value=""></option>');
          $.each(data, function(key, value) {
              $('select[name="kamarid_edit"]').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
          });
        }
      })
    })

    $('select[name="kamarid_edit"]').on('change', function(e) {
      e.preventDefault();
      var kelompokkelas_id = $('select[name="kelompokkelas_id_edit"]').val()
      var kelas_id = $('select[name="kelas_id_edit"]').val()
      var kamar_id = $(this).val()
      $.ajax({
        url: '/getbed/'+kelompokkelas_id+'/'+kelas_id+'/'+kamar_id+'/',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('select[name="bed_id_edit"]').empty()
          $.each(data, function(key, value) {
            $('select[name="bed_id_edit"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        }
      })
    })

    function editMutasi(id) {
      $('#myModal').modal('show');
      $('input[name="mutasi_id"]').val(id);
    }

    $('#button-update-mutasi').click(function (e) {
      e.preventDefault();
      $("#form-update").submit();
    })

    
  </script>
@endsection