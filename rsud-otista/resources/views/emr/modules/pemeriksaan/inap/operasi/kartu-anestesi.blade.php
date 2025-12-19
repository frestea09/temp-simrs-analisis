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

    input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }

    .bold {
        font-weight: bold;
    }

    
    .border {
        border: 1px solid black;
    }

    tr, td {
        padding: 0 !important;
        margin: 0 !important;
    }

    .p-1 {
      padding: .5rem !important;
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
</style>
@section('header')
    <h1>Operasi</h1>
@endsection

@section('content')
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
      <form method="POST" action="{{ url('emr-soap/pemeriksaan/kartu-anestesi/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
        <div class="row">
          @include('emr.modules.addons.tab-operasi')
          <div class="col-md-12">
            {{ csrf_field() }}
            {!! Form::hidden('registrasi_id', $reg->id) !!}
            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
            {!! Form::hidden('unit', $unit) !!}
            <br>

            <div class="col-md-12">
                <table class='table-striped table-bordered table-hover table-condensed table'>
                    <thead>
                        <tr>
                            <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                            <th class="text-center" style="vertical-align: middle;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($riwayats) == 0)
                            <tr>
                                <td colspan="2" class="text-center">Tidak Ada Riwayat Asessment</td>
                            </tr>
                        @endif
                        @foreach ($riwayats as $riwayat)
                            <tr>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                </td>
                                <td
                                    style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                    <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                        class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
              <h4 style="text-align: center;"><b>KARTU ANESTESI</b></h4>
            </div>
            <div class="col-md-6">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td>Diagnosa Pre Op</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][diagnosa_pre_op]" class="form-control" placeholder="Diagnosa Pre Op" value="{{ @$asessment['kartu_anestesi']['diagnosa_pre_op'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Jenis Tindakan Op</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][jenis_tindakan_op]" class="form-control" placeholder="Jenis Tindakan Op" value="{{ @$asessment['kartu_anestesi']['jenis_tindakan_op'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Diagnosa Post Op</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][diagnoa_pos_op]" class="form-control" placeholder="Diagnosa Post Op" value="{{ @$asessment['kartu_anestesi']['diagnoa_pos_op'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Dokter Operator</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][dokter_operator]" class="form-control" placeholder="Dokter Operator" value="{{ @$asessment['kartu_anestesi']['dokter_operator'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Asisten Operator</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][asisten_operator]" class="form-control" placeholder="Asisten Operator" value="{{ @$asessment['kartu_anestesi']['asisten_operator'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
              
            </div>
            <div class="col-md-6">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td>Tanggal</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][tanggal]" class="form-control" placeholder="Tanggal" value="{{ @$asessment['kartu_anestesi']['tanggal'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Kamar OK</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][kamar_ok]" class="form-control" placeholder="Kamar OK" value="{{ @$asessment['kartu_anestesi']['kamar_ok'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Informed Concent</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][informed_concent]" class="form-control" placeholder="Informed Concent" value="{{ @$asessment['kartu_anestesi']['informed_concent'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Dokter Anestesi</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][dokter_anestesi]" class="form-control" placeholder="Dokter Anestesi" value="{{ @$asessment['kartu_anestesi']['dokter_anestesi'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Penata Anestesi</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][penata_anestesi]" class="form-control" placeholder="Penata Anestesi" value="{{ @$asessment['kartu_anestesi']['penata_anestesi'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>A. STATUS MEDIS SAAT MASUK KAMAR OPERASI</label>
              </div>
              <table style="width: 100%; font-size: 12px" class="table-striped table-bordered table-hover table-condensed form-box table">
                <tbody>
                  <tr>
                    <td>Kesadaran</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][kesadaran]" class="form-control" placeholder="Kesadaran" value="{{ @$asessment['kartu_anestesi']['status_medis']['kesadaran'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Airway</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][airway]" class="form-control" placeholder="Airway" value="{{ @$asessment['kartu_anestesi']['status_medis']['airway'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Tekanan Darah</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][tekanan_darah]" class="form-control" placeholder="mmHG" value="{{ @$asessment['kartu_anestesi']['status_medis']['tekanan_darah'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>GCS</td>
                    <td>
                      E
                      <input type="text" name="fisik[kartu_anestesi][status_medis][gcs][E]" class="form-control" placeholder="E" value="{{ @$asessment['kartu_anestesi']['status_medis']['gcs']['E'] }}">
                      <br>
                      M
                      <input type="text" name="fisik[kartu_anestesi][status_medis][gcs][M]" class="form-control" placeholder="M" value="{{ @$asessment['kartu_anestesi']['status_medis']['gcs']['M'] }}">
                      <br>
                      V
                      <input type="text" name="fisik[kartu_anestesi][status_medis][gcs][V]" class="form-control" placeholder="V" value="{{ @$asessment['kartu_anestesi']['status_medis']['gcs']['V'] }}">
                      <br>
                    </td>
                  </tr>
                  <tr>
                    <td>Nadi</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][nadi]" class="form-control" placeholder="x/menit" value="{{ @$asessment['kartu_anestesi']['status_medis']['nadi'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Support</td>
                    <td>
                      1).
                      <input type="text" name="fisik[kartu_anestesi][status_medis][support][1]" class="form-control" placeholder="ug/kgBB/mnt" value="{{ @$asessment['kartu_anestesi']['status_medis']['support']['1'] }}">
                      <br>
                      2).
                      <input type="text" name="fisik[kartu_anestesi][status_medis][support][2]" class="form-control" placeholder="ug/kgBB/mnt" value="{{ @$asessment['kartu_anestesi']['status_medis']['support']['2'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Respirasi</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][status_medis][respirasi][spontan]" value="Ya" {{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['spontan'] == "Ya" ? "checked" : "" }}>
                      <label for="">Spontant, </label><br>
                      <span>RR : </span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][spontan_dipilih][rr]" class="form-control" placeholder="x/mnt" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['spontan_dipilih']['rr'] }}">
                      <span>O2 : </span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][spontan_dipilih][o2]" class="form-control" placeholder="L/mnt" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['spontan_dipilih']['o2'] }}">
                      <span>SPO2 : </span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][spontan_dipilih][spo2]" class="form-control" placeholder="%" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['spontan_dipilih']['spo2'] }}">
                      <br>
                      <input type="checkbox" name="fisik[kartu_anestesi][status_medis][respirasi][assist]" value="Ya" {{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['assist'] == "Ya" ? "checked" : "" }}>
                      <label for="">Assists</label>
                      <br>
                      <input type="checkbox" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol]" value="Ya" {{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol'] == "Ya" ? "checked" : "" }}>
                      <label for="">Kontrol</label><br>
                      <span>Tidal Volume :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][tidal_volume]" class="form-control" placeholder="mL" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['tidal_volume'] }}">
                      <span>RR :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][rr]" class="form-control" placeholder="x/mnt" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['rr'] }}">
                      <span>PIP :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][pip]" class="form-control" placeholder="PIP" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['pip'] }}">
                      <span>Tringger :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][tringger]" class="form-control" placeholder="Tringger" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['tringger'] }}">
                      <span>PEEP :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][peep]" class="form-control" placeholder="PEEP" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['peep'] }}">
                      <span>I:E ratio :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][ie_ratio]" class="form-control" placeholder="I:E ratio" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['ie_ratio'] }}">
                      <span>PS :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][ps]" class="form-control" placeholder="PS" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['ps'] }}">
                      <span>FIO2 :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][fio2]" class="form-control" placeholder="FIO2" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['fio2'] }}">
                      <span>SPO2 :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][respirasi][kontrol_dipilih][SPO2]" class="form-control" placeholder="%" value="{{ @$asessment['kartu_anestesi']['status_medis']['respirasi']['kontrol_dipilih']['SPO2'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>BB</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][bb]" class="form-control" placeholder="kg" value="{{ @$asessment['kartu_anestesi']['status_medis']['bb'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>TB</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][tb]" class="form-control" placeholder="cm" value="{{ @$asessment['kartu_anestesi']['status_medis']['tb'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Gol. Darah</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][gol_darah]" class="form-control" placeholder="Gol. Darah" value="{{ @$asessment['kartu_anestesi']['status_medis']['gol_darah'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Laboratorium</td>
                    <td>
                      <textarea name="fisik[kartu_anestesi][status_medis][laboratorium]" style="width: 100%" rows="4">{{ @$asessment['kartu_anestesi']['status_medis']['laboratorium'] }}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>EKG</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][ekg]" class="form-control" placeholder="EKG" value="{{ @$asessment['kartu_anestesi']['status_medis']['ekg'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Toraks Foto</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][toraks_foto]" class="form-control" placeholder="Toraks Foto" value="{{ @$asessment['kartu_anestesi']['status_medis']['toraks_foto'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>TFP</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][tfp]" class="form-control" placeholder="TFP" value="{{ @$asessment['kartu_anestesi']['status_medis']['tfp'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Pemeriksaan lain</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][pemeriksaan_lain]" class="form-control" placeholder="Pemeriksaan lain" value="{{ @$asessment['kartu_anestesi']['status_medis']['pemeriksaan_lain'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Penyakit Penyerta</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][penyakit_penyerta]" class="form-control" placeholder="Penyakit Penyerta" value="{{ @$asessment['kartu_anestesi']['status_medis']['penyakit_penyerta'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Sistem Saraf</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][sistem_saraf]" class="form-control" placeholder="Sistem Saraf" value="{{ @$asessment['kartu_anestesi']['status_medis']['sistem_saraf'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Sistem respirasi</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][sistem_respirasi]" class="form-control" placeholder="Sistem respirasi" value="{{ @$asessment['kartu_anestesi']['status_medis']['sistem_respirasi'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Sistem kardiovaskuler</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][sistem_kardiovaskuler]" class="form-control" placeholder="Sistem kardiovaskuler" value="{{ @$asessment['kartu_anestesi']['status_medis']['sistem_kardiovaskuler'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Sistem gastrointestinal</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][sistem_gastrointestinal]" class="form-control" placeholder="Sistem gastrointestinal" value="{{ @$asessment['kartu_anestesi']['status_medis']['sistem_gastrointestinal'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Sistem urinarius</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][sistem_urinarius]" class="form-control" placeholder="Sistem urinarius" value="{{ @$asessment['kartu_anestesi']['status_medis']['sistem_urinarius'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Sistem muskuloskeletal</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][sistem_muskuloskeletal]" class="form-control" placeholder="Sistem muskuloskeletal" value="{{ @$asessment['kartu_anestesi']['status_medis']['sistem_muskuloskeletal'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Sistem metabolik</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][sistem_metabolik]" class="form-control" placeholder="Sistem metabolik" value="{{ @$asessment['kartu_anestesi']['status_medis']['sistem_metabolik'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Lain-lain</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][status_medis][lain_lain]" class="form-control" placeholder="Lain-lain" value="{{ @$asessment['kartu_anestesi']['status_medis']['lain_lain'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Terapi medikamentosa</td>
                    <td>
                      <textarea name="fisik[kartu_anestesi][status_medis][terapi_medikamentosa]" style="width: 100%" rows="4">{{ @$asessment['kartu_anestesi']['status_medis']['terapi_medikamentosa'] }}</textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>B. STATUS FISIK</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td style="width: 40%;">ASA</td>
                    <td>
                      <input type="radio" name="fisik[kartu_anestesi][status_fisik][asa]" class="form-check-input" {{ @$asessment['kartu_anestesi']['status_fisik']['asa'] == "1" }} value="1"> <label for="">1</label>
                      <input type="radio" name="fisik[kartu_anestesi][status_fisik][asa]" class="form-check-input" {{ @$asessment['kartu_anestesi']['status_fisik']['asa'] == "2" }} value="2"> <label for="">2</label>
                      <input type="radio" name="fisik[kartu_anestesi][status_fisik][asa]" class="form-check-input" {{ @$asessment['kartu_anestesi']['status_fisik']['asa'] == "3" }} value="3"> <label for="">3</label>
                      <input type="radio" name="fisik[kartu_anestesi][status_fisik][asa]" class="form-check-input" {{ @$asessment['kartu_anestesi']['status_fisik']['asa'] == "4" }} value="4"> <label for="">4</label>
                      <input type="radio" name="fisik[kartu_anestesi][status_fisik][asa]" class="form-check-input" {{ @$asessment['kartu_anestesi']['status_fisik']['asa'] == "5" }} value="5"> <label for="">5</label>
                      <input type="radio" name="fisik[kartu_anestesi][status_fisik][asa]" class="form-check-input" {{ @$asessment['kartu_anestesi']['status_fisik']['asa'] == "E" }} value="E"> <label for="">E</label>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Alergi</td>
                    <td>
                      <input type="radio" name="fisik[kartu_anestesi][status_fisik][alergi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['status_fisik']['alergi'] == "Ya" }} value="Ya"> <label for="">Ya</label>
                      <input type="radio" name="fisik[kartu_anestesi][status_fisik][alergi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['status_fisik']['alergi'] == "Tidak" }} value="Tidak"> <label for="">Tidak</label>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>C. PREMEDIKASI</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2">
                      <input type="radio" name="fisik[kartu_anestesi][premedikasi][pilihan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['premedikasi']['pilihan'] == "Oral" ? "checked" : "" }} value="Oral"> <label for="">Oral</label>
                      <input type="radio" name="fisik[kartu_anestesi][premedikasi][pilihan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['premedikasi']['pilihan'] == "i.m" ? "checked" : "" }} value="i.m"> <label for="">i.m</label>
                      <input type="radio" name="fisik[kartu_anestesi][premedikasi][pilihan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['premedikasi']['pilihan'] == "i.v" ? "checked" : "" }} value="i.v"> <label for="">i.v</label>
                      <input type="radio" name="fisik[kartu_anestesi][premedikasi][pilihan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['premedikasi']['pilihan'] == "Rektal" ? "checked" : "" }} value="Rektal"> <label for="">Rektal</label>
                    </td>
                  </tr>
                  <tr>
                    <td>Jam</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][premedikasi][jam]" class="form-control" placeholder="Jam" value="{{ @$asessment['kartu_anestesi']['premedikasi']['jam'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Obat</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][premedikasi][obat]" class="form-control" placeholder="Obat" value="{{ @$asessment['kartu_anestesi']['premedikasi']['obat'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Dosis</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][premedikasi][dosis]" class="form-control" placeholder="Dosis" value="{{ @$asessment['kartu_anestesi']['premedikasi']['dosis'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Hasil</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][premedikasi][hasil]" class="form-control" placeholder="Hasil" value="{{ @$asessment['kartu_anestesi']['premedikasi']['hasil'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>D. JENIS ANESTESI</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2">
                      <input type="checkbox" name="fisik[kartu_anestesi][jenis_anestesi][anestesi_umum]" class="form-check-input" {{ @$asessment['kartu_anestesi']['jenis_anestesi']['anestesi_umum'] == "Anestesi Umum" ? "checked" : "" }} value="Anestesi Umum"> <label for="">Anestesi Umum</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][jenis_anestesi][spinal]" class="form-check-input" {{ @$asessment['kartu_anestesi']['jenis_anestesi']['spinal'] == "Spinal" ? "checked" : "" }} value="Spinal"> <label for="">Spinal</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][jenis_anestesi][epidural]" class="form-check-input" {{ @$asessment['kartu_anestesi']['jenis_anestesi']['epidural'] == "Epidural" ? "checked" : "" }} value="Epidural"> <label for="">Epidural</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][jenis_anestesi][kaudal]" class="form-check-input" {{ @$asessment['kartu_anestesi']['jenis_anestesi']['kaudal'] == "Kaudal" ? "checked" : "" }} value="Kaudal"> <label for="">Kaudal</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][jenis_anestesi][spinal_epidural]" class="form-check-input" {{ @$asessment['kartu_anestesi']['jenis_anestesi']['spinal_epidural'] == "Spinal Epidural" ? "checked" : "" }} value="Spinal Epidural"> <label for="">Spinal Epidural</label>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>E. ANESTESI UMUM</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td style="width: 40%;">Induksi</td>
                    <td>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][induksi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['induksi'] == "Sempurna" ? "checked" : "" }} value="Sempurna"> <label for="">Sempurna</label>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][induksi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['induksi'] == "Eksitasi" ? "checked" : "" }} value="Eksitasi"> <label for="">Eksitasi</label>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][induksi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['induksi'] == "Muntah" ? "checked" : "" }} value="Muntah"> <label for="">Muntah</label>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][induksi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['induksi'] == "Batuk" ? "checked" : "" }} value="Batuk"> <label for="">Batuk</label>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][induksi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['induksi'] == "Spasme" ? "checked" : "" }} value="Spasme"> <label for="">Spasme</label>
                    </td>
                  </tr>
                  <tr>
                    <td>Respirasi</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][anestesi_umum][respirasi][spontan]" value="Ya" {{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['spontan'] == "Ya" ? "checked" : "" }}>
                      <label for="">Spontant, </label><br>
                      <span>RR : </span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][spontan_dipilih][rr]" class="form-control" placeholder="x/mnt" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['spontan_dipilih']['rr'] }}">
                      <span>O2 : </span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][spontan_dipilih][o2]" class="form-control" placeholder="L/mnt" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['spontan_dipilih']['o2'] }}">
                      <span>SPO2 : </span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][spontan_dipilih][spo2]" class="form-control" placeholder="%" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['spontan_dipilih']['spo2'] }}">
                      <br>
                      <input type="checkbox" name="fisik[kartu_anestesi][anestesi_umum][respirasi][assist]" value="Ya" {{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['assist'] == "Ya" ? "checked" : "" }}>
                      <label for="">Assists</label>
                      <br>
                      <input type="checkbox" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol]" value="Ya" {{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol'] == "Ya" ? "checked" : "" }}>
                      <label for="">Kontrol</label><br>
                      <span>Tidal Volume :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][tidal_volume]" class="form-control" placeholder="mL" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['tidal_volume'] }}">
                      <span>RR :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][rr]" class="form-control" placeholder="x/mnt" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['rr'] }}">
                      <span>PIP :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][pip]" class="form-control" placeholder="PIP" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['pip'] }}">
                      <span>Tringger :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][tringger]" class="form-control" placeholder="Tringger" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['tringger'] }}">
                      <span>PEEP :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][peep]" class="form-control" placeholder="PEEP" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['peep'] }}">
                      <span>I:E ratio :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][ie_ratio]" class="form-control" placeholder="I:E ratio" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['ie_ratio'] }}">
                      <span>PS :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][ps]" class="form-control" placeholder="PS" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['ps'] }}">
                      <span>FIO2 :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][fio2]" class="form-control" placeholder="FIO2" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['fio2'] }}">
                      <span>SPO2 :</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][anestesi_umum][respirasi][kontrol_dipilih][SPO2]" class="form-control" placeholder="%" value="{{ @$asessment['kartu_anestesi']['anestesi_umum']['respirasi']['kontrol_dipilih']['SPO2'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Teknik Khusus</td>
                    <td>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][teknik_khusus]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['teknik_khusus'] == "Hipotermi" ? "checked" : "" }} value="Hipotermi"> <label for="">Hipotermi</label>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][teknik_khusus]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['teknik_khusus'] == "Hipotensi" ? "checked" : "" }} value="Hipotensi"> <label for="">Hipotensi</label>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][teknik_khusus]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['teknik_khusus'] == "Bypass" ? "checked" : "" }} value="Bypass"> <label for="">Bypass</label>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][teknik_khusus]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['teknik_khusus'] == "Ventilasi satu paru" ? "checked" : "" }} value="Ventilasi satu paru"> <label for="">Ventilasi satu paru</label>
                      <input type="radio" name="fisik[kartu_anestesi][anestesi_umum][teknik_khusus]" class="form-check-input" {{ @$asessment['kartu_anestesi']['anestesi_umum']['teknik_khusus'] == "Spasme" ? "checked" : "" }} value="Spasme"> <label for="">Spasme</label>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>F. BLOKADE REGIONAL</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td style="width: 40%;">Teknik</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][blokade_regional][teknik][spinal]" class="form-check-input" {{ @$asessment['kartu_anestesi']['blokade_regional']['teknik']['spinal'] == "Spinal" ? "checked" : "" }} value="Spinal"> <label for="">Spinal</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][blokade_regional][teknik][saddle]" class="form-check-input" {{ @$asessment['kartu_anestesi']['blokade_regional']['teknik']['saddle'] == "Saddle Block" ? "checked" : "" }} value="Saddle Block"> <label for="">Saddle Block</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][blokade_regional][teknik][regional]" class="form-check-input" {{ @$asessment['kartu_anestesi']['blokade_regional']['teknik']['regional'] == "Regional Intravena" ? "checked" : "" }} value="Regional Intravena"> <label for="">Regional Intravena</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][blokade_regional][teknik][epidural]" class="form-check-input" {{ @$asessment['kartu_anestesi']['blokade_regional']['teknik']['epidural'] == "Epidural" ? "checked" : "" }} value="Epidural"> <label for="">Epidural</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][blokade_regional][teknik][blokade]" class="form-check-input" {{ @$asessment['kartu_anestesi']['blokade_regional']['teknik']['blokade'] == "Blokade saraf tepi" ? "checked" : "" }} value="Blokade saraf tepi"> <label for="">Blokade saraf tepi</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][blokade_regional][teknik][kaudal]" class="form-check-input" {{ @$asessment['kartu_anestesi']['blokade_regional']['teknik']['kaudal'] == "Kaudal" ? "checked" : "" }} value="Kaudal"> <label for="">Kaudal</label>
                      <input type="checkbox" name="fisik[kartu_anestesi][blokade_regional][teknik][topikal]" class="form-check-input" {{ @$asessment['kartu_anestesi']['blokade_regional']['teknik']['topikal'] == "Topikal" ? "checked" : "" }} value="Topikal"> <label for="">Topikal</label>
                    </td>
                  </tr>
                  <tr>
                    <td>Lokasi Tusukan</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][lokasi_tusukan]" class="form-control" placeholder="Lokasi Tusukan" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['lokasi_tusukan'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Anestesi setinggi segmen</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][anestesi]" class="form-control" placeholder="Anestesi setinggi segmen" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['anestesi'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Anestesi lokal</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][anestesi_lokal]" class="form-control" placeholder="Anestesi lokal" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['anestesi_lokal'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Konsentrasi</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][konsentrasi]" class="form-control" placeholder="Konsentrasi" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['konsentrasi'] }}">
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][konsentrasi_jumlah]" class="form-control" placeholder="Jumlah (ml)" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['konsentrasi_jumlah'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Obat tambahan</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][obat_tambahan]" class="form-control" placeholder="Obat tambahan" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['obat_tambahan'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Dosis</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][dosis]" class="form-control" placeholder="Dosis" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['dosis'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Vasokonstrikstor</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][vasokonstrikstor]" class="form-control" placeholder="vasokonstrikstor" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['vasokonstrikstor'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Konsentrasi</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][konsentrasi]" class="form-control" placeholder="konsentrasi" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['konsentrasi'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Waktu mulai</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][suntikan_jam]" class="form-control" placeholder="Suntikan Jam" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['suntikan_jam'] }}">
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][analgesi_jam]" class="form-control" placeholder="Analgesi Jam" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['analgesi_jam'] }}">
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][operasi_jam]" class="form-control" placeholder="Operasi Jam" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['operasi_jam'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Tindakan anestesi tambahan</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][blokade_regional][tindakan_anestesi_tambahan]" class="form-control" placeholder="Tindakan anestesi tambahan" value="{{ @$asessment['kartu_anestesi']['blokade_regional']['tindakan_anestesi_tambahan'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>G. KEADAAN SELAMA OPERASI</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td style="width: 40%;">Monitor</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][nibp]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['nibp'] == "NIBP" ? "checked" : "" }} value="NIBP"> <label for="">NIBP</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][etco]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['etco'] == "ETCO2" ? "checked" : "" }} value="ETCO2"> <label for="">ETCO2</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][ekg]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['ekg'] == "EKG" ? "checked" : "" }} value="EKG"> <label for="">EKG</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][prekordial]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['prekordial'] == "Prekordial" ? "checked" : "" }} value="Prekordial"> <label for="">Prekordial</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][sao2]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['sao2'] == "SaO2" ? "checked" : "" }} value="SaO2"> <label for="">SaO2</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][bis]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['bis'] == "BIS" ? "checked" : "" }} value="BIS"> <label for="">BIS</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][temp]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['temp'] == "Temp" ? "checked" : "" }} value="Temp"> <label for="">Temp</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][swan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['swan'] == "Swan Gant" ? "checked" : "" }} value="Swan Gant"> <label for="">Swan Gant</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][ibp]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['ibp'] == "IBP" ? "checked" : "" }} value="IBP"> <label for="">IBP</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][monitor][cvp]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['monitor']['cvp'] == "CVP" ? "checked" : "" }} value="CVP"> <label for="">CVP</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Jalur Intravena dan Monitor Invasif</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalur][iv_1]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalur']['iv_1'] == "IV" ? "checked" : "" }} value="IV"> <label for="">IV</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalur][iv_2]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalur']['iv_2'] == "IV" ? "checked" : "" }} value="IV"> <label for="">IV</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalur][iv_3]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalur']['iv_3'] == "IV" ? "checked" : "" }} value="IV"> <label for="">IV</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalur][cvc]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalur']['cvc'] == "CVC" ? "checked" : "" }} value="CVC"> <label for="">CVC</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalur][ibv]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalur']['ibv'] == "IBV" ? "checked" : "" }} value="IBV"> <label for="">IBV</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalur][swan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalur']['swan'] == "Swan Gant" ? "checked" : "" }} value="Swan Gant"> <label for="">Swan Gant</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Peralatan Lainnya</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][peralatan_lainnya][penghangat_cairan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['peralatan_lainnya']['penghangat_cairan'] == "Penghangat Cairan" ? "checked" : "" }} value="Penghangat Cairan"> <label for="">Penghangat Cairan</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][peralatan_lainnya][penghangat_darah]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['peralatan_lainnya']['penghangat_darah'] == "Pengangat Darah" ? "checked" : "" }} value="Pengangat Darah"> <label for="">Pengangat Darah</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][peralatan_lainnya][infusion]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['peralatan_lainnya']['infusion'] == "Infusion Pump" ? "checked" : "" }} value="Infusion Pump"> <label for="">Infusion Pump</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][peralatan_lainnya][syringe]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['peralatan_lainnya']['syringe'] == "Syringe Pump" ? "checked" : "" }} value="Syringe Pump"> <label for="">Syringe Pump</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][peralatan_lainnya][warm]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['peralatan_lainnya']['warm'] == "Warm Air Blanket" ? "checked" : "" }} value="Warm Air Blanket"> <label for="">Warm Air Blanket</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][peralatan_lainnya][blanket]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['peralatan_lainnya']['blanket'] == "Blanket Roll" ? "checked" : "" }} value="Blanket Roll"> <label for="">Blanket Roll</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][peralatan_lainnya][folley]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['peralatan_lainnya']['folley'] == "Folley Cayheter" ? "checked" : "" }} value="Folley Cayheter"> <label for="">Folley Cayheter</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][peralatan_lainnya][ngt]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['peralatan_lainnya']['ngt'] == "NGT" ? "checked" : "" }} value="NGT"> <label for="">NGT</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Posisi Pasien Selama Operasi</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][supine]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['supine'] == "Supine" ? "checked" : "" }} value="Supine"> <label for="">Supine</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][semi_fower]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['semi_fower'] == "Semi Fower" ? "checked" : "" }} value="Semi Fower"> <label for="">Semi Fower</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][lithotomi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['lithotomi'] == "Lithotomi" ? "checked" : "" }} value="Lithotomi"> <label for="">Lithotomi</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][duduk]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['duduk'] == "Duduk" ? "checked" : "" }} value="Duduk"> <label for="">Duduk</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][prone]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['prone'] == "Prone" ? "checked" : "" }} value="Prone"> <label for="">Prone</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][lateral_kanan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['lateral_kanan'] == "Lateral Dekubitus Kanan" ? "checked" : "" }} value="Lateral Dekubitus Kanan"> <label for="">Lateral Dekubitus Kanan</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][jack]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['jack'] == "Jack-Knife" ? "checked" : "" }} value="Jack-Knife"> <label for="">Jack-Knife</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][lateral_kiri]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['lateral_kiri'] == "Lateral Dekubitus Kiri" ? "checked" : "" }} value="Lateral Dekubitus Kiri"> <label for="">Lateral Dekubitus Kiri</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][trendelenberg]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['trendelenberg'] == "Trendelenberg" ? "checked" : "" }} value="Trendelenberg"> <label for="">Trendelenberg</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][posisi_pasien][reverse_trendelenberg]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['posisi_pasien']['reverse_trendelenberg'] == "Revers Trendelenberg" ? "checked" : "" }} value="Revers Trendelenberg"> <label for="">Revers Trendelenberg</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Lengan</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][lengan][sudut]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['lengan']['sudut'] == "Sudut < 90" ? "checked" : "" }} value="Sudut < 90"> <label for="">Sudut < 90</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][lengan][bantalan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['lengan']['bantalan'] == "Bantalan Axilar" ? "checked" : "" }} value="Bantalan Axilar"> <label for="">Bantalan Axilar</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Mata</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][mata][penutup]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['mata']['penutup'] == "Penutup Mata" ? "checked" : "" }} value="Penutup Mata"> <label for="">Penutup Mata</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][mata][lubrikasi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['mata']['lubrikasi'] == "Lubrikasi" ? "checked" : "" }} value="Lubrikasi"> <label for="">Lubrikasi</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][mata][bantalan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['mata']['bantalan'] == "Bantalan Tambahan" ? "checked" : "" }} value="Bantalan Tambahan"> <label for="">Bantalan Tambahan</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>Anestesi Pasien Selama Operasi</b></td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Induksi</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][induksi][inhalasi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['induksi']['inhalasi'] == "Inhalasi" ? "checked" : "" }} value="Inhalasi"> <label for="">Inhalasi</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][induksi][intravena]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['induksi']['intravena'] == "Intravena" ? "checked" : "" }} value="Intravena"> <label for="">Intravena</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][induksi][preoksigenasi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['induksi']['preoksigenasi'] == "Preoksigenasi" ? "checked" : "" }} value="Preoksigenasi"> <label for="">Preoksigenasi</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][induksi][rapid_sequence]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['induksi']['rapid_sequence'] == "Rapid Sequence Induction" ? "checked" : "" }} value="Rapid Sequence Induction"> <label for="">Rapid Sequence Induction</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][induksi][penekanan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['induksi']['penekanan'] == "Penekanan Krikoid" ? "checked" : "" }} value="Penekanan Krikoid"> <label for="">Penekanan Krikoid</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">ETT</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][ett][tipe]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['ett']['tipe'] == "Tipe" ? "checked" : "" }} value="Tipe"> <label for="">Tipe</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][ett][kedalaman]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['ett']['kedalaman'] == "Kedalaman" ? "checked" : "" }} value="Kedalaman"> <label for="">Kedalaman</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][ett][cuffed]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['ett']['cuffed'] == "Cuffed" ? "checked" : "" }} value="Cuffed"> <label for="">Cuffed</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][ett][pack]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['ett']['pack'] == "Pack" ? "checked" : "" }} value="Pack"> <label for="">Pack</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][ett][pengulangan]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['ett']['pengulangan'] == "Pengulangan" ? "checked" : "" }} value="Pengulangan"> <label for="">Pengulangan</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][ett][revers_trendelenberg]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['ett']['revers_trendelenberg'] == "Revers Trendelenberg" ? "checked" : "" }} value="Revers Trendelenberg"> <label for="">Revers Trendelenberg</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Metode</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][metode][direct]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['metode']['direct'] == "Direct Laryngoscope" ? "checked" : "" }} value="Direct Laryngoscope"> <label for="">Direct Laryngoscope</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][metode][mandrin]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['metode']['mandrin'] == "Mandrin" ? "checked" : "" }} value="Mandrin"> <label for="">Mandrin</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][metode][fibrotic]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['metode']['fibrotic'] == "Fibrotic" ? "checked" : "" }} value="Fibrotic"> <label for="">Fibrotic</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][metode][tube]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['metode']['tube'] == "Tube Charger" ? "checked" : "" }} value="Tube Charger"> <label for="">Tube Charger</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][metode][teknik]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['metode']['teknik'] == "Teknik blind" ? "checked" : "" }} value="Teknik blind"> <label for="">Teknik blind</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][metode][video]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['metode']['video'] == "Video Assisted" ? "checked" : "" }} value="Video Assisted"> <label for="">Video Assisted</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][metode][teknik_awake]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['metode']['teknik_awake'] == "Teknik awake" ? "checked" : "" }} value="Teknik awake"> <label for="">Teknik awake</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][metode][intubasi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['metode']['intubasi'] == "Sudah terintubasi" ? "checked" : "" }} value="Sudah terintubasi"> <label for="">Sudah terintubasi</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Jalan Nafas</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalan_nafas][sukup_muka]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalan_nafas']['sukup_muka'] == "Sukup Muka" ? "checked" : "" }} value="Sukup Muka"> <label for="">Sukup Muka</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalan_nafas][intravena]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalan_nafas']['intravena'] == "Intravena" ? "checked" : "" }} value="Intravena"> <label for="">Intravena</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][jalan_nafas][preoksigenasi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['jalan_nafas']['preoksigenasi'] == "Preoksigenasi" ? "checked" : "" }} value="Preoksigenasi"> <label for="">Preoksigenasi</label><br>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Konfirmasi</td>
                    <td>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][konfirmasi][etco2]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['konfirmasi']['etco2'] == "ETCO2" ? "checked" : "" }} value="ETCO2"> <label for="">ETCO2</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][konfirmasi][suara_nafas]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['konfirmasi']['suara_nafas'] == "Suara nafas vesikular" ? "checked" : "" }} value="Suara nafas vesikular"> <label for="">Suara nafas vesikular</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][konfirmasi][pipa]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['konfirmasi']['pipa'] == "Pipa sudah plester" ? "checked" : "" }} value="Pipa sudah plester"> <label for="">Pipa sudah plester</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][konfirmasi][sulit_ventilasi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['konfirmasi']['sulit_ventilasi'] == "Sulit ventilasi" ? "checked" : "" }} value="Sulit ventilasi"> <label for="">Sulit ventilasi</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][konfirmasi][sulit_intubasi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['konfirmasi']['sulit_intubasi'] == "Sulit intubasi" ? "checked" : "" }} value="Sulit intubasi"> <label for="">Sulit intubasi</label><br>
                      <input type="checkbox" name="fisik[kartu_anestesi][keadaan_selama_operasi][konfirmasi][lain_lain]" class="form-check-input" {{ @$asessment['kartu_anestesi']['keadaan_selama_operasi']['konfirmasi']['lain_lain'] == "Lain-lain" ? "checked" : "" }} value="Lain-lain"> <label for="">Lain-lain</label><br>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12" style="margin-top: 1rem; overflow: auto;">
              <div class="text-center">
                <label for="" style="text-align: center">Monitoring</label>
              </div>
              <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                  <tr>
                      <td style="width:30%; font-weight:bold;">Jam</td>
                      <td>
                          <input type="time" class="form-control" name="fisik[monitoring][jam]" style="width: 100%" value="{{@$asessment['monitoring']['jam']}}">
                      </td>
                  </tr>
              </table>

              @php
                  $param_tnrs = [
                    [
                      "t" => 'T',
                      "n" => 'N',
                      "r" => 'R',
                      "s" => 'S',
                    ],
                    [
                      "t" => 220,
                      "n" => 220,
                      "r" => null,
                      "s" => 43,
                    ],
                    [
                      "t" => 200,
                      "n" => 200,
                      "r" => 60,
                      "s" => 42,
                    ],
                    [
                      "t" => 180,
                      "n" => 180,
                      "r" => null,
                      "s" => 41,
                    ],
                    [
                      "t" => 160,
                      "n" => 160,
                      "r" => null,
                      "s" => 40
                    ],
                    [
                      "t" => 140,
                      "n" => 140,
                      "r" => 48,
                      "s" => 39,
                    ],
                    [
                      "t" => 120,
                      "n" => 120,
                      "r" => null,
                      "s" => 38,
                    ],
                    [
                      "t" => 100,
                      "n" => 100,
                      "r" => 34,
                      "s" => 37,
                    ],
                    [
                      "t" => 80,
                      "n" => 80,
                      "r" => null,
                      "s" => 36,
                    ],
                    [
                      "t" => 60,
                      "n" => 60,
                      "r" => 24,
                      "s" => 35,
                    ],
                    [
                      "t" => 40,
                      "n" => 40,
                      "r" => null,
                      "s" => 34,
                    ],
                    [
                      "t" => 20,
                      "n" => 20,
                      "r" => 12,
                      "s" => 33,
                    ],
                  ]
              @endphp
              <table class="border" >
                  <tr>
                    <td class="border p-1" colspan="4"><b>O2</b></td>
                    @for ($i = 1; $i <= 45; $i++)
                        <td class="border">
                            <input type="hidden" name="fisik[monitoring][o2][{{$i}}]"  value="">
                            <input type="checkbox" name="fisik[monitoring][o2][{{$i}}]" class="selected_point" {{@$asessment['monitoring']['o2'][$i] == "selected" ? 'checked' : ''}} value="selected">
                        </td>
                    @endfor
                  </tr>
                  <tr>
                    <td class="border p-1" colspan="4"><b>N2O</b></td>
                    @for ($i = 1; $i <= 45; $i++)
                        <td class="border">
                            <input type="hidden" name="fisik[monitoring][n20][{{$i}}]"  value="">
                            <input type="checkbox" name="fisik[monitoring][n20][{{$i}}]" class="selected_point" {{@$asessment['monitoring']['n20'][$i] == "selected" ? 'checked' : ''}} value="selected">
                        </td>
                    @endfor
                  </tr>
                  <tr>
                    <td class="border p-1" colspan="4"><b>Air</b></td>
                    @for ($i = 1; $i <= 45; $i++)
                        <td class="border">
                            <input type="hidden" name="fisik[monitoring][air][{{$i}}]"  value="">
                            <input type="checkbox" name="fisik[monitoring][air][{{$i}}]" class="selected_point" {{@$asessment['monitoring']['air'][$i] == "selected" ? 'checked' : ''}} value="selected">
                        </td>
                    @endfor
                  </tr>
                  <tr>
                    <td class="border p-1" colspan="4"><b>Violatie</b></td>
                    @for ($i = 1; $i <= 45; $i++)
                        <td class="border">
                            <input type="hidden" name="fisik[monitoring][violatie][{{$i}}]"  value="">
                            <input type="checkbox" name="fisik[monitoring][violatie][{{$i}}]" class="selected_point" {{@$asessment['monitoring']['violatie'][$i] == "selected" ? 'checked' : ''}} value="selected">
                        </td>
                    @endfor
                  </tr>
                  <tr>
                    <td class="border p-1" colspan="4"><b>EKG</b></td>
                    @for ($i = 1; $i <= 45; $i++)
                        <td class="border">
                            <input type="hidden" name="fisik[monitoring][ekg][{{$i}}]"  value="">
                            <input type="checkbox" name="fisik[monitoring][ekg][{{$i}}]" class="selected_point" {{@$asessment['monitoring']['ekg'][$i] == "selected" ? 'checked' : ''}} value="selected">
                        </td>
                    @endfor
                  </tr>
                  <tr>
                    <td class="border p-1" colspan="4"><b>SpO2</b></td>
                    @for ($i = 1; $i <= 45; $i++)
                        <td class="border">
                            <input type="hidden" name="fisik[monitoring][spo2][{{$i}}]"  value="">
                            <input type="checkbox" name="fisik[monitoring][spo2][{{$i}}]" class="selected_point" {{@$asessment['monitoring']['spo2'][$i] == "selected" ? 'checked' : ''}} value="selected">
                        </td>
                    @endfor
                  </tr>
                  <tr>
                    <td class="border p-1" colspan="4"><b>Infus</b></td>
                    @for ($i = 1; $i <= 45; $i++)
                        <td class="border">
                            <input type="hidden" name="fisik[monitoring][infus][{{$i}}]"  value="">
                            <input type="checkbox" name="fisik[monitoring][infus][{{$i}}]" class="selected_point" {{@$asessment['monitoring']['infus'][$i] == "selected" ? 'checked' : ''}} value="selected">
                        </td>
                    @endfor
                  </tr>
                  @foreach ($param_tnrs as $key => $param)
                      <tr>
                        <td class="border p-1"><b>{{@$param['t']}}</b></td>
                        <td class="border p-1"><b>{{@$param['n']}}</b></td>
                        <td class="border p-1"><b>{{@$param['r']}}</b></td>
                        <td class="border p-1"><b>{{@$param['s']}}</b></td>
                        @for ($i = 1; $i <= 45; $i++)
                            <td class="border">
                                <input type="hidden" name="fisik[monitoring][{{$key}}][{{$i}}]"  value="">
                                <input type="checkbox" name="fisik[monitoring][{{$key}}][{{$i}}]" class="selected_point" {{@$asessment['monitoring'][$key][$i] == "selected" ? 'checked' : ''}} value="selected">
                            </td>
                        @endfor
                      </tr>
                  @endforeach
              </table>
            </div>

            <div class="col-md-6">
              <div>
                <label>Medikasi</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td>1.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][1]" class="form-control" placeholder="1" value="{{ @$asessment['kartu_anestesi']['medikasi']['1'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>2.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][2]" class="form-control" placeholder="2" value="{{ @$asessment['kartu_anestesi']['medikasi']['2'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>3.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][3]" class="form-control" placeholder="3" value="{{ @$asessment['kartu_anestesi']['medikasi']['3'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][4]" class="form-control" placeholder="4" value="{{ @$asessment['kartu_anestesi']['medikasi']['4'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][5]" class="form-control" placeholder="5" value="{{ @$asessment['kartu_anestesi']['medikasi']['5'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>6.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][6]" class="form-control" placeholder="6" value="{{ @$asessment['kartu_anestesi']['medikasi']['6'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>7.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][7]" class="form-control" placeholder="7" value="{{ @$asessment['kartu_anestesi']['medikasi']['7'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][8]" class="form-control" placeholder="8" value="{{ @$asessment['kartu_anestesi']['medikasi']['8'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>9.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][9]" class="form-control" placeholder="9" value="{{ @$asessment['kartu_anestesi']['medikasi']['9'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>10.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][10]" class="form-control" placeholder="10" value="{{ @$asessment['kartu_anestesi']['medikasi']['10'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>11.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][11]" class="form-control" placeholder="11" value="{{ @$asessment['kartu_anestesi']['medikasi']['11'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>12.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][12]" class="form-control" placeholder="12" value="{{ @$asessment['kartu_anestesi']['medikasi']['12'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>13.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][13]" class="form-control" placeholder="13" value="{{ @$asessment['kartu_anestesi']['medikasi']['13'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>14.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][medikasi][14]" class="form-control" placeholder="14" value="{{ @$asessment['kartu_anestesi']['medikasi']['14'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-6">
              <div>
                <label>Pemberian Cairan</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td>1.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][1]" class="form-control" placeholder="1" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['1'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>2.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][2]" class="form-control" placeholder="2" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['2'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>3.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][3]" class="form-control" placeholder="3" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['3'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][4]" class="form-control" placeholder="4" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['4'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][5]" class="form-control" placeholder="5" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['5'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>6.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][6]" class="form-control" placeholder="6" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['6'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>7.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][7]" class="form-control" placeholder="7" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['7'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][8]" class="form-control" placeholder="8" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['8'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>9.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][9]" class="form-control" placeholder="9" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['9'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>10.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][10]" class="form-control" placeholder="10" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['10'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>11.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][11]" class="form-control" placeholder="11" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['11'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>12.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][12]" class="form-control" placeholder="12" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['12'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>13.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][13]" class="form-control" placeholder="13" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['13'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>14.</td>
                    <td>
                      <input type="text" name="fisik[kartu_anestesi][pemberian_cairan][14]" class="form-control" placeholder="14" value="{{ @$asessment['kartu_anestesi']['pemberian_cairan']['14'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-6">
              <div>
                <label>Masalah Durante Operasi</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2">
                      <textarea name="fisik[kartu_anestesi][masalah_durante_operasi]" style="width: 100%;" rows="5">{{ @$asessment['kartu_anestesi']['masalah_durante_operasi'] }}</textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-6">
              <div>
                <label>Tindakan</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2">
                      <textarea name="fisik[kartu_anestesi][tindakan]" style="width: 100%;" rows="5">{{ @$asessment['kartu_anestesi']['tindakan'] }}</textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>Cairan</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td>Total Asupan Cairan</td>
                    <td>
                      <span>1. Kristaloid</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][cairan][total_asupan][kristaloid]" class="form-control" placeholder="Kristaloid (mL)" value="{{ @$asessment['kartu_anestesi']['cairan']['total_asupan']['kristaloid'] }}">
                      <span>2. Koloid</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][cairan][total_asupan][koloid]" class="form-control" placeholder="Koloid (mL)" value="{{ @$asessment['kartu_anestesi']['cairan']['total_asupan']['koloid'] }}">
                      <span>3. Darah</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][cairan][total_asupan][darah]" class="form-control" placeholder="darah (mL)" value="{{ @$asessment['kartu_anestesi']['cairan']['total_asupan']['darah'] }}">
                      <span>4. Komponen darah</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][cairan][total_asupan][komponen_darah]" class="form-control" placeholder="komponen_darah (mL)" value="{{ @$asessment['kartu_anestesi']['cairan']['total_asupan']['komponen_darah'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Total Keluaran Cairan</td>
                    <td>
                      <span>1. Perdarahan</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][cairan][total_keluaran][perdarahan]" class="form-control" placeholder="perdarahan (mL)" value="{{ @$asessment['kartu_anestesi']['cairan']['total_keluaran']['perdarahan'] }}">
                      <span>2. Diuresis</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][cairan][total_keluaran][diuresis]" class="form-control" placeholder="diuresis (mL)" value="{{ @$asessment['kartu_anestesi']['cairan']['total_keluaran']['diuresis'] }}">
                      <span>3. Cairan lain</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][cairan][total_keluaran][cairan_lain]" class="form-control" placeholder="Cairan lain (mL)" value="{{ @$asessment['kartu_anestesi']['cairan']['total_keluaran']['cairan_lain'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12">
              <div>
                <label>Sectio Caesar</label>
              </div>
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td>Keadaan Bayi</td>
                    <td>
                      <input type="radio" name="fisik[kartu_anestesi][sectio_caesar][keadaan_bayi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['sectio_caesar']['keadaan_bayi'] == "Hidup" }} value="Hidup"> <label for="">Hidup</label>
                      <input type="radio" name="fisik[kartu_anestesi][sectio_caesar][keadaan_bayi]" class="form-check-input" {{ @$asessment['kartu_anestesi']['sectio_caesar']['keadaan_bayi'] == "Mati dalam kandungan" }} value="Mati dalam kandungan"> <label for="">Mati dalam kandungan</label>
                    </td>
                  </tr>
                  <tr>
                    <td>Jenis kelamin</td>
                    <td>
                      <input type="radio" name="fisik[kartu_anestesi][sectio_caesar][jenis_kelamin]" class="form-check-input" {{ @$asessment['kartu_anestesi']['sectio_caesar']['jenis_kelamin'] == "L" }} value="L"> <label for="">L</label>
                      <input type="radio" name="fisik[kartu_anestesi][sectio_caesar][jenis_kelamin]" class="form-check-input" {{ @$asessment['kartu_anestesi']['sectio_caesar']['jenis_kelamin'] == "P" }} value="P"> <label for="">P</label>
                    </td>
                  </tr>
                  <tr>
                    <td>APGAR SKOR</td>
                    <td>
                      <span>1 Menit</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][sectio_caesar][apgar_skor][1menit]" class="form-control" placeholder="1 Menit" value="{{ @$asessment['kartu_anestesi']['sectio_caesar']['apgar_skor']['perdarahan'] }}">
                      <span>5 Menit</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][sectio_caesar][apgar_skor][5menit]" class="form-control" placeholder="5 Menit" value="{{ @$asessment['kartu_anestesi']['sectio_caesar']['apgar_skor']['5menit'] }}">
                      <span>10 Menit</span> <br>
                      <input type="text" name="fisik[kartu_anestesi][sectio_caesar][apgar_skor][10menit]" class="form-control" placeholder="10 Menit" value="{{ @$asessment['kartu_anestesi']['sectio_caesar']['apgar_skor']['10menit'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12 text-right">
              <button class="btn btn-success">Simpan</button>
            </div>
            
          </div>

        </div>

      </form>
    </div>

  </div>
@endsection

@section('script')
    <script type="text/javascript">
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
@endsection
