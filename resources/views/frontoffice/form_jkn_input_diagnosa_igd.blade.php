@extends('master')
@section('header')
    <h1>Input Diagnosa IGD <b>(Khusus JKN)</b></h1>
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
                            @php
                                $diagnosa_resume = App\EmrResume::where('registrasi_id', $reg->id)->where('type','resume-igd')->orderBy('id','DESC')->first();
                            @endphp
                            <th>Diagnosa Resume</th> 
                            <td colspan="3">
                                @isset(json_decode(@$diagnosa_resume->content,true)['diagnosa_utama'])
                                {{json_decode(@$diagnosa_resume->content,true)['diagnosa_utama'] ?? '-'}}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Diagnosa Resume Tambahan</th> 
                            <td>
                                @isset(json_decode(@$diagnosa_resume->content,true)['diagnosa_tambahan'])
                                {{json_decode(@$diagnosa_resume->content,true)['diagnosa_tambahan'] ?? '-'}}
                                @endisset
                            </td>
                        </tr>
                        {{-- <tr>
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
                        </tr> --}}
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
                        <tr>
                            <th>Diagnosa JKN</th> 
                            <td>
                                <button type="button" id="historiDiagnosaJkn" data-pasienID="{{ $reg->pasien_id }}"
                                    class="btn btn-info btn-flat btn-sm">
                                    <i class="fa fa-th-list"></i> Diagnosa JKN Sebelumnya
                                </button>
                            </td>
                            <th>Procedure JKN</th>
                            <td>
                                <button type="button" id="historiProsedurJkn" data-pasienID="{{ $reg->pasien_id }}"
                                    class="btn btn-info btn-flat btn-sm">
                                    <i class="fa fa-th-list"></i> Prosedur JKN Sebelumnya
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @if($pasien->tgllahir == '')
            <h4 class="text-center">Tanggal lahir pasien belum diisi</h4>
        @else
            {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/jkn-simpan-diagnosa-igd', 'class' => 'form-horizontal']) !!}
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
                                    <select name="icd10{{$i}}" id="icd10{{$i}}" class="form-control select2"></select>
                                    {{-- {!! Form::text('icd10'.$i, null, ['class' => 'form-control', 'id'=>'icd10'.$i]) !!} --}}
                                    <small class="text-danger">{{ $errors->first('icd10'.$i) }}</small>
                                </div>
                            </div>
                            @endfor
                            <div class="wrapper-diagnosa">

                            </div>
                            <button type="button" class="add_diagnosa pull-right btn btn-danger btn-sm"><i class="fa fa-plus"></i> Tambah Kolom</button><br/>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <h4>Prosedur</h4>
                            @for ($i=1; $i <= 5; $i++)
                                <div class="form-group{{ $errors->has('icd9'.$i) ? ' has-error' : '' }}">
                                    {!! Form::label('icd9'.$i, 'Prosedur '.$i, ['class' => 'col-sm-3 control-label']) !!}
                                    <input type="checkbox" value="Primary" name="kategoriicd9{{$i}}">&nbsp;Primary<br/>
                                    <div class="col-sm-9">
                                        <select name="icd9{{$i}}" id="icd9{{$i}}" class="form-control select2"></select>
                                        {{-- {!! Form::text('icd9'.$i, null, ['class' => 'form-control']) !!} --}}
                                    </div>
                                </div>
                            @endfor
                            <div class="wrapper-prosedur">

                            </div>
                            <button type="button" class="add_prosedur pull-right btn btn-info btn-sm"><i class="fa fa-plus"></i> Tambah Kolom</button><br/>
                            <hr>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                           
                        </div>
                        <div class="col-md-12">
                            <div  style="margin: 10px 0; display:flex; justify-content: end">
                                <a href="{{ url('frontoffice/antrian-realtime') }}" class="btn btn-warning btn-flat">BATAL</a>
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

    {{-- Modal Histori Diagnosa JKN --}}
    <div class="modal fade" id="showHistoriDiagnosaJkn" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Diagnosa JKN Sebelumnya</h4>
                </div>
                <div class="modal-body">
                    <div id="dataHistoriDiagnosaJkn">
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
    {{-- End Modal Histori Diagnosa JKN --}}

    {{-- Modal Histori Prosedur JKN --}}
    <div class="modal fade" id="showHistoriProsedurJkn" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Prosedur JKN Sebelumnya</h4>
                </div>
                <div class="modal-body">
                    <div id="dataHistoriProsedurJkn">
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
    {{-- End Modal Histori Prosedur JKN --}}

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
        var max_fields      = 25;
        var wrapper_prosedur         = $(".wrapper-prosedur"); 
        var wrapper         = $(".wrapper-diagnosa"); 
        var add_button      = $(".add_field_button");
        var remove_button   = $(".remove_field_button");
        var a = 5;
        var b = 5;

        // DIAGNOSA
        $(".add_diagnosa").click(function(e){
              e.preventDefault();
              // var total_fields = wrapper[0].childNodes.length;
              if(a < max_fields){
                a++;
                  $(wrapper).append(
                '<div class="form-group">'+
                    '<label class="col-sm-3 control-label">Diagnosa '+a+'</label>'+
                    '<input type="checkbox" value="Primary" name="kategoriicd10'+a+'">&nbsp;Primary<br/>'+
                    '<div class="col-sm-9">'+
                        '<select name="kasus'+a+'" class="form-control" id="">'+
                                        '<option value="Lama">Lama</option>'+
                                        '<option value="Baru">Baru</option>'+
                                    '</select>'+
                        '<input type="text" name="icd10'+a+'" id="icd10'+a+'" class="form-control"/>'+
                    '</div>'+
                '</div>'
                    );
                    icd10(a)
              }
          });

        // PROSEDUR
        $(".add_prosedur").click(function(e){
              e.preventDefault();
              if(b < max_fields){
                  b++;
                  $(wrapper_prosedur).append(
                '<div class="form-group">'+
                    '<label class="col-sm-3 control-label">Prosedur '+b+'</label>'+
                    '<input type="checkbox" value="Primary" name="kategoriicd9'+b+'">&nbsp;Primary<br/>'+
                    '<div class="col-sm-9">'+
                        '<input type="text" name="icd9'+b+'" id="icd9'+b+'" class="form-control"/>'+
                    '</div>'+
                '</div>'
                    );
                    icd9(b)
              }
          });
          $(wrapper).on("click",".remove_field_obat_2", function(e){ //user click on remove text
              console.log($(this));
            
            })
        $('.select2').select2();
        for(i = 1; i <= 5; i++) { 
            $('#icd10'+i).select2({
                    placeholder: "Klik untuk cari Diagnosa",
                    width: '100%',
                    ajax: {
                        url: '/frontoffice/ajax_icd10',
                        dataType: 'json',
                        data: function(params) {
                            return {
                                j: 1,
                                q: $.trim(params.term)
                            };
                        },
                        escapeMarkup: function(markup) {
                            return markup;
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                })
        
        }
        for(i = 1; i <= 5; i++) { 
            $('#icd9'+i).select2({
                    placeholder: "Klik untuk cari Prosedur",
                    width: '100%',
                    ajax: {
                        url: '/frontoffice/ajax_icd9',
                        dataType: 'json',
                        data: function(params) {
                            return {
                                j: 1,
                                q: $.trim(params.term)
                            };
                        },
                        escapeMarkup: function(markup) {
                            return markup;
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                })
        
        }
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

        $('#historiDiagnosaJkn').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHistoriDiagnosaJkn').modal('show');
            $('#dataHistoriDiagnosaJkn').load("/frontoffice/history-diagnosa-jkn/" + id);
        });

        $('#historiProsedurJkn').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHistoriProsedurJkn').modal('show');
            $('#dataHistoriProsedurJkn').load("/frontoffice/history-prosedur-jkn/" + id);
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