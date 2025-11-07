@extends('master')
@section('header')
    <h1>Input Diagnosa IGD </h1>
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
                            <th>Jenis Kelamin</th> <td>{{ ($reg->pasien->kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa Asesment</th> 
                            
                            <td>
                                @isset(json_decode(@$diagnosaAsesment->fisik,true)['diagnosis'])
                                {{json_decode(@$diagnosaAsesment->fisik,true)['diagnosis']}}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Diagnosa Asesment Tambahan</th> 
                            
                            <td>
                                @isset(json_decode(@$diagnosaAsesment->fisik,true)['diagnosistambahan'])
                                {{json_decode(@$diagnosaAsesment->fisik,true)['diagnosistambahan']}}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Diagnosa CPPT</th> <td>{{ @$diagnosaCPPT->assesment }}</td>
                        </tr>
                        <tr>
                            <th>Diagnosa CPPT Tambahan</th> <td>{{ @$diagnosaCPPT->diagnosistambahan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @if($pasien->tgllahir == '')
            <h4 class="text-center">Tanggal lahir pasien belum diisi</h4>
        @else
            <div class="row">
                <div class="col-md-6">
                    <button type="button" id="historiDiagnosa" data-pasienID="{{ $reg->pasien_id }}"
                        class="btn btn-info btn-flat">
                        <i class="fa fa-th-list"></i> Diagnosa Sebelumnya
                    </button>
                </div>
                <div class="col-md-6">
                    <button type="button" id="historiProsedur" data-pasienID="{{ $reg->pasien_id }}"
                        class="btn btn-info btn-flat">
                        <i class="fa fa-th-list"></i> Prosedur Sebelumnya
                    </button>
                </div>
            </div>
            {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/simpan_diagnosa_igd', 'class' => 'form-horizontal']) !!}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                <div class="row">
                    <div class="col-sm-12">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr/>
                        <div class="col-md-6">
                            <h4>Diagnosa</h4>
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
                            <div class="wrapper-diagnosa">

                            </div>
                            <button type="button" class="add_diagnosa pull-right btn btn-info btn-sm"><i class="fa fa-plus"></i> Tambah Kolom</button><br/>
                            <hr>
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
                                        @if (!$id_kondisi)
                                            <option value="11" selected>Stabil</option>
                                            
                                        @endif
                                        @foreach ($kondisi_akhirs as $kondisi)
                                            <option value="{{ $kondisi->id }}" {{@$id_kondisi->id == $kondisi->id  ? 'selected' : ''}}>{{ $kondisi->namakondisi }} </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('kondisi_akhir') }}</small>
                                    <small class="text-danger">*wajib diisi untuk input ke satusehat</small>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('cara_pulang') ? ' has-error' : '' }}">
                                {!! Form::label('cara_pulang', 'Cara Pulang', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <span><strong>ID SS: </strong> {{@$id_pulang->id_ss ? @$id_pulang->id_ss : '-'}}</span>
                                    <select name="cara_pulang" class="form-control select2">
                                        <option value="">-- Pilih Cara Pulang --</option>
                                        @if (!$id_pulang)
                                            <option value="1" selected>Pulang Atas Persetujuan Dokter</option>
                                            
                                        @endif
                                        @foreach ($cara_pulang as $pulang)
                                            <option value="{{ $pulang->id }}" {{@$id_pulang->id == $pulang->id  ? 'selected' : ''}}>{{ $pulang->namakondisi }} </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('cara_pulang') }}</small>
                                    <small class="text-danger">*wajib diisi untuk input ke satusehat</small>
                                </div>
                            </div>
                            
                        </div>
                        {{-- ======================================================================= --}}
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

                            <div class="wrapper-prosedur">

                            </div>
                            <button type="button" class="add_prosedur pull-right btn btn-danger btn-sm"><i class="fa fa-plus"></i> Tambah Kolom</button><br/>
                            <hr>


                            <div class="form-group{{ $errors->has('posisi_berkas_rm') ? ' has-error' : '' }}">
                                {!! Form::label('posisi_berkas_rm', 'Posisi Berkas', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::select('posisi_berkas_rm', $posisi, null, ['class' => 'form-control select2']) !!}
                                    <small class="text-danger">{{ $errors->first('posisi_berkas_rm') }}</small>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <a href="{{ url('frontoffice/input_diagnosa_igd') }}" class="btn btn-primary btn-flat"> <i class="fa fa-backward"></i> SELESAI</a>
                                <a href="{{ url('frontoffice/input_diagnosa_igd') }}" class="btn btn-warning btn-flat">BATAL</a>
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
@endsection
@section('script')
    <script>
        var max_fields      = 25;
        var wrapper         = $(".wrapper-prosedur"); 
        var wrapper         = $(".wrapper-diagnosa"); 
        var add_button      = $(".add_field_button");
        var remove_button   = $(".remove_field_button");
        var i = 5;

        // DIAGNOSA
        $(".add_diagnosa").click(function(e){
              e.preventDefault();
              // var total_fields = wrapper[0].childNodes.length;
              if(i < max_fields){
                  i++;
                  $(wrapper).append(
                '<div class="form-group">'+
                    '<label class="col-sm-3 control-label">Diagnosa '+i+'</label>'+
                    '<input type="checkbox" value="Primary" name="kategoriicd10'+i+'">&nbsp;Primary<br/>'+
                    '<div class="col-sm-9">'+
                        '<select name="kasus'+i+'" class="form-control" id="">'+
                                        '<option value="Lama">Lama</option>'+
                                        '<option value="Baru">Baru</option>'+
                                    '</select>'+
                        '<input type="text" name="icd10'+i+'" id="icd10'+i+'" class="form-control"/>'+
                    '</div>'+
                '</div>'
                    );
                    icd10(i)
              }
          });

        // PROSEDUR
        $(".add_prosedur").click(function(e){
              e.preventDefault();
              // var total_fields = wrapper[0].childNodes.length;
              if(i < max_fields){
                  i++;
                  $(wrapper).append(
                '<div class="form-group">'+
                    '<label class="col-sm-3 control-label">Prosedur '+i+'</label>'+
                    '<input type="checkbox" value="Primary" name="kategoriicd9'+i+'">&nbsp;Primary<br/>'+
                    '<div class="col-sm-9">'+
                        '<input type="text" name="icd9'+i+'" id="icd9'+i+'" class="form-control"/>'+
                    '</div>'+
                '</div>'
                    );
                    icd9(i)
              }
          });
          $(wrapper).on("click",".remove_field_obat_2", function(e){ //user click on remove text
              console.log($(this));
            //   e.preventDefault(); $(this).closest("tr").remove(); i--;
            })

        $('.select2').select2();
        $( document ).ready(function() {
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

        })

        // ICD 9
        function icd9(i){
            $(document).on('click', '.add'+i, function (e) {
                document.getElementById("icd9"+i).value = $(this).attr('data-nomor');
                $('#icd9').modal('hide');
            });

            //6
            $("input[name='icd9"+i+"']").on('focus', function () {
                $("#dataICD9").DataTable().destroy()
                $("#icd9").modal('show');
                $('#dataICD9').DataTable({
                    pageLength: 10,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: '/icd9/getData/'+i,
                    columns: [
                        // {data: 'rownum', orderable: false, searchable: false},
                        {data: 'id'},
                        {data: 'nomor'},
                        {data: 'nama'},
                        {data: 'add', searchable: false}
                    ]
                });
            });
        }

        // ICD10
        function icd10(i){
            $("input[name='icd10"+i+"']").on('focus', function () {
            $("#dataICD10").DataTable().destroy()
            $("#icd10").modal('show');
            $('#dataICD10').DataTable({
                pageLength: 10,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: '/icd10/getData/'+i,
                columns: [
                    // {data: 'rownum', orderable: false, searchable: false},
                    {data: 'id'},
                    {data: 'nomor'},
                    {data: 'nama'},
                    {data: 'add', searchable: false}
                ]
            });
        });

        $(document).on('click', '.pilih'+i, function (e) {
            document.getElementById("icd10"+i).value = $(this).attr('data-nomor');
            $('#icd10').modal('hide');
        });
        }
    </script>
@endsection