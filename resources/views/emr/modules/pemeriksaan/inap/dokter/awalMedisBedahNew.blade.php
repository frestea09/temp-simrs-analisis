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
    <h1>Asesmen</h1>
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
            <form method="POST"
                action="{{ url('emr-soap/pemeriksaan/asesmen_awal_medis_pasien_bedah/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    @include('emr.modules.addons.tabs')
                    <div class="col-md-12">

                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                        <h4 style="text-align: center; padding: 10px"><b>Asesmen Awal Medis Bedah</b></h4>
                        <br>

                        <div class="col-md-6">
                            <table style="width: 100%"
                                class="table table-striped table-bordered table-hover table-condensed form-box"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width: 50%; font-weight: bold;">Riwayat Kesehatan</td>
                                    <td style="padding: 5px;">
                                        <textarea rows="3" name="fisik[riwayatKesehatan]" style="display:inline-block; resize: vertical;"
                                            placeholder="[Masukkan Riwayat Kesehatan]" class="form-control">{{ @$assesment['riwayatKesehatan'] }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; font-weight: bold;">Pemeriksaan Fisik</td>
                                    <td style="padding: 5px;">
                                        <textarea rows="3" name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;"
                                            placeholder="[Masukkan Pemeriksaan Fisik]" class="form-control">{{ @$assesment['pemeriksaan_fisik'] }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; font-weight: bold;" colspan="2">Pemeriksaan Diagnostik</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; font-weight: 500;">Laboratorium</td>
                                    <td>
                                      <textarea rows="3" name="fisik[pemeriksaan_diagnostik][laboratorium]" style="display:inline-block; resize: vertical;"
                                              placeholder="[Laboratorium]" class="form-control">{{ @$assesment['pemeriksaan_diagnostik']['laboratorium'] }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; font-weight: 500;">Rontgen</td>
                                    <td>
                                      <textarea rows="3" name="fisik[pemeriksaan_diagnostik][rontgen]" style="display:inline-block; resize: vertical;"
                                              placeholder="[Rontgen]" class="form-control">{{ @$assesment['pemeriksaan_diagnostik']['rontgen'] }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][ct_scan][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['ct_scan']['pilihan'] == 'CT Scan' ? 'checked' : '' }}
                                          value="CT Scan">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">CT Scan</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][mrcp][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['mrcp']['pilihan'] == 'MRCP' ? 'checked' : '' }}
                                          value="MRCP">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">MRCP</label><br />
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][MRI][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['MRI']['pilihan'] == 'MRI' ? 'checked' : '' }}
                                          value="MRI">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">MRI</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][MRA][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['MRA']['pilihan'] == 'MRA' ? 'checked' : '' }}
                                          value="MRA">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">MRA</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][USG][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['USG']['pilihan'] == 'USG' ? 'checked' : '' }}
                                          value="USG">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">USG</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][EKG][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['EKG']['pilihan'] == 'EKG' ? 'checked' : '' }}
                                          value="EKG">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">EKG</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][CTG][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['CTG']['pilihan'] == 'CTG' ? 'checked' : '' }}
                                          value="CTG">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Echocardiography</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][Echocardiography][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['Echocardiography']['pilihan'] == 'Echocardiography' ? 'checked' : '' }}
                                          value="Echocardiography">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Echocardiography</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][Treadmill][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['Treadmill']['pilihan'] == 'Treadmill' ? 'checked' : '' }}
                                          value="Treadmill">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Treadmill</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][Gastroscopy][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['Gastroscopy']['pilihan'] == 'Gastroscopy' ? 'checked' : '' }}
                                          value="Gastroscopy">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Gastroscopy</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][Colonoscopy][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['Colonoscopy']['pilihan'] == 'Colonoscopy' ? 'checked' : '' }}
                                          value="Colonoscopy">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Colonoscopy</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][EMG][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['EMG']['pilihan'] == 'EMG' ? 'checked' : '' }}
                                          value="EMG">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">EMG</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][OAE][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['OAE']['pilihan'] == 'OAE' ? 'checked' : '' }}
                                          value="OAE">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">OAE</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][EEG][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['EEG']['pilihan'] == 'EEG' ? 'checked' : '' }}
                                          value="EEG">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">EEG</label>
                                      <input type="checkbox" id="" name="fisik[pemeriksaan_diagnostik][lain_lain][pilihan]"
                                          {{ @$assesment['pemeriksaan_diagnostik']['lain_lain']['pilihan'] == 'Lain-lain' ? 'checked' : '' }}
                                          value="Lain-lain">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Lain-lain</label>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;">Indikasi Pasien Di Rawat inap</td>
                                  <td style="padding: 5px;">
                                      <textarea rows="3" name="fisik[indikasi_pasien_rawat_inap]" style="display:inline-block; resize: vertical;"
                                          placeholder="[Masukkan Indikasi Pasien Di Rawat inap]" class="form-control">{{ @$assesment['indikasi_pasien_rawat_inap'] }}</textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;">Diagnosis Primer</td>
                                  <td style="padding: 5px;">
                                      <textarea rows="3" name="fisik[diagnosis_primer]" style="display:inline-block; resize: vertical;"
                                          placeholder="[Masukkan Diagnosis Primer]" class="form-control">{{ @$assesment['diagnosis_primer'] }}</textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;">Diagnosis Sekunder</td>
                                  <td style="padding: 5px;">
                                      <textarea rows="3" name="fisik[diagnosis_sekunder]" style="display:inline-block; resize: vertical;"
                                          placeholder="[Masukkan Diagnosis Sekunder]" class="form-control">{{ @$assesment['diagnosis_sekunder'] }}</textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;">Prosedur Terapi dan Tindakan yang telah dikerjakan</td>
                                  <td style="padding: 5px;">
                                      <textarea rows="3" name="fisik[prosedur_terapi]" style="display:inline-block; resize: vertical;"
                                          placeholder="[Masukkan Prosedur Terapi]" class="form-control">{{ @$assesment['prosedur_terapi'] }}</textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;">Komorbiditas Pasien</td>
                                  <td style="padding: 5px;">
                                      <textarea rows="3" name="fisik[komorbiditas_pasien]" style="display:inline-block; resize: vertical;"
                                          placeholder="[Masukkan Komorbiditas Pasien]" class="form-control">{{ @$assesment['komorbiditas_pasien'] }}</textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;">Obat Yang Telah Diberikan saat di rawat</td>
                                  <td style="padding: 5px;">
                                      <textarea rows="3" name="fisik[obat_yang_diberikan_saat_dirawat]" style="display:inline-block; resize: vertical;"
                                          placeholder="[Masukkan Obat Yang Telah Diberikan]" class="form-control">{{ @$assesment['obat_yang_diberikan_saat_dirawat'] }}</textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;">Obat Yang Telah Diberikan setelah pasien keluar</td>
                                  <td style="padding: 5px;">
                                      <textarea rows="3" name="fisik[obat_yang_diberikan_setelah_pasien_keluar]" style="display:inline-block; resize: vertical;"
                                          placeholder="[Masukkan Obat Yang Telah Diberikan]" class="form-control">{{ @$assesment['obat_yang_diberikan_setelah_pasien_keluar'] }}</textarea>
                                  </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table style="width: 100%"
                                class="table table-striped table-bordered table-hover table-condensed form-box"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width: 50%; font-weight: bold;" colspan="2">Kondisi pasien</td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px;" colspan="2">
                                       <div>
                                          <input type="radio" id="" name="fisik[kondisi_pasien][pilihan]"
                                              {{ @$assesment['kondisi_pasien']['pilihan'] == 'Pulang atas indikasi medis' ? 'checked' : '' }}
                                              value="Pulang atas indikasi medis">
                                          <label for="" style="font-weight: normal; margin-right: 10px;">Pulang atas indikasi medis</label>
                                       </div>
                                       <div>
                                          <input type="radio" id="" name="fisik[kondisi_pasien][pilihan]"
                                              {{ @$assesment['kondisi_pasien']['pilihan'] == 'Pulang atas permintaan sendiri' ? 'checked' : '' }}
                                              value="Pulang atas permintaan sendiri">
                                          <label for="" style="font-weight: normal; margin-right: 10px;">Pulang atas permintaan sendiri</label>
                                       </div>
                                       <div>
                                          <input type="radio" id="" name="fisik[kondisi_pasien][pilihan]"
                                              {{ @$assesment['kondisi_pasien']['pilihan'] == 'Pulang kondisi khusus' ? 'checked' : '' }}
                                              value="Pulang kondisi khusus">
                                          <label for="" style="font-weight: normal; margin-right: 10px;">Pulang kondisi khusus</label>
                                       </div>
                                       <div>
                                          <input type="radio" id="" name="fisik[kondisi_pasien][pilihan]"
                                              {{ @$assesment['kondisi_pasien']['pilihan'] == 'Pindah/Rujuk RS lain' ? 'checked' : '' }}
                                              value="Pindah/Rujuk RS lain">
                                          <label for="" style="font-weight: normal; margin-right: 10px;">Pindah/Rujuk RS lain</label>
                                       </div>
                                       <div>
                                          <input type="radio" id="" name="fisik[kondisi_pasien][pilihan]"
                                              {{ @$assesment['kondisi_pasien']['pilihan'] == 'Meninggal' ? 'checked' : '' }}
                                              value="Meninggal">
                                          <label for="" style="font-weight: normal; margin-right: 10px;">Meninggal</label>
                                       </div>
                                       <div>
                                          <input type="radio" id="" name="fisik[kondisi_pasien][pilihan]"
                                              {{ @$assesment['kondisi_pasien']['pilihan'] == 'Lain-lain' ? 'checked' : '' }}
                                              value="Lain-lain">
                                          <label for="" style="font-weight: normal; margin-right: 10px;">Lain-lain</label>
                                       </div>
                                       <div>
                                          <input type="radio" id="" name="fisik[kondisi_pasien][pilihan]"
                                              {{ @$assesment['kondisi_pasien']['pilihan'] == 'Pulang tanpa izin' ? 'checked' : '' }}
                                              value="Pulang tanpa izin">
                                          <label for="" style="font-weight: normal; margin-right: 10px;">Pulang tanpa izin</label>
                                       </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; font-weight: bold;" colspan="2">Keadaan saat pulang</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">KU</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[kondisi_pasien][keadaan_saat_pulang][ku]"
                                            class="form-control"
                                            value="{{ @$assesment['kondisi_pasien']['keadaan_saat_pulang']['ku'] }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">Kesadaran</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[kondisi_pasien][keadaan_saat_pulang][kesadaran]"
                                            class="form-control"
                                            value="{{ @$assesment['kondisi_pasien']['keadaan_saat_pulang']['kesadaran'] }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">TD</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[kondisi_pasien][keadaan_saat_pulang][td]"
                                            class="form-control"
                                            value="{{ @$assesment['kondisi_pasien']['keadaan_saat_pulang']['td'] ?? @$assesmen_perawat['keadaan_umum']['tanda_vital']['tekanan_darah'] }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">Nadi</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[kondisi_pasien][keadaan_saat_pulang][nadi]"
                                            class="form-control"
                                            value="{{ @$assesment['kondisi_pasien']['keadaan_saat_pulang']['nadi'] ?? @$assesmen_perawat['keadaan_umum']['tanda_vital']['nadi'] }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">Suhu</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[kondisi_pasien][keadaan_saat_pulang][suhu]"
                                            class="form-control"
                                            value="{{ @$assesment['kondisi_pasien']['keadaan_saat_pulang']['suhu'] ?? @$assesmen_perawat['keadaan_umum']['tanda_vital']['temp'] }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">Pernapasan</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[kondisi_pasien][keadaan_saat_pulang][pernapasan]"
                                            class="form-control"
                                            value="{{ @$assesment['kondisi_pasien']['keadaan_saat_pulang']['pernapasan'] ?? @$assesmen_perawat['keadaan_umum']['tanda_vital']['RR'] }}">
                                    </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">Mobilisasi saat pulang</td>
                                </tr>
                                <tr>
                                  <td style="width: 50%;" colspan="2">
                                    <div>
                                      <input type="radio" id="" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                                          {{ @$assesment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Mandiri' ? 'checked' : '' }}
                                          value="Mandiri">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Mandiri</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                                          {{ @$assesment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Dibantu sebagian' ? 'checked' : '' }}
                                          value="Dibantu sebagian">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Dibantu sebagian</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                                          {{ @$assesment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Dibantu penuh' ? 'checked' : '' }}
                                          value="Dibantu penuh">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Dibantu penuh</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                                          {{ @$assesment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Alat bantu' ? 'checked' : '' }}
                                          value="Alat bantu">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Alat bantu</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                                          {{ @$assesment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Tongkat' ? 'checked' : '' }}
                                          value="Tongkat">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Tongkat</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                                          {{ @$assesment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Kursi Roda' ? 'checked' : '' }}
                                          value="Kursi Roda">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Kursi Roda</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                                          {{ @$assesment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Branchard' ? 'checked' : '' }}
                                          value="Branchard">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Branchard</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[kondisi_pasien][mobilisasi_pulang][pilihan]"
                                          {{ @$assesment['kondisi_pasien']['mobilisasi_pulang']['pilihan'] == 'Walker' ? 'checked' : '' }}
                                          value="Walker">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Walker</label>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">Alat Kesehatan yang terpasang </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">
                                    <div>
                                      <input type="checkbox" id="" name="fisik[kondisi_pasien][alkes][tidak_ada]"
                                          {{ @$assesment['kondisi_pasien']['alkes']['tidak_ada'] == 'Tidak ada' ? 'checked' : '' }}
                                          value="Tidak ada">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Tidak ada</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[kondisi_pasien][alkes][iv_catheter]"
                                          {{ @$assesment['kondisi_pasien']['alkes']['iv_catheter'] == 'IV catheter' ? 'checked' : '' }}
                                          value="IV catheter">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">IV catheter</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[kondisi_pasien][alkes][dobel_lumen]"
                                          {{ @$assesment['kondisi_pasien']['alkes']['dobel_lumen'] == 'Dobel lumen' ? 'checked' : '' }}
                                          value="Dobel lumen">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Dobel lumen</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[kondisi_pasien][alkes][ngt]"
                                          {{ @$assesment['kondisi_pasien']['alkes']['ngt'] == 'NGT' ? 'checked' : '' }}
                                          value="NGT">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">NGT</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[kondisi_pasien][alkes][oksigen]"
                                          {{ @$assesment['kondisi_pasien']['alkes']['oksigen'] == 'Oksigen' ? 'checked' : '' }}
                                          value="Oksigen">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Oksigen</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[kondisi_pasien][alkes][catheter_urine]"
                                          {{ @$assesment['kondisi_pasien']['alkes']['catheter_urine'] == 'Catheter urine' ? 'checked' : '' }}
                                          value="Catheter urine">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Catheter urine</label>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">Instruksi/Tindak Lanjut</td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">Perawatan dirumah</td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">
                                    <div>
                                      <input type="radio" id="" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Tidak ada' ? 'checked' : '' }}
                                          value="Tidak ada">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Tidak ada</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Home Visite' ? 'checked' : '' }}
                                          value="Home Visite">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Home Visite</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Perawatan lanjutan' ? 'checked' : '' }}
                                          value="Perawatan lanjutan">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Perawatan lanjutan</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Perawatan luka' ? 'checked' : '' }}
                                          value="Perawatan luka">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Perawatan luka</label>
                                    </div>
                                    <div>
                                      <input type="radio" id="" name="fisik[instruksi_tindak_lanjut][perawatan_dirumah][pilihan]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['perawatan_dirumah']['pilihan'] == 'Pengobatan lanjutan' ? 'checked' : '' }}
                                          value="Pengobatan lanjutan">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Pengobatan lanjutan</label>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">Rencana pemeriksaan penunjang</td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][pemeriksaan_penunjang][laboratorim]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['pemeriksaan_penunjang']['laboratorim'] == 'Laboratorium' ? 'checked' : '' }}
                                          value="Laboratorium">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Laboratorium</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][pemeriksaan_penunjang][radiologi]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['pemeriksaan_penunjang']['radiologi'] == 'Radiologi' ? 'checked' : '' }}
                                          value="Radiologi">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Radiologi</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][pemeriksaan_penunjang][lain_lain]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['pemeriksaan_penunjang']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                                          value="Lain-lain">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Lain-lain</label>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">Kebutuhan Edukasi</td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][penyakit]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['penyakit'] == 'Penyakit' ? 'checked' : '' }}
                                          value="Penyakit">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Penyakit</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][obat]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['obat'] == 'Obat dan efek samping' ? 'checked' : '' }}
                                          value="Obat dan efek samping">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Obat dan efek samping</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][diet]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['diet'] == 'Diet' ? 'checked' : '' }}
                                          value="Diet">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Diet</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][aktifitas]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['aktifitas'] == 'Aktifitas dan istirahat dirumah' ? 'checked' : '' }}
                                          value="Aktifitas dan istirahat dirumah">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Aktifitas dan istirahat dirumah</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][hygiene]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['hygiene'] == 'Hygiene' ? 'checked' : '' }}
                                          value="Hygiene">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Hygiene</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][perawatan_dirumah]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['perawatan_dirumah'] == 'Perawatan luka dirumah' ? 'checked' : '' }}
                                          value="Perawatan luka dirumah">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Perawatan luka dirumah</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][perawatan_ibu_dan_bayi]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['perawatan_ibu_dan_bayi'] == 'Perawatan ibu dan bayi' ? 'checked' : '' }}
                                          value="Perawatan ibu dan bayi">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Perawatan ibu dan bayi</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][nyeri]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['nyeri'] == 'Nyeri' ? 'checked' : '' }}
                                          value="Nyeri">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Nyeri</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][pertolongan_mendesak]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['pertolongan_mendesak'] == 'Pertolongan mendesak' ? 'checked' : '' }}
                                          value="Pertolongan mendesak">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Pertolongan mendesak</label>
                                    </div>
                                    <div>
                                      <input type="checkbox" id="" name="fisik[instruksi_tindak_lanjut][kebutuhan_edukasi][lain_lain]"
                                          {{ @$assesment['instruksi_tindak_lanjut']['kebutuhan_edukasi']['lain_lain'] == 'Lain-lain' ? 'checked' : '' }}
                                          value="Lain-lain">
                                      <label for="" style="font-weight: normal; margin-right: 10px;">Lain-lain</label>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="width: 50%; font-weight: bold;" colspan="2">Penyakit Berhubungan Dengan</td>
                              </tr>
                              <tr>
                                  <td style="padding: 5px;" colspan="2">
                                     <div>
                                        <input type="radio" id="" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                                            {{ @$assesment['penyakit_berhubungan_dengan']['pilihan'] == 'Kelainan Bawaan / Kongenital' ? 'checked' : '' }}
                                            value="Kelainan Bawaan / Kongenital">
                                        <label for="" style="font-weight: normal; margin-right: 10px;">Kelainan Bawaan / Kongenital</label>
                                     </div>
                                     <div>
                                        <input type="radio" id="" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                                            {{ @$assesment['penyakit_berhubungan_dengan']['pilihan'] == 'Kesuburan' ? 'checked' : '' }}
                                            value="Kesuburan">
                                        <label for="" style="font-weight: normal; margin-right: 10px;">Kesuburan</label>
                                     </div>
                                     <div>
                                        <input type="radio" id="" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                                            {{ @$assesment['penyakit_berhubungan_dengan']['pilihan'] == 'Gangguan hormonal' ? 'checked' : '' }}
                                            value="Gangguan hormonal">
                                        <label for="" style="font-weight: normal; margin-right: 10px;">Gangguan hormonal</label>
                                     </div>
                                     <div>
                                        <input type="radio" id="" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                                            {{ @$assesment['penyakit_berhubungan_dengan']['pilihan'] == 'Gangguan Mental' ? 'checked' : '' }}
                                            value="Gangguan Mental">
                                        <label for="" style="font-weight: normal; margin-right: 10px;">Gangguan Mental</label>
                                     </div>
                                     <div>
                                        <input type="radio" id="" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                                            {{ @$assesment['penyakit_berhubungan_dengan']['pilihan'] == 'Kecelakaan' ? 'checked' : '' }}
                                            value="Kecelakaan">
                                        <label for="" style="font-weight: normal; margin-right: 10px;">Kecelakaan</label>
                                     </div>
                                     <div>
                                        <input type="radio" id="" name="fisik[penyakit_berhubungan_dengan][pilihan]"
                                            {{ @$assesment['penyakit_berhubungan_dengan']['pilihan'] == 'Kosmetik' ? 'checked' : '' }}
                                            value="Kosmetik">
                                        <label for="" style="font-weight: normal; margin-right: 10px;">Kosmetik</label>
                                     </div>
                                  </td>
                              </tr>
                            </table>
                            <button class="btn btn-success pull-right">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-12">
                <table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                            <th class="text-center" style="vertical-align: middle;">Tanggal Dibuat</th>
                            <th class="text-center" style="vertical-align: middle;">Poli / Ruangan</th>
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
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{ Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i') }}
                                </td>
                                <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                                    {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y')}}
                                </td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    @if ($riwayat->registrasi->rawat_inap)
                                        {{baca_kamar($riwayat->registrasi->rawat_inap->kamar_id)}}
                                    @else
                                        {{ baca_poli($riwayat->registrasi->poli_id) }}
                                    @endif
                                </td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <a href="{{ url("emr-soap/pemeriksaan/asesmen_awal_medis_pasien_bedah/".$unit."/".@$riwayat->registrasi_id."?asessment_id=".@$riwayat->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ url("cetak-eresume-medis/pdf/".@$riwayat->registrasi_id."/".@$riwayat->id) . "?source=asesmen" }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    <a href="{{ url('emr-soap-hapus-pemeriksaan/' . $unit . '/' . @$riwayat->registrasi_id . '/' . @$riwayat->id) }}"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"
                                    style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <br /><br />
            @if ($unit == "inap")
              <div class="col-md-12">
                @php
                  $biaya_diagnosa_awal = @\App\PaguPerawatan::find($rawatinap->pagu_diagnosa_awal)->biaya ?? 0;
                @endphp
                <div class="box box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title pull-left">
                          Total Tagihan Sementara Rp. {{ number_format($tagihan) }}
                      </h3>
                      <h3 class="box-title pull-right">Deposit : Rp.
                          {{ number_format(App\Deposit::where('registrasi_id', $reg->id)->sum('nominal')) }}</h3>
                  </div>
                  <div class="box-header with-border">
                      <h3 class="box-title pull-left">
                          Biaya Diagnosa Awal {{"Rp. " . number_format($biaya_diagnosa_awal)}}
                      </h3>
                  </div>
                  @if ($biaya_diagnosa_awal > 0)
                      <div class="box-header with-border">
                              @php
                                  $sisa_biaya  = $biaya_diagnosa_awal - $tagihan;
                                  $sisa_persen = sprintf("%.2f", ($sisa_biaya / $biaya_diagnosa_awal) * 100);
                              @endphp
                              @if ($sisa_persen <= 0)
                                  <h5 class="pull-left blink_me">
                                      Melebihi Biaya Diagnosa Awal {{"Rp. " . number_format($tagihan - $biaya_diagnosa_awal)}}
                                  </h5>
                              @else
                                  <h5 class="pull-left {{$sisa_persen <= 20 ? 'blink_me' : ''}}">
                                      Biaya Diagnosa Awal Tersisa {{"Rp. " . number_format($biaya_diagnosa_awal - $tagihan)}} ({{$sisa_persen . '%'}})
                                  </h5>
                              @endif
                      </div>
                  @endif
                  <div class="box-body">
                      <div class="box box-info">
                          <div class="box-body">
                              {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/entry-tindakan/save', 'class' => 'form-horizontal']) !!}
                              {!! Form::hidden('registrasi_id', $reg->id) !!}
                              {!! Form::hidden('jenis', $reg->bayar) !!}
                              {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                              {!! Form::hidden('dokter_id', @$rawatinap->dokter_id ? @$rawatinap->dokter_id : $reg->dokter_id) !!}
                              <div class="row">
                                  <div class="col-md-7">
              
                                      <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                                          {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-2 control-label']) !!}
                                          <div class="col-sm-10">
                                              {{-- {!! Form::select('pelaksana', $dokter, session('pelaksana') ? session('pelaksana') : null, ['class' => 'select2', 'style'=>'width:100%']) !!} --}}
                                              <select name="pelaksana" class="select2 form-control" style="width: 100%">
                                                  <option value="" selected>Pilih Pelaksana</option>
                                                  @foreach ($dokter as $d)
                                                      <option value="{{ $d->id }}"
                                                          {{ @$rawatinap->dokter_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                              <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                                          </div>
                                      </div>
              
                                      <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                                          {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-2 control-label']) !!}
                                          <div class="col-sm-10">
                                              <select name="tarif_id[]" id="select2Multiple" class="form-control" required
                                                  multiple></select>
                                              <small class="text-info">Pilihan Tarif mengikuti kolom pilihan <b>Kelas</b>, tanpa harus
                                                  mutasi</small>
                                              <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                                          </div>
                                      </div>
              
                                      <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                          {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-2 control-label']) !!}
                                          <div class="col-sm-4">
                                              {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                                              <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                          </div>
                                          {!! Form::label('bayar', 'Bayar', ['class' => 'col-sm-2 control-label']) !!}
                                          <div class="col-sm-4">
                                              <select name="cara_bayar_id" class="chosen-select">
                                                  @foreach ($carabayar as $key => $item)
                                                      @if ($key == $reg->bayar)
                                                          <option value="{{ $key }}" selected>{{ $item }}</option>
                                                      @else
                                                          <option value="{{ $key }}">{{ $item }}</option>
                                                      @endif
                                                  @endforeach
                                              </select>
                                              <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                          </div>
                                      </div>
                                      <div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
                                          {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-2 control-label']) !!}
                                          <div class="col-sm-4">
                                              <select name="kelas_id" class="select2 form-control">
                                                  <option value="">-- Pilih --</option>
                                                  @foreach ($kelas as $key => $item)
                                                      <option value="{{ $key }}"
                                                          {{ $key == @$rawatinap->kelas->id ? 'selected' : '' }}>{{ $item }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                              <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
                                          </div>
                                      </div>
                                      <div class="form-group{{ $errors->has('waktu_visit_dokter') ? ' has-error' : '' }}">
                                          {!! Form::label('waktu_visit_dokter', 'Waktu Visit Dokter', ['class' => 'col-sm-2 control-label']) !!}
                                          <div class="col-sm-4">
                                              <input type="time" class="form-control" name="waktu_visit_dokter">
                                              <small class="text-danger">{{ $errors->first('waktu_visit_dokter') }}</small>
                                          </div>
                                      </div>
                                      <div class="form-group{{ $errors->has('cyto') ? ' has-error' : '' }}">
                                          {!! Form::label('cyto', 'Cito', ['class' => 'col-sm-2 control-label']) !!}
                                          <div class="col-sm-4">
                                              <select name="cyto" id="" class="form-control">
                                                  <option value="" selected>Tidak</option>
                                                  <option value="1">Ya</option>
                                              </select>
                                              <small class="text-danger">{{ $errors->first('cyto') }}</small>
                                          </div>
                                      </div>
                                      <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                                          {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-2 control-label']) !!}
                                          <div class="col-sm-4">
                                              {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                                              <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                                          </div>
                                          <input type="hidden" name="dijamin" value="0">
                                          <div class="col-sm-4">
                                              <div class="btn-group pull-left">
                                                  {!! Form::submit('Simpan', [
                                                      'class' => 'btn btn-success btn-flat',
                                                      'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                                  ]) !!}
                                              </div>
                                          </div>
                                      </div>
                                      {!! Form::close() !!}
              
                                  </div>
              
                                  <div class="col-md-5">
                                      <div class='table-responsive' style="overflow: hidden;">
                                          <table class='table-striped table-bordered table-hover table-condensed table'>
                                              <tbody>
                                                  <tr>
                                                      <th>Nama Pasien</th>
                                                      <td>{{ $reg->pasien->nama }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th>No. RM</th>
                                                      <td>{{ $reg->pasien->no_rm }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th>Alamat</th>
                                                      <td>{{ $reg->pasien->alamat }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th>Cara Bayar</th>
                                                      <td>{{ baca_carabayar($reg->bayar) }}
                                                          @if ($reg->bayar == '1')
                                                              @if (!empty($reg->tipe_jkn))
                                                                  - {{ $reg->tipe_jkn }}
                                                              @endif
                                                          @endif
                                                      </td>
                                                  </tr>
                                                  @if ($reg->bayar == '1')
                                                      <tr>
                                                          <th>No. SEP</th>
                                                          <td>{{ $reg->no_sep ? $reg->no_sep : @\App\HistoriSep::where('registrasi_id', $reg->id)->first()->no_sep }}
                                                          </td>
                                                      </tr>
                                                      {{-- <tr>
                                                          <th>Hak Kelas JKN </th>
                                                          <td>{{ $reg->hak_kelas_inap }}</td>
                                                      </tr> --}}
                                                  @endif
                                                  <tr>
                                                      {{-- <th>Kelas Perawatan </th> <td>{{ baca_kelas($reg->kelas_id) }}</td> --}}
                                                      <th>Kelas Perawatan </th>
                                                      <td>{{ baca_kelas(@$rawatinap->kelas_id) }}</td>
                                                      @php
                                                          session(['kelas_id' => @$reg->kelas_id]);
                                                      @endphp
                                                  </tr>
                                                  {{-- <tr>
                                                      <th>DPJP IGD</th>
                                                      <td>{{ baca_dokter($reg->dokter_id) }}</td>
                                                  </tr> --}}
                                                  <tr>
                                                      <th>DPJP UTAMA</th>
                                                      <td> <b> {{ baca_dokter(@$rawatinap->dokter_id) }} </b></td>
                                                  </tr>
                                                  <tr>
                                                      <th>Tanggal Masuk</th>
                                                      <td> {{ tanggal_eklaim(@$rawatinap->tgl_masuk) }} </td>
                                                  </tr>
                                                  <tr>
                                                      <th>Kamar </th>
                                                      <td>{{ baca_kamar(@$rawatinap->kamar_id) }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th>ICD 9</th>
                                                      <td>
                                                        @if (!empty($icd9))
                                                            {{ implode(',', $icd9) }}
                                                        @endif
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <th>ICD 10</th>
                                                      <td> 
                                                          @if (!empty($icd10))
                                                              {{ implode(',', $icd10) }}
                                                          @endif
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <th>Diagnosa Awal</th>
                                                      <th>
                                                          <div class="form-group">
                                                              <div style="margin-left: 18px; width: 90%">
                                                                  {{-- <input type="number" class="form-control" name="biaya_diagnosa_awal" value="{{$rawatinap->total_biaya_diagnosa_awal}}"> --}}
                                                                  <select name="biaya_diagnosa_awal" class="form-control select2" id="" style="width: 100%;">
                                                                      <option value="">-- Pilih --</option>
                                                                      @foreach ($pagu as $p)
                                                                          <option value="{{ $p->id }}" {{$p->id == @$rawatinap->pagu_diagnosa_awal ? 'selected' : ''}}>{{ $p->diagnosa_awal .' - '.$p->biaya }}</option>
                                                                      @endforeach
                                                                  </select>
                                                              </div>
                                                          </div>
                                                      </th>
                                                      <th>
                                                          <button class="btn btn-success" type="button" id="update_diagnosa_awal"><i class="fa fa-save"></i></button>
                                                      </th>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
              
              
                          </div>
                      </div>
                      {{-- ======================================================================================================================= --}}
                      <div class="dataTindakanIrna">
                          {{-- progress bar --}}
                          <div class="progress progress-sm active">
                              <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar"
                                  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                  <span class="sr-only">97% Complete</span>
                              </div>
                          </div>
                      </div>
              
                      <div class="pull-right">
                          <a href="{{ url('rawat-inap/billing') }}" class="btn btn-primary btn-sm btn-flat"><i
                                  class="fa fa-step-backward"></i> SELESAI</a>
                      </div>
              
                  </div>
                </div>
                
                <div class="modal fade" id="editTindakanModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['method' => 'POST', 'class' => 'form-horizontal', 'id' => 'editTindakanForm']) !!}
                                <input type="hidden" name="folio_id" value="">
                                <input type="hidden" name="registrasi_id" value="">
                                <input type="hidden" name="id_tarif" value="">
                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('dpjp') ? ' has-error' : '' }}">
                                            {!! Form::label('dpjp', 'DPJP IRNA', ['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                <select name="dpjp" class="select2form-control" style="width: 100%">
                                                    @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger">{{ $errors->first('dpjp') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
                                            {!! Form::label('pelaksana', 'Pelaksana', ['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                <select name="pelaksana" class="form-control" style="width: 100%">
                                                    @foreach ($dokter as $d)
                                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger">{{ $errors->first('pelaksana') }}</small>
                                            </div>
                                        </div>
                
                                        <div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
                                            {!! Form::label('perawat', 'Kepala Unit', ['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                <select name="perawat" class="form-control select2" style="width: 100%">
                                                    @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $d)
                                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger">{{ $errors->first('perawat') }}</small>
                                            </div>
                                        </div>
                
                                        <div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
                                            {!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                <select class="form-control select2" name="tarif_id" style="width: 100%">
                                                    @foreach (Modules\Tarif\Entities\Tarif::whereIn('jenis', ['TI'])->get() as $d)
                                                        <option value="{{ $d->id }}">{{ $d->kode }} |
                                                            {{ $d->nama }} | {{ number_format($d->total) }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                                            </div>
                                        </div>
                
                                        <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                            {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::number('jumlah', 1, ['class' => 'form-control']) !!}
                                                <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                            </div>
                                        </div>
                
                                        <div class="form-group{{ $errors->has('cara_bayar_id') ? ' has-error' : '' }}">
                                            {!! Form::label('cara_bayar_id', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                <select name="cara_bayar_id" class="select2 form-control" style="width: 100%">
                                                    @foreach ($carabayar as $key => $item)
                                                        @if ($key == $reg->bayar)
                                                            <option value="{{ $key }}" selected>{{ $item }}</option>
                                                        @else
                                                            <option value="{{ $key }}">{{ $item }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <small class="text-danger">{{ $errors->first('cara_bayar_id') }}</small>
                                            </div>
                                        </div>
                
                                        <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                                            {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                                                <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('dijamin') ? ' has-error' : '' }}">
                                            {!! Form::label('dijamin', 'Dijamin', ['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::number('dijamin', 0, ['class' => 'form-control']) !!}
                                                <small class="text-danger">{{ $errors->first('dijamin') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary btn-flat"
                                        onclick="saveEditTindakan()">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            @endif
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
        status_reg = "<?= substr($reg->status_reg, 0, 1) ?>"

        $(".skin-red").addClass("sidebar-collapse");
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href") // activated tab
            // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);
    </script>

@if ($unit == "inap")
    <script type="text/javascript">
    $(".skin-blue").addClass("sidebar-collapse");
    $(function() {
        //LOAD TINDAKAN IRNA
        var registrasi_id = $('input[name="registrasi_id"]').val()
        var loadData = $('.dataTindakanIrna').load('/rawat-inap/data-tindakan/' + registrasi_id);
        if (loadData == true) {
            $('.progress').addClass('hidden')
        }
    });
    // status_reg = "<?= substr($reg->status_reg, 0, 1) ?>"
    status_reg = "I"
    var settings = {
        kelas_id: "<?= @$rawatinap->kelas_id ? $rawatinap->kelas_id : 8 ?>"
    };
    // $('select[name="kelas_id"]').change(function(){
    //   settings.kelas_id = $('select[name="kelas_id"]').val()
    // });
    // function getURL() {
    //     $('select[name="kelas_id"]').change(function(){
    //       settings.kelas_id = $('select[name="kelas_id"]').val()
    //     });
    //     let kelas_id = $('select[name="kelas_id"]').val()
    //     return '/tindakan/ajax-tindakan/'+status_reg+'/'+kelas_id;
    // }


    // console.log(settings.kelas_id)
    $('.select2').select2();

    let kelas_id = $('select[name="kelas_id"]').val()

    $('#select2Multiple').select2({
        placeholder: "Klik untuk isi nama tindakan",
        width: '100%',
        ajax: {
            url: '/tindakan/ajax-tindakan/' + status_reg + '/' + kelas_id,
            dataType: 'json',
            data: function(params) {
                return {
                    j: 1,
                    q: $.trim(params.term)
                };
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    })

    function cloneDiagnosis() {
        let templateElement = $('#template-diagnosis');
        let clonedElement = templateElement.clone(); // Clone the template element
        clonedElement.removeAttr('id'); // Remove id attribute to avoid duplicate ids
        clonedElement.show(); // Ensure the cloned element is visible (if it was hidden)

        clonedElement.find('.new-diagnosa').select2();
        clonedElement.find('.new-diagnosa').attr('disabled', false);

        clonedElement.insertBefore(templateElement);
    }





    $('#update_diagnosa_awal').click(function (e) {
        e.preventDefault();
        if (confirm('Apakah anda yakin ingin mengganti Biaya Diagnosa awal?')) {
            var registrasi_id = $('input[name="registrasi_id"]').val()
            let biaya = $('select[name="biaya_diagnosa_awal"]').val()
            $.ajax({
                url: '/rawat-inap/entry-tindakan/update/pagu/' + registrasi_id,
                type: 'POST',
                data: {
                    "biaya_diagnosa_awal": biaya,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(data) {
                    if (data == "ok") {
                        location.reload();
                    }
                }
            });
        }
    })

    // on kelas change
    $('select[name="kelas_id"]').on('change', function() {
        kelas_id = $(this).val();
        console.log(kelas_id);
        $('#select2Multiple').select2({
            placeholder: "Klik untuk isi nama tindakan",
            width: '100%',
            ajax: {
                url: '/tindakan/ajax-tindakan/' + status_reg + '/' + kelas_id,
                dataType: 'json',
                data: function(params) {
                    return {
                        j: 1,
                        q: $.trim(params.term)
                    };
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })
    });

    function editTindakan(folio_id, tarif_id) {
        $('#editTindakanModal').modal('show');
        $('.modal-title').text('Edit Tindakan');
        $('.select2').select2();
        $.ajax({
            url: '/rawat-inap/edit-tindakan/' + folio_id + '/' + tarif_id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (tarif_id != 10000) {
                    $('input[name="folio_id"]').val(data.folio.id);
                    $('input[name="registrasi_id"]').val(data.folio.registrasi_id);
                    $('input[name="id_tarif"]').val(data.folio.tarif_id);

                    $('select[name="dpjp"]').val(data.dokter.dokter_id).trigger('change');
                    $('select[name="pelaksana"]').val(data.folio.dokter_pelaksana).trigger('change');
                    $('select[name="perawat"]').val(data.folio.perawat).trigger('change');
                    $('select[name="cara_bayar_id"]').val(data.folio.cara_bayar_id).trigger('change');
                    $('select[name="tarif_id"]').val(data.folio.tarif_id).trigger('change');
                    $('input[name="dijamin"]').val(data.folio.dijamin);
                } else {
                    $('input[name="folio_id"]').val(data.folio.id);
                    $('input[name="registrasi_id"]').val(data.folio.registrasi_id);
                    $('input[name="id_tarif"]').val(data.folio.tarif_id);
                }
            }
        });
    }

    function saveEditTindakan() {
        var data = $('#editTindakanForm').serialize();
        $.ajax({
            url: '/rawat-inap/save-edit-tindakan',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(data) {
                if (data.sukses == true) {
                    $('#editTindakanModal').modal('hide');
                    location.reload();
                }
            }
        });
    }

    function ribuan(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $('select[name="kategoritarif_id"]').on('change', function() {
        var tarif_id = $(this).val();
        var reg_id = {{ $reg_id }}
        if (tarif_id) {
            $.ajax({
                url: '/rawat-inap/getKategoriTarifID/' + tarif_id + '/' + reg_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    //$('select[name="tarif_id"]').append('<option value=""></option>');
                    $('select[name="tarif_id"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="tarif_id"]').append('<option value="' + value.id +
                            '">' + value.nama + ' | ' + ribuan(value.total) +
                            '</option>');
                    });

                }
            });
        } else {
            $('select[name="tarif_id"]').empty();
        }
    });

    // tindakan inhealth
    $(document).on('click', '.inhealth-tindakan', function() {
        let id = $(this).attr('data-id');
        let body = {
            _token: "{{ csrf_token() }}",
            poli: $('input[name="poli_inhealth"]').val(),
            kodedokter: $('input[name="dokter_pelaksana_inhealth"]').val(),
            nosjp: $('input[name="no_sjp_inhealth"]').val(),
            jenispelayanan: $('input[name="jenis_pelayanan_inhealth"]').val(),
            kodetindakan: $('input[name="kode_tindakan_inhealth"]').val(),
            tglmasukrawat: $('input[name="tglmasukrawat"]').val()
        };
        if (confirm('Yakin akan di Sinkron Inhealth?')) {
            $.ajax({
                url: '/tindakan/inhealth/' + id,
                type: "POST",
                data: body,
                dataType: "json",
                beforeSend: function() {
                    $('button#btn-' + id).prop("disabled", true);
                },
                success: function(res) {
                    $('button#btn-' + id).prop("disabled", false);
                    if (res.status == true) {
                        $('button#btn-' + id).prop("disabled", true);
                        alert(res.msg);
                    } else {
                        alert(res.msg);
                    }
                }
            });
        }
    })
    $('select[name="bayar"]').on('change', function() {
        $.get('/tindakan/updateCaraBayar/' + $(this).attr('id') + '/' + $(this).val(), function() {
            location.reload();
        });
    })
    </script>
@endif
@endsection
