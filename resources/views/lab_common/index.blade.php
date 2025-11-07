@extends('master')

@section('header')
  <h1>Pemeriksaan Laboratorium</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
        Cari berdasarkan RM &nbsp;
      </h4>
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'pemeriksaanlabCommon', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        {{-- <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div> --}}

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">No RM</button>
            </span>
              {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required', 'onchange'=>'this.form.submit()','placeholder'=>'Ketik No. RM kemudian ENTER']) !!}
          </div>
        </div>
        {{-- <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div> --}}
        </div>
      {!! Form::close() !!}
      <hr>
      {{-- =================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pasien</th>
              <th>No. RM</th>
              <th>Dokter</th>
              <th>Ruangan</th>
              <th>Tanggal Registrasi</th>
              <th>Cara Bayar</th>
              <th>Input</th>
              <th>Rujukan</th>  
              <th>Cetak</th>
              <th>TTE</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($today as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ @$d->nama }}</td>
                <td>{{ @$d->no_rm}}</td>
                <td>{{ @$d->dpjp }}</td>
                <td>{{ @$d->poli }}</td>
                <td>{{ date('d-m-Y',  strtotime($d->created_at))}}</td>
                <td>{{ @$d->carabayar }}</td>
                <td><a href="{{ url('pemeriksaanlabCommon/create/'.$d->id) }}" target="_blank" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a></td>
                <td>
                  <a href="{{ url('pemeriksaanlab/cetakRujukan/'.$d->id) }}" target="_blank" class="btn btn-sm btn-warning btn-flat"><i class="fa fa fa-print"></i></a>
                </td>
                <td>
                  @if (@count(@$d->hasilLab_patalogi) > 0)
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success">Cetak</button>
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                          @foreach ($d->hasilLab_patalogi as $p)
                              <li><a href="{{ url('pemeriksaanlabCommon/cetak/'.$d->id.'/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank"> {{ $p->created_at }}</a></li>
                          @endforeach
                        </ul>
                    </div>
                  @endif
                </td>
                <td>
                  @if (count(@$d->hasilLab_patalogi) > 0)
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary">TTE</button>
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                          @foreach ($d->hasilLab_patalogi as $p)
                            @if (!empty(json_decode(@$p->tte)->base64_signed_file))
                                <li><a href="{{ url('pemeriksaanlabCommon/cetak/'.$d->id.'/'.$p->id.'?cetak_file_tte=true') }}" class="btn btn-success btn-flat btn-sm" target="_blank"> {{ $p->created_at }}</a></li>
                            @else
                              <li><a href="#" class="btn btn-flat btn-sm" onclick="showTTEModal({{$p->id}})"> {{ $p->created_at }}</a></li>
                            @endif
                          @endforeach
                        </ul>
                    </div>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>

    {{-- Modal TTE Hasil Lab PA--}}
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <form id="form-tte-hasil-lab" action="" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">TTE Hasil Laboratorium Patalogi</h4>
          </div>
          <div class="modal-body row" style="display: grid;">
              {!! csrf_field() !!}
              <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{Auth::user()->pegawai->nik}}" disabled>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Nama:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="dokter" id="dokter" value="{{Auth::user()->pegawai->nama}}" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">NIK:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nik" value="{{substr(Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
              </div>
            </div>
          </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="button-proses-tte-hasil-lab" onclick="prosesTTE()">Proses TTE</button>
          </div>
        </div>
        </form>
    
      </div>
    </div>
@endsection

@section('script')
    <script>
        function showTTEModal(hasil_lab_id) {
          $('#form-tte-hasil-lab').attr('action', '/pemeriksaanlabCommon/tte-hasil-lab/'+hasil_lab_id)
          $('#myModal').modal('show');
        }

        function prosesTTE() {
          $('input').prop('disabled', false)
          $('#form-tte-hasil-lab').submit();
        }
    </script>
@endsection
