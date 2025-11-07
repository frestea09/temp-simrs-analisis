@extends('master')

@section('header')
  <h1>Transit Rawat Darurat</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Periode Tanggal</h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'igd/transit', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', $tga, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
            </div>
          </div>
          </div>
        {!! Form::close() !!}
        <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Pasien</th>
                <th class="text-center">No. RM</th>
                <th class="text-center">Dokter</th>
                <th class="text-center">Triage</th>
                <th class="text-center">Cara Bayar</th>
                <th class="text-center">Registrasi</th>
                <th class="text-center">Tgl Masuk</th>
                <th class="text-center" style="width: 10%">AKSI</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                @if($d->pasien_id != 0 || $d->pasien_id != null)
                  @php
                      $folio = \Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('jenis', 'TG')->count();
                      $pulang = App\ResumePasien::where('registrasi_id', $d->id)->first();
                  @endphp
                  @if (Auth::user()->role()->first()->name == 'rawatdarurat')
                      @if ( cek_tindakan($d->id, 6) >= 2 )
                        <tr class="info">
                      @else
                        <tr>
                      @endif
                  @endif
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                      @if (Carbon\Carbon::now() > $d->created_at->addHours(6) && $d->status_reg == 'G1')
                        <span class="blink_me" style="color: red; font-weight: bold;">{{ $d->pasien->nama }}</span>
                      @else
                        {{ ($d->pasien_id != 0) ? $d->pasien->nama : '' }}
                      @endif
                    </td>
                    <td>{{ ($d->pasien_id != 0) ? $d->pasien->no_rm : '' }}</td>
                    <td>{{ Modules\Pegawai\Entities\Pegawai::where('id', $d->dokter_id)->first()->nama }}</td>
                    <td>{{ $d->triage_nama }}</td>
                    <td>{{ baca_carabayar($d->bayar) }}
                      @if (!empty($d->tipe_jkn))
                        - {{ $d->tipe_jkn }}
                      @endif
                    </td>
                    <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                    <td>
                      {{ date('d-m-Y H:i:s', strtotime($d->masuk)) }}
                    </td>
                    <td class="text-center">
                      <a href="{{ url('igd/entry-tindakan-transit/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                    </td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalTriage" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" role="form">
              <input type="hidden" name="registrasi_id" value="">
                <div class="form-group">
                  <label for="nama" class="col-md-3">Nama Pasien</label>
                  <div class="col-md-6">
                    <input type="text" readonly class="form-control" id="namaPasien" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="norm" class="col-md-3">No. RM</label>
                  <div class="col-md-6">
                    <input type="text" readonly class="form-control" id="nomorRM" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kondisi" class="col-md-3">False Emergency</label>
                  <div class="col-md-6">
                    <select class="form-control" name="status_ugd">
                      <option value="HTS1">HTS1</option>
                      <option value="HTS2">HTS2</option>
                      <option value="HTS3">HTS3</option>
                      <option value="HTS4">HTS4</option>
                    </select>
                  </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
              <button type="button" onclick="simpanTriage()" class="btn btn-primary btn-flat">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
@stop

@section('script')
  <script type="text/javascript">
    (function blink() {
        $('.blink_me').fadeOut(500).fadeIn(500, blink);
    })();
    function triage(registrasi_id, nama, norm) {
        $('#modalTriage').modal('show');
        $('.modal-title').text('Kondisi Pasien');
        $('#namaPasien').val(nama);
        $('#nomorRM').val(norm);
        $('input[name="registrasi_id"]').val(registrasi_id);
    }
    function simpanTriage() {
        var status_ugd = $('select[name="status_ugd"]').val();
        var registrasi_id = $('input[name="registrasi_id"]').val();
        $.ajax({
            url: '/tindakan/igd/ubah-status-ugd/'+registrasi_id+'/'+status_ugd,
            type: 'GET',
            success: function (data) {
                if(data.sukses == true){
                    $('#modalTriage').modal('hide');
                    location.reload();
                }
            }
        })
    }
  </script>
@endsection
