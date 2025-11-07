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
@php
  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">


            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/perencanaan/igd/resume/' . $unit . '/' . $reg->id) }}"
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
                            <h5 class="text-center"><b>E-Resume IGD</b></h5>
                            @php
                                $aswal = @json_decode(@$aswal_igd->fisik, true);
                                $icd10p = baca_icd10(@$icd10Primary_jkn->icd10);

                                $icd10s = [];
                                if(!empty($icd10Secondary_jkn)) {
                                    foreach($icd10Secondary_jkn as $row) {
                                        $icd = baca_icd10($row->icd10);
                                        if(is_array($icd)) {
                                            $icd10s[] = ($icd['kode'] ?? '').' '.($icd['nama'] ?? '');
                                        } else {
                                            $icd10s[] = $icd;
                                        }
                                    }
                                }

                                $icd9 = baca_icd9(@$icd9_jkn->icd9);
                            @endphp
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%;">Anamnesa</td>
                                    <td style="padding: 5px;">
                                        <textarea rows="10" name="form[anamnesa]" class="form-control" >{{@$form['anamnesa'] ?? @$aswal['igdAwal']['riwayatPenyakit']}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pemeriksaan fisik</td>
                                    <td style="padding: 5px;">
                                        <textarea rows="10" name="form[pemeriksaan_fisik]" class="form-control" >{{@$form['pemeriksaan_fisik'] ?? 'Tanda Vital : &#13;&#13;Tekanan Darah :' . @$aswal['igdAwal']['tandaVital']['tekananDarah'] . '&#13;' . 'Nadi :' . @$aswal['igdAwal']['tandaVital']['frekuensiNadi'] . '&#13;' . 'RR :' . @$aswal['igdAwal']['tandaVital']['RR'] . '&#13;' . 'Suhu :' . @$aswal['igdAwal']['tandaVital']['suhu'] . '&#13;' . 'Berat Badan :' . @$aswal['igdAwal']['tandaVital']['BB'] . '&#13;' . 'SPO2 :' . @$aswal['igdAwal']['tandaVital']['spo2']}}&#13;&#13;</textarea>
                                    </td>
                                </tr>
                                @php
                                    $userEdit = (in_array(auth()->user()->id, [1, 567]));
                                @endphp
                                <tr>
                                    <td style="width:40%;">Diagnosa Utama</td>
                                    <td style="padding: 5px;">
                                        <div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                            <input type="text" name="form[diagnosa_utama]" value="{{@$form['diagnosa_utama'] ?? @$aswal['igdAwal']['diagnosa']}}" class="form-control" placeholder="Diagnosa Utama"/>
                                            <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                            <input type="text" name="form[icdx_diagnosa_utama]" id="icdx_diagnosa_utama" value="{{@$form['icdx_diagnosa_utama'] ? @$form['icdx_diagnosa_utama'] : @$icd10p }}" class="form-control" placeholder="ICD X" readonly/>
                                            @if ($userEdit)
                                                <button type="button" class="btn btn-primary" id="editIcdxBtn">Edit</button>
                                                <button type="button" class="btn btn-success" id="saveIcdxBtn">Simpan</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Diagnosa Tambahan</td>
                                    <td style="padding: 5px;" id="diagnosa_tambahan">
                                        <button class="btn btn-flat btn-primary btn-sm" type="button" onclick="cloneDiagnosaTambahan()">
                                            <i class="fa fa-plus"></i> Tambah diagnosa tambahan
                                        </button>

                                        {{-- Diagnosa tambahan utama --}}
                                        <div class="btn-group" role="group" aria-label="..." style="display: flex; margin-top:5px;">
                                            <input type="text" name="form[diagnosa_tambahan]" 
                                                value="{{ @$form['diagnosa_tambahan'] ?? @$cppt->diagnosistambahan }}" 
                                                class="form-control" placeholder="Diagnosa Tambahan"/>
                                            <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                            <input type="text" name="form[icdx_diagnosa_tambahan]" id="icdx_diagnosa_tambahan" 
                                                value="{{ @$form['icdx_diagnosa_tambahan'] ? @$form['icdx_diagnosa_tambahan'] : ($icd10s[0] ?? '') }}" 
                                                class="form-control" placeholder="ICD X" readonly/>
                                            @if ($userEdit)
                                                <button type="button" class="btn btn-primary" id="editIcdxTambahanBtn">Edit</button>
                                                <button type="button" class="btn btn-success" id="saveIcdxTambahanBtn">Simpan</button>
                                            @endif
                                        </div>

                                        {{-- Diagnosa tambahan lainnya --}}
                                        @if (is_array(@$form['tambahan_icdx_diagnosa_tambahan']) && is_array(@$form['tambahan_diagnosa_tambahan']))
                                            {{-- kalau user sudah pernah isi form --}}
                                            @foreach (@$form['tambahan_diagnosa_tambahan'] as $key => $diagnosa_tambahan)
                                                <div class="btn-group" role="group" aria-label="..." style="display: flex; margin-top:5px;">
                                                    <input type="text" name="form[tambahan_diagnosa_tambahan][{{$key}}]" 
                                                        value="{{ @$form['tambahan_diagnosa_tambahan'][$key] }}" 
                                                        class="form-control" placeholder="Diagnosa Tambahan"/>
                                                    <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                                    <input type="text" name="form[tambahan_icdx_diagnosa_tambahan][{{$key}}]" 
                                                        value="{{ @$form['tambahan_icdx_diagnosa_tambahan'][$key] ?? ($icd10s[$key+1] ?? '') }}" 
                                                        class="form-control" placeholder="ICD X"/>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- kalau form kosong, tampilkan semua data dari $icd10s (selain yg pertama karena sudah dipakai di atas) --}}
                                            @foreach ($icd10s as $key => $icd)
                                                @if ($key > 0)
                                                    <div class="btn-group" role="group" aria-label="..." style="display: flex; margin-top:5px;">
                                                        <input type="text" name="form[tambahan_diagnosa_tambahan][{{$key}}]" 
                                                            value="" class="form-control" placeholder="Diagnosa Tambahan"/>
                                                        <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                                        <input type="text" name="form[tambahan_icdx_diagnosa_tambahan][{{$key}}]" 
                                                            value="{{ $icd }}" 
                                                            class="form-control" placeholder="ICD X"/>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Tindakan / Prosedur / Operasi</td>
                                    <td style="padding: 5px;">
                                        <button class="btn btn-flat btn-primary btn-sm" type="button" onclick="cloneTindakanProsedurOperasi()"><i class="fa fa-plus"> Tambah Tindakan / Prosedur / Operasi</i></button>
                                        <div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                            <input type="text" name="form[tindakan]" value="{{@$form['tindakan']}}" class="form-control" placeholder="Tindakan"/>
                                            <button type="button" class="btn btn-default" style="font-size: 12px;">ICD IX</button>
                                            <input type="text" name="form[icdix_tindakan]" id="icdix_tindakan" value="{{@$form['icdix_tindakan'] ? @$form['icdix_tindakan'] : @$icd9 }}" class="form-control" placeholder="ICD IX" readonly/>
                                            @if ($userEdit)
                                                <button type="button" class="btn btn-primary" id="editIcdixBtn">Edit</button>
                                                <button type="button" class="btn btn-success" id="saveIcdixBtn">Simpan</button>
                                            @endif
                                        </div>
                                        @if (is_array(@$form['tambahan_icdix_tindakan']) && is_array(@$form['tambahan_tindakan']))
                                            @foreach (@$form['tambahan_tindakan'] as $key => $tindakan)
                                                <div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                                    <input type="text" name="form[tambahan_tindakan][{{$key}}]" value="{{@$form['tambahan_tindakan'][$key]}}" class="form-control" placeholder="Tindakan / Prosedur / Operasi"/>
                                                    <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                                    <input type="text" name="form[tambahan_icdix_tindakan][{{$key}}]" value="{{@$form['tambahan_icdix_tindakan'][$key]}}" class="form-control" placeholder="ICD IX"/>
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pengobatan</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[pengobatan]" value="{{ @$form['pengobatan'] ? @$form['pengobatan'] : @$aswal['igdAwal']['tindakan_pengobatan'] }}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Cara Pulang</td>
                                    <td style="padding: 5px;">
                                        <select name="form[cara_pulang]" class="select2" style="width: 100%;" required>
                                            <option value="" selected disabled>-- Pilih salah satu --</option>
                                            <option {{@$form['cara_pulang'] == "Izin dokter" ? 'selected' : ''}} value="Izin dokter">Izin dokter</option>
                                            <option {{@$form['cara_pulang'] == "Pindah RS" ? 'selected' : ''}} value="Pindah RS">Pindah RS</option>
                                            <option {{@$form['cara_pulang'] == "APS" ? 'selected' : ''}} value="APS">APS</option>
                                            <option {{@$form['cara_pulang'] == "Melariksan Diri" ? 'selected' : ''}} value="Melariksan Diri">Melarikan Diri</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Kondisi saat pulang</td>
                                    <td style="padding: 5px;">
                                        <select name="form[kondisi_pulang]" class="select2" style="width: 100%;">
                                            <option value="" selected disabled>-- Pilih salah satu --</option>
                                            <option {{@$form['kondisi_pulang'] == "Sembuh" ? 'selected' : ''}} value="Sembuh">Sembuh</option>
                                            <option {{@$form['kondisi_pulang'] == "Perbaikan" ? 'selected' : ''}} value="Perbaikan">Perbaikan</option>
                                            <option {{@$form['kondisi_pulang'] == "Tidak sembuh" ? 'selected' : ''}} value="Tidak sembuh">Tidak sembuh</option>
                                            <option {{@$form['kondisi_pulang'] == "Meninggal" ? 'selected' : ''}} value="Meninggal">Meninggal</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>


                </div>

                @if (!isset($form))
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                @else
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <a href="{{url('cetak-eresume-pasien-igd/pdf/' . $riwayat->id)}}" class="btn btn-warning">Cetak</a>
                        <button class="btn btn-danger">Perbarui</button>
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
            $(document).ready(function () {
            $('#editIcdxBtn').on('click', function () {
                $('#icdx_diagnosa_utama').prop('readonly', false).focus();
                $('#editIcdxBtn').addClass('d-none');
                $('#saveIcdxBtn').removeClass('d-none');
            });
            $('#editIcdxTambahanBtn').on('click', function () {
                $('#icdx_diagnosa_tambahan').prop('readonly', false).focus();
                $('#editIcdxTambahanBtn').addClass('d-none');
                $('#saveIcdxTambahanBtn').removeClass('d-none');
            });
            $('#editIcdixBtn').on('click', function () {
                $('#icdix_tindakan').prop('readonly', false).focus();
                $('#editIcdixBtn').addClass('d-none');
                $('#saveIcdixBtn').removeClass('d-none');
            });

            $('#saveIcdxBtn').on('click', function () {
                updateIcdField('icdx_diagnosa_utama', $('#icdx_diagnosa_utama').val(), '#saveIcdxBtn', '#editIcdxBtn', '#icdx_diagnosa_utama');
            });
            $('#saveIcdxTambahanBtn').on('click', function () {
                updateIcdField('icdx_diagnosa_tambahan', $('#icdx_diagnosa_tambahan').val(), '#saveIcdxTambahanBtn', '#editIcdxTambahanBtn', '#icdx_diagnosa_tambahan');
            });
            $('#saveIcdixBtn').on('click', function () {
                updateIcdField('icdix_tindakan', $('#icdix_tindakan').val(), '#saveIcdixBtn', '#editIcdixBtn', '#icdix_tindakan');
            });

            function updateIcdField(key, value, saveBtn, editBtn, inputField) {
                const emrId = '{{ $riwayat->id ?? '' }}';
                $.ajax({
                    url: '{{ route('emr_resume.update_icd') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: emrId,
                        key: key,
                        value: value,
                    },
                    success: function (res) {
                        alert('ICD berhasil disimpan!');
                        $(inputField).prop('readonly', true);
                        $(editBtn).removeClass('d-none');
                        $(saveBtn).addClass('d-none');
                    },
                    error: function () {
                        alert('Gagal menyimpan!');
                    }
                });
            }
        });
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
                    $(this).prop('disabled', false);
                });

                key++;
                $('#table_terapi').append(row);
            });

            function cloneDiagnosaTambahan() {
                let html = `<div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                <input type="text" name="form[tambahan_diagnosa_tambahan][]" class="form-control" placeholder="Diagnosa Tambahan"/>
                                <button type="button" class="btn btn-default" style="font-size: 12px;">ICD X</button>
                                <input type="text" name="form[tambahan_icdx_diagnosa_tambahan][]" class="form-control" placeholder="ICD X"/>
                            </div>`
                $('#diagnosa_tambahan').append(html);
            }

            function cloneTindakanProsedurOperasi() {
                let html = `<div class="btn-group" role="group" aria-label="..." style="display: flex;">
                                <input type="text" name="form[tambahan_tindakan][]" class="form-control" placeholder="Tindakan / Prosedur / Operasi Tambahan"/>
                                <button type="button" class="btn btn-default" style="font-size: 12px;">ICD IX</button>
                                <input type="text" name="form[tambahan_icdix_tindakan][]" class="form-control" placeholder="ICD IX"/>
                            </div>`
                $('#tindakan_prosedur_operasi').append(html);
            }
        </script>

        
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    @endsection
