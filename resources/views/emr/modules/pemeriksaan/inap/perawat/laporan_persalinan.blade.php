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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/laporan-persalinan/' . $unit . '/' . $reg->id) }}"
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
                          <h4 style="text-align: center; padding: 10px"><b>Laporan Persalinan</b></h4>
                        <br>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <h5><b>G P A AH</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td colspan="2" rowspan="4" style="width: 10%;">
                                    G P A A H
                                
                                    {{-- <input type="datetime-local" name="fisik[jam_1][jam]" placeholder="Bahasa Daerah" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_1']['jam']}}"> --}}
                                </td>
                                <td style="width: 15%;">
                                    <label>G</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-control"
                                            name="fisik[keterangan][g]"
                                            value="{{@$assesment['keterangan']['g']}}" >
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>P</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-control"
                                            name="fisik[keterangan][p]"
                                            value="{{@$assesment['keterangan']['p']}}" >
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>A</label>
                                </td>
                                <td style="width: 60%;">
                                    <input class="form-control"
                                            name="fisik[keterangan][a]"
                                            value="{{@$assesment['keterangan']['a']}}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>AH</label>
                                </td>
                                <td style="width: 60%;">
                                    <input class="form-control"
                                            name="fisik[keterangan][ah]"
                                            value="{{@$assesment['keterangan']['ah']}}" >
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="6" style="width: 10%;">
                                    Jam
                                </td>
                                <td rowspan="6" style="width: 15%;">
                                    <input type="datetime-local" name="fisik[jam_1][jam_1]" placeholder="Bahasa Daerah" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_1']['jam_1']}}"><br>
                                    <input type="datetime-local" name="fisik[jam_1][jam_2]" placeholder="Bahasa Daerah" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_1']['jam_2']}}"><br>
                                    <input type="datetime-local" name="fisik[jam_1][jam_3]" placeholder="Bahasa Daerah" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_1']['jam_3']}}"><br>
                                </td>
                                <td style="width: 15%;">
                                    <label>Lahir Bayi</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_1][lahir_bayi][pilihan]"
                                            {{ @$assesment['jam_1']['lahir_bayi']['pilihan'] == 'Laki-laki' ? 'checked' : '' }}
                                            type="radio" value="Laki-laki">
                                        <label class="form-check-label" style="font-weight: 400;">Laki-laki</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_1][lahir_bayi][pilihan]"
                                            {{ @$assesment['jam_1']['lahir_bayi']['pilihan'] == 'Perempuan' ? 'checked' : '' }}
                                            type="radio" value="Perempuan">
                                        <label class="form-check-label" style="font-weight: 400;">Perempuan</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Jenis Persalinan</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_1][spontan][pilihan][EF]"
                                            {{ @$assesment['jam_1']['spontan']['pilihan']['EF'] == 'E.F' ? 'checked' : '' }}
                                            type="checkbox" value="E.F">
                                        <label class="form-check-label" style="font-weight: 400;">E.F</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_1][spontan][pilihan][Evc]"
                                            {{ @$assesment['jam_1']['spontan']['pilihan']['Evc'] == 'E.Vc' ? 'checked' : '' }}
                                            type="checkbox" value="E.Vc">
                                        <label class="form-check-label" style="font-weight: 400;">E.Vc</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_1][spontan][pilihan][SC]"
                                            {{ @$assesment['jam_1']['spontan']['pilihan']['SC'] == 'SC' ? 'checked' : '' }}
                                            type="checkbox" value="SC">
                                        <label class="form-check-label" style="font-weight: 400;">SC</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_1][spontan][pilihan][ManualAID]"
                                            {{ @$assesment['jam_1']['spontan']['pilihan']['ManualAID'] == 'Manual AID' ? 'checked' : '' }}
                                            type="checkbox" value="Manual AID">
                                        <label class="form-check-label" style="font-weight: 400;">Manual AID</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_1][spontan][pilihan][Bracht]"
                                            {{ @$assesment['jam_1']['spontan']['pilihan']['Bracht'] == 'Bracht' ? 'checked' : '' }}
                                            type="checkbox" value="Bracht">
                                        <label class="form-check-label" style="font-weight: 400;">Bracht</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_1][spontan][pilihan][Spontan]"
                                            {{ @$assesment['jam_1']['spontan']['pilihan']['Spontan'] == 'Spontan' ? 'checked' : '' }}
                                            type="checkbox" value="Spontan">
                                        <label class="form-check-label" style="font-weight: 400;">Spontan</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Berat (gr)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[jam_1][berat_badan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_1']['berat_badan']}}">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Panjang Badan (cm)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[jam_1][panjang_badan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_1']['panjang_badan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Lilitan Tali Pusat (+/-)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[jam_1][lilitan_tali_pusat]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_1']['lilitan_tali_pusat']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Episiotomi (+/-)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[jam_1][episiotomi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_1']['episiotomi']}}">
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="6" style="width: 10%;">
                                    Jam
                                </td>
                                <td rowspan="6" style="width: 15%;">
                                    <input type="datetime-local" name="fisik[jam_2][jam_1]" placeholder="Bahasa Daerah" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_2']['jam_1']}}"><br>
                                    <input type="datetime-local" name="fisik[jam_2][jam_2]" placeholder="Bahasa Daerah" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_2']['jam_2']}}"><br>
                                    <input type="datetime-local" name="fisik[jam_2][jam_3]" placeholder="Bahasa Daerah" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_2']['jam_3']}}"><br>
                                </td>
                                <td style="width: 15%;">
                                    <label>Plasenta lahir</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_2][plasenta_lahir][pilihan]"
                                            {{ @$assesment['jam_2']['plasenta_lahir']['pilihan'] == 'Spontan' ? 'checked' : '' }}
                                            type="radio" value="Spontan">
                                        <label class="form-check-label" style="font-weight: 400;">Spontan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_2][plasenta_lahir][pilihan]"
                                            {{ @$assesment['jam_2']['plasenta_lahir']['pilihan'] == 'Manual' ? 'checked' : '' }}
                                            type="radio" value="Manual">
                                        <label class="form-check-label" style="font-weight: 400;">Manual</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Kelengkapan</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_2][kelengkapan][pilihan]"
                                            {{ @$assesment['jam_2']['kelengkapan']['pilihan'] == 'Lengkap' ? 'checked' : '' }}
                                            type="radio" value="Lengkap">
                                        <label class="form-check-label" style="font-weight: 400;">Lengkap</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_2][kelengkapan][pilihan]"
                                            {{ @$assesment['jam_2']['kelengkapan']['pilihan'] == 'Tidak lengkap' ? 'checked' : '' }}
                                            type="radio" value="Tidak lengkap">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak lengkap</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Berat (gr)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[jam_2][berat_badan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_2']['berat_badan']}}">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Ukuran (cm)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[jam_2][ukuran]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_2']['ukuran']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Pendarahan (cc)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[jam_2][pendarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['jam_2']['pendarahan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Jahitan Perineum</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_2][jahitan_perineum][pilihan][]"
                                            {{ in_array('Luar', @$assesment['jam_2']['jahitan_perineum']['pilihan'] ?? []) ? 'checked' : '' }}
                                            type="checkbox" value="Luar">
                                        <label class="form-check-label" style="font-weight: 400;">Luar</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[jam_2][jahitan_perineum][pilihan][]"
                                            {{ in_array('Dalam', @$assesment['jam_2']['jahitan_perineum']['pilihan'] ?? []) ? 'checked' : '' }}
                                            type="checkbox" value="Dalam">
                                        <label class="form-check-label" style="font-weight: 400;">Dalam</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="5" style="width: 10%;">
                                    Post Partum
                                </td>
                                <td rowspan="5" style="width: 15%;">
                                    &nbsp;
                                </td>
                                <td style="width: 15%;">
                                    <label>Keadaan Ibu</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[post_partum][keadaan_ibu][pilihan]"
                                            {{ @$assesment['post_partum']['keadaan_ibu']['pilihan'] == 'Baik' ? 'checked' : '' }}
                                            type="radio" value="Baik">
                                        <label class="form-check-label" style="font-weight: 400;">Baik</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[post_partum][keadaan_ibu][pilihan]"
                                            {{ @$assesment['post_partum']['keadaan_ibu']['pilihan'] == 'Tidak baik' ? 'checked' : '' }}
                                            type="radio" value="Tidak baik">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak baik</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Tinggi Fu</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[post_partum][tinggi_fu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['post_partum']['tinggi_fu']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Konstrasksi Rahim</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[post_partum][konstraksi_rahim][pilihan]"
                                            {{ @$assesment['post_partum']['konstraksi_rahim']['pilihan'] == 'Baik' ? 'checked' : '' }}
                                            type="radio" value="Baik">
                                        <label class="form-check-label" style="font-weight: 400;">Baik</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[post_partum][konstraksi_rahim][pilihan]"
                                            {{ @$assesment['post_partum']['konstraksi_rahim']['pilihan'] == 'Tidak baik' ? 'checked' : '' }}
                                            type="radio" value="Tidak baik">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak baik</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Perdarahan</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[post_partum][perdarahan][pilihan]"
                                            {{ @$assesment['post_partum']['perdarahan']['pilihan'] == 'Ada' ? 'checked' : '' }}
                                            type="radio" value="Ada">
                                        <label class="form-check-label" style="font-weight: 400;">Ada</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[post_partum][perdarahan][pilihan]"
                                            {{ @$assesment['post_partum']['perdarahan']['pilihan'] == 'Tidak Ada' ? 'checked' : '' }}
                                            type="radio" value="Tidak Ada">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak Ada</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Terapi</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[post_partum][terapi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['post_partum']['terapi']}}">
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="6" style="width: 10%;">
                                    2 Jam Post Partum
                                </td>
                                <td rowspan="6" style="width: 15%;">
                                    &nbsp;
                                </td>
                                <td style="width: 15%;">
                                    <label>Keadaan Ibu</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[2_jam_post_partum][keadaan_ibu][pilihan]"
                                            {{ @$assesment['2_jam_post_partum']['keadaan_ibu']['pilihan'] == 'Baik' ? 'checked' : '' }}
                                            type="radio" value="Baik">
                                        <label class="form-check-label" style="font-weight: 400;">Baik</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[2_jam_post_partum][keadaan_ibu][pilihan]"
                                            {{ @$assesment['2_jam_post_partum']['keadaan_ibu']['pilihan'] == 'Tidak baik' ? 'checked' : '' }}
                                            type="radio" value="Tidak baik">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak baik</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Tensi (mmHg)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[2_jam_post_partum][tensi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['2_jam_post_partum']['tensi']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Nadi (x/menit)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[2_jam_post_partum][nadi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['2_jam_post_partum']['nadi']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Respirasi (x/menit)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[2_jam_post_partum][respirasi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['2_jam_post_partum']['respirasi']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Konstrasksi Rahim</label>
                                </td>
                                <td style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[2_jam_post_partum][konstraksi_rahim][pilihan]"
                                            {{ @$assesment['2_jam_post_partum']['konstraksi_rahim']['pilihan'] == 'Baik' ? 'checked' : '' }}
                                            type="radio" value="Baik">
                                        <label class="form-check-label" style="font-weight: 400;">Baik</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[2_jam_post_partum][konstraksi_rahim][pilihan]"
                                            {{ @$assesment['2_jam_post_partum']['konstraksi_rahim']['pilihan'] == 'Tidak baik' ? 'checked' : '' }}
                                            type="radio" value="Tidak baik">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak baik</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <label>Perdarahan (cc)</label>
                                </td>
                                <td style="width: 60%;">
                                    <input type="text" name="fisik[2_jam_post_partum][perdarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['2_jam_post_partum']['perdarahan']}}">
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 10%;">
                                    <label>Diagnosa :</label>
                                </td>
                                <td colspan="3" style="width: 60%;">
                                    <input type="text" name="fisik[diagnosa]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['diagnosa']}}">
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 10%;">
                                    <label>Konstrasepsi :</label>
                                </td>
                                <td colspan="3" style="width: 60%;">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[konstrasepsi][pilihan]"
                                            {{ @$assesment['konstrasepsi']['pilihan'] == 'Pil' ? 'checked' : '' }}
                                            type="radio" value="Pil">
                                        <label class="form-check-label" style="font-weight: 400;">Pil</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[konstrasepsi][pilihan]"
                                            {{ @$assesment['konstrasepsi']['pilihan'] == 'Suntik' ? 'checked' : '' }}
                                            type="radio" value="Suntik">
                                        <label class="form-check-label" style="font-weight: 400;">Suntik</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[konstrasepsi][pilihan]"
                                            {{ @$assesment['konstrasepsi']['pilihan'] == 'Implant' ? 'checked' : '' }}
                                            type="radio" value="Implant">
                                        <label class="form-check-label" style="font-weight: 400;">Implant</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[konstrasepsi][pilihan]"
                                            {{ @$assesment['konstrasepsi']['pilihan'] == 'AKDR' ? 'checked' : '' }}
                                            type="radio" value="AKDR">
                                        <label class="form-check-label" style="font-weight: 400;">AKDR</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[konstrasepsi][pilihan]"
                                            {{ @$assesment['konstrasepsi']['pilihan'] == 'MOW' ? 'checked' : '' }}
                                            type="radio" value="MOW">
                                        <label class="form-check-label" style="font-weight: 400;">MOW</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

                @if (empty(@$assesment))
                    <button class="btn btn-success pull-right">Simpan</button>
                @else
                    <button class="btn btn-danger pull-right">Perbarui</button>
                    <a href="{{url('emr-soap/pemeriksaan/cetak_laporan_persalinan' . '/' . $reg->id)}}" class="btn btn-warning pull-right" style="margin-right: 1rem;">Cetak</a>
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
    </script>
    
@endsection
