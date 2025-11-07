@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 20px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .border {
        border: 1px solid black;
    }

    .bold {
        font-weight: bold;
    }

    .p-1 {
        padding: 1rem;
    }
</style>
@section('header')
    <h1>E-Resume Rawat Inap</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">


            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/perencanaan/inap/lembar-observasi-obgyn/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        <br>
                        {{-- Anamnesis --}}
                        <div class="col-md-12">
                            <h5 class="text-center"><b>Lembar Observasi Obgyn</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%;">Nama</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[nama]" value="{{@$form['nama']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Diagnosis medis</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[diagnosis_medis]" value="{{@$form['diagnosis_medis']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">DPJP</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[dpjp]" value="{{@$form['dpjp']}}" class="form-control" />
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <div style="display: flex; justify-content:end; margin-bottom: 1rem;">
                                <button type="button" class="btn btn-primary btn-sm btn-flat" id="tambah_lembar_observasi"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                            <table class="border" style="width: 100%;" id="table_terapi">
                                {{-- Template Row Table --}}
                                <tr class="border" id="lembar_observasi_template" style="display: none;">
                                    <td class="border bold p-1 text-center">
                                        <input type="date" name="form[lembar_observasi][1][tanggal]" value="" class="form-control" disabled />
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="time" name="form[lembar_observasi][1][jam]" value="" class="form-control" disabled />
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[lembar_observasi][1][tensi]" value="" class="form-control" disabled />
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[lembar_observasi][1][nadi]" value="" class="form-control" disabled />
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[lembar_observasi][1][respirasi]" value="" class="form-control" disabled />
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[lembar_observasi][1][suhu]" value="" class="form-control" disabled />
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[lembar_observasi][1][tindakan]" value="" class="form-control" disabled />
                                    </td>
                                    <td class="border bold p-1 text-center">
                                        <input type="text" name="form[lembar_observasi][1][nama_perawat]" value="" class="form-control" disabled />
                                    </td>
                                </tr>
                                {{-- End Template Row Table --}}
                                <tr class="border">
                                    <td class="border bold p-1 text-center">TGL</td>
                                    <td class="border bold p-1 text-center">JAM</td>
                                    <td class="border bold p-1 text-center">TENSI</td>
                                    <td class="border bold p-1 text-center">NADI</td>
                                    <td class="border bold p-1 text-center">RESPIRASI</td>
                                    <td class="border bold p-1 text-center">SUHU</td>
                                    <td class="border bold p-1 text-center">TINDAKAN</td>
                                    <td class="border bold p-1 text-center">NAMA PERAWAT</td>
                                </tr>
                                @if (isset($form['lembar_observasi']))
                                  @foreach ($form['lembar_observasi'] as $key => $obat)
                                    <tr class="border lembar_observasi">
                                        <td class="border bold p-1 text-center">
                                            <input type="date" name="form[lembar_observasi][{{$key}}][tanggal]" value="{{$obat['tanggal']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="time" name="form[lembar_observasi][{{$key}}][jam]" value="{{$obat['jam']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[lembar_observasi][{{$key}}][tensi]" value="{{$obat['tensi']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[lembar_observasi][{{$key}}][nadi]" value="{{$obat['nadi']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[lembar_observasi][{{$key}}][respirasi]" value="{{$obat['respirasi']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[lembar_observasi][{{$key}}][suhu]" value="{{$obat['suhu']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[lembar_observasi][{{$key}}][tindakan]" value="{{$obat['tindakan']}}" class="form-control" />
                                        </td>
                                        <td class="border bold p-1 text-center">
                                            <input type="text" name="form[lembar_observasi][{{$key}}][nama_perawat]" value="{{$obat['nama_perawat']}}" class="form-control" />
                                        </td>
                                    </tr>
                                  @endforeach
                                @endif
                            </table>
                        </div>

                        <br /><br />
                    </div>


                </div>

                @if (!isset($form))
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                @else
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <button class="btn btn-danger">Perbarui</button>
                        <a href="{{url('emr-soap/pemeriksaan/cetak_observasi_obgyn') . '/' . $reg->id}}" class="btn btn-warning">Cetak</a>
                    </div>
                @endif
            </form>
            <br />
            <br />

        </div>
    
        </div>
    @endsection

    @section('script')
        <script type="text/javascript">
            //ICD 10
            $('.select2').select2();
            $("input[name='diagnosa_awal']").on('focus', function() {
                $("#dataICD10").DataTable().destroy()
                $("#ICD10").modal('show');
                $('#dataICD10').DataTable({
                    "language": {
                        "url": "/json/pasien.datatable-language.json",
                    },

                    pageLength: 10,
                    autoWidth: false,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: '/sep/geticd9',
                    columns: [
                        // {data: 'rownum', orderable: false, searchable: false},
                        {
                            data: 'id'
                        },
                        {
                            data: 'nomor'
                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'add',
                            searchable: false
                        }
                    ]
                });
            });

            $(document).on('click', '.addICD', function(e) {
                document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
                $('#ICD10').modal('hide');
            });
            $(".skin-red").addClass("sidebar-collapse");
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href") // activated tab
                // alert(target);
            });
            $("#date_tanpa_tanggal").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });
            $("#date_dengan_tanggal").attr('required', true);
        </script>
        <script>
            let key= $('.lembar_observasi').length + 1;
            $('#tambah_lembar_observasi').click(function (e) {
                let row = $('#lembar_observasi_template').clone();
                row.removeAttr('id').removeAttr('style');

                row.find('input[name^="form[lembar_observasi]"]').each(function() {
                    let newName = $(this).attr('name').replace(/\d+/, key);
                    $(this).attr('name', newName);
                    $(this).prop('disabled', false);
                });

                key++;
                $('#table_terapi').append(row);
            });
        </script>
    @endsection
