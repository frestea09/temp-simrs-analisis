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
    
    .bold {
        font-weight: bold;
    }

    .p-1 {
        padding: 1rem !important;
    }

    .background-green {
        background-color: rgb(0, 179, 0) !important;
        color: white;
    }
    .background-red {
        background-color: red !important;
        color: white;
    }
    .background-blue {
        background-color: blue !important;
        color: white;
    }
</style>
@section('header')
    <h1>Catatan Harian</h1>
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
                        <h4 style="text-align: center; padding: 10px"><b>PENGANTAR</b></h4>
                        <br>
                    </div>
                </div>
            <br />
            <div class="col-md-12">
                <table class='table table-striped table-bordered table-hover table-condensed' >
                  <thead>
                    <tr>
                      <th colspan="3" class="text-center bg-primary" style="">TRIAGE</th>
                    </tr>
                    <tr>
                      <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                      <th class="text-center" style="vertical-align: middle;">Asal</th>
                      <th class="text-center" style="vertical-align: middle;">Lihat</th>
                    </tr>
                  </thead>
                  <tbody>
                        @if (count($triage) == 0)
                            <tr>
                                <td colspan="4" class="text-center">Tidak Ada Triage</td>
                            </tr>
                        @endif
                        @foreach ($triage as $riwayat)
                            <tr>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{@date('d-m-Y',strtotime($riwayat->created_at)) }}
                                    {{-- {{ @Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }} --}}
                                </td>
                                <td style="text-align: center;">
                                    {{baca_poli($reg->poli_id)}}
                                </td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <a href="/cetak-triage-igd/pdf/{{ $registrasi_id }}/{{ $riwayat->id }}"
                                        target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    @if (!empty(json_decode(@$riwayat->tte)->base64_signed_file))
                                        <a href="/emr-soap-file-tte/{{ $riwayat->id }}/Triage"
                                            target="_blank" class="btn btn-success btn-sm">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <table class='table table-striped table-bordered table-hover table-condensed' >
                  <thead>
                    <tr>
                      <th colspan="3" class="text-center bg-primary" style="">ASWAL MEDIS IGD</th>
                    </tr>
                    <tr>
                      <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                      <th class="text-center" style="vertical-align: middle;">Asal</th>
                      <th class="text-center" style="vertical-align: middle;">Lihat</th>
                    </tr>
                  </thead>
                  <tbody>
                        @if (count($aswal_igd) == 0)
                            <tr>
                                <td colspan="3" class="text-center">Tidak Ada Riwayat Aswal Medis IGD</td>
                            </tr>
                        @endif
                        @foreach ($aswal_igd as $riwayat)
                            <tr>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{-- {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }} --}}
                                    {{@date('d-m-Y H:i',strtotime($riwayat->created_at)) }}
                                </td>
                                <td style="text-align: center;">{{baca_poli($reg->poli_id)}}</td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <a href="/cetak-asesmen-igd/pdf/{{ $registrasi_id }}/{{ $riwayat->id }}"
                                        target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <table class='table table-striped table-bordered table-hover table-condensed' >
                  <thead>
                    <tr>
                      <th colspan="3" class="text-center bg-primary" style="">TRANSFER INTERNAL</th>
                    </tr>
                    <tr>
                      <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                      <th class="text-center" style="vertical-align: middle;">Asal</th>
                      <th class="text-center" style="vertical-align: middle;">Lihat</th>
                    </tr>
                  </thead>
                  <tbody>
                        @if (count($transfer_internal) == 0)
                            <tr>
                                <td colspan="4" class="text-center">Tidak Ada Transfer Internal</td>
                            </tr>
                        @endif
                        @foreach ($transfer_internal as $riwayat)
                            <tr>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{-- {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }} --}}
                                    {{@date('d-m-Y H:i',strtotime($riwayat->created_at)) }}
                                </td>
                                <td style="text-align: center;">
                                    {{baca_poli($riwayat->poli_id)}}
                                </td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    @if (!empty($riwayat->ekstra))
                                        <a href="/cetak-eresume-transfer-internal-new/{{ $riwayat->id }}"
                                            target="_blank" class="btn btn-warning btn-sm">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    @else
                                        <a href="/cetak-eresume-transfer-internal/{{ $riwayat->id }}"
                                            target="_blank" class="btn btn-warning btn-sm">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <table class='table table-striped table-bordered table-hover table-condensed' >
                  <thead>
                    <tr>
                      <th colspan="3" class="text-center bg-primary" style="">KONSUL DOKTER</th>
                    </tr>
                    <tr>
                      <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                      <th class="text-center" style="vertical-align: middle;">Lihat</th>
                    </tr>
                  </thead>
                  <tbody>
                        @if (count($konsul_dokter) == 0)
                            <tr>
                                <td colspan="4" class="text-center">Tidak Ada Konsul Dokter</td>
                            </tr>
                        @endif
                        @foreach ($konsul_dokter as $riwayat)
                            <tr>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{-- {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }} --}}
                                    {{@date('d-m-Y H:i',strtotime($riwayat->created_at)) }}
                                </td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <button type="button" data-toggle="tooltip"
                                                            data-id="{{ $riwayat->id }}"
                                                            class="btn btn-success btn-xs btn-lihat-jawab">Lihat</button>&nbsp;&nbsp;
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <table class='table table-striped table-bordered table-hover table-condensed' >
                  <thead>
                    <tr>
                      <th colspan="3" class="text-center bg-primary" style="">SURAT PENGANTAR RAWAT INAP</th>
                    </tr>
                    <tr>
                      <th class="text-center" style="vertical-align: middle;">Tanggal</th>
                      <th class="text-center" style="vertical-align: middle;">Asal</th>
                      <th class="text-center" style="vertical-align: middle;">Lihat</th>
                    </tr>
                  </thead>
                  <tbody>
                        @if (count($spri) == 0)
                            <tr>
                                <td colspan="4" class="text-center">Tidak Ada Surat Pengantar Rawat Inap</td>
                            </tr>
                        @endif
                        @foreach ($spri as $riwayat)
                            <tr>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{-- {{ @Carbon\Carbon::parse(@$riwayat->created_at)->format('d-m-Y H:i') }} --}}
                                    {{@date('d-m-Y H:i',strtotime($riwayat->created_at)) }}
                                </td>
                                <td style="text-align: center;">{{baca_poli($reg->poli_id)}}</td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <a href="/spri/cetak/{{ $registrasi_id }}"
                                        target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                </table>
            </div>
            {{-- Rekonsiliasi Obat --}}
            <div class="col-md-12" style="margin-top: 20px">
                <div class='table-responsive'>
                    <table class='table-striped table-bordered table-hover table-condensed table'>
                        <thead>
                            <tr>
                                <th colspan="7" class="text-center bg-primary" style="">FORMULIR PENELUSURAN OBAT IGD</th>
                              </tr>
                            <tr>
                                <th>No.</th>
                                <th>Nama Obat</th>
                                <th>Dosis</th>
                                <th>Frekuensi</th>
                                <th>Alasan Makan Obat</th>
                                <th>Obat Dilanjutkan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @if (isset($rekonsiliasi))
                                @foreach ($rekonsiliasi as $r_obat)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ @$r_obat['nama_obat'] }}</td>
                                        <td>{{ @$r_obat['dosis'] }}</td>
                                        <td>{{ @$r_obat['frekuensi'] }}</td>
                                        <td>{{ @$r_obat['alasan_makan'] }}</td>
                                        <td>{{ @$r_obat['obat_dilanjutkan'] }}</td>
                                        {{-- <td>{{ @\Carbon\Carbon::parse(@$r_obat['tanggal'])->format('d-m-Y') }} --}}
                                        <td>{{@date('d-m-Y',strtotime($r_obat['tanggal'])) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="text-align: center">Tidak Ada Data</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px">
                <div class='table-responsive'>
                    <table class='table-striped table-bordered table-hover table-condensed table'>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Obat Yang Menimbulkan Alergi</th>
                                <th>Tingkat Alergi</th>
                                <th>Reaksi Alergi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @if (isset($obatAlergi))
                                @foreach ($obatAlergi as $a_obat)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ @$a_obat['nama_obat'] }}</td>
                                        <td>{{ @$a_obat['tingkat_alergi'] }}</td>
                                        <td>{{ @$a_obat['reaksi_alergi'] }}</td>
                                        {{-- <td>{{ @\Carbon\Carbon::parse(@$a_obat['tanggal'])->format('d-m-Y') }} --}}
                                        <td>{{date('d-m-Y',strtotime($a_obat['tanggal'])) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center">Tidak Ada Data</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modals" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    {{-- <h4 class="modal-title">Jawab Konsul</h4> --}}
                </div>
                <div class="modal-body" id="dataModals">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
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

        $(document).on('click', '.btn-lihat-jawab', function() {
            let id = $(this).attr('data-id');
            $('#dataModals').html('');
            $('#dataModals').load('/emr-datajawabankonsul/' + id);
            $('#modals').modal('show');
        })
    </script>
@endsection
