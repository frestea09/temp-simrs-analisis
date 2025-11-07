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
            <form method="POST" action="{{ url('emr-soap/perencanaan/inap/surat-dpjp/' . $unit . '/' . $reg->id) }}"
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
                        <div class="col-md-12">
                            <h4 class="text-center"><b>SURAT PERNYATAAN DPJP</b></h4>
                            <ul class="nav nav-tabs">
                                <li class="active"><a style="font-size: 12px;" data-toggle="tab" href="#pernyataan_dpjp"><b>Surat Pernyataan DPJP</b></a></li>
                                <li><a style="font-size: 12px;" data-toggle="tab" href="#pengalihan_dpjp"><b>Surat Pengalihan DPJP</b></a></li>
                                <li><a style="font-size: 12px;" data-toggle="tab" href="#rawat_bersama"><b>Surat Rawat Bersama</b></a></li>
                            </ul>
                            
                              <div class="tab-content">
                                <div id="pernyataan_dpjp" class="tab-pane fade in active">
                                  <h5 class="text-center"><b>Surat Pernyataan DPJP</b></h5>
                                  <div class="row">
                                    <div class="col-md-12">
                                        <table style="width: 100%"
                                            class="table-striped table-bordered table-hover table-condensed form-box table"
                                            style="font-size:12px;">
                                            <p>Yang bertandatangan di bawah ini :</p>
                                            <tr>
                                                <td style="width:40%;"><b>Nama</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[pernyataan_dpjp][nama]" value="{{@$form['pernyataan_dpjp']['nama'] ?? Auth::user()->pegawai->nama}}" class="form-control" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%;"><b>Bidang kewenangan klinis</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[pernyataan_dpjp][bidang_kewenangan_klinis]" value="{{@$form['pernyataan_dpjp']['bidang_kewenangan_klinis']}}" class="form-control" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%;"><b>SMF</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[pernyataan_dpjp][smf]" value="{{@$form['pernyataan_dpjp']['smf']}}" class="form-control" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                  </div>
                                </div>
                                <div id="pengalihan_dpjp" class="tab-pane fade">
                                  <h5 class="text-center"><b>Surat Pengalihan DPJP</b></h5>
                                  <div class="row">
                                    <div class="col-md-12">
                                        <table style="width: 100%"
                                            class="table-striped table-bordered table-hover table-condensed form-box table"
                                            style="font-size:12px;">
                                            <p>Yang bertandatangan di bawah ini, dengan ini mengalihkan pasien kepada :</p>
                                            <tr>
                                                <td style="width:40%;"><b>Nama</b></td>
                                                <td style="padding: 5px;">
                                                    <select name="form[pengalihan_dpjp][nama]" class="select2" style="width: 100%;">
                                                        <option value="" selected disabled>-- Pilih salah satu --</option>
                                                        @foreach ($dokter as $dok)
                                                            <option value="{{$dok->nama}}" {{@$form['pengalihan_dpjp']['nama'] == $dok->nama ? 'selected' : ''}}>{{$dok->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%;"><b>Bidang kewenangan klinis</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[pengalihan_dpjp][bidang_kewenangan_klinis]" value="{{@$form['pengalihan_dpjp']['bidang_kewenangan_klinis']}}" class="form-control" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%;"><b>SMF</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[pengalihan_dpjp][smf]" value="{{@$form['pengalihan_dpjp']['smf']}}" class="form-control" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%;"><b>Alasan</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[pengalihan_dpjp][alasan]" value="{{@$form['pengalihan_dpjp']['alasan']}}" class="form-control" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                  </div>
                                </div>
                                <div id="rawat_bersama" class="tab-pane fade">
                                  <h5 class="text-center"><b>Surat Rawat Bersama</b></h5>
                                  <div class="row">
                                    <div class="col-md-12">
                                        <table style="width: 100%"
                                            class="table-striped table-bordered table-hover table-condensed form-box table"
                                            style="font-size:12px;">
                                            <p>Yang bertandatangan di bawah ini, dengan ini mengalihkan pasien kepada :</p>
                                            <tr>
                                                <td style="width:40%;"><b>Nama</b></td>
                                                <td style="padding: 5px;">
                                                    <select name="form[rawat_bersama][nama]" class="select2" style="width: 100%;">
                                                        <option value="" selected disabled>-- Pilih salah satu --</option>
                                                        @foreach ($dokter as $dok)
                                                            <option value="{{$dok->nama}}" {{@$form['rawat_bersama']['nama'] == $dok->nama ? 'selected' : ''}}>{{$dok->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%;"><b>Bidang kewenangan klinis</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[rawat_bersama][bidang_kewenangan_klinis]" value="{{@$form['rawat_bersama']['bidang_kewenangan_klinis']}}" class="form-control" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%;"><b>SMF</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[rawat_bersama][smf]" value="{{@$form['rawat_bersama']['smf']}}" class="form-control" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%;"><b>Alasan</b></td>
                                                <td style="padding: 5px;">
                                                    <input type="text" name="form[rawat_bersama][alasan]" value="{{@$form['rawat_bersama']['alasan']}}" class="form-control" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
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
                        <a href="{{url('emr-soap-print-surat-dpjp/' . $unit . '/' . $reg->id . '/' . @$riwayat->id)}}" class="btn btn-warning">Cetak Semua</a>
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
            let key= $('.daftar_terapi').length + 1;
            $('#tambah_terapi').click(function (e) {
                let row = $('#daftar_terapi_template').clone();
                row.removeAttr('id').removeAttr('style');
                row.find('td:first').text(key);

                row.find('input[name^="form[terapi_pulang]"]').each(function() {
                    let newName = $(this).attr('name').replace(/\d+/, key);
                    $(this).attr('name', newName);
                });

                key++;
                $('#table_terapi').append(row);
            });
        </script>
    @endsection
