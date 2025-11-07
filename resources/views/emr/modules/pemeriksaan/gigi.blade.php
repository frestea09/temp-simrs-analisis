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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/gigi/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
                <div class="row">
                    @include('emr.modules.addons.tabs')
                    <div class="col-md-12">

                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                        <br>

                        {{-- Anamnesis --}}
                        @php
                            @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
                            if (!@$dataPegawai) {
                                @$dataPegawai = 1;
                            }
                        @endphp

                        @if (@$dataPegawai == '1')
                            <div class="col-md-6">
                                <h5><b>Asesmen</b></h5>
                                <input type="hidden" name="asesment_type" value="dokter">
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>1. ANAMNESIS</b></h5>
                                    <tr>
                                        <td style="width:20%;">A. Keluhan Utama</td>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" required name="fisik[anamnesa]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Keluhan Utama]" class="form-control">{{ @$assesment['anamnesa'] ?? @$assesment_perawat['anamnesa'] }}</textarea>
                                            @if($errors->has('fisik.anamnesa'))
                                                <div class="error text-danger">{{ $errors->first('fisik.anamnesa') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">B. Riwayat Penyakit Sekarang</td>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" required name="fisik[riwayatPenyakitSekarang]" style="display:inline-block; resize: vertical;"placeholder="[Masukkan Riwayat Penyakit Sekarang]" class="form-control">{{ @$assesment['riwayatPenyakitSekarang'] }}</textarea>
                                            @if($errors->has('fisik.riwayatPenyakitSekarang'))
                                                <div class="error text-danger">{{ $errors->first('fisik.riwayatPenyakitSekarang') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">C. Riwayat Penyakit Dahulu</td>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" required name="fisik[riwayatPenyakitDahulu]" style="display:inline-block; resize: vertical;"placeholder="[Masukkan Penyakit Dahulu]" class="form-control">{{ @$assesment['riwayatPenyakitDahulu'] }}</textarea>
                                            @if($errors->has('fisik.riwayatPenyakitDahulu'))
                                                <div class="error text-danger">{{ $errors->first('fisik.riwayatPenyakitDahulu') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">D. Pernah Dirawat</td>
                                        <td style="padding: 5px;">
                                            <div>
                                                <input type="radio" required name="fisik[isPernahDirawat]" class="" id="pernahDirawatYA" value="true" {{@$assesment['isPernahDirawat'] == 'true' ? 'checked' : ''}} onchange="isPernahDirawatChange(this)">
                                                <label for="pernahDirawatYA" class="control-label" style="margin-right: 10px">YA</label>
    
                                                <input type="radio" required name="fisik[isPernahDirawat]" class="" id="pernahDirawatTIDAK" value="false" {{@$assesment['isPernahDirawat'] == 'false' ? 'checked' : ''}} onchange="isPernahDirawatChange(this)">
                                                <label for="pernahDirawatTIDAK" class="control-label">TIDAK</label>

                                                @if($errors->has('fisik.isPernahDirawat'))
                                                    <div class="error text-danger">{{ $errors->first('fisik.isPernahDirawat') }}</div>
                                                @endif
                                            </div>
                                            <div style="margin-top: 10px;{{@$assesment['isPernahDirawat'] == 'true' ? '' : 'display:none'}}" id="pernahDirawatInputGroup">
                                                <input type="text" name="fisik[pernahDirawat][waktu]" class="form-control date_tanpa_tanggal" value="{{ @$assesment['pernahDirawat']['waktu'] }}">
                                                <input type="text" name="fisik[pernahDirawat][lokasi]" class="form-control" value="{{ @$assesment['pernahDirawat']['lokasi'] }}" placeholder="[Tempat/Lokasi]">
                                                <input type="text" name="fisik[pernahDirawat][diagnosa]" class="form-control" value="{{ @$assesment['pernahDirawat']['diagnosa'] }}" placeholder="[Diagnosa]">
                                            </div>
                                            <script>
                                                function isPernahDirawatChange(el){
                                                    if(el.value == 'true'){
                                                        document.getElementById('pernahDirawatInputGroup').style.display = 'block';
                                                    }else{
                                                        console.log(document.getElementById('pernahDirawatInputGroup'));
                                                        document.getElementById('pernahDirawatInputGroup').style.display = 'none';
                                                    }
                                                }
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">E. Riwayat Penyakit Keluarga</td>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" required name="fisik[riwayatPenyakitKeluarga]" style="display:inline-block; resize: vertical;"placeholder="[Masukkan Penyakit Keluarga]" class="form-control">{{ @$assesment['riwayatPenyakitKeluarga'] }}</textarea>
                                            @if($errors->has('fisik.riwayatPenyakitKeluarga'))
                                                <div class="error text-danger">{{ $errors->first('fisik.riwayatPenyakitKeluarga') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>2. PEMERIKSAAN FISIK</b></h5>
                                    <div>
                                        <span style="font-weight: bold">Kesadaran: </span>
                                        <em>
                                            {{@$assesment_perawat['tanda_vital']['kesadaran']['sebutkan'] ? @$assesment_perawat['tanda_vital']['kesadaran']['sebutkan'] : '-'}}
                                        </em>
                                    </div>
                                    <div>
                                        <span style="font-weight: bold">Tanda Vital: </span>
                                            Tekanan Darah: {{@$assesment_perawat['tanda_vital']['tekanan_darah1']['sebutkan'] ? @$assesment_perawat['tanda_vital']['tekanan_darah1']['sebutkan'] : '-'}}/{{@$assesment_perawat['tanda_vital']['tekanan_darah2']['sebutkan'] ? @$assesment_perawat['tanda_vital']['tekanan_darah2']['sebutkan'] : '-'}} MMHG |
                                            Nadi: {{@$assesment_perawat['tanda_vital']['nadi']['sebutkan'] ? @$assesment_perawat['tanda_vital']['nadi']['sebutkan'] : '-'}} X/Menit | 
                                            Suhu: {{@$assesment_perawat['tanda_vital']['temp']['sebutkan'] ? @$assesment_perawat['tanda_vital']['temp']['sebutkan'] : '-'}} oC | 
                                            Nafas: {{@$assesment_perawat['tanda_vital']['RR']['sebutkan'] ? @$assesment_perawat['tanda_vital']['RR']['sebutkan'] : '-'}} X/Menit | 
                                            Tinggi Badan: {{@$assesment_perawat['tanda_vital']['TB']['sebutkan'] ? @$assesment_perawat['tanda_vital']['TB']['sebutkan'] : '-'}} cm |
                                            Berat Badan: {{@$assesment_perawat['tanda_vital']['BB']['sebutkan'] ? @$assesment_perawat['tanda_vital']['BB']['sebutkan'] : '-'}} Kg |
                                    </div>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" required name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;"
                                                placeholder="[Masukkan Pemeriksaan Fisik]" class="form-control">{{ @$assesment['pemeriksaan_fisik'] }}</textarea>
                                            @if($errors->has('fisik.pemeriksaan_fisik'))
                                                <div class="error text-danger">{{ $errors->first('fisik.pemeriksaan_fisik') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>3. STATUS PEDIATRI (diisi bila perlu)</b></h5>
                                    <tr>
                                        <td style="width:20%;">A. Status Gizi</td>
                                        <td style="padding: 5px;">
                                            <input type="text" name="fisik[status_pediatri][status_gizi]"
                                                class="form-control" id=""
                                                value="{{ @$assesment['status_pediatri']['status_gizi'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">B. Riwayat Imunisasi</td>
                                        <td style="padding: 5px;">
                                            <input type="text" name="fisik[status_pediatri][riwayat_imunisasi]"
                                                class="form-control" id=""
                                                value="{{ @$assesment['status_pediatri']['riwayat_imunisasi'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">C. Riwayat Tumbuh Kembang</td>
                                        <td style="padding: 5px;">
                                            <input type="text" name="fisik[status_pediatri][riwayat_tumbuh_kembang]"
                                                class="form-control" id=""
                                                value="{{ @$assesment['status_pediatri']['riwayat_tumbuh_kembang'] }}">
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5>
                                        <b>4. STATUS LOKALIS</b>
                                        @if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4' ||$reg->poli_id == '47')
                                            <a href="{{ url('/emr-soap/penilaian/gigi/' . $unit . '/' . @$reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                                                title="Status Lokalis" class="btn btn-default btn-sm btn-flat"
                                                target="_blank"><i class="fa fa-pencil"></i> Isi Lokalis</a>&nbsp;&nbsp;
                                        @elseif(@$reg->poli_id == '15')
                                            <a href="{{ url('/emr-soap/penilaian/obgyn/' . $unit . '/' . @$reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                                                title="Status Lokalis" class="btn btn-default btn-sm btn-flat"
                                                target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                                        @elseif(@$reg->poli_id == '27')
                                            <a href="{{ url('/emr-soap/penilaian/hemodialisis/' . $unit . '/' . @$reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                                                title="Status Lokalis" class="btn btn-default btn-sm btn-flat"
                                                target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                                        @else
                                            <a href="{{ url('/emr-soap/penilaian/fisik/' . $unit . '/' . @$reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}"
                                                title="Status Lokalis" class="btn btn-default btn-sm btn-flat"
                                                target="_blank"><i class="fa fa-pencil"> </i> Isi Lokalis</a>&nbsp;&nbsp;
                                        @endif
                                    </h5>
                                    <tr>
                                        <td><b>Status Lokalis :</b>

                                            @if (@$gambar->image != null)
                                                <br>
                                                <img src="/images/{{ @$gambar['image'] }}" id="dataImage" style="width: 400px; height:auto;">
                                                <br>
                                                <label for="">Keterangan Lokalis</label>
                                                <br>
                                                <ol>
                                                    <li>{{ @$ketGambar['keterangan'][0][1] ? @$ketGambar['keterangan'][0][1] : '-' }}
                                                    </li>
                                                    <li>{{ @$ketGambar['keterangan'][1][2] ? @$ketGambar['keterangan'][1][2] : '-' }}
                                                    </li>
                                                    <li>{{ @$ketGambar['keterangan'][2][3] ? @$ketGambar['keterangan'][2][3] : '-' }}
                                                    </li>
                                                    <li>{{ @$ketGambar['keterangan'][3][4] ? @$ketGambar['keterangan'][3][4] : '-' }}
                                                    </li>
                                                    <li>{{ @$ketGambar['keterangan'][4][5] ? @$ketGambar['keterangan'][4][5] : '-' }}
                                                    </li>
                                                    <li>{{ @$ketGambar['keterangan'][5][6] ? @$ketGambar['keterangan'][5][6] : '-' }}
                                                    </li>
                                                </ol>
                                            @else
                                                -
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" name="fisik[keterangan_status_lokalis]" style="display:inline-block; resize: vertical;"
                                                placeholder="Keterangan Status Lokalis" class="form-control">{{ @$assesment['keterangan_status_lokalis'] }}</textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5><b>Asesmen</b></h5>
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>5. DIAGNOSIS</b></h5>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" required name="fisik[diagnosis]" style="display:inline-block; resize: vertical;"
                                                placeholder="[Masukkan Diagnosis]" class="form-control">{{ @$assesment['diagnosis'] }}</textarea>
                                            @if($errors->has('fisik.diagnosis'))
                                                <div class="error text-danger">{{ $errors->first('fisik.diagnosis') }}</div>
                                            @endif
                                        </td>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" name="fisik[diagnosistambahan]" style="display:inline-block; resize: vertical;" placeholder="[Masukkan Diagnosis Tambahan]" class="form-control" >{{ @$assesment['diagnosistambahan'] }}</textarea>
                                            <br/>
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>6. PLANNING</b></h5>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" required name="fisik[planning]" style="display:inline-block; resize: vertical;"
                                                placeholder="[Masukkan Planning]" class="form-control">{{ @$assesment['planning'] }}</textarea>
                                            @if($errors->has('fisik.planning'))
                                                <div class="error text-danger">{{ $errors->first('fisik.planning') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>Riwayat Medis Lainnya</b></h5>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" name="fisik[RiwayatLain]" style="display:inline-block; resize: vertical;" placeholder=""
                                                class="form-control">{{ @$assesment['RiwayatLain'] }}</textarea>
                                        </td>
                                    </tr>
                                </table>
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>Apakah pasien mempunyai kebiasaan</b></h5>
                                    <tr>
                                        <td><b>Minum Kopi :</b>
                                            <input type="checkbox" id=""
                                                name="fisik[kebiasaan][minumKopi][dipilih]" value="Ya"
                                                {{ @$assesment['kebiasaan']['minumKopi']['dipilih'] == 'Ya' ? 'checked' : '' }}>
                                            <label for=""
                                                style="font-weight: normal; margin-right: 10px;">Ya</label>

                                            <input type="checkbox" id=""
                                                name="fisik[kebiasaan][minumKopi][dipilih]" value="Tidak"
                                                {{ @$assesment['kebiasaan']['minumKopi']['dipilih'] == 'Tidak' ? 'checked' : '' }}>
                                            <label for=""
                                                style="font-weight: normal; margin-right: 10px;">Tidak</label><br />
                                        </td>
                                    </tr>
                                </table>

                                {{-- <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;"> 
              <h5><b>8. PENANGANAN PASIEN</b></h5>
              <tr>
                  <td style="padding: 5px;">
                    <input type="radio" id="pulang" name="fisik[penanganan_pasien]" value="Pulang" {{@$assesment['penanganan_pasien'] == 'Pulang' ? 'checked' : ''}}>
                    <label for="pulang" style="font-weight: normal;">Pulang</label><br>
                    <input type="radio" id="dirawat" name="fisik[penanganan_pasien]" value="Dirawat" {{@$assesment['penanganan_pasien'] == 'Dirawat' ? 'checked' : ''}}>
                    <label for="dirawat" style="font-weight: normal;">Dirawat</label><br>
                    <input type="radio" id="menolak_dirawat" name="fisik[penanganan_pasien]" value="Menolak Dirawat" {{@$assesment['penanganan_pasien'] == 'Menolak Dirawat' ? 'checked' : ''}}>
                    <label for="menolak_dirawat" style="font-weight: normal;">Menolak Dirawat</label><br>
                    <input type="radio" id="dirujuk" name="fisik[penanganan_pasien]" value="Dirujuk" {{@$assesment['penanganan_pasien'] == 'Dirujuk' ? 'checked' : ''}}>
                    <label for="dirujuk" style="font-weight: normal;">Dirujuk</label><br>
                  </td>
              </tr>
            </table> --}}
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">RENCANA PEMULANGAN PASIEN (Discharge
                                            Planning)</td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            Rencana Lama Rawat
                                        </td>
                                        <td>
                                            <input type="radio" id="rencanaRawat_1" name="fisik[dischargePlanning][rencanaLamaRawat][isDiTetapkan]" required value="true" {{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isDiTetapkan'] == 'true' ? 'checked' : '' }} onchange="isRencanaRawatChange(this)">
                                            <label for="rencanaRawat_1" style="font-weight: normal; margin-right: 10px;">Sudah dapat ditetapkan</label>

                                            <input type="radio" id="rencanaRawat_2" name="fisik[dischargePlanning][rencanaLamaRawat][isDiTetapkan]" required value="false" {{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isDiTetapkan'] == 'false' ? 'checked' : '' }} onchange="isRencanaRawatChange(this)">
                                            <label for="rencanaRawat_2" style="font-weight: normal; margin-right: 10px;">Belum Bisa Ditetapkan</label>
                                            @if($errors->has('fisik.dischargePlanning.rencanaLamaRawat.isDiTetapkan'))
                                                <div class="error text-danger">{{ $errors->first('fisik.dischargePlanning.rencanaLamaRawat.isDiTetapkan') }}</div>
                                            @endif
                                        </td>
                                        <script>
                                            function isRencanaRawatChange(el){
                                                if(el.value == 'true'){
                                                    document.getElementById('sudahDitetapkan').style.display = 'block';
                                                    document.getElementById('belumDitetapkan').style.display = 'none';
                                                }else{
                                                    document.getElementById('sudahDitetapkan').style.display = 'none';
                                                    document.getElementById('belumDitetapkan').style.display = 'block';
                                                }
                                            }
                                        </script>
                                    </tr>   
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            Keterangan
                                        </td>
                                        <td>
                                            <div id="sudahDitetapkan" style="{{@$assesment['dischargePlanning']['rencanaLamaRawat']['isDiTetapkan'] == 'true' ? 'display:block;' : 'display:none;'}}">
                                                <input type="number" name="fisik[dischargePlanning][rencanaLamaRawat][hari]" class="form-control" value="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['hari'] }}" placeholder="[Jumlah Hari]">
                                                <input type="text" name="fisik[dischargePlanning][rencanaLamaRawat][tanggalPulang]" class="form-control date_tanpa_tanggal" placeholder="[Rencana Tanggal Pulang]" value="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['tanggalPulang'] }}">
                                            </div>

                                            <div id="belumDitetapkan" style="{{@$assesment['dischargePlanning']['rencanaLamaRawat']['isDiTetapkan'] == 'true' ? 'display:none;' : 'display:block;'}}">
                                                <input type="text" name="fisik[dischargePlanning][rencanaLamaRawat][alasan]" class="form-control" value="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['alasan'] }}" placeholder="[Alasan]">
                                            </div>
                                        </td>
                                    </tr>   
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            Perawatan Lanjutan
                                        </td>
                                        <td>
                                            <input type="radio" id="perawatanLanjutan_1" name="fisik[dischargePlanning][rencanaLamaRawat][isPerawatanLanjutan]" value="true" {{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isPerawatanLanjutan'] == 'true' ? 'checked' : '' }} >
                                            <label for="perawatanLanjutan_1" style="font-weight: normal; margin-right: 10px;">YA</label>

                                            <input type="radio" id="perawatanLanjutan_2" name="fisik[dischargePlanning][rencanaLamaRawat][isPerawatanLanjutan]" value="false" {{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isPerawatanLanjutan'] == 'false' ? 'checked' : '' }} >
                                            <label for="perawatanLanjutan_2" style="font-weight: normal; margin-right: 10px;">Tidak</label>

                                            <input type="text" name="fisik[dischargePlanning][rencanaLamaRawat][perawatanLanjutan]" class="form-control" value="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['perawatanLanjutan'] }}" placeholder="[Jika Ya, Jelaskan perawatan lanjutannya]">
                                        </td>
                                    </tr>   

                                    {{-- <tr>
                                        <td style="width:25%; font-weight:500;">
                                            <input type="checkbox" id="dischargePlanning_1"
                                                name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS"
                                                {{ @$assesment['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_1"
                                                style="font-weight: normal; margin-right: 10px;">Kontrol ulang
                                                RS</label><br />
                                        </td>
                                        <td>
                                            <input type="text" name="fisik[dischargePlanning][kontrol][waktu]"
                                                class="form-control date_tanpa_tanggal"
                                                value="{{ @$assesment['dischargePlanning']['kontrol']['waktu'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            <input type="checkbox" id="dischargePlanning_2"
                                                name="fisik[dischargePlanning][kontrolPRB][dipilih]" value="Kontrol PRB"
                                                {{ @$assesment['dischargePlanning']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_2"
                                                style="font-weight: normal; margin-right: 10px;">Kontrol PRB</label><br />
                                        </td>
                                        <td>
                                            <input type="text" name="fisik[dischargePlanning][kontrolPRB][waktu]"
                                                class="form-control date_tanpa_tanggal"
                                                value="{{ @$assesment['dischargePlanning']['kontrolPRB']['waktu'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            <input type="checkbox" id="dischargePlanning_3"
                                                name="fisik[dischargePlanning][dirawat][dipilih]" value="Dirawat"
                                                {{ @$assesment['dischargePlanning']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_3"
                                                style="font-weight: normal; margin-right: 10px;">Dirawat</label><br />
                                        </td>
                                        <td>
                                            <input type="text" name="fisik[dischargePlanning][dirawat][waktu]"
                                                class="form-control date_tanpa_tanggal"
                                                value="{{ @$assesment['dischargePlanning']['dirawat']['waktu'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            <input type="checkbox" id="dischargePlanning_4"
                                                name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk"
                                                {{ @$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_4"
                                                style="font-weight: normal; margin-right: 10px;">Dirujuk</label><br />
                                        </td>
                                        <td>
                                            <input type="text" name="fisik[dischargePlanning][dirujuk][waktu]"
                                                class="form-control date_tanpa_tanggal"
                                                value="{{ @$assesment['dischargePlanning']['dirujuk']['waktu'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            <input type="checkbox" id="dischargePlanning_5"
                                                name="fisik[dischargePlanning][Konsultasi][dipilih]"
                                                value="Konsultasi selesai / tidak kontrol ulang"
                                                {{ @$assesment['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_5"
                                                style="font-weight: normal; margin-right: 10px;">Konsultasi selesai / tidak
                                                kontrol ulang</label><br />
                                        </td>
                                        <td>
                                            <input type="text" name="fisik[dischargePlanning][Konsultasi][waktu]"
                                                class="form-control date_tanpa_tanggal"
                                                value="{{ @$assesment['dischargePlanning']['Konsultasi']['waktu'] }}">
                                        </td>
                                    </tr> --}}
                                </table>

                                <button class="btn btn-success pull-right">Simpan</button>
            </form>
            <br />
            <br />

            <table class='table-striped table-bordered table-hover table-condensed table'>
                <form method="POST" action="{{ url('emr-soap/perencanaan/visum/' . $unit . '/' . $reg->id) }}"
                    class="form-horizontal">
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    {!! Form::hidden('poli', $poli) !!}
                    {!! Form::hidden('dpjp', $dpjp) !!}
                    <br>
                    <tr>
                        <td style="width:20%;">Visum</td>
                        <td style="padding: 5px;">
                            <textarea name="keterangan[pemeriksaanDokter]" id="" class="form-control"
                                style="resize: vertical; dispay: inline-block;" rows="10">{{ @$visum['pemeriksaanDokter'] }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <button class="btn btn-success">Simpan Visum</button>
                        </td>
                    </tr>
                </form>
            </table>

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

                    @if (count($riwayats_dokter) == 0)
                        <tr>
                            <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                        </tr>
                    @endif
                    @foreach ($riwayats_dokter as $riwayat)
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
                                <a href="{{ url('cetak-resume-medis-rencana-kontrol-gigi/pdf/' . @$riwayat->registrasi_id . '/' . @$riwayat->id) }}"
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
    @else
        <div class="col-md-6">
            <input type="hidden" name="asesment_type" value="perawat">
            <h5><b>Asesmen Keperawatan</b></h5>
            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <h5><b>A. KELUHAN UTAMA</b></h5>
                <tr>
                    <td style="padding: 5px;">
                        <textarea rows="3" name="fisik[anamnesa]" style="display:inline-block; resize: vertical;"
                            placeholder="Masukkan Keluhan Utama" class="form-control"></textarea>
                        @if($errors->has('fisik.anamnesa'))
                            <div class="error text-danger">{{ $errors->first('fisik.anamnesa') }}</div>
                        @endif
                    </td>
                </tr>
            </table>

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <h5><b>B. RIWAYAT MEDIK</b></h5>
                <tr>
                    <td style="font-weight:500; width: 50%;">HIPERTENSI</td>
                    <td>
                        <input type="radio" id="hipertensi_1" name="fisik[riwayat_medik][hipertensi][pilihan]"
                            value="Tidak Ada">
                        <label for="hipertensi_1" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label>
                        <input type="radio" id="hipertensi_2" name="fisik[riwayat_medik][hipertensi][pilihan]"
                            value="Ada">
                        <label for="hipertensi_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                        <input type="number" id="hipertensi_3" name="fisik[riwayat_medik][hipertensi][sebutkan]"
                            style="display:inline-block; width: 150px;" class="form-control"
                            placeholder="Sebutkan (MMHG)">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">PENYAKIT JANTUNG</td>
                    <td>
                        <input type="radio" id="penyakitJantung_1"
                            name="fisik[riwayat_medik][penyakitJantung][pilihan]" value="Tidak Ada">
                        <label for="penyakitJantung_1" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label>
                        <input type="radio" id="penyakitJantung_2"
                            name="fisik[riwayat_medik][penyakitJantung][pilihan]" value="Ada">
                        <label for="penyakitJantung_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">KELAINAN DARAH</td>
                    <td>
                        <input type="radio" id="kelainanDarah_1" name="fisik[riwayat_medik][kelainanDarah][pilihan]"
                            value="Tidak Ada">
                        <label for="kelainanDarah_1" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label>
                        <input type="radio" id="kelainanDarah_2" name="fisik[riwayat_medik][kelainanDarah][pilihan]"
                            value="Ada">
                        <label for="kelainanDarah_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">DIABETES</td>
                    <td>
                        <input type="radio" id="diabetes_1" name="fisik[riwayat_medik][diabetes][pilihan]"
                            value="Tidak Ada">
                        <label for="diabetes_1" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label>
                        <input type="radio" id="diabetes_2" name="fisik[riwayat_medik][diabetes][pilihan]"
                            value="Ada">
                        <label for="diabetes_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">ALERGI</td>
                    <td>
                        <input type="radio" id="alergi_1" name="fisik[riwayat_medik][alergi][pilihan]"
                            value="Tidak Ada">
                        <label for="alergi_1" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label>
                        <input type="radio" id="alergi_2" name="fisik[riwayat_medik][alergi][pilihan]"
                            value="Ada">
                        <label for="alergi_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                        <input type="text" id="alergi_3" name="fisik[riwayat_medik][alergi][sebutkan]"
                            style="display:inline-block;" class="form-control" placeholder="Sebutkan">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">RIWAYAT MEDIS LAINNYA</td>
                    <td>
                        <input type="radio" id="medisLainnya_1" name="fisik[riwayat_medik][medisLainnya][pilihan]"
                            value="Tidak Ada">
                        <label for="medisLainnya_1" style="font-weight: normal; margin-right: 10px;">Tidak Ada</label>
                        <input type="radio" id="medisLainnya_2" name="fisik[riwayat_medik][medisLainnya][pilihan]"
                            value="Ada">
                        <label for="medisLainnya_2" style="font-weight: normal; margin-right: 10px;">Ada</label><br />
                        <input type="text" id="medisLainnya_3" name="fisik[riwayat_medik][medisLainnya][pilihanAda]"
                        style="display:inline-block;" class="form-control" placeholder="Jelaskan">
                    </td>
                </tr>
            </table>

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <h5><b>C. TANDA-TANDA VITAL</b></h5>
                <tr>
                    <td style="font-weight:500; width: 50%;">TEKANAN DARAH (MmHg)</td>
                    <td>
                        <input type="number" id="tekanan_darah1" name="fisik[tanda_vital][tekanan_darah1][sebutkan]"
                            placeholder="(MmHg)" style="display:inline-block; width: 100px;" class="form-control">
                        <span>/</span>
                        <input type="number" id="tekanan_darah2" name="fisik[tanda_vital][tekanan_darah2][sebutkan]"
                            placeholder="(MmHg)" style="display:inline-block; width: 100px;" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">NADI (X/M)</td>
                    <td>
                        <input type="number" id="nadi" name="fisik[tanda_vital][nadi][sebutkan]"
                            placeholder="(X/M)" style="display:inline-block; width: 100px;" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">SUHU (°C)</td>
                    <td>
                        <input type="number" id="temp" name="fisik[tanda_vital][temp][sebutkan]"
                            placeholder="(°C)" style="display:inline-block; width: 100px;" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">NAFAS (X/M)</td>
                    <td>
                        <input type="number" id="RR" name="fisik[tanda_vital][RR][sebutkan]" placeholder="(X/M)"
                            style="display:inline-block; width: 100px;" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">TINGGI BADAN (CM)</td>
                    <td>
                        <input type="number" id="TB" name="fisik[tanda_vital][TB][sebutkan]" placeholder="(CM)"
                            style="display:inline-block; width: 100px;" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">BERAT BADAN (KG)</td>
                    <td>
                        <input type="number" id="BB" name="fisik[tanda_vital][BB][sebutkan]" placeholder="(KG)"
                            style="display:inline-block; width: 100px;" class="form-control">
                    </td>
                </tr>
            </table>

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <h5><b>D. RIWAYAT KESEHATAN GIGI SAAT INI</b></h5>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <img src="/images/skalaNyeriFix.jpg" alt=""
                            style="width: 300px; height: 150px; padding-bottom: 10px;"><br />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>TGL</span>
                        <input type="date" id="tgl1" name="fisik[riwayatKesehatanGigi][tgl1]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Gigi</span>
                        <input type="text" id="gigi1" name="fisik[riwayatKesehatanGigi][gigi1]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Skala</span>
                        <input type="number" id="skala1" name="fisik[riwayatKesehatanGigi][skala1]"
                            style="display:inline-block; width: 80px;" class="form-control" placeholder="1-10">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>TGL</span>
                        <input type="date" id="tgl2" name="fisik[riwayatKesehatanGigi][tgl2]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Gigi</span>
                        <input type="text" id="gigi2" name="fisik[riwayatKesehatanGigi][gigi2]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Skala</span>
                        <input type="number" id="skala2" name="fisik[riwayatKesehatanGigi][skala2]"
                            style="display:inline-block; width: 80px;" class="form-control" placeholder="1-10">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>TGL</span>
                        <input type="date" id="tgl3" name="fisik[riwayatKesehatanGigi][tgl3]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Gigi</span>
                        <input type="text" id="gigi3" name="fisik[riwayatKesehatanGigi][gigi3]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Skala</span>
                        <input type="number" id="skala3" name="fisik[riwayatKesehatanGigi][skala3]"
                            style="display:inline-block; width: 80px;" class="form-control" placeholder="1-10">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>TGL</span>
                        <input type="date" id="tgl4" name="fisik[riwayatKesehatanGigi][tgl4]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Gigi</span>
                        <input type="text" id="gigi4" name="fisik[riwayatKesehatanGigi][gigi4]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Skala</span>
                        <input type="number" id="skala4" name="fisik[riwayatKesehatanGigi][skala4]"
                            style="display:inline-block; width: 80px;" class="form-control" placeholder="1-10">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>TGL</span>
                        <input type="date" id="tgl5" name="fisik[riwayatKesehatanGigi][tgl5]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Gigi</span>
                        <input type="text" id="gigi5" name="fisik[riwayatKesehatanGigi][gigi5]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Skala</span>
                        <input type="number" id="skala5" name="fisik[riwayatKesehatanGigi][skala5]"
                            style="display:inline-block; width: 80px;" class="form-control" placeholder="1-10">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>TGL</span>
                        <input type="date" id="tgl6" name="fisik[riwayatKesehatanGigi][tgl6]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Gigi</span>
                        <input type="text" id="gigi6" name="fisik[riwayatKesehatanGigi][gigi6]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Skala</span>
                        <input type="number" id="skala6" name="fisik[riwayatKesehatanGigi][skala6]"
                            style="display:inline-block; width: 80px;" class="form-control" placeholder="1-10">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>TGL</span>
                        <input type="date" id="tgl7" name="fisik[riwayatKesehatanGigi][tgl7]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Gigi</span>
                        <input type="text" id="gigi7" name="fisik[riwayatKesehatanGigi][gigi7]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Skala</span>
                        <input type="number" id="skala7" name="fisik[riwayatKesehatanGigi][skala7]"
                            style="display:inline-block; width: 80px;" class="form-control" placeholder="1-10">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>TGL</span>
                        <input type="date" id="tgl8" name="fisik[riwayatKesehatanGigi][tgl8]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Gigi</span>
                        <input type="text" id="gigi8" name="fisik[riwayatKesehatanGigi][gigi8]"
                            style="display:inline-block; width: 150px; margin-right: 10px;" class="form-control">
                        <span>Skala</span>
                        <input type="number" id="skala8" name="fisik[riwayatKesehatanGigi][skala8]"
                            style="display:inline-block; width: 80px;" class="form-control" placeholder="1-10">
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <h5><b>Asesmen Keperawatan</b></h5>
            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <h5><b>E. RIWAYAT GIGI SEBELUMNYA</b></h5>
                <tr>
                    <td style="font-weight:500; width: 50%;">APAKAH PASIEN SUDAH PERNAH MENDAPATKAN PERAWATAN GIGI
                        SEBELUMNYA : </td>
                    <td>
                        <input type="radio" id="perawatanGigi_1" name="fisik[riwayatGigi][perawatanGigi][pilihan]"
                            value="Tidak">
                        <label for="perawatanGigi_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                        <input type="radio" id="perawatanGigi_2" name="fisik[riwayatGigi][perawatanGigi][pilihan]"
                            value="Ya">
                        <label for="perawatanGigi_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">APAKAH PASIEN MENYIKAT GIGI 2 x SEHARI : </td>
                    <td>
                        <input type="radio" id="menyikat2x_1" name="fisik[riwayatGigi][menyikat2x][pilihan]"
                            value="Tidak">
                        <label for="menyikat2x_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                        <input type="radio" id="menyikat2x_2" name="fisik[riwayatGigi][menyikat2x][pilihan]"
                            value="Ya">
                        <label for="menyikat2x_2" style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">APAKAH PASIEN MENYIKAT GIGI SESUDAH MAKAN : </td>
                    <td>
                        <input type="radio" id="menyikatSesudahMakan_1"
                            name="fisik[riwayatGigi][menyikatSesudahMakan][pilihan]" value="Tidak">
                        <label for="menyikatSesudahMakan_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                        <input type="radio" id="menyikatSesudahMakan_2"
                            name="fisik[riwayatGigi][menyikatSesudahMakan][pilihan]" value="Ya">
                        <label for="menyikatSesudahMakan_2"
                            style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">APAKAH PASIEN MENYIKAT GIGI SEBELUM TIDUR : </td>
                    <td>
                        <input type="radio" id="menyikatSebelumTidur_1"
                            name="fisik[riwayatGigi][menyikatSebelumTidur][pilihan]" value="Tidak">
                        <label for="menyikatSebelumTidur_1" style="font-weight: normal; margin-right: 10px;">Tidak</label>
                        <input type="radio" id="menyikatSebelumTidur_2"
                            name="fisik[riwayatGigi][menyikatSebelumTidur][pilihan]" value="Ya">
                        <label for="menyikatSebelumTidur_2"
                            style="font-weight: normal; margin-right: 10px;">Ya</label><br />
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">BAGAIMANA CARA GERAKAN MENYIKAT GIGI : </td>
                    <td>
                        <input type="radio" id="gerakanMenyikatGigi_1"
                            name="fisik[riwayatGigi][gerakanMenyikatGigi][pilihan]" value="Memutar">
                        <label for="gerakanMenyikatGigi_1" style="font-weight: normal; margin-right: 10px;">Memutar</label>
                        <input type="radio" id="gerakanMenyikatGigi_2"
                            name="fisik[riwayatGigi][gerakanMenyikatGigi][pilihan]" value="Maju Mundur">
                        <label for="gerakanMenyikatGigi_2"
                            style="font-weight: normal; margin-right: 10px;">Maju Mundur</label><br />
                        <input type="radio" id="gerakanMenyikatGigi_3"
                            name="fisik[riwayatGigi][gerakanMenyikatGigi][pilihan]" value="Searah Tumbuh Gigi">
                        <label for="gerakanMenyikatGigi_3"
                            style="font-weight: normal; margin-right: 10px;">Searah Tumbuh Gigi</label><br />
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500; width: 50%;">APAKAH PASIEN MEMPUNYAI KEBIASAAN : </td>
                    <td>
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: 400;">
                            <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][minumKopi]"
                                type="hidden" value="" id="flexCheckDefault">
                                <b>Minum Kopi</b>
                                <div>
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][minumKopiYa]"
                                        type="checkbox" value="Minum Kopi" id="flexCheckDefault">
                                        Ya
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][minumKopiTidak]"
                                        type="checkbox" value="Minum Kopi" id="flexCheckDefault">
                                        Tidak
                                </div>
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: 400;">
                            <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][minumAlkohol]"
                                type="hidden" value="" id="flexCheckDefault">
                                <b>Minum Alkohol</b>
                                <div>
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][minumAlkoholYa]"
                                        type="checkbox" value="Minum Alkohol" id="flexCheckDefault">
                                        Ya
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][minumAlkoholTidak]"
                                        type="checkbox" value="Minum Alkohol" id="flexCheckDefault">
                                        Tidak
                                </div>
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: 400;">
                            <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][merokok]"
                                type="hidden" value="" id="flexCheckDefault">
                                <b>Merokok</b>
                                <div>
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][merokokYa]"
                                        type="checkbox" value="Merokok" id="flexCheckDefault">
                                        Ya
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][merokokTidak]"
                                        type="checkbox" value="Merokok" id="flexCheckDefault">
                                        Tidak
                                </div>
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: 400;">
                            <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][mengunyah1sisi]"
                                type="hidden" value="" id="flexCheckDefault">
                                <b>Mengunyah 1 Sisi</b>
                                <div>
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][mengunyah1sisiYa]"
                                        type="checkbox" value="Mengunyah 1 sisi" id="flexCheckDefault">
                                        Ya
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][mengunyah1sisiTidak]"
                                        type="checkbox" value="Mengunyah 1 sisi" id="flexCheckDefault">
                                        Tidak
                                </div>
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: 400;">
                            <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][menggigitPensil]"
                                type="hidden" value="" id="flexCheckDefault">
                                <b>Menggigit Pensil</b>
                                <div>
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][menggigitPensilYa]"
                                        type="checkbox" value="Menggigit Pensil" id="flexCheckDefault">
                                        Ya
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][menggigitPensilTidak]"
                                        type="checkbox" value="Menggigit Pensil" id="flexCheckDefault">
                                        Tidak
                                </div>
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: 400;">
                            <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][bruxism]"
                                type="hidden" value="" id="flexCheckDefault">
                                <b>Bruxism</b>
                                <div>
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][bruxismYa]"
                                        type="checkbox" value="BRUXISM" id="flexCheckDefault">
                                        Ya
                                    <input class="form-check-input" name="fisik[riwayatGigi][kebiasaan][bruxismTidak]"
                                        type="checkbox" value="BRUXISM" id="flexCheckDefault">
                                        Tidak
                                </div>
                        </label><br />
                    </td>
                </tr>
            </table>

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <h5><b>F. DIAGNOSA KEPERAWATAN GIGI DAN MULUT</b></h5>
                <tr>
                    <td>
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][1]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][1]" type="checkbox"
                                value="true" id="flexCheckDefault">
                            TIDAK TERPENUHINYA KEBUTUHAN AKAN BEBAS DARI RASA NYERI PADA LEHER DAN KEPALA
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][2]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][2]" type="checkbox"
                                value="true" id="flexCheckDefault">
                            TIDAK TERPENUHINYA KEBUTUHAN AKAN KESAN WAJAH YANG SEHAT
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][3]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][3]" type="checkbox"
                                value="true" id="flexCheckDefault">
                            TIDAK TERPENUHINYA INTEGRASI (KEBUTUHAN) JARINGAN KULIT, MUKOSA DAN MEMBRAN PADA LEHER DAN
                            KEPALA
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][4]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][4]" type="checkbox"
                                value="true" id="flexCheckDefault">
                            TIDAK TERPENUHINYA KEBUTUHAN PENGETAHUAN / PEMAHAMAN YANG BAIK TENTANG KESEHATAN GIGI DAN MULUT
                        </label><br />
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][5]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][5]" type="checkbox"
                                value="true" id="flexCheckDefault">
                            TIDAK TERPENUHINYA KEBUTUHAN AKAN BEBAS DARI MASALAH KECEMASAN / STREES
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][6]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][6]" type="checkbox"
                                value="true" id="flexCheckDefault">
                            TIDAK TERPENUHINYA TANGGUNG JAWAB AKAN KESEHATAN GIGI DAN MULUT SENDIRI
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][7]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][7]" type="checkbox"
                                value="true" id="flexCheckDefault">
                            TIDAK TERPENUHINYA KEBUTUHAN AKAN PERLINDUNGAN DARI RESIKO PENYAKIT GIGI DAN MULUT
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][8]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[diagnosaGigiMulut][8]" type="checkbox"
                                value="true" id="flexCheckDefault">
                            TIDAK TERPENUHINYA KONDISI BIOLOGIS GIGI DAN MULUT DENGAN BAIK
                        </label><br />
                    </td>
                </tr>
            </table>

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <h5><b>G. IMPLEMENTASI DAN EVALUASI KEPERAWATAN GIGI DAN MULUT</b></h5>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold;">
                        Perawatan Klinis
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">
                        KOLABORASI
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][1]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][1]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            Sp. BM
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][2]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][2]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            Sp. KG
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][3]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][3]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            Sp.Ortho
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][4]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][4]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            Sp. Prostho
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][5]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][5]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            Sp. KGA
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][6]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][6]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            Sp. Perio
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][7]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][kolaborasi][7]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            Drg
                        </label><br />
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">
                        INTERVENSI
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][1]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][1]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PREVENTIF PERAWATAN GIGI
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][2]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][2]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            DEBRIDEMENT
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][3]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][3]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            IRIGASI
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][4]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][4]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PERAWATAN LUKA
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][5]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][5]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            BUKA JAHITAN
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][6]" type="hidden"
                                value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][intervensi][6]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            Sp. BM
                        </label><br />
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">
                        KONSELING PERAWATAN GIGI
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][1]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][1]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PENKES HIGIENE RONGGA MULUT
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][2]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][2]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PENKES SELAMAT PERAWATAN GIGI
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][3]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][3]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PENKES PERAWATAN GIGI DI RUMAH
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][4]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][4]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PENKES DIET NUTRISI
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][5]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][5]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PENKES PRE OPERASI
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][6]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][konselingPerawatanGigi][6]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PENKES PASCA OPERASI
                        </label><br />
                    </td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">
                        EVALUASI
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][1]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][1]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            OHIS
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][2]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][2]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PENKES GIGI DAN MULUT
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][3]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][3]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PERAWATAN KLINIS
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][4]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][4]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            NYERI
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][5]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][5]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            GRANULASI
                        </label><br />
                        <label class="form-check-label" for="flexCheckDefault"
                            style="margin-right: 10px; font-weight: 400;">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][6]"
                                type="hidden" value="" id="flexCheckDefault">
                            <input class="form-check-input" name="fisik[evaluasiGigiMulut][evaluasi][6]"
                                type="checkbox" value="true" id="flexCheckDefault">
                            PASCA OPERASI
                        </label><br />
                    </td>
                </tr>
            </table>

            <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                style="font-size:12px;">
                <input type="hidden" name="fisik[perawat][tanggal]" value="{{ now() }}">
                <input type="hidden" name="fisik[perawat][nama]" value="{{ @Auth::user()->name }}">
                {{-- <input type="hidden" name="fisik[perawat][ttd]" value="{{ @Auth::user()->Pegawai->tanda_tangan }}"> --}}
            </table>

            <button class="btn btn-success pull-right" style="margin-bottom: 10px;">Simpan</button>
            </form>


        </div>
        <div class="col-md-12">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <a href="#askepCollapse" data-toggle="collapse">Asuhan Keperawatan</a>
                        </h4>
                    </div>
                    <div id="askepCollapse" class="panel-collapse collapse">
                        <div class="panel-body">
                            @if (substr($reg->status_reg, 0, 1) == 'J')
                                <form method="POST"
                                    action="{{ url('emr-soap/pemeriksaan/asuhanKeperawatan/' . $unit . '/' . $reg->id) }}"
                                    class="form-horizontal">
                                    {{ csrf_field() }}
                                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                                    {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                                    {!! Form::hidden('unit', $unit) !!}
                                    <br>
                                    <h4 style="text-align: center"><b>Asuhan Keperawatan</b></h4>

                                    @include('emr.modules.pemeriksaan.select-askep')

                                    <div style="text-align: right;">
                                        <button class="btn btn-success">Simpan Askep</button>
                                    </div>
                                </form>
                                @include('emr.modules.pemeriksaan.modal-tte-askep')
                            @elseif(substr($reg->status_reg, 0, 1) == 'I')
                                <h5><b>Diagnosa Keperawatan</b></h5>
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">

                                    <tr>
                                        <td>
                                            @if (@$diagnosis != null)
                                                @foreach (@$diagnosis as $diagnosa)
                                                    - {{ $diagnosa }} <br>
                                                @endforeach
                                            @else
                                                <i>Belum Ada Yang Dipilih</i>
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <h5><b>Intervensi</b></h5>
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <tr>
                                        <td>
                                            @if (@$siki != null)
                                                @foreach (@$siki as $siki)
                                                    * {{ $siki }} <br>
                                                @endforeach
                                            @else
                                                <i>Belum Ada Yang Dipilih</i>
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <h5><b>Implementasi</b></h5>
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <tr>
                                        <td>
                                            @if (@$implementasi != null)
                                                @foreach (@$implementasi as $i)
                                                    * {{ $i }} <br>
                                                @endforeach
                                            @else
                                                <i>Belum Ada Yang Dipilih</i>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
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

                    @if (count($riwayats_perawat) == 0)
                        <tr>
                            <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                        </tr>
                    @endif
                    @foreach ($riwayats_perawat as $riwayat)
                        <tr>
                            <td
                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                {{ Carbon\Carbon::parse($riwayat->registrasi->created_at)->format('d-m-Y H:i') }}
                            </td>
                            <td
                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                {{ baca_poli($riwayat->registrasi->poli_id) }}
                            </td>

                            <td
                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                    class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                <a href="{{ url('cetak-resume-medis-rencana-kontrol-gigi/pdf/' . @$riwayat->registrasi_id . '/' . @$riwayat->id) }}"
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
        @endif







        <br /><br />
    </div>
    </div>

    {{-- <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div> --}}
    {{-- </form> --}}

    {{-- Tambahan --}}
    @if (@$dataPegawai == '1')
        <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
            style="font-size:12px;">
            <h5><b>7. TINDAKAN</b></h5>
            <tr>
                <td style="padding: 5px;">
                    {!! Form::open(['method' => 'POST', 'route' => 'tindakan.save', 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('poli_id', $poli) !!}
                    {!! Form::hidden('jenis', $reg->jenis_pasien) !!}
                    {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                    {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
                    {!! Form::hidden('pelaksana', $reg->dokter_id) !!}
                    {!! Form::hidden('tanggal', Carbon\Carbon::now()->format('d-m-Y')) !!}
                    {!! Form::hidden('jumlah', 1) !!}
                    <select name="tarif_id[]" id="select2Multiple" class="form-control"
                        multiple="multiple"></select>
                    <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
                    <div class="form-group" style="margin-top: 10px;">
                        {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-9">
                            {!! Form::submit('Simpan Tindakan', [
                                'class' => 'btn btn-success btn-flat pull-right',
                                'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                            ]) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        </table>
    @endif
    {{-- End Tambahan --}}

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
        $(".date_tanpa_tanggal").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true
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

        $('#historiAskep').click(function(e) {
            var id = $(this).attr('data-pasienID');
            $('#showHistoriAskep').modal('show');
            $('#dataHistoriAskep').load("/emr-riwayat-askep/" + id);
        });
    </script>

    <script>
        $('.select2-diagnosis').select2({
            placeholder: "Pilih Diagnosa",
            allowClear: true,
            width: '85%'
        });
        $('.select2-pemeriksaanDalam').select2({
            placeholder: "Pilih Intervensi",
            allowClear: true
        });
        $('.select2-fungsional').select2({
            placeholder: "Pilih Impelemntasi",
            allowClear: true
        });

        $('#select2-diagnosis').change(function(e) {
            var intervensi = $('#select2-pemeriksaanDalam');
            var implementasi = $('#select2-fungsional');
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
