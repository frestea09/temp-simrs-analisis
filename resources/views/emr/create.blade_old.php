@extends('master')

@section('header')
  <h1>Resume Pasien</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div>
    <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

        <div class="row">
            <div class="col-md-12">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active" style="height: 175px;">
                        <div class="row">
                            <div class="col-md-2">
                                <h4 class="widget-user-username">Nama</h4>
                                <h5 class="widget-user-desc">No. RM</h5>
                                <h5 class="widget-user-desc">Alamat</h5>
                                <h5 class="widget-user-desc">Cara Bayar</h5>
                                <h5 class="widget-user-desc">DPJP</h5>
                                <h5 class="widget-user-desc">Kunjungan</h5>
                            </div>
                            <div class="col-md-7">
                                <h3 class="widget-user-username">:{{ $reg->pasien->nama}}</h3>
                                <h5 class="widget-user-desc">: {{ $reg->pasien->no_rm }}</h5>
                                <h5 class="widget-user-desc">: {{ $reg->pasien->alamat}}</h5>
                                <h5 class="widget-user-desc">: {{ baca_carabayar($reg->bayar) }} </h5>
                                <h5 class="widget-user-desc">: {{ baca_dokter($reg->dokter_id)}}</h5>
                                <h5 class="widget-user-desc">: {{ ($reg->jenis_pasien == 1) ? 'Baru' : 'Lama' }}</h5>
                            </div>
                            <div class="col-md-3 text-center">
                                {{--  <h3>Total Tagihan</h3>
                                <h2 style="margin-top: -5px;">Rp. </h2>  --}}
                            </div>
                        </div>
                    </div>
                    <div class="widget-user-image">

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ url('save-resume-medis') }}" class="form-horizontal">
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                    <div class="form-group">
                        <label for="darah" class="col-md-2 control-label">Tekanan Darah</label>
                        <div class="col-md-3">
                            <input type="text" name="tekanandarah" value="{{ !empty($resume) ? $resume->tekanandarah : NULL }}" class="form-control" autocomplete="off" required>
                            <small class="text-danger">{{ $errors->first('tekanandarah') }}</small>
                        </div>
                        <label for="bb" class="col-md-2 control-label">Berat Badan</label>
                        <div class="col-md-3">
                            <input type="text" name="bb" value="{{ !empty($resume) ? $resume->bb : NULL }}" class="form-control" autocomplete="off" required>
                            <small class="text-danger">{{ $errors->first('bb') }}</small>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">
                        {!! Form::label('kondisi', 'Kondisi Akhir', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::select('kondisi', $kondisi, ($resume) ?  $resume->keterangan : NULL, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                            <small class="text-danger">{{ $errors->first('kondisi') }}</small>
                        </div>
                    </div>
                    <br>
                    <table style="width: 100%">
                        <tr>
                            <th style="width: 50%" class="text-center">Diagnosa </th>
                            <th style="width: 50%" class="text-center">Tindakan</th>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <small class="text-danger text-center">{{ $errors->first('diagnosa') }}</small>
                                <textarea name="diagnosa" required>{{ !empty($resume) ? $resume->diagnosa : NULL }}</textarea>
                            </td>
                            <td style="padding: 5px;">
                                <small class="text-danger text-center">{{ $errors->first('tindakan') }}</small>
                                <textarea name="tindakan" required>{{ !empty($resume) ? $resume->tindakan : NULL }}</textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                    </div>
                </form>
                <hr/>
                <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', $reg->id) !!}
                  {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                  {{--  <div class="form-group">
                      <label for="darah" class="col-md-2 control-label">Tekanan Darah</label>
                      <div class="col-md-3">
                          <input type="text" name="tekanandarah" value="{{ !empty($resume) ? $resume->tekanandarah : NULL }}" class="form-control" autocomplete="off">
                          <small class="text-danger">{{ $errors->first('tekanandarah') }}</small>
                      </div>
                      <label for="bb" class="col-md-2 control-label">Berat Badan</label>
                      <div class="col-md-3">
                          <input type="text" name="bb" value="{{ !empty($resume) ? $resume->bb : NULL }}" class="form-control" autocomplete="off">
                          <small class="text-danger">{{ $errors->first('bb') }}</small>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('kondisi') ? ' has-error' : '' }}">
                      {!! Form::label('kondisi', 'Kondisi Akhir', ['class' => 'col-sm-2 control-label']) !!}
                      <div class="col-sm-3">
                          {!! Form::select('kondisi', $kondisi, ($resume) ?  $resume->keterangan : NULL, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                          <small class="text-danger">{{ $errors->first('kondisi') }}</small>
                      </div>
                  </div>  --}}
                  <br>
                  {{--  <table style="width: 100%">
                      <tr>
                          <th style="width: 50%" class="text-center">Diagnosa </th>
                          <th style="width: 50%" class="text-center">Tindakan</th>
                      </tr>
                      <tr>
                          <td style="padding: 5px;">
                            <small class="text-danger text-center">{{ $errors->first('diagnosa') }}</small>
                            <textarea name="diagnosa">{{ !empty($resume) ? $resume->diagnosa : NULL }}</textarea>
                          </td>
                          <td style="padding: 5px;">
                            <small class="text-danger text-center">{{ $errors->first('tindakan') }}</small>
                            <textarea name="tindakan">{{ !empty($resume) ? $resume->tindakan : NULL }}</textarea>
                          </td>
                      </tr>
                  </table>  --}}
                    {{--  <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                    </div>  --}}
                    {{-- <div class="col-sm-12">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Diagnosa Sebelumnya</h4>
                                    @if($resume != null)
                                        {!! $resume->diagnosa !!}
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h4>Prosedur Sebelumnya</h4>
                                    @if($resume != null)
                                        {!! $resume->tindakan !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                @isset($perawatanicd10)
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-condensed">
                                                <tbody>
                                                @foreach ($perawatanicd10 as $key => $d)
                                                    <tr>
                                                        <td>{{ $d->icd10 }}</td>
                                                        <td>{{ baca_diagnosa($d->icd10) }}</td>
                                                        <td>
                                                            <a href="{{ url('frontoffice/hapus-diagnosa/'.$d->id.'/'.$reg->id) }}" class="btn btn-flat btn-danger btn-sm" title="hapus"> <i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endisset
                                @isset($perawatanicd9)
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-condensed">
                                                <tbody>
                                                @foreach ($perawatanicd9 as $key => $d)
                                                    <tr>
                                                        <td>{{ $d->icd9 }}</td>
                                                        <td>{{ baca_prosedur($d->icd9) }} </td>
                                                        <td>
                                                            <a href="{{ url('frontoffice/hapus-prosedur/'.$d->id.'/'.$reg->id) }}" class="btn btn-flat btn-danger btn-sm" title="hapus"> <i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-sm-12">
                        <hr/>
                        <div class="col-md-6">
                            <h4>Diagnosa</h4>
                            @for ($i=1; $i <= 5; $i++)
                            <div class="form-group{{ $errors->has('icd10'.$i) ? ' has-error' : '' }}">
                                {!! Form::label('icd10', 'Diagnosa '.$i, ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::text('icd10'.$i, null, ['class' => 'form-control', 'autocomplete' => 'off', 'id'=>'icd10'.$i]) !!}
                                    <small class="text-danger">{{ $errors->first('icd10'.$i) }}</small>
                                </div>
                            </div>
                            @endfor
                            <hr>
                            <div class="form-group{{ $errors->has('status_kondisi') ? ' has-error' : '' }}">
                                {!! Form::label('status_kondisi', 'Kondisi Pasien', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::select('status_kondisi', $kondisi, null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                    <small class="text-danger">{{ $errors->first('status_kondisi') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Prosedur</h4>
                            @for ($i=1; $i <= 5; $i++)
                                <div class="form-group{{ $errors->has('icd9'.$i) ? ' has-error' : '' }}">
                                    {!! Form::label('icd9'.$i, 'Prosedur '.$i, ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('icd9'.$i, null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            @endfor
                            <hr>
                            <div class="form-group{{ $errors->has('posisi_berkas_rm') ? ' has-error' : '' }}">
                                {!! Form::label('posisi_berkas_rm', 'Posisi Berkas', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::select('posisi_berkas_rm', $posisi, null, ['class' => 'form-control select2']) !!}
                                    <small class="text-danger">{{ $errors->first('posisi_berkas_rm') }}</small>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <a href="{{ url('rawat-inap/billing') }}" class="btn btn-primary btn-flat"> <i class="fa fa-backward"></i> SELESAI</a>
                                <a href="{{ url('rawat-inap/billing') }}" class="btn btn-warning btn-flat">BATAL</a>
                                {!! Form::submit('Simpan', ['class' => 'btn btn-success btn-flat','onclick'=>'return confirm("Yakin data sudah benar semua?")']) !!}
                            </div>
                        </div>
                    </div> --}}
                </form>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <h3>Resume Medis</h3>
                        <a href="{{ url('cetak-resume-medis/'.$reg->id) }}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a>
                        <a href="{{ url('cetak-resume-medis/pdf/'.$reg->id) }}" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
                        <table class="table table-bordered" id="data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tekanan Darah</th>
                                    <th>Berat Badan</th>
                                    <th>Diagnosa</th>
                                    <th>Tindakan</th>
                                    {{-- <th class="text-center">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $all_resume as $key_a => $val_a )
                                <tr>
                                    <td>{{ ($key_a + 1) }}</td>
                                    <td>{{ $val_a->tekanandarah }}</td>
                                    <td>{{ $val_a->bb }}</td>
                                    <td>{!! $val_a->diagnosa !!}</td>
                                    <td>{!! $val_a->tindakan !!}</td>
                                    {{-- <td class="text-center">
                                        
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="modal fade" id="icd9" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD9</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD9' class='table table-striped table-bordered table-hover table-condensed'>
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>Nama</th>
                                  <th>Add</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  
  <div class="modal fade" id="icd10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="">Data ICD10</h4>
              </div>
              <div class="modal-body">
                  <div class='table-responsive'>
                      <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>Nama</th>
                                  <th>Add</th>
                              </tr>
                          </thead>
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
        $('.select2').select2();
        CKEDITOR.replace( 'diagnosa', {
                height: 200,
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
            });
        CKEDITOR.replace( 'tindakan', {
                height: 200,
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
            });
    </script>
@endsection
