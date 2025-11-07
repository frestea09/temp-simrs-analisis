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

    .border {
        border: 1px solid black;
    }
    
    .bold {
        font-weight: bold;
    }

    .p-1 {
        padding: 1rem !important;
    }

    .background-green {
        background-color: rgb(0, 179, 0) !important;
        color: white;
    }
    .background-red {
        background-color: red !important;
        color: white;
    }
    .background-blue {
        background-color: blue !important;
        color: white;
    }
</style>
@section('header')
    <h1>Catatan Harian</h1>
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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/catatan-harian/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('assesment_id', @$riwayat->id) !!}
                        <h4 style="text-align: center; padding: 10px"><b>Catatan Harian</b></h4>
                        <br>
                    </div>
                </div>

                @php
                    $shift = [
                        "p",
                        "s",
                        "m",
                    ];

                    $params = [
                        "1" => [
                            "respirasi" => 104,
                            "nadi" => 280,
                            "suhu" => 42,
                        ],
                        "2" => [
                            "respirasi" => 100,
                            "nadi" => 270,
                            "suhu" => null,
                        ],
                        "3" => [
                            "respirasi" => 96,
                            "nadi" => 260,
                            "suhu" => null,
                        ],
                        "4" => [
                            "respirasi" => 92,
                            "nadi" => 250,
                            "suhu" => 41,
                        ],
                        "5" => [
                            "respirasi" => 88,
                            "nadi" => 240,
                            "suhu" => null,
                        ],
                        "6" => [
                            "respirasi" => 84,
                            "nadi" => 230,
                            "suhu" => null,
                        ],
                        "7" => [
                            "respirasi" => 80,
                            "nadi" => 220,
                            "suhu" => 40,
                        ],
                        "8" => [
                            "respirasi" => 76,
                            "nadi" => 210,
                            "suhu" => null,
                        ],
                        "9" => [
                            "respirasi" => 72,
                            "nadi" => 200,
                            "suhu" => null,
                        ],
                        "10" => [
                            "respirasi" => 68,
                            "nadi" => 190,
                            "suhu" => 39,
                        ],
                        "11" => [
                            "respirasi" => 64,
                            "nadi" => 180,
                            "suhu" => null,
                        ],
                        "12" => [
                            "respirasi" => 60,
                            "nadi" => 170,
                            "suhu" => null,
                        ],
                        "13" => [
                            "respirasi" => 56,
                            "nadi" => 160,
                            "suhu" => 38,
                        ],
                        "14" => [
                            "respirasi" => 52,
                            "nadi" => 150,
                            "suhu" => null,
                        ],
                        "15" => [
                            "respirasi" => 48,
                            "nadi" => 140,
                            "suhu" => null,
                        ],
                        "16" => [
                            "respirasi" => 44,
                            "nadi" => 130,
                            "suhu" => 37,
                        ],
                        "17" => [
                            "respirasi" => 40,
                            "nadi" => 120,
                            "suhu" => null,
                        ],
                        "18" => [
                            "respirasi" => 38,
                            "nadi" => 110,
                            "suhu" => null,
                        ],
                        "19" => [
                            "respirasi" => 32,
                            "nadi" => 100,
                            "suhu" => 36,
                        ],
                        "21" => [
                            "respirasi" => 28,
                            "nadi" => 90,
                            "suhu" => null,
                        ],
                        "22" => [
                            "respirasi" => 24,
                            "nadi" => 80,
                            "suhu" => null,
                        ],
                        "23" => [
                            "respirasi" => 20,
                            "nadi" => 70,
                            "suhu" => 35,
                        ],
                        "24" => [
                            "respirasi" => 16,
                            "nadi" => 60,
                            "suhu" => null,
                        ],
                        "25" => [
                            "respirasi" => 12,
                            "nadi" => 50,
                            "suhu" => null,
                        ],
                        "26" => [
                            "respirasi" => 8,
                            "nadi" => 40,
                            "suhu" => 34,
                        ],
                    ];
                @endphp
                <div class="row">

                    <div class="col-md-12" style="overflow: auto;">
                        <table style="width: 150%"
                            class="border"
                            style="font-size:12px;">
                            <tr class="border">
                                <td class="border bold p-1" colspan="3">Tanggal</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    <td class="border" colspan="6">
                                        <input type="text" name="fisik[catatan_harian][{{$i}}][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i]['tanggal']}}">
                                    </td>
                                @endfor
                            </tr>
                            <tr class="border">
                                <td class="border bold p-1 background-green">Respirasi</td>
                                <td class="border bold p-1 background-red">Nadi</td>
                                <td class="border bold p-1 background-blue">Suhu</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold p-1 text-center" colspan="2">{{$s}}</td>
                                    @endforeach
                                @endfor
                            </tr>
                            @foreach ($params as $key => $p)
                                <tr class="border">
                                    <td class="border bold p-1 text-center background-green">{{$p['respirasi']}}</td>
                                    <td class="border bold p-1 text-center background-red">{{$p['nadi']}}</td>
                                    @if ($p['suhu'])
                                        <td class="border bold p-1 text-center background-blue" style="vertical-align: top;" rowspan="{{$key == 26 ? "1" : "3"}}">{{$p['suhu']}}</td>
                                    @endif
                                    @for ($i = 1; $i <= 7; $i++)
                                        @foreach ($shift as $s)
                                            <td class="border bold text-center">
                                                <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][1][{{$key}}]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['1'][$key]}}">
                                            </td>
                                            <td class="border bold text-center">
                                                <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][2][{{$key}}]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['2'][$key]}}">
                                            </td>
                                        @endforeach
                                    @endfor
                                </tr>
                            @endforeach
                            <tr class="border">
                                <td class="border bold p-1" colspan="3">Tekanan Darah</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][tekanan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['tekanan_darah']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                <td class="border bold p-1" colspan="3">Berat Badan (Kg)</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][berat_badan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['berat_badan']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                <td class="border bold p-1" style="vertical-align: top;" rowspan="4" colspan="3">Cairan Infus</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][cairan_infus_1]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['cairan_infus_1']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][cairan_infus_2]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['cairan_infus_2']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][cairan_infus_3]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['cairan_infus_3']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][cairan_infus_4]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['cairan_infus_4']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                <td class="border bold p-1" colspan="3">EWS</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][ews]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['ews']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                <td class="border bold p-1" colspan="3">Diet (D)</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][diet]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['diet']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                <td class="border bold p-1" colspan="3">Intake</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][intake]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['intake']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                <td class="border bold p-1" colspan="3">OUTPUT (Diuresis / BAK)</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][diuresis]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['diuresis']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                            <tr class="border">
                                <td class="border bold p-1" colspan="3">OUTPUT (Defekasi / BAB)</td>
                                @for ($i = 1; $i <= 7; $i++)
                                    @foreach ($shift as $s)
                                        <td class="border bold  text-center" colspan="2">
                                            <input type="text" name="fisik[catatan_harian][{{$i}}][{{$s}}][defekasi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['catatan_harian'][$i][$s]['defekasi']}}">
                                        </td>
                                    @endforeach
                                @endfor
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table style="width: 100%"
                            class="table table-striped table-bordered table-hover table-condensed form-box"
                            style="font-size:12px;">
                            <h5 class="text-center"><b>LEMBAR OBSERVASI</b></h5>
                            <tr>
                                <td style="width:50%; font-weight:500;">Frekuensi Nafas</td>
                                <td>
                                    <div style="">
                                        <div>
                                            <input class="hitungSkor" type="radio" id="frekuensi_nafas_1"
                                                name="fisik[lembar_observasi][frekuensi_nafas][pilihan]" value="0"
                                                {{ @$assesment['lembar_observasi']['frekuensi_nafas']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="frekuensi_nafas_1" style="font-weight: normal;">
                                                < 60 x/mnt<b>(0 Skor)</b>
                                            </label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="frekuensi_nafas_2"
                                                name="fisik[lembar_observasi][frekuensi_nafas][pilihan]" value="1"
                                                {{ @$assesment['lembar_observasi']['frekuensi_nafas']['pilihan'] == '1' ? 'checked' : '' }}>
                                            <label for="frekuensi_nafas_2" style="font-weight: normal;">60 - 80 x/mnt <b>(1
                                                    Skor)</b></label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="frekuensi_nafas_3"
                                                name="fisik[lembar_observasi][frekuensi_nafas][pilihan]" value="2"
                                                {{ @$assesment['lembar_observasi']['frekuensi_nafas']['pilihan'] == '2' ? 'checked' : '' }}>
                                            <label for="frekuensi_nafas_3" style="font-weight: normal;">> 80 x/mnt<b>(2
                                                    Skor)</b></label><br />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%; font-weight:500;">Retraksi</td>
                                <td>
                                    <div style="">
                                        <div>
                                            <input class="hitungSkor" type="radio" id="retraksi_1"
                                                name="fisik[lembar_observasi][retraksi][pilihan]" value="0"
                                                {{ @$assesment['lembar_observasi']['retraksi']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="retraksi_1" style="font-weight: normal;">
                                                Tidak ada retraksi<b>(0 Skor)</b>
                                            </label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="retraksi_2"
                                                name="fisik[lembar_observasi][retraksi][pilihan]" value="1"
                                                {{ @$assesment['lembar_observasi']['retraksi']['pilihan'] == '1' ? 'checked' : '' }}>
                                            <label for="retraksi_2" style="font-weight: normal;">Retraksi ringan <b>(1
                                                    Skor)</b></label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="retraksi_3"
                                                name="fisik[lembar_observasi][retraksi][pilihan]" value="2"
                                                {{ @$assesment['lembar_observasi']['retraksi']['pilihan'] == '2' ? 'checked' : '' }}>
                                            <label for="retraksi_3" style="font-weight: normal;">Retraksi berat<b>(2
                                                    Skor)</b></label><br />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%; font-weight:500;">Sianosis</td>
                                <td>
                                    <div style="">
                                        <div>
                                            <input class="hitungSkor" type="radio" id="sianosis_1"
                                                name="fisik[lembar_observasi][sianosis][pilihan]" value="0"
                                                {{ @$assesment['lembar_observasi']['sianosis']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="sianosis_1" style="font-weight: normal;">
                                                Tidak ada sianosis<b>(0 Skor)</b>
                                            </label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="sianosis_2"
                                                name="fisik[lembar_observasi][sianosis][pilihan]" value="1"
                                                {{ @$assesment['lembar_observasi']['sianosis']['pilihan'] == '1' ? 'checked' : '' }}>
                                            <label for="sianosis_2" style="font-weight: normal;">Sianosis hilang dengan Pemberian O2 <b>(1
                                                    Skor)</b></label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="sianosis_3"
                                                name="fisik[lembar_observasi][sianosis][pilihan]" value="2"
                                                {{ @$assesment['lembar_observasi']['sianosis']['pilihan'] == '2' ? 'checked' : '' }}>
                                            <label for="sianosis_3" style="font-weight: normal;">Sianosis menetap walau diberi O2<b>(2
                                                    Skor)</b></label><br />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%; font-weight:500;">Suara nafas</td>
                                <td>
                                    <div style="">
                                        <div>
                                            <input class="hitungSkor" type="radio" id="suara_nafas_1"
                                                name="fisik[lembar_observasi][suara_nafas][pilihan]" value="0"
                                                {{ @$assesment['lembar_observasi']['suara_nafas']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="suara_nafas_1" style="font-weight: normal;">
                                                Suara nafas kedua paru baik<b>(0 Skor)</b>
                                            </label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="suara_nafas_2"
                                                name="fisik[lembar_observasi][suara_nafas][pilihan]" value="1"
                                                {{ @$assesment['lembar_observasi']['suara_nafas']['pilihan'] == '1' ? 'checked' : '' }}>
                                            <label for="suara_nafas_2" style="font-weight: normal;">Suara nafas kedua paru menurun <b>(1
                                                    Skor)</b></label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="suara_nafas_3"
                                                name="fisik[lembar_observasi][suara_nafas][pilihan]" value="2"
                                                {{ @$assesment['lembar_observasi']['suara_nafas']['pilihan'] == '2' ? 'checked' : '' }}>
                                            <label for="suara_nafas_3" style="font-weight: normal;">Tidak ada suara nafas di kedua paru baik<b>(2
                                                    Skor)</b></label><br />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%; font-weight:500;">Merintih</td>
                                <td>
                                    <div style="">
                                        <div>
                                            <input class="hitungSkor" type="radio" id="merintih_1"
                                                name="fisik[lembar_observasi][merintih][pilihan]" value="0"
                                                {{ @$assesment['lembar_observasi']['merintih']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="merintih_1" style="font-weight: normal;">Tidak merintih<b>(0
                                                    Skor)</b></label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="merintih_2"
                                                name="fisik[lembar_observasi][merintih][pilihan]" value="1"
                                                {{ @$assesment['lembar_observasi']['merintih']['pilihan'] == '1' ? 'checked' : '' }}>
                                            <label for="merintih_2" style="font-weight: normal;">Dapat di dengar dengan
                                                stetoskop <b>(1 Skor)</b></label><br />
                                        </div>
                                        <div>
                                            <input class="hitungSkor" type="radio" id="merintih_3"
                                                name="fisik[lembar_observasi][merintih][pilihan]" value="2"
                                                {{ @$assesment['lembar_observasi']['merintih']['pilihan'] == '2' ? 'checked' : '' }}>
                                            <label for="merintih_3" style="font-weight: normal;">Dapat di dengar tanpa
                                                alat bantu<b>(2 Skor)</b></label><br />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%; font-weight:500;">JUMLAH SKOR</td>
                                <td>
                                    <input type="number" name="fisik[lembar_observasi][jumlahSkor][angka]"
                                        style="display:inline-block; width: 100%;" class="form-control jumlahSkor"
                                        id=""
                                        value="{{ @$assesment['lembar_observasi']['jumlahSkor']['angka'] }}"
                                        readonly>
                                    <br><br>
                                    <input type="text" name="fisik[lembar_observasi][jumlahSkor][hasil]"
                                        style="display:inline-block; width: 100%;" class="form-control hasilSkor"
                                        id=""
                                        value="{{ @$assesment['lembar_observasi']['jumlahSkor']['hasil'] }}"
                                        readonly>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

                <button class="btn btn-success pull-right">Simpan</button>
            </form>
            <br />

        </div>
        <div class="col-md-12">
            <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th colspan="4" class="text-center" style="vertical-align: middle;">History</th>
                </tr>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                  <th class="text-center" style="vertical-align: middle;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @if (count($riwayats) == 0)
                    <tr>
                        <td colspan="4" class="text-center">Tidak Ada Riwayat Apgar Score</td>
                    </tr>
                @endif
                @foreach ($riwayats as $riwayat)
                @php
                  @$apgar_score = @json_decode(@$riwayat->fisik)->apgar_score;
                @endphp
                    <tr>
                        <td style="text-align: center; {{ $riwayat->id == request()->apgar_score_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{@Carbon\Carbon::parse(@$apgar_score->tanggal)->format('d-m-Y')}}
                        </td>
                        <td style="text-align: center; {{ $riwayat->id == request()->apgar_score_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            <a href="{{ url("emr-soap/pemeriksaan/inap/catatan-harian/".$unit."/".@$riwayat->registrasi_id."?asessment_id=".@$riwayat->id) }}" class="btn btn-warning btn-sm">
                              <i class="fa fa-pencil"></i>
                            </a>
                            {{-- <a href="{{ url("emr-soap/pemeriksaan/cetak_apgar_score/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-info btn-sm">
                              <i class="fa fa-print"></i>
                            </a>
                            <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                              <i class="fa fa-trash"></i>
                            </a> --}}
                        </td>
                    </tr>
                    <tr>
                      <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                        <i>Dibuat : {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }}</i>
                      </td>
                    </tr>
                @endforeach
              
              </tbody>
            </table>
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
        $('.hitungSkor').on('change', function (){
          var total = 0 ;
          var hasil = $('.hasilSkor');
          $('.hitungSkor:checked').each(function (){
            total += parseInt($(this).val());
          });

          $('.jumlahSkor').val(total);

          if(total <= 3){
            hasil.val('Gawat napas ringan -> Perawatan Tk II A');
          }else if(total <= 5){
            hasil.val('Gawat napas sedang -> Perawatan Tk II B');
          }else if(total >= 6){
            hasil.val('Gawat napas berat -> perawatan Tk III (NICU)');
          }
        });
    </script>
@endsection
