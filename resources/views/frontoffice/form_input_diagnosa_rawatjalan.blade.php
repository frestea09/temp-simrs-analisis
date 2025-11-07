@extends('master')
@section('header')
    <h1>Input Diagnosa Rawat Jalan </h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <div class='table-responsive'>
                <table class='table table-bordered table-hover table-condensed'>
                    <tbody>
                        <tr>
                            <th style="width:15%;">No RM</th> <td style="width:30%">{{ $reg->pasien->no_rm }}</td> <th>Alamat</th> <td>{{ $reg->pasien->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Nama </th> <td>{{ $reg->pasien->nama }}</td> <th>Cara Bayar</th> <td>{{ baca_carabayar($reg->jenis_pasien) }}</td>
                        </tr>
                        <tr>
                            <th>Umur</th> <td>{{ hitung_umur($reg->pasien->tgllahir) }}</td> <th>Poli</th> <td>{{ $reg->poli->nama }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th> <td colspan="3">{{ ($reg->pasien->kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa Asesment</th> 
                            
                            <td colspan="3">
                                @isset(json_decode(@$diagnosaAsesment->fisik,true)['diagnosis'])
                                {{json_decode(@$diagnosaAsesment->fisik,true)['diagnosis'] ?? '-'}}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Diagnosa Asesment Tambahan</th> 
                            
                            <td>
                                @isset(json_decode(@$diagnosaAsesment->fisik,true)['diagnosistambahan'])
                                {{json_decode(@$diagnosaAsesment->fisik,true)['diagnosistambahan'] ?? '-'}}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Diagnosa CPPT</th> 
                            <td colspan="3">{{ @$diagnosaCPPT->assesment ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa CPPT Tambahan</th> <td>{{ @$diagnosaCPPT->diagnosistambahan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Hasil Laboratorium</th> 
                            <td>
                                <button type="button" id="hasilLab" data-pasienID="{{ $reg->pasien_id }}"
                                    class="btn btn-danger btn-flat btn-sm">
                                    <i class="fa fa-th-list"></i> Lihat Hasil
                                </button>
                            </td>
                            <th>Hasil Radiologi</th>
                            <td>
                                <button type="button" id="hasilRad" data-pasienID="{{ $reg->pasien_id }}"
                                    class="btn btn-danger btn-flat btn-sm">
                                    <i class="fa fa-th-list"></i> Lihat Hasil
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>Diagnosa Sebelumnya</th> 
                            <td>
                                <button type="button" id="historiDiagnosa" data-pasienID="{{ $reg->pasien_id }}"
                                    class="btn btn-info btn-flat btn-sm">
                                    <i class="fa fa-th-list"></i> Diagnosa Sebelumnya
                                </button>
                            </td>
                            <th>Procedure Sebelumnya</th>
                            <td>
                                <button type="button" id="historiProsedur" data-pasienID="{{ $reg->pasien_id }}"
                                    class="btn btn-info btn-flat btn-sm">
                                    <i class="fa fa-th-list"></i> Prosedur Sebelumnya
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @if($pasien->tgllahir == '')
            <h4 class="text-center">Tanggal lahir pasien belum diisi</h4>
        @else
            {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/simpan_diagnosa_rawatjalan', 'class' => 'form-horizontal']) !!}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($resume != null)
                                        {!! $resume->diagnosa !!}
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($resume != null)
                                        {!! $resume->tindakan !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                {{-- @isset($perawatanicd10)
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-condensed">
                                                <tbody>
                                                @foreach ($perawatanicd10 as $key => $d)
                                                    <tr>
                                                        <td>{{ $d->icd10 }}</td>
                                                        <td>{{ baca_diagnosa($d->icd10) }}</td>
                                                        <td>
                                                            @if ($d->jenis == 'TA')
                                                                (Rawat Jalan)
                                                            @elseif($d->jenis == 'TI')
                                                                (Rawat Inap)
                                                            @else
                                                                (Rawat Darurat)
                                                            @endif
                                                        </td>
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
                                                            @if ($d->jenis == 'TA')
                                                                (Rawat Jalan)
                                                            @elseif($d->jenis == 'TI')
                                                                (Rawat Inap)
                                                            @else
                                                                (Rawat Darurat)
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('frontoffice/hapus-prosedur/'.$d->id.'/'.$reg->id) }}" class="btn btn-flat btn-danger btn-sm" title="hapus"> <i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endisset --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr/>
                        <div class="col-md-6">
                            <h4>Diagnosa</h4>
                            <div class="notification">
                                <span style="color: red; font-weight: bold;"><i>Jika diagnosa utama, checklist checkbox primary <br>
                                    Jika diagnosa tambahan, abaikan checkbox primary</i></span>
                            </div>
                            @for ($i=1; $i <= 5; $i++)
                            <div class="form-group{{ $errors->has('icd10'.$i) ? ' has-error' : '' }}">
                                    {!! Form::label('icd10', 'Diagnosa '.$i, ['class' => 'col-sm-3 control-label']) !!} 
                                    <input type="checkbox" value="Primary" name="kategoriicd10{{$i}}">&nbsp; Primary<br/>
                                <div class="col-sm-9">
                                    <select name="kasus{{$i}}" class="form-control" id="">
                                        <option value="Lama">Lama</option>
                                        <option value="Baru">Baru</option>
                                    </select>
                                    {!! Form::text('icd10'.$i, null, ['class' => 'form-control', 'id'=>'icd10'.$i]) !!}
                                    <small class="text-danger">{{ $errors->first('icd10'.$i) }}</small>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="col-md-6">
                            <h4>Prosedur</h4>
                            @for ($i=1; $i <= 5; $i++)
                                <div class="form-group{{ $errors->has('icd9'.$i) ? ' has-error' : '' }}">
                                    {!! Form::label('icd9'.$i, 'Prosedur '.$i, ['class' => 'col-sm-3 control-label']) !!}
                                    <input type="checkbox" value="Primary" name="kategoriicd9{{$i}}">&nbsp;Primary<br/>
                                    <div class="col-sm-9">
                                        {!! Form::text('icd9'.$i, null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            @endfor
                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            @php
                                $id_kondisi  = @json_decode(@$reg->id_pulang_ss)->leave_condition;
                                $id_pulang   = @json_decode(@$reg->id_pulang_ss)->cara_pulang;
                            @endphp
                            <h4>Data Tambahan</h4>
                            <div class="form-group{{ $errors->has('kondisi_akhir') ? ' has-error' : '' }}">
                                {!! Form::label('kondisi_akhir', 'Kondisi Akhir', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <span><strong>ID SS: </strong> {{@$id_kondisi->id_ss ? @$id_kondisi->id_ss : '-'}}</span>
                                    <select name="kondisi_akhir" class="form-control select2">
                                        <option value="">-- Pilih Kondisi Akhir --</option>
                                        @foreach ($kondisi_akhirs as $kondisi)
                                            <option value="{{ $kondisi->id }}" {{@$id_kondisi->id == $kondisi->id  ? 'selected' : ''}}>{{ $kondisi->namakondisi }} </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('kondisi_akhir') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('cara_pulang') ? ' has-error' : '' }}">
                                {!! Form::label('cara_pulang', 'Cara Pulang', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <span><strong>ID SS: </strong> {{@$id_pulang->id_ss ? @$id_pulang->id_ss : '-'}}</span>
                                    <select name="cara_pulang" class="form-control select2">
                                        <option value="">-- Pilih Cara Pulang --</option>
                                        @foreach ($cara_pulang as $pulang)
                                            <option value="{{ $pulang->id }}" {{@$id_pulang->id == $pulang->id  ? 'selected' : ''}}>{{ $pulang->namakondisi }} </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('cara_pulang') }}</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('posisi_berkas_rm') ? ' has-error' : '' }}">
                                {!! Form::label('posisi_berkas_rm', 'Posisi Berkas', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::select('posisi_berkas_rm', $posisi, null, ['class' => 'form-control select2']) !!}
                                    <small class="text-danger">{{ $errors->first('posisi_berkas_rm') }}</small>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-md-12">
                            <div  style="margin: 10px 0; display:flex; justify-content: end">
                                {{-- <a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" class="btn btn-primary btn-flat"> <i class="fa fa-backward"></i> SELESAI</a> --}}
                                <a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" class="btn btn-warning btn-flat">BATAL</a>
                                {!! Form::submit('Simpan', ['class' => 'btn btn-success btn-flat','onclick'=>'return confirm("Yakin data sudah benar semua?")']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        @endif
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

    {{-- Modal Histori Diagnosa --}}
    <div class="modal fade" id="showHistoriDiagnosa" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Diagnosa Sebelumnya</h4>
                </div>
                <div class="modal-body">
                    <div id="dataHistoriDiagnosa">
                        <div class="spinner-square">
                            <div class="square-1 square"></div>
                            <div class="square-2 square"></div>
                            <div class="square-3 square"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Histori Diagnosa --}}

    {{-- Modal Histori Prosedur --}}
    <div class="modal fade" id="showHistoriProsedur" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Prosedur Sebelumnya</h4>
                </div>
                <div class="modal-body">
                    <div id="dataHistoriProsedur">
                        <div class="spinner-square">
                            <div class="square-1 square"></div>
                            <div class="square-2 square"></div>
                            <div class="square-3 square"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Histori Prosedur --}}
    {{-- Modal Hasil Lab --}}
    <div class="modal fade" id="showHasilLab" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Hasil Laboratorium</h4>
                </div>
                <div class="modal-body">
                    <div id="dataHasilLab">
                        <div class="spinner-square">
                            <div class="square-1 square"></div>
                            <div class="square-2 square"></div>
                            <div class="square-3 square"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Hasil Lab --}}
    {{-- Modal Hasil Rad --}}
    <div class="modal fade" id="showHasilRad" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Hasil Radiologi</h4>
                </div>
                <div class="modal-body">
                    <div id="dataHasilRad">
                        <div class="spinner-square">
                            <div class="square-1 square"></div>
                            <div class="square-2 square"></div>
                            <div class="square-3 square"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Hasil Rad --}}
@endsection
@section('script')
    <script>
        $('.select2').select2();

        $('#historiDiagnosa').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHistoriDiagnosa').modal('show');
            $('#dataHistoriDiagnosa').load("/frontoffice/history-diagnosa/" + id);
        });

        $('#historiProsedur').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHistoriProsedur').modal('show');
            $('#dataHistoriProsedur').load("/frontoffice/history-prosedur/" + id);
        });
        
        $('#hasilLab').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHasilLab').modal('show');
            $('#dataHasilLab').load("/frontoffice/hasil-lab/" + id);
        });
        $('#hasilRad').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHasilRad').modal('show');
            $('#dataHasilRad').load("/frontoffice/hasil-rad/" + id);
        });
    </script>
@endsection