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

    .size-column-info {
        width: 70px; height: 40px;
    }

    .size-column-input {
        width: 120px; height: 40px;
    }

    .text-red {
        color: red;
        font-weight: bold;
    }

    .text-green {
        color: green;
        font-weight: bold;
    }

    .text-violet {
        color: rgb(153, 0, 255);
        font-weight: bold;
    }

    .text-black {
        color: black;
        font-weight: bold;
    }

    .w-50 {
        width: 50%;
    }
</style>
@section('header')
    <h1>Intensive Care Unit</h1>
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

            <div class="row">
                <div class="col-md-12">
                    @include('emr.modules.addons.tabs')
                </div>
                <br>
                <br><br>
                <form method="POST" action="{{ url('emr/icu/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
                    @php
                        $jam = array(7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 , 20, 21, 22, 23, 24, 1, 2, 3, 4, 5, 6);
                    @endphp
                    <div class="col-md-12" style="overflow: auto">
                        {{csrf_field()}}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                        <table style="width: 250%" class="border">
                            <h3 class="text-center" style="font-weight: bold; width: 250%;">INTENSIVE CARE UNIT</h3> <br><br>
                            <tbody>
                                <tr>
                                    <td colspan="29" class="border" style="background-color: red;">&nbsp;</td>
                                </tr>

                                {{-- JAM --}}

                                <tr>
                                    <td colspan="5"><h4 style="font-weight: bold; padding: 0 1rem">JAM</h4></td>
                                    <td class="text-center text-violet">07</td>
                                    <td class="text-center text-violet">08</td>
                                    <td class="text-center text-violet">09</td>
                                    <td class="text-center text-violet">10</td>
                                    <td class="text-center text-violet">11</td>
                                    <td class="text-center text-violet">12</td>
                                    <td class="text-center text-violet">13</td>
                                    <td class="text-center text-violet">14</td>
                                    <td class="text-center text-violet">15</td>
                                    <td class="text-center text-violet">16</td>
                                    <td class="text-center text-violet">17</td>
                                    <td class="text-center text-violet">18</td>
                                    <td class="text-center text-violet">19</td>
                                    <td class="text-center text-violet">20</td>
                                    <td class="text-center text-violet">21</td>
                                    <td class="text-center text-violet">22</td>
                                    <td class="text-center text-violet">23</td>
                                    <td class="text-center text-violet">24</td>
                                    <td class="text-center text-violet">01</td>
                                    <td class="text-center text-violet">02</td>
                                    <td class="text-center text-violet">03</td>
                                    <td class="text-center text-violet">04</td>
                                    <td class="text-center text-violet">05</td>
                                    <td class="text-center text-violet">06</td>
                                </tr>

                                {{-- TANDA VITAL --}}

                                @php
                                    $parameters = array(
                                        1 => ['HR <br> 200', 'T <br> 41', 'RR <br> 100', 'NIBP <br> 250'],
                                        2 => ['180', '40', '90', '225'],
                                        3 => ['160', '39', '80', '200'],
                                        4 => ['140', '38', '70', '175'],
                                        5 => ['120', '37', '60', '150'],
                                        6 => ['100', '36', '50', '125'],
                                        7 => ['80', '35', '40', '100'],
                                        8 => ['60', '34', '30', '75'],
                                        9 => ['40', '33', '20', '50'],
                                        10 => ['20', '32', '10', '25'],
                                        11 => ['0', '31', '0', '0'],
                                    );
                                @endphp

                                @foreach ($parameters as $key => $array)
                                    <tr>
                                        @if ($key == 1)
                                            <td class="text-center border" style="writing-mode: vertical-rl;text-orientation: upright;" rowspan="11"><h4 style="font-weight: bold;margin: 0; padding: 2rem 0; ">TANDA VITAL</h4></td>
                                        @endif
                                        <td class="text-center border size-column-info text-red">{!! $array[0] !!}</td>
                                        <td class="text-center border size-column-info text-green">{!! $array[1] !!}</td>
                                        <td class="text-center border size-column-info text-violet">{!! $array[2] !!}</td>
                                        <td class="text-center border size-column-info text-black ">{!! $array[3] !!}</td>
                                        @foreach ($jam as $j)
                                            <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[tanda_vital][{{$key}}][{{$j}}]" value="{{@$assesment['tanda_vital'][$key][$j]}}"></td>
                                        @endforeach
                                    </tr>                               
                                @endforeach

                                {{-- GAMBARAN EKG/VES --}}

                                <tr>
                                    <td class="border" colspan="5"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">GAMBARAN EKG/VES</h4></td>
                                    @foreach ($jam as $j)
                                        <td class="text-center border size-column-input">
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <input type="text" class="form-control" style="width: 40%;" name="fisik[gambaran_ekg_ves][{{$j}}][1]" value="{{@$assesment['gambaran_ekg_ves'][$j][1]}}">
                                                /
                                                <input type="text" class="form-control" style="width: 40%;" name="fisik[gambaran_ekg_ves][{{$j}}][2]" value="{{@$assesment['gambaran_ekg_ves'][$j][2]}}">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- SATURASI O2/ETCO2 --}}

                                <tr>
                                    <td class="border" colspan="5"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">SATURASI O2/EtCO2</h4></td>
                                    @foreach ($jam as $j)
                                        <td class="text-center border size-column-input">
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <input type="text" class="form-control" style="width: 40%;" name="fisik[saturasi_o2_etco2][{{$j}}][1]" value="{{@$assesment['saturasi_o2_etco2'][$j][1]}}">
                                                /
                                                <input type="text" class="form-control" style="width: 40%;" name="fisik[saturasi_o2_etco2][{{$j}}][2]" value="{{@$assesment['saturasi_o2_etco2'][$j][2]}}">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- HEMODINAMIK --}}

                                @php
                                    $parameters_hemodinamik = array(
                                        1 => ['IBP <br> 250', 'CO <br> 10', 'CVP <br> 25', 'PAP <br> 50'],
                                        2 => ['200', '8', '20', '40'],
                                        3 => ['150', '6', '15', '30'],
                                        4 => ['100', '4', '10', '20'],
                                        5 => ['50', '2', '5', '10'],
                                        6 => ['0', '36', '0', '0'],
                                    );
                                @endphp

                                @foreach ($parameters_hemodinamik as $key => $array)
                                    <tr>
                                        @if ($key == 1)
                                            <td class="text-center border" style="writing-mode: vertical-rl;text-orientation: upright;" rowspan="6"><h4 style="font-weight: bold;margin: 0; padding: 2rem 0; ">HEMODINAMIK</h4></td>
                                        @endif
                                        <td class="text-center border size-column-info text-red">{!! $array[0] !!}</td>
                                        <td class="text-center border size-column-info text-green">{!! $array[1] !!}</td>
                                        <td class="text-center border size-column-info text-violet">{!! $array[2] !!}</td>
                                        <td class="text-center border size-column-info text-black ">{!! $array[3] !!}</td>
                                        @foreach ($jam as $j)
                                            <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[hemodinamik][{{$key}}][{{$j}}]" value="{{@$assesment['hemodinamik'][$key][$j]}}"></td>
                                        @endforeach
                                    </tr>                               
                                @endforeach

                                {{-- GLASCOW COMA SCALE --}}

                                <tr>
                                    <td class="border" colspan="3"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">GLASCOW COMA SCALE</h4></td>
                                    <td class="border" colspan="2"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red text-center">E <br> <br> <br> M <br> <br> <br> V</h4></td>
                                    @foreach ($jam as $j)
                                        <td class="text-center border size-column-input">
                                            <div>
                                                <input type="text" class="form-control" name="fisik[gcs][{{$j}}][e]" value="{{@$assesment['gcs'][$j]['e']}}"><br>
                                                <input type="text" class="form-control" name="fisik[gcs][{{$j}}][m]" value="{{@$assesment['gcs'][$j]['m']}}"><br>
                                                <input type="text" class="form-control" name="fisik[gcs][{{$j}}][v]" value="{{@$assesment['gcs'][$j]['v']}}">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- UKURAN PUPIL --}}

                                <tr>
                                    <td class="border" colspan="3"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">UKURAN PUPIL</h4></td>
                                    <td class="border" colspan="2"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red text-center">Kanan <br> <br> <br> Kiri</h4></td>
                                    @foreach ($jam as $j)
                                    <td class="text-center border size-column-input">
                                            <div>
                                                <br>
                                                <input type="text" class="form-control" name="fisik[ukuran_pupil][{{$j}}][kanan]" value="{{@$assesment['ukuran_pupil'][$j]['kanan']}}"><br>
                                                <input type="text" class="form-control" name="fisik[ukuran_pupil][{{$j}}][kiri]" value="{{@$assesment['ukuran_pupil'][$j]['kiri']}}"><br>
                                                <br>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- SKALA NYERI --}}

                                <tr>
                                    <td class="border" colspan="3"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">SKALA NYERI</h4></td>
                                    <td class="border" colspan="2"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red text-center">CPOT, NRS <br> <br> <br> CS, FS <br> <br> <br> Nilai</h4></td>
                                    @foreach ($jam as $j)
                                    <td class="text-center border size-column-input">
                                            <div>
                                                <br>
                                                <input type="text" class="form-control" name="fisik[skala_nyeri][{{$j}}][cpot_nrs]" value="{{@$assesment['skala_nyeri'][$j]['cpot_nrs']}}"><br>
                                                <input type="text" class="form-control" name="fisik[skala_nyeri][{{$j}}][cs_fs]" value="{{@$assesment['skala_nyeri'][$j]['cs_fs']}}"><br>
                                                <input type="text" class="form-control" name="fisik[skala_nyeri][{{$j}}][nilai]" value="{{@$assesment['skala_nyeri'][$j]['nilai']}}"><br>
                                                <br>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- RISIKO JATUH --}}

                                <tr>
                                    <td class="border" colspan="5"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">RISIKO JATUH</h4></td>
                                    @foreach ($jam as $j)
                                        <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[risiko_jatuh][{{$j}}]" value="{{@$assesment['risiko_jatuh'][$j]}}"></td>
                                    @endforeach
                                </tr>

                                {{-- BRADEN SCALE --}}

                                <tr>
                                    <td class="border" colspan="5"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">BRADEN SCALE</h4></td>
                                    @foreach ($jam as $j)
                                        <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[braden_scale][{{$j}}]" value="{{@$assesment['braden_scale'][$j]}}"></td>
                                    @endforeach
                                </tr>
                                
                                {{-- VENTILASI --}}

                                @php
                                    $parameters_ventilasi = array(
                                        1 => ['TIPE', 'single'],
                                        2 => ['RR : SETING/AKTUAL', 'double'],
                                        3 => ['I : E RATIO', 'single'],
                                        4 => ['TV : SETING/AKTUAL', 'double'],
                                        5 => ['MV : SETING/AKTUAL', 'double'],
                                        6 => ['P.CONTROL/P.SUPP', 'double'],
                                        7 => ['PEEP', 'single'],
                                        8 => ['F102', 'single'],
                                        9 => ['PEAK/PLATEU PRESSURE', 'double'],
                                        10 => ['ETT/TC:DIAMETER/KEDALAMAN', 'double'],
                                    );
                                @endphp

                                @foreach ($parameters_ventilasi as $key => $array)
                                    <tr>
                                        @if ($key == 1)
                                            <td class="text-center border" style="writing-mode: vertical-rl;text-orientation: upright;" rowspan="10"><h4 style="font-weight: bold;margin: 0; padding: 2rem 0; ">VENTILASI</h4></td>
                                        @endif
                                        <td colspan="4" class="text-center border size-column-info text-violet">{{ $array[0] }}</td>
                                        @foreach ($jam as $j)
                                            @if ($array[1] == "single")
                                                <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[ventilasi][{{$key}}][{{$j}}][1]" value="{{@$assesment['ventilasi'][$key][$j][1]}}"></td>
                                            @else
                                                <td class="text-center border size-column-input">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[ventilasi][{{$key}}][{{$j}}][1]" value="{{@$assesment['ventilasi'][$key][$j][1]}}">
                                                        /
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[ventilasi][{{$key}}][{{$j}}][2]" value="{{@$assesment['ventilasi'][$key][$j][2]}}">
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>                               
                                @endforeach
                                
                                {{-- CAIRAN MASUK --}}

                                @php
                                    $transfusi = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'JUMLAH 1 JAM / KUMULATIF'];
                                    $makan = [1 => 'ORAL', 2 => 'ENTERAL', 3 => 'JUMLAH 1 JAM / KUMULATIF'];
                                @endphp

                                {{-- TRANSFUSI --}}

                                <tr>
                                    <td class="text-center border" style="writing-mode: vertical-rl;text-orientation: upright; width: 150px;" rowspan="30"><h4 style="font-weight: bold;margin: 0; padding: 2rem 0; ">CAIRAN MASUK</h4></td>
                                    <td colspan="1" rowspan="6" style="writing-mode: vertical-rl;text-orientation: upright;" class="text-center border size-column-info text-green">TRANSFUSI</td>
                                    <td colspan="3" class="text-center border text-violet">&nbsp;</td>
                                    @for ($i = 1; $i <= 24; $i++)
                                        <td class="text-center border text-violet size-column-input">CM / CA</td>
                                    @endfor
                                </tr>
                                @foreach ($transfusi as $key => $trans)
                                    <tr>
                                        <td colspan="3" class="text-center border {{$key == 5 ? 'text-red' : 'text-violet'}}">{{$trans}}</td>
                                        @foreach ($jam as $j)
                                            <td class="text-center border size-column-input">
                                                @if ($key == 5)
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_masuk][transfusi][jumlah_jam_kumulatif][{{$j}}][1]" value="{{@$assesment['cairan_masuk']['transfusi']['jumlah_jam_kumulatif'][$j][1]}}">
                                                        /
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_masuk][transfusi][jumlah_jam_kumulatif][{{$j}}][2]" value="{{@$assesment['cairan_masuk']['transfusi']['jumlah_jam_kumulatif'][$j][2]}}">
                                                    </div>
                                                @else
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_masuk][transfusi][{{$key}}][{{$j}}][cm]" value="{{@$assesment['cairan_masuk']['transfusi'][$key][$j][cm]}}">
                                                        /
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_masuk][transfusi][{{$key}}][{{$j}}][ca]" value="{{@$assesment['cairan_masuk']['transfusi'][$key][$j][ca]}}">
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>                           
                                @endforeach

                                {{-- MAKAN --}}

                                <tr>
                                    <td colspan="1" rowspan="4" style="writing-mode: vertical-rl;text-orientation: upright;" class="text-center border size-column-info text-green">MAKAN</td>
                                </tr>
                                @foreach ($makan as $key => $mak)
                                    <tr>
                                        <td colspan="3" class="text-center border {{$key == 3 ? 'text-red' : 'text-violet'}}">{{$mak}}</td>
                                        @foreach ($jam as $j)
                                            @if ($key == 3)
                                                <td class="text-center border size-column-input">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_masuk][makan][jumlah_jam_kumulatif][{{$j}}][1]" value="{{@$assesment['cairan_masuk']['makan']['jumlah_jam_kumulatif'][$j][1]}}">
                                                        /
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_masuk][makan][jumlah_jam_kumulatif][{{$j}}][2]" value="{{@$assesment['cairan_masuk']['makan']['jumlah_jam_kumulatif'][$j][2]}}">
                                                    </div>
                                                </td>
                                            @else
                                                <td class="text-center border size-column-input">
                                                    <input type="text" class="form-control" name="fisik[cairan_masuk][makan][{{$key}}][{{$j}}]" value="{{@$assesment['cairan_masuk']['makan'][$key][$j]}}">
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>                           
                                @endforeach

                                {{-- PARENTERAL --}}

                                <tr>
                                    <td colspan="1" rowspan="20" style="writing-mode: vertical-rl;text-orientation: upright;" class="text-center border size-column-info text-green">PARENTERAL</td>
                                </tr>
                                @for ($i = 1; $i <= 18; $i++)
                                    <tr>
                                        <td colspan="3" class="text-center border">&nbsp;</td>
                                        @foreach ($jam as $j)
                                                <td class="text-center border size-column-input">
                                                    <input type="text" class="form-control" name="fisik[cairan_masuk][parenteral][{{$key}}][{{$j}}]" value="{{@$assesment['cairan_masuk']['parenteral'][$key][$j]}}">
                                                </td>
                                        @endforeach
                                    </tr>                           
                                @endfor

                                <tr>
                                    <td colspan="3" class="text-center border text-red">JUMLAH 1 JAM / KUMULATIF</td>
                                    @foreach ($jam as $j)
                                            <td class="text-center border size-column-input">
                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                    <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_masuk][parenteral][jumlah_jam_kumulatif][{{$j}}][1]" value="{{@$assesment['cairan_masuk']['parenteral']['jumlah_jam_kumulatif'][$j][1]}}">
                                                    /
                                                    <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_masuk][parenteral][jumlah_jam_kumulatif][{{$j}}][2]" value="{{@$assesment['cairan_masuk']['parenteral']['jumlah_jam_kumulatif'][$j][2]}}">
                                                </div>
                                            </td>
                                    @endforeach
                                </tr>

                                {{-- KUMULATIF --}}

                                <tr>
                                    <td class="border" colspan="5"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">KUMULATIF</h4></td>
                                    @foreach ($jam as $j)
                                        <td class="text-center border size-column-input">
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <input type="text" class="form-control" style="width: 40%;" name="fisik[kumulatif][{{$j}}][1]" value="{{@$assesment['kumulatif'][$j][1]}}">
                                                /
                                                <input type="text" class="form-control" style="width: 40%;" name="fisik[kumulatif][{{$j}}][2]" value="{{@$assesment['kumulatif'][$j][2]}}">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- CAIRAN KELUAR --}}

                                @php
                                    $parameters_cairan_keluar = array(
                                        1 => 'URINE',
                                        2 => 'NGT',
                                        3 => 'BAB',
                                        4 => 'DRAIN I',
                                        5 => 'DRAIN II',
                                        6 => 'DRAIN III',
                                        7 => 'IWL',
                                        8 => 'JUMLAH 1 JAM / KUMULATIF'
                                    );
                                @endphp

                                @foreach ($parameters_cairan_keluar as $key => $array)
                                    <tr>
                                        @if ($key == 1)
                                            <td class="text-center border" style="writing-mode: vertical-rl;text-orientation: upright;" rowspan="8"><h4 style="font-weight: bold;margin: 0; padding: 2rem 0; ">CAIRAN KELUAR</h4></td>
                                        @endif
                                        <td colspan="4" class="text-center border size-column-info {{$key == 8 ? 'text-red' : 'text-violet'}}">{{ $array }}</td>
                                        @foreach ($jam as $j)
                                            @if ($key != 8)
                                                <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[cairan_keluar][{{$key}}][{{$j}}][1]" value="{{@$assesment['cairan_keluar'][$key][$j][1]}}"></td>
                                            @else
                                                <td class="text-center border size-column-input">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_keluar][jumlah_jam_kumulatif][{{$j}}][1]" value="{{@$assesment['cairan_keluar']['jumlah_jam_kumulatif'][$j][1]}}">
                                                        /
                                                        <input type="text" class="form-control" style="width: 40%;" name="fisik[cairan_keluar][jumlah_jam_kumulatif][{{$j}}][2]" value="{{@$assesment['cairan_keluar']['jumlah_jam_kumulatif'][$j][2]}}">
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>                               
                                @endforeach

                                 {{-- KESEIMBANGAN CAIRAN --}}

                                 <tr>
                                    <td class="border" colspan="5"><h4 style="font-weight: bold; padding: 0 1rem" class="text-red">KESEIMBANGAN CAIRAN</h4></td>
                                    @foreach ($jam as $j)
                                        <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[keseimbangan_cairan][{{$j}}]" value="{{@$assesment['keseimbangan_cairan'][$j]}}"></td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 250%" class="border">
                            <tr>
                                <td colspan="31" class="border" style="background-color: red;">&nbsp;</td>
                            </tr>

                            {{-- CATATAN PENGOBATAN --}}

                            @php
                                $parameters_catatan_pengobatan = array(
                                    "nama_dokter" => 'Nama Dokter Pemberi Instruksi',
                                    "nama_obat" => 'Nama Obat, Kekuatan dan Bentuk Sediaan',
                                    "aturan_pakai" => 'Aturan pakai dan Rute Pemberian',
                                    "tgl_mulai" => 'Tanggal Mulai',
                                    "tgl_stop" => 'Tanggal Stop',
                                    "verif_apotek" => 'Verifikasi Apoteker',
                                );
                            @endphp

                            <tr>
                                <td class="text-center border" style="writing-mode: vertical-rl;text-orientation: upright; width: 150px;" rowspan="19"><h4 style="font-weight: bold;margin: 0; padding: 2rem 0; ">CATATAN PENGOBATAN</h4></td>
                                @foreach ($parameters_catatan_pengobatan as $array)
                                    <td class="text-center border size-column-info text-black">{!! $array !!}</td>
                                @endforeach
                                <td class="text-center text-black border">07</td>
                                <td class="text-center text-black border">08</td>
                                <td class="text-center text-black border">09</td>
                                <td class="text-center text-black border">10</td>
                                <td class="text-center text-black border">11</td>
                                <td class="text-center text-black border">12</td>
                                <td class="text-center text-black border">13</td>
                                <td class="text-center text-black border">14</td>
                                <td class="text-center text-black border">15</td>
                                <td class="text-center text-black border">16</td>
                                <td class="text-center text-black border">17</td>
                                <td class="text-center text-black border">18</td>
                                <td class="text-center text-black border">19</td>
                                <td class="text-center text-black border">20</td>
                                <td class="text-center text-black border">21</td>
                                <td class="text-center text-black border">22</td>
                                <td class="text-center text-black border">23</td>
                                <td class="text-center text-black border">24</td>
                                <td class="text-center text-black border">01</td>
                                <td class="text-center text-black border">02</td>
                                <td class="text-center text-black border">03</td>
                                <td class="text-center text-black border">04</td>
                                <td class="text-center text-black border">05</td>
                                <td class="text-center text-black border">06</td>
                            </tr>
                            @for ($i = 1; $i <= 18; $i++)
                                <tr>
                                    @foreach ($parameters_catatan_pengobatan as $key => $text)
                                            <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[catatan_pengobatan][{{$i}}][{{$key}}]" value="{{@$assesment['catatan_pengobatan'][$i][$key]}}"></td>
                                        @endforeach
                                    @foreach ($jam as $j)
                                            <td class="border  size-column-input"><input type="text" class="form-control" name="fisik[catatan_pengobatan][{{$i}}][{{$j}}]" value="{{@$assesment['catatan_pengobatan'][$i][$j]}}"></td>
                                    @endforeach
                                </tr>
                            @endfor
                            
                            <tr>
                                <td colspan="31">
                                    <img src="{{asset('icu.png')}}" style="width: 40%;" alt="icu_info">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br><br>
                    <button class="btn btn-success pull-right">Simpan</button>
                </form>
            </div>
            
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
