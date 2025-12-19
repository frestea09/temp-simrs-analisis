@extends('master')

@section('header')
  <h1>Entry Tindakan </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Rekam Medis &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="row">
                <div class="col-md-2">
                  <h3 class="widget-user-username">Nama</h3>
                  <h5 class="widget-user-desc">No. RM</h5>
                  <h5 class="widget-user-desc">Alamat</h5>
                  <h5 class="widget-user-desc">Cara Bayar</h5>
                </div>
                <div class="col-md-7">
                  <h3 class="widget-user-username">:{{ $pasien->nama}}</h3>
                  <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
                  <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
                  <h5 class="widget-user-desc">: Umum</h5>
                </div>
                <div class="col-md-3 text-center">
                  <h3>Total Tagihan</h3>
                  <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2>
                </div>
              </div>
            </div>
            <div class="widget-user-image">
            </div>
          </div>
          <!-- /.widget-user -->
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class="box box-info">
          <div class="box-body">
            {!! Form::open(['method' => 'POST', 'route' => 'tindakan.save', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('registrasi_id', $reg_id) !!}
            {!! Form::hidden('poli_id', 1) !!}
            {!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
            {!! Form::hidden('pasien_id', $pasien->id) !!}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                    {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('dokter_id', $dokter, null, ['class' => 'chosen-select']) !!}
                        <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                    {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('pelaksana', $dokter, null, ['class' => 'chosen-select']) !!}
                        <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('kategoriheader_id') ? ' has-error' : '' }}">
                    {!! Form::label('kategoriheader_id', 'Kategori', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('kategoriheader_id', $kat_tarif, null, ['class' => 'chosen-select']) !!}
                        <small class="text-danger">{{ $errors->first('kategoriheader_id') }}</small>
                    </div>
                </div>
              </div>
              {{--  --}}
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                    {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="chosen-select" name="tarif_id" id="tarif_id">
                          @foreach ($tindakan as $key => $d)
                            <option value="{{ $d->id }}">{{ $d->nama }} | Rp. {{ number_format($d->total) }} 
                              @if($d->carabayar == 1)
                                <b class="pull-right text-green">&nbsp&nbsp&nbsp&nbsp [ JKN ]</b>
                              @elseif($d->carabayar == 2)
                                <b class="pull-right text-blue">&nbsp&nbsp&nbsp&nbsp [ Umum ]</b>
                              @endif
                            </option>
                          @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                    </div>
                </div>

                <div class="btn-group pull-right">
                    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
                </div>
              </div>
            </div>

            {!! Form::close() !!}
          </div>
        </div>
        {{-- ======================================================================================================================= --}}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Tindakan</th>
                <th>Poli</th>
                <th>Biaya</th>
                <th>Jml</th>
                <th>Total</th>
                <th>DPJP</th>
                <th>Petugas Entry</th>
                <th>Waktu</th>
                <th>Bayar</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($folio as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->tarif->nama }}</td>
                  <td>{{ $d->poli->nama }}</td>
                  <td>{{ number_format($d->tarif->total,0,',','.') }}</td>
                  <td></td>
                  <td>{{ number_format($d->total,0,',','.') }}</td>
                  <td>{{ $d->dokter->nama }}</td>
                  <td>{{ $d->user->name }}</td>
                  <td>{{ $d->created_at }}</td>
                  <td></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        {{ $jenis->status_reg }}
        <div class="pull-right">
          <a href="{{ url('tindakan/verif-rajal/'.$reg_id) }}" onclick="return confirm('Yakin melakukan tindakan ini? cek sekali lagi status kondisi akhir pasien!')" class="btn btn-success btn-sm btn-flat">
            <i class="fa fa-check"></i> SELESAI
          </a>
        </div>
      </div>
    </div>
@stop
