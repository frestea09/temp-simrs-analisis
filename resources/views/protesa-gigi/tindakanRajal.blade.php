@extends('master')

@section('header')
  <h1>Protesa Gigi - Rawat Jalan </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">Periode Tanggal</h4>
      </div>
      <div class="box-body">

        {!! Form::open(['method' => 'POST', 'url' => 'protesa-gigi/tindakan-rajal', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off', 'onchange'=>'this.form.submit()']) !!}
            </div>
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
                {{-- <th class="text-center" style="vertical-align: middle;">Bangsal</th> --}}
                <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
                <th class="text-center" style="vertical-align: middle;">Proses</th>
                <th class="text-center" style="vertical-align: middle;">Cetak</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($reg as $key => $d)
                  @if (Auth::user()->role()->first()->name == 'protesagigi')
                      @if ( cek_tindakan($d->id, 19) > 0 )
                        <tr class="danger">
                      @else
                        <tr>
                      @endif
                  @endif
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->created_at->format('d-m-Y') }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  {{-- <td>{{ baca_kamar($d->kamar_id) }}</td> --}}
                  <td>{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td class="text-center">
                  {{-- @role(['protesagigi', 'administrator']) --}}
                    <a href="{{ url('protesa-gigi/insert-tindakan/rajal/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN TINDAKAN INI ?')" class="btn btn-sm btn-info btn-flat">
                      <i class="fa fa-refresh"></i>
                    </a>
                  {{-- @endrole --}}
                  </td>
                  <td class="text-center">
                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'P')->count() > 0)
                      <a href="{{ url('protesa-gigi/cetak-tindakan/TJ/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection
