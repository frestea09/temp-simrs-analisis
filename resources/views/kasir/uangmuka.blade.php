@extends('master')
@section('header')
  <h1>Uang Muka {{ $type }}<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'POST', 'url' => '/kasir/uangmuka-rawatinap', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('registrasi_id', null) !!}
        {!! Form::hidden('type', $type) !!}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  {!! Form::label('nama', 'Pasien', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                    <div class="input-group">
                        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                        <span class="input-group-btn">
                          <button type="button" id="openModal" class="btn btn-default btn-flat"><i class="fa fa-search"></i> </button>
                        </span>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('nama', 'No. RM', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::text('no_rm', null, ['class' => 'form-control', 'readonly'=>true]) !!}
                      <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                  </div>
              </div>
              <div class="btn-group pull-right">
                {!! Form::submit("LANJUT", ['class' => 'btn btn-success btn-flat']) !!}
              </div>
            </div>
          </div>

      {!! Form::close() !!}

      @isset($reg)
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead class="bg-primary">
              <tr>
                <th style="vertical-align: middle;">No. RM</th>
                <th>Nama Lengkap</th>
                <th style="vertical-align: middle;">Alamat</th>
                <th style="vertical-align: middle;">Cara Bayar</th>
                <th style="vertical-align: middle;">Dokter</th>
                <th>Tanggal Inap</th>
                <th class="text-center" style="vertical-align: middle;">DP</th>
              </tr>
            </thead>
            <tbody>
              @if ($reg->count() > 0)
                  <tr>
                    <td>{{ $reg->pasien->no_rm }}</td>
                    <td>{{ $reg->pasien->nama }}</td>
                    <td>{{ $reg->pasien->alamat }}</td>
                    <td>{{ !empty($reg->bayar) ? baca_carabayar($reg->bayar) : '' }}</td>
                    <td>{{ !empty($reg->dokter_id) ? baca_dokter($reg->dokter_id) : '' }}</td>
                    <td>{{ $inap ? tanggal($inap->tgl_masuk) : NULL }}</td>
                    <td class="text-center">
                      <button type="button" onclick="titipUM({{ $reg->id }})" class="btn btn-primary btn-flat"> <i class="fa fa-plus"></i> </button>
                    </td>
                  </tr>
              @else
                <tr>
                  <td colspan="6">Data tidak ditemukan</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      @endisset

      <div id="viewDeposit" class="col-md-12">
      </div>


    </div>
    <div class="box-footer">
    </div>
  </div>

  {{-- Modal Uang Muka --}}
  <div class="modal fade" id="modalUM" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="FormUM" method="post">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="registrasi_id" value="">
              <input type="hidden" name="type" value="{{ $type }}">
              <div class="form-group " id="inputNominal">
                <label for="nominal" class="col-md-3 control-label">Nominal</label>
                <div class="col-md-8">
                  <div class="input-group">
                    <span class="input-group-addon">Rp. </span>
                    <input type="text" name="nominal" class="form-control uang" id="" placeholder="">
                    <span class="input-group-addon">,00</span>
                  </div>
                  <small class="text-danger"><p id="nominal-error"></p></small>
                </div>
              </div>
              <div class="form-group " id="inputKeluarga">
                <label for="nominal" class="col-md-3 control-label">Keluarga</label>
                <div class="col-md-8">
                  <input type="text" name="keluarga" class="form-control" id="" placeholder="">
                  <small class="text-danger"><p id="keluarga-error"></p></small>
                </div>
              </div>
              <div class="form-group " id="inputUmur">
                <label for="umur" class="col-md-3 control-label">Umur</label>
                <div class="col-md-8">
                  <input type="number" name="umur" class="form-control" id="" placeholder="">
                  <small class="text-danger">
                    <p id="umur-error"></p>
                  </small>
                </div>
              </div>
              <div class="form-group " id="inputPekerjaan">
                <label for="pekerjaan" class="col-md-3 control-label">Pekerjaan</label>
                <div class="col-md-8">
                  <input type="text" name="pekerjaan" class="form-control" id="" placeholder="">
                  <small class="text-danger">
                    <p id="pekerjaan-error"></p>
                  </small>
                </div>
              </div>
              <div class="form-group " id="inputAlamat">
                <label for="alamat" class="col-md-3 control-label">Alamat</label>
                <div class="col-md-8">
                  <input type="text" name="alamat" class="form-control" id="" placeholder="">
                  <small class="text-danger">
                    <p id="alamat-error"></p>
                  </small>
                </div>
              </div>
  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="button" id="saveUM" class="btn btn-success btn-flat" name="button">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    {{-- Modal Return --}}
    <div class="modal fade" id="modalRet" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="FormRet" method="post">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="registrasi_id" value="">
              <input type="hidden" name="type" value="{{ $type }}">
              <div class="form-group " id="inputNominal">
                <label for="nominal" class="col-md-3 control-label">Nominal</label>
                <div class="col-md-8">
                  <div class="input-group">
                    <span class="input-group-addon">Rp. </span>
                    <input type="text" name="nominal" class="form-control uang" id="" placeholder="">
                    <span class="input-group-addon">,00</span>
                  </div>
                  <small class="text-danger"><p id="nominal-error"></p></small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                <button type="button" id="saveRet" class="btn btn-success btn-flat" name="button">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    {{-- MODAL SEARCH pasien --}}
    <div class="modal fade" id="searchPasien" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <table id="dataPasien" class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No. RM</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Input</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endsection

  @section('script')
  <script type="text/javascript">
    $('.uang').maskNumber({
      thousands: ',',
      integer: true,
    });

    $(document).ready(function() {
      var registrasi_id = $('input[name="registrasi_id"]').val();
      $('#viewDeposit').load('/kasir/viewDeposit/'+registrasi_id)

      if($('select[name="jenis_pasien"]').val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }

      $('select[name="jenis_pasien"]').on('change', function () {
        if ($(this).val() == 1) {
          $('select[name="tipe_jkn"]').removeAttr('disabled');
        } else {
          $('select[name="tipe_jkn"]').attr('disabled', true);
        }
      });

      //SEARCH PASIEN
      $('#openModal').on('click', function () {
        $("#dataPasien").DataTable().destroy();
        $('#searchPasien').modal('show');
        $('.modal-title').text('Cari Pasien');
        $('#dataPasien').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
          @if($type == 'Rawat Inap')
            ajax: '/kasir/dataPasienInap',
          @else
            ajax: '/kasir/dataPasienDarurat',
          @endif
            columns: [
                {data: 'no_rm'},
                {data: 'nama'},
                {data: 'alamat'},
                {data: 'input', searchable: false},
            ]
        });
      });

      $(document).on('click', '.inputPasien', function (e) {
        $('input[name="nama"]').val($(this).attr('data-nama'));
        $('input[name="no_rm"]').val($(this).attr('data-no_rm'));
        $('input[name="registrasi_id"]').val($(this).attr('data-registrasi_id'));
        $('#searchPasien').modal('hide');
      });

      $('input[name="nama"]').on('keyup', function () {
        if ( $('input[name="nama"]').val() == '' ) {
          $('input[name="no_rm"]').val('');
          $('input[name="pasien_id"]').val('');
        }
      });

    });

//TITIP UANG MUKA
  function titipUM(registrasi_id) {
      $('#modalUM').modal('show');
      $('.modal-title').text('Titip Uang Muka');
      $('input[name="registrasi_id"]').val(registrasi_id);

      //Remove Notif Error
      $('#nominal-error').html("");
      $('#nama-error').html("");
      $('#nohp-error').html("");
      $('#status-error').html("");
      $('#inputNominal').removeClass('has-error');
      $('#inputKeluarga').removeClass('has-error');
  }

  function returnDp(registrasi_id, id) {
    $.get('/kasir/save-return-rawatinap/'+id, function(res){
      if(res.success == true){
        $('#viewDeposit').load('/kasir/viewDeposit/'+registrasi_id)
      }
    })
  }

  //SAVE UANG MUKA - DEPOSIT
  $('#saveUM').on('click', function () {
    $.ajax({
      url: '/kasir/save-uangmuka-rawatinap',
      type: 'POST',
      data: $('#FormUM').serialize(),
      success: function (data) {
        console.log(data);
        if(data.errors) {
          if(data.errors.nominal) {
            $('#inputNominal').addClass('has-error');
            $('#nominal-error').html( data.errors.nominal[0] );
          }
          if(data.errors.keluarga) {
            $('#inputKeluarga').addClass('has-error');
            $('#keluarga-error').html( data.errors.keluarga[0] )
          }
        }
        if(data.success) {
          $("#FormUM")[0].reset();
          $('#modalUM').modal('hide');
          $('#viewDeposit').load('/kasir/viewDeposit/'+data.registrasi_id)
        }
      }
    });
  });

  </script>
  @endsection
