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

    .border {
        border: 1px solid black;
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

    tr, td {
        padding: .3rem !important;
        text-align: center;
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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/' . $unit . '/' . $reg->id) }}"
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
                          <h4 style="text-align: center; padding: 10px"><b>Daftar Pemberian Terapi</b></h4>
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
                                      <td colspan="3" class="text-center">Tidak Ada Riwayat Pemberian Terapi</td>
                                  </tr>
                              @endif
                              @foreach ($riwayats as $riwayat)
                                  <tr>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          {{@Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                                      </td>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          {{ @$riwayat->user->name }}
                                      </td>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                          <a href="{{ url("emr-soap-print/cetak-pemberian-terapi/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-warning btn-sm" target="_blank">
                                            <i class="fa fa-print"></i>
                                          </a>
                                          <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                            <i class="fa fa-trash"></i>
                                          </a>
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
                    @if (@$assesment || count(@$not_done_input) == 0)
                        <div class="col-md-12" style="overflow: auto;">
                            <table style="width: 150%" class="border" style="font-size:12px;">
                                <tr class="border">
                                    <td class="border bold" rowspan="3">NO</td>
                                    <td class="border bold" rowspan="3">NAMA OBAT (TULISKAN NAMA DAN DOSIS LENGKAP)</td>
                                    <td class="border bold" rowspan="3">CARA DAN FREKUENSI PEMBERIAN</td>
                                    <td class="border bold" colspan="17">TANGGAL</td>
                                    <td class="border bold" rowspan="3">KET</td>
                                </tr>
                                <tr class="border">
                                    <td class="border bold" rowspan="2">WAKTU/PETUGAS</td>
                                    <td class="border" colspan="4">
                                        <input type="date" name="fisik[tanggal_1][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal_1']['tanggal']}}">
                                    </td>
                                    <td class="border" colspan="4">
                                        <input type="date" name="fisik[tanggal_2][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal_2']['tanggal']}}">
                                    </td>
                                    <td class="border" colspan="4">
                                        <input type="date" name="fisik[tanggal_3][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal_3']['tanggal']}}">
                                    </td>
                                    <td class="border" colspan="4">
                                        <input type="date" name="fisik[tanggal_4][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal_4']['tanggal']}}">
                                    </td>
                                </tr>
                                <tr class="border">
                                    <td class="border bold">I</td>
                                    <td class="border bold">II</td>
                                    <td class="border bold">III</td>
                                    <td class="border bold">IV</td>
                                    <td class="border bold">I</td>
                                    <td class="border bold">II</td>
                                    <td class="border bold">III</td>
                                    <td class="border bold">IV</td>
                                    <td class="border bold">I</td>
                                    <td class="border bold">II</td>
                                    <td class="border bold">III</td>
                                    <td class="border bold">IV</td>
                                    <td class="border bold">I</td>
                                    <td class="border bold">II</td>
                                    <td class="border bold">III</td>
                                    <td class="border bold">IV</td>
                                </tr>

                                @for ($i = 1; $i <= 15; $i++)
                                    <tr class="border">
                                        <td class="border  bold" rowspan="2">{{$i}}<x/td>
                                        <td class="border" rowspan="2">
                                            <input name="fisik[pemberian_terapi][{{$i}}][nama_obat]" style="display:inline-block;" class="form-control" value="{{@$assesment['pemberian_terapi'][$i]['nama_obat']}}">
                                        </td>
                                        <td class="border" rowspan="2">
                                            <input name="fisik[pemberian_terapi][{{$i}}][frekuensi_pemberian]" style="display:inline-block;" class="form-control" value="{{@$assesment['pemberian_terapi'][$i]['frekuensi_pemberian']}}">
                                        </td>
                                        <td class="border bold">JAM</td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][jam][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['1']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][jam][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['2']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][jam][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['3']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][jam][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['4']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][jam][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['1']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][jam][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['2']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][jam][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['3']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][jam][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['4']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][jam][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['1']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][jam][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['2']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][jam][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['3']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][jam][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['4']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][jam][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['1']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][jam][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['2']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][jam][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['3']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][jam][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['4']}}</textarea>
                                        </td>
                                        <td rowspan="2">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][keterangan]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['keterangan']}}</textarea>
                                        </td>
                                    </tr>

                                    <tr class="border">
                                        <td class="border bold">NAMA</td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][nama][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['1']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][nama][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['2']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][nama][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['3']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][nama][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['4']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][nama][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['1']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][nama][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['2']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][nama][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['3']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][nama][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['4']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][nama][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['1']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][nama][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['2']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][nama][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['3']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][nama][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['4']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][nama][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['1']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][nama][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['2']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][nama][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['3']}}</textarea>
                                        </td>
                                        <td class="border">
                                            <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][nama][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['4']}}</textarea>
                                        </td>
                                    </tr>
                                @endfor
                            </table>
                        </div>
                    @elseif (count(@$not_done_input) > 0)
                        @foreach ($not_done_input as $asessment)
                            @php
                                @$assesment = json_decode($asessment->fisik, true);
                            @endphp
                            <div class="col-md-12" style="overflow: auto;">
                                <table style="width: 150%" class="border" style="font-size:12px;">
                                    <tr class="border">
                                        <td class="border bold" rowspan="3">NO</td>
                                        <td class="border bold" rowspan="3">NAMA OBAT (TULISKAN NAMA DAN DOSIS LENGKAP)</td>
                                        <td class="border bold" rowspan="3">CARA DAN FREKUENSI PEMBERIAN</td>
                                        <td class="border bold" colspan="17">TANGGAL</td>
                                        <td class="border bold" rowspan="3">KET</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border bold" rowspan="2">WAKTU/PETUGAS</td>
                                        <td class="border" colspan="4">
                                            <input type="date" name="fisik[tanggal_1][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal_1']['tanggal']}}">
                                        </td>
                                        <td class="border" colspan="4">
                                            <input type="date" name="fisik[tanggal_2][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal_2']['tanggal']}}">
                                        </td>
                                        <td class="border" colspan="4">
                                            <input type="date" name="fisik[tanggal_3][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal_3']['tanggal']}}">
                                        </td>
                                        <td class="border" colspan="4">
                                            <input type="date" name="fisik[tanggal_4][tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal_4']['tanggal']}}">
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border bold">I</td>
                                        <td class="border bold">II</td>
                                        <td class="border bold">III</td>
                                        <td class="border bold">IV</td>
                                        <td class="border bold">I</td>
                                        <td class="border bold">II</td>
                                        <td class="border bold">III</td>
                                        <td class="border bold">IV</td>
                                        <td class="border bold">I</td>
                                        <td class="border bold">II</td>
                                        <td class="border bold">III</td>
                                        <td class="border bold">IV</td>
                                        <td class="border bold">I</td>
                                        <td class="border bold">II</td>
                                        <td class="border bold">III</td>
                                        <td class="border bold">IV</td>
                                    </tr>

                                    @for ($i = 1; $i <= 8; $i++)
                                        <tr class="border">
                                            <td class="border  bold" rowspan="2">{{$i}}<x/td>
                                            <td class="border" rowspan="2">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][nama_obat]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['nama_obat']}}</textarea>
                                            </td>
                                            <td class="border" rowspan="2">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][frekuensi_pemberian]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['frekuensi_pemberian']}}</textarea>
                                            </td>
                                            <td class="border bold">JAM</td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][jam][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['1']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][jam][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['2']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][jam][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['3']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][jam][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['jam']['4']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][jam][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['1']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][jam][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['2']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][jam][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['3']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][jam][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['jam']['4']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][jam][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['1']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][jam][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['2']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][jam][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['3']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][jam][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['jam']['4']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][jam][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['1']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][jam][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['2']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][jam][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['3']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][jam][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['jam']['4']}}</textarea>
                                            </td>
                                            <td rowspan="2">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][keterangan]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['keterangan']}}</textarea>
                                            </td>
                                        </tr>

                                        <tr class="border">
                                            <td class="border bold">NAMA</td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][nama][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['1']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][nama][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['2']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][nama][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['3']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_1][nama][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_1']['nama']['4']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][nama][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['1']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][nama][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['2']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][nama][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['3']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_2][nama][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_2']['nama']['4']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][nama][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['1']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][nama][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['2']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][nama][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['3']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_3][nama][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_3']['nama']['4']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][nama][1]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['1']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][nama][2]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['2']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][nama][3]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['3']}}</textarea>
                                            </td>
                                            <td class="border">
                                                <textarea name="fisik[pemberian_terapi][{{$i}}][tanggal_4][nama][4]" style="display:inline-block;" class="form-control">{{@$assesment['pemberian_terapi'][$i]['tanggal_4']['nama']['4']}}</textarea>
                                            </td>
                                        </tr>
                                    @endfor
                                </table>
                                <div style="margin: 2rem 0;">
                                    <input type="hidden" value="{{$asessment->id}}" name="asessment_id">
                                    <button type="submit" class="btn btn-warning">Perbarui</button>
                                    <button type="button" class="btn btn-primary" onclick="markAsDone({{$asessment->id}})">Tandai Selesai</button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                @if (count(@$not_done_input) == 0)
                    @if (@$assesment)
                        <button class="btn btn-danger pull-right">Perbarui</button>
                        <a href="{{url()->current()}}" class="btn btn-warning pull-right">Batal Edit</a>
                    @else
                        <input type="hidden" name="simpan" value="true">
                        <button class="btn btn-success pull-right">Simpan</button>
                    @endif
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

        function markAsDone(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/emr-soap/pemeriksaan/mark-done/daftar-pemberian-terapi/' + id,
                type: 'POST',
                dataType: 'json',
            })
            .done(function(data) {
                if (data.sukses) {
                    alert('Berhasil Menandai Selesai');
                    window.location.reload();
                } else {
                    alert('Gagal Menandadi Selesai');
                }
            })
            .fail(function() {
                alert('Gagal Menandadi Selesai');
            });
            
        }
    </script>
    
@endsection
