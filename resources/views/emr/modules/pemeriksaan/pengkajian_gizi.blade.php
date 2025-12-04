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
<link href="{{asset('jquery-autocomplete-inner-master/lib/stylesheets/jquery.ui.all.css')}}" media="screen" rel="stylesheet" type="text/css"/>
<link href="{{asset('jquery-autocomplete-inner-master/lib/stylesheets/app.css')}}" rel="stylesheet" type="text/css"/>
<script src="{{asset('jquery-autocomplete-inner-master/lib/javascripts/jquery-1.7.2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('jquery-autocomplete-inner-master/lib/javascripts/jquery-ui-1.8.20.custom.js')}}" type="text/javascript"></script>

<style>
    .ui-menu .ui-menu-item {
        font-family: 'IBM Plex Sans', sans-serif;
    }
    
    .ui-menu-item-wrapper {
        padding: 1rem;
    }
</style>
@section('header')
    <h1>Pengkajian Gizi</h1>
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
            <form method="POST" action="{{ url('emr-soap/pengkajian-gizi/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tab-gizi')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                          <h4 style="text-align: center; padding: 10px"><b>ASSASMENT / PENGKAJIAN GIZI</b></h4>
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
                                        <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')"><i class="fa fa-trash"></i></a>
                                        <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url("cetak-pengkajian-gizi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a>
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

                    <div class="col-md-12">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width: 20%;">
                                    Tanggal Pemeriksaan
                                </td>
                                <td>
                                    <input type="datetime-local" name="tanggal_pemeriksaan" style="display:inline-block;" class="form-control" value="{{ isset($current_asessment) ? \Carbon\Carbon::parse($current_asessment->created_at)->format('Y-m-d\TH:i') : '' }}">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <h5><b>Antropometri</b></h5>
                    <div class="col-md-6">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td colspan="2" style="width: 50%; font-weight: bold;">Dewasa</td>
                            </tr>
                            <tr>
                                <td>
                                    BB Saat ini (Kg)
                                </td>
                                <td>
                                    <input type="text" placeholder="BB saat ini.....(Kg)" oninput="kalkulasiGizi()" name="fisik[pengkajian][antropometri][dewasa][bb_saat_ini]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['dewasa']['bb_saat_ini']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    BB biasanya (Kg)
                                </td>
                                <td>
                                    <input type="text" placeholder="BB biasanya.....(Kg)" oninput="hitungPenurunanDewasa()" name="fisik[pengkajian][antropometri][dewasa][bb_biasanya]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['dewasa']['bb_biasanya']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Penurunan BB (%)
                                </td>
                                <td>
                                    <input type="text" placeholder="(%)" name="fisik[pengkajian][antropometri][dewasa][penurunan_bb]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['dewasa']['penurunan_bb']}}">
                                    <br>
                                        Dalam (minggu/bulan)
                                    <br>
                                    <input type="text" placeholder="Dalam....(minggu/bulan)" name="fisik[pengkajian][antropometri][dewasa][penurunan_bb_dalam]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['dewasa']['penurunan_bb_dalam']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tinggi Badan (cm)
                                </td>
                                <td>
                                    <input type="text" placeholder="Tinggi badan.....(cm)" oninput="kalkulasiGizi()"  name="fisik[pengkajian][antropometri][dewasa][tinggi_badan]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['dewasa']['tinggi_badan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    LILA (cm)
                                </td>
                                <td>
                                    <input type="text" placeholder="LILA.....(cm)" name="fisik[pengkajian][antropometri][dewasa][lila]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['dewasa']['lila']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    IMT
                                </td>
                                <td>
                                    <input type="text" placeholder="IMT" name="fisik[pengkajian][antropometri][dewasa][imt]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['dewasa']['imt']}}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Status Gizi
                                </td>
                                <td>
                                    <input type="text" placeholder="Status Gizi" name="fisik[pengkajian][antropometri][dewasa][status_gizi]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['dewasa']['status_gizi']}}" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td colspan="2" style="width: 50%; font-weight: bold;">Anak</td>
                            </tr>
                            <tr>
                                <td>
                                    BB Saat ini (Kg)
                                </td>
                                <td>
                                    <input type="text" placeholder="BB saat ini.....(Kg)" name="fisik[pengkajian][antropometri][anak][bb_saat_ini]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['bb_saat_ini']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    BB biasanya (Kg)
                                </td>
                                <td>
                                    <input type="text" placeholder="BB biasanya.....(Kg)" oninput="hitungPenurunanAnak()" name="fisik[pengkajian][antropometri][anak][bb_biasanya]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['bb_biasanya']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Penurunan BB (%)
                                </td>
                                <td>
                                    <input type="text" placeholder="(%)" name="fisik[pengkajian][antropometri][anak][penurunan_bb]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['penurunan_bb']}}">
                                    <br>
                                        Dalam (minggu/bulan)
                                    <br>
                                    <input type="text" placeholder="Dalam....(minggu/bulan)" name="fisik[pengkajian][antropometri][anak][penurunan_bb_dalam]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['penurunan_bb_dalam']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tinggi Badan (cm)
                                </td>
                                <td>
                                    <input type="text" placeholder="Tinggi badan.....(cm)"  name="fisik[pengkajian][antropometri][anak][tinggi_badan]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['tinggi_badan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    LILA (cm)
                                </td>
                                <td>
                                    <input type="text" placeholder="LILA.....(cm)" name="fisik[pengkajian][antropometri][anak][lila]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['lila']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Standar Deviasi
                                </td>
                                <td>
                                     BB / U
                                    <br>
                                    <input type="text" placeholder="BB / U" name="fisik[pengkajian][antropometri][anak][standar_deviasi][1]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['1']}}">
                                    <input type="text" placeholder="Status Gizi" name="fisik[pengkajian][antropometri][anak][standar_deviasi][status_gizi_1]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_1']}}">
                                    <br>
                                     PB, TB / U
                                    <br>
                                    <input type="text" placeholder="PB, TB / U" name="fisik[pengkajian][antropometri][anak][standar_deviasi][2]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['2']}}">
                                    <input type="text" placeholder="Status Gizi" name="fisik[pengkajian][antropometri][anak][standar_deviasi][status_gizi_2]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_2']}}">
                                    <br>
                                     BB / PB , TB
                                    <br>
                                    <input type="text" placeholder="BB / PB , TB" name="fisik[pengkajian][antropometri][anak][standar_deviasi][3]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['3']}}">
                                    <input type="text" placeholder="Status Gizi" name="fisik[pengkajian][antropometri][anak][standar_deviasi][status_gizi_3]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_3']}}">
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Status Gizi
                                </td>
                                <td>
                                    <input type="text" placeholder="Status Gizi" name="fisik[pengkajian][antropometri][anak][status_gizi]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['antropometri']['anak']['status_gizi']}}">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h5><b>Bio Kimia Terkait Gizi</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td colspan="2" style="width: 50%;">
                                    <textarea rows="5" name="fisik[pengkajian][biokimia]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Bio Kimia Terkait Gizi]" class="form-control" >{{@$assesment['pengkajian']['biokimia']}}</textarea>
                                </td>
                            </tr>
                        </table>
                        <h5><b>Hasil Lab</b></h5>
                        <div class='table-responsive'>
                            <table class='table-striped table-bordered table-hover table-condensed table'>
                                <thead>
                                    <tr>
                                        <th>No.Lab</th>
                                        <th>Daftar Pemeriksaan</th>
                                        <th>Waktu Pemeriksaan</th>
                                        <th>Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hasillab as $p)
                                        <tr>
                                            <td>{{ $p->no_lab }}</td>
                                            <td>
                                                <ul style="padding: 15px;">
                                                    @foreach ($p->orderLab->folios as $folio)
                                                        <li>{{$folio->namatarif}}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ date('Y-m-d', strtotime($p->tgl_pemeriksaan)) }} {{ $p->jam }}</td>
                                            <td>
                                                <a href="{{ url('cetak-lis-pdf/' . @$p->no_lab . '/' . @$registrasi_id) }}"
                                                    target="_blank" class="btn btn-sm btn-danger btn-flat"> <i class="fa fa-print"></i>
                                                    Lihat </a>
                                                {{-- <a href="{{ url('pemeriksaanlab/cetakAll/'.$p->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-print"></i> Lihat </a> --}}
                                                {{-- <a href="{{ url("radiologi/cetak-ekpertise/".$p->id."/".$registrasi_id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Lihat </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h5><b>Fisik Klinis Gizi</b></h5>
                        <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                                    Gangguan Nafsu Makan
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gangguan_nafsu_makan]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_nafsu_makan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gangguan_nafsu_makan]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_nafsu_makan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                                    Kembung
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][kembung]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['kembung'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][kembung]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['kembung'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                               
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Diare
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gigi_geligi]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gigi_geligi'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gigi_geligi]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gigi_geligi'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Konstipasi
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][konstipasi]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['konstipasi'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][konstipasi]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['konstipasi'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                 <td style="font-weight: bold;border: 1px solid black;">
                                    Mual
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][mual]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['mual'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][mual]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['mual'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Muntah
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][muntah]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['muntah'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][muntah]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['muntah'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Kepala dan mata
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][kepala_dan_mata]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['kepala_dan_mata'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][kepala_dan_mata]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['kepala_dan_mata'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Atropi otot lengan
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][antropi_otot_lengan]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['antropi_otot_lengan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][antropi_otot_lengan]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['antropi_otot_lengan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Hilang lemak subkutan
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][hilang_lemak_subkutan]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['hilang_lemak_subkutan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][hilang_lemak_subkutan]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['hilang_lemak_subkutan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Gangguan menelan
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gangguan_menelan]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_menelan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gangguan_menelan]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_menelan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Gangguan mengunyah
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gangguan_mengunyah]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_mengunyah'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gangguan_mengunyah]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_mengunyah'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Gangguan menghisap
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gangguan_menghisap]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_menghisap'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][gangguan_menghisap]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_menghisap'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Sesak
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][sesak]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['sesak'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][sesak]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['sesak'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Stomatitis
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][stomatitis]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['stomatitis'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][fisik_klinis_gizi][stomatitis]"
                                            {{ @$assesment['pengkajian']['fisik_klinis_gizi']['stomatitis'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Lainnya
                                </td>
                                <td style="border: 1px solid black;" class="text-center" colspan="5">
                                    <input type="text" name="fisik[pengkajian][fisik_klinis_gizi][lainnya]" class="form-control" value="{{ @$assesment['pengkajian']['fisik_klinis_gizi']['lainnya'] }}">
                                </td>
                            </tr>

                            
                            <tr>
                                <td colspan="4" style="width:50%; font-weight:bold;">Tanda Vital</td>
                              </tr>
                              <tr>
                                <td style="padding: 5px;">
                                  <label class="form-check-label" style="font-weight: normal;">Tekanan Darah (mmHG)</label><br/>
                                  <input type="text" name="fisik[pengkajian][fisik_klinis_gizi][tanda_vital][tekanan_darah]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['tekanan_darah'] ?? @$cppt_perawat->tekanan_darah}}">
                                </td>
                                <td style="padding: 5px;">
                                    <label class="form-check-label" style="font-weight: normal;"> Suhu (°C)</label><br/>
                                    <input type="text" name="fisik[pengkajian][fisik_klinis_gizi][tanda_vital][suhu]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['suhu'] ?? @$cppt_perawat->suhu}}">
                                  </td>
                                <td style="padding: 5px;">
                                  <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br/>
                                  <input type="text" name="fisik[pengkajian][fisik_klinis_gizi][tanda_vital][nadi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['nadi'] ?? @$cppt_perawat->nadi}}">
                                </td>
                                <td style="padding: 5px;">
                                  <label class="form-check-label" style="font-weight: normal;">Respirasi (x/menit)</label><br/>
                                  <input type="text" name="fisik[pengkajian][fisik_klinis_gizi][tanda_vital][respirasi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['respirasi'] ?? @$cppt_perawat->frekuensi_nafas}}">
                                </td>
                                <td style="padding: 5px;">
                                  <label class="form-check-label" style="font-weight: normal;">Saturasi (x/menit)</label><br/>
                                  <input type="text" name="fisik[pengkajian][fisik_klinis_gizi][tanda_vital][saturasi]" style="display:inline-block; width: 100px;" class="form-control" id="" value="{{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['saturasi']}}">
                                </td>
                              </tr>
                        </table>
                        <a href="{{url('emr-soap/riwayat/' . @$unit . '/' . @$registrasi_id)}}" class="btn btn-sm btn-danger">Riwayat CPPT & EWS</a>
                    </div>

                    <div class="col-md-12">
                        <h5><b>Riwayat Diet</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width: 20%;">
                                    Asupan Nutrisi RS
                                </td>
                                <td>
                                    <input type="text" placeholder="Asupan Nutrisi RS" name="fisik[pengkajian][riwayat_diet][asupan_nutrisi_rs]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_rs']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    Asupan Nutrisi SMRS
                                </td>
                                <td>
                                    <input type="text" placeholder="Asupan Nutrisi SMRS" name="fisik[pengkajian][riwayat_diet][asupan_nutrisi_smrs]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_smrs']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    Asupan Nutrisi Cairan
                                </td>
                                <td>
                                    <input type="text" placeholder="Asupan Nutrisi Cairan" name="fisik[pengkajian][riwayat_diet][asupan_nutrisi_cairan]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_cairan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    Kepercayaan Terhadap Makanan
                                </td>
                                <td>
                                    <input type="text" placeholder="Kepercayaan Terhadap Makanan" name="fisik[pengkajian][riwayat_diet][pantangan_makan]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['pantangan_makan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    Pengalaman diet sebelumnya
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][pengalaman_diet]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['pengalaman_diet'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][pengalaman_diet]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['pengalaman_diet'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    Riwayat konseling gizi
                                </td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][riwayat_konseling]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['riwayat_konseling'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][riwayat_konseling]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['riwayat_konseling'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    Alergi makanan
                                </td>
                                <td>
                                    <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                                        <tr style="border: 1px solid black;">
                                            <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                                                Telur
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][telur]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['telur'] == 'Ya' ? 'checked' : '' }}
                                                        type="radio" value="Ya">
                                                    <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][telur]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['telur'] == 'Tidak' ? 'checked' : '' }}
                                                        type="radio" value="Tidak">
                                                    <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                                </div>
                                            </td>
                                            <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                                                Gluten/gandum
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][gluten]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['gluten'] == 'Ya' ? 'checked' : '' }}
                                                        type="radio" value="Ya">
                                                    <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][gluten]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['gluten'] == 'Tidak' ? 'checked' : '' }}
                                                        type="radio" value="Tidak">
                                                    <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="border: 1px solid black;">
                                            <td style="font-weight: bold;border: 1px solid black;">
                                                Udang
                                            </td>
                                            <td style="border: 1px solid black;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][udang]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['udang'] == 'Ya' ? 'checked' : '' }}
                                                        type="radio" value="Ya">
                                                    <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][udang]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['udang'] == 'Tidak' ? 'checked' : '' }}
                                                        type="radio" value="Tidak">
                                                    <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                                </div>
                                            </td>
                                            <td style="font-weight: bold;border: 1px solid black;">
                                                Susu sapi / produk olahan
                                            </td>
                                            <td style="border: 1px solid black;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][susu_sapi]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['susu_sapi'] == 'Ya' ? 'checked' : '' }}
                                                        type="radio" value="Ya">
                                                    <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][susu_sapi]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['susu_sapi'] == 'Tidak' ? 'checked' : '' }}
                                                        type="radio" value="Tidak">
                                                    <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="border: 1px solid black;">
                                            <td style="font-weight: bold;border: 1px solid black;">
                                                Ikan
                                            </td>
                                            <td style="border: 1px solid black;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][ikan]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['ikan'] == 'Ya' ? 'checked' : '' }}
                                                        type="radio" value="Ya">
                                                    <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][ikan]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['ikan'] == 'Tidak' ? 'checked' : '' }}
                                                        type="radio" value="Tidak">
                                                    <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                                </div>
                                            </td>
                                            <td style="font-weight: bold;border: 1px solid black;">
                                                Kacang-kacangan
                                            </td>
                                            <td style="border: 1px solid black;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][kacang_kacangan]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['kacang_kacangan'] == 'Ya' ? 'checked' : '' }}
                                                        type="radio" value="Ya">
                                                    <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[pengkajian][riwayat_diet][alergi_makanan][kacang_kacangan]"
                                                        {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['kacang_kacangan'] == 'Tidak' ? 'checked' : '' }}
                                                        type="radio" value="Tidak">
                                                    <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">
                                    Alergi makanan lainnya
                                </td>
                                <td>
                                    <input type="text" placeholder="Alergi makanan lainnya" name="fisik[pengkajian][riwayat_diet][alergi_makanan_lainnya]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['alergi_makanan_lainnya']}}">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 style="text-align: center; padding: 10px"><b>DIAGNOSA GIZI</b></h4>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td colspan="2" style="width: 50%;">
                                    
                                    <textarea rows="5" name="fisik[diagnosa_gizi]" id="diagnosa_gizi" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosa Gizi]" class="form-control" >{{@$assesment['diagnosa_gizi']}}</textarea>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 style="text-align: center; padding: 10px"><b>INTERVENSI GIZI</b></h4>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width: 20%;">
                                    Tujuan
                                </td>
                                <td>
                                    <input type="text" placeholder="Tujuan" name="fisik[intervensi_gizi][tujuan]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['tujuan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width: 20%;">
                                    Preskrisi Diet
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 20%;">a. Bentuk makanan</td>
                                <td>
                                    <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                                        <tr style="border: 1px solid black;">
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan][]"
                                                        type="checkbox" value="MC"
                                                        {{ in_array('MC', @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-weight: 400;">MC</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan][]"
                                                        type="checkbox" value="BR"
                                                        {{ in_array('BR', @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-weight: 400;">BR</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan][]"
                                                        type="checkbox" value="Sippy"
                                                        {{ in_array('Sippy', @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-weight: 400;">Sippy</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div style="display: flex; align-items: center; vertical-align:middle">
                                                    <input style="margin: 0" class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan][]"
                                                        type="checkbox" value="Lainnya"
                                                        {{ in_array('Lainnya', @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-weight: 400; margin: 0 1rem 0 0;">Lainnya</label>
                                                    <input type="text" placeholder="Isi jika Lainnya" name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan_lain]" style="display:inline-block;" class="form-control" value="{{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan_lain'] }}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="border: 1px solid black;">
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan][]"
                                                        type="checkbox" value="Makanan saring (TD I)"
                                                        {{ in_array('Makanan saring (TD I)', @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-weight: 400;">Makanan saring (TD I)</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan][]"
                                                        type="checkbox" value="Makanan lunak (TD II)"
                                                        {{ in_array('Makanan lunak (TD II)', @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-weight: 400;">Makanan lunak (TD II)</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan][]"
                                                        type="checkbox" value="Makanan lunak (TD III)"
                                                        {{ in_array('Makanan lunak (TD III)', @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-weight: 400;">Makanan lunak (TD III)</label>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid black; width: 10%;" class="text-center">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan][]"
                                                        type="checkbox" value="Makanan biasa (TD IV)"
                                                        {{ in_array('Makanan biasa (TD IV)', @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" style="font-weight: 400;">Makanan biasa (TD IV)</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 20%;">b. Jenis diet</td>
                                <td>
                                    <select name="fisik[intervensi_gizi][preskripsi_diet][jenis_diet]" class="form-control select2" id="" style="width: 100%;" onchange="showJenisDietLain(this)">
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == '' ? 'selected' : '' }} value="">-- Pilih --</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Diet Jantung (DJ)' ? 'selected' : '' }} value="Diet Jantung (DJ)">Diet Jantung (DJ)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Rendah Serat (RS)' ? 'selected' : '' }} value="Rendah Serat (RS)">Rendah Serat (RS)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Diet Hati (DH)' ? 'selected' : '' }} value="Diet Hati (DH)">Diet Hati (DH)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Diet Diabetes Mellitus (DM)' ? 'selected' : '' }} value="Diet Diabetes Mellitus (DM)">Diet Diabetes Mellitus (DM)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Tinggi Kalori Tinggi Protein (TKTP)' ? 'selected' : '' }} value="Tinggi Kalori Tinggi Protein (TKTP)">Tinggi Kalori Tinggi Protein (TKTP)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Diet Lambung (DL)' ? 'selected' : '' }} value="Diet Lambung (DL)">Diet Lambung (DL)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Rendah Protein (R.PROT)' ? 'selected' : '' }} value="Rendah Protein (R.PROT)">Rendah Protein (R.PROT)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Rendah Lemak (RL)' ? 'selected' : '' }} value="Rendah Lemak (RL)">Rendah Lemak (RL)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Rendah Garam (RG)' ? 'selected' : '' }} value="Rendah Garam (RG)">Rendah Garam (RG)</option>
                                        <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Lainnya' ? 'selected' : '' }} value="Lainnya">Lainnya</option>
                                      </select>
                                      <div id="jenis_diet_lainnya" @if(@$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] != 'Lainnya')style="display: none;"@endif>
                                          <input type="text" class="form-control" name="fisik[intervensi_gizi][preskripsi_diet][jenis_diet_lainnya]" placeholder="Isi jika jenis diet 'Lainnya'" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet_lainnya']}}">
                                      </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 20%;">c. Frekuensi</td>
                                <td>
                                    <input type="text" placeholder="Frekuensi" name="fisik[intervensi_gizi][preskripsi_diet][frekuensi]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['frekuensi']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 20%;">d. Rute</td>
                                <td>
                                    <select name="fisik[intervensi_gizi][preskripsi_diet][rute][]" class="form-control select2" multiple id="" style="width: 100%;">
                                        @if (@in_array("Oral", @$assesment['intervensi_gizi']['preskripsi_diet']['rute']))
                                            <option selected value="Oral">Oral</option>
                                        @else
                                            <option value="Oral">Oral</option>
                                        @endif
                                        @if (@in_array("NGT", @$assesment['intervensi_gizi']['preskripsi_diet']['rute']))
                                            <option selected value="NGT">NGT</option>
                                        @else
                                            <option value="NGT">NGT</option>
                                        @endif
                                        @if (@in_array("Panteral", @$assesment['intervensi_gizi']['preskripsi_diet']['rute']))
                                            <option selected value="Panteral">Panteral</option>
                                        @else
                                            <option value="Panteral">Panteral</option>
                                        @endif
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 20%;">e. Kebutuhan</td>
                                <td>
                                    Energi
                                    <br>
                                    <input type="text" placeholder="Energi" name="fisik[intervensi_gizi][preskripsi_diet][kebutuhan][energi]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['energi']}}">
                                    <br>
                                    Protein
                                    <br>
                                    <input type="text" placeholder="Protein" name="fisik[intervensi_gizi][preskripsi_diet][kebutuhan][protein]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['protein']}}">
                                    <br>
                                    Lemak
                                    <br>
                                    <input type="text" placeholder="Lemak" name="fisik[intervensi_gizi][preskripsi_diet][kebutuhan][lemak]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['lemak']}}">
                                    <br>
                                    Karbohidrat
                                    <br>
                                    <input type="text" placeholder="Karbohidrat" name="fisik[intervensi_gizi][preskripsi_diet][kebutuhan][karbohidrat]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['karbohidrat']}}">
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; width: 20%;">f. Edukasi</td>
                                <td>
                                    <input type="text" placeholder="Edukasi" name="fisik[intervensi_gizi][preskripsi_diet][edukasi]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['edukasi']}}">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <h4 style="text-align: center; padding: 10px"><b>MONITORING</b></h4>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td colspan="2" style="width: 50%;">
                                    <textarea rows="5" name="fisik[monitoring]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Monitoring]" class="form-control" >{{@$assesment['monitoring']}}</textarea>
                                </td>
                            </tr>
                        </table>
                        <h4 style="text-align: center; padding: 10px"><b>EVALUASI</b></h4>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td colspan="2" style="width: 50%;">
                                    <textarea rows="5" name="fisik[evaluasi]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Evaluasi]" class="form-control" >{{@$assesment['evaluasi']}}</textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <button class="btn btn-success pull-right" id="submitButton" type="submit">Simpan</button>
            </form>
            <br />
            
        </div>
    </div>


    

@endsection

@section('script')
    <script>
        $(".skin-blue").addClass("sidebar-collapse");
        $('#dokter_id').select2()
        $('.select2').select2();

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

        function showJenisDietLain(select) {
            if (select.value == 'Lainnya') {
                $('#jenis_diet_lainnya').show();
            } else {
                $('#jenis_diet_lainnya').hide();
            }
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
            if (imt < 8.6) {
                kategori = "Gizi Kurang";
            } else if (imt >= 8.6 && imt <= 18.4) {
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

        function hitungPenurunanDewasa() {
            let beratBadanSaatIni = $('input[name="fisik[pengkajian][antropometri][dewasa][bb_saat_ini]"]').val();
            let beratBadanBiasa = $('input[name="fisik[pengkajian][antropometri][dewasa][bb_biasanya]"]').val();

            let persentasePenurunan = ((beratBadanBiasa - beratBadanSaatIni) / beratBadanBiasa) * 100;

            let kesimpulan = (persentasePenurunan < 0) ? "Naik " + Math.abs(persentasePenurunan).toFixed(2) + "% dari berat badan biasanya" : "Turun " + Math.abs(persentasePenurunan).toFixed(2) + "% dari berat badan biasanya";

            $('input[name="fisik[pengkajian][antropometri][dewasa][penurunan_bb]"]').val(kesimpulan)
        }

        function hitungPenurunanAnak() {
            let beratBadanSaatIni = $('input[name="fisik[pengkajian][antropometri][anak][bb_saat_ini]"]').val();
            let beratBadanBiasa = $('input[name="fisik[pengkajian][antropometri][anak][bb_biasanya]"]').val();

            let persentasePenurunan = ((beratBadanBiasa - beratBadanSaatIni) / beratBadanBiasa) * 100;

            let kesimpulan = (persentasePenurunan < 0) ? "Naik " + Math.abs(persentasePenurunan).toFixed(2) + "% dari berat badan biasanya" : "Turun " + Math.abs(persentasePenurunan).toFixed(2) + "% dari berat badan biasanya";

            $('input[name="fisik[pengkajian][antropometri][anak][penurunan_bb]"]').val(kesimpulan)
        }

        document.addEventListener("keydown", function(event) {
            if (event.key === "Enter" && !event.target.matches("#submitButton")) {
                event.preventDefault();
                return false;
            }
        });
    </script>

    <script>
            // search only, if the regexp matches
            var predictive = [
                
            ];
            // Defines for the example the match to take which is any word (with Umlauts!!).
            function _leftMatch(string, area) {
                return string.substring(0, area.selectionStart).match(/[\wäöüÄÖÜß]+$/)
            }

            function _setCursorPosition(area, pos) {
                if (area.setSelectionRange) {
                    area.setSelectionRange(pos, pos);
                } else if (area.createTextRange) {
                    var range = area.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', pos);
                    range.moveStart('character', pos);
                    range.select();
                }
            }

            $("#diagnosa_gizi").autocomplete({
                position: { my : "right top", at: "right bottom" },
                source: function(request, response) {
                    var str = _leftMatch(request.term, $("#diagnosa_gizi")[0]);
                    str = (str != null) ? str[0] : "";

                    console.log(str);
                    

                    $.ajax({
                        url: '/get-predictive?term=' + str,
                        type: 'GET'
                    })
                    .done(function(data) {
                        predictive = data;
                        response($.ui.autocomplete.filter(
                                predictive, str));
                    })

                },
                //minLength: 2,  // does have no effect, regexpression is used instead
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                // Insert the match inside the ui element at the current position by replacing the matching substring
                select: function(event, ui) {
                    //alert("completing "+ui.item.value);},
                    var m = _leftMatch(this.value, this)[0];
                    var beg = this.value.substring(0, this.selectionStart - m.length);
                    this.value = beg + ui.item.value + this.value.substring(this.selectionStart, this.value.length);
                    var pos = beg.length + ui.item.value.length;
                    _setCursorPosition(this, pos);
                    return false;
                },
                search:function(event, ui) {
                    var m = _leftMatch(this.value, this);
                    return (m != null )
                }
            });
    </script>
    
@endsection
