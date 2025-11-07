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
    <h1>Informed Consent</h1>
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
            <form method="POST" action="{{ url('emr-soap/perencanaan/informedConsent/' . $unit . '/' . $reg->id) }}"
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
                            <table class='table-striped table-bordered table-hover table-condensed table'>
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                                        <th class="text-center" style="vertical-align: middle;">User</th>
                                        <th class="text-center" style="vertical-align: middle;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($riwayats) == 0)
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak Ada Riwayat Asessment</td>
                                        </tr>
                                    @endif
                                    @foreach ($riwayats as $riwayat)
                                        <tr>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                            </td>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                {{@baca_user($riwayat->user_id)}}
                                            </td>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                                    class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                <a href="{{url('emr-soap-print-informedConsentPersetujuan/' . $reg->id .'/'. $riwayat->id)}}" target="_blank" class="btn btn-success btn-sm">Persetujuan</a>
                                                <a href="{{url('emr-soap-print-informedConsentPenolakan/' . $reg->id .'/'. $riwayat->id)}}" target="_blank" class="btn btn-danger btn-sm">Penolakan</a>
                                                <a href="{{url('emr-soap-delete/'.$unit .'/'. $reg->id .'/'. $riwayat->id)}}"  class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        {{-- Anamnesis --}}
                        <div class="col-md-12">
                            <h5 class="text-center"><b>Informed Consent</b></h5>
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%;">Tindakan</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[tindakan]" value="{{@$form['tindakan']}}" class="form-control" />
                                        {{-- <select name="form[tindakan][]" class="form-control select2" style="width: 100%;" multiple>
                                            @foreach($tarifs as $id => $nama)
                                                <option value="{{ $nama }}" {{ in_array($nama, @$form['tindakan'] ?? []) ? 'selected' : '' }}>{{ $nama }}</option>
                                            @endforeach
                                        </select> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Dokter Pelaksana Tindakan</td>
                                    <td style="padding: 5px;">
                                        {{-- <input type="text" name="form[dokter_pelaksana_tindakan]" value="{{@$form['dokter_pelaksana_tindakan']}}" class="form-control" /> --}}
                                        <select name="form[dokter_pelaksana_tindakan]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih Salah Satu</option>
                                            @foreach($dokters as $id => $nama)
                                                <option value="{{ $nama }}" {{ @$nama == @$form['dokter_pelaksana_tindakan'] ? 'selected' : '' }}>{{ $nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Pemberi Informasi</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[pemberi_informasi]" value="{{@$form['pemberi_informasi']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Penerima Informasi/Pemberian Persetujuan</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[persetujuan]" value="{{@$form['persetujuan']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Saksi</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[saksi]" value="{{@$form['saksi']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Dokter yang menyatakan</td>
                                    <td style="padding: 5px;">
                                        <select name="form[dokter_yang_menyatakan]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih Salah Satu</option>
                                            @foreach($dokters as $id => $nama)
                                                <option value="{{ $nama }}" {{ @$nama == @$form['dokter_yang_menyatakan'] ? 'selected' : '' }}>{{ $nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Yang menyatakan</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[yang_menyatakan]" value="{{@$form['yang_menyatakan']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Tanggal Lahir (pemberi persetujuan)</td>
                                    <td style="padding: 5px;">
                                        <input type="date" name="form[tanggal_lahir]" value="{{@$form['tanggal_lahir']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Jenis kelamin (pemberi persetujuan)</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[jenis_kelamin]" value="{{@$form['jenis_kelamin']}}" class="form-control" />
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td style="width:40%;">Umur</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[umur]" value="{{@$form['umur']}}" class="form-control" />
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td style="width:40%;">Alamat (pemberi persetujuan)</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="form[alamat]" value="{{@$form['alamat']}}" class="form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%;">Jenis Informasi</td>
                                    <td style="padding: 5px;">
                                        <ol>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][diagnosa_kerja]"
                                                        {{ @$form['jenis_informasi']['diagnosa_kerja'] == 'Diagnosa Kerja' ? 'checked' : '' }}
                                                        type="checkbox" value="Diagnosa Kerja">
                                                    <label class="form-check-label" style="font-weight: 400;">Diagnosa Kerja</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_diagnosa_kerja]" value="{{@$form['jenis_informasi']['isi_diagnosa_kerja']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][diagnosa_banding]"
                                                        {{ @$form['jenis_informasi']['diagnosa_banding'] == 'Diagnosa Banding' ? 'checked' : '' }}
                                                        type="checkbox" value="Diagnosa Banding">
                                                    <label class="form-check-label" style="font-weight: 400;">Diagnosa Banding</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_diagnosa_banding]" value="{{@$form['jenis_informasi']['isi_diagnosa_banding']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][tindakan_dokter]"
                                                        {{ @$form['jenis_informasi']['tindakan_dokter'] == 'Tindakan dokter' ? 'checked' : '' }}
                                                        type="checkbox" value="Tindakan dokter">
                                                    <label class="form-check-label" style="font-weight: 400;">Tindakan Dokter</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_tindakan_dokter]" value="{{@$form['jenis_informasi']['isi_tindakan_dokter']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][indikasi_tindakan]"
                                                        {{ @$form['jenis_informasi']['indikasi_tindakan'] == 'Indikasi Tindakan' ? 'checked' : '' }}
                                                        type="checkbox" value="Indikasi Tindakan">
                                                    <label class="form-check-label" style="font-weight: 400;">Indikasi Tindakan</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_indikasi_tindakan]" value="{{@$form['jenis_informasi']['isi_indikasi_tindakan']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][tata_cara]"
                                                        {{ @$form['jenis_informasi']['tata_cara'] == 'Tata Cara' ? 'checked' : '' }}
                                                        type="checkbox" value="Tata Cara">
                                                    <label class="form-check-label" style="font-weight: 400;">Tata Cara</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_tata_cara]" value="{{@$form['jenis_informasi']['isi_tata_cara']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][tujuan]"
                                                        {{ @$form['jenis_informasi']['tujuan'] == 'Tujuan' ? 'checked' : '' }}
                                                        type="checkbox" value="Tujuan">
                                                    <label class="form-check-label" style="font-weight: 400;">Tujuan</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_tujuan]" value="{{@$form['jenis_informasi']['isi_tujuan']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][risiko_tindakan]"
                                                        {{ @$form['jenis_informasi']['risiko_tindakan'] == 'Risiko Tindakan' ? 'checked' : '' }}
                                                        type="checkbox" value="Risiko Tindakan">
                                                    <label class="form-check-label" style="font-weight: 400;">Risiko Tindakan</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_risiko_tindakan]" value="{{@$form['jenis_informasi']['isi_risiko_tindakan']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][komplikasi]"
                                                        {{ @$form['jenis_informasi']['komplikasi'] == 'Komplikasi' ? 'checked' : '' }}
                                                        type="checkbox" value="Komplikasi">
                                                    <label class="form-check-label" style="font-weight: 400;">Komplikasi</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_komplikasi]" value="{{@$form['jenis_informasi']['isi_komplikasi']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][prognosis]"
                                                        {{ @$form['jenis_informasi']['prognosis'] == 'Prognosis' ? 'checked' : '' }}
                                                        type="checkbox" value="Prognosis">
                                                    <label class="form-check-label" style="font-weight: 400;">Prognosis</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_prognosis]" value="{{@$form['jenis_informasi']['isi_prognosis']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][alternatif_resiko]"
                                                        {{ @$form['jenis_informasi']['alternatif_resiko'] == 'Alternatif dan Resiko' ? 'checked' : '' }}
                                                        type="checkbox" value="Alternatif dan Resiko">
                                                    <label class="form-check-label" style="font-weight: 400;">Alternatif dan Resiko</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_alternatif_resiko]" value="{{@$form['jenis_informasi']['isi_alternatif_resiko']}}" class="form-control" />
                                                </div>
                                            </li>
                                            <li style="width: 100%;">
                                                <div style="width: 100%;">
                                                    <input class="form-check-input"
                                                        name="form[jenis_informasi][lain_lain]"
                                                        {{ @$form['jenis_informasi']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                                                        type="checkbox" value="Lain-lain">
                                                    <label class="form-check-label" style="font-weight: 400;">Lain-lain</label>
                                                    <input type="text" placeholder="Isi informasi" name="form[jenis_informasi][isi_lain_lain]" value="{{@$form['jenis_informasi']['isi_lain_lain']}}" class="form-control" />
                                                </div>
                                            </li>
                                        </ol>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="float: right;">
                                        {{-- <a target="_blank" href="{{ url('/signaturepad/informed-consent/'.@$reg->id) }}" class="btn btn-info btn-sm btn-flat" data-toggle="tooltip" title="ttd pasien"><i class=""></i>Tanda Tangan Pasien</a> |  --}}
                                        <a target="_blank" href="{{ url('/signaturepad/informed-consent-saksi/'.@$reg->id) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" title="ttd saksi"><i class=""></i>Tanda Tangan Saksi</a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <br /><br />
                    </div>


                </div>

                {{-- @if (!isset($form)) --}}
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                {{-- @else
                    <div class="col-md-12 text-right" style="margin-top: 2rem;">
                        <a href="{{url('emr-soap-print-informedConsentPenundaan/' . $reg->id)}}" target="_blank" class="btn btn-warning">Cetak Penundaan</a>
                        <a href="{{url('emr-soap-print-informedConsentPenolakan/' . $reg->id)}}" target="_blank" class="btn btn-danger">Cetak Penolakan</a>
                        <a href="{{url('emr-soap-print-informedConsentPersetujuan/' . $reg->id)}}" target="_blank" class="btn btn-success">Cetak Persetujuan</a>
                        <button class="btn btn-primary">Perbarui</button>
                    </div>
                @endif --}}
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
    @endsection
