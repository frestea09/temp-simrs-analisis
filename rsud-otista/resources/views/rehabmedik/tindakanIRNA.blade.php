@extends('master')

@section('header')
  <h1>Billing System Rehabilitasi Medik - Rawat Inap </h1>
@endsection

@section('content')
<style>

  .blink_me {
          animation: blinker 2s linear infinite;
          color: orange;
        }
  
        @keyframes blinker {
          50% {
            opacity: 0;
          }
        }
  
  
</style>

    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          Periode Tanggal &nbsp;
        </h4>
      </div>
      <div class="box-body">

        {!! Form::open(['method' => 'POST', 'url' => 'rehabmedik/tindakan-irna', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
            </div>
          </div>
          </div>
        {!! Form::close() !!}
        <hr>

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>Status</th>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>No. RM</th>
                <th>Dokter</th>
                <th>Cara Bayar</th>
                <th>Registrasi</th>
                <th>Proses</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                  @if (Auth::user()->role()->first()->name == 'rehabmedik')
                      @if ( cek_tindakan($d->id, 16) > 0 )
                        <tr class="success">
                      @else
                        <tr>
                      @endif
                  @endif
                  @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'M')->first() == null)
                  <td class="blink_me"> <b>Baru</b> </td>
                  @else
                      <td><b style="color:red">Selesai</b></td>
                  @endif
                  <td>{{ $no++ }}</td>
                  <td>{{ @$d->pasien->nama }}</td>
                  <td>{{ @$d->pasien->no_rm }}</td>

                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td>{{ $d->created_at }}</td>
                  <td width="80px" class="text-center">
                    <a href="{{ url('rehabmedik/entry-tindakan-irna/'. $d->id.'/'.@$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('rehabmedik/rehabIrnaCetak/'.$d->id.'/'.@$d->pasien_id) }}" target="_blank" class="btn btn-sm btn-info btn-flat btn-warning"><i class="fa fa-print"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>


      </div>
    </div>

@stop
