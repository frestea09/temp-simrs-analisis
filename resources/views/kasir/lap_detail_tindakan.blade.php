@extends('master')
@section('header')
  <h1>Rincian Detail Tindakan <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'kasir/laporan-rincian-detail-tindakan', 'class' => 'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                            <small class="text-danger">{{ $errors->first('tga') }}</small>
                        </div>
                        <div class="col-md-1">
                            s/d
                        </div>
                        <div class="col-sm-4">
                            {!! Form::text('tgb', null, ['class' => 'form-control datepicker']) !!}
                            <small class="text-danger">{{ $errors->first('tgb') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('dokter') ? ' has-error' : '' }}">
                        {!! Form::label('dokter', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="dokter">
                                <option value="">[Semua]</option>
                                @foreach (Modules\Pegawai\Entities\Pegawai::all() as $key => $d)
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('dokter') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                        {!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('no_rm', null, ['class' => 'form-control']) !!}
                            <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('jenis_pasien') ? ' has-error' : '' }}">
                        {!! Form::label('jenis_pasien', 'Jenis Pasien', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            <select class="form-control" name="jenis_pasien">
                              @if (!empty($_POST['jenis_pasien']) && $_POST['jenis_pasien'] == 1)
                                <option value="">[Semua]</option>
                                <option value="1" selected>JKN</option>
                                <option value="2">Umum</option>
                              @elseif (!empty($_POST['jenis_pasien']) && $_POST['jenis_pasien'] == 2)
                                <option value="">[Semua]</option>
                                <option value="1">JKN</option>
                                <option value="2" selected>Umum</option>
                              @else
                                <option value="">[Semua]</option>
                                <option value="1">JKN</option>
                                <option value="2">Umum</option>
                              @endif

                            </select>
                            <small class="text-danger">{{ $errors->first('jenis_pasien') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tipe_layanan') ? ' has-error' : '' }}">
                        {!! Form::label('tipe_layanan', 'Tipe Layanan', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('tipe_layanan', [''=>'[Semua]', '1'=>'Reguler', '2'=>'Eksekutif'], null, ['class' => 'chosen-select']) !!}
                            <small class="text-danger">{{ $errors->first('tipe_layanan') }}</small>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('petugas') ? ' has-error' : '' }}">
                        {!! Form::label('petugas', 'Nama Petugas', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('petugas', [], null, ['class' => 'chosen-select']) !!}
                            <small class="text-danger">{{ $errors->first('petugas') }}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-primary btn-flat">Lanjut</button>
                        </div>
                    </div>
                </div>
            </div>

        {!! Form::close() !!}

        <hr>

        @isset($reg)
            <div class='table-responsive'>
              <table class='table table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th class="text-center" style="vertical-align: middle">No</th>
                    <th class="text-center" style="vertical-align: middle">No. RM</th>
                    <th class="text-center" style="vertical-align: middle">Nama</th>
                    <th class="text-center" style="vertical-align: middle">Jenis Pasien</th>
                    <th class="text-center" style="vertical-align: middle">Tipe Layanan</th>
                    <th class="text-center" style="vertical-align: middle">Tindakan</th>
                    <th class="text-center" style="vertical-align: middle">Biaya</th>
                    <th class="text-center" style="vertical-align: middle">Jml</th>
                    <th class="text-center" style="vertical-align: middle">Total Tindakan</th>
                    <th class="text-center" style="vertical-align: middle">Jasa Sarana</th>
                    <th class="text-center" style="vertical-align: middle">Jasa Pelayanan</th>
                    <th class="text-center" style="vertical-align: middle">Jasa Dokter</th>
                    <th class="text-center" style="vertical-align: middle">Dokter</th>
                    <th class="text-center" style="vertical-align: middle">Pelaksana</th>
                    <th class="text-center" style="vertical-align: middle">Poli</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($reg as $key => $d)
                        @php
                            $folio = Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->get();
                        @endphp
                        <tr>
                          <td rowspan="{{ $folio->count() + 1 }}" class="text-center" style="vertical-align: middle">{{ $no++ }} </td>
                          <td rowspan="{{ $folio->count() + 1 }}" class="text-center" style="vertical-align: middle">{{ $d->pasien->no_rm }}</td>
                          <td rowspan="{{ $folio->count() + 1 }}" class="text-center" style="vertical-align: middle">{{ $d->pasien->nama }}</td>
                          <td rowspan="{{ $folio->count() + 1 }}" class="text-center" style="vertical-align: middle">{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? '-'.$d->tipe_jkn : '' }}</td>
                          <td rowspan="{{ $folio->count() + 1 }}" class="text-center" style="vertical-align: middle">
                              @if ($d->tipe_layanan == 1)
                                  Reguler
                              @elseif ($d->tipe_layanan == 2)
                                  Ekeskutif
                              @else
                              @endif
                          </td>
                           <td colspan="3" style="height:1px" class="text-center" style="vertical-align: middle"> </td>
                           <td rowspan="{{ $folio->count() + 1 }}" class="text-center" style="vertical-align: middle">{{ number_format($folio->sum('total')) }} </td>
                        </tr>
                        @foreach ($folio as $key => $f)
                            <tr>
                                <td style="vertical-align: middle">{{ $f->namatarif }}</td>
                                <td style="vertical-align: middle">{{ number_format($f->total) }}</td>
                                <td class="text-center" style="vertical-align: middle">1</td>
                                <td class="text-center" style="vertical-align: middle"></td>
                                <td class="text-center" style="vertical-align: middle"></td>
                                <td class="text-center" style="vertical-align: middle"></td>
                                <td style="vertical-align: middle">{{ baca_dokter($f->dokter_id) }}</td>
                                <td style="vertical-align: middle"></td>
                                <td style="vertical-align: middle">{{ baca_poli($f->poli_id) }}</td>
                            </tr>
                        @endforeach


                    @endforeach
                </tbody>
              </table>
            </div>
        @endisset


    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
