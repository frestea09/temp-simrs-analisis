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
        $route = Route::current()->getName();
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
                @include('emr.modules.addons.tab-operasi')
                <div class="col-md-12">
                    <form method="POST" action="{{ url('emr-soap/pemeriksaan/pre-operatif/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                        <br>
                        <div class="col-md-6">
                            <h5><b>Asuhan Keperawatan Perioperatif Instalasi Bedah Sentral</b></h5>

                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <h5><b>A. Data Perawatan Pre Operatif</b></h5>
                                <tr>
                                    <td style="width:20%;">1. Kesadaran</td>
                                    <td style="padding: 5px;">
                                        <select name="fisik[preOperatif][kesadaran]" class="select2" style="width: 100%">
                                            <option value=""   selected disabled>-- Pilih Opsi --</option>
                                            <option value="Sadar" {{@$asessment['preOperatif']['kesadaran'] == 'Sadar' ? 'selected' : ''}}>Sadar</option>
                                            <option value="Mengantuk" {{@$asessment['preOperatif']['kesadaran'] == 'Mengantuk' ? 'selected' : ''}}>Mengantuk</option>
                                            <option value="Tidur" {{@$asessment['preOperatif']['kesadaran'] == 'Tidur' ? 'selected' : ''}}>Tidur</option>
                                            <option value="Sedasi" {{@$asessment['preOperatif']['kesadaran'] == 'Sedasi' ? 'selected' : ''}}>Sedasi</option>
                                            <option value="Disorientasi" {{@$asessment['preOperatif']['kesadaran'] == 'Disorientasi' ? 'selected' : ''}}>Disorientasi</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">2. Sistem Pernafasan</td>
                                    <td style="padding: 5px;">
                                        <select name="fisik[preOperatif][sistemPernafasan]" class="select2" style="width: 100%">
                                            <option value=""   selected disabled>-- Pilih Opsi --</option>
                                            <option value="Normal" {{@$asessment['preOperatif']['sistemPernafasan'] == 'Normal' ? 'selected' : ''}}>Normal</option>
                                            <option value="Sesak" {{@$asessment['preOperatif']['sistemPernafasan'] == 'Sesak' ? 'selected' : ''}}>Sesak</option>
                                        </select>

                                        <br>
                                        <span>Suara Nafas :</span>
                                        <br>

                                        <select name="fisik[preOperatif][suaraNafas]" class="select2" style="width: 100%">
                                            <option value=""   selected disabled>-- Pilih Opsi --</option>
                                            <option value="Normal" {{@$asessment['preOperatif']['suaraNafas'] == 'Normal' ? 'selected' : ''}}>Normal</option>
                                            <option value="Ronchi" {{@$asessment['preOperatif']['suaraNafas'] == 'Ronchi' ? 'selected' : ''}}>Ronchi</option>
                                            <option value="Mengi" {{@$asessment['preOperatif']['suaraNafas'] == 'Mengi' ? 'selected' : ''}}>Mengi</option>
                                        </select>

                                        <br>
                                        <span>Alat Bantu :</span>
                                        <br>

                                        <select name="fisik[preOperatif][alatBantuNafas]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="Tracheostomi" {{@$asessment['preOperatif']['alatBantuNafas'] == 'Tracheostomi' ? 'selected' : ''}}>Tracheostomi</option>
                                            <option value="Terpasang 02" {{@$asessment['preOperatif']['alatBantuNafas'] == 'Terpasang 02' ? 'selected' : ''}}>Terpasang 02</option>
                                            <option value="Terpasang CTT" {{@$asessment['preOperatif']['alatBantuNafas'] == 'Terpasang CTT' ? 'selected' : ''}}>Terpasang CTT</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">3. Sistem  Kardiopulmona</td>
                                    <td style="padding: 5px;">
                                        <span>Edema Perifer :</span> <br>
                                        <select name="fisik[preOperatif][kardiopulmonal][edemaPerifer][ada]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="Tidak" {{@$asessment['preOperatif']['kardiopulmonal']['edemaPerifer']['ada'] == 'Tidak' ? 'selected' : ''}}>Tidak</option>
                                            <option value="Ya, Lokasi ..." {{@$asessment['preOperatif']['kardiopulmonal']['edemaPerifer']['ada'] == 'Ya, Lokasi ...' ? 'selected' : ''}}>Ya, Lokasi ...</option>
                                        </select>
                                        <input type="text" name="fisik[preOperatif][kardiopulmonal][edemaPerifer][keterangan]" class="form-control" value="{{@$asessment['preOperatif']['kardiopulmonal']['edemaPerifer']['keterangan']}}" placeholder="keterangan">

                                        <br>
                                        <span>Alat Bantu :</span>
                                        <br>

                                        <select name="fisik[preOperatif][kardiopulmonal][alatBantu]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="Terpasang Pace Maker" {{@$asessment['preOperatif']['kardiopulmonal']['alatBantu'] == 'Terpasang Pace Maker' ? 'selected' : ''}}>Terpasang Pace Maker</option>
                                            <option value="Terpasanag Kateter Jantung" {{@$asessment['preOperatif']['kardiopulmonal']['alatBantu'] == 'Terpasanag Kateter Jantung' ? 'selected' : ''}}>Terpasanag Kateter Jantung</option>
                                        </select>

                                        <br>
                                        <span>Kulit :</span>
                                        <br>

                                        <select name="fisik[preOperatif][kardiopulmonal][kulit]" class="select2"  style="width: 100%">
                                            <option value=""  disabled>-- Pilih Opsi --</option>
                                            <option value="Dingin" {{@$asessment['preOperatif']['kardiopulmonal']['kulit'] == 'Dingin' ? 'selected' : ''}}>Dingin</option>
                                            <option value="Hangat" {{@$asessment['preOperatif']['kardiopulmonal']['kulit'] == 'Hangat' ? 'selected' : ''}}>Hangat</option>
                                            <option value="Utuh" {{@$asessment['preOperatif']['kardiopulmonal']['kulit'] == 'Utuh' ? 'selected' : ''}}>Utuh</option>
                                            <option value="Luka" {{@$asessment['preOperatif']['kardiopulmonal']['kulit'] == 'Luka' ? 'selected' : ''}}>Luka</option>
                                            <option value="Kering" {{@$asessment['preOperatif']['kardiopulmonal']['kulit'] == 'Kering' ? 'selected' : ''}}>Kering</option>
                                            <option value="Lembab" {{@$asessment['preOperatif']['kardiopulmonal']['kulit'] == 'Lembab' ? 'selected' : ''}}>Lembab</option>
                                            <option value="Tato" {{@$asessment['preOperatif']['kardiopulmonal']['kulit'] == 'Tato' ? 'selected' : ''}}>Tato</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">4. Sistem Muskuloskeleta</td>
                                    <td style="padding: 5px;">
                                        <select name="fisik[preOperatif][sistemMuskuloskeleta]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="TAK" {{@$asessment['preOperatif']['sistemMuskuloskeleta'] == 'TAK' ? 'selected' : ''}}>TAK</option>
                                            <option value="Paralisis" {{@$asessment['preOperatif']['sistemMuskuloskeleta'] == 'Paralisis' ? 'selected' : ''}}>Paralisis</option>
                                            <option value="Traksi" {{@$asessment['preOperatif']['sistemMuskuloskeleta'] == 'Traksi' ? 'selected' : ''}}>Traksi</option>
                                            <option value="Alat Bantu" {{@$asessment['preOperatif']['sistemMuskuloskeleta'] == 'Alat Bantu' ? 'selected' : ''}}>Alat Bantu</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">5. Sistem Perkemihan</td>
                                    <td style="padding: 5px;">
                                        <select name="fisik[preOperatif][sistemPerkemihan]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="TAK" {{@$asessment['preOperatif']['sistemPerkemihan'] == 'TAK' ? 'selected' : ''}}>TAK</option>
                                            <option value="Kateter" {{@$asessment['preOperatif']['sistemPerkemihan'] == 'Kateter' ? 'selected' : ''}}>Kateter</option>
                                            <option value="Lain-Lain" {{@$asessment['preOperatif']['sistemPerkemihan'] == 'Lain-Lain' ? 'selected' : ''}}>Lain-Lain</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">6. Sistem Neurosensor</td>
                                    <td style="padding: 5px;">
                                        <select name="fisik[preOperatif][sistemNeurosensor]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="TAK" {{@$asessment['preOperatif']['sistemNeurosensor'] == 'TAK' ? 'selected' : ''}}>TAK</option>
                                            <option value="Pendengaran" {{@$asessment['preOperatif']['sistemNeurosensor'] == 'Pendengaran' ? 'selected' : ''}}>Pendengaran</option>
                                            <option value="Bahasa Isyarat" {{@$asessment['preOperatif']['sistemNeurosensor'] == 'Bahasa Isyarat' ? 'selected' : ''}}>Bahasa Isyarat</option>
                                            <option value="Bahasa" {{@$asessment['preOperatif']['sistemNeurosensor'] == 'Bahasa' ? 'selected' : ''}}>Bahasa</option>
                                            <option value="Penglihatan" {{@$asessment['preOperatif']['sistemNeurosensor'] == 'Penglihatan' ? 'selected' : ''}}>Penglihatan</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">7. Alat Bantu</td>
                                    <td style="padding: 5px;">
                                        <select name="fisik[preOperatif][alatBantu]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="Alat Dengar" {{@$asessment['preOperatif']['alatBantu'] == 'Alat Dengar' ? 'selected' : ''}}>Alat Dengar</option>
                                            <option value="Kacamata" {{@$asessment['preOperatif']['alatBantu'] == 'Kacamata' ? 'selected' : ''}}>Kacamata</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">8. Keluhan Nyeri</td>
                                    <td style="padding: 5px;">
                                        <select name="fisik[preOperatif][keluhanNyeri][pilihan]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="Ya" {{@$asessment['preOperatif']['keluhanNyeri']['pilihan']== 'Ya' ? 'selected' : ''}}>Ya</option>
                                            <option value="Tidak" {{@$asessment['preOperatif']['keluhanNyeri']['pilihan']== 'Tidak' ? 'selected' : ''}}>Tidak</option>
                                        </select>

                                        <br>
                                        <span>Skala Nyeri (0-10) :</span>
                                        <br>
                                        <input type="text" name="fisik[preOperatif][keluhanNyeri][skalaNyeri]" class="form-control" value="{{@$asessment['preOperatif']['keluhanNyeri']['skalaNyeri']}}" placeholder="Skala Nyeri">
                                        <br>
                                        <span>Lokasi :</span>
                                        <br>
                                        <input type="text" name="fisik[preOperatif][keluhanNyeri][lokasi]" class="form-control" value="{{@$asessment['preOperatif']['keluhanNyeri']['lokasi']}}" placeholder="Lokasi">
                                        <br>
                                        <span>Yang meringankan / memperberat nyeri :</span>
                                        <br>
                                        <input type="text" name="fisik[preOperatif][keluhanNyeri][yang_meringankan_atau_memperberat]" class="form-control" value="{{@$asessment['preOperatif']['keluhanNyeri']['yang_meringankan_atau_memperberat']}}" placeholder="Yang meringankan / memperberat nyeri">
                                        <br>
                                        <span>Waktu :</span>
                                        <br>
                                        <input type="datetime-local" name="fisik[preOperatif][keluhanNyeri][waktu]" class="form-control" value="{{@$asessment['preOperatif']['keluhanNyeri']['waktu']}}" placeholder="Waktu">
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">9. Status Psikologi</td>
                                    <td style="padding: 5px;">
                                        <select name="fisik[preOperatif][statusPsikologi]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="Tenang" {{@$asessment['preOperatif']['statusPsikologi'] == 'Tenang' ? 'selected' : ''}}>Tenang</option>
                                            <option value="Gelisah" {{@$asessment['preOperatif']['statusPsikologi'] == 'Gelisah' ? 'selected' : ''}}>Gelisah</option>
                                            <option value="Banyak Bicara" {{@$asessment['preOperatif']['statusPsikologi'] == 'Banyak Bicara' ? 'selected' : ''}}>Banyak Bicara</option>
                                            <option value="Menangis" {{@$asessment['preOperatif']['statusPsikologi'] == 'Menangis' ? 'selected' : ''}}>Menangis</option>
                                            <option value="Lemah" {{@$asessment['preOperatif']['statusPsikologi'] == 'Lemah' ? 'selected' : ''}}>Lemah</option>
                                            <option value="Lain-lain" {{@$asessment['preOperatif']['statusPsikologi'] == 'Lain-lain' ? 'selected' : ''}}>Lain-lain</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="col-md-12">
                                            <form method="POST" action="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
                                                {{ csrf_field() }}
                                                {!! Form::hidden('registrasi_id', $reg->id) !!}
                                                {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                                                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                                                {!! Form::hidden('unit', $unit) !!}
                                                <br>
                                                @include('emr.modules.pemeriksaan.select-askep')
                                
                                                <div style="text-align: right;">
                                                <button class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>
                                            @include('emr.modules.pemeriksaan.modal-tte-askep')
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <h5><b>B. Data Perawatan Intra Operatif</b></h5>
                                <tr>
                                    <td colspan="2" style="font-weight: bold;">1. TTV</td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">TD</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[intraOperatif][td]" class="form-control" value="{{@$asessment['intraOperatif']['td']}}">
                                    </td>
                                    <td>mmHg</td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">SpO2</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[intraOperatif][spo2]" class="form-control" value="{{@$asessment['intraOperatif']['spo2']}}">
                                    </td>
                                    <td>%</td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">HR</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[intraOperatif][hr]" class="form-control" value="{{@$asessment['intraOperatif']['hr']}}">
                                    </td>
                                    <td>X/Menit</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight: bold;">2. Pendarahan</td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Kasa</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[intraOperatif][kasa]" class="form-control" value="{{@$asessment['intraOperatif']['kasa']}}">
                                    </td>
                                    <td>Cc</td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Suction</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[intraOperatif][suction]" class="form-control" value="{{@$asessment['intraOperatif']['suction']}}">
                                    </td>
                                    <td>Cc</td>
                                </tr>
                                <tr>
                                    <td style="width:20%;font-weight: bold;">3. Irigasi Pencucian</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[intraOperatif][irigasiPencucian]" class="form-control" value="{{@$asessment['intraOperatif']['irigasiPencucian']}}">
                                    </td>
                                    <td>Cc</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="col-md-12">
                                            <form method="POST" action="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
                                                {{ csrf_field() }}
                                                {!! Form::hidden('registrasi_id', $reg->id) !!}
                                                {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                                                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                                                {!! Form::hidden('unit', $unit) !!}
                                                <br>
                                                @include('emr.modules.pemeriksaan.select-askep')
                                
                                                <div style="text-align: right;">
                                                <button class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>
                                            @include('emr.modules.pemeriksaan.modal-tte-askep')
                                        </div>
                                    </td>
                                </tr>
                            </table>


                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <h5><b>C. Data Perawatan Post Operatif</b></h5>
                                <tr>
                                    <td style="width:20%;">1. Keluhan Nyeri</td>
                                    <td style="padding: 5px;" colspan="2">
                                        <select name="fisik[postOperatif][keluhanNyeri]" class="select2" style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="Ya" {{@$asessment['postOperatif']['keluhanNyeri'] == 'Ya' ? 'selected' : ''}}>Ya</option>
                                            <option value="Tidak" {{@$asessment['postOperatif']['keluhanNyeri'] == 'Tidak' ? 'selected' : ''}}>Tidak</option>
                                            <option value="Tidak Bisa" {{@$asessment['preOperatif']['keluhanNyeri'] == 'Tidak Bisa' ? 'selected' : ''}}>Tidak Bisa</option>
                                        </select>

                                        <br>
                                        <span>Skala Nyeri (0-10) :</span>
                                        <br>

                                        <input type="text" name="fisik[postOperatif][skalaNyeri]" class="form-control" value="{{@$asessment['postOperatif']['skalaNyeri']}}" placeholder="0-10">
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">2. Kondisi Kulit</td>
                                    <td style="padding: 5px;" colspan="2">
                                        <select name="fisik[postOperatif][kondisiKulit]" class="select2"  style="width: 100%">
                                            <option value=""  disabled>-- Pilih Opsi --</option>
                                            <option value="Dingin" {{@$asessment['postOperatif']['kondisiKulit'] == 'Dingin' ? 'selected' : ''}}>Dingin</option>
                                            <option value="Hangat" {{@$asessment['postOperatif']['kondisiKulit'] == 'Hangat' ? 'selected' : ''}}>Hangat</option>
                                            <option value="Kering" {{@$asessment['postOperatif']['kondisiKulit'] == 'Kering' ? 'selected' : ''}}>Kering</option>
                                            <option value="Utuh" {{@$asessment['postOperatif']['kondisiKulit'] == 'Utuh' ? 'selected' : ''}}>Utuh</option>
                                            <option value="Lembab" {{@$asessment['postOperatif']['kondisiKulit'] == 'Lembab' ? 'selected' : ''}}>Lembab</option>
                                            <option value="Lain-Lain" {{@$asessment['postOperatif']['kondisiKulit'] == 'Lain-Lain' ? 'selected' : ''}}>Lain-Lain</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">3. Kesadaran</td>
                                    <td style="padding: 5px;" colspan="2">
                                        <select name="fisik[postOperatif][kesadaran]" class="select2"  style="width: 100%">
                                            <option value=""  disabled>-- Pilih Opsi --</option>
                                            <option value="Sadar" {{@$asessment['postOperatif']['kesadaran'] == 'Sadar' ? 'selected' : ''}}>Sadar</option>
                                            <option value="Mengantuk" {{@$asessment['postOperatif']['kesadaran'] == 'Mengantuk' ? 'selected' : ''}}>Mengantuk</option>
                                            <option value="Terintubasi" {{@$asessment['postOperatif']['kesadaran'] == 'Terintubasi' ? 'selected' : ''}}>Terintubasi</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">4. TTV</td>
                                </tr>

                                <tr>
                                    <td style="width:20%;">TD</td>
                                    <td style="padding: 5px;" >
                                        <input type="text" name="fisik[postOperatif][td]" class="form-control" value="{{@$asessment['postOperatif']['td']}}">
                                    </td>
                                    <td>%</td>

                                </tr>
                                <tr>
                                    <td style="width:20%;">SpO2</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[postOperatif][spo2]" class="form-control" value="{{@$asessment['postOperatif']['spo2']}}">
                                    </td>
                                    <td>%</td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">HR</td>
                                    <td style="padding: 5px;">
                                        <input type="text" name="fisik[postOperatif][hr]" class="form-control" value="{{@$asessment['postOperatif']['hr']}}">
                                    </td>
                                    <td>X/Menit</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="col-md-12">
                                            <form method="POST" action="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
                                                {{ csrf_field() }}
                                                {!! Form::hidden('registrasi_id', $reg->id) !!}
                                                {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                                                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                                                {!! Form::hidden('unit', $unit) !!}
                                                <br>
                                                @include('emr.modules.pemeriksaan.select-askep')
                                
                                                <div style="text-align: right;">
                                                <button class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>
                                            @include('emr.modules.pemeriksaan.modal-tte-askep')
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <h5><b>D. Alasan Pembatalan / Penundaan Operasi</b></h5>
                                <tr>
                                    <td>
                                        <textarea name="fisik[alasanPembatalan]"  rows="4" style="width: 100%" class="form-control" placeholder="Jelakan">{{@$asessment['alasanPembatalan']}}</textarea>
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <h5><b>Post Operasi Ke</b></h5>
                                <tr>
                                    <td style="width:20%;">1. Ke</td>
                                    <td>
                                        <select name="fisik[postOperasiKe]" class="select2"  style="width: 100%">
                                            <option value="" selected disabled>-- Pilih Opsi --</option>
                                            <option value="RR" {{@$asessment['postOperasiKe'] == 'RR' ? 'selected' : ''}}>RR</option>
                                            <option value="R. Intensif" {{@$asessment['postOperasiKe'] == 'R. Intensif' ? 'selected' : ''}}>R. Intensif</option>
                                            <option value="Ruangan" {{@$asessment['postOperasiKe'] == 'Ruangan' ? 'selected' : ''}}>Ruangan</option>
                                            <option value="Rumah" {{@$asessment['postOperasiKe'] == 'Rumah' ? 'selected' : ''}}>Rumah</option>
                                            <option value="Ruangan" {{@$asessment['postOperasiKe'] == 'Ruangan' ? 'selected' : ''}}>Ruangan</option>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:20%;">Dengan</td>
                                    <td>
                                        <select name="fisik[pergiDengan]" class="select2"  style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="Strecher" {{@$asessment['pergiDengan'] == 'Strecher' ? 'selected' : ''}}>Strecher</option>
                                            <option value="Kursi Roda" {{@$asessment['pergiDengan'] == 'Kursi Roda' ? 'selected' : ''}}>Kursi Roda</option>
                                            <option value="Berjalan Sendiri" {{@$asessment['pergiDengan'] == 'Berjalan Sendiri' ? 'selected' : ''}}>Berjalan Sendiri</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <h5><b>E. Discharge Planning (Khusus ODS)</b></h5>
                                <tr>
                                    <td>
                                        <select name="fisik[dischargePlanning]" class="select2"  style="width: 100%">
                                            <option value=""  selected disabled>-- Pilih Opsi --</option>
                                            <option value="tanya" {{@$asessment['dischargePlanning'] == 'tanya' ? 'selected' : ''}}>Tanyakan apakah ada pusing, mual, dll. Bila ada biarkan pasien istirahat sampai keluhan hilang</option>
                                            <option value="jelaskan" {{@$asessment['dischargePlanning'] == 'jelaskan' ? 'selected' : ''}}>Jelaskan cara dan rute penggunaan obat, perawatan luka dirumah (rekomendasikan ke puskesmas/RS terdekat)</option>
                                            <option value="informasi" {{@$asessment['dischargePlanning'] == 'informasi' ? 'selected' : ''}}>Informasikan dengan jelas tanggal kontrol</option>
                                            <option value="pastikan" {{@$asessment['dischargePlanning'] == 'pastikan' ? 'selected' : ''}}>Pastiksan Pasien Tidak Pulang Sendiri</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <button class="btn btn-success" type="submit">Simpan</button>
                        </div>

                        <div class="col-md-6">
                            <table class='table-striped table-bordered table-hover table-condensed table'>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center" style="vertical-align: middle;">History</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
                                        <th class="text-center" style="vertical-align: middle;">Poli</th>
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
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                {{ baca_poli($riwayat->registrasi->poli_id) }}
                                            </td>
                                            {{-- @if ($riwayat->id == request()->asessment_id)
                                            <td style="text-align: center; background-color:rgb(172, 247, 162)">
                                                {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                                            </td>
                                        @else
                                            <td style="text-align: center;">
                                                {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                                            </td>
                                        @endif --}}
                
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                                    class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                                <a href="{{ url('emr-soap-print/cetak-pre-operatif/' . @$riwayat->id) }}"
                                                    target="_blank" class="btn btn-warning btn-sm">
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
                                            <td colspan="3"
                                                style="font-size: 8pt; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                <i>Dibuat : {{ Carbon\Carbon::parse($riwayat->updated_at)->format('d-m-Y H:i') }}</i>
                                            </td>
                                        </tr>
                                    @endforeach
                
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                </div>
            </div>   
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
        $("#date_dengan_tanggal").attr('', true);
    </script>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var dataImage = document.getElementById("dataImage");
        var captionText = document.getElementById("caption");
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = dataImage.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Pilih Multi Tindakan",
                allowClear: true
            });

        });

        // MASTER OBAT
        $('#select2Multiple').select2({
            placeholder: "Klik untuk isi nama tindakan",
            width: '100%',
            ajax: {
                url: '/tindakan/ajax-tindakan/' + status_reg,
                dataType: 'json',
                data: function(params) {
                    return {
                        j: 1,
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })

        $(document).ready(function() {
            //TINDAKAN entry
            $('select[name="kategoriTarifID"]').on('change', function() {
                var tarif_id = $(this).val();
                if (tarif_id) {
                    $.ajax({
                        url: '/tindakan/getTarif/' + tarif_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            //$('select[name="tarif_id"]').append('<option value=""></option>');
                            $('select[name="tarif_id"]').empty();
                            $.each(data, function(id, nama, total) {
                                $('select[name="tarif_id"]').append('<option value="' +
                                    nama.id + '">' + nama.nama + ' | ' + ribuan(nama
                                        .total) + '</option>');
                            });

                        }
                    });
                } else {
                    $('select[name="tarif_id"]').empty();
                }
            });
        });

        $('.historiAskep').click( function(e) {
            var id = $(this).attr('data-pasienID');
            $('.showHistoriAskep').modal('show');
            $('.dataHistoriAskep').load("/emr-riwayat-askep/" + id);
        });

        $('.select2-diagnosis').select2({
            placeholder: "Pilih Diagnosa",
            width: '85%'
        });
        $('.select2-pemeriksaanDalam').select2({
            placeholder: "Pilih Intervensi",
            allowClear: true
        });
        $('.select2-fungsional').select2({
            placeholder: "Pilih Implementasi",
            allowClear: true
        });
    
        $('.select2-diagnosis').change(function(e){
          var intervensi = $('.select2-pemeriksaanDalam');
          var implementasi = $('.select2-fungsional');
          var diagnosa = $(this).val();
    
          intervensi.empty();
          implementasi.empty();
    
          $.ajax({
            url: '/emr-get-askep?namaDiagnosa='+diagnosa,
            type: 'get',
            dataType: 'json',
          })
          .done(function(res) {
            if(res[0].metadata.code == 200){
              $.each(res[1], function(index, val){
                intervensi.append('<option value="'+ val.namaIntervensi +'">'+ val.namaIntervensi +'</option>');
              })
              $.each(res[2], function(index, val){
                implementasi.append('<option value="'+ val.namaImplementasi +'">'+ val.namaImplementasi +'</option>');
              })
            }
          })
    
        });
    </script>
@endsection
