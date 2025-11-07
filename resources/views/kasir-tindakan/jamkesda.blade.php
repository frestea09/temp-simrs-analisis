@extends('master')
@section('header')
  <h1>Input Jaminan Jamkesda<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{--  <h4>Data Pasien Ambulance</h4>  --}}
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/kasir/jamkesda', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
            <span class="input-group-btn">
              <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">NOMOR RM</button>
            </span>
            <select name="no_rm" class="form-control" id="selectRM" onchange="this.form.submit()">
            </select>
            <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
        </div>
      </div>
      {!! Form::close() !!}
      <hr>
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama </th>
              <th>Pelayanan</th>
              <th>Tgl Registrasi</th>
              <th>Poli / Kamar</th>
              <th>Input</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->no_rm }}</td>
              <td>{{ strtoupper($d->nama) }}</td>
              <td>
                @if (substr($d->status_reg, 0,1) == 'J')
                    Rawat Jalan
                @elseif(substr($d->status_reg, 0,1) == 'G')
                    IGD
                @elseif(substr($d->status_reg, 0,1) == 'I')
                    Rawat Inap
                @endif
              </td>
              <td>{{ $d->created_at }}</td>
              <td>
                @if (substr($d->status_reg, 0,1) == 'I')
                  @php
                      $irna = \App\Rawatinap::where('registrasi_id', $d->registrasi_id)->first();
                  @endphp
                  {{ baca_kamar($irna['kamar_id']) }}
                @else
                  {{ baca_poli($d->poli_id) }}
                @endif
              </td>
              <td>
                <button type="button" onclick="addForm({{ $d->registrasi_id }})" class="btn btn-flat btn-primary"><i class="fa fa-ambulance"></i></button>
              </td>

            @endforeach

          </tbody>
        </table>
      </div>

    </div>
  </div>

  <div class="modal fade" id="jamkesdaModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          {!! Form::open(['method' => 'POST', 'id' => 'formJamkesda', 'class'=>'form-horizontal']) !!}
              <input type="hidden" name="registrasi_id" value="">
              <div class="form-group dijaminGroup">
                <label for="dijamin" class="col-sm-3 control-label">Dijamin</label>
                <div class="col-sm-6">
                  <input type="text" name="dijamin" class="form-control uang">
                  <small class="text-danger dijaminError"></small>
                </div>
              </div>
          {!! Form::close() !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="save()">Simpan</button>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('script')
  <script type="text/javascript">

     // Currency
    $('.uang').maskNumber({
      thousands: ',',
      integer: true,
    });


    $('#selectRM').select2({
      placeholder: "Pilih No Rm...",
      ajax: {
          url: '/pasien/master-pasien/',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  })


function addForm(registrasi_id){
  $('#jamkesdaModal').modal({
    backdrop: 'static',
    keyboard: false
  })
  $('.modal-title').text('Input Jaminan Jamkesda')
  $('.select2').select2()
  $('input[name="registrasi_id"]').val(registrasi_id)
}

function save(){
  var data = $('#formJamkesda').serialize()
  $.post('/kasir/jamkesdaSave', data, function(resp){
    if(resp.sukses == false){
      if (resp.error.dijamin){
        $('.dijaminGroup').addClass('has-error')
        $('.dijaminError').text(resp.error.dijamin[0])
      }
    }
    if(resp.sukses == true){
      $('#formJamkesda')[0].reset()
      $('#jamkesdaModal').modal('hide')
      alert('Perawat Jamkesda berhasil diinput')
    }
  })
}


  </script>

@endsection
