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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/gizi/' . $unit . '/' . $reg->id) }}"
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
                        <br>

                        {{-- Anamnesis --}}
                        @php
                            @$dataPegawai = Auth::user()->pegawai->kategori_pegawai;
                            if (!@$dataPegawai) {
                                @$dataPegawai = 1;
                            }
                        @endphp

                        @if (@$dataPegawai == '1')
                             {{-- History --}}
                             <div class="col-md-12">
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
                                                <td
                                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                    <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                                        class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                                    <a href="{{ url('cetak-resume-medis-rencana-kontrol-gizi/pdf/' . @$riwayat->registrasi_id . '/' . @$riwayat->id) }}"
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
                            <div class="col-md-6">
                                <h5><b>Asesmen</b></h5>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>1. ANAMNESIS</b></h5>
                                    <tr>
                                        <td style="width:20%;">A. Keluhan Utama</td>
                                        <td style="padding: 5px;">
                                            <textarea rows="4" name="fisik[anamnesa]" style="display:inline-block; resize: vertical;"
                                                placeholder="[Masukkan Keluhan Utama]" class="form-control">{{ @$assesment['anamnesa'] }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">B. Riwayat Penyakit Sekarang</td>
                                        <td style="padding: 5px;">
                                            <textarea rows="4" name="fisik[riwayatPenyakitSekarang]"
                                                style="display:inline-block; resize: vertical;"placeholder="[Masukkan Riwayat Penyakit Sekarang]"
                                                class="form-control">{{ @$assesment['riwayatPenyakitSekarang'] }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">C. Riwayat Penyakit Dahulu</td>
                                        <td style="padding: 5px;">
                                            <textarea rows="4" name="fisik[riwayatPenyakitDahulu]"
                                                style="display:inline-block; resize: vertical;"placeholder="[Masukkan Penyakit Dahulu]" class="form-control">{{ @$assesment['riwayatPenyakitDahulu'] }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">D. Pernah Dirawat</td>
                                        <td style="padding: 5px;">
                                            <div>
                                                <input type="radio" name="fisik[isPernahDirawat]" class=""
                                                    id="pernahDirawatYA" value="true"
                                                    {{ @$assesment['isPernahDirawat'] == 'true' ? 'checked' : '' }}
                                                    onchange="isPernahDirawatChange(this)">
                                                <label for="pernahDirawatYA" class="control-label"
                                                    style="margin-right: 10px">YA</label>

                                                <input type="radio" name="fisik[isPernahDirawat]" class=""
                                                    id="pernahDirawatTIDAK" value="false"
                                                    {{ @$assesment['isPernahDirawat'] == 'false' ? 'checked' : '' }}
                                                    onchange="isPernahDirawatChange(this)">
                                                <label for="pernahDirawatTIDAK" class="control-label">TIDAK</label>
                                            </div>
                                            <div style="margin-top: 10px;{{ @$assesment['isPernahDirawat'] == 'true' ? '' : 'display:none' }}"
                                                id="pernahDirawatInputGroup">
                                                <input type="text" name="fisik[pernahDirawat][waktu]"
                                                    class="form-control date_tanpa_tanggal"
                                                    value="{{ @$assesment['pernahDirawat']['waktu'] }}">
                                                <input type="text" name="fisik[pernahDirawat][lokasi]"
                                                    class="form-control"
                                                    value="{{ @$assesment['pernahDirawat']['lokasi'] }}"
                                                    placeholder="[Tempat/Lokasi]">
                                                <input type="text" name="fisik[pernahDirawat][diagnosa]"
                                                    class="form-control"
                                                    value="{{ @$assesment['pernahDirawat']['diagnosa'] }}"
                                                    placeholder="[Diagnosa]">
                                            </div>
                                            <script>
                                                function isPernahDirawatChange(el) {
                                                    if (el.value == 'true') {
                                                        document.getElementById('pernahDirawatInputGroup').style.display = 'block';
                                                    } else {
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
                                            <textarea rows="4" name="fisik[riwayatPenyakitKeluarga]"
                                                style="display:inline-block; resize: vertical;"placeholder="[Masukkan Penyakit Keluarga]" class="form-control">{{ @$assesment['riwayatPenyakitKeluarga'] }}</textarea>
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
                                    <h5><b>2. PEMERIKSAAN FISIK</b></h5>
                                    <div>
                                        <span style="font-weight: bold">Kesadaran: </span>
                                        <em>
                                            {{ @$assesment['tanda_vital']['kesadaran']['sebutkan'] ? @$assesment['tanda_vital']['kesadaran']['sebutkan'] : '-' }}
                                        </em>
                                    </div>
                                    <div>
                                        <span style="font-weight: bold">GCS: </span>
                                        E: {{ @$assesment['GCS']['E'] ? @$assesment['GCS']['E'] : '-' }}
                                        M: {{ @$assesment['GCS']['M'] ? @$assesment['GCS']['M'] : '-' }}
                                        V: {{ @$assesment['GCS']['V'] ? @$assesment['GCS']['V'] : '-' }}
                                        Total: {{ @$assesment['GCS']['Total'] ? @$assesment['GCS']['Total'] : '-' }}
                                        <br>

                                        <span style="font-weight: bold">Keadaan Umum: </span>
                                        {{ @$assesment['keadaan_umum'] ? @$assesment['keadaan_umum'] : '-' }}
                                        <br>

                                        <span style="font-weight: bold">Tanda Vital: </span> <br>
                                        <strong>Tekanan Darah:</strong>
                                        {{ @$assesment['tanda_vital']['tekanan_darah1']['sebutkan'] ? @$assesment['tanda_vital']['tekanan_darah1']['sebutkan'] : '-' }}/{{ @$assesment['tanda_vital']['tekanan_darah2']['sebutkan'] ? @$assesment['tanda_vital']['tekanan_darah2']['sebutkan'] : '-' }}
                                        MMHG <br>
                                        <strong>Nadi:</strong>
                                        {{ @$assesment['tanda_vital']['nadi']['sebutkan'] ? @$assesment['tanda_vital']['nadi']['sebutkan'] : '-' }}
                                        X/Menit  <br>
                                        <strong>Suhu:</strong>
                                        {{ @$assesment['tanda_vital']['temp']['sebutkan'] ? @$assesment['tanda_vital']['temp']['sebutkan'] : '-' }}
                                        oC <br>
                                        <strong>Nafas:</strong>
                                        {{ @$assesment['tanda_vital']['RR']['sebutkan'] ? @$assesment['tanda_vital']['RR']['sebutkan'] : '-' }}
                                        X/Menit <br>
                                        <strong>Tinggi Badan:</strong>
                                        {{ @$assesment['tanda_vital']['TB']['sebutkan'] ? @$assesment['tanda_vital']['TB']['sebutkan'] : '-' }}
                                        cm <br>
                                        <strong>Berat Badan:</strong>
                                        {{ @$assesment['tanda_vital']['BB']['sebutkan'] ? @$assesment['tanda_vital']['BB']['sebutkan'] : '-' }}
                                        Kg <br>
                                    </div>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" name="fisik[pemeriksaan_fisik]" style="display:inline-block; resize: vertical;"
                                                placeholder="[Masukkan Pemeriksaan Fisik]" class="form-control">{{ @$assesment['pemeriksaan_fisik'] }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <style>
                                                #tablePemeriksaanFisik, #tablePemeriksaanFisik th, #tablePemeriksaanFisik td {
                                                    border: 1px solid black;
                                                    padding: 5px
                                                }
                                            </style>
                                            <table style="width: 100%;" id="tablePemeriksaanFisik">
                                                {{--  PEMERIKSAAN FISIK--}}
                                                <tr>
                                                    <th style="width:40%;text-align:center" colspan="3">PEMERIKSAAN FISIK</th>
                                                </tr>

                                                <tr>
                                                    <th style="width:40%;text-align:center">INDIKATOR</th>
                                                    <th  style="width:50%;text-align:center">JAWABAN</th>
                                                    <th  style="width:10%;text-align:center">SKOR</th>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3"  style="width:40%">Kehilangan lemak subkutan ( trisep , bisep )</td>
                                                    <td  style="width:50%">Tidak ada ( A )</td>
                                                    <td  style="width:10%" rowspan="3">
                                                        <input type="text" name="fisik[lokalisGizi][6][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['6']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">
                                                        Salah satu tempat ( B )
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Salah satu tempat ( B )</td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="3"  style="width:40%">Kehilangan masa otot ( tulang selangka, scapula, belikat, tulang rusuk, betis )</td>
                                                    <td  style="width:50%">Tidak ada ( A )</td>
                                                    <td  style="width:10%" rowspan="3">
                                                        <input type="text" name="fisik[lokalisGizi][7][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['7']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">
                                                        Beberapa tempat ( B )
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Semua tempat ( B )</td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="3"  style="width:40%">Edema ( bisa ditanyakan ke perawat / dokter )</td>
                                                    <td  style="width:50%">Tidak ada / sedikit ( A )</td>
                                                    <td  style="width:10%" rowspan="3">
                                                        <input type="text" name="fisik[lokalisGizi][8][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['8']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%"> Sedang / tungkai ( B ) </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Berat / anaraksa ( C )</td>
                                                </tr>
                                                

                                                <tr>
                                                    <td rowspan="3"  style="width:40%">Asites ( bisa ditanyakan ke perawat / dokter )</td>
                                                    <td  style="width:50%">Tidak ada  ( A )</td>
                                                    <td  style="width:10%" rowspan="3">
                                                        <input type="text" name="fisik[lokalisGizi][9][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['9']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%"> Sedang ( B ) </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Berat ( C )</td>
                                                </tr>

                                                <tr>
                                                    <th style="width:40%;text-align:center" colspan="2">KESELURUHAN SKOR SGA </th>
                                                    <th style="width:40%;text-align:center">
                                                        <input type="text" name="fisik[lokalisGizi][skorKeseluruhan]" class="form-control" value="{{@$assesment['lokalisGizi']['skorKeseluruhan']}}" placeholder="[SKOR]">
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td colspan="3">
                                                        <ul>
                                                            <li>A	= Gizi baik / normal ( skor  “A“ pada ≥ 50% kategori atau ada peningkatan signifikan)</li>
                                                            <li>B	= Gizi kurang / sedang  ( skor  “B“ pada ≥ 50% kategori ) </li>
                                                            <li>C	= Gizi buruk ( skor  “C” pada ≥ 50% kategori,  tanda-tanda fisik signifikan )</li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>
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
                                
                            </div>

                            <div class="col-md-6">
                                <h5><b>Asesmen</b></h5>
                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5>
                                        <b>4. STATUS LOKALIS</b>
                                        @if (@$reg->poli_id == '3' || @$reg->poli_id == '34' || @$reg->poli_id == '4')
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
                                                <img src="/images/{{ @$gambar['image'] }}" id="dataImage"
                                                    style="width: 400px; height:auto;">
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
                                    <tr>
                                        <td style="padding: 5px;">
                                            <style>
                                                #tableLokalisGizi, #tableLokalisGizi th, #tableLokalisGizi td {
                                                    border: 1px solid black;
                                                    padding: 5px
                                                }
                                            </style>
                                            <table style="width: 100%;" id="tableLokalisGizi">
                                                <tr>
                                                    <th style="width:40%;text-align:center" colspan="3">RIWAYAT MEDIS</th>
                                                </tr>
                                                <tr>
                                                    <th style="width:40%;text-align:center">INDIKATOR</th>
                                                    <th  style="width:50%;text-align:center">JAWABAN</th>
                                                    <th  style="width:10%;text-align:center">SKOR</th>
                                                </tr>
                                                <tr>
                                                    <td rowspan="5"  style="width:40%">
                                                        Perubahan BB selama 6 bulan terakhir
                                                        <br>
                                                        <strong>(BB Biasanya - BB Awal Masuk) / BB Biasanya</strong>
                                                    </td>
                                                    <td  style="width:50%">Tidak ada ( A )</td>
                                                    <td  style="width:10%" rowspan="5">
                                                        <input type="text" name="fisik[lokalisGizi][1][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['1']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Ada perubahan, penurunan / peningkatan < 5% ( A )</td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Ada perubahan, penurunan / peningkatan 5-10% ( B )</td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Ada perubahan , penurunan / peningkatan > 10% ( B )</td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Tidak tahu ( tidak dinilai )</td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="4"  style="width:40%">Perubahan intake makan, perubahan dalam jumlah asupan akhir-akhir ini dibanding dengan kebiasaan</td>
                                                    <td  style="width:50%">Asupan cukup dan tidak ada peruban , kalaupun adahanya sedikit dan tidak dalam waktu singkat ( A )</td>
                                                    <td  style="width:10%" rowspan="4">
                                                        <input type="text" name="fisik[lokalisGizi][2][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['2']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Asupan menurun daripada sebelum sakit namun dalam tahap ringan ( B )</td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Asupan rendah tapi ada peningkatan ( B )</td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Asupan sangat tidak cukup dan menurun tahap berat daripada sebelumnya ( C )</td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="3"  style="width:40%">
                                                        Perubahan gastrointestinal
                                                        <br>
                                                        <div>
                                                            <label class="control-lable">Mual</label>
                                                            <input type="text" name="fisik[lokalisGizi][3][mual]" class="form-control" value="{{@$assesment['lokalisGizi']['3']['mual']}}" placeholder="[Mual]">

                                                            <label class="control-lable">Muntah</label>
                                                            <input type="text" name="fisik[lokalisGizi][3][muntah]" class="form-control" value="{{@$assesment['lokalisGizi']['3']['muntah']}}" placeholder="[Muntah]">

                                                            <label class="control-lable">Diare</label>
                                                            <input type="text" name="fisik[lokalisGizi][3][diare]" class="form-control" value="{{@$assesment['lokalisGizi']['3']['diare']}}" placeholder="[Diare]">

                                                            <label class="control-lable">Anoreksia</label>
                                                            <input type="text" name="fisik[lokalisGizi][3][anoreksia]" class="form-control" value="{{@$assesment['lokalisGizi']['3']['anoreksia']}}" placeholder="[Anoreksia]">
                                                        </div>
                                                    </td>
                                                    <td  style="width:50%">Jika ada beberapa gejala atau tidak ada gejala, sebentar-sebentar ( A )</td>
                                                    <td  style="width:10%" rowspan="3">
                                                        <input type="text" name="fisik[lokalisGizi][3][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['3']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Jika ada beberapa gejala > 2 minggu ( B )</td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Jika > 1 / semua gejala /teratur > 2 minggu ( C )</td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="3"  style="width:40%">Perubahan kapasitas fungsional </td>
                                                    <td  style="width:50%">Aktifitas normal, tidak ada kelainan, stamina tetap ( A )</td>
                                                    <td  style="width:10%" rowspan="3">
                                                        <input type="text" name="fisik[lokalisGizi][4][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['4']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Aktifitas ringan, mengalami sedikit penurunan ( B )</td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Tanpa aktifitas , di tempat tidur , penurunan stamina ( C )</td>
                                                </tr>



                                                <tr>
                                                    <td rowspan="3"  style="width:40%">Penyakit dan hubungan dengan kebutuhan gizi</td>
                                                    <td  style="width:50%">Tidak ada ( A )</td>
                                                    <td  style="width:10%" rowspan="3">
                                                        <input type="text" name="fisik[lokalisGizi][5][skor]" class="form-control" value="{{@$assesment['lokalisGizi']['5']['skor']}}" placeholder="[SKOR]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">
                                                        Ada <br>
                                                        1. Rendah, ( mis ; hernia, infeksi,penyakit jantung kongestif ) ( B ) <br>
                                                        2. Sedang , ( mis; DM, pneumonia ) ( B ) 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style="width:50%">Tinggi ( mis ; diare, kanker , peritonitis berat ) ( C )</td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>5. HASIL SKRINING</b></h5>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <input type="radio" id="hasilSkrining_1" name="fisik[hasilSkrining]" value="Gizi Baik"
                                                {{ @$assesment['hasilSkrining'] == 'Gizi Baik' ? 'checked' : '' }}>
                                            <label for="hasilSkrining_1"
                                                style="font-weight: normal; margin-right: 10px;">Gizi Baik</label>
                                            <input type="radio" id="hasilSkrining_2"
                                                name="fisik[hasilSkrining]" value="Beresiko malnutrisi / malnutrisi sedang"
                                                {{ @$assesment['hasilSkrining'] == 'Beresiko malnutrisi / malnutrisi sedang' ? 'checked' : '' }}>
                                            <label for="hasilSkrining_2"
                                                style="font-weight: normal; margin-right: 10px;">Beresiko malnutrisi / malnutrisi sedang </label>
                                            <input type="radio" id="hasilSkrining_3"
                                                name="fisik[hasilSkrining]" value="Malnutrisi berat"
                                                {{ @$assesment['hasilSkrining'] == 'Malnutrisi berat' ? 'checked' : '' }}>
                                            <label for="hasilSkrining_3"
                                                style="font-weight: normal; margin-right: 10px;">Malnutrisi berat</label><br />
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>6. TINDAK LANJUT SKRINING</b></h5>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <input type="checkbox" id="tindakLanjutSkrining_1" name="fisik[tindakLanjutSkrining][monitoring]" value="Monitoring umum"
                                                {{ @$assesment['tindakLanjutSkrining']['monitoring'] == 'Monitoring umum' ? 'checked' : '' }}>
                                            <label for="tindakLanjutSkrining_1"
                                                style="font-weight: normal; margin-right: 10px;">Monitoring umum</label>
                                            <input type="checkbox" id="tindakLanjutSkrining_2"
                                                name="fisik[tindakLanjutSkrining][konseling]" value="Konseling"
                                                {{ @$assesment['tindakLanjutSkrining']['konseling'] == 'Konseling' ? 'checked' : '' }}>
                                            <label for="tindakLanjutSkrining_2"
                                                style="font-weight: normal; margin-right: 10px;">Konseling </label>
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>7. KONSELING DAN EDUKASI GIZI</b></h5>
                                    <tr>
                                        <td style="width:20%;">A. Materi</td>
                                        <td style="padding: 5px;">
                                            <input type="text" name="fisik[edukasi][materi]"
                                                class="form-control" value="{{ @$assesment['edukasi']['materi'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">B. Leaflet yang diberikan</td>
                                        <td style="padding: 5px;">
                                            <input type="text" name="fisik[edukasi][leaflet]"
                                                class="form-control" value="{{ @$assesment['edukasi']['leaflet'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">C. Data penting terkait </td>
                                        <td style="padding: 5px;">
                                            <input type="text" name="fisik[edukasi][dataPenting]"
                                                class="form-control" value="{{ @$assesment['edukasi']['dataPenting'] }}">
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%"
                                    class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <h5><b>8. DIAGNOSIS</b></h5>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" name="fisik[diagnosis]" style="display:inline-block; resize: vertical;"
                                                placeholder="[Masukkan Diagnosis]" class="form-control">{{ @$assesment['diagnosis'] }}</textarea>
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
                                    <h5><b>9. PLANNING</b></h5>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <textarea rows="3" name="fisik[planning]" style="display:inline-block; resize: vertical;"
                                                placeholder="[Masukkan Planning]" class="form-control">{{ @$assesment['planning'] }}</textarea>
                                        </td>
                                    </tr>
                                </table>
                                
                                {{-- <table style="width: 100%"
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
                                            <input type="radio" id="rencanaRawat_1"
                                                name="fisik[dischargePlanning][rencanaLamaRawat][isDiTetapkan]"
                                                value="true"
                                                {{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isDiTetapkan'] == 'true' ? 'checked' : '' }}
                                                onchange="isRencanaRawatChange(this)">
                                            <label for="rencanaRawat_1"
                                                style="font-weight: normal; margin-right: 10px;">Sudah dapat
                                                ditetapkan</label>

                                            <input type="radio" id="rencanaRawat_2"
                                                name="fisik[dischargePlanning][rencanaLamaRawat][isDiTetapkan]"
                                                value="false"
                                                {{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isDiTetapkan'] == 'false' ? 'checked' : '' }}
                                                onchange="isRencanaRawatChange(this)">
                                            <label for="rencanaRawat_2"
                                                style="font-weight: normal; margin-right: 10px;">Belum Bisa
                                                Ditetapkan</label>
                                        </td>
                                        <script>
                                            function isRencanaRawatChange(el) {
                                                if (el.value == 'true') {
                                                    document.getElementById('sudahDitetapkan').style.display = 'block';
                                                    document.getElementById('belumDitetapkan').style.display = 'none';
                                                } else {
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
                                            <div id="sudahDitetapkan"
                                                style="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isDiTetapkan'] == 'true' ? 'display:block;' : 'display:none;' }}">
                                                <input type="number"
                                                    name="fisik[dischargePlanning][rencanaLamaRawat][hari]"
                                                    class="form-control"
                                                    value="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['hari'] }}"
                                                    placeholder="[Jumlah Hari]">
                                                <input type="text"
                                                    name="fisik[dischargePlanning][rencanaLamaRawat][tanggalPulang]"
                                                    class="form-control date_tanpa_tanggal"
                                                    placeholder="[Rencana Tanggal Pulang]"
                                                    value="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['tanggalPulang'] }}">
                                            </div>

                                            <div id="belumDitetapkan"
                                                style="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isDiTetapkan'] == 'true' ? 'display:none;' : 'display:block;' }}">
                                                <input type="text"
                                                    name="fisik[dischargePlanning][rencanaLamaRawat][alasan]"
                                                    class="form-control"
                                                    value="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['alasan'] }}"
                                                    placeholder="[Alasan]">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            Perawatan Lanjutan
                                        </td>
                                        <td>
                                            <input type="radio" id="perawatanLanjutan_1"
                                                name="fisik[dischargePlanning][rencanaLamaRawat][isPerawatanLanjutan]"
                                                value="true"
                                                {{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isPerawatanLanjutan'] == 'true' ? 'checked' : '' }}>
                                            <label for="perawatanLanjutan_1"
                                                style="font-weight: normal; margin-right: 10px;">YA</label>

                                            <input type="radio" id="perawatanLanjutan_2"
                                                name="fisik[dischargePlanning][rencanaLamaRawat][isPerawatanLanjutan]"
                                                value="false"
                                                {{ @$assesment['dischargePlanning']['rencanaLamaRawat']['isPerawatanLanjutan'] == 'false' ? 'checked' : '' }}>
                                            <label for="perawatanLanjutan_2"
                                                style="font-weight: normal; margin-right: 10px;">Tidak</label>

                                            <input type="text"
                                                name="fisik[dischargePlanning][rencanaLamaRawat][perawatanLanjutan]"
                                                class="form-control"
                                                value="{{ @$assesment['dischargePlanning']['rencanaLamaRawat']['perawatanLanjutan'] }}"
                                                placeholder="[Jika Ya, Jelaskan perawatan lanjutannya]">
                                        </td>
                                    </tr>
                                </table>
                                <button class="btn btn-success pull-right">Simpan</button>
                                <span style="color: red">Simpan terlebih dahulu sebelum melanjutkan!</span>
                            </div>
                        @else
                            {{-- Asesmen Perawat  --}}
                            <div class="col-md-6">
                                <h5><b>Asesmen</b></h5>
                                <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">Riwayat Alergi</td>
                                        <td>
                                            <div style="display: flex; gap: 10px">
                                                <div>
                                                    <input type="radio" id="riwayat_alergi1" name="fisik[riwayat_alergi][pilihan]"
                                                        value="Tidak"
                                                        {{ @$assesment['riwayat_alergi']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                                    <label for="riwayat_alergi1" style="font-weight: normal;">Tidak</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="riwayat_alergi2" name="fisik[riwayat_alergi][pilihan]"
                                                        value="Ya"
                                                        {{ @$assesment['riwayat_alergi']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                                                    <label for="riwayat_alergi2" style="font-weight: normal;">Ya</label><br>
                                                </div>
                                            </div>
                                            <input type="text" id="riwayat_alergi3" name="fisik[riwayat_alergi][sebutkan]"
                                                style="display:inline-block;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['riwayat_alergi']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">Keluhan Utama</td>
                                        <td>
                                            <textarea name="fisik[anamnesa]" id="" rows="2" style="resize: vertical; display: inline-block;"
                                                class="form-control">{{ @$assesment['anamnesa'] }}</textarea>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">1. Keadaan Umum</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="keadaan_umum1" name="fisik[keadaan_umum]"
                                                        value="Tampak Tidak Sakit"
                                                        {{ @$assesment['keadaan_umum'] == 'Tampak Tidak Sakit' ? 'checked' : '' }}>
                                                    <label for="keadaan_umum1" style="font-weight: normal;">Tampak Tidak Sakit</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="keadaan_umum2" name="fisik[keadaan_umum]" value="Sakit Ringan"
                                                        {{ @$assesment['keadaan_umum'] == 'Sakit Ringan' ? 'checked' : '' }}>
                                                    <label for="keadaan_umum2" style="font-weight: normal;">Sakit Ringan</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="keadaan_umum3" name="fisik[keadaan_umum]" value="Sakit Sedang"
                                                        {{ @$assesment['keadaan_umum'] == 'Sakit Sedang' ? 'checked' : '' }}>
                                                    <label for="keadaan_umum3" style="font-weight: normal;">Sakit Sedang</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="keadaan_umum4" name="fisik[keadaan_umum]" value="Sakit Berat"
                                                        {{ @$assesment['keadaan_umum'] == 'Sakit Berat' ? 'checked' : '' }}>
                                                    <label for="keadaan_umum4" style="font-weight: normal;">Sakit Berat</label><br>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">2. Kesadaran</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="kesadaran1" name="fisik[kesadaran]" value="Composmentis"
                                                        {{ @$assesment['kesadaran'] == 'Composmentis' ? 'checked' : '' }}>
                                                    <label for="kesadaran1" style="font-weight: normal;">Composmentis</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kesadaran2" name="fisik[kesadaran]" value="Apatis"
                                                        {{ @$assesment['kesadaran'] == 'Apatis' ? 'checked' : '' }}>
                                                    <label for="kesadaran2" style="font-weight: normal;">Apatis</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kesadaran3" name="fisik[kesadaran]" value="Somnolen"
                                                        {{ @$assesment['kesadaran'] == 'Somnolen' ? 'checked' : '' }}>
                                                    <label for="kesadaran3" style="font-weight: normal;">Somnolen</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kesadaran4" name="fisik[kesadaran]" value="Sopor"
                                                        {{ @$assesment['kesadaran'] == 'Sopor' ? 'checked' : '' }}>
                                                    <label for="kesadaran4" style="font-weight: normal;">Sopor</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kesadaran5" name="fisik[kesadaran]" value="Coma"
                                                        {{ @$assesment['kesadaran'] == 'Coma' ? 'checked' : '' }}>
                                                    <label for="kesadaran5" style="font-weight: normal;">Coma</label><br>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td rowspan="4" style="width:25%; font-weight:bold;">3. GCS</td>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="margin-right: 20px;">E</label>
                                            <input type="text" name="fisik[GCS][E]" style="display:inline-block; width: 100px;"
                                                placeholder="E" class="form-control gcs" id=""
                                                value="{{ @$assesment['GCS']['E'] }}">
                                        </td>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="margin-right: 20px;">M</label>
                                            <input type="text" name="fisik[GCS][M]" style="display:inline-block; width: 100px;"
                                                placeholder="M" class="form-control gcs" id=""
                                                value="{{ @$assesment['GCS']['M'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="margin-right: 20px;">V</label>
                                            <input type="text" name="fisik[GCS][V]" style="display:inline-block; width: 100px;"
                                                placeholder="V" class="form-control gcs" id=""
                                                value="{{ @$assesment['GCS']['V'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="margin-right: 20px;">Total</label>
                                            <input type="text" name="fisik[GCS][Total]" style="display:inline-block; width: 100px;"
                                                placeholder="Total" class="form-control" id="gcsScore" disabled value="0">
                                        </td>
                                    </tr>
                                    </tr>
                                    <script>
                                        let gcs = document.getElementsByClassName('gcs');
                                        let gcsScore = document.getElementById('gcsScore');
                                        gcs = Array.from(gcs);
                                        gcs.forEach(el => {
                                            el.addEventListener('input', function() {
                                                let gcsVal = 0;
                                                gcs.forEach(x => {
                                                    let val = parseInt(x.value)
                                                    if (isNaN(val)) {
                                                        val = 0;
                                                    }
                                                    gcsVal += val;
                                                })
                                                gcsScore.value = gcsVal;
                                            })
                                        });
                                    </script>
                    
                                    <tr>
                                        <td colspan="2" style="width:50%; font-weight:bold;">4. Tanda Vital</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="font-weight: normal;">TD (mmHG)</label><br />
                                            <input type="text" name="fisik[tanda_vital][tekanan_darah]"
                                                style="display:inline-block; width: 100%;" class="form-control" id=""
                                                value="{{ @$assesment['tanda_vital']['tekanan_darah'] }}">
                                        </td>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br />
                                            <input type="text" name="fisik[tanda_vital][nadi]" style="display:inline-block; width: 100%;"
                                                class="form-control" id="" value="{{ @$assesment['tanda_vital']['nadi'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="font-weight: normal;">RR (x/menit)</label><br />
                                            <input type="text" name="fisik[tanda_vital][RR]" style="display:inline-block; width: 100%;"
                                                class="form-control" id="" value="{{ @$assesment['tanda_vital']['RR'] }}">
                                        </td>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="font-weight: normal;"> Temp (°C)</label><br />
                                            <input type="text" name="fisik[tanda_vital][temp]" style="display:inline-block; width: 100%;"
                                                class="form-control" id="" value="{{ @$assesment['tanda_vital']['temp'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="font-weight: normal;">Berat Badan (kg)</label><br />
                                            <input type="text" name="fisik[tanda_vital][BB]" style="display:inline-block; width: 100%;"
                                                class="form-control" id="" value="{{ @$assesment['tanda_vital']['BB'] }}">
                                        </td>
                                        <td style="padding: 5px;">
                                            <label class="form-check-label" style="font-weight: normal;">Tinggi Badan (Cm)</label><br />
                                            <input type="text" name="fisik[tanda_vital][TB]" style="display:inline-block; width: 100%;"
                                                class="form-control" id="" value="{{ @$assesment['tanda_vital']['TB'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">5. Assesmen Nyeri</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="radio" id="nyeri_1" name="fisik[nyeri][pilihan]" value="Tidak"
                                                {{ @$assesment['nyeri']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                            <label for="nyeri_1" style="font-weight: normal;">Tidak</label><br>
                                        </td>
                                        <td>
                                            <input type="radio" id="nyeri_2" name="fisik[nyeri][pilihan]" value="Ada"
                                                {{ @$assesment['nyeri']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                                            <label for="nyeri_2" style="font-weight: normal;">Ada (Lanjut Ke Deskripsi Nyeri)</label><br>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">- Provokatif</td>
                                        <td>
                                            <input type="radio" id="provokatif_1" name="fisik[nyeri][provokatif][pilihan]"
                                                value="Benturan"
                                                {{ @$assesment['nyeri']['provokatif']['pilihan'] == 'Benturan' ? 'checked' : '' }}>
                                            <label for="provokatif_1" style="font-weight: normal;">Benturan</label>
                                            <input type="radio" id="provokatif_2" name="fisik[nyeri][provokatif][pilihan]" value="Spontan"
                                                {{ @$assesment['nyeri']['provokatif']['pilihan'] == 'Spontan' ? 'checked' : '' }}>
                                            <label for="provokatif_2" style="font-weight: normal;">Spontan</label>
                                            <input type="radio" id="provokatif_3" name="fisik[nyeri][provokatif][pilihan]"
                                                value="Lain-Lain"
                                                {{ @$assesment['nyeri']['provokatif']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                            <label for="provokatif_3" style="font-weight: normal;">Lain-Lain</label>
                                            <input type="text" id="provokatif_4" name="fisik[nyeri][provokatif][sebutkan]"
                                                style="display:inline-block;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['nyeri']['provokatif']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">- Quality</td>
                                        <td>
                                            <div style="display: flex; gap:10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="quality_1" name="fisik[nyeri][quality][pilihan]"
                                                        value="Seperti Tertusuk"
                                                        {{ @$assesment['nyeri']['quality']['pilihan'] == 'Seperti Tertusuk' ? 'checked' : '' }}>
                                                    <label for="quality_1" style="font-weight: normal;">Seperti Tertusuk Benda
                                                        Tajam/Tumpul</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="quality_2" name="fisik[nyeri][quality][pilihan]"
                                                        value="Berdenyut"
                                                        {{ @$assesment['nyeri']['quality']['pilihan'] == 'Berdenyut' ? 'checked' : '' }}>
                                                    <label for="quality_2" style="font-weight: normal;">Berdenyut</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="quality_3" name="fisik[nyeri][quality][pilihan]"
                                                        value="Terbakar"
                                                        {{ @$assesment['nyeri']['quality']['pilihan'] == 'Terbakar' ? 'checked' : '' }}>
                                                    <label for="quality_3" style="font-weight: normal;">Terbakar</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="quality_4" name="fisik[nyeri][quality][pilihan]"
                                                        value="Teriris"
                                                        {{ @$assesment['nyeri']['quality']['pilihan'] == 'Teriris' ? 'checked' : '' }}>
                                                    <label for="quality_4" style="font-weight: normal;">Teriris</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="quality_5" name="fisik[nyeri][quality][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['nyeri']['quality']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="quality_5" style="font-weight: normal;">Lain-Lain</label><br />
                                                </div>
                                            </div>
                                            <input type="text" id="quality_6" name="fisik[nyeri][quality][sebutkan]"
                                                style="display:inline-block;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['nyeri']['quality']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">- Region</td>
                                        <td>
                                            <label class="form-check-label" style="font-weight: normal;">Terlokalisir di</label><br />
                                            <input type="text" name="fisik[nyeri][region][terlokalisir]"
                                                style="display:inline-block; width: 100%;" class="form-control" id=""
                                                value="{{ @$assesment['nyeri']['region']['terlokalisir'] }}"><br />
                                            <label class="form-check-label" style="font-weight: normal;">Menyebar ke</label><br />
                                            <input type="text" name="fisik[nyeri][region][menyebar]"
                                                style="display:inline-block; width: 100%;" class="form-control" id=""
                                                value="{{ @$assesment['nyeri']['region']['menyebar'] }}"><br />
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td colspan="2" style="text-align:center; font-weight:bold;">
                                            <p style="text-align: left;">- Severity</p>
                                            <img src="/images/skalaNyeriFix.jpg" alt=""
                                                style="width: 300px; height: 150px; padding-bottom: 10px;"><br />
                                            <input type="radio" id="severity_1" name="fisik[nyeri][severity][pilihan]" value="0"
                                                {{ @$assesment['nyeri']['severity']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="severity_1" style="font-weight: normal;">0</label>
                                            <input type="radio" id="severity_2" name="fisik[nyeri][severity][pilihan]" value="1-3"
                                                style="margin-left: 25px;"
                                                {{ @$assesment['nyeri']['severity']['pilihan'] == '1-3' ? 'checked' : '' }}>
                                            <label for="severity_2" style="font-weight: normal;">1-3</label>
                                            <input type="radio" id="severity_3" name="fisik[nyeri][severity][pilihan]" value="4-6"
                                                style="margin-left: 25px;"
                                                {{ @$assesment['nyeri']['severity']['pilihan'] == '4-6' ? 'checked' : '' }}>
                                            <label for="severity_3" style="font-weight: normal;">4-6</label>
                                            <input type="radio" id="severity_4" name="fisik[nyeri][severity][pilihan]" value="7-9"
                                                style="margin-left: 25px;"
                                                {{ @$assesment['nyeri']['severity']['pilihan'] == '7-9' ? 'checked' : '' }}>
                                            <label for="severity_4" style="font-weight: normal;">7-9</label>
                                            <input type="radio" id="severity_5" name="fisik[nyeri][severity][pilihan]" value="10"
                                                style="margin-left: 25px;"
                                                {{ @$assesment['nyeri']['severity']['pilihan'] == '10' ? 'checked' : '' }}>
                                            <label for="severity_5" style="font-weight: normal;">10</label>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">- Time / Durasi (Menit)</td>
                                        <td>
                                            <input type="number" name="fisik[nyeri][durasi]" style="display:inline-block; width: 100%;"
                                                class="form-control" id="" value="{{ @$assesment['nyeri']['durasi'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:bold;">- Nyeri Hilang Jika</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="nyeri_hilang_1" name="fisik[nyeri][nyeri_hilang][pilihan]"
                                                        value="Minum Obat"
                                                        {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Minum Obat' ? 'checked' : '' }}>
                                                    <label for="nyeri_hilang_1" style="font-weight: normal;">Minum Obat</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="nyeri_hilang_2" name="fisik[nyeri][nyeri_hilang][pilihan]"
                                                        value="Istirahat"
                                                        {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Istirahat' ? 'checked' : '' }}>
                                                    <label for="nyeri_hilang_2" style="font-weight: normal;">Istirahat</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="nyeri_hilang_3" name="fisik[nyeri][nyeri_hilang][pilihan]"
                                                        value="Berubah Posisi"
                                                        {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Berubah Posisi' ? 'checked' : '' }}>
                                                    <label for="nyeri_hilang_3" style="font-weight: normal;">Berubah Posisi</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="nyeri_hilang_4" name="fisik[nyeri][nyeri_hilang][pilihan]"
                                                        value="Mendengarkan Musik"
                                                        {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Mendengarkan Musik' ? 'checked' : '' }}>
                                                    <label for="nyeri_hilang_4" style="font-weight: normal;">Mendengarkan Musik</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="nyeri_hilang_5" name="fisik[nyeri][nyeri_hilang][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['nyeri']['nyeri_hilang']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="nyeri_hilang_5" style="font-weight: normal;">Lain-Lain</label><br />
                                                </div>
                                            </div>
                                            <input type="text" id="nyeri_hilang_6" name="fisik[nyeri][nyeri_hilang][sebutkan]"
                                                style="display:inline-block;" class="form-control" placeholder="Sebutkan"
                                                {{ @$assesment['nyeri']['nyeri_hilang']['sebutkan'] }}>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">6. Risiko Jatuh</td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Apakah ada riwayat jatuh dalam waktu 3 bulan sebab apapun</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input class="hitungResiko" type="radio" id="riwayatJatuh_1"
                                                        name="fisik[risikoJatuh][riwayatJatuh][pilihan]" value="25"
                                                        {{ @$assesment['risikoJatuh']['riwayatJatuh']['pilihan'] == '25' ? 'checked' : '' }}>
                                                    <label for="riwayatJatuh_1" style="font-weight: normal;">Ya <b>(25 Skor)</b></label><br />
                                                </div>
                                                <div>
                                                    <input class="hitungResiko" type="radio" id="riwayatJatuh_2"
                                                        name="fisik[risikoJatuh][riwayatJatuh][pilihan]" value="0"
                                                        {{ @$assesment['risikoJatuh']['riwayatJatuh']['pilihan'] == '0' ? 'checked' : '' }}>
                                                    <label for="riwayatJatuh_2" style="font-weight: normal;">Tidak <b>(0
                                                            Skor)</b></label><br />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Diagnosis sekunder : Apakah memiliki lebih dari satu penyakit
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input class="hitungResiko" type="radio" id="diagnosisSekunder_1"
                                                        name="fisik[risikoJatuh][diagnosisSekunder][pilihan]" value="15"
                                                        {{ @$assesment['risikoJatuh']['diagnosisSekunder']['pilihan'] == '15' ? 'checked' : '' }}>
                                                    <label for="diagnosisSekunder_1" style="font-weight: normal;">Ya <b>(15
                                                            Skor)</b></label><br />
                                                </div>
                                                <div>
                                                    <input class="hitungResiko" type="radio" id="diagnosisSekunder_2"
                                                        name="fisik[risikoJatuh][diagnosisSekunder][pilihan]" value="0"
                                                        {{ @$assesment['risikoJatuh']['diagnosisSekunder']['pilihan'] == '0' ? 'checked' : '' }}>
                                                    <label for="diagnosisSekunder_2" style="font-weight: normal;">Tidak <b>(0
                                                            Skor)</b></label><br />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Alat bantu berjalan</td>
                                        <td>
                                            <input class="hitungResiko" type="radio" id="alatBantu_1"
                                                name="fisik[risikoJatuh][alatBantu][pilihan]" value="0"
                                                {{ @$assesment['risikoJatuh']['alatBantu']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="alatBantu_1" style="font-weight: normal;">Dibantu perawat/tidak menggunakan alat
                                                bantu/bed rest <b>(0 Skor)</b></label><br />
                                            <input class="hitungResiko" type="radio" id="alatBantu_2"
                                                name="fisik[risikoJatuh][alatBantu][pilihan]" value="15"
                                                {{ @$assesment['risikoJatuh']['alatBantu']['pilihan'] == '15' ? 'checked' : '' }}>
                                            <label for="alatBantu_2" style="font-weight: normal;">Menggunakan alat bantu : kruk/tongka, kursi
                                                roda <b>(15 Skor)</b></label><br />
                                            <input class="hitungResiko" type="radio" id="alatBantu_3"
                                                name="fisik[risikoJatuh][alatBantu][pilihan]" value="30"
                                                {{ @$assesment['risikoJatuh']['alatBantu']['pilihan'] == '30' ? 'checked' : '' }}>
                                            <label for="alatBantu_3" style="font-weight: normal;">Merambat dengan berpegangan pada benda di
                                                sekitar (meja, kursi, lemari, dll) <b>(30 Skor)</b></label><br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Apakah terpasang infus/pemberian anti koagulan (heparin)/obat
                                            lain yang mempunyai efek samping risiko jatuh</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input class="hitungResiko" type="radio" id="efekSamping_1"
                                                        name="fisik[risikoJatuh][efekSamping][pilihan]" value="20"
                                                        {{ @$assesment['risikoJatuh']['efekSamping']['pilihan'] == '20' ? 'checked' : '' }}>
                                                    <label for="efekSamping_1" style="font-weight: normal;">Ya <b>(20 Skor)</b></label><br />
                                                </div>
                                                <div>
                                                    <input class="hitungResiko" type="radio" id="efekSamping_2"
                                                        name="fisik[risikoJatuh][efekSamping][pilihan]" value="0"
                                                        {{ @$assesment['risikoJatuh']['efekSamping']['pilihan'] == '0' ? 'checked' : '' }}>
                                                    <label for="efekSamping_2" style="font-weight: normal;">Tidak <b>(0
                                                            Skor)</b></label><br />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Kondisi untuk melakukan gerakan berpindah / mobilisasi</td>
                                        <td>
                                            <input class="hitungResiko" type="radio" id="mobilisasi_1"
                                                name="fisik[risikoJatuh][mobilisasi][pilihan]" value="0"
                                                {{ @$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="mobilisasi_1" style="font-weight: normal;">Normal/bed rest/Imobilisasi <b>(0
                                                    Skor)</b></label><br />
                                            <input class="hitungResiko" type="radio" id="mobilisasi_2"
                                                name="fisik[risikoJatuh][mobilisasi][pilihan]" value="15"
                                                {{ @$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '15' ? 'checked' : '' }}>
                                            <label for="mobilisasi_2" style="font-weight: normal;">Lemah (tidak bertenaga) <b>(15
                                                    Skor)</b></label><br />
                                            <input class="hitungResiko" type="radio" id="mobilisasi_3"
                                                name="fisik[risikoJatuh][mobilisasi][pilihan]" value="30"
                                                {{ @$assesment['risikoJatuh']['mobilisasi']['pilihan'] == '30' ? 'checked' : '' }}>
                                            <label for="mobilisasi_3" style="font-weight: normal;">Ada keterbatasan berjalan (pincang,
                                                diseret) <b>(30 Skor)</b></label><br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Bagaimana Status Mental</td>
                                        <td>
                                            <input class="hitungResiko" type="radio" id="statusMental_1"
                                                name="fisik[risikoJatuh][statusMental][pilihan]" value="0"
                                                {{ @$assesment['risikoJatuh']['statusMental']['pilihan'] == '0' ? 'checked' : '' }}>
                                            <label for="statusMental_1" style="font-weight: normal;">Menyadari kelemahannya <b>(0
                                                    Skor)</b></label><br />
                                            <input class="hitungResiko" type="radio" id="statusMental_2"
                                                name="fisik[risikoJatuh][statusMental][pilihan]" value="15"
                                                {{ @$assesment['risikoJatuh']['statusMental']['pilihan'] == '15' ? 'checked' : '' }}>
                                            <label for="statusMental_2" style="font-weight: normal;">Tidak menyadari kelemahannya <b>(15
                                                    Skor)</b></label><br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">JUMLAH SKOR</td>
                                        <td>
                                            <input type="number" name="fisik[risikoJatuh][jumlahSkor][angka]"
                                                style="display:inline-block; width: 100%;" class="form-control jumlahSkorResiko"
                                                id="" value="{{ @$assesment['risikoJatuh']['jumlahSkor']['angka'] }}" readonly>
                                            <br><br>
                                            <input type="text" name="fisik[risikoJatuh][jumlahSkor][hasil]"
                                                style="display:inline-block; width: 100%;" class="form-control hasilSkorResiko"
                                                id="" value="{{ @$assesment['risikoJatuh']['jumlahSkor']['hasil'] }}" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">7. Fungsional</td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Alat Bantu</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="alatBantu_1" name="fisik[fungsional][alatBantu][pilihan]"
                                                        value="Ya"
                                                        {{ @$assesment['fungsional']['alatBantu']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                                                    <label for="alatBantu_1" style="font-weight: normal;">Ya</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="alatBantu_2" name="fisik[fungsional][alatBantu][pilihan]"
                                                        value="Tidak"
                                                        {{ @$assesment['fungsional']['alatBantu']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                                    <label for="alatBantu_2" style="font-weight: normal;">Tidak</label><br />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Protesa</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="protesa_1" name="fisik[fungsional][protesa][pilihan]"
                                                        value="Ya"
                                                        {{ @$assesment['fungsional']['protesa']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                                                    <label for="protesa_1" style="font-weight: normal;">Ya</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="protesa_2" name="fisik[fungsional][protesa][pilihan]"
                                                        value="Tidak"
                                                        {{ @$assesment['fungsional']['protesa']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                                    <label for="protesa_2" style="font-weight: normal;">Tidak</label><br />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Cacat Tubuh</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="cacatTubuh_1" name="fisik[fungsional][cacatTubuh][pilihan]"
                                                        value="Ya"
                                                        {{ @$assesment['fungsional']['cacatTubuh']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                                                    <label for="cacatTubuh_1" style="font-weight: normal;">Ya</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="cacatTubuh_2" name="fisik[fungsional][cacatTubuh][pilihan]"
                                                        value="Tidak"
                                                        {{ @$assesment['fungsional']['cacatTubuh']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                                    <label for="cacatTubuh_2" style="font-weight: normal;">Tidak</label><br />
                                                </div>
                                            </div>
                    
                    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Activity of Daily Living (ADL)</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="adl_1" name="fisik[fungsional][adl][pilihan]"
                                                        value="Mandiri"
                                                        {{ @$assesment['fungsional']['adl']['pilihan'] == 'Mandiri' ? 'checked' : '' }}>
                                                    <label for="adl_1" style="font-weight: normal;">Mandiri</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="adl_2" name="fisik[fungsional][adl][pilihan]"
                                                        value="Dibantu"
                                                        {{ @$assesment['fungsional']['adl']['pilihan'] == 'Dibantu' ? 'checked' : '' }}>
                                                    <label for="adl_2" style="font-weight: normal;">Dibantu</label><br />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">PEMERIKSAAN FISIK</td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Pernyarafan</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="pernyarafan_1"
                                                        name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['pernyarafan']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="pernyarafan_1" style="font-weight: normal;">Tidak ada keluhan</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernyarafan_2"
                                                        name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Tremor"
                                                        {{ @$assesment['pemeriksaanFisik']['pernyarafan']['pilihan'] == 'Tremor' ? 'checked' : '' }}>
                                                    <label for="pernyarafan_2" style="font-weight: normal;">Tremor</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernyarafan_3"
                                                        name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Hemiparase"
                                                        {{ @$assesment['pemeriksaanFisik']['pernyarafan']['pilihan'] == 'Hemiparase' ? 'checked' : '' }}>
                                                    <label for="pernyarafan_3"
                                                        style="font-weight: normal;">Hemiparase/Hemiplegia</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernyarafan_4"
                                                        name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="ROM"
                                                        {{ @$assesment['pemeriksaanFisik']['pernyarafan']['pilihan'] == 'ROM' ? 'checked' : '' }}>
                                                    <label for="pernyarafan_4" style="font-weight: normal;">ROM</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernyarafan_5"
                                                        name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Paralise"
                                                        {{ @$assesment['pemeriksaanFisik']['pernyarafan']['pilihan'] == 'Paralise' ? 'checked' : '' }}>
                                                    <label for="pernyarafan_5" style="font-weight: normal;">Paralise</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernyarafan_6"
                                                        name="fisik[pemeriksaanFisik][pernyarafan][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['pernyarafan']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="pernyarafan_6" style="font-weight: normal;">Lain-Lain</label><br />
                                                </div>
                                            </div>
                                            <input type="text" id="pernyarafan_7" name="fisik[pemeriksaanFisik][pernyarafan][sebutkan]"
                                                style="display:inline-block;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['pernyarafan']['sebutkan'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Pernapasan</td>
                                        <td>
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="pernapasan_1"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="pernapasan_1" style="font-weight: normal;">Tidak ada keluhan</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_2"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Sekret"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Sekret' ? 'checked' : '' }}>
                                                    <label for="pernapasan_2" style="font-weight: normal;">Sekret (+)</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_3"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Vesikular"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Vesikular' ? 'checked' : '' }}>
                                                    <label for="pernapasan_3" style="font-weight: normal;">Vesikular</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_4"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Ronchi"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Ronchi' ? 'checked' : '' }}>
                                                    <label for="pernapasan_4" style="font-weight: normal;">Ronchi</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_5"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Wheezing"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Wheezing' ? 'checked' : '' }}>
                                                    <label for="pernapasan_5" style="font-weight: normal;">Wheezing</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_6"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Menggunakan Otot Bantu"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Menggunakan Otot Bantu' ? 'checked' : '' }}>
                                                    <label for="pernapasan_6" style="font-weight: normal;">Menggunakan Otot
                                                        Bantu</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_7"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Retraksi Dada"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Retraksi Dada' ? 'checked' : '' }}>
                                                    <label for="pernapasan_7" style="font-weight: normal;">Retraksi Dada / Inter
                                                        Costa</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_8"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Pernapasan Dada"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Pernapasan Dada' ? 'checked' : '' }}>
                                                    <label for="pernapasan_8" style="font-weight: normal;">Pernapasan Dada</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_9"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Pernapasan Perut"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Pernapasan Perut' ? 'checked' : '' }}>
                                                    <label for="pernapasan_9" style="font-weight: normal;">Pernapasan Perut</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pernapasan_10"
                                                        name="fisik[pemeriksaanFisik][pernapasan][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['pernapasan']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="pernapasan_10" style="font-weight: normal;">Lain-Lain</label><br />
                                                </div>
                                            </div>
                                            <input type="text" id="pernapasan_11" name="fisik[pemeriksaanFisik][pernapasan][sebutkan]"
                                                style="display:inline-block;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['pernapasan']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                </table>
                            </div>
                    
                            <div class="col-md-6">
                                <h5><b>Asesmen</b></h5>
                                <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Kardiovaskuler</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_1"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_2"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Oedema"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'Oedema' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_2"
                                                        style="font-weight: normal; margin-right: 10px;">Oedema</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_3"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Murmur"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'Murmur' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_3"
                                                        style="font-weight: normal; margin-right: 10px;">Murmur</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_4"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Chest Pain"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'Chest Pain' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_4" style="font-weight: normal; margin-right: 10px;">Chest
                                                        Pain</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_5"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Reguler"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'Reguler' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_5"
                                                        style="font-weight: normal; margin-right: 10px;">Reguler</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_6"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Ireguler"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'Ireguler' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_6"
                                                        style="font-weight: normal; margin-right: 10px;">Ireguler</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_7"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Gallop"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'Gallop' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_7"
                                                        style="font-weight: normal; margin-right: 10px;">Gallop</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_8"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="CRT < 2"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'CRT < 2' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_8" style="font-weight: normal; margin-right: 10px;">CRT <
                                                            2</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_9"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="CRT > 2"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'CRT > 2' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_9" style="font-weight: normal; margin-right: 10px;">CRT >
                                                        2</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="kardiovaskuler_10"
                                                        name="fisik[pemeriksaanFisik][kardiovaskuler][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="kardiovaskuler_10"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="kardiovaskuler_11"
                                                name="fisik[pemeriksaanFisik][kardiovaskuler][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['kardiovaskuler']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Pencernaan</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="pencernaan_1"
                                                        name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="pencernaan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="pencernaan_2"
                                                        name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="konstipasi"
                                                        {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan'] == 'Konstipasi' ? 'checked' : '' }}>
                                                    <label for="pencernaan_2"
                                                        style="font-weight: normal; margin-right: 10px;">konstipasi</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="pencernaan_3"
                                                        name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Diare"
                                                        {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan'] == 'Diare' ? 'checked' : '' }}>
                                                    <label for="pencernaan_3"
                                                        style="font-weight: normal; margin-right: 10px;">Diare</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pencernaan_4"
                                                        name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Mual"
                                                        {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan'] == 'Mual' ? 'checked' : '' }}>
                                                    <label for="pencernaan_4" style="font-weight: normal; margin-right: 10px;">Mual /
                                                        Muntah</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="pencernaan_5"
                                                        name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Anoreksia"
                                                        {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan'] == 'Anoreksia' ? 'checked' : '' }}>
                                                    <label for="pencernaan_5"
                                                        style="font-weight: normal; margin-right: 10px;">Anoreksia</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="pencernaan_6"
                                                        name="fisik[pemeriksaanFisik][pencernaan][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['pencernaan']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="pencernaan_6"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="pencernaan_7" name="fisik[pemeriksaanFisik][pencernaan][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['pencernaan']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Endokrin</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="endokrin_1"
                                                        name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="endokrin_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="endokrin_2"
                                                        name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Pembesaran Kelenjar"
                                                        {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan'] == 'Pembesaran Kelenjar' ? 'checked' : '' }}>
                                                    <label for="endokrin_2" style="font-weight: normal; margin-right: 10px;">Pembesaran
                                                        Kelenjar</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="endokrin_3"
                                                        name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Tiroid"
                                                        {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan'] == 'Tiroid' ? 'checked' : '' }}>
                                                    <label for="endokrin_3" style="font-weight: normal; margin-right: 10px;">Tiroid</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="endokrin_4"
                                                        name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Keringat"
                                                        {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan'] == 'Keringat' ? 'checked' : '' }}>
                                                    <label for="endokrin_4" style="font-weight: normal; margin-right: 10px;">Keringat
                                                        Banyak</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="endokrin_5"
                                                        name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Napas Bau"
                                                        {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan'] == 'Napas Bau' ? 'checked' : '' }}>
                                                    <label for="endokrin_5" style="font-weight: normal; margin-right: 10px;">Napas
                                                        Bau</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="endokrin_6"
                                                        name="fisik[pemeriksaanFisik][endokrin][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['endokrin']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="endokrin_6"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                    
                                            </div>
                                            <input type="text" id="endokrin_7" name="fisik[pemeriksaanFisik][endokrin][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['endokrin']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Reproduksi</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="reproduksi_1"
                                                        name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="reproduksi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="reproduksi_2"
                                                        name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Keputihan"
                                                        {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan'] == 'Keputihan' ? 'checked' : '' }}>
                                                    <label for="reproduksi_2"
                                                        style="font-weight: normal; margin-right: 10px;">Keputihan</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="reproduksi_3"
                                                        name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Haid Tidak Teratur"
                                                        {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan'] == 'Haid Tidak Teratur' ? 'checked' : '' }}>
                                                    <label for="reproduksi_3" style="font-weight: normal; margin-right: 10px;">Haid Tidak
                                                        Teratur</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="reproduksi_4"
                                                        name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Tidak Haid"
                                                        {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan'] == 'Tidak Haid' ? 'checked' : '' }}>
                                                    <label for="reproduksi_4" style="font-weight: normal; margin-right: 10px;">Tidak
                                                        Haid</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="reproduksi_5"
                                                        name="fisik[pemeriksaanFisik][reproduksi][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="reproduksi_5"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="reproduksi_6" name="fisik[pemeriksaanFisik][reproduksi][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['reproduksi']['pilihan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Abdomen</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="abdomen_1" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="abdomen_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_2" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="Membesar"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'Membesar' ? 'checked' : '' }}>
                                                    <label for="abdomen_2" style="font-weight: normal; margin-right: 10px;">Membesar</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_3" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="Distensi"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'Distensi' ? 'checked' : '' }}>
                                                    <label for="abdomen_3"
                                                        style="font-weight: normal; margin-right: 10px;">Distensi</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_4" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="Nyeri Tekan"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'Nyeri Tekan' ? 'checked' : '' }}>
                                                    <label for="abdomen_4" style="font-weight: normal; margin-right: 10px;">Nyeri
                                                        Tekan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_5" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="Luka"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'Luka' ? 'checked' : '' }}>
                                                    <label for="abdomen_5" style="font-weight: normal; margin-right: 10px;">Luka</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_6" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="L I"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'L I' ? 'checked' : '' }}>
                                                    <label for="abdomen_6" style="font-weight: normal; margin-right: 10px;">L I</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_7" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="L II"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'L II' ? 'checked' : '' }}>
                                                    <label for="abdomen_7" style="font-weight: normal; margin-right: 10px;">L
                                                        II</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_8" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="L III"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'L III' ? 'checked' : '' }}>
                                                    <label for="abdomen_8" style="font-weight: normal; margin-right: 10px;">L III</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_9" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="L IV"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'L IV' ? 'checked' : '' }}>
                                                    <label for="abdomen_9" style="font-weight: normal; margin-right: 10px;">L
                                                        IV</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="abdomen_10" name="fisik[pemeriksaanFisik][abdomen][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['abdomen']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="abdomen_10"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="abdomen_11" name="fisik[pemeriksaanFisik][abdomen][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['abdomen']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Kulit</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="kulit_1" name="fisik[pemeriksaanFisik][kulit][pilihan]"
                                                        value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="kulit_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kulit_2" name="fisik[pemeriksaanFisik][kulit][pilihan]"
                                                        value="Turgor"
                                                        {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan'] == 'Turgor' ? 'checked' : '' }}>
                                                    <label for="kulit_2" style="font-weight: normal; margin-right: 10px;">Turgor Tidak
                                                        Baik</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="kulit_3" name="fisik[pemeriksaanFisik][kulit][pilihan]"
                                                        value="Perubahan Warna"
                                                        {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan'] == 'Perubahan Warna' ? 'checked' : '' }}>
                                                    <label for="kulit_3" style="font-weight: normal; margin-right: 10px;">Perubahan
                                                        Warna</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kulit_4" name="fisik[pemeriksaanFisik][kulit][pilihan]"
                                                        value="Terdapat Lecet"
                                                        {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan'] == 'Terdapat Lecet' ? 'checked' : '' }}>
                                                    <label for="kulit_4" style="font-weight: normal; margin-right: 10px;">Terdapat
                                                        Lecet</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="kulit_5" name="fisik[pemeriksaanFisik][kulit][pilihan]"
                                                        value="Terdapat Luka"
                                                        {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan'] == 'Terdapat Luka' ? 'checked' : '' }}>
                                                    <label for="kulit_5" style="font-weight: normal; margin-right: 10px;">Terdapat
                                                        Luka</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="kulit_6" name="fisik[pemeriksaanFisik][kulit][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['kulit']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="kulit_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="kulit_7" name="fisik[pemeriksaanFisik][kulit][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['kulit']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Mata</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="mata_1" name="fisik[pemeriksaanFisik][mata][pilihan]"
                                                        value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['mata']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="mata_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="mata_2" name="fisik[pemeriksaanFisik][mata][pilihan]"
                                                        value="Kuning"
                                                        {{ @$assesment['pemeriksaanFisik']['mata']['pilihan'] == 'Kuning' ? 'checked' : '' }}>
                                                    <label for="mata_2" style="font-weight: normal; margin-right: 10px;">Kuning</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="mata_3" name="fisik[pemeriksaanFisik][mata][pilihan]"
                                                        value="Pucat"
                                                        {{ @$assesment['pemeriksaanFisik']['mata']['pilihan'] == 'Pucat' ? 'checked' : '' }}>
                                                    <label for="mata_3"
                                                        style="font-weight: normal; margin-right: 10px;">Pucat</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="mata_4" name="fisik[pemeriksaanFisik][mata][pilihan]"
                                                        value="VOD"
                                                        {{ @$assesment['pemeriksaanFisik']['mata']['pilihan'] == 'VOD' ? 'checked' : '' }}>
                                                    <label for="mata_4" style="font-weight: normal; margin-right: 10px;">VOD (Visus Ocula
                                                        Dektra)</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="mata_5" name="fisik[pemeriksaanFisik][mata][pilihan]"
                                                        value="VOS"
                                                        {{ @$assesment['pemeriksaanFisik']['mata']['pilihan'] == 'VOS' ? 'checked' : '' }}>
                                                    <label for="mata_5" style="font-weight: normal; margin-right: 10px;">VOS (Visus Okula
                                                        Sinistra)</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="mata_6" name="fisik[pemeriksaanFisik][mata][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['mata']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="mata_6" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="mata_7" name="fisik[pemeriksaanFisik][mata][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['mata']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Genetalia</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="genetalia_1"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="genetalia_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_2"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Nyeri Tekan"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Nyeri Tekan' ? 'checked' : '' }}>
                                                    <label for="genetalia_2" style="font-weight: normal; margin-right: 10px;">Nyeri
                                                        Tekan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_3"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Benjolan"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Benjolan' ? 'checked' : '' }}>
                                                    <label for="genetalia_3"
                                                        style="font-weight: normal; margin-right: 10px;">Benjolan</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_4"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Hipospsdia"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Hipospsdia' ? 'checked' : '' }}>
                                                    <label for="genetalia_4"
                                                        style="font-weight: normal; margin-right: 10px;">Hipospsdia</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_5"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Epispadia"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Epispadia' ? 'checked' : '' }}>
                                                    <label for="genetalia_5"
                                                        style="font-weight: normal; margin-right: 10px;">Epispadia</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_6"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Hidrochele"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Hidrochele' ? 'checked' : '' }}>
                                                    <label for="genetalia_6"
                                                        style="font-weight: normal; margin-right: 10px;">Hidrochele</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_7"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Lesi"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Lesi' ? 'checked' : '' }}>
                                                    <label for="genetalia_7"
                                                        style="font-weight: normal; margin-right: 10px;">Lesi</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_8"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Eritema"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Eritema' ? 'checked' : '' }}>
                                                    <label for="genetalia_8"
                                                        style="font-weight: normal; margin-right: 10px;">Eritema</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_9"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Peradangan"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Peradangan' ? 'checked' : '' }}>
                                                    <label for="genetalia_9"
                                                        style="font-weight: normal; margin-right: 10px;">Peradangan</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="genetalia_10"
                                                        name="fisik[pemeriksaanFisik][genetalia][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['genetalia']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="genetalia_10"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                    
                                            <input type="text" id="genetalia_11" name="fisik[pemeriksaanFisik][genetalia][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['genetalia']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Urinaria</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="urinaria_1"
                                                        name="fisik[pemeriksaanFisik][urinaria][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="urinaria_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="urinaria_2"
                                                        name="fisik[pemeriksaanFisik][urinaria][pilihan]" value="Warna"
                                                        {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan'] == 'Warna' ? 'checked' : '' }}>
                                                    <label for="urinaria_2"
                                                        style="font-weight: normal; margin-right: 10px;">Warna</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="urinaria_3"
                                                        name="fisik[pemeriksaanFisik][urinaria][pilihan]" value="Produksi"
                                                        {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan'] == 'Produksi' ? 'checked' : '' }}>
                                                    <label for="urinaria_3"
                                                        style="font-weight: normal; margin-right: 10px;">Produksi</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="urinaria_4"
                                                        name="fisik[pemeriksaanFisik][urinaria][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['urinaria']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="urinaria_4"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="urinaria_5" name="fisik[pemeriksaanFisik][urinaria][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['urinaria']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Gigi</td>
                                        <td style="">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="gigi_1" name="fisik[pemeriksaanFisik][gigi][pilihan]"
                                                        value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['gigi']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="gigi_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label><br>
                                                </div>
                                                <div>
                                                    <input type="radio" id="gigi_4" name="fisik[pemeriksaanFisik][gigi][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['gigi']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="gigi_4" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="gigi_5" name="fisik[pemeriksaanFisik][gigi][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['gigi']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Ektremitas Atas</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="ektremitasAtas_1"
                                                        name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="ektremitasAtas_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="ektremitasAtas_2"
                                                        name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Gerakan Terbatas"
                                                        {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan'] == 'Gerakan Terbatas' ? 'checked' : '' }}>
                                                    <label for="ektremitasAtas_2" style="font-weight: normal; margin-right: 10px;">Gerakan Terbatas</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="ektremitasAtas_3"
                                                        name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Nyeri"
                                                        {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan'] == 'Nyeri' ? 'checked' : '' }}>
                                                    <label for="ektremitasAtas_3"
                                                        style="font-weight: normal; margin-right: 10px;">Nyeri</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="ektremitasAtas_4"
                                                        name="fisik[pemeriksaanFisik][ektremitasAtas][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="ektremitasAtas_4"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="ektremitasAtas_5"
                                                name="fisik[pemeriksaanFisik][ektremitasAtas][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['ektremitasAtas']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Ektremitas Bawah</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="ektremitasBawah_1"
                                                        name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="ektremitasBawah_1" style="font-weight: normal; margin-right: 10px;">Tidak
                                                        ada keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="ektremitasBawah_2"
                                                        name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Gerakan Terbatas"
                                                        {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan'] == 'Gerakan Terbatas' ? 'checked' : '' }}>
                                                    <label for="ektremitasBawah_2" style="font-weight: normal; margin-right: 10px;">Gerakan
                                                        Terbatas</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="ektremitasBawah_3"
                                                        name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Nyeri"
                                                        {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan'] == 'Nyeri' ? 'checked' : '' }}>
                                                    <label for="ektremitasBawah_3"
                                                        style="font-weight: normal; margin-right: 10px;">Nyeri</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="ektremitasBawah_4"
                                                        name="fisik[pemeriksaanFisik][ektremitasBawah][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="ektremitasBawah_4"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="ektremitasBawah_5"
                                                name="fisik[pemeriksaanFisik][ektremitasBawah][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['ektremitasBawah']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Muka / Wajah</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="muka_1" name="fisik[pemeriksaanFisik][muka][pilihan]"
                                                        value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['muka']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="muka_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="muka_2" name="fisik[pemeriksaanFisik][muka][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['muka']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="muka_2" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="muka_3" name="fisik[pemeriksaanFisik][muka][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['muka']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Telinga</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="telinga_1" name="fisik[pemeriksaanFisik][telinga][pilihan]"
                                                        value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['telinga']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="telinga_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="telinga_2" name="fisik[pemeriksaanFisik][telinga][pilihan]"
                                                        value="Tidak Simetris"
                                                        {{ @$assesment['pemeriksaanFisik']['telinga']['pilihan'] == 'Tidak Simetris' ? 'checked' : '' }}>
                                                    <label for="telinga_2" style="font-weight: normal; margin-right: 10px;">Tidak
                                                        Simetris</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="telinga_3" name="fisik[pemeriksaanFisik][telinga][pilihan]"
                                                        value="Cerumen"
                                                        {{ @$assesment['pemeriksaanFisik']['telinga']['pilihan'] == 'Cerumen' ? 'checked' : '' }}>
                                                    <label for="telinga_3"
                                                        style="font-weight: normal; margin-right: 10px;">Cerumen</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="telinga_4" name="fisik[pemeriksaanFisik][telinga][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['telinga']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="telinga_4"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="telinga_5" name="fisik[pemeriksaanFisik][telinga][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['telinga']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Hidung</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="hidung_1" name="fisik[pemeriksaanFisik][hidung][pilihan]"
                                                        value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['hidung']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="hidung_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="hidung_2" name="fisik[pemeriksaanFisik][hidung][pilihan]"
                                                        value="Tidak Simetris"
                                                        {{ @$assesment['pemeriksaanFisik']['hidung']['pilihan'] == 'Tidak Simetris' ? 'checked' : '' }}>
                                                    <label for="hidung_2" style="font-weight: normal; margin-right: 10px;">Tidak
                                                        Simetris</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="hidung_3" name="fisik[pemeriksaanFisik][hidung][pilihan]"
                                                        value="Sekret"
                                                        {{ @$assesment['pemeriksaanFisik']['hidung']['pilihan'] == 'Sekret' ? 'checked' : '' }}>
                                                    <label for="hidung_3" style="font-weight: normal; margin-right: 10px;">Sekfret</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="hidung_4" name="fisik[pemeriksaanFisik][hidung][pilihan]"
                                                        value="Cuping"
                                                        {{ @$assesment['pemeriksaanFisik']['hidung']['pilihan'] == 'Cuping' ? 'checked' : '' }}>
                                                    <label for="hidung_4" style="font-weight: normal; margin-right: 10px;">Pernafasan Cuping
                                                        Hidung</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="hidung_5" name="fisik[pemeriksaanFisik][hidung][pilihan]"
                                                        value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['hidung']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="hidung_5" style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="hidung_6" name="fisik[pemeriksaanFisik][hidung][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['hidung']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Tenggorokan</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="tenggorokan_1"
                                                        name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Tidak ada keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['tenggorokan']['pilihan'] == 'Tidak ada keluhan' ? 'checked' : '' }}>
                                                    <label for="tenggorokan_1" style="font-weight: normal; margin-right: 10px;">Tidak ada
                                                        keluhan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="tenggorokan_2"
                                                        name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Tonsil Ada Keluhan"
                                                        {{ @$assesment['pemeriksaanFisik']['tenggorokan']['pilihan'] == 'Tonsil Ada Keluhan' ? 'checked' : '' }}>
                                                    <label for="tenggorokan_2" style="font-weight: normal; margin-right: 10px;">Tonsil Ada
                                                        Keluhan</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="tenggorokan_3"
                                                        name="fisik[pemeriksaanFisik][tenggorokan][pilihan]" value="Lain-Lain"
                                                        {{ @$assesment['pemeriksaanFisik']['tenggorokan']['pilihan'] == 'Lain-Lain' ? 'checked' : '' }}>
                                                    <label for="tenggorokan_3"
                                                        style="font-weight: normal; margin-right: 10px;">Lain-Lain</label>
                                                </div>
                                            </div>
                                            <input type="text" id="tenggorokan_4" name="fisik[pemeriksaanFisik][tenggorokan][sebutkan]"
                                                style="display:inline-block; width: 100%;" class="form-control" placeholder="Sebutkan"
                                                value="{{ @$assesment['pemeriksaanFisik']['tenggorokan']['sebutkan'] }}">
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Keadaan Emosional</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="keadaanEmosional_1"
                                                        name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Kooperatif"
                                                        {{ @$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'kooperatif' ? 'checked' : '' }}>
                                                    <label for="keadaanEmosional_1"
                                                        style="font-weight: normal; margin-right: 10px;">Kooperatif</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="keadaanEmosional_2"
                                                        name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Butuh Pertolongan"
                                                        {{ @$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Butuh Pertolongan' ? 'checked' : '' }}>
                                                    <label for="keadaanEmosional_2" style="font-weight: normal; margin-right: 10px;">Butuh
                                                        Pertolongan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="keadaanEmosional_3"
                                                        name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Ingin Tahu"
                                                        {{ @$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Ingin Tahu' ? 'checked' : '' }}>
                                                    <label for="keadaanEmosional_3" style="font-weight: normal; margin-right: 10px;">Ingin
                                                        Tahu</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="keadaanEmosional_4"
                                                        name="fisik[pemeriksaanFisik][keadaanEmosional][pilihan]" value="Bingung"
                                                        {{ @$assesment['pemeriksaanFisik']['keadaanEmosional']['pilihan'] == 'Bingung' ? 'checked' : '' }}>
                                                    <label for="keadaanEmosional_4"
                                                        style="font-weight: normal; margin-right: 10px;">Bingung</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Kebutuhan Edukasi dan Pengajaran</td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="kebutuhanEdukasi_1"
                                                        name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan]" value="Pasien"
                                                        {{ @$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan'] == 'Pasien' ? 'checked' : '' }}>
                                                    <label for="kebutuhanEdukasi_1"
                                                        style="font-weight: normal; margin-right: 10px;">Pasien</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kebutuhanEdukasi_2"
                                                        name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan]" value="Orang Tua"
                                                        {{ @$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan'] == 'Orang Tua' ? 'checked' : '' }}>
                                                    <label for="kebutuhanEdukasi_2" style="font-weight: normal; margin-right: 10px;">Orang
                                                        Tua</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kebutuhanEdukasi_3"
                                                        name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan]" value="Anak"
                                                        {{ @$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan'] == 'Anak' ? 'checked' : '' }}>
                                                    <label for="kebutuhanEdukasi_3"
                                                        style="font-weight: normal; margin-right: 10px;">Anak</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="kebutuhanEdukasi_4"
                                                        name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan]" value="Suami"
                                                        {{ @$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan'] == 'Suami' ? 'checked' : '' }}>
                                                    <label for="kebutuhanEdukasi_4"
                                                        style="font-weight: normal; margin-right: 10px;">Suami</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kebutuhanEdukasi_5"
                                                        name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan]" value="Istri"
                                                        {{ @$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan'] == 'Istri' ? 'checked' : '' }}>
                                                    <label for="kebutuhanEdukasi_5"
                                                        style="font-weight: normal; margin-right: 10px;">Istri</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="kebutuhanEdukasi_6"
                                                        name="fisik[pemeriksaanFisik][kebutuhanEdukasi][pilihan]" value="Keluarga Lainnya"
                                                        {{ @$assesment['pemeriksaanFisik']['kebutuhanEdukasi']['pilihan'] == 'Keluarga Lainnya' ? 'checked' : '' }}>
                                                    <label for="kebutuhanEdukasi_6"
                                                        style="font-weight: normal; margin-right: 10px;">Keluarga Lainnya</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Bicara</td>
                                        <td style="text-align: start;">
                                            <input type="radio" id="bicara_1" name="fisik[pemeriksaanFisik][bicara][pilihan]"
                                                value="Normal"
                                                {{ @$assesment['pemeriksaanFisik']['bicara']['pilihan'] == 'Normal' ? 'checked' : '' }}>
                                            <label for="bicara_1" style="font-weight: normal; margin-right: 10px;">Normal</label>
                                            <input type="radio" id="bicara_2" name="fisik[pemeriksaanFisik][bicara][pilihan]"
                                                value="Gangguan Bicara"
                                                {{ @$assesment['pemeriksaanFisik']['bicara']['pilihan'] == 'Gangguan Bicara' ? 'checked' : '' }}>
                                            <label for="bicara_2" style="font-weight: normal; margin-right: 10px;">Gangguan Bicara</label>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Bahasa Sehari-Hari</td>
                                        <td style="text-align: start;">
                                            <input type="radio" id="bahasa_1" name="fisik[pemeriksaanFisik][bahasa][pilihan]"
                                                value="Indonesia"
                                                {{ @$assesment['pemeriksaanFisik']['bahasa']['pilihan'] == 'Indonesia' ? 'checked' : '' }}>
                                            <label for="bahasa_1" style="font-weight: normal; margin-right: 10px;">Indonesia</label>
                                            <input type="radio" id="bahasa_2" name="fisik[pemeriksaanFisik][bahasa][pilihan]"
                                                value="Daerah"
                                                {{ @$assesment['pemeriksaanFisik']['bahasa']['pilihan'] == 'Daerah' ? 'checked' : '' }}>
                                            <label for="bahasa_2" style="font-weight: normal; margin-right: 10px;">Daerah</label>
                                            <input type="radio" id="bahasa_3" name="fisik[pemeriksaanFisik][bahasa][pilihan]"
                                                value="Inggris dan Lainnya"
                                                {{ @$assesment['pemeriksaanFisik']['bahasa']['pilihan'] == 'Inggris dan Lainnya' ? 'checked' : '' }}>
                                            <label for="bahasa_3" style="font-weight: normal; margin-right: 10px;">Inggris dan
                                                Lainnya</label><br />
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Perlu Penerjemah</td>
                                        <td style="text-align: start;">
                                            <input type="radio" id="penerjemah_1" name="fisik[pemeriksaanFisik][penerjemah][pilihan]"
                                                value="Perlu Penerjemah"
                                                {{ @$assesment['pemeriksaanFisik']['penerjemah']['pilihan'] == 'Perlu Penerjemah' ? 'checked' : '' }}>
                                            <label for="penerjemah_1" style="font-weight: normal; margin-right: 10px;">Perlu
                                                Penerjemah</label>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Hambatan Edukasi</td>
                                        <td style="text-align: start;">
                                            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                                                <div>
                                                    <input type="radio" id="hambatanEdukasi_1"
                                                        name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Bahasa"
                                                        {{ @$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] == 'Bahasa' ? 'checked' : '' }}>
                                                    <label for="hambatanEdukasi_1"
                                                        style="font-weight: normal; margin-right: 10px;">Bahasa</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="hambatanEdukasi_2"
                                                        name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Pendengaran"
                                                        {{ @$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] == 'Pendengaran' ? 'checked' : '' }}>
                                                    <label for="hambatanEdukasi_2"
                                                        style="font-weight: normal; margin-right: 10px;">Pendengaran</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="hambatanEdukasi_3"
                                                        name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Hilang Memori"
                                                        {{ @$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] == 'Hilang Memori' ? 'checked' : '' }}>
                                                    <label for="hambatanEdukasi_3" style="font-weight: normal; margin-right: 10px;">Hilang
                                                        Memori</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="hambatanEdukasi_4"
                                                        name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Motivasi Buruk"
                                                        {{ @$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] == 'Motivasi Buruk' ? 'checked' : '' }}>
                                                    <label for="hambatanEdukasi_4" style="font-weight: normal; margin-right: 10px;">Motivasi
                                                        Buruk</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="hambatanEdukasi_5"
                                                        name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Cemas"
                                                        {{ @$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] == 'Cemas' ? 'checked' : '' }}>
                                                    <label for="hambatanEdukasi_5"
                                                        style="font-weight: normal; margin-right: 10px;">Cemas</label><br />
                                                </div>
                                                <div>
                                                    <input type="radio" id="hambatanEdukasi_6"
                                                        name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]" value="Masalah Penglihatan"
                                                        {{ @$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] == 'Masalah Penglihatan' ? 'checked' : '' }}>
                                                    <label for="hambatanEdukasi_6" style="font-weight: normal; margin-right: 10px;">Masalah
                                                        Penglihatan</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="hambatanEdukasi_7"
                                                        name="fisik[pemeriksaanFisik][hambatanEdukasi][pilihan]"
                                                        value="Tidak ditemukan Hambatan"
                                                        {{ @$assesment['pemeriksaanFisik']['hambatanEdukasi']['pilihan'] == 'Tidak ditemukan Hambatan' ? 'checked' : '' }}>
                                                    <label for="hambatanEdukasi_7" style="font-weight: normal; margin-right: 10px;">Tidak
                                                        ditemukan Hambatan</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                    
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Edukasi yang diberikan</td>
                                        <td style="text-align: start;">
                                            <input type="radio" id="edukasi_1" name="fisik[pemeriksaanFisik][edukasi][pilihan]"
                                                value="Proses Penyakit"
                                                {{ @$assesment['pemeriksaanFisik']['edukasi']['pilihan'] == 'Proses Penyakit' ? 'checked' : '' }}>
                                            <label for="edukasi_1" style="font-weight: normal; margin-right: 10px;">Proses Penyakit</label>
                                            <input type="radio" id="edukasi_2" name="fisik[pemeriksaanFisik][edukasi][pilihan]"
                                                value="Pengobatan"
                                                {{ @$assesment['pemeriksaanFisik']['edukasi']['pilihan'] == 'Pengobatan' ? 'checked' : '' }}>
                                            <label for="edukasi_2" style="font-weight: normal; margin-right: 10px;">Pengobatan</label>
                                            <input type="radio" id="edukasi_3" name="fisik[pemeriksaanFisik][edukasi][pilihan]"
                                                value="Nutrisi"
                                                {{ @$assesment['pemeriksaanFisik']['edukasi']['pilihan'] == 'Nutrisi' ? 'checked' : '' }}>
                                            <label for="edukasi_3" style="font-weight: normal; margin-right: 10px;">Nutrisi</label><br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Status Gizi</td>
                                        <td>
                                            <input type="text" id="statusGizi" name="fisik[pemeriksaanFisik][statusGizi]"
                                                style="display:inline-block;" class="form-control" placeholder=""
                                                value="{{ @$assesment['pemeriksaanFisik']['statusGizi'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Status Pediatrik</td>
                                        <td>
                                            <input type="text" id="statusPediatrik" name="fisik[pemeriksaanFisik][statusPediatrik]"
                                                style="display:inline-block;" class="form-control" placeholder=""
                                                value="{{ @$assesment['pemeriksaanFisik']['statusPediatrik'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Riwayat Imunisasi</td>
                                        <td>
                                            <input type="text" id="riwayatImunisasi" name="fisik[pemeriksaanFisik][riwayatImunisasi]"
                                                style="display:inline-block;" class="form-control" placeholder=""
                                                value="{{ @$assesment['pemeriksaanFisik']['riwayatImunisasi'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">Riwayat Tumbuh Kembang</td>
                                        <td>
                                            <input type="text" id="riwayatTumbuh" name="fisik[pemeriksaanFisik][riwayatTumbuh]"
                                                style="display:inline-block;" class="form-control" placeholder=""
                                                value="{{ @$assesment['pemeriksaanFisik']['riwayatTumbuh'] }}">
                                        </td>
                                    </tr>
                                </table>
                    
                                <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                                    style="font-size:12px;">
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">RENCANA PEMULANGAN PASIEN (Discharge Planning)</td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            <input type="checkbox" id="dischargePlanning_1"
                                                name="fisik[dischargePlanning][kontrol][dipilih]" value="Kontrol ulang RS"
                                                {{ @$assesment['dischargePlanning']['kontrol']['dipilih'] == 'Kontrol ulang RS' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol ulang
                                                RS</label><br />
                                        </td>
                                        <td>
                                            <input type="text" id="waktuKontrol" name="fisik[dischargePlanning][kontrol][waktu]"
                                                class="form-control date_tanpa_tanggal"
                                                value="{{ @$assesment['dischargePlanning']['kontrol']['waktu'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                          <button type="button" id="listKontrol" data-dokterID="{{ $reg->dokter_id }}"
                                            class="btn btn-info btn-sm btn-flat">
                                            <i class="fa fa-th-list"></i> Lihat List Kontrol
                                          </button>
                                        </td>
                                      </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            <input type="checkbox" id="dischargePlanning_1"
                                                name="fisik[dischargePlanning][kontrolPRB][dipilih]" value="Kontrol PRB"
                                                {{ @$assesment['dischargePlanning']['kontrolPRB']['dipilih'] == 'Kontrol PRB' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Kontrol
                                                PRB</label><br />
                                        </td>
                                        <td>
                                            <input type="text" name="fisik[dischargePlanning][kontrolPRB][waktu]"
                                                class="form-control date_tanpa_tanggal"
                                                value="{{ @$assesment['dischargePlanning']['kontrolPRB']['waktu'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                            <input type="checkbox" id="dischargePlanning_1"
                                                name="fisik[dischargePlanning][dirawat][dipilih]" value="Dirawat"
                                                {{ @$assesment['dischargePlanning']['dirawat']['dipilih'] == 'Dirawat' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_1"
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
                                            <input type="checkbox" id="dischargePlanning_1"
                                                name="fisik[dischargePlanning][dirujuk][dipilih]" value="Dirujuk"
                                                {{ @$assesment['dischargePlanning']['dirujuk']['dipilih'] == 'Dirujuk' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_1"
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
                                            <input type="checkbox" id="dischargePlanning_1"
                                                name="fisik[dischargePlanning][Konsultasi][dipilih]"
                                                value="Konsultasi selesai / tidak kontrol ulang"
                                                {{ @$assesment['dischargePlanning']['Konsultasi']['dipilih'] == 'Konsultasi selesai / tidak kontrol ulang' ? 'checked' : '' }}>
                                            <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Konsultasi
                                                selesai / tidak kontrol ulang</label><br />
                                        </td>
                                        <td>
                                            <input type="text" name="fisik[dischargePlanning][Konsultasi][waktu]"
                                                class="form-control date_tanpa_tanggal"
                                                value="{{ @$assesment['dischargePlanning']['Konsultasi']['waktu'] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:25%; font-weight:500;">
                                          <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][pulpak][dipilih]" value="Pulang Paksa" {{@$assesment['dischargePlanning']['pulpak']['dipilih'] == 'Pulang Paksa' ? 'checked' : ''}}>
                                          <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Pulang Paksa</label><br/>
                                        </td>
                                        <td>
                                          <input type="text" name="fisik[dischargePlanning][pulpak][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['pulpak']['waktu']}}">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:25%; font-weight:500;">
                                          <input type="checkbox" id="dischargePlanning_1" name="fisik[dischargePlanning][meninggal][dipilih]" value="Meninggal" {{@$assesment['dischargePlanning']['meninggal']['dipilih'] == 'Meninggal' ? 'checked' : ''}}>
                                          <label for="dischargePlanning_1" style="font-weight: normal; margin-right: 10px;">Meninggal</label><br/>
                                        </td>
                                        <td>
                                          <input type="text" name="fisik[dischargePlanning][meninggal][waktu]" class="form-control date_tanpa_tanggal" value="{{@$assesment['dischargePlanning']['meninggal']['waktu']}}">
                                        </td>
                                      </tr>
                                </table>
                                <div style="text-align: right;">
                                    <input class="btn btn-warning" type="reset" value="Reset">&nbsp;&nbsp;
                                    <button class="btn btn-success">Simpan</button>
                                </div>
                    
                                </form>
                    
                            </div>
                            {{-- History --}}
                            <div class="col-md-12">
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
                                                <td
                                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                    <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                                        class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                                    <a href="{{ url('cetak-resume-medis-rencana-kontrol-gizi/pdf/' . @$riwayat->registrasi_id . '/' . @$riwayat->id) }}"
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
                    </div>
                </div>
            </form>
            <br />

            @if (@$dataPegawai == '1')
                <div class="col-md-12">
                    <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"
                        style="font-size:12px;">
                        <h5><b>TINDAKAN</b></h5>
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
                </div>

                {{-- Visum --}}
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
            @endif

            
        </div>
    </div>

  {{-- Modal List Kontrol ======================================================================== --}}
  <div class="modal fade" id="showListKontrol" tabindex="-1" role="dialog" aria-labelledby=""
  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">List Kontrol</h4>
            </div>
            <div class="modal-body">
                <div id="dataListKontrol">
                    <div class="spinner-square">
                        <div class="square-1 square"></div>
                        <div class="square-2 square"></div>
                        <div class="square-3 square"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
  </div>
  {{-- End Modal List Kontrol ======================================================================== --}}
    

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
        // $(".date_tanpa_tanggal").datepicker({
        //     format: "dd/mm/yyyy",
        //     autoclose: true
        // });
        $(".date_tanpa_tanggal").datepicker( {
            format: "dd-mm-yyyy",
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

            if (diagnosa == 'BERSIHAN JALAN NAPAS TIDAK EFEKTIF') {
                var optionIntervensi = [
                    "Monitor Pola Napas (Frekuensi, Kedalaman, Usaha Napas)",
                    "Monitor Bunyi Napas Tambahan",
                    "Monitor Sputum (Jumlah, Warna, Aroma)",
                    "Pertahankan Kepatenan Jalan Napas Dengan Head Tilt dan Chin Lift (Jaw Thrust) Jika Curiga Trauma Servikal",
                    "Posisikan Semi Fowler atau Fowler",
                    "Berikan Minum Hangat",
                    "Lakukan Fisioterapi",
                    "Lakukan Penghisapan Lender Kurang Dari 15 Detik",
                    "Lakukan Hiperoksigenasi Sebelum Penghisapan Endotrakeal",
                    "Keluarkan Sumbatan Benda Padat Dengan Forsep Mcgill",
                    "Berikan Oksigen",
                    "Anjurkan Asupan Cairan 2000 ml/hari Jika Tidak Kontraindikasi",
                    "Ajarkan Teknik Batuk Efektif",
                    "Kolaborasi Pemberian Bronkodilator, Ekspektoran, MukoLitik",
                    "Identifikasi Kemampuan Batuk",
                    "Monitor Adanya Retensi Sputum",
                    "Monitor Tanda dan Gejala Infeksi Saluran Napas",
                    "Monitor Input dan Output Cairan (mis. Jumlah dan Karakteristik)",
                    "Atur Posisi Semi Fowler atau Fowler",
                    "Pasang Perlak dan Bengkok di Pangkuan Pasien",
                    "Buang Secret Pada Tempat Sputum",
                    "Jelaskan Tujuan dan Prosedur Batuk Efektif",
                    "Anjurkan Tarik Nafas dalam Melalui Hidung Selama 4 Detik Ditahan Selama 2 detik Kemudian keluarkan dari Mulut dengan bibir mencucu (dibulatkan) selama 8 detik",
                    "Anjurkan Mengulangi Tarik Napas Dalam hingga 3 kali",
                    "Anjurkan Batuk dengan Kuat Langsung Setelah Tarik Napas dalam yang ke-3",
                    "Kolaborasi Pemberian Mukolitik atau Ekspektoran, Jika Perlu",
                    "Monitor Kecepatan Aliran Oksigen",
                    "Monitor Posisi Alat Terapi Oksigen",
                    "Monitor Aliran Oksigen Secara Periodic dan Pastikan Fraksi Yang Diberikan Cukup",
                    "Monitor Efektifitas Terapi Oksigen",
                    "Monitor Kemampuan Melepaskan Oksigen Saat Makan",
                    "Monitor Tanda-Tanda Hipoventilasi",
                    "Monitor Tanda dan Gejala Toksikasi Oksigen dan Atelektasis",
                    "Monitor Tingkat Kecemasan Akibat Terapi Oksigen",
                    "Monitor Integritas Mukosa Hidung Akibat Pemasangan Oksigen",
                    "Bersihkan Secret Pada Mulut, Hidung, dan, Trakea, jika perlu",
                    "Pertahankan Kepatenan Jalan Napas",
                    "Siapkan Danatur Peralatan Pemberian Oksigen",
                    "Berikan Oksigen Tambahan, jika perlu",
                    "Tetap Berikan Oksigen Saat Pasien Ditransportasi",
                    "Gunakan Perangkat Oksigen Yang Sesuai Dengan Tingkat Mobilitas Pasien",
                    "Ajarkan Pasien dan Keluarga Cara Menggunakan Oksigen di Rumah",
                    "Kolaborasi Penentuan Dosis Oksigen",
                    "Kolaborasi Penggunaan Oksigen Saat Aktivitas dan atau tidur"
                ];

                var optionImplementasi = [
                    "Memonitor Pola Napas (Frekuensi, Kedalaman, Usaha Napas)",
                    "Memonitor Bunyi Napas Tambahan",
                    "Memonitor Sputum (Jumlah, Warna, Aroma)",
                    "Mempertahankan Kepatenan Jalan Napas Dengan Head Tilt dan Chin Lift (Jaw Thrust) Jika Curiga Trauma Servikal",
                    "Memposisikan Semi Fowler atau Fowler",
                    "Memberikan Minum Hangat",
                    "Melakukan Fisioterapi",
                    "Melakukan Penghisapan Lender Kurang Dari 15 Detik",
                    "Melakukan Hiperoksigenasi Sebelum Penghisapan Endotrakeal",
                    "Mengeluarkan Sumbatan Benda Padat Dengan Forsep Mcgill",
                    "Memberikan Oksigen",
                    "Menganjurkan Asupan Cairan 2000 ml/hari Jika Tidak Kontraindikasi",
                    "Mengajarkan Teknik Batuk Efektif",
                    "Melakukan kolaborasi Pemberian Bronkodilator, Ekspektoran, MukoLitik",
                    "Mengidentifikasi Kemampuan Batuk",
                    "Memonitor Adanya Retensi Sputum",
                    "Memonitor Tanda dan Gejala Infeksi Saluran Napas",
                    "Memonitor Input dan Output Cairan (mis. Jumlah dan Karakteristik)",
                    "Mengatur Posisi Semi Fowler atau Fowler",
                    "Memasang Perlak dan Bengkok di Pangkuan Pasien",
                    "Membuang Secret Pada Tempat Sputum",
                    "Menjelaskan Tujuan dan Prosedur Batuk Efektif",
                    "Menganjurkan Tarik Nafas dalam Melalui Hidung Selama 4 Detik Ditahan Selama 2 detik Kemudian keluarkan dari Mulut dengan bibir mencucu (dibulatkan) selama 8 detik",
                    "Menganjurkan Mengulangi Tarik Napas Dalam hingga 3 kali",
                    "Menganjurkan Batuk dengan Kuat Langsung Setelah Tarik Napas dalam yang ke-3",
                    "Melakukan kolaborasi Pemberian Mukolitik atau Ekspektoran, Jika Perlu",
                    "Memonitor Kecepatan Aliran Oksigen",
                    "Memonitor Posisi Alat Terapi Oksigen",
                    "Memonitor Aliran Oksigen Secara Periodic dan Pastikan Fraksi Yang Diberikan Cukup",
                    "Memonitor Efektifitas Terapi Oksigen",
                    "Memonitor Kemampuan Melepaskan Oksigen Saat Makan",
                    "Memonitor Tanda-Tanda Hipoventilasi",
                    "Memonitor Tanda dan Gejala Toksikasi Oksigen dan Atelektasis",
                    "Memonitor Tingkat Kecemasan Akibat Terapi Oksigen",
                    "Memonitor Integritas Mukosa Hidung Akibat Pemasangan Oksigen",
                    "Membersihkan Secret Pada Mulut, Hidung, dan, Trakea, jika perlu",
                    "Mempertahankan Kepatenan Jalan Napas",
                    "Menyiapkan Danatur Peralatan Pemberian Oksigen",
                    "Memberikan Oksigen Tambahan, jika perlu",
                    "Tetap Berikan Oksigen Saat Pasien Ditransportasi",
                    "Menggunakan Perangkat Oksigen Yang Sesuai Dengan Tingkat Mobilitas Pasien",
                    "Mengajarkan Pasien dan Keluarga Cara Menggunakan Oksigen di Rumah",
                    "Melakukan kolaborasi Penentuan Dosis Oksigen",
                    "Melakukan kolaborasi Penggunaan Oksigen Saat Aktivitas dan atau tidur"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'POLA NAPAS TIDAK EFEKTIF') {

                var optionIntervensi = [
                    "Mengidentifikasi dan Mengelola Kepatenan Jalan Napas",
                    "Monitor Pola Napas (Frekuensi, Kedalaman, Usaha Napas)",
                    "Monitor Bunyi Napas Tambahan",
                    "Monitor Sputum (Jumlah, Warna, Aroma)",
                    "Pertahankan kepatenan jalan napas dengan head-tift dan chin-lift (jaw-trust jika curiga trauma servikal)",
                    "Posisikan pasien semi fowler atau fowler",
                    "Berikan minuman hangat",
                    "Lakukan fisioterapi dada, jika perlu",
                    "lakukan penghisapan lendir kurang dari 15 detik",
                    "Lakukan hiperoksigenasi sebelum penghisapan endotrakeal",
                    "Keluarkan sumbatan benda padat dengan proses McGill",
                    "Berikan oksigen, jika perlu",
                    "Anjurkan asupan cairan 2000 ml/hari, jika tidak kontraindikasi",
                    "Ajarkan teknik batuk efektif",
                    "Kolaborasi pemberian bronkhodilator, ekspektoran, mukolitik, jika perlu",
                    "Monitor frekuensi, irama, kedalaman, dan upaya napas",
                    "Monitor pola napas (seperti bradipnea, tapikneu, hiperventilasi, kussmaul, cheynestokes, ataksisk)",
                    "Monitor kemampuan batuk efektif",
                    "Monitor adanya produksi sputum",
                    "Monitor adanya sumbatan jalan napas",
                    "Palpasi kesimetrisan ekspansi paru",
                    "Auskultasi bunyi napas",
                    "Monitor saturasi oksigen",
                    "Monitor hasil AGD",
                    "Monitor hasil xpray thoraks",
                    "Atur interval pemantauan respirasi sesuai kondisi pasien",
                    "Dokumentasikan hasil pemantauan",
                    "Jelaskan tujuan dan prosedue pemantauan",
                    "Jelaskan hasil pemantauan, jika perlu"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi dan Mengelola Kepatenan Jalan Napas",
                    "Memonitor Pola Napas (Frekuensi, Kedalaman, Usaha Napas)",
                    "Memonitor Bunyi Napas Tambahan",
                    "Memonitor Sputum (Jumlah, Warna, Aroma)",
                    "Mempertahankan kepatenan jalan napas dengan head-tift dan chin-lift (jaw-trust jika curiga trauma servikal)",
                    "Memposisikan pasien semi fowler atau fowler",
                    "Memberikan minuman hangat",
                    "Melakukan fisioterapi dada, jika perlu",
                    "Melakukan penghisapan lendir kurang dari 15 detik",
                    "Melakukan hiperoksigenasi sebelum penghisapan endotrakeal",
                    "Mengeluarkan sumbatan benda padat dengan proses McGill",
                    "Memberikan oksigen, jika perlu",
                    "Menganjurkan asupan cairan 2000 ml/hari, jika tidak kontraindikasi",
                    "Mengajarkan teknik batuk efektif",
                    "Melakukan kolaborasi pemberian bronkhodilator, ekspektoran, mukolitik, jika perlu",
                    "Memonitor frekuensi, irama, kedalaman, dan upaya napas",
                    "Memonitor pola napas (seperti bradipnea, tapikneu, hiperventilasi, kussmaul, cheynestokes, ataksisk)",
                    "Memonitor kemampuan batuk efektif",
                    "Memonitor adanya produksi sputum",
                    "Memonitor adanya sumbatan jalan napas",
                    "Melakukan palpasi kesimetrisan ekspansi paru",
                    "Melakukan auskultasi bunyi napas",
                    "Memonitor saturasi oksigen",
                    "Memonitor hasil AGD",
                    "Memonitor hasil xpray thoraks",
                    "Mengatur interval pemantauan respirasi sesuai kondisi pasien",
                    "Melakukan dokumentasikan hasil pemantauan",
                    "Menjelaskan tujuan dan prosedue pemantauan",
                    "Menjelaskan hasil pemantauan, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'PENURUNAN CURAH JANTUNG') {
                var optionIntervensi = [
                    "Identifikasi tanda/ gejala primer penurunan curah jantung (meliputi dipsnea, kelelahan, edema, ortopnea, peningkatan CVP)",
                    "Identifikasi tanda atau gejala sekunder penurunan curah jantung (meliputi distensi vena jugularis, palpitasi, ronkhi basah, uliguria, batuk, kulit pucat)",
                    "Monitor tekanan darah",
                    "Monitor intake dan output cairan",
                    "Monitor berat badan setiap hari",
                    "Monitor saturasi oksigen",
                    "Monitor keluhan nyeri dada",
                    "Monitor EKG",
                    "Monitor aritmia",
                    "Monitor nilai laboratorium jantung",
                    "Monitor fungsi alat pacu jantung",
                    "Periksa tekanan darah dan frekuensi nadi sebelum pemberian obat",
                    "Periksa tekanan darah dan frekuensi nadi sebelum dan sesudah aktivitas",
                    "Posisikan pasien semi fowler / fowler dengan kaki kebawah atau posisi nyaman",
                    "Berikan diet jantung yang sesuai",
                    "Gunakan stoking elastic atau pneumatic intermiten sesuai indikasi",
                    "Fasilitasi pasien dan keluarga untuk modifikasi gaya hidup sehat",
                    "Berikan terapi relaksasi untuk mengurangi stress jika perlu",
                    "Berikan dukungan emosional dan spiritual",
                    "Berikan oksigen untuk mempertahankan saturasi oksigen >94%",
                    "Anjurkan beraktivitas fisik sesuai toleransi",
                    "Anjurkan beraktivitas fisik secara bertahap",
                    "Anjurkan berhenti merokok",
                    "Ajarkan pasien dan keluarga mengukur berat badan harian",
                    "Ajarkan pasien dan keluarga mengukur intake dan output cairan harian",
                    "Kolaborasi pemberian anti aritmia, jika perlu",
                    "Rujuk ke program rehabilitasi jantung"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi tanda/ gejala primer penurunan curah jantung (meliputi dipsnea, kelelahan, edema, ortopnea, peningkatan CVP)",
                    "Mengidentifikasi tanda atau gejala sekunder penurunan curah jantung (meliputi distensi vena jugularis, palpitasi, ronkhi basah, uliguria, batuk, kulit pucat)",
                    "Memonitor tekanan darah",
                    "Memonitor intake dan output cairan",
                    "Memonitor berat badan setiap hari",
                    "Memonitor saturasi oksigen",
                    "Memonitor keluhan nyeri dada",
                    "Memonitor EKG",
                    "Memonitor aritmia",
                    "Memonitor nilai laboratorium jantung",
                    "Memonitor fungsi alat pacu jantung",
                    "Memeriksa tekanan darah dan frekuensi nadi sebelum pemberian obat",
                    "Memeriksa tekanan darah dan frekuensi nadi sebelum dan sesudah aktivitas",
                    "Memposisikan pasien semi fowler / fowler dengan kaki kebawah atau posisi nyaman",
                    "Memberikan diet jantung yang sesuai",
                    "Menggunakan stoking elastic atau pneumatic intermiten sesuai indikasi",
                    "Memfasilitasi pasien dan keluarga untuk modifikasi gaya hidup sehat",
                    "Memberikan terapi relaksasi untuk mengurangi stress jika perlu",
                    "Memberikan dukungan emosional dan spiritual",
                    "Memberikan oksigen untuk mempertahankan saturasi oksigen >94%",
                    "Menganjurkan beraktivitas fisik sesuai toleransi",
                    "Menganjurkan beraktivitas fisik secara bertahap",
                    "Menganjurkan berhenti merokok",
                    "Mengajarkan pasien dan keluarga mengukur berat badan harian",
                    "Mengajarkan pasien dan keluarga mengukur intake dan output cairan harian",
                    "Melakukan kolaborasi pemberian anti aritmia, jika perlu",
                    "Merujuk ke program rehabilitasi jantung"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'PERFUSI PERIFER TIDAK EFEKTIF') {
                var optionIntervensi = [
                    "Periksa sirkulasi perifer (mis: nadi perifer, edema, pengisian kapiler, warna, suhu, ankle-brachial index)",
                    "Identifikasi faktor risiko gangguan sirkulasi (mis: diabetes, perokok, orang tua, hipertensi dan kadar kolesterol tinggi)",
                    "Monitor panas, kemerahan, nyeri atau bengkak pada ekstremitas",
                    "Hindari pemasangan infus atau pengambilan darah di area keterbatasan perfusi",
                    "Hindari pengukuran tekanan darah pada ekstremitas dengan keterbatasan perfusi",
                    "Hindari penekanan dan pemasangan tourniquet pada area yang cedera",
                    "Lakukan pencegahan infeksi",
                    "Lakukan perawatan kaki dan kuku",
                    "Lakukan hidrasi",
                    "Anjurkan berhenti merokok",
                    "Anjurkan berolah raga rutin",
                    "Anjurkan mengecek air mandi untuk menghindari kulit terbakar",
                    "Anjurkan menggunakan obat penurun tekanan darah, antikoagulan, dan penurun kolesterol, jika perlu",
                    "Anjurkan minum obat pengontrol tekanan darah secara teratur",
                    "Anjurkan menghindari penggunaan obat penyekat beta",
                    "Anjurkan melakukan perawatan kulit yang tepat (mis: melembabkan kulit kering pada kaki)",
                    "Anjurkan program rehabilitasi vaskuler",
                    "Anjurkan program diet untuk memperbaiki sirkulasi (mis: rendah lemak jenuh, minyak ikan omega 3)",
                    "Informasikan tanda dan gejala darurat yang harus dilaporkan (mis: rasa sakit yang tidak hilang saat istirahat, luka tidak sembuh, hilangnya rasa)",
                    "Pemantauan hasil laboratorium",
                    "Pemantauan hemodinamik invasif",
                    "Pemantauan tanda vital",
                    "Pemakaian stoking elastis",
                    "Pemberian obat intravena",
                    "Pemberian obat oral",
                    "Pemberian produk darah",
                    "Pencegahan luka tekan",
                    "Pengambilan sampel darah arteri",
                    "Pengambilan sampel darah vena",
                    "Pengaturan posisi",
                    "Perawatan emboli perifer",
                    "Perawatan kaki",
                    "Perawatan neurovaskuler",
                    "Promosi latihan fisik",
                    "Terapi bekam",
                    "Terapi intravena",
                    "Terapi oksigen",
                    "Tourniquet pneumatik",
                    "Uji laboratorium di tempat tidur"
                ];
                var optionImplementasi = [
                    "Memeriksa sirkulasi perifer (mis: nadi perifer, edema, pengisian kapiler, warna, suhu, ankle-brachial index)",
                    "Mengidentifikasi faktor risiko gangguan sirkulasi (mis: diabetes, perokok, orang tua, hipertensi dan kadar kolesterol tinggi)",
                    "Memonitor panas, kemerahan, nyeri atau bengkak pada ekstremitas",
                    "Menghindari pemasangan infus atau pengambilan darah di area keterbatasan perfusi",
                    "Menghindari pengukuran tekanan darah pada ekstremitas dengan keterbatasan perfusi",
                    "Menghindari penekanan dan pemasangan tourniquet pada area yang cedera",
                    "Melakukan pencegahan infeksi",
                    "Melakukan perawatan kaki dan kuku",
                    "Melakukan hidrasi",
                    "Menganjurkan berhenti merokok",
                    "Menganjurkan berolah raga rutin",
                    "Menganjurkan mengecek air mandi untuk menghindari kulit terbakar",
                    "Menganjurkan menggunakan obat penurun tekanan darah, antikoagulan, dan penurun kolesterol, jika perlu",
                    "Menganjurkan minum obat pengontrol tekanan darah secara teratur",
                    "Menganjurkan menghindari penggunaan obat penyekat beta",
                    "Menganjurkan melakukan perawatan kulit yang tepat (mis: melembabkan kulit kering pada kaki)",
                    "Menganjurkan program rehabilitasi vaskuler",
                    "Menganjurkan program diet untuk memperbaiki sirkulasi (mis: rendah lemak jenuh, minyak ikan omega 3)",
                    "Menginformasikan tanda dan gejala darurat yang harus dilaporkan (mis: rasa sakit yang tidak hilang saat istirahat, luka tidak sembuh, hilangnya rasa)",
                    "Melakukan pemantauan hasil laboratorium",
                    "Melakukan pemantauan hemodinamik invasif",
                    "Melakukan pemantauan tanda vital",
                    "Melakukan pemakaian stoking elastis",
                    "Melakukan pemberian obat intravena",
                    "Melakukan pemberian obat oral",
                    "Melakukan pemberian produk darah",
                    "Melakukan pencegahan luka tekan",
                    "Melakukan pengambilan sampel darah arteri",
                    "Melakukan pengambilan sampel darah vena",
                    "Melakukan pengaturan posisi",
                    "Melakukan perawatan emboli perifer",
                    "Melakukan perawatan kaki",
                    "Melakukan perawatan neurovaskuler",
                    "Melakukan promosi latihan fisik",
                    "Menganjurkan terapi bekam",
                    "Melakukan terapi intravena",
                    "Melakukan terapi oksigen",
                    "Melakukan tourniquet pneumatik",
                    "Melakukan uji laboratorium di tempat tidur"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'DIARE') {
                var optionIntervensi = [
                    "Identifikasi penyebab diare (mis: inflamasi gastrointestinal, proses infeksi, malabsorpsi, ansietas, stres, obat-obatan, pemberian botol susu)",
                    "Identifikasi riwayat pemberian makanan",
                    "Identifikasi gejala invaginasi (mis: tangisan, keras, kepucatan pada bayi)",
                    "Monitor warna, volume, frekuensi, dan konsistensi feses",
                    "Monitor tanda dan gejala hypovolemia (mis: takikardia, nadi teraba lemah, tekanan darah turun, turgor kulit turun, mukosa, kulit kering, CRT melambat, BB menurun)",
                    "Monitor iritasi dan ulserasi kulit di daerah perianal",
                    "Monitor jumlah pengeluaran diare",
                    "Monitor keamanan penyiapan makanan",
                    "Berikan asupan cairan oral (mis: larutan garam gula, oralit, pedialyte, renalyte)",
                    "Pasang jalur intravena",
                    "Berikan cairan intravena (mis: ringer asetat, ringer laktat), jika perlu",
                    "Anjurkan makan porsi kecil dan sering secara bertahap",
                    "Anjurkan menghindari makanan pembentuk gas, pedas, dan mengandung laktosa",
                    "Anjurkan melanjutkan pemberian ASI",
                    "Kolaborasi pemberian obat antimotilitas (mis: loperamid, difenoksilat)",
                    "Kolaborasi pemberian antispasmodik/spasmolitik (mis: papaverine, ekstrak belladonna, mebeverine)",
                    "Kolaborasi pemberian pengeras feses (mis: atapugit, smektit, kaolin-pektin)",
                    "Monitor frekuensi dan kekuatan nadi",
                    "Monitor frekuensi napas",
                    "Monitor tekanan darah",
                    "Monitor berat badan",
                    "Monitor waktu pengisian kapiler",
                    "Monitor elastisitas atau turgor kulit",
                    "Monitor jumlah, warna, dan berat jenis urin",
                    "Monitor kadar albumin dan protein total",
                    "Monitor hasil pemeriksaan serum (mis: osmolaritas serum, hematokrit natrium, kalium, BUN)",
                    "Monitor intake dan output cairan",
                    "Identifikasi tanda-tanda hipovolemia (mis: frekuensi nadi meningkat, nadi teraba lemah, tekanan darah menurun, tekanan nadi menyempit, turgor kulit menurun, hematokrit meningkat, haus, lemah, konsentrasi urin meningkat, berat badan menurun dalam waktu singkat)",
                    "Identifikasi tanda-tanda hipovolemia (mis: dyspnea, edema perifer, edema anasarca, JVP meningkat, refleks hepatojugular positif, berat badan menurun dalam waktu singkat)",
                    "Identifikasi faktor risiko ketidakseimbangan cairan",
                    "Atur interval waktu pemantauan sesuai dengan kondisi pasien",
                    "Dokumentasi hasil pemantauan",
                    "Jelaskan tujuan dan prosedur pemantauan",
                    "Informasikan hasil pemantauan, jika perlu"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi penyebab diare (mis: inflamasi gastrointestinal, proses infeksi, malabsorpsi, ansietas, stres, obat-obatan, pemberian botol susu)",
                    "Mengidentifikasi riwayat pemberian makanan",
                    "Mengidentifikasi gejala invaginasi (mis: tangisan, keras, kepucatan pada bayi)",
                    "Memonitor warna, volume, frekuensi, dan konsistensi feses",
                    "Memonitor tanda dan gejala hypovolemia (mis: takikardia, nadi teraba lemah, tekanan darah turun, turgor kulit turun, mukosa, kulit kering, CRT melambat, BB menurun)",
                    "Memonitor iritasi dan ulserasi kulit di daerah perianal",
                    "Memonitor jumlah pengeluaran diare",
                    "Memonitor keamanan penyiapan makanan",
                    "Memberikan asupan cairan oral (mis: larutan garam gula, oralit, pedialyte, renalyte)",
                    "Memasang jalur intravena",
                    "Memberikan cairan intravena (mis: ringer asetat, ringer laktat), jika perlu",
                    "Menganjurkan makan porsi kecil dan sering secara bertahap",
                    "Menganjurkan menghindari makanan pembentuk gas, pedas, dan mengandung laktosa",
                    "Menganjurkan melanjutkan pemberian ASI",
                    "Melakukan kolaborasi pemberian obat antimotilitas (mis: loperamid, difenoksilat)",
                    "Melakukan kolaborasi pemberian antispasmodik/spasmolitik (mis: papaverine, ekstrak belladonna, mebeverine)",
                    "Melakukan kolaborasi pemberian pengeras feses (mis: atapugit, smektit, kaolin-pektin)",
                    "Memonitor frekuensi dan kekuatan nadi",
                    "Memonitor frekuensi napas",
                    "Memonitor tekanan darah",
                    "Memonitor berat badan",
                    "Memonitor waktu pengisian kapiler",
                    "Memonitor elastisitas atau turgor kulit",
                    "Memonitor jumlah, warna, dan berat jenis urin",
                    "Memonitor kadar albumin dan protein total",
                    "Memonitor hasil pemeriksaan serum (mis: osmolaritas serum, hematokrit natrium, kalium, BUN)",
                    "Memonitor intake dan output cairan",
                    "Mengidentifikasi tanda-tanda hipovolemia (mis: frekuensi nadi meningkat, nadi teraba lemah, tekanan darah menurun, tekanan nadi menyempit, turgor kulit menurun, hematokrit meningkat, haus, lemah, konsentrasi urin meningkat, berat badan menurun dalam waktu singkat)",
                    "Mengidentifikasi tanda-tanda hipovolemia (mis: dyspnea, edema perifer, edema anasarca, JVP meningkat, refleks hepatojugular positif, berat badan menurun dalam waktu singkat)",
                    "Mengidentifikasi faktor risiko ketidakseimbangan cairan",
                    "Mengatur interval waktu pemantauan sesuai dengan kondisi pasien",
                    "Mendokumentasi hasil pemantauan",
                    "Menjelaskan tujuan dan prosedur pemantauan",
                    "Menginformasikan hasil pemantauan, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'HIPERVOLEMIA') {
                var optionIntervensi = [
                    "Periksa tanda dan gejala hipervolemia (mis: ortopnea, dyspnea, edema, jvp/cvp meningkat, refleks hepatojugular positif, suara napas tambahan)",
                    "Identifikasi penyebab hipervolemia",
                    "Monitor intake dan output cairan",
                    "Monitor tanda hemokonsentrasi (mis: kadar natrium, BUN, hematokrit, berat jenis urin)",
                    "Monitor kecepatan infus secara ketat",
                    "Timbang berat badan setiap hari pada waktu yang sama",
                    "Batasi asupan cairan dan garam",
                    "Tinggikan 30-40*",
                    "Anjurkan melaporkan jika haluaran urine <0,5 ml/kg/jam dalam 6 jam",
                    "Anjurkan melaporkan jika berat badan bertambah >1kg dalam sehari",
                    "Ajarkan cara membatasi cairan",
                    "Kolaborasi pemberian diuretik"
                ];

                var optionImplementasi = [
                    "Memeriksa tanda dan gejala hipervolemia (mis: ortopnea, dyspnea, edema, jvp/cvp meningkat, refleks hepatojugular positif, suara napas tambahan)",
                    "Mengidentifikasi penyebab hipervolemia",
                    "Memonitor intake dan output cairan",
                    "Memonitor tanda hemokonsentrasi (mis: kadar natrium, BUN, hematokrit, berat jenis urin)",
                    "Memonitor kecepatan infus secara ketat",
                    "Menimbang berat badan setiap hari pada waktu yang sama",
                    "Membatasi asupan cairan dan garam",
                    "Meninggikan 30-40*",
                    "Menganjurkan melaporkan jika haluaran urine <0,5 ml/kg/jam dalam 6 jam",
                    "Menganjurkan melaporkan jika berat badan bertambah >1kg dalam sehari",
                    "Mengajarkan cara membatasi cairan",
                    "Melakukan kolaborasi pemberian diuretik"
                ];
                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'RESIKO HIPERVOLEMIA') {
                var optionIntervensi = [
                    "Periksa tanda dan gejala hipovolemia  (mis. Frekuensi nadi meningkat, nadi teraba lemah, tekanan darah menurun, tekanan nadi menyempit, turgor kulit menurun, membran mukosa kering, volume urin menurun, hematokrit meningkat, haus, lemah)",
                    "Hitung kebutuhan cairan",
                    "Monitor intake dan output cairan",
                    "Berikan posisi Modified Trendelenburg",
                    "Berikan asupan cairan oral",
                    "Anjurkan memperbanyak asupan cairan oral",
                    "Anjurkan menghindari perubahan posisi mendadak",
                    "Kolaborasi pemberian cairan IV isotonis (mis: NaCl, RL)",
                    "Kolaborasi pemberian cairan hipotonis (mis: Glukosa 2,5%, NaCl 0,4%)",
                    "Kolaborasi pemberian cairan koloid (mis: Albumin, Plasmanate)",
                    "Kolaborasi pemberian produk darah"
                ];

                var optionImplementasi = [
                    "Memeriksa tanda dan gejala hipovolemia  (mis. Frekuensi nadi meningkat, nadi teraba lemah, tekanan darah menurun, tekanan nadi menyempit, turgor kulit menurun, membran mukosa kering, volume urin menurun, hematokrit meningkat, haus, lemah)",
                    "Menghitung kebutuhan cairan",
                    "Memonitor intake dan output cairan",
                    "Memberikan posisi Modified Trendelenburg",
                    "Memberikan asupan cairan oral",
                    "Menganjurkan memperbanyak asupan cairan oral",
                    "Menganjurkan menghindari perubahan posisi mendadak",
                    "Melakukan kolaborasi pemberian cairan IV isotonis (mis: NaCl, RL)",
                    "Melakukan kolaborasi pemberian cairan hipotonis (mis: Glukosa 2,5%, NaCl 0,4%)",
                    "Melakukan kolaborasi pemberian cairan koloid (mis: Albumin, Plasmanate)",
                    "Melakukan kolaborasi pemberian produk darah"
                ];
                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'RESIKO KETIDAKSTABILAN KADAR GULA') {
                var optionIntervensi = [
                    "Identifikasi kemungkinan penyebab hiperglikemia",
                    "Identifikasi situasi yang menyebabkan kebutuhan insulin meningkat",
                    "Monitor kadar glukosa darah",
                    "Monitor tanda dan gejala hiperglikemia",
                    "Monitor intake dan output cairan",
                    "Monitor keton urin, kadar AGD, elektrolit, tekanan darah ortostatik dan frekuensi nadi",
                    "Berikan asupan cairan oral",
                    "Konsultasi dengan medis jika tanda hiperglikemia dan gejala hiperglikemia tetap ada atau memburuk",
                    "Fasilitasi ambulasi jika ada hipotensi ortostatik",
                    "Anjurkan menghindari olahraga saat kadar glukosa darah lebih dari 250mg/dl",
                    "Anjurkan monitor kadar glukosa darah secara mandiri",
                    "Anjurkan kepatuhan terhadap diet dan olahraga",
                    "Ajarkan indikasi dan pentingnya pengujian keton urin",
                    "Ajarkan pengelolaan diabetes (penggunaan insulin, obat oral, monitor asupan cairan, penggantian karbohidrat, dan bantuan profesional kesehatan)",
                    "Kolaborasi pemberian insulin, jika perlu",
                    "Kolaborasi pemberian cairan IV, jika perlu",
                    "Kolaborasi pemberian kalium, jika perlu",
                    "Identifikasi tanda dan gejala hipoglikemia",
                    "Identifikasi kemungkinan penyebab hipoglikemia",
                    "Berikan karbohidrat sederhana",
                    "Berikan glucagon jika perlu",
                    "Berikan karbohidrat kompleks dan protein sesuai diet",
                    "Pertahankan kepatenan jalan nafas",
                    "Pertahankan akses IV",
                    "Hubungi layanan medis darurat, jika perlu",
                    "Anjurkan membawa karbohidrat sederhana setiap saat",
                    "Anjurkan memakai identitas darurat yang tepat",
                    "Anjurkan monitor kadar glukosa darah",
                    "Anjurkan berdiskusi dengan tim perawatan diabetes tentang penyesuaian program pengobatan",
                    "Jelaskan interaksi diet, insulin atau agen oral dan olahraga",
                    "Ajarkan pengelolaan hipoglikemia (tanda dan gejala, faktor resiko, dan pengobatan hipoglikemia)",
                    "Ajarkan perawatan mandiri untuk mencegah hipoglikemia (mengurangi insulin atau agen oral dan atau meningkatkan asupan makanan untuk berolahraga)",
                    "Kolaborasi pemberian dekstrose",
                    "Kolaborasi pemberian glukagon"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi kemungkinan penyebab hiperglikemia",
                    "Mengidentifikasi situasi yang menyebabkan kebutuhan insulin meningkat",
                    "Memonitor kadar glukosa darah",
                    "Memonitor tanda dan gejala hiperglikemia",
                    "Memonitor intake dan output cairan",
                    "Memonitor keton urin, kadar AGD, elektrolit, tekanan darah ortostatik dan frekuensi nadi",
                    "Memberikan asupan cairan oral",
                    "Melakukan konsultasi dengan medis jika tanda hiperglikemia dan gejala hiperglikemia tetap ada atau memburuk",
                    "Memfasilitasi ambulasi jika ada hipotensi ortostatik",
                    "Menganjurkan menghindari olahraga saat kadar glukosa darah lebih dari 250mg/dl",
                    "Menganjurkan monitor kadar glukosa darah secara mandiri",
                    "Menganjurkan kepatuhan terhadap diet dan olahraga",
                    "Mengajarkan indikasi dan pentingnya pengujian keton urin",
                    "Mengajarkan pengelolaan diabetes (penggunaan insulin, obat oral, monitor asupan cairan, penggantian karbohidrat, dan bantuan profesional kesehatan)",
                    "Melakukan kolaborasi pemberian insulin, jika perlu",
                    "Melakukan kolaborasi pemberian cairan IV, jika perlu",
                    "Melakukan kolaborasi pemberian kalium, jika perlu",
                    "Mengidentifikasi tanda dan gejala hipoglikemia",
                    "Mengidentifikasi kemungkinan penyebab hipoglikemia",
                    "Memberikan karbohidrat sederhana",
                    "Memberikan glucagon jika perlu",
                    "Memberikan karbohidrat kompleks dan protein sesuai diet",
                    "Mempertahankan kepatenan jalan nafas",
                    "Mempertahankan akses IV",
                    "Menghubungi layanan medis darurat, jika perlu",
                    "Menganjurkan membawa karbohidrat sederhana setiap saat",
                    "Menganjurkan memakai identitas darurat yang tepat",
                    "Menganjurkan monitor kadar glukosa darah",
                    "Menganjurkan berdiskusi dengan tim perawatan diabetes tentang penyesuaian program pengobatan",
                    "Menjelaskan interaksi diet, insulin atau agen oral dan olahraga",
                    "Mengajarkan pengelolaan hipoglikemia (tanda dan gejala, faktor resiko, dan pengobatan hipoglikemia)",
                    "Mengajarkan perawatan mandiri untuk mencegah hipoglikemia (mengurangi insulin atau agen oral dan atau meningkatkan asupan makanan untuk berolahraga)",
                    "Melakukan kolaborasi pemberian dekstrose",
                    "Melakukan kolaborasi pemberian glukagon"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'GANGGUAN MOBILITAS FISIK') {
                var optionIntervensi = [
                    "Identifikasi adanya nyeri atau keluhan fisik lainnya",
                    "Identifikasi toleransi fisik melakukan pergerakan",
                    "Monitor frekuensi jantung dan tekanan darah sebelum memulai mobilisasi",
                    "Monitor kondisi umum selama melakukan mobilisasi terapeutik",
                    "Fasilitasi pergerakan jika perlu",
                    "Libatkan keluarga untuk membantu pasien dalam meningkatkan pergerakan",
                    "Jelaskan tujuan dan prosedur mobilisasi",
                    "Anjurkan melakukan mobilisasi dini ",
                    "Ajarkan mobilisasi sederhana yang harus dilakukan (mis: duduk ditempat tidur, duduk disisi tempat tidur, pindah dari tempat tidur ke kursi)"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi adanya nyeri atau keluhan fisik lainnya",
                    "Mengidentifikasi toleransi fisik melakukan pergerakan",
                    "Memonitor frekuensi jantung dan tekanan darah sebelum memulai mobilisasi",
                    "Memonitor kondisi umum selama melakukan mobilisasi terapeutik",
                    "Memfasilitasi pergerakan jika perlu",
                    "Melibatkan keluarga untuk membantu pasien dalam meningkatkan pergerakan",
                    "Menjelaskan tujuan dan prosedur mobilisasi",
                    "Menganjurkan melakukan mobilisasi dini ",
                    "Mengajarkan mobilisasi sederhana yang harus dilakukan (mis: duduk ditempat tidur, duduk disisi tempat tidur, pindah dari tempat tidur ke kursi)"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'NYERI KRONIS') {
                var optionIntervensi = [
                    "Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri",
                    "Identifikasi skala nyeri",
                    "Identifikasi respon nyeri nonverbal",
                    "Identifikasi factor yang memperingan dan memperberat nyeri",
                    "Identifikasi pengetahuan dan keyakinan tentang nyeri",
                    "Identifikasi budaya terhadap respon nyeri",
                    "Identifikasi pengaruh nyeri terhadap kualitas hidup pasien",
                    "Monitor efek samping penggunaan analgetik",
                    "Monitor keberhasilan terapi komplementer yang sudah diberikan",
                    "Fasilitasi istirahat tidur kontrol lingkungan yang memperberat nyeri (mis: suhu ruangan, pencahayaan, dan kebisingan)",
                    "Beri teknik non farmakologis untuk meredakan nyeri (aromaterapi, terapi pijat, hypnosis, biofeedback, teknik imajinasi terbimbing, teknik tarik napas dalam dan kompres hangat/dingin)",
                    "Kontrol lingkungan yang memperberat nyeri(suhu ruangan, pencahayaan, dan kebisingan)",
                    "Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri",
                    "Jelaskan penyebab, periodde dan pemicu nyeri",
                    "Jelaskan strategi meredakan nyeri",
                    "Anjurkan menggunakan analgetik secara tepat",
                    "Anjurkan monitor nyeri secara mandiri",
                    "Ajarkan teknik nonfarmakologis untuk mengurangi rasa nyeri",
                    "Identifikasi gejala yang tidak menyenangkan (mis: mual, nyeri, gatal, sesak)",
                    "Identifikasi pemahaman tentang kondisi, situasi, dan perasaannya",
                    "Identifikasi masalah emosional dan spiritual",
                    "Berikan posisi yang nyaman",
                    "Ciptakan lingkungan yang nyaman",
                    "Berikan kompres dingin atau hangat",
                    "Dukung keluarga dan pengasuh terlibat dalam terapi/pengobatan",
                    "Diskusikan mengenai situasi dan pilihan terapi atau pengobatan yang diinginkan",
                    "Jelaskan mengenai kondisi dan pilihan terapi/pengobatan",
                    "Ajarkan terapi relaksasi",
                    "Ajarkan Teknik distraksi dan imajinasi terbimbing",
                    "Ajarkan latihan pernafasan",
                    "Kolaborasi pemberian analgetik, jika perlu"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri",
                    "Mengidentifikasi skala nyeri",
                    "Mengidentifikasi respon nyeri nonverbal",
                    "Mengidentifikasi factor yang memperingan dan memperberat nyeri",
                    "Mengidentifikasi pengetahuan dan keyakinan tentang nyeri",
                    "Mengidentifikasi budaya terhadap respon nyeri",
                    "Mengidentifikasi pengaruh nyeri terhadap kualitas hidup pasien",
                    "Memonitor efek samping penggunaan analgetik",
                    "Memonitor keberhasilan terapi komplementer yang sudah diberikan",
                    "Memfasilitasi istirahat tidur kontrol lingkungan yang memperberat nyeri (mis: suhu ruangan, pencahayaan, dan kebisingan)",
                    "Memberi teknik non farmakologis untuk meredakan nyeri (aromaterapi, terapi pijat, hypnosis, biofeedback, teknik imajinasi terbimbing, teknik tarik napas dalam dan kompres hangat/dingin)",
                    "Melakukan kontrol lingkungan yang memperberat nyeri(suhu ruangan, pencahayaan, dan kebisingan)",
                    "Mempertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri",
                    "Menjelaskan penyebab, periodde dan pemicu nyeri",
                    "Menjelaskan strategi meredakan nyeri",
                    "Menganjurkan menggunakan analgetik secara tepat",
                    "Menganjurkan monitor nyeri secara mandiri",
                    "Mengajarkan teknik nonfarmakologis untuk mengurangi rasa nyeri",
                    "Mengidentifikasi gejala yang tidak menyenangkan (mis: mual, nyeri, gatal, sesak)",
                    "Mengidentifikasi pemahaman tentang kondisi, situasi, dan perasaannya",
                    "Mengidentifikasi masalah emosional dan spiritual",
                    "Memberikan posisi yang nyaman",
                    "Menciptakan lingkungan yang nyaman",
                    "Memberikan kompres dingin atau hangat",
                    "Mendukung keluarga dan pengasuh terlibat dalam terapi/pengobatan",
                    "Mendiskusikan mengenai situasi dan pilihan terapi atau pengobatan yang diinginkan",
                    "Menjelaskan mengenai kondisi dan pilihan terapi/pengobatan",
                    "Mengajarkan terapi relaksasi",
                    "Mengajarkan Teknik distraksi dan imajinasi terbimbing",
                    "Mengajarkan latihan pernafasan",
                    "Melakukan kolaborasi pemberian analgetik, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'DEFISIT PENGETAHUAN TENTANG PENYAKIT / PERAWATAN') {
                var optionIntervensi = [
                    "Identifikasi kesiapan dan kemampuan menerima informasi",
                    "Identifikasi faktor-faktor yang dapat meningkatkan dan menurunkan motivasi perilaku hidup bersih dan sehat",
                    "Sediakan materi dan media pendidikan kesehatan",
                    "Jadwalkan pendidikan kesehatan sesuai kesepakatan",
                    "Berikan kesempatan untuk bertanya",
                    "Jelaskan faktor risiko yang dapat mempengaruhi kesehatan",
                    "Ajarkan perilaku hidup bersih dan sehat",
                    "Ajarkan strategi yang dapat digunakan untuk meningkatkan perilaku hidup bersih dan sehat"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi kesiapan dan kemampuan menerima informasi",
                    "Mengidentifikasi faktor-faktor yang dapat meningkatkan dan menurunkan motivasi perilaku hidup bersih dan sehat",
                    "Menyediakan materi dan media pendidikan kesehatan",
                    "Menjadwalkan pendidikan kesehatan sesuai kesepakatan",
                    "Memnerikan kesempatan untuk bertanya",
                    "Menjelaskan faktor risiko yang dapat mempengaruhi kesehatan",
                    "Mengajarkan perilaku hidup bersih dan sehat",
                    "Mengajarkan strategi yang dapat digunakan untuk meningkatkan perilaku hidup bersih dan sehat"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'GANGGUAN INTEGRITAS KULIT / JARINGAN') {
                var optionIntervensi = [
                    "Identifikasi penyebab gangguan integritas kulit(mis: perubahan sirkulasi, perubahan status nutrisi, penurunan kelembaban, suhu lingkungan ekstrem, penurunan mobilitas)",
                    "Ubah posisi tiap 2 jam jika tirah baring",
                    "Lakukan pemijatan pada area penonjolan tulang, jika perlu",
                    "Bersihkan perineal dengan air hangat, terutama pada saat periode diare",
                    "Gunakan produk berbahan petrolium",
                    "Gunakan produk berbahan ringan/alami dan hipoalergik pada kulit sensitive",
                    "Hindari produk berbahan dasar alcohol pada kulit kering",
                    "Anjurkan menggunakan pelembab (mis: lotion, serum)",
                    "Anjurkan minum air yang cukup",
                    "Anjurkan meningkatkan asupan nutrisi",
                    "Anjurkan meningkatkan asupan buah dan sayur",
                    "Anjurkan menghindari terpapar suhu ekstrem",
                    "Anjurkan menggunakan tabir surya SPF minimal 30 saat berada di luar rumah",
                    "Anjurkan mandi dan menggunakan sabun secukupnya",
                    "Monitor karakteristik luka (mis: Drainase, warna, ukuran, bau)",
                    "Monitor tanda-tanda infeksi",
                    "Lepaskan balutan dan plester secara perlahan",
                    "Cukur rambut didaerah luka, jika perlu",
                    "Bersihkan dengan cairan NaCI atau pembersih nontoksik, sesuai kebutuhan",
                    "Bersihkan jaringan nekrotik",
                    "Berikan salep yang sesuai ke kulit, jika perlu",
                    "Pasang balutan sesuai jenis luka",
                    "Pertahankan teknik steril saat melakukan perawatn luka",
                    "Ganti balutan sesuai jumlah eksudat dan drainase",
                    "Jadwalkan perubahan posisi setiap 2 jam atau sesuai kondisi pasien",
                    "Jelaskan tanda dan gejala infeksi",
                    "Anjurkan mengkonsumsi makanan tinggi kalori dan protein",
                    "Ajarkan prosedur perawatan luka secara mandiri",
                    "Kolaborasi prosedur debridement (mis: Enzimatik, biologis mekanis, autolitik), jika perlu",
                    "Kolaborasi pemberian antibiotic"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi penyebab gangguan integritas kulit(mis: perubahan sirkulasi, perubahan status nutrisi, penurunan kelembaban, suhu lingkungan ekstrem, penurunan mobilitas)",
                    "Mengubah posisi tiap 2 jam jika tirah baring",
                    "Melakukan pemijatan pada area penonjolan tulang, jika perlu",
                    "Membersihkan perineal dengan air hangat, terutama pada saat periode diare",
                    "Menggunakan produk berbahan petrolium",
                    "Menggunakan produk berbahan ringan/alami dan hipoalergik pada kulit sensitive",
                    "Menghindari produk berbahan dasar alcohol pada kulit kering",
                    "Menganjurkan menggunakan pelembab (mis: lotion, serum)",
                    "Menganjurkan minum air yang cukup",
                    "Menganjurkan meningkatkan asupan nutrisi",
                    "Menganjurkan meningkatkan asupan buah dan sayur",
                    "Menganjurkan menghindari terpapar suhu ekstrem",
                    "Menganjurkan menggunakan tabir surya SPF minimal 30 saat berada di luar rumah",
                    "Menganjurkan mandi dan menggunakan sabun secukupnya",
                    "Memonitor karakteristik luka (mis: Drainase, warna, ukuran, bau)",
                    "Memonitor tanda-tanda infeksi",
                    "Melepaskan balutan dan plester secara perlahan",
                    "Mencukur rambut didaerah luka, jika perlu",
                    "Membersihkan dengan cairan NaCI atau pembersih nontoksik, sesuai kebutuhan",
                    "Membersihkan jaringan nekrotik",
                    "Memberikan salep yang sesuai ke kulit, jika perlu",
                    "Memasang balutan sesuai jenis luka",
                    "Mempertahankan teknik steril saat melakukan perawatn luka",
                    "Mengganti balutan sesuai jumlah eksudat dan drainase",
                    "Menjadwalkan perubahan posisi setiap 2 jam atau sesuai kondisi pasien",
                    "Menjelaskan tanda dan gejala infeksi",
                    "Menganjurkan mengkonsumsi makanan tinggi kalori dan protein",
                    "Mengajarkan prosedur perawatan luka secara mandiri",
                    "Melakukan kolaborasi prosedur debridement (mis: Enzimatik, biologis mekanis, autolitik), jika perlu",
                    "Melakukan kolaborasi pemberian antibiotic"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'HIPERTERMIA') {
                var optionIntervensi = [
                    "Identifikasi penyebab hipotermia (mis: dehidrasi, terpapar lingkungan panas, penggunaan inkubator)",
                    "Monitor suhu tubuh",
                    "Monitor kadar elektrolit",
                    "Monitor haluaran urine",
                    "Monitor komplikasi akibat hipertermia",
                    "Identifikasi kesiapan dan kemampuan menerima informassi",
                    "Sediakan lingkungan yang dingin",
                    "Longgarkan atau lepaskan pakaian",
                    "Basahi dan kipas permukaan tubuh",
                    "Berikan cairan oral",
                    "Ganti linen setiap hari atau lebih sering jika mengalami hiperhidrosis (keringat berlebih)",
                    "Lakukan pendinginan eksternal (mis: selimut hipotermia atau kompres dingin pada dahi, leher, dada, abdomen, aksila)",
                    "Hindari pemberian antipiretik atau aspirin",
                    "Berikan oksigen, jika perlu",
                    "Sediakan materi dan media pendidikan kesehatan jadwalkan pendidikan kesehatan sesuai kesepakatan",
                    "Berikan kesempatan untuk bertanya",
                    "Anjurkan tirah baring",
                    "Ajarkan kompres hangat jika demam",
                    "Ajarkan cara mengukur suhu",
                    "Anjurkan penggunaan pakaian yang dapat menyerap keringat",
                    "Anjurkan tetap memandikan pasien, jika memungkinkan",
                    "Anjurkan pemberian antipiretik, sesuai indikasi",
                    "Anjurkan menciptakan lingkungan yang nyaman",
                    "Anjurkan banyak minum",
                    "Anjurkan penggunaan pakaian yang longgar",
                    "Anjurkan minum analgestik jika merasa pusing, sesuai indikasi",
                    "Anjurkan melakukan pemeriksaan darah jika demam >3 hari",
                    "Kolaborasi pemberian cairan dan elektrolit intravena, jika perlu"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi penyebab hipotermia (mis: dehidrasi, terpapar lingkungan panas, penggunaan inkubator)",
                    "Memonitor suhu tubuh",
                    "Memonitor kadar elektrolit",
                    "Memonitor haluaran urine",
                    "Memonitor komplikasi akibat hipertermia",
                    "Mengidentifikasi kesiapan dan kemampuan menerima informassi",
                    "Menyediakan lingkungan yang dingin",
                    "Melonggarkan atau lepaskan pakaian",
                    "Membasahi dan kipas permukaan tubuh",
                    "Memberikan cairan oral",
                    "Mengganti linen setiap hari atau lebih sering jika mengalami hiperhidrosis (keringat berlebih)",
                    "Melakukan pendinginan eksternal (mis: selimut hipotermia atau kompres dingin pada dahi, leher, dada, abdomen, aksila)",
                    "Menghindari pemberian antipiretik atau aspirin",
                    "Memberikan oksigen, jika perlu",
                    "Menyediakan materi dan media pendidikan kesehatan jadwalkan pendidikan kesehatan sesuai kesepakatan",
                    "Memberikan kesempatan untuk bertanya",
                    "Menganjurkan tirah baring",
                    "Mengajarkan kompres hangat jika demam",
                    "Mengajarkan cara mengukur suhu",
                    "Menganjurkan penggunaan pakaian yang dapat menyerap keringat",
                    "Menganjurkan tetap memandikan pasien, jika memungkinkan",
                    "Menganjurkan pemberian antipiretik, sesuai indikasi",
                    "Menganjurkan menciptakan lingkungan yang nyaman",
                    "Menganjurkan banyak minum",
                    "Menganjurkan penggunaan pakaian yang longgar",
                    "Menganjurkan minum analgestik jika merasa pusing, sesuai indikasi",
                    "Menganjurkan melakukan pemeriksaan darah jika demam >3 hari",
                    "Melakukan kolaborasi pemberian cairan dan elektrolit intravena, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'BODY IMAGE') {
                var optionIntervensi = [
                    "Identifikasi harapan cintra tubuh berdasarkan tahap perkembangan",
                    "Identifikasi budaya, agama, jenis kelamin, dan umur terkait citra tubuh",
                    "Identifikasi perubahan citra tubuh yang mengakibatkan isolasi sosial",
                    "Monitor frekuensi pernyataan kritik terhadap diri sendiri",
                    "Monitor apakah pasien bisa melihat bagian tubuh yang berubah",
                    "Diskusikan perubahan tubuh dan fungsinya",
                    "Diskusikan perbedaan penampilan fisik terhadap harga diri",
                    "Diskusikan perubahan akibat pubertas, kehamilan dan penuaan",
                    "Diskusikan kondisi stres yang mempengaruhi citra tubuh (mis: luka, penyakit, pembedahan)",
                    "Diskusikan cara mengembangkan harapan citra tubuh secara realistis",
                    "Diskusikan persepsi pasien dan keluarga tentang perubahan citra tubuh",
                    "Jelaskan kepada keluarga tentang perawatan perubahan citra tubuh",
                    "Anjurkan mengungkapkan gambaran diri terhadap citra tubuh",
                    "Anjurkan menggunakan alat bantu (mis: pakaian, wig, kosmetik)",
                    "Anjurkan mengikuti kelompok pendukung (mis: kelompok sebaya)",
                    "Latih fungsi tubuh yang dimiliki",
                    "Latih pengingkatan penampilan diri (mis: berdandan)",
                    "Latih pengungkapan kemampuan diri kepada orang lain"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi harapan cintra tubuh berdasarkan tahap perkembangan",
                    "Mengidentifikasi budaya, agama, jenis kelamin, dan umur terkait citra tubuh",
                    "Mengidentifikasi perubahan citra tubuh yang mengakibatkan isolasi sosial",
                    "Memonitor frekuensi pernyataan kritik terhadap diri sendiri",
                    "Memonitor apakah pasien bisa melihat bagian tubuh yang berubah",
                    "Mendiskusikan perubahan tubuh dan fungsinya",
                    "Mendiskusikan perbedaan penampilan fisik terhadap harga diri",
                    "Mendiskusikan perubahan akibat pubertas, kehamilan dan penuaan",
                    "Mendiskusikan kondisi stres yang mempengaruhi citra tubuh (mis: luka, penyakit, pembedahan)",
                    "Mendiskusikan cara mengembangkan harapan citra tubuh secara realistis",
                    "Mendiskusikan persepsi pasien dan keluarga tentang perubahan citra tubuh",
                    "Menjelaskan kepada keluarga tentang perawatan perubahan citra tubuh",
                    "Menganjurkan mengungkapkan gambaran diri terhadap citra tubuh",
                    "Menganjurkan menggunakan alat bantu (mis: pakaian, wig, kosmetik)",
                    "Menganjurkan mengikuti kelompok pendukung (mis: kelompok sebaya)",
                    "Melatih fungsi tubuh yang dimiliki",
                    "Melatih pengingkatan penampilan diri (mis: berdandan)",
                    "Melatih pengungkapan kemampuan diri kepada orang lain"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'CEMAS') {
                var optionIntervensi = [
                    "Identifikasi saat tingkat ansietas berubah",
                    "Identifikasi kemampuan mengambil keputusan",
                    "Monitor tanda-tanda ansietas (verbal dan nonverbal)",
                    "Ciptakan suasana terapeutik untuk menumbuhkan kepercayaan",
                    "Temani pasien untuk mengurangi kecemasan, jika memungkinkan",
                    "Pahami situasi yang membuat ansietas",
                    "Dengarkan dengan penuh perhatian",
                    "Gunakan pendekatan yang tenang dan meyakinkan",
                    "Tempatkan barang pribadi yang memberikan kenyamanan",
                    "Motivasi mengidentifikasi situasi yang memicu kecemasan",
                    "Diskusikan perencanaan yang realistis tentang peristiwa yang akan datang",
                    "Jelaskan prosedur, termasuk sensasi yang mungkin dialami",
                    "Informasikan secara factual mengenai, diagnosis, pengobatan, dan prognosis",
                    "Anjurkan keluarga untuk tetap bersama pasien, jika perlu",
                    "Anjurkan melakukan kegiatan yang tidak kompetitif, jika perlu",
                    "Anjurkan mengungkapkan perasaan dan persepsi",
                    "Latih kegiatan pengalihan untuk mengurangi ketegangan",
                    "Latih penggunaan mekanisme pertahanan diri yang tepat",
                    "Latih teknik relaksaksi",
                    "Kolaborasi penggunaan obat ansietas, jika perlu",
                    "Identifikasi penurunan tingkat energi, ketidakmampuan berkonsentrasi, atau gejala lain yang mengganggu kemampuan kognitif",
                    "Identifikasi teknik relaksaksi yang pernah efektif digunakan",
                    "Identifikasi kesediaan, kemampuan, dan penggunaan teknik sebelumnya",
                    "Periksa ketegangan otot, TTV sebelum dan setelah latihan",
                    "Monitor respon terhadap terapi relaksaksi",
                    "Ciptakan lingkungan tenang dan tanpa gangguan dengan pencahayaan dan suhu ruang nyaman, jika memungkinkan",
                    "Berikan informasi tertulis tentang persiapan dan prosedur teknik relaksaksi",
                    "Gunakan pakaian longgar",
                    "Gunakan nada suara lembut dengan irama lambat dan berirama",
                    "Gunakan relaksaksi sebagai strategi penunjang dengan analgetik atau tindakan medis lain, jika sesuai",
                    "Jelaskan tujuan, manfaat, batasan, dan jenis relaksaksi yang tersedia",
                    "Jelaskan secara rinci intervensi yang dipilih",
                    "Anjurkan mengambil posisi nyaman",
                    "Anjurkan rileks dan merasakan sensasi relaksaksi",
                    "Anjurkan sering mengulangi atau melatih teknik yang dipilih",
                    "Demonstrasikan dan latih teknik relaksaksi"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi saat tingkat ansietas berubah",
                    "Mengidentifikasi kemampuan mengambil keputusan",
                    "Memonitor tanda-tanda ansietas (verbal dan nonverbal)",
                    "Menciptakan suasana terapeutik untuk menumbuhkan kepercayaan",
                    "Menemani pasien untuk mengurangi kecemasan, jika memungkinkan",
                    "Memahami situasi yang membuat ansietas",
                    "Mendengarkan dengan penuh perhatian",
                    "Menggunakan pendekatan yang tenang dan meyakinkan",
                    "Menempatkan barang pribadi yang memberikan kenyamanan",
                    "Memotivasi mengidentifikasi situasi yang memicu kecemasan",
                    "Mendiskusikan perencanaan yang realistis tentang peristiwa yang akan datang",
                    "Menjelaskan prosedur, termasuk sensasi yang mungkin dialami",
                    "Menginformasikan secara factual mengenai, diagnosis, pengobatan, dan prognosis",
                    "Menganjurkan keluarga untuk tetap bersama pasien, jika perlu",
                    "Menganjurkan melakukan kegiatan yang tidak kompetitif, jika perlu",
                    "Menganjurkan mengungkapkan perasaan dan persepsi",
                    "Melatih kegiatan pengalihan untuk mengurangi ketegangan",
                    "Melatih penggunaan mekanisme pertahanan diri yang tepat",
                    "Melatih teknik relaksaksi",
                    "Melakukan kolaborasi penggunaan obat ansietas, jika perlu",
                    "Mengidentifikasi penurunan tingkat energi, ketidakmampuan berkonsentrasi, atau gejala lain yang mengganggu kemampuan kognitif",
                    "Mengidentifikasi teknik relaksaksi yang pernah efektif digunakan",
                    "Mengidentifikasi kesediaan, kemampuan, dan penggunaan teknik sebelumnya",
                    "Memeriksa ketegangan otot, TTV sebelum dan setelah latihan",
                    "Memonitor respon terhadap terapi relaksaksi",
                    "Menciptakan lingkungan tenang dan tanpa gangguan dengan pencahayaan dan suhu ruang nyaman, jika memungkinkan",
                    "Memberikan informasi tertulis tentang persiapan dan prosedur teknik relaksaksi",
                    "Menggunakan pakaian longgar",
                    "Menggunakan nada suara lembut dengan irama lambat dan berirama",
                    "Menggunakan relaksaksi sebagai strategi penunjang dengan analgetik atau tindakan medis lain, jika sesuai",
                    "Menjelaskan tujuan, manfaat, batasan, dan jenis relaksaksi yang tersedia",
                    "Menjelaskan secara rinci intervensi yang dipilih",
                    "Menganjurkan mengambil posisi nyaman",
                    "Menganjurkan rileks dan merasakan sensasi relaksaksi",
                    "Menganjurkan sering mengulangi atau melatih teknik yang dipilih",
                    "Mendemonstrasikan dan latih teknik relaksaksi"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'GANGGUAN PERSEFSI SENSORI') {
                var optionIntervensi = [
                    "Monitor perilaku yang mengindikasi halusinasi",
                    "Monitor dan sesuaikan tingkat aktivitas dan stimulasi lingkungan",
                    "Monitor isi halusinasi (mis: kekerasan atau membahayakan diri)",
                    "Pertahankan lingkungan yang aman",
                    "Lakukan tindakan keselamatan ketika tidak dapat mengontrol perilaku (mis: limit setting, pembatasan wilayah, pengekangan fisik, seklusi)",
                    "Diskusikan perasaan dan respon terhadap halusinasi",
                    "Anjurkan memonitor sendiri situasi terjadinya halusinasi",
                    "Anjurkan bicara pada orang yang dipercaya untuk memberi dukungan dan umpan balik korektif terhadap halusinasi",
                    "Anjurkan melakukan distraksi (mis: mendengarkan musik, melakukan aktifitas dan teknik relaksasi)",
                    "Ajarkan pasien dan keluarga cara mengontrol halusinasi",
                    "Kolaborasi pemberian obat antipsikotik dan antiansietas, jika perlu"
                ];
                var optionImplementasi = [
                    "Memonitor perilaku yang mengindikasi halusinasi",
                    "Memonitor dan sesuaikan tingkat aktivitas dan stimulasi lingkungan",
                    "Memonitor isi halusinasi (mis: kekerasan atau membahayakan diri)",
                    "Mempertahankan lingkungan yang aman",
                    "Melakukan tindakan keselamatan ketika tidak dapat mengontrol perilaku (mis: limit setting, pembatasan wilayah, pengekangan fisik, seklusi)",
                    "Mendiskusikan perasaan dan respon terhadap halusinasi",
                    "Menganjurkan memonitor sendiri situasi terjadinya halusinasi",
                    "Menganjurkan bicara pada orang yang dipercaya untuk memberi dukungan dan umpan balik korektif terhadap halusinasi",
                    "Menganjurkan melakukan distraksi (mis: mendengarkan musik, melakukan aktifitas dan teknik relaksasi)",
                    "Mengajarkan pasien dan keluarga cara mengontrol halusinasi",
                    "Melakukan kolaborasi pemberian obat antipsikotik dan antiansietas, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'DEFISIT NUTRISI') {
                var optionIntervensi = [
                    "Identifikasi Status nutrisi",
                    "Identifikasi alergi dan",
                    "Intoleransi makanan",
                    "Identifikasi makanan yang disukai",
                    "Identifikasi kebutuhan kalori dan jenis nutrien",
                    "Identifikasi perlunya penggunaan selang nasogastrik",
                    "Monitor asupan makanan",
                    "Monitor berat badan",
                    "Monitor hasil pemeriksaan laboratorium",
                    "Periksa status gizi, status alergi, program diet, kebutuhan dan kemampuan pemenuhan kebutuhan gizi",
                    "Identifikasi kemampuan dan waktu yang tetap menerima informasi dari",
                    "Identifikasi kesiapan dan kemampuan ibu atau pengasuh menerima informasi",
                    "Identifikasi kemampuan ibu atau pengasuh menyediakan nutrisi terapeutik",
                    "Lakukan oral hygienis sebelum makan, jika perlu",
                    "Falisitasi menentukan pedoman diet (mis: piramide makanan)",
                    "Sajikan makanan secara menarik dan suhu yang sesuai",
                    "Berikan makanan tinggi serat untuk mencegah konstipasi",
                    "Berikan makanan tinggi kalori dan tinggi protein",
                    "Berikan suplemen makanan, jika perlu",
                    "Hentikan pemberian makanan melalui selang nasogastrik jika asupan oral dapat ditoleransi",
                    "Persiapkan materi dan media seperti jenis-jenis nutrisi, tabal makanan penukar, cara mengelola, cara menakar makanan",
                    "Jadwalkan pendidikan kesehatan sesuai kesepakatan",
                    "Berikan kesempatan untuk bertanya",
                    "Anjurkan posisi duduk, jika mampu",
                    "Ajarkan diet yang diprogramkan",
                    "Jelaskan pada pasien dan keluarga alergi makanan, makanan yang harus dihindari, kebutuhan jumlah kalori, jenis makanan yang dibutuhkan pasien",
                    "Ajarkan cara melaksanakan diet sesuai program (mis: makanan tinggi protein, rendah garam, rendah kalori)",
                    "Jelaskan hal-hal yang dilakukan sebelum memberikan makan (mis: perawatan mulut, penggunaan gigi palsu, obat-obat yang harus diberikan sebelum makan)",
                    "Demonstrasikan cara membersihkan mulut",
                    "Demonstrasikan cara mengatur posisi saat makan",
                    "Ajarkan pasien atau keluarga memonitor asupan kalori dan makanan (mis: menggunakan buku harian)",
                    "Anjurkan mendemonstrasikan cara memberi makan, menghitung kalori, menyiapkan makanan sesuai program diet",
                    "Jelaskan tanda-tanda awal rasa lapar (mis: bayi gelisah, membuka mulut dan menggeleng-gelengkan kepala, menjulurkan lidah, menghisap jari atau tangan)",
                    "Anjurkan menghindari pemberian pemanis buatan",
                    "Ajarkan perilaku Hidup Bersih dan Sehat (PHBS) mis, cuci tangan sebelum dan sesudah makan, cuci tangan dengan sabun setelah ke toilet",
                    "Ajarkan cara memilih makanan sesuai dengan usia bayi",
                    "Ajarkan cara mengatur frekuensi makanan sesuai usia bayi",
                    "Anjurkan tetap memberikan ASI pada saat bayi sakit",
                    "Jelaskan tujuan dan prosedur pemberian nutrisi parenteral",
                    "Jelaskan hal-hal yang harus diperhatikan selama menjalan terapi parenteral (mis. kondisi lokasi dan keadaan selang)",
                    "Anjurkan memeriksa mulut secara teratur untuk tanda-tanda parotitis, glossitis dan lesi oral",
                    "Kolaborasi pemberian medikasi sebelum makan (mis: pereda nyeri, antlemetik), jika perlu",
                    "Kolaborasi dengan ahli gizi untuk menentukan jumlah kalori dan jenis nutrien yang dibutuhkan, jika perlu"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi Status nutrisi",
                    "Mengidentifikasi alergi dan",
                    "Mentoleransi makanan",
                    "Mengidentifikasi makanan yang disukai",
                    "Mengidentifikasi kebutuhan kalori dan jenis nutrien",
                    "Mengidentifikasi perlunya penggunaan selang nasogastrik",
                    "Memonitor asupan makanan",
                    "Memonitor berat badan",
                    "Memonitor hasil pemeriksaan laboratorium",
                    "Memeriksa status gizi, status alergi, program diet, kebutuhan dan kemampuan pemenuhan kebutuhan gizi",
                    "Mengidentifikasi kemampuan dan waktu yang tetap menerima informasi dari",
                    "Mengidentifikasi kesiapan dan kemampuan ibu atau pengasuh menerima informasi",
                    "Mengidentifikasi kemampuan ibu atau pengasuh menyediakan nutrisi terapeutik",
                    "Melakukan oral hygienis sebelum makan, jika perlu",
                    "Memfalisitasi menentukan pedoman diet (mis: piramide makanan)",
                    "Menyajikan makanan secara menarik dan suhu yang sesuai",
                    "Memberikan makanan tinggi serat untuk mencegah konstipasi",
                    "Memberikan makanan tinggi kalori dan tinggi protein",
                    "Memberikan suplemen makanan, jika perlu",
                    "Menghentikan pemberian makanan melalui selang nasogastrik jika asupan oral dapat ditoleransi",
                    "Mempersiapkan materi dan media seperti jenis-jenis nutrisi, tabal makanan penukar, cara mengelola, cara menakar makanan",
                    "Menjadwalkan pendidikan kesehatan sesuai kesepakatan",
                    "Memberikan kesempatan untuk bertanya",
                    "Menganjurkan posisi duduk, jika mampu",
                    "Mengajarkan diet yang diprogramkan",
                    "Menjelaskan pada pasien dan keluarga alergi makanan, makanan yang harus dihindari, kebutuhan jumlah kalori, jenis makanan yang dibutuhkan pasien",
                    "Mengajarkan cara melaksanakan diet sesuai program (mis: makanan tinggi protein, rendah garam, rendah kalori)",
                    "Menjelaskan hal-hal yang dilakukan sebelum memberikan makan (mis: perawatan mulut, penggunaan gigi palsu, obat-obat yang harus diberikan sebelum makan)",
                    "Mendemonstrasikan cara membersihkan mulut",
                    "Mendemonstrasikan cara mengatur posisi saat makan",
                    "Mengajarkan pasien atau keluarga memonitor asupan kalori dan makanan (mis: menggunakan buku harian)",
                    "Menganjurkan mendemonstrasikan cara memberi makan, menghitung kalori, menyiapkan makanan sesuai program diet",
                    "Menjelaskan tanda-tanda awal rasa lapar (mis: bayi gelisah, membuka mulut dan menggeleng-gelengkan kepala, menjulurkan lidah, menghisap jari atau tangan)",
                    "Menganjurkan menghindari pemberian pemanis buatan",
                    "Mengajarkan perilaku Hidup Bersih dan Sehat (PHBS) mis, cuci tangan sebelum dan sesudah makan, cuci tangan dengan sabun setelah ke toilet",
                    "Mengajarkan cara memilih makanan sesuai dengan usia bayi",
                    "Mengajarkan cara mengatur frekuensi makanan sesuai usia bayi",
                    "Menganjurkan tetap memberikan ASI pada saat bayi sakit",
                    "Menjelaskan tujuan dan prosedur pemberian nutrisi parenteral",
                    "Menjelaskan hal-hal yang harus diperhatikan selama menjalan terapi parenteral (mis. kondisi lokasi dan keadaan selang)",
                    "Menganjurkan memeriksa mulut secara teratur untuk tanda-tanda parotitis, glossitis dan lesi oral",
                    "Melakukan kolaborasi pemberian medikasi sebelum makan (mis: pereda nyeri, antlemetik), jika perlu",
                    "Melakukan kolaborasi dengan ahli gizi untuk menentukan jumlah kalori dan jenis nutrien yang dibutuhkan, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'GANGGUAN ELIMINASI URINE') {
                var optionIntervensi = [
                    "Identifikasi tanda dan gejala retensi atau inkontinensia urin",
                    "Identifikasi faktor yang menyebebkan retensi atau inkontinensia urin",
                    "Monitor eliminasi urin (mis: frekuensi, konsistensi, aroma, volume, dan warna)",
                    "Catat waktu-waktu dan haluaran berkemih",
                    "Batasi asupan cairan, jika perlu",
                    "Ambil sampel urin tengah (midstream) atau kultur",
                    "Ajarkan tanda dan gejala infeksi saluran berkemih",
                    "Ajarkan mengukur asupan cairan dan haluaran urin",
                    "Ajarkan mengenali tanda berkemih dan waktu yang tepat untuk berkemih",
                    "Ajarkan terapi modalitas penguatan otot-otot panggul/berkemihan",
                    "Anjurkan minum yang cukup, jika tidak ada kontraindikasi",
                    "Anjurkan mengurangi minum menjelang tidur",
                    "Kolaborasi pemberian obat supositoria uretra, jika perlu",
                    "Periksa kondisi pasien (mis: kesadaran, tanda-tanda vital, daerah perineal, distensi kandung kemih, inkontinensia urin, refeks berkemih)",
                    "Siapkan peralatan, bahan-bahan, dan ruangan tindakan",
                    "Siapkan pasien: bebaskan pakaian bawah dan posisikan dorsal rekumben (untuk wanita) dan supine (untuk laki-laki)",
                    "Pasang sarung tangan",
                    "Bersihkan daerah perineal atau preposium dengan cairan NaCI atau aquades",
                    "Lakukan insersi kateter urin dengan menerapkan prinsip aseptic",
                    "Sambungkan kateter urin dengan urin bag",
                    "Isi balon dengan NaCI 0,9% sesuai anjuran pabrik",
                    "Fiksasi selang kateter diatas simpisis atau di paha",
                    "Pastikan urin bag ditempatkan lebih rendah dari kandung kemih",
                    "Berikan label waktu pemasangan",
                    "Jelaskan tujuan dan prosedur pemasangan kateter urin",
                    "Anjurkan menarik napas saat insersi selang kateter"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi tanda dan gejala retensi atau inkontinensia urin",
                    "Mengidentifikasi faktor yang menyebebkan retensi atau inkontinensia urin",
                    "Memonitor eliminasi urin (mis: frekuensi, konsistensi, aroma, volume, dan warna)",
                    "Mencatat waktu-waktu dan haluaran berkemih",
                    "Membatasi asupan cairan, jika perlu",
                    "Mengambil sampel urin tengah (midstream) atau kultur",
                    "Mengajarkan tanda dan gejala infeksi saluran berkemih",
                    "Mengajarkan mengukur asupan cairan dan haluaran urin",
                    "Mengajarkan mengenali tanda berkemih dan waktu yang tepat untuk berkemih",
                    "Mengajarkan terapi modalitas penguatan otot-otot panggul/berkemihan",
                    "Menganjurkan minum yang cukup, jika tidak ada kontraindikasi",
                    "Menganjurkan mengurangi minum menjelang tidur",
                    "Melakukan kolaborasi pemberian obat supositoria uretra, jika perlu",
                    "Memeriksa kondisi pasien (mis: kesadaran, tanda-tanda vital, daerah perineal, distensi kandung kemih, inkontinensia urin, refeks berkemih)",
                    "Menyiapkan peralatan, bahan-bahan, dan ruangan tindakan",
                    "Menyiapkan pasien: bebaskan pakaian bawah dan posisikan dorsal rekumben (untuk wanita) dan supine (untuk laki-laki)",
                    "Memasang sarung tangan",
                    "Membersihkan daerah perineal atau preposium dengan cairan NaCI atau aquades",
                    "Melakukan insersi kateter urin dengan menerapkan prinsip aseptic",
                    "Menyambungkan kateter urin dengan urin bag",
                    "Mengisi balon dengan NaCI 0,9% sesuai anjuran pabrik",
                    "Melakukan Fiksasi selang kateter diatas simpisis atau di paha",
                    "Memastikan urin bag ditempatkan lebih rendah dari kandung kemih",
                    "Memberikan label waktu pemasangan",
                    "Menjelaskan tujuan dan prosedur pemasangan kateter urin",
                    "Menganjurkan menarik napas saat insersi selang kateter"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'GANGGUAN RASA NYAMAN') {
                var optionIntervensi = [
                    "Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri",
                    "Identifikasi skala nyeri",
                    "Identifikasi respons nyeri non verbal",
                    "Identifikasi faktor yang memperberat dan memperingatkan nyeri",
                    "Identifikasi pengetahuan dan keyakinan tentang nyeri",
                    "Identifikasi pengaruh budaya terhadap respon nyeri",
                    "Identifikasi pengaruh nyeri terhadap kualitas hidup",
                    "Monitor keberhasilan terapi komplementer yang sudah diberikan",
                    "Monitor efek samping penggunaan analgetik",
                    "Berikan teknik nonfarmakoligis untuk mengurangi rasa nyeri (mis: TENS, Hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imitasi terbimbing, kompres hangat/dingin, terapi bermain)",
                    "Kontrol lingkungan yang memperberat rasa nyeri (mis: suhu ruangan, pencahayaan, kebisingan)",
                    "Fasilitasi istirahat dan tidur",
                    "Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri",
                    "Jelaskan penyebab, periode, dan pemicu nyeri",
                    "Jelaskan strategi meredakan nyeri",
                    "Anjurkan memonitor nyeri secara mandiri",
                    "Anjurkan menggunakan analgetik secara tepat",
                    "Ajarkan teknik nonfarmakoligis untuk mengurangi rasa nyeri",
                    "Kolaborasi pemberian analgetik, jika perlu"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri",
                    "Mengidentifikasi skala nyeri",
                    "Mengidentifikasi respons nyeri non verbal",
                    "Mengidentifikasi faktor yang memperberat dan memperingatkan nyeri",
                    "Mengidentifikasi pengetahuan dan keyakinan tentang nyeri",
                    "Mengidentifikasi pengaruh budaya terhadap respon nyeri",
                    "Mengidentifikasi pengaruh nyeri terhadap kualitas hidup",
                    "Memonitor keberhasilan terapi komplementer yang sudah diberikan",
                    "Memonitor efek samping penggunaan analgetik",
                    "Memberikan teknik nonfarmakoligis untuk mengurangi rasa nyeri (mis: TENS, Hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imitasi terbimbing, kompres hangat/dingin, terapi bermain)",
                    "Melakukan kontrol lingkungan yang memperberat rasa nyeri (mis: suhu ruangan, pencahayaan, kebisingan)",
                    "Memfasilitasi istirahat dan tidur",
                    "Mempertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri",
                    "Menjelaskan penyebab, periode, dan pemicu nyeri",
                    "Menjelaskan strategi meredakan nyeri",
                    "Menganjurkan memonitor nyeri secara mandiri",
                    "Menganjurkan menggunakan analgetik secara tepat",
                    "Mengajarkan teknik nonfarmakoligis untuk mengurangi rasa nyeri",
                    "Melakukan kolaborasi pemberian analgetik, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'RESIKO INFEKSI') {
                var optionIntervensi = [
                    "Monitor tanda gejala infeksi local dan sistemik",
                    "Batasi perawatan kulit pada daerah edema",
                    "Cuci tangan sebelum dan sesudah kontak dengan pasien",
                    "Pertahankan teknik aseptic pada pasien beresiko tinggi",
                    "Jelaskan tanda dan gejala infeksi",
                    "Ajaran cairan memeriksa luka",
                    "Anjurkan meningkatkan cairan",
                    "Kolaborasi pemberian imunisasi, jika perlu"
                ];
                var optionIntervensi = [
                    "Memonitor tanda gejala infeksi local dan sistemik",
                    "Membatasi perawatan kulit pada daerah edema",
                    "Mencuci tangan sebelum dan sesudah kontak dengan pasien",
                    "Mempertahankan teknik aseptic pada pasien beresiko tinggi",
                    "Menjelaskan tanda dan gejala infeksi",
                    "Mengajarkan cairan memeriksa luka",
                    "Menganjurkan meningkatkan cairan",
                    "Melakukan kolaborasi pemberian imunisasi, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'KONSTIPASI') {
                var optionIntervensi = [
                    "Periksa tanda dan gejala konstipasi",
                    "Periksa pergerakan usus, karakteristik faeces (konsistensi, bentuk, volume, dan warna)",
                    "Identifikasi faktor risiko konstipasi (mis: obat-obatan, tirah baring, dan diet rendah serat)",
                    "Monitor tanda dan gejala ruptur usus dan/atau peritonitis",
                    "Anjurkan diet tinggi serat",
                    "Lakukan massage abdomen, jika perlu",
                    "Lakukan evakuasi fases secara manual, jika perlu",
                    "Berikan enema atau irigasi, jika perlu",
                    "Jelaskan etilogi masalah dan alasan tindakan",
                    "Anjurkan peningkatan asupan cairan, jika tidak ada kontra indikasi",
                    "Latih buang air besar secara teratur",
                    "Ajarkan cara mengatasi konstipasi/impaksi",
                    "Konsultasi dengan tim medis tentang penurunan/peningkatan frekuensi suara usus",
                    "Kolaborasi penggunaan obat pencahar, jika perlu"
                ];
                var optionImplementasi = [
                    "Memeriksa tanda dan gejala konstipasi",
                    "Memeriksa pergerakan usus, karakteristik faeces (konsistensi, bentuk, volume, dan warna)",
                    "Mengidentifikasi faktor risiko konstipasi (mis: obat-obatan, tirah baring, dan diet rendah serat)",
                    "Memonitor tanda dan gejala ruptur usus dan/atau peritonitis",
                    "Menganjurkan diet tinggi serat",
                    "Melakukan massage abdomen, jika perlu",
                    "Melakukan evakuasi fases secara manual, jika perlu",
                    "Memberikan enema atau irigasi, jika perlu",
                    "Menjelaskan etilogi masalah dan alasan tindakan",
                    "Menganjurkan peningkatan asupan cairan, jika tidak ada kontra indikasi",
                    "Melatih buang air besar secara teratur",
                    "Mengajarkan cara mengatasi konstipasi/impaksi",
                    "Melakukan konsultasi dengan tim medis tentang penurunan/peningkatan frekuensi suara usus",
                    "Melakukan kolaborasi penggunaan obat pencahar, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'HARGA DIRI RENDAH KRONIS') {
                var optionIntervensi = [
                    "Identifikasi budaya, agama, ras, jenis kelamin, dan usia terhadap harga diri",
                    "Monitor verbalisasi yang merendahkan diri",
                    "Monitor tingkat harga diri setiap waktu, sesuai kebutuhan",
                    "Motivasi terlibat dalam verbalisasi",
                    "Motivasi menerima tantangan atau hal baru",
                    "Diskusikan pernyataan tentang harga diri",
                    "Diskusikan kepercayaan terhadap penilaian diri",
                    "Diskusikan pengalaman yang meningkatkan diri",
                    "Diskusikan persepsi negatif diri",
                    "Diskusikan alasan mengkritik diri atau rasa bersalah",
                    "Diskusikan penetapan tujuan realistis untuk mencapai harga diri yang lebih tinggi",
                    "Diskusikan bersama keluarga untuk menetapkan harapan dan batasan yang jelas",
                    "Berikan umpan balik positif atas peningkatan mencapai tujuan",
                    "Fasilitasi lingkungan dan aktivitas yang meningkatkan harga diri",
                    "Jelaskan kepada keluarga pentingnya dukungan dalam perkembangan konsep positif diri pasien",
                    "Anjurkan mengidentifikasi kekuatan yang dimiliki",
                    "Anjurkan mempertahankan kontak mata saat berkomunikasi dengan orang lain",
                    "Anjurkan membuka diri terhadap kritik negatif",
                    "Ajarkan mengevaluasi perilaku",
                    "Ajarkan cara mengatasi bullying",
                    "Latih peningkatan tanggung jawab untuk diri sendiri",
                    "Latih penyataan/kemampuan positif diri",
                    "Latih cara berfikir dan berperilaku positif",
                    "Latih meningkatkan kepercayaan pada kemampuan dalam menangani situasi"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi budaya, agama, ras, jenis kelamin, dan usia terhadap harga diri",
                    "Memonitor verbalisasi yang merendahkan diri",
                    "Memonitor tingkat harga diri setiap waktu, sesuai kebutuhan",
                    "Memotivasi terlibat dalam verbalisasi",
                    "Memotivasi menerima tantangan atau hal baru",
                    "Mendiskusikan pernyataan tentang harga diri",
                    "Mendiskusikan kepercayaan terhadap penilaian diri",
                    "Mendiskusikan pengalaman yang meningkatkan diri",
                    "Mendiskusikan persepsi negatif diri",
                    "Mendiskusikan alasan mengkritik diri atau rasa bersalah",
                    "Mendiskusikan penetapan tujuan realistis untuk mencapai harga diri yang lebih tinggi",
                    "Mendiskusikan bersama keluarga untuk menetapkan harapan dan batasan yang jelas",
                    "Memberikan umpan balik positif atas peningkatan mencapai tujuan",
                    "Memfasilitasi lingkungan dan aktivitas yang meningkatkan harga diri",
                    "Menjelaskan kepada keluarga pentingnya dukungan dalam perkembangan konsep positif diri pasien",
                    "Menganjurkan mengidentifikasi kekuatan yang dimiliki",
                    "Menganjurkan mempertahankan kontak mata saat berkomunikasi dengan orang lain",
                    "Menganjurkan membuka diri terhadap kritik negatif",
                    "Mengajarkan mengevaluasi perilaku",
                    "Mengajarkan cara mengatasi bullying",
                    "Melatih peningkatan tanggung jawab untuk diri sendiri",
                    "Melatih penyataan/kemampuan positif diri",
                    "Melatih cara berfikir dan berperilaku positif",
                    "Melatih meningkatkan kepercayaan pada kemampuan dalam menangani situasi"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'HARGA DIRI RENDAH SITUASIONAL') {
                var optionIntervensi = [
                    "Identifikasi harapan untuk mengendalikan perilaku",
                    "Diskusikan tanggung jawab terhadap perilaku",
                    "Jadwalkan kegiatan terstruktur",
                    "Ciptakan dan pertahankan lingkungan dan kegiatan perawatan konsisten setiap dinas",
                    "Tingkatkan aktivitas fisik sesuai kemampuan",
                    "Bataasi jumlah pengunjung",
                    "Bicara dengan nada rendah dan tenang",
                    "Lakukan kegiatan pengalihan terhadap sumber agitasi",
                    "Cegah perilaku pasif agresif",
                    "Beri penguatan positif terhadap keberhasilan mengendalikan perilaku",
                    "Lakukan pengekangan fisik sesuai indikasi",
                    "Hindari bersikap menyudutkan dan menghentkan pembicaraan",
                    "Hindari sikap mengancam dan berdebat",
                    "Hindari berdebat atau menawar batas perilaku yang telah ditetapkan",
                    "Informasikan keluarga bahwa keluarga sebagai dasar pembentukan kognitif"
                ];
                var optionImplementasi = [
                    "Megidentifikasi harapan untuk mengendalikan perilaku",
                    "Mendiskusikan tanggung jawab terhadap perilaku",
                    "Menjadwalkan kegiatan terstruktur",
                    "Menciptakan dan pertahankan lingkungan dan kegiatan perawatan konsisten setiap dinas",
                    "Meningkatkan aktivitas fisik sesuai kemampuan",
                    "Membataasi jumlah pengunjung",
                    "Berbicara dengan nada rendah dan tenang",
                    "Melakukan kegiatan pengalihan terhadap sumber agitasi",
                    "Mencegah perilaku pasif agresif",
                    "Memberi penguatan positif terhadap keberhasilan mengendalikan perilaku",
                    "Melakukan pengekangan fisik sesuai indikasi",
                    "Menghindari bersikap menyudutkan dan menghentkan pembicaraan",
                    "Menghindari sikap mengancam dan berdebat",
                    "Menghindari berdebat atau menawar batas perilaku yang telah ditetapkan",
                    "Menginformasikan keluarga bahwa keluarga sebagai dasar pembentukan kognitif"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'KEPUTUSASAAN') {
                var optionIntervensi = [
                    "Identifikasi fungsi marah, frustasi, dan amuk pasien",
                    "Identifikasi hal yang telah memicu emosi",
                    "Fasilitasi mengungkapkan perasaan cemas, marah, atau sedih",
                    "Buat pernyataan suportif atau empati selama fase berduka",
                    "Lakukan sentuhan untuk memberikan dukungan (mis: merangkul, menepuk-nepuk)",
                    "Tetap bersama pasien dan pastikan keamanan selama ansietas jika diperlukan",
                    "Kurangi tuntutan berfikir selama sakit atau lelah",
                    "Jelaskan konsekuensi tidak menghadapi rasa bersalah dan malu",
                    "Anjurkan mengungkapkan perasaan yang dialami (mis: Ansietas, marah, sedih)",
                    "Anjurkan mengungkapkan pengalaman emosional sebelumnya dan pola respon yang biasa digunakan",
                    "Ajarkan penggunaan mekanisme pertahanan yang tepat",
                    "Rujuk untuk konseling, jika perlu"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi fungsi marah, frustasi, dan amuk pasien",
                    "Mengidentifikasi hal yang telah memicu emosi",
                    "Memfasilitas mengungkapkan perasaan cemas, marah, atau sedih",
                    "Membuat pernyataan suportif atau empati selama fase berduka",
                    "Melakukan sentuhan untuk memberikan dukungan (mis: merangkul, menepuk-nepuk)",
                    "Menetap bersama pasien dan pastikan keamanan selama ansietas jika diperlukan",
                    "Mengurangi tuntutan berfikir selama sakit atau lelah",
                    "Menjelaskan konsekuensi tidak menghadapi rasa bersalah dan malu",
                    "Menganjurkan mengungkapkan perasaan yang dialami (mis: Ansietas, marah, sedih)",
                    "Menganjurkan mengungkapkan pengalaman emosional sebelumnya dan pola respon yang biasa digunakan",
                    "Mengajarkan penggunaan mekanisme pertahanan yang tepat",
                    "Merujuk untuk konseling, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'KETIDAKBERDAYAAN') {

            } else if (diagnosa == 'WAHAM') {
                var optionIntervensi = [
                    "Monitor waham yang isinya membahayakan diri sendiri, orang lain dan lingkungan",
                    "Monitor efek terapeutik dan efek samping obat",
                    "Bina hubungan interpersonal saling percaya",
                    "Tunjukkan sikap tidak menghakimi secara konsisten",
                    "Diskusikan waham dengan berfokus dengan perasaan yang mendasari waham ('And terlihat seperti sedang merasa ketakutan')",
                    "Hindari perdebatan tentang keyakinan yang keliru, nyatakan keraguan sesuai fakta",
                    "Hindari memperkuat gagasan waham",
                    "Sediakan lingkungan aman dan nyaman",
                    "Berikan aktivitas rekreasi dan pengalihan sesuai kebutuhan",
                    "Lakukan intervensi pengontrolan perilaku waham (mis: limit setting, pembatasan wilayah, pengekangan fisik, atau seklusi)",
                    "Anjurkan mengungkapkan dan memvalidasi waham (uji realitas) dengan orang yang dipercaya (pemberi asuhan/keluarga)",
                    "Anjurkan melakukan rutinitas harian secara konsisten",
                    "Latihan manajemen stress",
                    "Jelaskan tentang waham serta penyakit terkait (mis: Delirium, skizofrenia, atau depresi), cara mengatasi dan obat yang diberikan",
                    "Kolaborasi pemberian obat, sesuai indikasi"
                ];
                var optionImplementasi = [
                    "Memonitor waham yang isinya membahayakan diri sendiri, orang lain dan lingkungan",
                    "Memonitor efek terapeutik dan efek samping obat",
                    "Membina hubungan interpersonal saling percaya",
                    "Menunjukkan sikap tidak menghakimi secara konsisten",
                    "Mendiskusikan waham dengan berfokus dengan perasaan yang mendasari waham ('And terlihat seperti sedang merasa ketakutan')",
                    "Menghindari perdebatan tentang keyakinan yang keliru, nyatakan keraguan sesuai fakta",
                    "Menghindari memperkuat gagasan waham",
                    "Menyediakan lingkungan aman dan nyaman",
                    "Memberikan aktivitas rekreasi dan pengalihan sesuai kebutuhan",
                    "Melakukan intervensi pengontrolan perilaku waham (mis: limit setting, pembatasan wilayah, pengekangan fisik, atau seklusi)",
                    "Menganjurkan mengungkapkan dan memvalidasi waham (uji realitas) dengan orang yang dipercaya (pemberi asuhan/keluarga)",
                    "Menganjurkan melakukan rutinitas harian secara konsisten",
                    "Mealkuan latihan manajemen stress",
                    "Menjelaskan tentang waham serta penyakit terkait (mis: Delirium, skizofrenia, atau depresi), cara mengatasi dan obat yang diberikan",
                    "Melakukan kolaborasi pemberian obat, sesuai indikasi"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'KETIDAKPATUHAN') {
                var optionIntervensi = [
                    "Identifikasi kepatuhan menjalani program pengobatan",
                    "Buat komitmen menjalani program pengobatan dengan baik",
                    "Buat jadwal pendampingan keluarga untuk bergantian menemani pasien selama menjalani program pengobatan, jika perlu",
                    "Dokumentasikan aktivitas selama menjalani proses pengobatan",
                    "Diskusikan hal-hal yang dapat mendukung atau menghambat berjalannya program pengobatan",
                    "Libatkan keluarga untuk mendukung program pengobatan yang dijalani",
                    "Informasikan program pengobatan",
                    "Informasikan manfaat yang akan diperoleh jika teratur menjalani program pengobatan",
                    "Anjurkan keluarga untuk mendampingi dan merawat pasien selama menjalani program pengobatan",
                    "Anjurkan pasien dan keluarga melakukan konsultasi ke pelayanan kesehatan terdekat, jika diperlukan"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi kepatuhan menjalani program pengobatan",
                    "Membuat komitmen menjalani program pengobatan dengan baik",
                    "Membuat jadwal pendampingan keluarga untuk bergantian menemani pasien selama menjalani program pengobatan, jika perlu",
                    "Mendokumentasikan aktivitas selama menjalani proses pengobatan",
                    "Mendiskusikan hal-hal yang dapat mendukung atau menghambat berjalannya program pengobatan",
                    "Melibatkan keluarga untuk mendukung program pengobatan yang dijalani",
                    "Menginformasikan program pengobatan",
                    "Menginformasikan manfaat yang akan diperoleh jika teratur menjalani program pengobatan",
                    "Menganjurkan keluarga untuk mendampingi dan merawat pasien selama menjalani program pengobatan",
                    "Menganjurkan pasien dan keluarga melakukan konsultasi ke pelayanan kesehatan terdekat, jika diperlukan"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'KESIAPAN PENINGKATAN ELIMINASI') {
                var optionIntervensi = [
                    "Identifikasi tanda dan gejala retensi atau inkonsistensi urine",
                    "Identifikasi faktor yang menyebabkan retensi atau inkonsistensi urine",
                    "Monitor eliminasi urine (mis: frekuensi, konsistensi, aroma, volume, dan warna)",
                    "Catat waktu-waktu dan haluaran berkemih",
                    "Batasi asupan cairan, jika perlu",
                    "Ambil sampel urine tengah (midstream) atau kultur",
                    "Ajarkan tanda dan gejala infeksi saluran kemih",
                    "Ajarkan mengukur asupan cairan dan haluaran urine",
                    "Ajarkan mengambil spesimen urine midstream",
                    "Ajarkan mengenali tanda berkemih dan waktu yang tepat untuk berkemih",
                    "Ajarkan terapi modalitas penguatan otot-otot panggul/berkemihan",
                    "Ajarkan minum yang cukup, jika tidak ada kontraindikasi",
                    "Anjurkan mengurangi minum sebelum tidur",
                    "Kolaborasi pemberian obat supositoria utera, jika perlu"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi tanda dan gejala retensi atau inkonsistensi urine",
                    "Mengidentifikasi faktor yang menyebabkan retensi atau inkonsistensi urine",
                    "Memonitor eliminasi urine (mis: frekuensi, konsistensi, aroma, volume, dan warna)",
                    "Mencatat waktu-waktu dan haluaran berkemih",
                    "Membatasi asupan cairan, jika perlu",
                    "Mengambil sampel urine tengah (midstream) atau kultur",
                    "Mengajarkan tanda dan gejala infeksi saluran kemih",
                    "Mengajarkan mengukur asupan cairan dan haluaran urine",
                    "Mengajarkan mengambil spesimen urine midstream",
                    "Mengajarkan mengenali tanda berkemih dan waktu yang tepat untuk berkemih",
                    "Mengajarkan terapi modalitas penguatan otot-otot panggul/berkemihan",
                    "Mengajarkan minum yang cukup, jika tidak ada kontraindikasi",
                    "Menganjurkan mengurangi minum sebelum tidur",
                    "Melakukan kolaborasi pemberian obat supositoria utera, jika perlu"
                ];

                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            } else if (diagnosa == 'GANGGUAN MEMORI') {
                var optionIntervensi = [
                    "Identifikasi persiapan dan kemampuan menerima informasi",
                    "Identifikasi pengetahuan teknik memori",
                    "Sediakan materi dan media pendidikan kesehatan",
                    "Jadwalkan pendidikan kesehatan sesuai kesepakatan",
                    "Berikan tempat untuk bertanya",
                    "Anjurkan menggunakan media tulis (mis: Daftar benda, kalender, buku catatan)",
                    "Anjurkan menggunakan media auditorik (mis: timer, jam alarm)",
                    "Anjurkan menggunakan gambar atau tulisan-tulisan sebagai pengingat letak barang (mis: tempat sepatu yang perlu diperbaiki)",
                    "Anjurkan keluarga membantu untuk menciptakan lingkungan yang konsisten",
                    "Ajarkan teknik memori (mis: konsentrasi dan menghadirkan memori, mengulang informasi, membuat asosiasi mental dan meletakkan benda pada tempat yang benar)",
                    "Ajarkan cara mengatur letak benda pada tempatnya"
                ];
                var optionImplementasi = [
                    "Mengidentifikasi persiapan dan kemampuan menerima informasi",
                    "Mengidentifikasi pengetahuan teknik memori",
                    "Menyediakan materi dan media pendidikan kesehatan",
                    "Menjadwalkan pendidikan kesehatan sesuai kesepakatan",
                    "Memberikan tempat untuk bertanya",
                    "Menganjurkan menggunakan media tulis (mis: Daftar benda, kalender, buku catatan)",
                    "Menganjurkan menggunakan media auditorik (mis: timer, jam alarm)",
                    "Menganjurkan menggunakan gambar atau tulisan-tulisan sebagai pengingat letak barang (mis: tempat sepatu yang perlu diperbaiki)",
                    "Menganjurkan keluarga membantu untuk menciptakan lingkungan yang konsisten",
                    "Mengajarkan teknik memori (mis: konsentrasi dan menghadirkan memori, mengulang informasi, membuat asosiasi mental dan meletakkan benda pada tempat yang benar)",
                    "Mengajarkan cara mengatur letak benda pada tempatnya"
                ];


                optionIntervensi.forEach(function(optionValue) {
                    intervensi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });

                optionImplementasi.forEach(function(optionValue) {
                    implementasi.append('<option value="' + optionValue + '">' + optionValue + '</option>');
                });
            }

        });

        $(document).on('click', '#listKontrol', function(e) {
            var id = $(this).attr('data-dokterID');
            var tgl = $('#waktuKontrol').val();
            
            if(tgl == null || tgl == ''){
            alert('Harap Isi Tanggal Kontrol');
            }else{
            $('#showListKontrol').modal('show');
            $('#dataListKontrol').load("/soap/list-kontrol/"+tgl+"/" + id);
            }
        });
    </script>
@endsection
