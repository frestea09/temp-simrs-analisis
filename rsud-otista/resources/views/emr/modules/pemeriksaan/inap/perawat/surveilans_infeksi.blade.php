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

    tr, td {
        padding: 1rem !important;
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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/form-surveilans-infeksi/' . $unit . '/' . $reg->id) }}"
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
                          <h4 style="text-align: center; padding: 10px"><b>FORMULIR SURVEILANS INFEKSI</b></h4>
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
                                          {{@Carbon\Carbon::parse(@$riwayat->registrasi->created_at)->format('d-m-Y H:i')}}
                                      </td>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          {{ @$riwayat->user->name }}
                                      </td>
                                      <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                          <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                          
                                          <a href="{{ url("cetak-formulir-surveilans-infeksi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
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
                    <div class="col-md-6">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width:30%; font-weight:bold;">Diagnosa saat masuk</td>
                                <td>
                                    <textarea class="form-control" name="fisik[diagnosa_saat_masuk]" style="width: 100%" rows="4">{{@$assesment['diagnosa_saat_masuk']}}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Faktor Risiko Selama Di Rawat</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[faktor_risiko][keganasan]"
                                            {{ @$assesment['faktor_risiko']['keganasan'] == 'Keganasan' ? 'checked' : '' }}
                                            type="checkbox" value="Keganasan">
                                        <label class="form-check-label" style="font-weight: 400;">Keganasan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[faktor_risiko][gizi_buruk]"
                                            {{ @$assesment['faktor_risiko']['gizi_buruk'] == 'Gizi Buruk' ? 'checked' : '' }}
                                            type="checkbox" value="Gizi Buruk">
                                        <label class="form-check-label" style="font-weight: 400;">Gizi Buruk</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[faktor_risiko][ggn_imunitas]"
                                            {{ @$assesment['faktor_risiko']['ggn_imunitas'] == 'Ggn. Imunitas' ? 'checked' : '' }}
                                            type="checkbox" value="Ggn. Imunitas">
                                        <label class="form-check-label" style="font-weight: 400;">Ggn. Imunitas</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[faktor_risiko][diabetes]"
                                            {{ @$assesment['faktor_risiko']['diabetes'] == 'Diabetes' ? 'checked' : '' }}
                                            type="checkbox" value="Diabetes">
                                        <label class="form-check-label" style="font-weight: 400;">Diabetes</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[faktor_risiko][hiv]"
                                            {{ @$assesment['faktor_risiko']['hiv'] == 'HIV' ? 'checked' : '' }}
                                            type="checkbox" value="HIV">
                                        <label class="form-check-label" style="font-weight: 400;">HIV</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[faktor_risiko][hbv]"
                                            {{ @$assesment['faktor_risiko']['hbv'] == 'HBV' ? 'checked' : '' }}
                                            type="checkbox" value="HBV">
                                        <label class="form-check-label" style="font-weight: 400;">HBV</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[faktor_risiko][hcv]"
                                            {{ @$assesment['faktor_risiko']['hcv'] == 'HCV' ? 'checked' : '' }}
                                            type="checkbox" value="HCV">
                                        <label class="form-check-label" style="font-weight: 400;">HCV</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width:30%; font-weight:bold;">PENGAWASAN RISIKO INFEKSI ALIRAN DARAH PRIMER ( IADP )/PLEBITIS</td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Jenis Akses:</td>
                                <td>
                                    (1) Kateter vena perifer <br>
                                    (2) kateter vena sentral <br>
                                    (3) Kateter arteri <br>
                                    (4) Kateter umbilical <br>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        
                        <table class="border" style="width: 100%;">
                            <tr class="border">
                                <td rowspan="2" class="border text-center bold">NO</td>
                                <td rowspan="2" class="border text-center bold">Lokasi</td>
                                <td rowspan="2" class="border text-center bold">Kode Akses 1/2/3/4</td>
                                <td colspan="2" class="border text-center bold">Tanggal Pemasangan</td>
                                <td colspan="2" class="border text-center bold">Kemerahan</td>
                                <td colspan="2" class="border text-center bold">Bengkak</td>
                                <td colspan="2" class="border text-center bold">Demam</td>
                                <td colspan="2" class="border text-center bold">Nyeri</td>
                                <td colspan="2" class="border text-center bold">Pus</td>
                                <td rowspan="2" class="border text-center bold">Hasil Kultur Darah</td>
                            </tr>
                            <tr class="border">
                                <td class="border bold text-center">Mulai</td>
                                <td class="border bold text-center">S/D Selesai</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                            </tr>

                            @for ($i = 1; $i <= 27; $i++)
                                <tr class="border">
                                    <td class="border bold">
                                        {{$i}}
                                    </td>
                                    <td class="border">
                                        <input type="text" name="fisik[pengawasan_risiko_infeksi][{{$i}}][lokasi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pengawasan_risiko_infeksi'][$i]['lokasi']}}">
                                    </td>
                                    <td class="border">
                                        <input type="text" name="fisik[pengawasan_risiko_infeksi][{{$i}}][kode_akses]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pengawasan_risiko_infeksi'][$i]['kode_akses']}}">
                                    </td>
                                    <td class="border">
                                        <input type="text" name="fisik[pengawasan_risiko_infeksi][{{$i}}][tanggal_pemasangan][mulai]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pengawasan_risiko_infeksi'][$i]['tanggal_pemasangan']['mulai']}}">
                                    </td>
                                    <td class="border">
                                        <input type="text" name="fisik[pengawasan_risiko_infeksi][{{$i}}][tanggal_pemasangan][selesai]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pengawasan_risiko_infeksi'][$i]['tanggal_pemasangan']['selesai']}}">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][kemerahan][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['kemerahan']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][kemerahan][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['kemerahan']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][bengkak][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['bengkak']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][bengkak][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['bengkak']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][demam][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['demam']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][demam][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['demam']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][nyeri][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['nyeri']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][nyeri][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['nyeri']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][pus][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['pus']['ya'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_risiko_infeksi][{{$i}}][pus][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_risiko_infeksi'][$i]['pus']['tidak'] == "dipilih" ? "checked" : ""}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="text" name="fisik[pengawasan_risiko_infeksi][{{$i}}][hasil_kultur_darah]" style="display:inline-block;" id="" value="{{@$assesment['pengawasan_risiko_infeksi'][$i]['hasil_kultur_darah']}}" class="form-control">
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width:30%; font-weight:bold;">PHLEBITIS</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[phlebitis][pilihan]"
                                            {{ @$assesment['phlebitis']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[phlebitis][pilihan]"
                                            {{ @$assesment['phlebitis']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">IADP</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[iadp][pilihan]"
                                            {{ @$assesment['iadp']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[iadp][pilihan]"
                                            {{ @$assesment['iadp']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width:30%; font-weight:bold;">TOTAL HARI PEMASANGAN</td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Kateterperifer (Hari)</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[kateterperifer]" style="width: 100%" value="{{@$assesment['kateterperifer']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Katetersentral (Hari)</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[katetersentral]" style="width: 100%" value="{{@$assesment['katetersentral']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;" colspan="2">PENGAWASAN INFEKSI SALURAN KEMIH (ISK)</td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Kateter urin</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kateter_urin][pilihan]"
                                            {{ @$assesment['kateter_urin']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kateter_urin][pilihan]"
                                            {{ @$assesment['kateter_urin']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        
                        <table class="border" style="width: 100%;">
                            <tr class="border">
                                <td rowspan="2" class="border text-center bold">NO</td>
                                <td colspan="2" class="border text-center bold">Tanggal Pemasangan</td>
                                <td colspan="2" class="border text-center bold">Kemerahan Dalam Urin</td>
                                <td colspan="2" class="border text-center bold">Demam</td>
                                <td colspan="2" class="border text-center bold">Nyeri Berkemih</td>
                                <td colspan="2" class="border text-center bold">Pus Dalam Urin</td>
                                <td rowspan="2" class="border text-center bold">Hasil Kultur Urin</td>
                            </tr>
                            <tr class="border">
                                <td class="border bold text-center">Mulai</td>
                                <td class="border bold text-center">S/D</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                            </tr>

                            @for ($i = 1; $i <= 3; $i++)
                                <tr class="border">
                                    <td class="border bold">
                                        {{$i}}
                                    </td>
                                    <td class="border">
                                        <input type="text" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][tanggal_pemasangan][mulai]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['tanggal_pemasangan']['mulai']}}">
                                    </td>
                                    <td class="border">
                                        <input type="text" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][tanggal_pemasangan][selesai]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['tanggal_pemasangan']['selesai']}}">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][kemerahan][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['kemerahan']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][kemerahan][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['kemerahan']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][demam][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['demam']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][demam][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['demam']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][nyeri][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['nyeri']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][nyeri][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['nyeri']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][pus][ya]" style="display:inline-block;" id="" {{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['pus']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][pus][tidak]" style="display:inline-block;" id="" {{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['pus']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border">
                                        <input type="text" name="fisik[pengawasan_infeksi_saluran_kemih][{{$i}}][hasil_kultur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pengawasan_infeksi_saluran_kemih'][$i]['hasil_kultur']}}">
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    </div>

                    
                    <div class="col-md-6">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width:30%; font-weight:bold;">KEJADIAN ISK</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kejadian_isk][pilihan]"
                                            {{ @$assesment['kejadian_isk']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kejadian_isk][pilihan]"
                                            {{ @$assesment['kejadian_isk']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">TOTAL LAMA PEMASANGAN KATETER URIN</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[total_lama_pemasangan_kateter_urin]" style="width: 100%" value="{{@$assesment['total_lama_pemasangan_kateter_urin']}}">
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="width:30%; font-weight:bold;">PEMASANGAN VENTILATOR ASSOCIATED PNEUMONIA (VAP)</td>
                            </tr>
                           
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="border" style="width: 100%;">
                            <tr class="border">
                                <td rowspan="2" class="border text-center bold">NO</td>
                                <td rowspan="2" class="border text-center bold">Tanggal Kejadian</td>
                                <td colspan="2" class="border text-center bold">Batuk</td>
                                <td colspan="2" class="border text-center bold">Demam</td>
                                <td colspan="2" class="border text-center bold">Leukositosis / Leukopeni</td>
                                <td colspan="2" class="border text-center bold">Ronkhi</td>
                                <td colspan="2" class="border text-center bold">Sesak</td>
                                <td colspan="3" class="border text-center bold">Jenis Sputum</td>
                            </tr>
                            <tr class="border">
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Ya</td>
                                <td class="border bold text-center">Tidak</td>
                                <td class="border bold text-center">Encer</td>
                                <td class="border bold text-center">Kental</td>
                                <td class="border bold text-center">Purulent</td>
                            </tr>

                            @for ($i = 1; $i <= 2; $i++)
                                <tr class="border">
                                    <td class="border bold">
                                        {{$i}}
                                    </td>
                                    <td class="border">
                                        <input type="text" name="fisik[pemasangan_ventilator_associated][{{$i}}][tanggal_kejadian]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemasangan_ventilator_associated'][$i]['tanggal_kejadian']}}">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][batuk][ya]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['batuk']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][batuk][tidak]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['batuk']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][demam][ya]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['demam']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][demam][tidak]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['demam']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][leukopeni][ya]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['leukopeni']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][leukopeni][tidak]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['leukopeni']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][ronkhi][ya]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['ronkhi']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][ronkhi][tidak]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['ronkhi']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][sesak][ya]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['sesak']['ya'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][sesak][tidak]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['sesak']['tidak'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][jenis_sputum][encer]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['jenis_sputum']['encer'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][jenis_sputum][kental]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['jenis_sputum']['kental'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                    <td class="border text-center">
                                        <input type="checkbox" name="fisik[pemasangan_ventilator_associated][{{$i}}][jenis_sputum][purulen]" style="display:inline-block;" id="" {{@$assesment['pemasangan_ventilator_associated'][$i]['jenis_sputum']['purulen'] == "dipilih" ? 'checked' : ''}} value="dipilih">
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width:30%; font-weight:bold;">Tanggal Pasang</td>
                                <td>
                                    <input type="datetime-local" class="form-control" name="fisik[tanggal_pasang_ventilator]" style="width: 100%" value="{{@$assesment['tanggal_pasang_ventilator']}}">
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="width:30%; font-weight:bold;">PEMANTAUAN INFEKSI DAERAH OPERASI (IDO)</td>
                            </tr>

                            <tr>
                                <td style="width:30%; font-weight:bold;">Pemakaian antibiotika profilaksis</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pemakaian_antibioka_profilaksis][ya]"
                                            {{ @$assesment['pemakaian_antibioka_profilaksis']['ya'] == 'ya' ? 'checked' : '' }}
                                            type="checkbox" value="ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya, sebutkan</label>
                                        <input type="text" class="form-control" name="fisik[pemakaian_antibioka_profilaksis][sebutkan]" style="width: 100%" value="{{@$assesment['pemakaian_antibioka_profilaksis']['sebutkan']}}">
                                    </div>
                                </td>
                            </tr>
                           
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="border" style="width: 100%;">
                            <tr class="border">
                                <td rowspan="2" class="border text-center bold">Keadaan Luka</td>
                                <td colspan="22" class="border text-center bold">Hari Operasi</td>
                            </tr>
                            <tr class="border">
                                @for ($i = 1; $i <= 22; $i++)
                                    <td class="border bold text-center">{{$i}}</td>
                                @endfor
                            </tr>

                            <tr class="border">
                                <td class="border text-center bold">KEMERAHAN</td>
                                @for ($i = 1; $i <= 22; $i++)
                                    <td class="border bold text-center">
                                        <input type="text" class="form-control" name="fisik[pemantauan_infeksi_daerah_operasi][kemerahan][{{$i}}]" style="width: 100%" value="{{@$assesment['pemantauan_infeksi_daerah_operasi']['kemerahan'][$i]}}">
                                    </td>
                                @endfor
                            </tr>

                            <tr class="border">
                                <td class="border text-center bold">EDEMA</td>
                                @for ($i = 1; $i <= 22; $i++)
                                    <td class="border bold text-center">
                                        <input type="text" class="form-control" name="fisik[pemantauan_infeksi_daerah_operasi][edema][{{$i}}]" style="width: 100%" value="{{@$assesment['pemantauan_infeksi_daerah_operasi']['edema'][$i]}}">
                                    </td>
                                @endfor
                            </tr>

                            <tr class="border">
                                <td class="border text-center bold">CAIRAN</td>
                                @for ($i = 1; $i <= 22; $i++)
                                    <td class="border bold text-center">
                                        <input type="text" class="form-control" name="fisik[pemantauan_infeksi_daerah_operasi][cairan][{{$i}}]" style="width: 100%" value="{{@$assesment['pemantauan_infeksi_daerah_operasi']['cairan'][$i]}}">
                                    </td>
                                @endfor
                            </tr>

                            <tr class="border">
                                <td class="border text-center bold">NYERI</td>
                                @for ($i = 1; $i <= 22; $i++)
                                    <td class="border bold text-center">
                                        <input type="text" class="form-control" name="fisik[pemantauan_infeksi_daerah_operasi][nyeri][{{$i}}]" style="width: 100%" value="{{@$assesment['pemantauan_infeksi_daerah_operasi']['nyeri'][$i]}}">
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width:30%; font-weight:bold;">Kejadian Infeksi Daerah (IDO)</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kejadian_infeksi_daerah][pilihan]"
                                            {{ @$assesment['kejadian_infeksi_daerah']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kejadian_infeksi_daerah][pilihan]"
                                            {{ @$assesment['kejadian_infeksi_daerah']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                           
                            
                            <tr>
                                <td colspan="2" style="width:30%; font-weight:bold;">PEMANTAUAN LUKA TEKAN / DEKUBITUS</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <table class="border" style="width: 100%;">
                            <tr class="border">
                                <td colspan="8" class="border text-center bold">Kondisi Pasien</td>
                                <td colspan="6" class="border text-center bold">Inspeksi Kulit</td>
                            </tr>
                            <tr class="border">
                                <td colspan="2" class="border text-center bold">Immobilisasi</td>
                                <td colspan="2" class="border text-center bold">Penurunan Sensori</td>
                                <td colspan="2" class="border text-center bold">Adanya Penekanan</td>
                                <td colspan="2" class="border text-center bold">Kelembaban Kulit</td>
                                <td colspan="2" class="border text-center bold">Kemerahan</td>
                                <td colspan="2" class="border text-center bold">Lecet</td>
                                <td colspan="2" class="border text-center bold">Luka Tekan</td>
                            </tr>
                            <tr class="border">
                                <td class="border text-center bold">Ya</td>
                                <td class="border text-center bold">Tidak</td>
                                <td class="border text-center bold">Ya</td>
                                <td class="border text-center bold">Tidak</td>
                                <td class="border text-center bold">Ya</td>
                                <td class="border text-center bold">Tidak</td>
                                <td class="border text-center bold">Ya</td>
                                <td class="border text-center bold">Tidak</td>
                                <td class="border text-center bold">Ya</td>
                                <td class="border text-center bold">Tidak</td>
                                <td class="border text-center bold">Ya</td>
                                <td class="border text-center bold">Tidak</td>
                                <td class="border text-center bold">Ya</td>
                                <td class="border text-center bold">Tidak</td>
                            </tr>
                            <tr class="border">
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][immobilisasi][ya]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['immobilisasi']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][immobilisasi][tidak]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['immobilisasi']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][penuruan_sensori][ya]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['penuruan_sensori']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][penuruan_sensori][tidak]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['penuruan_sensori']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][adanya_penekanan][ya]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['adanya_penekanan']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][adanya_penekanan][tidak]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['adanya_penekanan']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][kelembaban_kulit][ya]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['kelembaban_kulit']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][kelembaban_kulit][tidak]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['kelembaban_kulit']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][kemerahan][ya]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['kemerahan']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][kemerahan][tidak]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['kemerahan']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][lecet][ya]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['lecet']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][lecet][tidak]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['lecet']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][luka_tekan][ya]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['luka_tekan']['ya'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                                <td class="border text-center">
                                    <input type="checkbox" name="fisik[pemantauan_luka_tekan][1][luka_tekan][tidak]" style="display:inline-block;" id="" {{@$assesment['pemantauan_luka_tekan']['1']['luka_tekan']['tidak'] == 'dipilih' ? 'checked' : ''}} value="dipilih">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="width:30%; font-weight:bold;">KEJADIAN LUKA TEKAN / DEKUBITUS</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kejadian_luka_tekan_dekubitus][pilihan]"
                                            {{ @$assesment['kejadian_luka_tekan_dekubitus']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kejadian_luka_tekan_dekubitus][pilihan]"
                                            {{ @$assesment['kejadian_luka_tekan_dekubitus']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%; font-weight:bold;">TANGGAL PASIEN KELUAR RS</td>
                                <td>
                                    <input type="datetime-local" class="form-control" name="fisik[tanggal_pasien_keluar_rs]" style="width: 100%" value="{{@$assesment['tanggal_pasien_keluar_rs']}}">
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
    </script>
    
@endsection
