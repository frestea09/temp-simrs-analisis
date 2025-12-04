@extends('master')
@section('header')
  <h1>Rawat Inap  <small></small></h1>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4>Pendaftaran IBS</h4>
    </div>
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
              <th>Dokter</th>
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
      @if ($ibs->count() > 0)
        <h4>Pendaftaran Sebelumnya</h4>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Rencana Operasi</th>
                <th>Suspect</th>
                <th>Hapus</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ibs as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td class="editable" data-id="{{ $d->id }}" data-value="{{ $d->rencana_operasi }}">
                      {{ tgl_indo($d->rencana_operasi) }}
                  </td>
                  <td>{!! $d->suspect !!}</td>
                  <td><button class="btn btn-danger btn-sm" onclick="deleteIbs({{ @$d->id }})">Hapus</button></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
        {{-- @include('tinymce') --}}
          {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/save-ibs', 'class' => 'form-horizontal']) !!}
              {!! Form::hidden('registrasi_id', $reg->id) !!}
              {!! Form::hidden('carabayar', baca_carabayar($reg->bayar)) !!}
              @if ($irna)
                {!! Form::hidden('rawatinap_id', @$irna->id) !!}
                  
              @endif
              {{-- {!! Form::hidden('rawatinap_id', @$irna->id) !!} --}}
              {!! Form::hidden('no_rm', $reg->pasien->no_rm) !!}

              <div class="form-group{{ $errors->has('rencana_operasi') ? ' has-error' : '' }}">
                  {!! Form::label('rencana_operasi', 'Rencana Operasi', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::text('rencana_operasi', null, ['class' => 'form-control datepicker']) !!}
                      <small class="text-danger">{{ $errors->first('rencana_operasi') }}</small>
                  </div>
              </div>
              @if ($reg->bayar == 1)
              <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                {!! Form::label('no_jkn', 'No. Kartu', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  <input type="number" name="no_jkn" class="form-control" id="" value="{{$reg->pasien->no_jkn}}">
                  <small class="text-danger">No.Kartu wajib sesuai karena akan dikirim ke WS BPJS</small>
                </div>
              </div>
              @endif
              <div class="form-group{{ $errors->has('kodepoli') ? ' has-error' : '' }}">
                {!! Form::label('kodepoli', 'SMF Tujuan', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  <select name="kodepoli" class="form-control select2" style="width: 100%">
                    <option value=""></option>
                    @foreach ($poli as $d)
                      <option value="{{ $d->bpjs }}">{{ $d->nama }} </option>
                    @endforeach
                  </select>
                    <small class="text-danger">{{ $errors->first('kodepoli') }}</small>
                </div>
            </div>
            <div class="form-group{{ $errors->has('suspect') ? ' has-error' : '' }}">
                {!! Form::label('suspect', 'Suspect', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::textarea('suspect', null, ['class' => 'form-control']) !!}
                    <small class="text-green"> *cukup isikan tindakan yang akan dilakukan</small><br>
                    <small class="text-danger">{{ $errors->first('suspect') }}</small>
                </div>
            </div>

            @if (baca_carabayar($reg->bayar) == 'JKN')
            <div class="form-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
              {!! Form::label('no_jkn', 'Nomor JKN', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                {!! Form::text('no_jkn',  Modules\Pasien\Entities\Pasien::where('id', $reg->pasien_id)->first()->no_jkn , ['class' => 'form-control']) !!}
                 <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
              </div>
            </div>
            @endif
              <div class="btn-group pull-right">
                  <a href="{{ url('rawat-inap/billing') }}" class="btn btn-warning btn-flat">Batal</a>
                  {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
              </div>
          {!! Form::close() !!}


    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2()

  function deleteIbs(id) {

    if (confirm("Yakin Hapus Operasi") == true) {
      $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/rawatinap/deleteIbs/'+id,
          type: 'POST',
          dataType: 'json',
        })
        .done(function(data) {
          alert('Berhasil Hapus Operasi')
          location.reload()
        })
        .fail(function() {
          alert('Gagal Hapus');
          location.reload()
        });
    } else {
      alert('Cancel Hapus')
    }


      
  }

</script>
<script>
$(document).ready(function () {
    $('.editable').dblclick(function () {
        let td = $(this);
        let awal = td.data('value');
        let id = td.data('id');

        if (td.find('input').length > 0) return;

        let input = $('<input type="date" class="form-control form-control-sm">');
        input.val(awal);
        td.html(input);
        input.focus();
        input.blur(function () {
            simpanPerubahan(td, input.val(), id);
        });
        input.keypress(function (e) {
            if (e.which == 13) { 
                simpanPerubahan(td, input.val(), id);
            }
        });

    });

    function simpanPerubahan(td, newValue, id) {

        if (newValue == "" || newValue == null) {
            alert("Tanggal tidak boleh kosong!");
            td.html(td.data('value'));
            return;
        }

        $.ajax({
            url: "{{ url('rawat-inap/ibs/update-tanggal') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                rencana_operasi: newValue
            },
            success: function (res) {
                td.data('value', newValue);
                td.html(res.tgl_indo);
            },
            error: function (xhr) {
                alert("Gagal menyimpan perubahan!");
                td.html(td.data('value'));
            }
        });
    }

});
</script>
@endsection
