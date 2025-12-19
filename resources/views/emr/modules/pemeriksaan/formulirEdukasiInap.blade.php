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

    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }

    .select2-selection__rendered {
        padding-left: 20px !important;
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
</style>
@section('header')
    <h1>Formulir Edukasi Pasien Dan Keluarga</h1>
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
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/formulir-edukasi/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                          <h4 style="text-align: center; padding: 10px"><b>Formulir Edukasi Pasien dan Keluarga</b></h4>
                        <br>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table class='table table-striped table-bordered table-hover table-condensed' >
                            <thead>
                                <tr>
                                <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                                </tr>
                                <tr>
                                <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                                <th class="text-center" style="vertical-align: middle;">Terakhir Update</th>
                                <th class="text-center" style="vertical-align: middle;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            @if (count($riwayats) == 0)
                                <tr>
                                    <td colspan="3" class="text-center">Tidak Ada Riwayat Formulir</td>
                                </tr>
                            @endif
                            @foreach ($riwayats as $riwayat)
                                <tr>
                                    <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                        {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                                    </td>
                                    <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                        {{ date('d-m-Y H:i', strtotime(@$riwayat->updated_at)) }}
                                    </td>
                                    <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                        <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ url("cetak-formulir-edukasi-pasien-keluarga/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-success btn-sm" target="_blank">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            
                            </tbody>
                      </table>
                    </div>
                    <div class="col-md-12">
                        <h5><b>A. Asesmen Kebutuhan Edukasi</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width: 30%;">
                                    Agama
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 2rem;">
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[kebutuhan_edukasi][agama][pilihan]"
                                                {{ @$assesment['kebutuhan_edukasi']['agama']['pilihan'] == 'Islam' ? 'checked' : '' }}
                                                type="radio" value="Islam">
                                            <label class="form-check-label" style="font-weight: 400;">Islam</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[kebutuhan_edukasi][agama][pilihan]"
                                                {{ @$assesment['kebutuhan_edukasi']['agama']['pilihan'] == 'Protestan' ? 'checked' : '' }}
                                                type="radio" value="Protestan">
                                            <label class="form-check-label" style="font-weight: 400;">Protestan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[kebutuhan_edukasi][agama][pilihan]"
                                                {{ @$assesment['kebutuhan_edukasi']['agama']['pilihan'] == 'Katolik' ? 'checked' : '' }}
                                                type="radio" value="Katolik">
                                            <label class="form-check-label" style="font-weight: 400;">Katolik</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[kebutuhan_edukasi][agama][pilihan]"
                                                {{ @$assesment['kebutuhan_edukasi']['agama']['pilihan'] == 'Hindu' ? 'checked' : '' }}
                                                type="radio" value="Hindu">
                                            <label class="form-check-label" style="font-weight: 400;">Hindu</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[kebutuhan_edukasi][agama][pilihan]"
                                                {{ @$assesment['kebutuhan_edukasi']['agama']['pilihan'] == 'Budha' ? 'checked' : '' }}
                                                type="radio" value="Budha">
                                            <label class="form-check-label" style="font-weight: 400;">Budha</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[kebutuhan_edukasi][agama][pilihan]"
                                                {{ @$assesment['kebutuhan_edukasi']['agama']['pilihan'] == 'Lain-lain' ? 'checked' : '' }}
                                                type="radio" value="Lain-lain">
                                                <input type="text" name="fisik[kebutuhan_edukasi][agama][pilihan_lain]" placeholder="Lainnya" style="display:inline-block; width: 120px;" class="form-control" id="" value="{{@$assesment['kebutuhan_edukasi']['agama']['pilihan_lain']}}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">
                                    Keyakinan dan nilai-nilai budaya yang dianut pasien dan keluarga berhubungan dengan kesehatan (contoh: tidak bersedia transfusi, tidak makan daging, tidak mau menggunakan obat-obatan yang mengandung babi, dll)
                                </td>
                                <td  style="vertical-align: middle;">
                                    <input type="text" name="fisik[kebutuhan_edukasi][keyakinan_nilai]" placeholder="Jelaskan" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kebutuhan_edukasi']['keyakinan_nilai']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">
                                    Kemampuan Membaca
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][kemampuan_membaca][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['kemampuan_membaca']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][kemampuan_membaca][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['kemampuan_membaca']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">
                                    Tingkat pendidikan
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][tingkat_pendidikan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['tingkat_pendidikan']['pilihan'] == 'SD' ? 'checked' : '' }}
                                            type="radio" value="SD">
                                        <label class="form-check-label" style="font-weight: 400;">SD</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][tingkat_pendidikan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['tingkat_pendidikan']['pilihan'] == 'SMP' ? 'checked' : '' }}
                                            type="radio" value="SMP">
                                        <label class="form-check-label" style="font-weight: 400;">SMP</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][tingkat_pendidikan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['tingkat_pendidikan']['pilihan'] == 'SMU' ? 'checked' : '' }}
                                            type="radio" value="SMU">
                                        <label class="form-check-label" style="font-weight: 400;">SMU</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][tingkat_pendidikan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['tingkat_pendidikan']['pilihan'] == 'S1' ? 'checked' : '' }}
                                            type="radio" value="S1">
                                        <label class="form-check-label" style="font-weight: 400;">S1</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">
                                    Bahasa yang digunakan sehari-hari
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][bahasa_digunakan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['bahasa_digunakan']['pilihan'] == 'Indonesia' ? 'checked' : '' }}
                                            type="radio" value="Indonesia">
                                        <label class="form-check-label" style="font-weight: 400;">Indonesia</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][bahasa_digunakan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['bahasa_digunakan']['pilihan'] == 'Daerah' ? 'checked' : '' }}
                                            type="radio" value="Daerah">
                                        <label class="form-check-label" style="font-weight: 400;">Daerah</label>
                                        <div>
                                            <input type="text" name="fisik[kebutuhan_edukasi][bahasa_digunakan][pilihan_daerah]" placeholder="Bahasa_digunakan Daerah" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kebutuhan_edukasi']['bahasa_digunakan']['pilihan_daerah']['pilihan_lain']}}">
                                        </div>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][bahasa_digunakan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['bahasa_digunakan']['pilihan'] == 'Asing' ? 'checked' : '' }}
                                            type="radio" value="Asing">
                                        <label class="form-check-label" style="font-weight: 400;">Asing</label>
                                        <div>
                                            <input type="text" name="fisik[kebutuhan_edukasi][bahasa_digunakan][pilihan_asing]" placeholder="Bahasa_digunakan Asing" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kebutuhan_edukasi']['bahasa_digunakan']['pilihan_asing']['pilihan_lain']}}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">
                                    Terdapat hambatan dalam penerimaan edukasi
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <b>
                                            Jika Ya, sebutkan hambatannya (bisa di checklist lebih dari satu) :
                                        </b>
                                    </div>
                                    <div style="display: flex; gap: 5rem;">
                                        <div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][pendengaran]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['pendengaran'] == 'Pendengaran' ? 'checked' : '' }}
                                                    type="checkbox" value="Pendengaran">
                                                <label class="form-check-label" style="font-weight: 400;">Pendengaran</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][penglihatan]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['penglihatan'] == 'Penglihatan' ? 'checked' : '' }}
                                                    type="checkbox" value="Penglihatan">
                                                <label class="form-check-label" style="font-weight: 400;">Penglihatan</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][kognitif]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['kognitif'] == 'Kognitif' ? 'checked' : '' }}
                                                    type="checkbox" value="Kognitif">
                                                <label class="form-check-label" style="font-weight: 400;">Kognitif</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][fisik]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['fisik'] == 'Fisik' ? 'checked' : '' }}
                                                    type="checkbox" value="Fisik">
                                                <label class="form-check-label" style="font-weight: 400;">Fisik</label>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][emosi]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['emosi'] == 'Emosi' ? 'checked' : '' }}
                                                    type="checkbox" value="Emosi">
                                                <label class="form-check-label" style="font-weight: 400;">Emosi</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][budaya]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['budaya'] == 'Budaya' ? 'checked' : '' }}
                                                    type="checkbox" value="Budaya">
                                                <label class="form-check-label" style="font-weight: 400;">Budaya</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][agama]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['agama'] == 'Agama' ? 'checked' : '' }}
                                                    type="checkbox" value="Agama">
                                                <label class="form-check-label" style="font-weight: 400;">Agama</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][motivasi]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['motivasi'] == 'Motivasi' ? 'checked' : '' }}
                                                    type="checkbox" value="Motivasi">
                                                <label class="form-check-label" style="font-weight: 400;">Motivasi</label>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][bahasa]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['bahasa'] == 'Bahasa' ? 'checked' : '' }}
                                                    type="checkbox" value="Bahasa">
                                                <label class="form-check-label" style="font-weight: 400;">Bahasa</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][nilai]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['nilai'] == 'Nilai / Kepercayaan' ? 'checked' : '' }}
                                                    type="checkbox" value="Nilai / Kepercayaan">
                                                <label class="form-check-label" style="font-weight: 400;">Nilai / Kepercayaan</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input"
                                                    name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][lain]"
                                                    {{ @$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['lain'] == 'Lainnya' ? 'checked' : '' }}
                                                    type="checkbox" value="Lainnya">
                                                    <input type="text" name="fisik[kebutuhan_edukasi][terdapat_hambatan][pilihan_ya][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 150px;" class="form-control" id="" value="{{@$assesment['kebutuhan_edukasi']['terdapat_hambatan']['pilihan_ya']['lain_detail']}}">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">
                                    Kesediaan pasien menerima informasi
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][ketersediaan_pasien_menerima_informasi][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['ketersediaan_pasien_menerima_informasi']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][ketersediaan_pasien_menerima_informasi][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['ketersediaan_pasien_menerima_informasi']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">
                                    Butuh penerjemah bahasa
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][butuh_penerjemah_bahasa][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['butuh_penerjemah_bahasa']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][butuh_penerjemah_bahasa][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['butuh_penerjemah_bahasa']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;">
                                    Pasien membutuhkan edukasi kolaboratif
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][butuh_edukasi_kolaboratif][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['butuh_edukasi_kolaboratif']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kebutuhan_edukasi][butuh_edukasi_kolaboratif][pilihan]"
                                            {{ @$assesment['kebutuhan_edukasi']['butuh_edukasi_kolaboratif']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h5><b>B. Perencanaan Edukasi</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Tgl & Waktu</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Profesi</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Materi</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Metode</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Media</b>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[perencanaan_edukasi][dokter_dpjp][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['dokter_dpjp']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <select name="fisik[perencanaan_edukasi][profesi][dokter]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($dokter as $d)
                                            <option value="{{ $d->id }}" {{ $d->id == @$ranap->dokter_id ? 'selected' : ''}}>{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][materi][kondisi_kesehatan]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['materi']['kondisi_kesehatan'] == 'Kondisi Kesehatan dan diagnosis' ? 'checked' : '' }}
                                                type="checkbox" value="Kondisi Kesehatan dan diagnosis">
                                            <label class="form-check-label" style="font-weight: 400;">Kondisi Kesehatan dan diagnosis</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][materi][teknik_rehabilitasi]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['materi']['teknik_rehabilitasi'] == 'Teknik teknik rehabilitasi' ? 'checked' : '' }}
                                                type="checkbox" value="Teknik teknik rehabilitasi">
                                            <label class="form-check-label" style="font-weight: 400;">Teknik teknik rehabilitasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][materi][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][dokter_dpjp][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['dokter_dpjp']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][metode][diskusi]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                                                type="checkbox" value="Diskusi">
                                            <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][metode][ceramah]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                                                type="checkbox" value="Ceramah">
                                            <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][metode][demonstrasi]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][metode][simulasi]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                                                type="checkbox" value="Simulasi">
                                            <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][metode][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][dokter_dpjp][metode][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['dokter_dpjp']['metode']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][media][leaflet]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                                                type="checkbox" value="Leaflet">
                                            <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][media][audio_visual]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                                                type="checkbox" value="Audio Visual">
                                            <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][media][lembar_balik]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                                                type="checkbox" value="Lembar balik">
                                            <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][media][alat_peraga]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                                                type="checkbox" value="Alat peraga">
                                            <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][dokter_dpjp][media][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][dokter_dpjp][media][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['dokter_dpjp']['media']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[perencanaan_edukasi][perawat][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['perawat']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <select name="fisik[perencanaan_edukasi][profesi][perawat]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($perawat as $p)
                                            <option value="{{ $p->id }}" {{ $p->id == @$assesment['perencanaan_edukasi']['profesi']['perawat'] ? 'selected' : ''}}>{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][materi][manajemen_nyeri]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['materi']['manajemen_nyeri'] == 'Manajemen Nyeri' ? 'checked' : '' }}
                                                type="checkbox" value="Manajemen Nyeri">
                                            <label class="form-check-label" style="font-weight: 400;">Manajemen Nyeri</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][materi][penggunaan_peralatan]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['materi']['penggunaan_peralatan'] == 'Penggunaan peralatan medis secara efektif dan aman' ? 'checked' : '' }}
                                                type="checkbox" value="Penggunaan peralatan medis secara efektif dan aman">
                                            <label class="form-check-label" style="font-weight: 400;">Penggunaan peralatan medis secara efektif dan aman</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][materi][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][perawat][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['perawat']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][metode][diskusi]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                                                type="checkbox" value="Diskusi">
                                            <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][metode][ceramah]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                                                type="checkbox" value="Ceramah">
                                            <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][metode][demonstrasi]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][metode][simulasi]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                                                type="checkbox" value="Simulasi">
                                            <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][metode][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][perawat][metode][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['perawat']['metode']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][media][leaflet]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                                                type="checkbox" value="Leaflet">
                                            <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][media][audio_visual]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                                                type="checkbox" value="Audio Visual">
                                            <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][media][lembar_balik]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                                                type="checkbox" value="Lembar balik">
                                            <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][media][alat_peraga]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                                                type="checkbox" value="Alat peraga">
                                            <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][perawat][media][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['perawat']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][perawat][media][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['perawat']['media']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[perencanaan_edukasi][farmasi][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['farmasi']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <select name="fisik[perencanaan_edukasi][profesi][farmasi]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($apotek as $a)
                                            <option value="{{ $a->id }}" {{ $a->id == @$assesment['perencanaan_edukasi']['profesi']['farmasi'] ? 'selected' : ''}}>{{ $a->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][materi][penggunaan_obat]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['materi']['penggunaan_obat'] == 'Penggunaan obat-obatan secara efektif dan aman' ? 'checked' : '' }}
                                                type="checkbox" value="Penggunaan obat-obatan secara efektif dan aman">
                                            <label class="form-check-label" style="font-weight: 400;">Penggunaan obat-obatan secara efektif dan aman</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][materi][efek_samping_obat]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['materi']['efek_samping_obat'] == 'Efek samping obat' ? 'checked' : '' }}
                                                type="checkbox" value="Efek samping obat">
                                            <label class="form-check-label" style="font-weight: 400;">Efek samping obat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][materi][potensi_interaksi]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['materi']['potensi_interaksi'] == 'Potensi interaksi obat yang diresepkan dengan obat lain serta makanan' ? 'checked' : '' }}
                                                type="checkbox" value="Potensi interaksi obat yang diresepkan dengan obat lain serta makanan">
                                            <label class="form-check-label" style="font-weight: 400;">Potensi interaksi obat yang diresepkan dengan obat lain serta makanan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][materi][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][farmasi][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['farmasi']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][metode][diskusi]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                                                type="checkbox" value="Diskusi">
                                            <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][metode][ceramah]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                                                type="checkbox" value="Ceramah">
                                            <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][metode][demonstrasi]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][metode][simulasi]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                                                type="checkbox" value="Simulasi">
                                            <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][metode][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][farmasi][metode][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['farmasi']['metode']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][media][leaflet]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                                                type="checkbox" value="Leaflet">
                                            <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][media][audio_visual]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                                                type="checkbox" value="Audio Visual">
                                            <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][media][lembar_balik]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                                                type="checkbox" value="Lembar balik">
                                            <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][media][alat_peraga]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                                                type="checkbox" value="Alat peraga">
                                            <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][farmasi][media][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['farmasi']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][farmasi][media][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['farmasi']['media']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[perencanaan_edukasi][nutrisionis][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['nutrisionis']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <select name="fisik[perencanaan_edukasi][profesi][nutrisionis]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($nutrisionis as $n)
                                            <option value="{{ $n->id }}" {{ $n->id == @$assesment['perencanaan_edukasi']['profesi']['nutrisionis'] ? 'selected' : ''}}>{{ $n->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][materi][diet_dan_nutrisi]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['materi']['diet_dan_nutrisi'] == 'Diet dan nutrisi yang benar' ? 'checked' : '' }}
                                                type="checkbox" value="Diet dan nutrisi yang benar">
                                            <label class="form-check-label" style="font-weight: 400;">Diet dan nutrisi yang benar</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][materi][lain1]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][nutrisionis][materi][lain_detail1]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['nutrisionis']['materi']['lain_detail1']}}">
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][materi][lain2]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][nutrisionis][materi][lain_detail2]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['nutrisionis']['materi']['lain_detail2']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][metode][diskusi]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                                                type="checkbox" value="Diskusi">
                                            <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][metode][ceramah]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                                                type="checkbox" value="Ceramah">
                                            <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][metode][demonstrasi]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][metode][simulasi]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                                                type="checkbox" value="Simulasi">
                                            <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][metode][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][nutrisionis][metode][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['nutrisionis']['metode']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][media][leaflet]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                                                type="checkbox" value="Leaflet">
                                            <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][media][audio_visual]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                                                type="checkbox" value="Audio Visual">
                                            <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][media][lembar_balik]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                                                type="checkbox" value="Lembar balik">
                                            <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][media][alat_peraga]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                                                type="checkbox" value="Alat peraga">
                                            <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][nutrisionis][media][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['nutrisionis']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][nutrisionis][media][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['nutrisionis']['media']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[perencanaan_edukasi][lain_lain][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['lain_lain']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][materi][lain1]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][lain_lain][materi][lain_detail1]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['lain_lain']['materi']['lain_detail1']}}">
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][materi][lain2]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][lain_lain][materi][lain_detail2]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['lain_lain']['materi']['lain_detail2']}}">
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][materi][lain3]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['materi']['lain3'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][lain_lain][materi][lain_detail3]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['lain_lain']['materi']['lain_detail3']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][metode][diskusi]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['metode']['diskusi'] == 'Diskusi' ? 'checked' : '' }}
                                                type="checkbox" value="Diskusi">
                                            <label class="form-check-label" style="font-weight: 400;">Diskusi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][metode][ceramah]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['metode']['ceramah'] == 'Ceramah' ? 'checked' : '' }}
                                                type="checkbox" value="Ceramah">
                                            <label class="form-check-label" style="font-weight: 400;">Ceramah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][metode][demonstrasi]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['metode']['demonstrasi'] == 'Demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Demonstrasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][metode][simulasi]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['metode']['simulasi'] == 'Simulasi' ? 'checked' : '' }}
                                                type="checkbox" value="Simulasi">
                                            <label class="form-check-label" style="font-weight: 400;">Simulasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][metode][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['metode']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][lain_lain][metode][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['nutrisionis']['metode']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][media][leaflet]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['media']['leaflet'] == 'Leaflet' ? 'checked' : '' }}
                                                type="checkbox" value="Leaflet">
                                            <label class="form-check-label" style="font-weight: 400;">Leaflet</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][media][audio_visual]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['media']['audio_visual'] == 'Audio Visual' ? 'checked' : '' }}
                                                type="checkbox" value="Audio Visual">
                                            <label class="form-check-label" style="font-weight: 400;">Audio Visual</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][media][lembar_balik]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['media']['lembar_balik'] == 'Lembar balik' ? 'checked' : '' }}
                                                type="checkbox" value="Lembar balik">
                                            <label class="form-check-label" style="font-weight: 400;">Lembar balik</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][media][alat_peraga]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['media']['alat_peraga'] == 'Alat peraga' ? 'checked' : '' }}
                                                type="checkbox" value="Alat peraga">
                                            <label class="form-check-label" style="font-weight: 400;">Alat peraga</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[perencanaan_edukasi][lain_lain][media][lain]"
                                                {{ @$assesment['perencanaan_edukasi']['lain_lain']['media']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[perencanaan_edukasi][lain_lain][media][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 200px;" class="form-control" id="" value="{{@$assesment['perencanaan_edukasi']['lain_lain']['media']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-12">
                        <h5><b>C. Pelaksanaan Edukasi</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Tgl & Waktu</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Materi Edukasi</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Durasi (Menit)</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Verifikasi</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Tanggal Rencana Reedukasi / Redemonstrasi</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Pemberi Edukasi</b>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <b>Pasien / Keluarga</b>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][dokter_dpjp][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['dokter_dpjp']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Dokter Spesialis / DPJP</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kondisi_kesehatan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kondisi_kesehatan'] == 'Kondisi Kesehatan dan diagnosis pasti' ? 'checked' : '' }}
                                                type="checkbox" value="Kondisi Kesehatan dan diagnosis pasti">
                                            <label class="form-check-label" style="font-weight: 400;">Kondisi Kesehatan dan diagnosis pasti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][hasil_pemeriksaan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['hasil_pemeriksaan'] == 'Hasil pemeriksaan diagnostik' ? 'checked' : '' }}
                                                type="checkbox" value="Hasil pemeriksaan diagnostik">
                                            <label class="form-check-label" style="font-weight: 400;">Hasil pemeriksaan diagnostik</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][tindakan_medis]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['tindakan_medis'] == 'Tindakan Medis' ? 'checked' : '' }}
                                                type="checkbox" value="Tindakan Medis">
                                            <label class="form-check-label" style="font-weight: 400;">Tindakan Medis</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][perkiraan_hari_perawatan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['perkiraan_hari_perawatan'] == 'Perkiraan hari perawatan' ? 'checked' : '' }}
                                                type="checkbox" value="Perkiraan hari perawatan">
                                            <label class="form-check-label" style="font-weight: 400;">Perkiraan hari perawatan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][penjelasan_komplikasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['penjelasan_komplikasi'] == 'Penjelasan komplikasi' ? 'checked' : '' }}
                                                type="checkbox" value="Penjelasan komplikasi">
                                            <label class="form-check-label" style="font-weight: 400;">Penjelasan komplikasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kemungkinan_timbulnya_masalah]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kemungkinan_timbulnya_masalah'] == 'Kemungkinan timbulnya masalah selama masa pemulihan' ? 'checked' : '' }}
                                                type="checkbox" value="Kemungkinan timbulnya masalah selama masa pemulihan">
                                            <label class="form-check-label" style="font-weight: 400;">Kemungkinan timbulnya masalah selama masa pemulihan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kemungkinan_alternatif_pengobatan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kemungkinan_alternatif_pengobatan'] == 'Kemungkinan alternatif pengobatan' ? 'checked' : '' }}
                                                type="checkbox" value="Kemungkinan alternatif pengobatan">
                                            <label class="form-check-label" style="font-weight: 400;">Kemungkinan alternatif pengobatan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kemungkinan_keberhasilan_pengobatan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kemungkinan_keberhasilan_pengobatan'] == 'Kemungkinan keberhasilan pengobatan' ? 'checked' : '' }}
                                                type="checkbox" value="Kemungkinan keberhasilan pengobatan">
                                            <label class="form-check-label" style="font-weight: 400;">Kemungkinan keberhasilan pengobatan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][kemungkinan_yang_terjadi_apabila_tidak_diobati]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['kemungkinan_yang_terjadi_apabila_tidak_diobati'] == 'Kemungkinan yang terjadi apabila tidak diobati' ? 'checked' : '' }}
                                                type="checkbox" value="Kemungkinan yang terjadi apabila tidak diobati">
                                            <label class="form-check-label" style="font-weight: 400;">Kemungkinan yang terjadi apabila tidak diobati</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][lain]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][dokter_dpjp][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['dokter_dpjp']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][dokter_dpjp][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['dokter_dpjp']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][dokter_dpjp][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['dokter_dpjp']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][dokter_dpjp][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['dokter_dpjp']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    {{-- <input type="text" name="fisik[pelaksanaan_edukasi][dokter_dpjp][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['dokter_dpjp']['pemberi_edukasi']}}"> --}}
                                    <select name="fisik[pelaksanaan_edukasi][dokter_dpjp][pemberi_edukasi]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($dokter as $d)
                                            <option value="{{ $d->id }}" {{ $d->id == @$ranap->dokter_id ? 'selected' : ''}}>{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][dokter_dpjp][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['dokter_dpjp']['pasien_keluarga']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][perawat][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['perawat']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Keperawatan / Kebidanan</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][hand_hygiene]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['hand_hygiene'] == 'Hand Hygiene' ? 'checked' : '' }}
                                                type="checkbox" value="Hand Hygiene">
                                            <label class="form-check-label" style="font-weight: 400;">Hand Hygiene</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][mobilisasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['mobilisasi'] == 'Mobilisasi / ROM' ? 'checked' : '' }}
                                                type="checkbox" value="Mobilisasi / ROM">
                                            <label class="form-check-label" style="font-weight: 400;">Mobilisasi / ROM</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][batuk_efektif]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['batuk_efektif'] == 'Batuk Efektif' ? 'checked' : '' }}
                                                type="checkbox" value="Batuk Efektif">
                                            <label class="form-check-label" style="font-weight: 400;">Batuk Efektif</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_luka]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_luka'] == 'Perawatan luka' ? 'checked' : '' }}
                                                type="checkbox" value="Perawatan luka">
                                            <label class="form-check-label" style="font-weight: 400;">Perawatan luka</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_pasca_bedah]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_pasca_bedah'] == 'Perawatan pasca bedah' ? 'checked' : '' }}
                                                type="checkbox" value="Perawatan pasca bedah">
                                            <label class="form-check-label" style="font-weight: 400;">Perawatan pasca bedah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][penanganan_cara_perawatan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['penanganan_cara_perawatan'] == 'Penanganan & cara Perawatan di rumah' ? 'checked' : '' }}
                                                type="checkbox" value="Penanganan & cara Perawatan di rumah">
                                            <label class="form-check-label" style="font-weight: 400;">Penanganan & cara Perawatan di rumah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][asi_eksklusif]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['asi_eksklusif'] == 'ASI Eksklusif / cara menyusui' ? 'checked' : '' }}
                                                type="checkbox" value="ASI Eksklusif / cara menyusui">
                                            <label class="form-check-label" style="font-weight: 400;">ASI Eksklusif / cara menyusui</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_bayi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_bayi'] == 'Perawatan bayi baru lahir' ? 'checked' : '' }}
                                                type="checkbox" value="Perawatan bayi baru lahir">
                                            <label class="form-check-label" style="font-weight: 400;">Perawatan bayi baru lahir</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_tali_pusat]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_tali_pusat'] == 'Perawatan tali pusat' ? 'checked' : '' }}
                                                type="checkbox" value="Perawatan tali pusat">
                                            <label class="form-check-label" style="font-weight: 400;">Perawatan tali pusat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][perawatan_payudara]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['perawatan_payudara'] == 'Perawatan payudara' ? 'checked' : '' }}
                                                type="checkbox" value="Perawatan payudara">
                                            <label class="form-check-label" style="font-weight: 400;">Perawatan payudara</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][pemenuhan_kebutuhan_cairan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['pemenuhan_kebutuhan_cairan'] == 'Pemenuhan kebutuhan cairan' ? 'checked' : '' }}
                                                type="checkbox" value="Pemenuhan kebutuhan cairan">
                                            <label class="form-check-label" style="font-weight: 400;">Pemenuhan kebutuhan cairan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][personal_hygiene]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['personal_hygiene'] == 'Personal hygiene' ? 'checked' : '' }}
                                                type="checkbox" value="Personal hygiene">
                                            <label class="form-check-label" style="font-weight: 400;">Personal hygiene</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][materi][lain]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][perawat][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['perawat']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][perawat][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['perawat']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][perawat][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['perawat']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][perawat][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['perawat']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    {{-- <input type="text" name="fisik[pelaksanaan_edukasi][perawat][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['perawat']['pemberi_edukasi']}}"> --}}
                                    <select name="fisik[pelaksanaan_edukasi][perawat][pemberi_edukasi]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($perawat as $p)
                                            <option value="{{ $p->id }}" {{ $p->id == @$assesment['pelaksanaan_edukasi']['perawat']['pemberi_edukasi'] ? 'selected' : ''}}>{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][perawat][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['perawat']['pasien_keluarga']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][farmasi][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['farmasi']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Farmasi</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][penggunaan_obat]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['penggunaan_obat'] == 'Penggunaan obat-obatan secara efektif dan aman' ? 'checked' : '' }}
                                                type="checkbox" value="Penggunaan obat-obatan secara efektif dan aman">
                                            <label class="form-check-label" style="font-weight: 400;">Penggunaan obat-obatan secara efektif dan aman</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][potensi_interaksi_obat]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['potensi_interaksi_obat'] == 'Potensi interaksi obat' ? 'checked' : '' }}
                                                type="checkbox" value="Potensi interaksi obat">
                                            <label class="form-check-label" style="font-weight: 400;">Potensi interaksi obat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][nama_obat]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['nama_obat'] == 'Nama obat dan kegunaannya' ? 'checked' : '' }}
                                                type="checkbox" value="Nama obat dan kegunaannya">
                                            <label class="form-check-label" style="font-weight: 400;">Nama obat dan kegunaannya</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][kontra_indikasi_obat]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['kontra_indikasi_obat'] == 'Kontra indikasi obat' ? 'checked' : '' }}
                                                type="checkbox" value="Kontra indikasi obat">
                                            <label class="form-check-label" style="font-weight: 400;">Kontra indikasi obat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][aturan_pemakaian]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['aturan_pemakaian'] == 'Aturan pemakaian dan dosis obat' ? 'checked' : '' }}
                                                type="checkbox" value="Aturan pemakaian dan dosis obat">
                                            <label class="form-check-label" style="font-weight: 400;">Aturan pemakaian dan dosis obat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][jumlah_obat]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['jumlah_obat'] == 'Jumlah obat yang diberikan' ? 'checked' : '' }}
                                                type="checkbox" value="Jumlah obat yang diberikan">
                                            <label class="form-check-label" style="font-weight: 400;">Jumlah obat yang diberikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][cara_penyimpanan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['cara_penyimpanan'] == 'Cara penyimpanan obat' ? 'checked' : '' }}
                                                type="checkbox" value="Cara penyimpanan obat">
                                            <label class="form-check-label" style="font-weight: 400;">Cara penyimpanan obat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][efek_samping_obat]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['efek_samping_obat'] == 'Efek samping obat' ? 'checked' : '' }}
                                                type="checkbox" value="Efek samping obat">
                                            <label class="form-check-label" style="font-weight: 400;">Efek samping obat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][materi][lain]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][farmasi][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['farmasi']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][farmasi][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['farmasi']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][farmasi][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['farmasi']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][farmasi][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['farmasi']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    {{-- <input type="text" name="fisik[pelaksanaan_edukasi][farmasi][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['farmasi']['pemberi_edukasi']}}"> --}}
                                    <select name="fisik[pelaksanaan_edukasi][farmasi][pemberi_edukasi]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($apotek as $a)
                                            <option value="{{ $a->id }}" {{ $a->id == @$assesment['pelaksanaan_edukasi']['farmasi']['pemberi_edukasi'] ? 'selected' : ''}}>{{ $a->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][farmasi][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['farmasi']['pasien_keluarga']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Diet dan Nutrisi</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][status_gizi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['status_gizi'] == 'Status gizi dan menjelaskan makanan RS' ? 'checked' : '' }}
                                                type="checkbox" value="Status gizi dan menjelaskan makanan RS">
                                            <label class="form-check-label" style="font-weight: 400;">Status gizi dan menjelaskan makanan RS</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][diet_selama_perawatan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['diet_selama_perawatan'] == 'Diet selama perawatan' ? 'checked' : '' }}
                                                type="checkbox" value="Diet selama perawatan">
                                            <label class="form-check-label" style="font-weight: 400;">Diet selama perawatan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][diet_untuk_dirumah]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['diet_untuk_dirumah'] == 'Diet untuk dirumah' ? 'checked' : '' }}
                                                type="checkbox" value="Diet untuk dirumah">
                                            <label class="form-check-label" style="font-weight: 400;">Diet untuk dirumah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][pembatasan_diet_jika_pasien]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['pembatasan_diet_jika_pasien'] == 'Pembatasan diet jika pasien membawa makanan dari rumah' ? 'checked' : '' }}
                                                type="checkbox" value="Pembatasan diet jika pasien membawa makanan dari rumah">
                                            <label class="form-check-label" style="font-weight: 400;">Pembatasan diet jika pasien membawa makanan dari rumah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain1]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain_detail1]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain_detail1']}}">
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain2]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain_detail2]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain_detail2']}}">
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain3]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain3'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain_detail3]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain_detail3']}}">
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain4]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain4'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][materi][lain_detail4]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['materi']['lain_detail4']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    {{-- <input type="text" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['pemberi_edukasi']}}"> --}}
                                    <select name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][pemberi_edukasi]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($nutrisionis as $n)
                                            <option value="{{ $n->id }}" {{ $n->id == @$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['pemberi_edukasi'] ? 'selected' : ''}}>{{ $n->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][diet_dan_nutrisi][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['diet_dan_nutrisi']['pasien_keluarga']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][rehab_medik][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rehab_medik']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Rehabilitasi Medik</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][teknik_teknik_rehab]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['teknik_teknik_rehab'] == 'Teknik-teknik rehabilitasi' ? 'checked' : '' }}
                                                type="checkbox" value="Teknik-teknik rehabilitasi">
                                            <label class="form-check-label" style="font-weight: 400;">Teknik-teknik rehabilitasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][gerak_aktif_pasif]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['gerak_aktif_pasif'] == 'Gerak aktif & pasif' ? 'checked' : '' }}
                                                type="checkbox" value="Gerak aktif & pasif">
                                            <label class="form-check-label" style="font-weight: 400;">Gerak aktif & pasif</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][mobilisasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['mobilisasi'] == 'Mobilisasi yang dianjurkan' ? 'checked' : '' }}
                                                type="checkbox" value="Mobilisasi yang dianjurkan">
                                            <label class="form-check-label" style="font-weight: 400;">Mobilisasi yang dianjurkan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][excercise]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['excercise'] == 'Excercise' ? 'checked' : '' }}
                                                type="checkbox" value="Excercise">
                                            <label class="form-check-label" style="font-weight: 400;">Excercise</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][fisioterapi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['fisioterapi'] == 'Fisioterapi' ? 'checked' : '' }}
                                                type="checkbox" value="Fisioterapi">
                                            <label class="form-check-label" style="font-weight: 400;">Fisioterapi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][terapi_okupasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['terapi_okupasi'] == 'Terapi okupasi' ? 'checked' : '' }}
                                                type="checkbox" value="Terapi okupasi">
                                            <label class="form-check-label" style="font-weight: 400;">Terapi okupasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][ortotik_wicara]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['ortotik_wicara'] == 'Ortotik wicara' ? 'checked' : '' }}
                                                type="checkbox" value="Ortotik wicara">
                                            <label class="form-check-label" style="font-weight: 400;">Ortotik wicara</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][ortotik_prostetik]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['ortotik_prostetik'] == 'Ortotik prostetik' ? 'checked' : '' }}
                                                type="checkbox" value="Ortotik prostetik">
                                            <label class="form-check-label" style="font-weight: 400;">Ortotik prostetik</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][lain1]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][rehab_medik][materi][lain_detail1]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['lain_detail1']}}">
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][materi][lain2]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][rehab_medik][materi][lain_detail2]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rehab_medik']['materi']['lain_detail2']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][rehab_medik][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rehab_medik']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rehab_medik][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rehab_medik']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][rehab_medik][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rehab_medik']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    {{-- <input type="text" name="fisik[pelaksanaan_edukasi][rehab_medik][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rehab_medik']['pemberi_edukasi']}}"> --}}
                                    <select name="fisik[pelaksanaan_edukasi][rehab_medik][pemberi_edukasi]" class="form-control select2" style="width: 100%">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($rehab as $r)
                                            <option value="{{ $r->id }}" {{ $r->id == @$assesment['pelaksanaan_edukasi']['rehab_medik']['pemberi_edukasi'] ? 'selected' : ''}}>{{ $r->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][rehab_medik][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rehab_medik']['pasien_keluarga']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][alat_medis][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['alat_medis']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Informasi penggunaan alat medis secara efektif dan aman</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][infus]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['infus'] == 'Infus' ? 'checked' : '' }}
                                                type="checkbox" value="Infus">
                                            <label class="form-check-label" style="font-weight: 400;">Infus</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][syringe_pump]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['syringe_pump'] == 'Syringe Pump' ? 'checked' : '' }}
                                                type="checkbox" value="Syringe Pump">
                                            <label class="form-check-label" style="font-weight: 400;">Syringe Pump</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][infus_pump]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['infus_pump'] == 'Infus Pump' ? 'checked' : '' }}
                                                type="checkbox" value="Infus Pump">
                                            <label class="form-check-label" style="font-weight: 400;">Infus Pump</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][ventilator]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['ventilator'] == 'Ventilator' ? 'checked' : '' }}
                                                type="checkbox" value="Ventilator">
                                            <label class="form-check-label" style="font-weight: 400;">Ventilator</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][o2nc]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['o2nc'] == 'O2 NC' ? 'checked' : '' }}
                                                type="checkbox" value="O2 NC">
                                            <label class="form-check-label" style="font-weight: 400;">O2 NC</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][hemodialisa]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['hemodialisa'] == 'Hemodialisa' ? 'checked' : '' }}
                                                type="checkbox" value="Hemodialisa">
                                            <label class="form-check-label" style="font-weight: 400;">Hemodialisa</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][ogt]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['ogt'] == 'OGT' ? 'checked' : '' }}
                                                type="checkbox" value="OGT">
                                            <label class="form-check-label" style="font-weight: 400;">OGT</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][wsd]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['wsd'] == 'WSD' ? 'checked' : '' }}
                                                type="checkbox" value="WSD">
                                            <label class="form-check-label" style="font-weight: 400;">WSD</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][kateter_urin]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['kateter_urin'] == 'Kateter urin' ? 'checked' : '' }}
                                                type="checkbox" value="Kateter urin">
                                            <label class="form-check-label" style="font-weight: 400;">Kateter urin</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][cpap]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['cpap'] == 'CPAP' ? 'checked' : '' }}
                                                type="checkbox" value="CPAP">
                                            <label class="form-check-label" style="font-weight: 400;">CPAP</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][drain]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['drain'] == 'Drain' ? 'checked' : '' }}
                                                type="checkbox" value="Drain">
                                            <label class="form-check-label" style="font-weight: 400;">Drain</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][fototherapy]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['fototherapy'] == 'Fototherapy' ? 'checked' : '' }}
                                                type="checkbox" value="Fototherapy">
                                            <label class="form-check-label" style="font-weight: 400;">Fototherapy</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][ngt]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['ngt'] == 'NGT' ? 'checked' : '' }}
                                                type="checkbox" value="NGT">
                                            <label class="form-check-label" style="font-weight: 400;">NGT</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][materi][lain]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][alat_medis][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['alat_medis']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][alat_medis][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['alat_medis']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][alat_medis][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['alat_medis']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][alat_medis][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['alat_medis']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][alat_medis][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['alat_medis']['pemberi_edukasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][alat_medis][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['alat_medis']['pasien_keluarga']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][rohaniawan][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rohaniawan']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Rohaniawan</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][materi][bimbingan_ibadah]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['materi']['bimbingan_ibadah'] == 'Bimbingan ibadah' ? 'checked' : '' }}
                                                type="checkbox" value="Bimbingan ibadah">
                                            <label class="form-check-label" style="font-weight: 400;">Bimbingan ibadah</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][materi][bimbingan_doa]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['materi']['bimbingan_doa'] == 'Bimbingan doa' ? 'checked' : '' }}
                                                type="checkbox" value="Bimbingan doa">
                                            <label class="form-check-label" style="font-weight: 400;">Bimbingan doa</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][materi][konseling_spritiual]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['materi']['konseling_spritiual'] == 'Konseling spiritual akhir hayat' ? 'checked' : '' }}
                                                type="checkbox" value="Konseling spiritual akhir hayat">
                                            <label class="form-check-label" style="font-weight: 400;">Konseling spiritual akhir hayat</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][materi][lain1]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['materi']['lain1'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][rohaniawan][materi][lain_detail1]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rohaniawan']['materi']['lain_detail1']}}">
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][materi][lain2]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['materi']['lain2'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][rohaniawan][materi][lain_detail2]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rohaniawan']['materi']['lain_detail2']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][rohaniawan][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rohaniawan']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][rohaniawan][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['rohaniawan']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][rohaniawan][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rohaniawan']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][rohaniawan][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rohaniawan']['pemberi_edukasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][rohaniawan][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['rohaniawan']['pasien_keluarga']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][manajemen_nyeri][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Manajemen Nyeri</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][farmakologi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['farmakologi'] == 'Farmakologi' ? 'checked' : '' }}
                                                type="checkbox" value="Farmakologi">
                                            <label class="form-check-label" style="font-weight: 400;">Farmakologi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][non_farmakologi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['non_farmakologi'] == 'Non Farmakologi' ? 'checked' : '' }}
                                                type="checkbox" value="Non Farmakologi">
                                            <label class="form-check-label" style="font-weight: 400;">Non Farmakologi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][distraksi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['distraksi'] == 'Distraksi' ? 'checked' : '' }}
                                                type="checkbox" value="Distraksi">
                                            <label class="form-check-label" style="font-weight: 400;">Distraksi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][relaksasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['relaksasi'] == 'Relaksasi' ? 'checked' : '' }}
                                                type="checkbox" value="Relaksasi">
                                            <label class="form-check-label" style="font-weight: 400;">Relaksasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][gate_control]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['gate_control'] == 'Gate Control' ? 'checked' : '' }}
                                                type="checkbox" value="Gate Control">
                                            <label class="form-check-label" style="font-weight: 400;">Gate Control</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][lain]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][manajemen_nyeri][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][manajemen_nyeri][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][manajemen_nyeri][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][manajemen_nyeri][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][manajemen_nyeri][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['pemberi_edukasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][manajemen_nyeri][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['manajemen_nyeri']['pasien_keluarga']}}">
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="datetime-local" name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['tanggal_waktu']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <b>Informasi bagi pasien dan keluarga</b>
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][hak_kewajiban]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['hak_kewajiban'] == 'Hak dan kewajiban pasien' ? 'checked' : '' }}
                                                type="checkbox" value="Hak dan kewajiban pasien">
                                            <label class="form-check-label" style="font-weight: 400;">Hak dan kewajiban pasien</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][tata_tertib]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['tata_tertib'] == 'Tata tertib RS' ? 'checked' : '' }}
                                                type="checkbox" value="Tata tertib RS">
                                            <label class="form-check-label" style="font-weight: 400;">Tata tertib RS</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][hak_berpartisipasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['hak_berpartisipasi'] == 'Hak untuk berpartisipasi pada proses pelayanan' ? 'checked' : '' }}
                                                type="checkbox" value="Hak untuk berpartisipasi pada proses pelayanan">
                                            <label class="form-check-label" style="font-weight: 400;">Hak untuk berpartisipasi pada proses pelayanan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][pemasangan_gelang]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['pemasangan_gelang'] == 'Pemasangan gelang identitas pasien/gelang risiko' ? 'checked' : '' }}
                                                type="checkbox" value="Pemasangan gelang identitas pasien/gelang risiko">
                                            <label class="form-check-label" style="font-weight: 400;">Pemasangan gelang identitas pasien/gelang risiko</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][lain]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['lain'] == 'Lain' ? 'checked' : '' }}
                                                type="checkbox" value="Lain">
                                                <input type="text" name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][materi][lain_detail]" placeholder="Lainnya" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['materi']['lain_detail']}}">
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][durasi]" placeholder="Durasi, Cth : 10" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['durasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][sudah_mengerti]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['sudah_mengerti'] == 'Sudah mengerti' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mengerti">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mengerti</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][berpartisipasi_mengambil_keputusan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['berpartisipasi_mengambil_keputusan'] == 'Berpartisipasi mengambil keputusan' ? 'checked' : '' }}
                                                type="checkbox" value="Berpartisipasi mengambil keputusan">
                                            <label class="form-check-label" style="font-weight: 400;">Berpartisipasi mengambil keputusan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][sudah_mampu_mendemonstrasikan]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['sudah_mampu_mendemonstrasikan'] == 'Sudah mampu mendomenstrasikan' ? 'checked' : '' }}
                                                type="checkbox" value="Sudah mampu mendomenstrasikan">
                                            <label class="form-check-label" style="font-weight: 400;">Sudah mampu mendomenstrasikan</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][reedukasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['reedukasi'] == 'Re-edukasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-edukasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-edukasi</label>
                                        </div>
                                        <div>
                                            <input class="form-check-input"
                                                name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][verifikasi][redemonstrasi]"
                                                {{ @$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['verifikasi']['redemonstrasi'] == 'Re-demonstrasi' ? 'checked' : '' }}
                                                type="checkbox" value="Re-demonstrasi">
                                            <label class="form-check-label" style="font-weight: 400;">Re-demonstrasi</label>
                                        </div>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="date" name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][tgl_rencana]" placeholder="Tanggal Rencana" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['tgl_rencana']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][pemberi_edukasi]" placeholder="Pemberi Edukasi" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['pemberi_edukasi']}}">
                                </td>
                                <td style="border: 1px solid black; width: 10%; vertical-align: middle;">
                                    <input type="text" name="fisik[pelaksanaan_edukasi][informasi_bagi_pasien][pasien_keluarga]" placeholder="Pasien / Keluarga" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pelaksanaan_edukasi']['informasi_bagi_pasien']['pasien_keluarga']}}">
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

                <button class="btn btn-success pull-right">Simpan</button>
            </form>
            <br />
            
        </div>
    </div>


    

@endsection

@section('script')
    <script>
        $(".skin-blue").addClass("sidebar-collapse");
        $('#dokter_id').select2()

        function editDokter(id) {
            var dok = $('#dokter_id').val();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/emr/editDokter/' + dok + '/' + id,
                    type: 'POST',
                    dataType: 'json',
                })
                .done(function(data) {
                    alert('Berhasil Ubah DPJP');
                })
                .fail(function() {
                    alert('Gagal Ubah DPJP');
                });

        }

        function kalkulasiGizi() {
            let beratBadan = $('input[name="fisik[pengkajian][antropometri][dewasa][bb_saat_ini]"]').val();
            let tinggiBadan = $('input[name="fisik[pengkajian][antropometri][dewasa][tinggi_badan]"]').val();

            console.log(beratBadan, tinggiBadan);
            let tinggiMeter = tinggiBadan / 100; // konversi ke (cm) => (m)
    
            // Hitung IMT
            let imt = beratBadan / (tinggiMeter * tinggiMeter);
            
            $('input[name="fisik[pengkajian][antropometri][dewasa][imt]"]').val(imt.toFixed(1));

            // Kategori IMT
            let kategori = null;
            if (imt < 17.0 && imt <= 18.4) {
                kategori = "Kurus";
            } else if (imt >= 18.5 && imt <= 25.0) {
                kategori = "Normal";
            } else if (imt >= 25.1 && imt <= 27.0) {
                kategori = "Overweight";
            } else if (imt > 27.0) {
                kategori = "Obesitas";
            } else {
                kategori = "Tidak Masuk Kategori";
            }

            $('input[name="fisik[pengkajian][antropometri][dewasa][status_gizi]"]').val(kategori);
        }
    </script>
    
@endsection
