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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/catatan-persalinan/' . $unit . '/' . $reg->id) }}"
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
                          <h4 style="text-align: center; padding: 10px"><b>Catatan Persalinan</b></h4>
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
                                          
                                          {{-- <a href="{{ url("cetak-formulir-surveilans-infeksi/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" target="_blank" class="btn btn-warning btn-sm">
                                            <i class="fa fa-print"></i>
                                          </a> --}}

                                          {{-- <a href="{{ url("emr-soap-hapus-pemeriksaan/".$unit."/".@$riwayat->registrasi_id."/".@$riwayat->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
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

                    <div class="col-md-6">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                           <tr>
                                <td style="font-weight: bold">Tanggal</td>
                                <td>
                                    <input type="date" name="fisik[tanggal]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tanggal']}}">
                                </td>
                           </tr>
                           <tr>
                                <td style="font-weight: bold">Nama bidan</td>
                                <td>
                                    <input type="text" name="fisik[nama_bidan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['nama_bidan']}}">
                                </td>
                           </tr>
                           <tr>
                                <td style="font-weight: bold">Tempat Persalinan</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[tempat_persalinan][pilihan]"
                                            {{ @$assesment['tempat_persalinan']['pilihan'] == 'Rumbah Ibu' ? 'checked' : '' }}
                                            type="radio" value="Rumbah Ibu">
                                        <label class="form-check-label" style="font-weight: 400;">Rumbah Ibu</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[tempat_persalinan][pilihan]"
                                            {{ @$assesment['tempat_persalinan']['pilihan'] == 'Polindes' ? 'checked' : '' }}
                                            type="radio" value="Polindes">
                                        <label class="form-check-label" style="font-weight: 400;">Polindes</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[tempat_persalinan][pilihan]"
                                            {{ @$assesment['tempat_persalinan']['pilihan'] == 'Klinik Swasta' ? 'checked' : '' }}
                                            type="radio" value="Klinik Swasta">
                                        <label class="form-check-label" style="font-weight: 400;">Klinik Swasta</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[tempat_persalinan][pilihan]"
                                            {{ @$assesment['tempat_persalinan']['pilihan'] == 'Puskesmas' ? 'checked' : '' }}
                                            type="radio" value="Puskesmas">
                                        <label class="form-check-label" style="font-weight: 400;">Puskesmas</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[tempat_persalinan][pilihan]"
                                            {{ @$assesment['tempat_persalinan']['pilihan'] == 'Rumah Sakit' ? 'checked' : '' }}
                                            type="radio" value="Rumah Sakit">
                                        <label class="form-check-label" style="font-weight: 400;">Rumah Sakit</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[tempat_persalinan][pilihan]"
                                            {{ @$assesment['tempat_persalinan']['pilihan'] == 'Lainnya' ? 'checked' : '' }}
                                            type="radio" value="Lainnya">
                                        <label class="form-check-label" style="font-weight: 400;">Lainnya</label>
                                        <input type="text" name="fisik[tempat_persalinan][pilihan_lainnya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tempat_persalinan']['pilihan_lainnya']}}">
                                    </div>
                                </td>
                           </tr>
                           <tr>
                                <td style="font-weight: bold">ALamat tempat persalinan</td>
                                <td>
                                    <input type="text" name="fisik[alamat_persalinan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['alamat_persalinan']}}">
                                </td>
                            </tr>
                           <tr>
                                <td style="font-weight: bold">Catatan: rujuk, kala</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[catatan][pilihan]"
                                            {{ @$assesment['catatan']['pilihan'] == 'I' ? 'checked' : '' }}
                                            type="radio" value="I">
                                        <label class="form-check-label" style="font-weight: 400;">I</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[catatan][pilihan]"
                                            {{ @$assesment['catatan']['pilihan'] == 'II' ? 'checked' : '' }}
                                            type="radio" value="II">
                                        <label class="form-check-label" style="font-weight: 400;">II</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[catatan][pilihan]"
                                            {{ @$assesment['catatan']['pilihan'] == 'III' ? 'checked' : '' }}
                                            type="radio" value="III">
                                        <label class="form-check-label" style="font-weight: 400;">III</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[catatan][pilihan]"
                                            {{ @$assesment['catatan']['pilihan'] == 'IV' ? 'checked' : '' }}
                                            type="radio" value="IV">
                                        <label class="form-check-label" style="font-weight: 400;">IV</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Alasan merujuk:</td>
                                <td>
                                    <input type="text" name="fisik[alasan_merujuk]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['alasan_merujuk']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Tempat rujukan:</td>
                                <td>
                                    <input type="text" name="fisik[tempat_rujukan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['tempat_rujukan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Pendamping pada saat merujuk:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pendamping][pilihan]"
                                            {{ @$assesment['pendamping']['pilihan'] == 'Bidan' ? 'checked' : '' }}
                                            type="radio" value="Bidan">
                                        <label class="form-check-label" style="font-weight: 400;">Bidan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pendamping][pilihan]"
                                            {{ @$assesment['pendamping']['pilihan'] == 'Suami' ? 'checked' : '' }}
                                            type="radio" value="Suami">
                                        <label class="form-check-label" style="font-weight: 400;">Suami</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pendamping][pilihan]"
                                            {{ @$assesment['pendamping']['pilihan'] == 'Keluarga' ? 'checked' : '' }}
                                            type="radio" value="Keluarga">
                                        <label class="form-check-label" style="font-weight: 400;">Keluarga</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pendamping][pilihan]"
                                            {{ @$assesment['pendamping']['pilihan'] == 'Teman' ? 'checked' : '' }}
                                            type="radio" value="Teman">
                                        <label class="form-check-label" style="font-weight: 400;">Teman</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pendamping][pilihan]"
                                            {{ @$assesment['pendamping']['pilihan'] == 'Dukun' ? 'checked' : '' }}
                                            type="radio" value="Dukun">
                                        <label class="form-check-label" style="font-weight: 400;">Dukun</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pendamping][pilihan]"
                                            {{ @$assesment['pendamping']['pilihan'] == 'Tidak ada' ? 'checked' : '' }}
                                            type="radio" value="Tidak ada">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <h5><b>KALA I</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                           <tr>
                                <td style="font-weight: bold">Partograf melewati gariw waspada:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_1][partograf_melewati_garis_waspada][pilihan]"
                                            {{ @$assesment['kala_1']['partograf_melewati_garis_waspada'['pilihan']] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_1][partograf_melewati_garis_waspada][pilihan]"
                                            {{ @$assesment['kala_1']['partograf_melewati_garis_waspada'['pilihan']] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                           </tr>
                           <tr>
                                <td style="font-weight: bold">Masalah lain, sebutkan:</td>
                                <td>
                                    <input type="text" name="fisik[kala_1][masalah_lain]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_1']['masalah_lain']}}">
                                </td>
                           </tr>
                           <tr>
                                <td style="font-weight: bold">Penatalaksanaan masalah tsb:</td>
                                <td>
                                    <input type="text" name="fisik[kala_1][penatalaksanaan_masalah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_1']['penatalaksanaan_masalah']}}">
                                </td>
                           </tr>
                           <tr>
                                <td style="font-weight: bold">Hasilnya:</td>
                                <td>
                                    <input type="text" name="fisik[kala_1][hasilnya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_1']['hasilnya']}}">
                                </td>
                           </tr>
                        </table>

                        <h5><b>KALA II</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                           <tr>
                                <td style="font-weight: bold">Episiotomi:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][episiotomi][pilihan]"
                                            {{ @$assesment['kala_2']['episiotomi'['pilihan']] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya, indikasi</label>
                                        <input type="text" name="fisik[kala_2][episiotomi][pilihan_ya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['episiotomi']['pilihan_ya']}}">
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][episiotomi][pilihan]"
                                            {{ @$assesment['kala_2']['episiotomi'['pilihan']] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                           </tr>
                           <tr>
                                <td style="font-weight: bold">Pendamping pada saat persalinan:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][pendamping][pilihan]"
                                            {{ @$assesment['kala_2']['pendamping']['pilihan'] == 'Suami' ? 'checked' : '' }}
                                            type="radio" value="Suami">
                                        <label class="form-check-label" style="font-weight: 400;">Suami</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][pendamping][pilihan]"
                                            {{ @$assesment['kala_2']['pendamping']['pilihan'] == 'Keluarga' ? 'checked' : '' }}
                                            type="radio" value="Keluarga">
                                        <label class="form-check-label" style="font-weight: 400;">Keluarga</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][pendamping][pilihan]"
                                            {{ @$assesment['kala_2']['pendamping']['pilihan'] == 'Teman' ? 'checked' : '' }}
                                            type="radio" value="Teman">
                                        <label class="form-check-label" style="font-weight: 400;">Teman</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][pendamping][pilihan]"
                                            {{ @$assesment['kala_2']['pendamping']['pilihan'] == 'Dukun' ? 'checked' : '' }}
                                            type="radio" value="Dukun">
                                        <label class="form-check-label" style="font-weight: 400;">Dukun</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][pendamping][pilihan]"
                                            {{ @$assesment['kala_2']['pendamping']['pilihan'] == 'Tidak ada' ? 'checked' : '' }}
                                            type="radio" value="Tidak ada">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak ada</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Gawat janin:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][gawat_janin][pilihan]"
                                            {{ @$assesment['kala_2']['gawat_janin'['pilihan']] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya, tindakan yang dilakukan</label>
                                        <input type="text" name="fisik[kala_2][gawat_janin][pilihan_ya_1]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['gawat_janin']['pilihan_ya_1']}}">
                                        <input type="text" name="fisik[kala_2][gawat_janin][pilihan_ya_2]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['gawat_janin']['pilihan_ya_2']}}">
                                        <input type="text" name="fisik[kala_2][gawat_janin][pilihan_ya_3]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['gawat_janin']['pilihan_ya_3']}}">
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][gawat_janin][pilihan]"
                                            {{ @$assesment['kala_2']['gawat_janin'['pilihan']] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Distosia bahu:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][distosia_bahu][pilihan]"
                                            {{ @$assesment['kala_2']['distosia_bahu'['pilihan']] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya, tindakan yang dilakukan</label>
                                        <input type="text" name="fisik[kala_2][distosia_bahu][pilihan_ya_1]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['distosia_bahu']['pilihan_ya_1']}}">
                                        <input type="text" name="fisik[kala_2][distosia_bahu][pilihan_ya_2]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['distosia_bahu']['pilihan_ya_2']}}">
                                        <input type="text" name="fisik[kala_2][distosia_bahu][pilihan_ya_3]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['distosia_bahu']['pilihan_ya_3']}}">
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_2][distosia_bahu][pilihan]"
                                            {{ @$assesment['kala_2']['distosia_bahu'['pilihan']] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Masalah lain, sebutkan:</td>
                                <td>
                                    <input type="text" name="fisik[kala_2][masalah_lain]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['masalah_lain']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Penatalaksanaan masalah tersebut:</td>
                                <td>
                                    <input type="text" name="fisik[kala_2][penatalaksanaan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['penatalaksanaan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Hasilnya:</td>
                                <td>
                                    <input type="text" name="fisik[kala_2][hasilnya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_2']['hasilnya']}}">
                                </td>
                            </tr>
                        </table>

                        <h5><b>KALA III</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                           <tr>
                                <td style="font-weight: bold">Lama kala III (Menit):</td>
                                <td>
                                    <input type="text" name="fisik[kala_3][lama_kala]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['lama_kala']}}">
                                </td>
                           </tr>
                           <tr>
                                <td style="font-weight: bold">Pemberian Oktsithosin 10 U M ?:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_3][pemberian_oktsithosin][pilihan]"
                                            {{ @$assesment['kala_3']['pemberian_oktsithosin']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya, waktu</label>
                                        <input type="text" name="fisik[kala_3][pemberian_oktsithosin][pilihan_ya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['pemberian_oktsithosin']['pilihan_ya']}}">
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_3][pemberian_oktsithosin][pilihan]"
                                            {{ @$assesment['kala_3']['pemberian_oktsithosin']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                                        <input type="text" name="fisik[kala_3][pemberian_oktsithosin][pilihan_tidak]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['pemberian_oktsithosin']['pilihan_tidak']}}">
                                    </div>
                                </td>
                            </tr>
                           <tr>
                                <td style="font-weight: bold">Pemberian ulang Oktsithosin ?:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_3][pemberian_ulang_oktsithosin][pilihan]"
                                            {{ @$assesment['kala_3']['pemberian_ulang_oktsithosin']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya, waktu</label>
                                        <input type="text" name="fisik[kala_3][pemberian_ulang_oktsithosin][pilihan_ya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['pemberian_ulang_oktsithosin']['pilihan_ya']}}">
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_3][pemberian_ulang_oktsithosin][pilihan]"
                                            {{ @$assesment['kala_3']['pemberian_ulang_oktsithosin']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                                        <input type="text" name="fisik[kala_3][pemberian_ulang_oktsithosin][pilihan_tidak]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['pemberian_ulang_oktsithosin']['pilihan_tidak']}}">
                                    </div>
                                </td>
                            </tr>
                           <tr>
                                <td style="font-weight: bold">Penegangan tali pusat terkendali ?:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_3][penegangan_tali_pusat][pilihan]"
                                            {{ @$assesment['kala_3']['penegangan_tali_pusat']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya, waktu</label>
                                        <input type="text" name="fisik[kala_3][penegangan_tali_pusat][pilihan_ya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['penegangan_tali_pusat']['pilihan_ya']}}">
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_3][penegangan_tali_pusat][pilihan]"
                                            {{ @$assesment['kala_3']['penegangan_tali_pusat']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                                        <input type="text" name="fisik[kala_3][penegangan_tali_pusat][pilihan_tidak]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['penegangan_tali_pusat']['pilihan_tidak']}}">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                 <td style="font-weight: bold">Masase Fundus Uteri?:</td>
                                 <td>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][masase_fundus_uteri][pilihan]"
                                             {{ @$assesment['kala_3']['masase_fundus_uteri']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                             type="radio" value="Ya">
                                         <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                     </div>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][masase_fundus_uteri][pilihan]"
                                             {{ @$assesment['kala_3']['masase_fundus_uteri']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                             type="radio" value="Tidak">
                                         <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                                         <input type="text" name="fisik[kala_3][masase_fundus_uteri][pilihan_tidak]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['masase_fundus_uteri']['pilihan_tidak']}}">
                                     </div>
                                 </td>
                             </tr>
                            <tr>
                                 <td style="font-weight: bold">Plasenta lahir lengkap?:</td>
                                 <td>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][plasenta_lahir_lengkap][pilihan]"
                                             {{ @$assesment['kala_3']['plasenta_lahir_lengkap']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                             type="radio" value="Ya">
                                         <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                     </div>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][plasenta_lahir_lengkap][pilihan]"
                                             {{ @$assesment['kala_3']['plasenta_lahir_lengkap']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                             type="radio" value="Tidak">
                                         <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                     </div>
                                     
                                     <label class="form-check-label" style="font-weight: 400;">Jika tidak lengkap, tindakan yang dilakukan :</label>
                                    <input type="text" name="fisik[kala_3][plasenta_lahir_lengkap][pilihan_tidak_1]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['plasenta_lahir_lengkap']['pilihan_tidak_1']}}">
                                    <input type="text" name="fisik[kala_3][plasenta_lahir_lengkap][pilihan_tidak_2]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['plasenta_lahir_lengkap']['pilihan_tidak_2']}}">
                                    <input type="text" name="fisik[kala_3][plasenta_lahir_lengkap][pilihan_tidak_3]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['plasenta_lahir_lengkap']['pilihan_tidak_3']}}">
                                 </td>
                             </tr>
                            <tr>
                                 <td style="font-weight: bold">Plasenta tidak lahir > 30 menit?:</td>
                                 <td>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][plasenta_tidak_lahir][pilihan]"
                                             {{ @$assesment['kala_3']['plasenta_tidak_lahir']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                             type="radio" value="Ya">
                                         <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                     </div>
                                     <label class="form-check-label" style="font-weight: 400;">Ya, Tindakan :</label>
                                     <input type="text" name="fisik[kala_3][plasenta_tidak_lahir][pilihan_ya_1]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['plasenta_tidak_lahir']['pilihan_ya_1']}}">
                                     <input type="text" name="fisik[kala_3][plasenta_tidak_lahir][pilihan_ya_2]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['plasenta_tidak_lahir']['pilihan_ya_2']}}">
                                     <input type="text" name="fisik[kala_3][plasenta_tidak_lahir][pilihan_ya_3]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['plasenta_tidak_lahir']['pilihan_ya_3']}}">
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][plasenta_tidak_lahir][pilihan]"
                                             {{ @$assesment['kala_3']['plasenta_tidak_lahir']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                             type="radio" value="Tidak">
                                         <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                     </div>
                                 </td>
                             </tr>
                            <tr>
                                 <td style="font-weight: bold">Lasensat:</td>
                                 <td>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][lasensat][pilihan]"
                                             {{ @$assesment['kala_3']['lasensat']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                             type="radio" value="Ya">
                                         <label class="form-check-label" style="font-weight: 400;">Ya, dimana</label>
                                     </div>
                                     <input type="text" name="fisik[kala_3][lasensat][pilihan_ya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['lasensat']['pilihan_ya']}}">
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][lasensat][pilihan]"
                                             {{ @$assesment['kala_3']['lasensat']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                             type="radio" value="Tidak">
                                         <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                     </div>
                                 </td>
                             </tr>
                            <tr>
                                 <td style="font-weight: bold">Jika lasersatperneum, derajat:</td>
                                 <td>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][lasersatperneum_derajat][pilihan]"
                                             {{ @$assesment['kala_3']['lasersatperneum_derajat']['pilihan'] == '1' ? 'checked' : '' }}
                                             type="radio" value="1">
                                         <label class="form-check-label" style="font-weight: 400;">1</label>
                                     </div>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][lasersatperneum_derajat][pilihan]"
                                             {{ @$assesment['kala_3']['lasersatperneum_derajat']['pilihan'] == '2' ? 'checked' : '' }}
                                             type="radio" value="2">
                                         <label class="form-check-label" style="font-weight: 400;">2</label>
                                     </div>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][lasersatperneum_derajat][pilihan]"
                                             {{ @$assesment['kala_3']['lasersatperneum_derajat']['pilihan'] == '3' ? 'checked' : '' }}
                                             type="radio" value="3">
                                         <label class="form-check-label" style="font-weight: 400;">3</label>
                                     </div>
                                     <div>
                                         <input class="form-check-input"
                                             name="fisik[kala_3][lasersatperneum_derajat][pilihan]"
                                             {{ @$assesment['kala_3']['lasersatperneum_derajat']['pilihan'] == '4' ? 'checked' : '' }}
                                             type="radio" value="4">
                                         <label class="form-check-label" style="font-weight: 400;">4</label>
                                     </div>
                                 </td>
                            </tr>
                            <tr>
                                <td>Tindakan:</td>
                                <td>
                                    <input type="text" name="fisik[kala_3][lasersatperneum_derajat][tindakan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['lasersatperneum_derajat']['tindakan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>Penjahitan:</td>
                                <td>
                                    <input type="text" name="fisik[kala_3][lasersatperneum_derajat][penjahitan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['lasersatperneum_derajat']['penjahitan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>Tidak dijahit, alasan:</td>
                                <td>
                                    <input type="text" name="fisik[kala_3][lasersatperneum_derajat][alasan_tidak_dijahit]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['lasersatperneum_derajat']['alasan_tidak_dijahit']}}">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Alonia Utari?:</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_3][alinea_utari][pilihan]"
                                            {{ @$assesment['kala_3']['alinea_utari']['pilihan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                    <label class="form-check-label" style="font-weight: 400;">Ya, Tindakan :</label>
                                    <input type="text" name="fisik[kala_3][alinea_utari][pilihan_ya_1]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['alinea_utari']['pilihan_ya_1']}}">
                                    <input type="text" name="fisik[kala_3][alinea_utari][pilihan_ya_2]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['alinea_utari']['pilihan_ya_2']}}">
                                    <input type="text" name="fisik[kala_3][alinea_utari][pilihan_ya_3]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['alinea_utari']['pilihan_ya_3']}}">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[kala_3][alinea_utari][pilihan]"
                                            {{ @$assesment['kala_3']['alinea_utari']['pilihan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Jumlah pendarahan (ml):</td>
                                <td>
                                    <input type="text" name="fisik[kala_3][jumlah_pendarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['jumlah_pendarahan']}}">
                                </td>
                           </tr>
                            <tr>
                                <td style="font-weight: bold">Masalah lain, sebutkan:</td>
                                <td>
                                    <input type="text" name="fisik[kala_3][masalah_lain]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['masalah_lain']}}">
                                </td>
                           </tr>
                            <tr>
                                <td style="font-weight: bold">Hasilnya:</td>
                                <td>
                                    <input type="text" name="fisik[kala_3][hasilnya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['kala_3']['hasilnya']}}">
                                </td>
                           </tr>
                         </table>

                         <h5><b>BAYI BARU LAHIR</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td style="font-weight: bold">Berat badan (gram)</td>
                                <td>
                                    <input type="text" name="fisik[bayi_baru_lahir][berat_badan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['berat_badan']}}">
                                </td>
                           </tr>
                            <tr>
                                <td style="font-weight: bold">Panjang</td>
                                <td>
                                    <input type="text" name="fisik[bayi_baru_lahir][panjang]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['panjang']}}">
                                </td>
                           </tr>
                            <tr>
                                <td style="font-weight: bold">Jenis Kelamin</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][jenis_kelamin][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['jenis_kelamin']['pilihan'] == 'L' ? 'checked' : '' }}
                                            type="radio" value="L">
                                        <label class="form-check-label" style="font-weight: 400;">L</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][jenis_kelamin][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['jenis_kelamin']['pilihan'] == 'P' ? 'checked' : '' }}
                                            type="radio" value="P">
                                        <label class="form-check-label" style="font-weight: 400;">P</label>
                                    </div>
                                </td>
                           </tr>
                            <tr>
                                <td style="font-weight: bold">Penilaian bayi baru lahir</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][penilaian_bayi_lahir][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['penilaian_bayi_lahir']['pilihan'] == 'Baik' ? 'checked' : '' }}
                                            type="radio" value="Baik">
                                        <label class="form-check-label" style="font-weight: 400;">Baik</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][penilaian_bayi_lahir][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['penilaian_bayi_lahir']['pilihan'] == 'ada penyakit' ? 'checked' : '' }}
                                            type="radio" value="ada penyakit">
                                        <label class="form-check-label" style="font-weight: 400;">ada penyakit</label>
                                    </div>
                                </td>
                           </tr>
                            <tr>
                                <td style="font-weight: bold">Bayi Lahir</td>
                                <td>
                                    &nbsp;
                                </td>
                           </tr>
                            <tr>
                                <td>Normal tindakan</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Mengeringkan' ? 'checked' : '' }}
                                            type="radio" value="Mengeringkan">
                                        <label class="form-check-label" style="font-weight: 400;">Mengeringkan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Menghangatkan' ? 'checked' : '' }}
                                            type="radio" value="Menghangatkan">
                                        <label class="form-check-label" style="font-weight: 400;">Menghangatkan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Rangsangan' ? 'checked' : '' }}
                                            type="radio" value="Rangsangan">
                                        <label class="form-check-label" style="font-weight: 400;">Rangsangan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Bungkus bayi dan tempatkan di sisi ibu' ? 'checked' : '' }}
                                            type="radio" value="Bungkus bayi dan tempatkan di sisi ibu">
                                        <label class="form-check-label" style="font-weight: 400;">Bungkus bayi dan tempatkan di sisi ibu</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'tindakan pencegahan infeksi mata' ? 'checked' : '' }}
                                            type="radio" value="tindakan pencegahan infeksi mata">
                                        <label class="form-check-label" style="font-weight: 400;">tindakan pencegahan infeksi mata</label>
                                    </div>
                                </td>
                           </tr>
                            <tr>
                                <td>Aspliksis ringan / pucat / biru / lemas, tindakan</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Mengeringkan' ? 'checked' : '' }}
                                            type="radio" value="Mengeringkan">
                                        <label class="form-check-label" style="font-weight: 400;">Mengeringkan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Menghangatkan' ? 'checked' : '' }}
                                            type="radio" value="Menghangatkan">
                                        <label class="form-check-label" style="font-weight: 400;">Menghangatkan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Rangsangan' ? 'checked' : '' }}
                                            type="radio" value="Rangsangan">
                                        <label class="form-check-label" style="font-weight: 400;">Rangsangan</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'Bungkus bayi dan tempatkan di sisi ibu' ? 'checked' : '' }}
                                            type="radio" value="Bungkus bayi dan tempatkan di sisi ibu">
                                        <label class="form-check-label" style="font-weight: 400;">Bungkus bayi dan tempatkan di sisi ibu</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'bebaskan jalan napas' ? 'checked' : '' }}
                                            type="radio" value="bebaskan jalan napas">
                                        <label class="form-check-label" style="font-weight: 400;">bebaskan jalan napas</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][bayi_lahir][normal_tindakan][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['bayi_lahir']['normal_tindakan']['pilihan'] == 'lain lain' ? 'checked' : '' }}
                                            type="radio" value="lain lain">
                                        <label class="form-check-label" style="font-weight: 400;">lain lain, sebutkan</label>
                                        <input type="text" name="fisik[bayi_lahir][normal_tindakan][pilihan_lain]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_lahir']['normal_tindakan']['pilihan_lain']}}">
                                    </div>
                                </td>
                           </tr>
                           <tr>
                                    <td style="font-weight: bold">Cacat bawaan, sebutkan</td>
                                    <td>
                                        <input type="text" name="fisik[bayi_baru_lahir][bayi_lahir][cacat_bawaan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['bayi_lahir']['cacat_bawaan']}}">
                                    </td>
                            </tr>
                           <tr>
                                    <td style="font-weight: bold">Hipotermia, tindakan</td>
                                    <td>
                                        <input type="text" name="fisik[bayi_baru_lahir][bayi_lahir][hipotermia_1]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['bayi_lahir']['hipotermia_1']}}">
                                        <input type="text" name="fisik[bayi_baru_lahir][bayi_lahir][hiportemia_2]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['bayi_lahir']['hiportemia_2']}}">
                                        <input type="text" name="fisik[bayi_baru_lahir][bayi_lahir][hiportemia_3]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['bayi_lahir']['hiportemia_3']}}">
                                    </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Pemberian ASI</td>
                                <td>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][pemberian_asi][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['pemberian_asi']['pilihan'] == 'Ya, waktu' ? 'checked' : '' }}
                                            type="radio" value="Ya, waktu">
                                        <label class="form-check-label" style="font-weight: 400;">Ya, waktu</label>
                                        <input type="text" name="fisik[bayi_baru_lahir][pemberian_asi][pilihan_ya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['pemberian_asi']['pilihan_ya']}}">
                                    </div>
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[bayi_baru_lahir][pemberian_asi][pilihan]"
                                            {{ @$assesment['bayi_baru_lahir']['pemberian_asi']['pilihan'] == 'Tidak, alasan' ? 'checked' : '' }}
                                            type="radio" value="Tidak, alasan">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak, alasan</label>
                                        <input type="text" name="fisik[bayi_baru_lahir][pemberian_asi][pilihan_tidak]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['pemberian_asi']['pilihan_tidak']}}">
                                    </div>
                                </td>
                        </tr>
                        <tr>
                                <td style="font-weight: bold">Masalah lain, sebutkan</td>
                                <td>
                                    <input type="text" name="fisik[bayi_baru_lahir][masalah_lain][sebutkan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['masalah_lain']['sebutkan']}}">
                                </td>
                        </tr>
                        <tr>
                                <td style="font-weight: bold">Hasilnya</td>
                                <td>
                                    <input type="text" name="fisik[bayi_baru_lahir][hasilnya][jelaskan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['bayi_baru_lahir']['hasilnya']['jelaskan']}}">
                                </td>
                        </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5><b>PEMANTAUAN PERSALINAN KALA IV</b></h5>
                        <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                            <tr>
                                <td>Jam Ke</td>
                                <td>Waktu</td>
                                <td>Tekanan darah</td>
                                <td>Nadi</td>
                                <td>Temperatur</td>
                                <td>Tinggi Fundus Utari</td>
                                <td>Konstraksi Utarus</td>
                                <td>Kandung Kemih</td>
                                <td>Pendarahan</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][jam_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['jam_ke']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][waktu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['waktu']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][tekanan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['tekanan_darah']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][nadi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['nadi']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][temperatur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['temperatur']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][tinggi_fundus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['tinggi_fundus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][konstraksi_utarus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['konstraksi_utarus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][kandung_kamuh]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['kandung_kamuh']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_1][pendarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_1']['pendarahan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][jam_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['jam_ke']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][waktu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['waktu']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][tekanan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['tekanan_darah']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][nadi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['nadi']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][temperatur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['temperatur']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][tinggi_fundus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['tinggi_fundus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][konstraksi_utarus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['konstraksi_utarus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][kandung_kamuh]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['kandung_kamuh']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_2][pendarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_2']['pendarahan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][jam_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['jam_ke']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][waktu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['waktu']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][tekanan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['tekanan_darah']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][nadi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['nadi']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][temperatur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['temperatur']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][tinggi_fundus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['tinggi_fundus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][konstraksi_utarus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['konstraksi_utarus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][kandung_kamuh]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['kandung_kamuh']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_3][pendarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_3']['pendarahan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][jam_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['jam_ke']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][waktu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['waktu']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][tekanan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['tekanan_darah']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][nadi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['nadi']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][temperatur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['temperatur']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][tinggi_fundus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['tinggi_fundus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][konstraksi_utarus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['konstraksi_utarus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][kandung_kamuh]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['kandung_kamuh']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_4][pendarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_4']['pendarahan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][jam_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['jam_ke']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][waktu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['waktu']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][tekanan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['tekanan_darah']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][nadi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['nadi']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][temperatur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['temperatur']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][tinggi_fundus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['tinggi_fundus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][konstraksi_utarus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['konstraksi_utarus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][kandung_kamuh]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['kandung_kamuh']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_5][pendarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_5']['pendarahan']}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][jam_ke]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['jam_ke']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][waktu]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['waktu']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][tekanan_darah]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['tekanan_darah']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][nadi]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['nadi']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][temperatur]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['temperatur']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][tinggi_fundus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['tinggi_fundus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][konstraksi_utarus]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['konstraksi_utarus']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][kandung_kamuh]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['kandung_kamuh']}}">
                                </td>
                                <td>
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][param_6][pendarahan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['param_6']['pendarahan']}}">
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold">Masalah Kala IV:</td>
                                <td colspan="9">
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][masalah_kala_iv]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['masalah_kala_iv']}}">
                                </td>
                           </tr>
                            <tr>
                                <td style="font-weight: bold">Penatalaksanaan yang dilakukan untuk masalah tersebut:</td>
                                <td colspan="9">
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][penatalaksanaan]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['penatalaksanaan']}}">
                                </td>
                           </tr>
                            <tr>
                                <td style="font-weight: bold">Bagaimana hasilnya:</td>
                                <td colspan="9">
                                    <input type="text" name="fisik[pemantauan_persalinan_kala_iv][hasilnya]" style="display:inline-block;" class="form-control" id="" value="{{@$assesment['pemantauan_persalinan_kala_iv']['hasilnya']}}">
                                </td>
                           </tr>
                        </table>
                    </div>
                </div>

                @if (empty(@$assesment))
                    <button class="btn btn-success pull-right">Simpan</button>
                @else
                    <button class="btn btn-danger pull-right">Perbarui</button>
                    <a href="{{url('emr-soap/pemeriksaan/cetak_catatan_persalinan' . '/' . $reg->id)}}" class="btn btn-warning pull-right" style="margin-right: 1rem;">Cetak</a>
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
