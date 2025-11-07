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
      <form method="POST" action="{{ url('emr-soap/pemeriksaan/keadaan-pasca-bedah/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
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
              <h4 style="text-align: center;"><b>KEADAAN PASCA BEDAH</b></h4>
            </div>
            <div class="col-md-6">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td>Kesadaran</td>
                    <td>
                      <input type="datetime-local" name="fisik[keadaan_pasca_bedah][kesadaran]" class="form-control" placeholder="Kesadaran" value="{{ @$asessment['keadaan_pasca_bedah']['kesadaran'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Tekanan Darah</td>
                    <td>
                      <input type="text" name="fisik[keadaan_pasca_bedah][tekanan_darah]" class="form-control" placeholder="mmHG" value="{{ @$asessment['keadaan_pasca_bedah']['tekanan_darah'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>GCS</td>
                    <td>
                      E
                      <input type="text" name="fisik[keadaan_pasca_bedah][gcs][E]" class="form-control" placeholder="E" value="{{ @$asessment['keadaan_pasca_bedah']['gcs']['E'] }}">
                      <br>
                      M
                      <input type="text" name="fisik[keadaan_pasca_bedah][gcs][M]" class="form-control" placeholder="M" value="{{ @$asessment['keadaan_pasca_bedah']['gcs']['M'] }}">
                      <br>
                      V
                      <input type="text" name="fisik[keadaan_pasca_bedah][gcs][V]" class="form-control" placeholder="V" value="{{ @$asessment['keadaan_pasca_bedah']['gcs']['V'] }}">
                      <br>
                    </td>
                  </tr>
                  <tr>
                    <td>Nadi</td>
                    <td>
                      <input type="text" name="fisik[keadaan_pasca_bedah][nadi]" class="form-control" placeholder="x/menit" value="{{ @$asessment['keadaan_pasca_bedah']['nadi'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Support</td>
                    <td>
                      1).
                      <input type="text" name="fisik[keadaan_pasca_bedah][support][1]" class="form-control" placeholder="ug/kgBB/mnt" value="{{ @$asessment['keadaan_pasca_bedah']['support']['1'] }}">
                      <br>
                      2).
                      <input type="text" name="fisik[keadaan_pasca_bedah][support][2]" class="form-control" placeholder="ug/kgBB/mnt" value="{{ @$asessment['keadaan_pasca_bedah']['support']['2'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Respirasi</td>
                    <td>
                      <input type="checkbox" name="fisik[keadaan_pasca_bedah][respirasi][spontan]" value="Ya" {{ @$asessment['keadaan_pasca_bedah']['respirasi']['spontan'] == "Ya" ? "checked" : "" }}>
                      <label for="">Spontant, </label><br>
                      <span>RR : </span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][spontan_dipilih][rr]" class="form-control" placeholder="x/mnt" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['spontan_dipilih']['rr'] }}">
                      <span>O2 : </span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][spontan_dipilih][o2]" class="form-control" placeholder="L/mnt" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['spontan_dipilih']['o2'] }}">
                      <span>SPO2 : </span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][spontan_dipilih][spo2]" class="form-control" placeholder="%" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['spontan_dipilih']['spo2'] }}">
                      <br>
                      <input type="checkbox" name="fisik[keadaan_pasca_bedah][respirasi][assist]" value="Ya" {{ @$asessment['keadaan_pasca_bedah']['respirasi']['assist'] == "Ya" ? "checked" : "" }}>
                      <label for="">Assists</label>
                      <br>
                      <input type="checkbox" name="fisik[keadaan_pasca_bedah][respirasi][kontrol]" value="Ya" {{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol'] == "Ya" ? "checked" : "" }}>
                      <label for="">Kontrol</label><br>
                      <span>Tidal Volume :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][tidal_volume]" class="form-control" placeholder="mL" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['tidal_volume'] }}">
                      <span>RR :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][rr]" class="form-control" placeholder="x/mnt" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['rr'] }}">
                      <span>PIP :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][pip]" class="form-control" placeholder="PIP" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['pip'] }}">
                      <span>Tringger :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][tringger]" class="form-control" placeholder="Tringger" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['tringger'] }}">
                      <span>PEEP :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][peep]" class="form-control" placeholder="PEEP" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['peep'] }}">
                      <span>I:E ratio :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][ie_ratio]" class="form-control" placeholder="I:E ratio" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['ie_ratio'] }}">
                      <span>PS :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][ps]" class="form-control" placeholder="PS" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['ps'] }}">
                      <span>FIO2 :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][fio2]" class="form-control" placeholder="FIO2" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['fio2'] }}">
                      <span>SPO2 :</span> <br>
                      <input type="text" name="fisik[keadaan_pasca_bedah][respirasi][kontrol_dipilih][SPO2]" class="form-control" placeholder="%" value="{{ @$asessment['keadaan_pasca_bedah']['respirasi']['kontrol_dipilih']['SPO2'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Komplikasi</td>
                    <td>
                      <input type="text" name="fisik[keadaan_pasca_bedah][komplikasi]" class="form-control" placeholder="Komplikasi" value="{{ @$asessment['keadaan_pasca_bedah']['komplikasi'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>Tindakan</td>
                    <td>
                      <input type="text" name="fisik[keadaan_pasca_bedah][tindakan]" class="form-control" placeholder="Tindakan" value="{{ @$asessment['keadaan_pasca_bedah']['tindakan'] }}">
                    </td>
                  </tr>
                </tbody>
              </table>
              
            </div>

            <div class="col-md-6">
              <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                <tbody>
                  <tr>
                    <td colspan="2" style="text-align: center;"><label for="">INSTRUKSI OPERASI / PASCA ANESTESI</label></td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Pemantauan, kesadaran, Tekanan darah, Nadi, Respirasi setiap</td>
                    <td>
                      <textarea name="fisik[instruksi_pasca_operasi][pemantauan]" style="width: 100%" rows="10">{{ @$asessment['instruksi_pasca_operasi']['pemantauan'] }}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Posisi Pasien</td>
                    <td>
                      <textarea name="fisik[instruksi_pasca_operasi][posisi_pasien]" style="width: 100%" rows="10">{{ @$asessment['instruksi_pasca_operasi']['posisi_pasien'] }}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Pengelolaan Nyeri</td>
                    <td>
                      <textarea name="fisik[instruksi_pasca_operasi][pengelolaan_nyeri]" style="width: 100%" rows="10">{{ @$asessment['instruksi_pasca_operasi']['pengelolaan_nyeri'] }}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Penanganan Mual Muntah</td>
                    <td>
                      <textarea name="fisik[instruksi_pasca_operasi][penanganan_mual_muntah]" style="width: 100%" rows="10">{{ @$asessment['instruksi_pasca_operasi']['penanganan_mual_muntah'] }}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Diet dan Nutrisi</td>
                    <td>
                      <textarea name="fisik[instruksi_pasca_operasi][diet_dan_nutrisi]" style="width: 100%" rows="10">{{ @$asessment['instruksi_pasca_operasi']['diet_dan_nutrisi'] }}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Obat-obatan</td>
                    <td>
                      <textarea name="fisik[instruksi_pasca_operasi][obat_obatan]" style="width: 100%" rows="10">{{ @$asessment['instruksi_pasca_operasi']['obat_obatan'] }}</textarea>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Lain-lain</td>
                    <td>
                      <textarea name="fisik[instruksi_pasca_operasi][lain_lain]" style="width: 100%" rows="10">{{ @$asessment['instruksi_pasca_operasi']['lain_lain'] }}</textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
              
            </div>

            <div class="col-md-12">
              <div class="text-center">
                <label for="" style="text-align: center">Modified Aldert's Scoring System</label>
              </div>
              <table class="border" style="width: 100%;">
                <tbody class="border">
                  <tr class="border">
                    <td class="border p-1 text-center bold">Tanda</td>
                    <td class="border p-1 text-center bold">Kriteria</td>
                    <td class="border p-1 text-center bold">Nilai</td>
                    <td class="border p-1 text-center bold">15'</td>
                    <td class="border p-1 text-center bold">30'</td>
                    <td class="border p-1 text-center bold">45'</td>
                    <td class="border p-1 text-center bold">60'</td>
                    <td class="border p-1 text-center bold">Saat Keluar</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Aktifitas</td>
                    <td class="border p-1">Dapat menggerakan ke-4 anggota badan sendiri/dengan perintah</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][aktifitas][15]" value="{{@$asessment['modified_aldert_scoring_system']['aktifitas']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][aktifitas][30]" value="{{@$asessment['modified_aldert_scoring_system']['aktifitas']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][aktifitas][45]" value="{{@$asessment['modified_aldert_scoring_system']['aktifitas']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][aktifitas][60]" value="{{@$asessment['modified_aldert_scoring_system']['aktifitas']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][aktifitas][saat_keluar]" value="{{@$asessment['modified_aldert_scoring_system']['aktifitas']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Dapat menggerakan ke-2 anggota badan sendiri/dengan perintah</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Tidak dapat menggerakan anggota badan</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Respirasi</td>
                    <td class="border p-1">Dapat nafas dalam dan batuk bebas</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][respirasi][15]" value="{{@$asessment['modified_aldert_scoring_system']['respirasi']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][respirasi][30]" value="{{@$asessment['modified_aldert_scoring_system']['respirasi']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][respirasi][45]" value="{{@$asessment['modified_aldert_scoring_system']['respirasi']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][respirasi][60]" value="{{@$asessment['modified_aldert_scoring_system']['respirasi']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][respirasi][saat_keluar]" value="{{@$asessment['modified_aldert_scoring_system']['respirasi']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Dyspnoe atau nafas terbatas</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Apnoe</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Sirkulasi</td>
                    <td class="border p-1">TD +- 20% dari Pre Anestesi</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][sirkulasi][15]" value="{{@$asessment['modified_aldert_scoring_system']['sirkulasi']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][sirkulasi][30]" value="{{@$asessment['modified_aldert_scoring_system']['sirkulasi']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][sirkulasi][45]" value="{{@$asessment['modified_aldert_scoring_system']['sirkulasi']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][sirkulasi][60]" value="{{@$asessment['modified_aldert_scoring_system']['sirkulasi']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][sirkulasi][saat_keluar]" value="{{@$asessment['modified_aldert_scoring_system']['sirkulasi']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">TD +- 20 - 50% dari Pre Anestesi</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">TD +- 50% dari Pre Anestesi</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Kesadaran</td>
                    <td class="border p-1">Sadar Penuh</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][kesadaran][15]" value="{{@$asessment['modified_aldert_scoring_system']['kesadaran']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][kesadaran][30]" value="{{@$asessment['modified_aldert_scoring_system']['kesadaran']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][kesadaran][45]" value="{{@$asessment['modified_aldert_scoring_system']['kesadaran']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][kesadaran][60]" value="{{@$asessment['modified_aldert_scoring_system']['kesadaran']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][kesadaran][saat_keluar]" value="{{@$asessment['modified_aldert_scoring_system']['kesadaran']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Dapat dibangunkan bila dipanggil</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Tidak bereaksi</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Saturasi O2</td>
                    <td class="border p-1">> 90% dengan udara bebas</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][saturasi_o2][15]" value="{{@$asessment['modified_aldert_scoring_system']['saturasi_o2']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][saturasi_o2][30]" value="{{@$asessment['modified_aldert_scoring_system']['saturasi_o2']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][saturasi_o2][45]" value="{{@$asessment['modified_aldert_scoring_system']['saturasi_o2']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][saturasi_o2][60]" value="{{@$asessment['modified_aldert_scoring_system']['saturasi_o2']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][saturasi_o2][saat_keluar]" value="{{@$asessment['modified_aldert_scoring_system']['saturasi_o2']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Memerlukan tambahan O2, untuk menjaga SpO2 > 90%</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">SpO2 > 90% dengan tambahan O2</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border" colspan="2">&nbsp;</td>
                    <td class="border p-1 text-center">Score</td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][15][skor]" value="{{@$asessment['modified_aldert_scoring_system']['15']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][30][skor]" value="{{@$asessment['modified_aldert_scoring_system']['30']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][45][skor]" value="{{@$asessment['modified_aldert_scoring_system']['45']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][60][skor]" value="{{@$asessment['modified_aldert_scoring_system']['60']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][saat_keluar][skor]" value="{{@$asessment['modified_aldert_scoring_system']['saat_keluar']['skor']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border" colspan="2">Skor >= 8, pasien diperbolehkan pindah dari ruang pemulihan</td>
                    <td class="border p-1 text-center">Total Score :</td>
                    <td class="border p-1" colspan="5">
                      <input type="text" class="form-control" name="fisik[modified_aldert_scoring_system][total_skor]" value="{{@$asessment['modified_aldert_scoring_system']['total_skor']}}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12" style="margin-top: 1rem;">
              <div class="text-center">
                <label for="" style="text-align: center">Modified BROMAGE Score</label>
              </div>
              <table class="border" style="width: 100%;">
                <tbody class="border">
                  <tr class="border">
                    <td class="border p-1 text-center bold">No</td>
                    <td class="border p-1 text-center bold">Kriteria</td>
                    <td class="border p-1 text-center bold">Nilai</td>
                    <td class="border p-1 text-center bold">15'</td>
                    <td class="border p-1 text-center bold">30'</td>
                    <td class="border p-1 text-center bold">45'</td>
                    <td class="border p-1 text-center bold">60'</td>
                    <td class="border p-1 text-center bold">Saat Keluar</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center">1</td>
                    <td class="border p-1">Dapat mengangkat tungkai bawah</td>
                    <td class="border p-1 text-center">0</td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][1][15]" value="{{@$asessment['modified_bromage_score']['1']['15']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][1][30]" value="{{@$asessment['modified_bromage_score']['1']['30']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][1][45]" value="{{@$asessment['modified_bromage_score']['1']['45']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][1][60]" value="{{@$asessment['modified_bromage_score']['1']['60']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][1][saat_keluar]" value="{{@$asessment['modified_bromage_score']['1']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1">Tidak dapat menekuk lutut, tapi dapat mengangkat kaki</td>
                    <td class="border p-1 text-center">1</td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][2][15]" value="{{@$asessment['modified_bromage_score']['2']['15']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][2][30]" value="{{@$asessment['modified_bromage_score']['2']['30']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][2][45]" value="{{@$asessment['modified_bromage_score']['2']['45']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][2][60]" value="{{@$asessment['modified_bromage_score']['2']['60']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][2][saat_keluar]" value="{{@$asessment['modified_bromage_score']['2']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center">3</td>
                    <td class="border p-1">Tidak dapat mengangkat tungkai bawah, tetapi dapat menelkuk lutut</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][3][15]" value="{{@$asessment['modified_bromage_score']['3']['15']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][3][30]" value="{{@$asessment['modified_bromage_score']['3']['30']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][3][45]" value="{{@$asessment['modified_bromage_score']['3']['45']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][3][60]" value="{{@$asessment['modified_bromage_score']['3']['60']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][3][saat_keluar]" value="{{@$asessment['modified_bromage_score']['3']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center">4</td>
                    <td class="border p-1">Tidak dapat mengangkat kaki sama sekali</td>
                    <td class="border p-1 text-center">3</td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][4][15]" value="{{@$asessment['modified_bromage_score']['4']['15']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][4][30]" value="{{@$asessment['modified_bromage_score']['4']['30']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][4][45]" value="{{@$asessment['modified_bromage_score']['4']['45']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][4][60]" value="{{@$asessment['modified_bromage_score']['4']['60']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][4][saat_keluar]" value="{{@$asessment['modified_bromage_score']['4']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border" colspan="2">&nbsp;</td>
                    <td class="border p-1 text-center">Score</td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][15][skor]" value="{{@$asessment['modified_bromage_score']['15']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][30][skor]" value="{{@$asessment['modified_bromage_score']['30']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][45][skor]" value="{{@$asessment['modified_bromage_score']['45']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][60][skor]" value="{{@$asessment['modified_bromage_score']['60']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][saat_keluar][skor]" value="{{@$asessment['modified_bromage_score']['saat_keluar']['skor']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border" colspan="2">Pasien dapat dipindahkan jika skor kurang dari 2</td>
                    <td class="border p-1 text-center">Total Score :</td>
                    <td class="border p-1" colspan="5">
                      <input type="text" class="form-control" name="fisik[modified_bromage_score][total_skor]" value="{{@$asessment['modified_bromage_score']['total_skor']}}">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-12" style="margin-top: 1rem;">
              <div class="text-center">
                <label for="" style="text-align: center">Modified PADDS Scoring System Score</label>
              </div>
              <table class="border" style="width: 100%;">
                <tbody class="border">
                  <tr class="border">
                    <td class="border p-1 text-center bold">Tanda</td>
                    <td class="border p-1 text-center bold">Kriteria</td>
                    <td class="border p-1 text-center bold">Nilai</td>
                    <td class="border p-1 text-center bold">15'</td>
                    <td class="border p-1 text-center bold">30'</td>
                    <td class="border p-1 text-center bold">45'</td>
                    <td class="border p-1 text-center bold">60'</td>
                    <td class="border p-1 text-center bold">Saat Keluar</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Tanda Vital</td>
                    <td class="border p-1">< 20 % dari baseline preoperatif</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][tanda_vital][15]" value="{{@$asessment['modified_padds_scoring']['tanda_vital']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][tanda_vital][30]" value="{{@$asessment['modified_padds_scoring']['tanda_vital']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][tanda_vital][45]" value="{{@$asessment['modified_padds_scoring']['tanda_vital']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][tanda_vital][60]" value="{{@$asessment['modified_padds_scoring']['tanda_vital']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][tanda_vital][saat_keluar]" value="{{@$asessment['modified_padds_scoring']['tanda_vital']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">20 - 40% dari baseline preoperatif</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">> 40% dari baseline preoperatif</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Aktifitas</td>
                    <td class="border p-1">Seperti sebelum preoperatif</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][aktifitas][15]" value="{{@$asessment['modified_padds_scoring']['aktifitas']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][aktifitas][30]" value="{{@$asessment['modified_padds_scoring']['aktifitas']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][aktifitas][45]" value="{{@$asessment['modified_padds_scoring']['aktifitas']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][aktifitas][60]" value="{{@$asessment['modified_padds_scoring']['aktifitas']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][aktifitas][saat_keluar]" value="{{@$asessment['modified_padds_scoring']['aktifitas']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Memerlukan bantuan</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Tidak dapat ambulasi</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Mual dan Muntah</td>
                    <td class="border p-1">Minimal dengan obat oral</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][mual_dan_muntah][15]" value="{{@$asessment['modified_padds_scoring']['mual_dan_muntah']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][mual_dan_muntah][30]" value="{{@$asessment['modified_padds_scoring']['mual_dan_muntah']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][mual_dan_muntah][45]" value="{{@$asessment['modified_padds_scoring']['mual_dan_muntah']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][mual_dan_muntah][60]" value="{{@$asessment['modified_padds_scoring']['mual_dan_muntah']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][mual_dan_muntah][saat_keluar]" value="{{@$asessment['modified_padds_scoring']['mual_dan_muntah']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Sedang dengan obat parental</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Berlanjut dengan obat ulangan</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Nyeri</td>
                    <td class="border p-1">Minimal dengan obat oral</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][nyeri][15]" value="{{@$asessment['modified_padds_scoring']['nyeri']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][nyeri][30]" value="{{@$asessment['modified_padds_scoring']['nyeri']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][nyeri][45]" value="{{@$asessment['modified_padds_scoring']['nyeri']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][nyeri][60]" value="{{@$asessment['modified_padds_scoring']['nyeri']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][nyeri][saat_keluar]" value="{{@$asessment['modified_padds_scoring']['nyeri']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Masih merasa nyeri</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Tidak bereaksi</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1 text-center" rowspan="3">Perdarahan</td>
                    <td class="border p-1">Minimal tanpa ganti balutan</td>
                    <td class="border p-1 text-center">2</td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][perdarahan][15]" value="{{@$asessment['modified_padds_scoring']['perdarahan']['15']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][perdarahan][30]" value="{{@$asessment['modified_padds_scoring']['perdarahan']['30']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][perdarahan][45]" value="{{@$asessment['modified_padds_scoring']['perdarahan']['45']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][perdarahan][60]" value="{{@$asessment['modified_padds_scoring']['perdarahan']['60']}}">
                    </td>
                    <td class="border p-1" rowspan="3">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][perdarahan][saat_keluar]" value="{{@$asessment['modified_padds_scoring']['perdarahan']['saat_keluar']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Sedang dengan ganti balutan 2x</td>
                    <td class="border p-1 text-center">1</td>
                  </tr>
                  <tr class="border">
                    <td class="border p-1">Berat dengan ganti balutan 3x</td>
                    <td class="border p-1 text-center">0</td>
                  </tr>
                  <tr class="border">
                    <td class="border" colspan="2">&nbsp;</td>
                    <td class="border p-1 text-center">Score</td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][15][skor]" value="{{@$asessment['modified_padds_scoring']['15']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][30][skor]" value="{{@$asessment['modified_padds_scoring']['30']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][45][skor]" value="{{@$asessment['modified_padds_scoring']['45']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][60][skor]" value="{{@$asessment['modified_padds_scoring']['60']['skor']}}">
                    </td>
                    <td class="border p-1">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][saat_keluar][skor]" value="{{@$asessment['modified_padds_scoring']['saat_keluar']['skor']}}">
                    </td>
                  </tr>
                  <tr class="border">
                    <td class="border" colspan="2">Total Skor PADDS adalah 10 <br> Skor >= 9, pasien diperbolehkan pindah dari ruang pemulihan</td>
                    <td class="border p-1 text-center">Total Score :</td>
                    <td class="border p-1" colspan="5">
                      <input type="text" class="form-control" name="fisik[modified_padds_scoring][total_skor]" value="{{@$asessment['modified_padds_scoring']['total_skor']}}">
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
                      <td style="width:30%; font-weight:bold;">Masuk RR Jam</td>
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
