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

    input.selected_point {
        width: 35px;
        height: 35px;
        padding: 0 !important;
        margin: 0 !important;
        /* visibility: hidden; */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border: none;
        position: relative;
        -webkit-print-color-adjust: exact;//:For Chrome
        color-adjust: exact;//:For Firefox
    }

    input.selected_point:hover {
        cursor: pointer;
        background-color: rgb(255, 133, 133);
    }

    input.selected_point:checked {
        background-color: red;
    }

    @media print {
        input.chosen_point:checked {
            background-color: red !important;
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

    .border {
        border: 1px solid black;
    }

    tr, td {
        padding: 0 !important;
        margin: 0 !important;
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

    .bold {
        font-weight: bold;
    }
    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@section('header')
    <h1>Formulir Surveilans Infeksi</h1>
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
            <form method="POST" id="partograf-form" action="{{ url('emr-soap/pemeriksaan/inap/partograf/' . $unit . '/' . $reg->id) }}"
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
                        <input type="hidden" id="data-partograf" name="partograf">
                          <h4 style="text-align: center; padding: 10px"><b>PARTOGRAF</b></h4>
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
                                <th class="text-center" style="vertical-align: middle;">User</th>
                                <th class="text-center" style="vertical-align: middle;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            @if (count($riwayats) == 0)
                                <tr>
                                    <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                                </tr>
                            @endif
                            @foreach ($riwayats as $riwayat)
                                <tr>
                                    <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                        {{Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                                    </td>
                                    <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                        {{ @$riwayat->user->name }}
                                    </td>
                                    <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                        <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url('emr-soap/pemeriksaan/cetak_partograf'."/".@$riwayat->registrasi_id) }}" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
                                        <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                        <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                    <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                                    </td>
                                </tr>
                            @endforeach
                            
                            </tbody>
                      </table>
                    </div>
                    <div class="col-md-6">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width:30%; font-weight:bold;">Nama Ibu</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[nama_ibu]" style="width: 100%" value="{{@$assesment['nama_ibu']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="fisik[tanggal]" style="width: 100%" value="{{@$assesment['tanggal']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Ketuban Pecah sejak jam</td>
                                <td>
                                    <input type="datetime-local" class="form-control" name="fisik[ketuban_pecah_sejak_jam]" style="width: 100%" value="{{@$assesment['ketuban_pecah_sejak_jam']}}">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width:30%; font-weight:bold;">Umur</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[ibu]" style="width: 100%" value="{{@$assesment['ibu']}}">
                                    <label class="form-check-label" style="font-weight: bold;">G :</label>
                                    <input type="text" name="fisik[G]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['G']}}">
                                    <label class="form-check-label" style="font-weight: bold;">P :</label>
                                    <input type="text" name="fisik[P]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['P']}}">
                                    <label class="form-check-label" style="font-weight: bold;">A :</label>
                                    <input type="text" name="fisik[A]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['A']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Jam</td>
                                <td>
                                    <input type="time" class="form-control" name="fisik[tanggal]" style="width: 100%" value="{{@$assesment['tanggal']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Mules sejak jam</td>
                                <td>
                                    <input type="time" class="form-control" name="fisik[mules_sejak_jam]" style="width: 100%" value="{{@$assesment['mules_sejak_jam']}}">
                                </td>
                            </tr>

                            {{-- Input Hidden Gambar --}}
                            <input type="hidden" id="gambar-partograf" name="gambar_partograf">
                        </table>
                    </div>

                    {{-- Denyut Jantung --}}
                    {{-- <div class="col-md-12">
                        @php
                            $param_denyut_jantung = [
                                '200',
                                '190',
                                '180',
                                '170',
                                '160',
                                '150',
                                '140',
                                '130',
                                '120',
                                '110',
                                '100',
                                '90',
                                '80',
                            ]
                        @endphp
                        <table class="border" >
                            @foreach ($param_denyut_jantung as $key => $param)
                                <tr>
                                    @if ($key == 0)
                                        <td rowspan="13" style="width: 300px; padding: 1rem !important">
                                            <b>Denyut Jantung (menit)</b>
                                        </td>
                                    @endif
                                    <td style="width: 50px" class="text-center">{{$param}}</td>
                                    @for ($i = 1; $i <= 32; $i++)
                                        <td class="border">
                                            <input type="hidden" name="fisik[denyut_jantung][{{$param}}][{{$i}}]"  value="">
                                            <input type="checkbox" name="fisik[denyut_jantung][{{$param}}][{{$i}}]" class="selected_point" {{@$assesment['denyut_jantung'][$param][$i] == "selected" ? 'checked' : ''}} value="selected">
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </table>
                    </div> --}}

                    {{-- Air Ketuban --}}
                    {{-- <div class="col-md-12" style="margin-top: 2rem;">
                        <table class="border" >
                            @for ($a = 1; $a <= 2; $a++)
                                <tr>
                                    @if ($a == 1)
                                        <td rowspan="13" colspan="2" style="width: 300px; padding: 1rem !important">
                                            <b>Air Ketuban Penyusutan</b>
                                        </td>
                                    @endif
                                    @for ($i = 1; $i <= 32; $i++)
                                        <td class="border">
                                            <input type="hidden" name="fisik[air_ketuban][{{$a}}][{{$i}}]"  value="">
                                            <input type="checkbox" name="fisik[air_ketuban][{{$a}}][{{$i}}]" class="selected_point" {{@$assesment['air_ketuban'][$a][$i] == "selected" ? 'checked' : ''}} value="selected">
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </table>
                    </div> --}}

                    {{-- Jam --}}
                    {{-- <div class="col-md-12" style="margin-top: 2rem;">
                        @php
                            $param_jam = [
                                '10',
                                '9',
                                '8',
                                '7',
                                '6',
                                '5',
                                '4',
                                '3',
                                '2',
                                '1',
                                '0',
                            ]
                        @endphp
                        <table class="border" >
                            @foreach ($param_jam as $key => $param)
                                <tr>
                                    @if ($key == 0)
                                        <td rowspan="11" style="width: 300px; padding: 1rem !important">
                                            <b>Jam</b>
                                        </td>
                                    @endif
                                    <td style="width: 50px" class="text-center">{{$param}}</td>
                                    @for ($i = 1; $i <= 32; $i++)
                                        <td class="border">
                                            <input type="hidden" name="fisik[jam_waspada_bertindak][{{$param}}][{{$i}}]"  value="">
                                            <input type="checkbox" name="fisik[jam_waspada_bertindak][{{$param}}][{{$i}}]" class="selected_point" {{@$assesment['jam_waspada_bertindak'][$param][$i] == "selected" ? 'checked' : ''}} value="selected">
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                            <tr>
                                <td rowspan="2" colspan="2" class="border" style="width: 300px; padding: 1rem !important;">
                                    <b>Waktu (Jam)</b>
                                </td>
                                @for ($b = 1; $b <= 16; $b++)
                                    <td colspan="2" class="border text-center bold" style="padding: 1rem !important">{{$b}}</td>
                                @endfor
                            </tr>
                            <tr>
                                 @for ($c = 1; $c <= 16; $c++)
                                    <td colspan="2" class="border text-center bold">
                                        <input type="text" class="form-control" name="fisik[waktu_waspasa_bertindak][{{$c}}]" style="width: 100%" value="{{@$assesment['waktu_waspasa_bertindak'][$c]}}">
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </div> --}}

                    {{-- Kontraksi Tiap --}}
                    {{-- <div class="col-md-12" style="margin-top: 2rem;">
                        @php
                            $param_jam = [
                                '5',
                                '4',
                                '3',
                                '2',
                                '1',
                            ]
                        @endphp
                        <table class="border" >
                            @foreach ($param_jam as $key => $param)
                                <tr>
                                    @if ($key == 0)
                                        <td rowspan="11" style="width: 300px; padding: 1rem !important">
                                            <b>(Detik)</b>
                                        </td>
                                    @endif
                                    <td style="width: 50px" class="text-center">{{$param}}</td>
                                    @for ($i = 1; $i <= 32; $i++)
                                        <td class="border">
                                            <input type="hidden" name="fisik[kontraksi_detik][{{$param}}][{{$i}}]"  value="">
                                            <input type="checkbox" name="fisik[kontraksi_detik][{{$param}}][{{$i}}]" class="selected_point" {{@$assesment['kontraksi_detik'][$param][$i] == "selected" ? 'checked' : ''}} value="selected">
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </table>
                    </div> --}}

                     {{-- Oksitosin U/L --}}
                     {{-- <div class="col-md-12" style="margin-top: 2rem;">
                        <table class="border" >
                            @for ($a = 1; $a <= 2; $a++)
                                <tr>
                                    @if ($a == 1)
                                        <td rowspan="13" colspan="2" style="width: 300px; padding: 1rem !important">
                                            <b>Oksitosin U/L</b>
                                        </td>
                                    @endif
                                    @for ($i = 1; $i <= 32; $i++)
                                        <td class="border">
                                            <input type="hidden" name="fisik[oksitosin][{{$a}}][{{$i}}]"  value="">
                                            <input type="checkbox" name="fisik[oksitosin][{{$a}}][{{$i}}]" class="selected_point" {{@$assesment['oksitosin'][$a][$i] == "selected" ? 'checked' : ''}} value="selected">
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </table>
                    </div> --}}

                    
                    {{-- Obat dan Cairan --}}
                    {{-- <div class="col-md-12" style="margin-top: 2rem;">
                        <table class="border">
                            <tr>
                                <td rowspan="1" colspan="2" class="border" style="width: 300px; padding: 1rem !important;">
                                    <b>Obat dan Cairan IV</b>
                                </td>
                                @for ($c = 1; $c <= 16; $c++)
                                   <td colspan="2" class="border text-center bold">
                                       <input type="text" class="form-control" name="fisik[obat_dan_cairan][{{$c}}]" style="width: 100%" value="{{@$assesment['obat_dan_cairan'][$c]}}">
                                   </td>
                               @endfor
                            </tr>
                        </table>
                    </div> --}}

                       {{-- Tekanan Darah --}}
                    {{-- <div class="col-md-12" style="margin-top: 2rem;">
                        @php
                            $param_tekanan_darah = [
                                '180',
                                '170',
                                '160',
                                '150',
                                '140',
                                '130',
                                '120',
                                '110',
                                '100',
                                '90',
                                '80',
                                '70',
                                '60',
                            ]
                        @endphp
                        <table class="border" >
                            @foreach ($param_tekanan_darah as $key => $param)
                                <tr>
                                    @if ($key == 0)
                                        <td rowspan="13" style="width: 300px; padding: 1rem !important">
                                            <b>Tekanan Darah</b>
                                        </td>
                                    @endif
                                    <td style="width: 50px" class="text-center">{{$param}}</td>
                                    @for ($i = 1; $i <= 32; $i++)
                                        <td class="border">
                                            <input type="hidden" name="fisik[tekanan_darah][{{$param}}][{{$i}}]"  value="">
                                            <input type="checkbox" name="fisik[tekanan_darah][{{$param}}][{{$i}}]" class="selected_point" {{@$assesment['tekanan_darah'][$param][$i] == "selected" ? 'checked' : ''}} value="selected">
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </table>
                    </div> --}}

                    {{-- Temperatur --}}

                    {{-- <div class="col-md-12" style="margin-top: 2rem;">
                        <table class="border">
                            <tr>
                                <td rowspan="2" colspan="2" class="border" style="width: 300px; padding: 1rem !important;">
                                    <b>Temperatur (C)</b>
                                </td>
                                @for ($b = 1; $b <= 16; $b++)
                                    <td colspan="2" class="border text-center bold" style="padding: 1rem !important">{{$b}}</td>
                                @endfor
                            </tr>
                            <tr>
                                 @for ($c = 1; $c <= 16; $c++)
                                    <td colspan="2" class="border text-center bold">
                                        <input type="text" class="form-control" name="fisik[temperatur][{{$c}}]" style="width: 100%" value="{{@$assesment['temperatur'][$c]}}">
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </div> --}}

                    {{-- Urin --}}
                    {{-- <div class="col-md-12" style="margin-top: 2rem;">
                        @php
                            $param_urin = [
                                'Protein',
                                'Ascites',
                                'Volume',
                            ]
                        @endphp
                        <table class="border" >
                            @foreach ($param_urin as $key => $param)
                                <tr>
                                    @if ($key == 0)
                                        <td rowspan="13" style="width: 70px; padding: 1rem !important">
                                            <b>Urin</b>
                                        </td>
                                    @endif
                                    <td style="width: 50px; padding: 1rem !important;" class="text-center border">{{$param}}</td>
                                    @for ($i = 1; $i <= 16; $i++)
                                        <td colspan="2" class="border text-center bold">
                                            <input type="text" class="form-control" name="fisik[urin][{{$param}}][{{$i}}]" style="width: 100%" value="{{@$assesment['urin'][$param][$i]}}">
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </table>
                    </div> --}}

                </div>

                <div class="col-md-12" style="text-align: center;">
                    <div id="canvas_div" style="overflow-x: auto;">
                        @if (empty($assesment['base64']))
                            <canvas id="canvas" width="996" height="1510" style="background: url('/images/partograf.png') no-repeat;"></canvas>
                        @else
                            <canvas id="canvas" width="996" height="1510" style="background: url('data:image/png;base64,{{$assesment['base64']}}') no-repeat;"></canvas>
                        @endif
                    </div>
                    <div style="text-align: left;">
                        <b>Perhatian !</b>
                        <br>
                        <span>Mode <b>Brush</b> digunakan untuk menggambar</span> <br>
                        <span>Mode <b>Eraser</b> digunakan untuk menghapus gambaran sebelum disimpan. jika sudah disimpan. coretan lama tidak dapat dihapus</span>

                    </div>
                    <div class="text-center"
                            style="width: 100%; display:flex; justify-content:center; gap: 10px; margin-top: 10px">
                            <div class="btn btn-warning" onclick="clearArea()">Clear Area</div>
                            <div style="display: flex; align-items:center; gap:5px">
                                <span>Line Width: </span>
                                <input type="number" name="" class="form-control" id="selWidth" value="2"
                                    style="width: 100px">
                            </div>
                            <div style="display: flex; align-items:center; gap:5px">
                                <span>Color: </span>
                                <input type="color" name="" class="form-control" id="selColor" value="#ff0000"
                                    style="width: 100px">
                            </div>
                            <div style="display: flex; align-items:center; gap:5px">
                                <span>Mode: </span>
                                <select id="mode" class="select2">
                                    <option value="brush" selected>Brush</option>
                                    <option value="eraser">Eraser</option>
                                </select>
                            </div>
                        </div>
                </div>


                <div class="col-md-12" style="margin: 20px 0px;">
                    <h4 class="text-center">Keterangan</h4>
                    <table style="width: 100%; height: 150px;">
                        <tr>
                            <td>
                                <input type="text" name="fisik[keterangan][denyut_jantung_janin]" class="form-control" placeholder="Denyut Jantung Janin" style="width: 80%;" value="{{@$assesment['keterangan']['denyut_jantung_janin']}}">
                            </td>
                            <td>
                                <input type="text" name="fisik[keterangan][air_ketuban_penyusutan]" class="form-control" placeholder="Air Ketuban Penyusutan" style="width: 80%;" value="{{@$assesment['keterangan']['air_ketuban_penyusutan']}}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="fisik[keterangan][pembukaan_servis]" class="form-control" placeholder="Pembukaan Servis" style="width: 80%;" value="{{@$assesment['keterangan']['pembukaan_servis']}}">
                            </td>
                            <td>
                                <input type="text" name="fisik[keterangan][jam]" class="form-control" placeholder="Jam" style="width: 80%;" value="{{@$assesment['keterangan']['jam']}}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="fisik[keterangan][kontraksi_tiap]" class="form-control" placeholder="Kontraksi Tiap 10 Menit" style="width: 80%;" value="{{@$assesment['keterangan']['kontraksi_tiap']}}">
                            </td>
                            <td>
                                <input type="text" name="fisik[keterangan][oksitosin]" class="form-control" placeholder="Oksitosin" style="width: 80%;" value="{{@$assesment['keterangan']['oksitosin']}}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="fisik[keterangan][cp_tetes]" class="form-control" placeholder="CP Tetes / Menit" style="width: 80%;" value="{{@$assesment['keterangan']['cp_tetes']}}">
                            </td>
                            <td>
                                <input type="text" name="fisik[keterangan][obat_dan_cairan_iv]" class="form-control" placeholder="Obat dan cairan IV" style="width: 80%;" value="{{@$assesment['keterangan']['obat_dan_cairan_iv']}}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="fisik[keterangan][tekanan_darah]" class="form-control" placeholder="Tekanan Darah" style="width: 80%;" value="{{@$assesment['keterangan']['tekanan_darah']}}">
                            </td>
                            <td>
                                <input type="text" name="fisik[keterangan][suhu]" class="form-control" placeholder="Suhu" style="width: 80%;" value="{{@$assesment['keterangan']['sunu']}}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="fisik[keterangan][urine]" class="form-control" placeholder="Urine" style="width: 80%;" value="{{@$assesment['keterangan']['urine']}}">
                            </td>
                            <td>
                                <input type="text" name="fisik[keterangan][input]" class="form-control" placeholder="Input" style="width: 80%;" value="{{@$assesment['keterangan']['input']}}">
                            </td>
                        </tr>
                    </table>
                </div>

                <button class="btn btn-success pull-right" id="save-partograf" type="button" onclick="savePartograf()">Simpan</button>
            </form>
            <br />
            
        </div>
    </div>


    

@endsection

@section('script')
    <script>
        $(".skin-blue").addClass("sidebar-collapse");
        $('#dokter_id').select2()
        $('.select2').select2({
            width: "100%"
        });
        let reg_id = "{{$reg->id}}"
        let unit = "{{$unit}}"

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

    <script>
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        let isDrawing = false;
        let x = 0;
        let y = 0;
        var offsetX;
        var offsetY;

        function startup() {
            canvas.addEventListener('touchstart', handleStart);
            canvas.addEventListener('touchend', handleEnd);
            canvas.addEventListener('touchcancel', handleCancel);
            canvas.addEventListener('touchmove', handleMove);
            canvas.addEventListener('mousedown', (e) => {
                x = e.offsetX;
                y = e.offsetY;
                isDrawing = true;
            });

            canvas.addEventListener('mousemove', (e) => {
                if (isDrawing) {
                drawLine(context, x, y, e.offsetX, e.offsetY);
                    x = e.offsetX;
                    y = e.offsetY;
                }
            });

            canvas.addEventListener('mouseup', (e) => {
                if (isDrawing) {
                drawLine(context, x, y, e.offsetX, e.offsetY);
                    x = 0;
                    y = 0;
                    isDrawing = false;
                }
            });
        }

        document.addEventListener("DOMContentLoaded", startup);

        const ongoingTouches = [];

        function handleStart(evt) {
            evt.preventDefault();
            const touches = evt.changedTouches;
            offsetX = canvas.getBoundingClientRect().left;
            offsetY = canvas.getBoundingClientRect().top;
            for (let i = 0; i < touches.length; i++) {
                ongoingTouches.push(copyTouch(touches[i]));
            }
        }

        function handleMove(evt) {
            evt.preventDefault();
            const touches = evt.changedTouches;
            for (let i = 0; i < touches.length; i++) {
                const color = document.getElementById('selColor').value;
                const idx = ongoingTouchIndexById(touches[i].identifier);
                if (idx >= 0) {
                context.beginPath();
                context.moveTo(ongoingTouches[idx].clientX - offsetX, ongoingTouches[idx].clientY - offsetY);
                context.lineTo(touches[i].clientX - offsetX, touches[i].clientY - offsetY);
                context.lineWidth = document.getElementById('selWidth').value;
                context.strokeStyle = color;
                context.lineJoin = "round";
                context.closePath();
                context.stroke();
                ongoingTouches.splice(idx, 1, copyTouch(touches[i]));  // swap in the new touch record
                }
            }
        }

        function handleEnd(evt) {
            evt.preventDefault();
            const touches = evt.changedTouches;
            for (let i = 0; i < touches.length; i++) {
                const color = document.getElementById('selColor').value;
                let idx = ongoingTouchIndexById(touches[i].identifier);
                if (idx >= 0) {
                context.lineWidth = document.getElementById('selWidth').value;
                context.fillStyle = color;
                ongoingTouches.splice(idx, 1);  // remove it; we're done
                }
            }
        }

        function handleCancel(evt) {
            evt.preventDefault();
            const touches = evt.changedTouches;
            for (let i = 0; i < touches.length; i++) {
                let idx = ongoingTouchIndexById(touches[i].identifier);
                ongoingTouches.splice(idx, 1);  // remove it; we're done
            }
        }

        function copyTouch({ identifier, clientX, clientY }) {
            return { identifier, clientX, clientY };
        }

        function ongoingTouchIndexById(idToFind) {
            for (let i = 0; i < ongoingTouches.length; i++) {
                const id = ongoingTouches[i].identifier;
                if (id === idToFind) {
                return i;
                }
            }
            return -1;    // not found
        }

        function drawLine(context, x1, y1, x2, y2) {
            context.globalCompositeOperation = document.getElementById('mode').value == "brush" ? "source-over" : "destination-out"; 
            context.beginPath();
            context.strokeStyle = document.getElementById('selColor').value;
            context.lineWidth = document.getElementById('selWidth').value;
            context.lineJoin = "round";
            context.moveTo(x1, y1);
            context.lineTo(x2, y2);
            context.closePath();
            context.stroke();
        }

        function clearArea() {
            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    </script>

    <script>
        let base64 = "{{@$assesment['base64']}}";
        function savePartograf() {
            // buat temporary canvas untuk menggambar background
            var tmpCanvas = document.createElement('canvas');
            tmpCanvas.width = canvas.width;
            tmpCanvas.height = canvas.height;
            var tmpCtx = tmpCanvas.getContext('2d');
            var img = new Image();
            img.onload = function() {
                tmpCtx.drawImage(img, 0, 0);
                // tambahkan gambar yang tercoret ke dalam temporary canvas
                tmpCtx.drawImage(canvas, 0, 0);
                // simpan gambar dengan background yang tercoret
                var imageData = tmpCanvas.toDataURL('image/png');
                $('#gambar-partograf').val(imageData);
                $('#partograf-form')[0].submit();
            };

            if (base64) {
                img.src = 'data:image/png;base64,'+base64;
            } else {
                img.src = '/images/partograf.png';
            }

        }
    </script>
    
@endsection
