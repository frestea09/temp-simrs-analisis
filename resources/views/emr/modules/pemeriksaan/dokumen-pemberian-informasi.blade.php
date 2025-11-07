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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/dokumen-pemberian-informasi/' . $unit . '/' . $reg->id) }}"
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
                          <h4 style="text-align: center; padding: 10px"><b>Dokumen Pemberian Informasi</b></h4>
                        <br>
                    </div>
                </div>
                
                <div class="row">

                    <div class="col-md-12">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%;" class="text-center">
                                    <b>NO</b>
                                </td>
                                <td style="border: 1px solid black; width: 15%;" class="text-center">
                                    <b>TGL/JAM</b>
                                </td>
                                <td style="border: 1px solid black; width: 30%;" class="text-center">
                                    <b>JENIS INFORMASI</b>
                                </td>
                                <td style="border: 1px solid black; width: 50%;" class="text-center">
                                    <b>ISI INFORMASI</b>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    1
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][pemasangan_infus][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['pemasangan_infus']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan Infus
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_infus][rehidrasi_cairan]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_infus']['rehidrasi_cairan'] == 'Rehidrasi Cairan' ? 'checked' : '' }}
                                                type="checkbox" value="Rehidrasi Cairan">
                                            <label class="form-check-label" style="font-weight: 400;">Rehidrasi Cairan</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_infus][memasukkan_obat]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_infus']['memasukkan_obat'] == 'Memasukkan Obat' ? 'checked' : '' }}
                                                type="checkbox" value="Memasukkan Obat">
                                            <label class="form-check-label" style="font-weight: 400;">Memasukkan Obat</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_infus][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_infus']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][pemasangan_infus][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_infus']['lainnya']}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][pemasangan_infus][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_infus']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan Infus
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Untuk rehidrasi / pemberian therapu cairan <br>
                                        - Untuk memberikan obat obat injeksi IV <br>
                                        - Untuk memberikan untrisi parenteral <br>
                                        <b>Resiko : </b> <br>
                                        - Plebhitis / Infeksi
                                    </td>
                                @endif
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    2
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][pemasangan_dower][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['pemasangan_dower']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan Dower Cathether
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_dower][mengeluarkan_urine]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_dower']['mengeluarkan_urine'] == 'Mengeluarkan Urine' ? 'checked' : '' }}
                                                type="checkbox" value="Mengeluarkan Urine">
                                            <label class="form-check-label" style="font-weight: 400;">Mengeluarkan Urine</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_dower][menghitung_kebutuhan]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_dower']['menghitung_kebutuhan'] == 'Menghitung Kebutuhan Cairan' ? 'checked' : '' }}
                                                type="checkbox" value="Menghitung Kebutuhan Cairan">
                                            <label class="form-check-label" style="font-weight: 400;">Menghitung Kebutuhan Cairan</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_dower][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_dower']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][pemasangan_dower][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_dower'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][pemberian_suntikan][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['pemberian_suntikan']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemberian Suntikan / Injeksi
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Untuk memberikan obat obat yang tidak bisa diberikan melalui mulut <br>
                                        <b>Resiko : </b> <br>
                                        - Plebhitis / Infeksi (IV) <br>
                                        - Hematoma / Memar (IM)
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    3
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][tindakan_restrain][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['tindakan_restrain']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Tindakan Restrain (Pengikatan)
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][tindakan_restrain][mengurangi_resiko_jatuh]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['tindakan_restrain']['mengurangi_resiko_jatuh'] == 'Mengurangi Resiko Jatuh' ? 'checked' : '' }}
                                                type="checkbox" value="Mengurangi Resiko Jatuh">
                                            <label class="form-check-label" style="font-weight: 400;">Mengurangi Resiko Jatuh</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][tindakan_restrain][memudahkan_pemberian_terapi]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['tindakan_restrain']['memudahkan_pemberian_terapi'] == 'Memudahkan Pemberian Terapi' ? 'checked' : '' }}
                                                type="checkbox" value="Memudahkan Pemberian Terapi">
                                            <label class="form-check-label" style="font-weight: 400;">Memudahkan Pemberian Terapi</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][tindakan_restrain][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['tindakan_restrain']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][tindakan_restrain][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['tindakan_restrain'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][pemasangan_ogt][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_ogt']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan OGT
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Untuk Dekompresi / mengeluarkan udara dari lambung <br>
                                        - Untuk pemberisan nutrisi enteral <br>
                                        - Untuk bilang lambung <br>
                                        <b>Resiko : </b> <br>
                                        - Aspirasi / tersedak <br>
                                        - Iritasi / lecet
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    4
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][tes_antibiotik][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['tes_antibiotik']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Tes Untuk Antibiotik
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][tes_antibiotik][mengetahui_alergi_obat]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['tes_antibiotik']['mengetahui_alergi_obat'] == 'Mengetahui Alergi Obat' ? 'checked' : '' }}
                                                type="checkbox" value="Mengetahui Alergi Obat">
                                            <label class="form-check-label" style="font-weight: 400;">Mengetahui Alergi Obat</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][tes_antibiotik][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['tes_antibiotik']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][tes_antibiotik][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['tes_antibiotik'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][suction_nasofaring][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['suction_nasofaring']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Suction Nasofaring
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Membersihkan jalan nafas dari lendir / ketuban <br>
                                        <b>Resiko : </b> <br>
                                        - Iritasi / lect pada selaput lendir mulut / hidung
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    5
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][pemberian_suntikan][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['pemberian_suntikan']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemberian Suntikan / Injeksi
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemberian_suntikan][penahan_sakit]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemberian_suntikan']['penahan_sakit'] == 'Penahan Sakit' ? 'checked' : '' }}
                                                type="checkbox" value="Penahan Sakit">
                                            <label class="form-check-label" style="font-weight: 400;">Penahan Sakit</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemberian_suntikan][antibiotik]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemberian_suntikan']['antibiotik'] == 'Antibiotik' ? 'checked' : '' }}
                                                type="checkbox" value="Antibiotik">
                                            <label class="form-check-label" style="font-weight: 400;">Antibiotik</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemberian_suntikan][obat_mual_muntah]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemberian_suntikan']['obat_mual_muntah'] == 'Obat Mual dan Muntah' ? 'checked' : '' }}
                                                type="checkbox" value="Obat Mual dan Muntah">
                                            <label class="form-check-label" style="font-weight: 400;">Obat Mual dan Muntah</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemberian_suntikan][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemberian_suntikan']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][pemberian_suntikan][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['pemberian_suntikan'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][pemasangan_therapy][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_therapy']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan therapy sinar (blue light)
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Untuk menurunkan kadar bilirubin dalam darah <br>
                                        <b>Resiko : </b> <br>
                                        - Kekurangan cairan <br>
                                        - Demam <br>
                                        - Diare <br>
                                        - Baby Bronze Syndrome
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    6
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][pemasangan_ngt][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['pemasangan_ngt']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan NGT
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_ngt][bilas_lambung]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_ngt']['bilas_lambung'] == 'Bilas Lambung' ? 'checked' : '' }}
                                                type="checkbox" value="Bilas Lambung">
                                            <label class="form-check-label" style="font-weight: 400;">Bilas Lambung</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_ngt][memberikan_obat_makan_minum]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_ngt']['memberikan_obat_makan_minum'] == 'Memberikan obat/makan/minum' ? 'checked' : '' }}
                                                type="checkbox" value="Memberikan obat/makan/minum">
                                            <label class="form-check-label" style="font-weight: 400;">Memberikan obat/makan/minum</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_ngt][mengurangi_perut_kembung]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_ngt']['mengurangi_perut_kembung'] == 'Mengurangi perut kembung' ? 'checked' : '' }}
                                                type="checkbox" value="Mengurangi perut kembung">
                                            <label class="form-check-label" style="font-weight: 400;">Mengurangi perut kembung</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_ngt][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_ngt']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][pemasangan_ngt][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_ngt'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][skrining_bayi][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['skrining_bayi']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Skrining Bayi baru lahir (Pemeriksaan Darah)
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Untuk mengetahui kondisi kesehatan / mendeteksi adanya kemungkinan penyakit <br>
                                        <b>Resiko : </b> <br>
                                        - Hematoma / memar pada area pengambilan darah
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    7
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][pemasangan_ogt][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['pemasangan_ogt']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan OGT
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_ogt][memberikan_obat_makan_minum]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_ogt']['memberikan_obat_makan_minum'] == 'Memberikan obat/makan/minum' ? 'checked' : '' }}
                                                type="checkbox" value="Memberikan obat/makan/minum">
                                            <label class="form-check-label" style="font-weight: 400;">Memberikan obat/makan/minum</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_ogt][mengurangi_perut_kembung]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_ogt']['mengurangi_perut_kembung'] == 'Mengurangi perut kembung' ? 'checked' : '' }}
                                                type="checkbox" value="Mengurangi perut kembung">
                                            <label class="form-check-label" style="font-weight: 400;">Mengurangi perut kembung</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_ogt][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_ogt']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][pemasangan_ogt][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_ogt'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][pemasangan_early_cpap][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_early_cpap']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan early CPAP
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Membuka alveoli paru <br>
                                        - Mencegah kekurangan oksigen <br>
                                        <b>Resiko : </b> <br>
                                        - Keracunan oksigen <br>
                                        - Lecet pada selaput lendir hidung
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    8
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][pemasangan_bidai][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['pemasangan_bidai']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan Bidai
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_bidai][mengurangi_nyeri]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_bidai']['mengurangi_nyeri'] == 'Mengurangi Nyeri Akibat Trauma' ? 'checked' : '' }}
                                                type="checkbox" value="Mengurangi Nyeri Akibat Trauma">
                                            <label class="form-check-label" style="font-weight: 400;">Mengurangi Nyeri Akibat Trauma</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_bidai][mengurangi_perdarahan]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_bidai']['mengurangi_perdarahan'] == 'Mengurangi perdarahan' ? 'checked' : '' }}
                                                type="checkbox" value="Mengurangi perdarahan">
                                            <label class="form-check-label" style="font-weight: 400;">Mengurangi perdarahan</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][pemasangan_bidai][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['pemasangan_bidai']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][pemasangan_bidai][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_bidai'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][pemasangan_cpap][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['pemasangan_cpap']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemasangan CPAP
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Membuka alveoli paru <br>
                                        - Mencegah kekurangan oksigen <br>
                                        <b>Resiko : </b> <br>
                                        - Keracunan oksigen <br>
                                        - Lecet pada selaput lendir hidung <br>
                                        - Kerusakan retina mata pada bayi prematur
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    9
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][suction_nasofaring][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['suction_nasofaring']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Suction Nasofaring
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][suction_nasofaring][membersihkan_jalannafas]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['suction_nasofaring']['membersihkan_jalannafas'] == 'Membersihkan Jalan Nafas' ? 'checked' : '' }}
                                                type="checkbox" value="Membersihkan Jalan Nafas">
                                            <label class="form-check-label" style="font-weight: 400;">Membersihkan Jalan Nafas</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][suction_nasofaring][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['suction_nasofaring']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][suction_nasofaring][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['suction_nasofaring'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][pemberian_therapy_oksigen][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['pemberian_therapy_oksigen']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Pemberian therapy oksigen Nasal canule
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Mencegah / mengatasi kekurangan oksigen <br>
                                        <b>Resiko : </b> <br>
                                        - Keracunan oksigen <br>
                                        - Lecet pada selaput lendir hidung <br>
                                        - Kerusakan retina mata pada bayi prematur
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    10
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][penjahitan_luka][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['penjahitan_luka']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Penjahitan Luka Derajat Ringan
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][penjahitan_luka][menghentikan_perdarahan]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['penjahitan_luka']['menghentikan_perdarahan'] == 'Menghentikan Perdarahan' ? 'checked' : '' }}
                                                type="checkbox" value="Menghentikan Perdarahan">
                                            <label class="form-check-label" style="font-weight: 400;">Menghentikan Perdarahan</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][penjahitan_luka][menyatukan_jaringan]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['penjahitan_luka']['menyatukan_jaringan'] == 'Menyatukan Jaringan' ? 'checked' : '' }}
                                                type="checkbox" value="Menyatukan Jaringan">
                                            <label class="form-check-label" style="font-weight: 400;">Menyatukan Jaringan</label>
                                        </div>
                                        <div style="width: 100%;">
                                            <input class="form-check-input"
                                                name="fisik[dokumen_pemberian_terapi][penjahitan_luka][isi_lainnya]"
                                                {{ @$assesment['dokumen_pemberian_terapi']['penjahitan_luka']['isi_lainnya'] == 'Lainnya' ? 'checked' : '' }}
                                                type="checkbox" value="Lainnya">
                                            <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        </div>
                                        <input type="text" placeholder="Isi informasi" name="fisik[dokumen_pemberian_terapi][penjahitan_luka][lainnya]" value="{{@$assesment['dokumen_pemberian_terapi']['penjahitan_luka'][lainnya]}}" class="form-control" />
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][resusitasi_ventilasi][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['resusitasi_ventilasi']['tanggal_waktu']}}">
                                    </td>
                                    <td style="border: 1px solid black; width: 30%; vertical-align: top;">
                                        Resusitasi / Ventilasi Tekanan Positif
                                    </td>
                                    <td style="border: 1px solid black; width: 50%; vertical-align: top;">
                                        <b>Tujuan : </b> <br>
                                        - Untuk memperbaiki sistem pernapasan bayi & membuka alveoli paru <br>
                                        <b>Resiko : </b> <br>
                                        - Pneumothorax
                                    </td>
                                @endif
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
                                    11
                                </td>
                                @if ($unit == 'igd')
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top; padding: 0;" class="text-center">
                                        <input type="datetime-local" name="fisik[igd][dokumen_pemberian_terapi][tambahan][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['igd']['dokumen_pemberian_terapi']['tambahan']['tanggal_waktu']}}">
                                    </td>
                                @else
                                    <td style="border: 1px solid black; width: 15%; vertical-align: top; padding: 0;" class="text-center">
                                        <input type="datetime-local" name="fisik[dokumen_pemberian_terapi][tambahan][tanggal_waktu]" placeholder="Lainnya" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['dokumen_pemberian_terapi']['tambahan']['tanggal_waktu']}}">
                                    </td>
                                @endif
                                <td style="border: 1px solid black; width: 30%; vertical-align: top; padding: 0;">
                                    <textarea style="width: 100%;" name="fisik[dokumen_pemberian_terapi][tambahan][jenis_informasi]"cols="30" rows="10">{{@$assesment['dokumen_pemberian_terapi']['tambahan']['jenis_informasi']}}</textarea>
                                </td>
                                <td style="border: 1px solid black; width: 50%; vertical-align: top; padding: 0;">
                                    <textarea style="width: 100%;" name="fisik[dokumen_pemberian_terapi][tambahan][isi_informasi]"cols="30" rows="10">{{@$assesment['dokumen_pemberian_terapi']['tambahan']['isi_informasi']}}</textarea>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

                @if (empty(@$assesment))
                    <button class="btn btn-success pull-right">Simpan</button>
                @else
                    <button class="btn btn-danger pull-right">Perbarui</button>
                    <a href="{{url('emr-soap-print/cetak-dokumen-pemberian-informasi/' .$unit. '/' . $reg->id)}}" target="_blank" class="btn btn-warning pull-right" style="margin-right: 1rem;">Cetak</a>
                @endif
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
