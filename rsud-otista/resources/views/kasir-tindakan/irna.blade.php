@extends('master')
@section('header')
  <h1>Kasir Rawat Inap</h1>

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
        Periode Tanggal &nbsp;
      </h4>
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'POST', 'url' => 'kasir/rawatinap', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required','autocomplete'=>'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()' ,'autocomplete'=>'off']) !!}
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
              <th>Ruangan</th>
              <th>Cara Bayar</th>
              <th>Total Tagihan</th>
              <th>Bayar</th>
              <th>Piutang</th>
            </tr>
          </thead>
          <tbody>
            @isset($today)
              @foreach ($today as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->pasien->nama }}</td>
                    <td>{{ $d->pasien->no_rm }}</td>
                    <td>{{ baca_dokter($d->dokter_id) }}</td>
                    <td>{{ baca_kamar($d->kamar_id) }}</td>
                    <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                    <td class="text-right">{{ number_format(total_tagihan($d->id)) }}</td>
                    <td>
                      @if (total_tagihan($d->id) > 0)
                        <a href="{{ url('kasir/rawatinap/bayar/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                      @else
                        <i class="fa fa-check text-success"></i> <span class="text-success"> LUNAS </span>
                        <br>
                        <a href="{{ url('kasir/rawatinap/bayar/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                      @endif
                    </td>
                    <td>
                      @if ($d->bayar <> 1)
                        @if ($d->lunas == 'P')
                          Piutang
                        @else
                          <a href="{{ url('kasir/piutang/'.$d->id) }}" onclick="return confirm('Yakin akan di masukkan piutang?')" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-dollar"></i></a>
                        @endif
                      @endif
                    </td>
                  </tr>
                {{-- @endif --}}
              @endforeach
            @endisset
            @isset($byRM)
              @foreach ($byRM as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->reg_id }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  <td>{{ number_format(total_tagihan($d->id)) }}</td>
                  <td>
                    <a href="{{ url('kasir/rawatinap/bayar/'. $d->regid.'/'.$d->pasienid) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                  </td>
                  <td>
                    @if ($d->bayar <> 1)
                      @if ($d->lunas == 'P')
                        Piutang
                      @else
                        <a href="{{ url('kasir/piutang/'.$d->id) }}" onclick="return confirm('Yakin akan di masukkan piutang?')" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-dollar"></i></a>
                      @endif
                    @endif
                  </td>
                </tr>
              @endforeach
            @endisset

          </tbody>
        </table>
      </div>


    </div>
  </div>

  <!-- jQuery 3 -->
  {{-- <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      setInterval(function () {
        $('#kasirRJ').load("{{ route('kasir.rawatjalan-ajax') }}");
      },5000);
    });

  </script> --}}
@endsection
