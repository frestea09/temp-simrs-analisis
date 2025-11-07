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
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/laporan-operasi-ods/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
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
                                    @foreach ($riwayats as $index => $riwayat)
                                        <tr>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                            </td>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                {{-- <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                                    class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> --}}
                                                         <button type="button" class="btn btn-primary" data-index="{{ $index }}" onclick="previewLaporan(event)">
                                                            <i class="fa fa-eye"></i> Preview & Print
                                                        </button>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                          <h4 style="text-align: center;"><b>LAPORAN OPERASI MATA</b></h4>
                        </div>
                        
                        <div class="col-md-12">
                          <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table"style="font-size:12px;">
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Tanggal Operasi</td>
                                  <td colspan="3">
                                      <input type="date" class="form-control" name="fisik[tanggalOperasi]" value="{{ @$asessment['tanggalOperasi']}}" />
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Ruang Operasi</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[ruangOperasi]" value="{{ @$asessment['ruangOperasi']}}" />
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Kamar</td>
                                  <td>
                                      <input type="text" class="form-control" name="fisik[kamar]" value="{{ @$asessment['kamar']}}" />
                                  </td>
                              </tr>
                              <tr>
                                  <td style="width:20%; font-weight:bold;">Cito / Terencana</td>
                                  <td>
                                    <div style="display: flex; flex-flow: column">
                                      <div style="width:100%;">
                                        <label for="sifat_1">
                                          <input class="form-check-input"
                                              name="fisik[sifat]" id="sifat_1"
                                              type="radio" value="Cito"  {{ @$asessment['sifat'] == 'Cito' ? 'checked' : '' }} >
                                          Cito
                                        </label>
                                      </div>
                                      <div style="width:100%;">
                                        <label for="sifat_2">
                                          <input class="form-check-input"
                                              name="fisik[sifat]" id="sifat_2"
                                              type="radio" value="Terencana"  {{ @$asessment['sifat'] == 'Terencana' ? 'checked' : '' }} >
                                          Terencana
                                        </label>
                                      </div>
                                    </div>
                                  </td>
                                  <td style="width:20%; font-weight:bold;">Area Operasi</td>
                                  <td>
                                    <div style="display: flex; flex-flow: column">
                                      <div style="width:100%;">
                                        <label for="">
                                          <input class="form-check-input"
                                              name="fisik[areaOperasi][1]" id=""
                                              type="checkbox" value="OD"  {{ @$asessment['areaOperasi'['1']] == 'OD' ? 'checked' : '' }} >
                                          OD
                                        </label>
                                      </div>
                                      <div style="width:100%;">
                                        <label for="">
                                          <input class="form-check-input"
                                              name="fisik[areaOperasi][2]" id=""
                                              type="checkbox" value="OS"  {{ @$asessment['areaOperasi'['2']] == 'OS' ? 'checked' : '' }} >
                                          OS
                                        </label>
                                      </div>
                                    </div>
                                  </td>
                              </tr>

                              <tr>
                                <td style="width:20%; font-weight:bold;">DPJP Bedah</td>
                                <td>
                                  <select name="fisik[dpjpBedah]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($dokters as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['dpjpBedah'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td style="width:20%; font-weight:bold;">Asisten</td>
                                <td>
                                  <select name="fisik[asisten]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($perawats as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['asisten'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>

                              <tr>
                                <td style="width:20%; font-weight:bold;">Perawat Instrumen</td>
                                <td>
                                  <select name="fisik[perawatInstrumen]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($perawats as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['perawatInstrumen'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td style="width:20%; font-weight:bold;">Lama operasi berlangsung</td>
                                <td>
                                  <input type="text" class="form-control" name="fisik[lamaOperasi]" value="{{ @$asessment['lamaOperasi']}}" />
                                </td>
                              </tr>

                              <tr>
                                <td style="width:20%; font-weight:bold;">Jam Mulai Operasi</td>
                                <td>
                                    <input type="time" class="form-control" name="fisik[jamMulaiOperasi]" value="{{ @$asessment['jamMulaiOperasi']}}" />
                                </td>
                                <td style="width:20%; font-weight:bold;">Jam Selesai Operasi</td>
                                <td>
                                    <input type="time" class="form-control" name="fisik[jamSelesaiOperasi]" value="{{ @$asessment['jamSelesaiOperasi']}}" />
                                </td>
                              </tr>

                              <tr>
                                <td style="width:20%; font-weight:bold;">Diagnosis Pre Operasi</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[diagnosisPreOperasi]" value="{{ @$asessment['diagnosisPreOperasi']}}" />
                                </td>
                                <td style="width:20%; font-weight:bold;">Obat-obatan anestesi</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[obatObatAnestesi]" value="{{ @$asessment['obatObatAnestesi']}}" />
                                </td>
                              </tr>

                              <tr>
                                <td style="width:20%; font-weight:bold;">Visus</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[visus]" value="{{ @$asessment['visus']}}" />
                                </td>
                                <td style="width:20%; font-weight:bold;">Jenis Anestesi</td>
                                <td>
                                  <div style="display: flex; flex-flow: column">
                                    <div style="width:100%;">
                                      <label for="">
                                        <input class="form-check-input"
                                            name="fisik[jenisAnestesi][1]" id=""
                                            type="checkbox" value="Lokal"  {{ @$asessment['jenisAnestesi'['1']] == 'Lokal' ? 'checked' : '' }} >
                                        Lokal
                                      </label>
                                    </div>
                                    <div style="width:100%;">
                                      <label for="">
                                        <input class="form-check-input"
                                            name="fisik[jenisAnestesi][2]" id=""
                                            type="checkbox" value="Anestesi Umum"  {{ @$asessment['jenisAnestesi'['2']] == 'Anestesi Umum' ? 'checked' : '' }} >
                                        Anestesi Umum
                                      </label>
                                    </div>
                                    <div style="width:100%;">
                                      <label for="">
                                        <input class="form-check-input"
                                            name="fisik[jenisAnestesi][3]" id=""
                                            type="checkbox" value="Sedasi"  {{ @$asessment['jenisAnestesi'['3']] == 'Sedasi' ? 'checked' : '' }} >
                                        Sedasi
                                      </label>
                                    </div>
                                    <div style="width:100%;">
                                      <label for="">
                                        <input class="form-check-input"
                                            name="fisik[jenisAnestesi][4]" id=""
                                            type="checkbox" value="Anestesi Block"  {{ @$asessment['jenisAnestesi'['4']] == 'Anestesi Block' ? 'checked' : '' }} >
                                        Anestesi Block
                                      </label>
                                    </div>
                                  </div>
                                </td>
                              </tr>

                              <tr>
                                <td style="width:20%; font-weight:bold;">Indikasi Operasi</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[indikasiOperasi]" value="{{ @$asessment['indikasiOperasi']}}" />
                                </td>
                                <td style="width:20%; font-weight:bold;">Jenis Operasi</td>
                                <td>
                                    <input type="text" class="form-control" name="fisik[jenisOperasi]" value="{{ @$asessment['jenisOperasi']}}" />
                                </td>
                              </tr>

                              <tr>
                                <td style="width:20%; font-weight:bold;">Diagnosis Post Operasi</td>
                                <td colspan="3">
                                    <input type="text" class="form-control" name="fisik[diagnosisPostOperasi]" value="{{ @$asessment['diagnosisPostOperasi']}}" />
                                </td>
                              </tr>

                              <tr>
                                <td style="width:20%; font-weight:bold;">DPJP Anestesi</td>
                                <td>
                                  <select name="fisik[dpjpAnestesi]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($dokters as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['dpjpAnestesi'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td style="width:20%; font-weight:bold;">Perawat Anestesi</td>
                                <td>
                                  <select name="fisik[perawatAnestesi]" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($perawats as $id => $nama)
                                      <option value="{{ $nama }}" {{ @$asessment['perawatAnestesi'] == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                          </table>


                          <table style="width: 100%; font-size: 12px;" class="table-striped table-bordered table-hover table-condensed form-box table">
                            <tr>
                              <td style="width:20%; font-weight:bold;">Anesthesi</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[anesthesi][1]" id=""
                                          type="checkbox" value="Retrobulbar"  {{ @$asessment['anesthesi']['1'] == 'Retrobulbar' ? 'checked' : '' }} >
                                      Retrobulbar
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[anesthesi][2]" id=""
                                          type="checkbox" value="Lidocain 2%"  {{ @$asessment['anesthesi']['2'] == 'Lidocain 2%' ? 'checked' : '' }} >
                                      Lidocain 2%
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[anesthesi][3]" id=""
                                          type="checkbox" value="Peribulber"  {{ @$asessment['anesthesi']['3'] == 'Peribulber' ? 'checked' : '' }} >
                                      Peribulber
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[anesthesi][4]" id=""
                                          type="checkbox" value="Marcain 0,5%"  {{ @$asessment['anesthesi']['4'] == 'Marcain 0,5%' ? 'checked' : '' }} >
                                      Marcain 0,5%
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[anesthesi][5]" id=""
                                          type="checkbox" value="Topikal"  {{ @$asessment['anesthesi']['5'] == 'Topikal' ? 'checked' : '' }} >
                                      Topikal
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[anesthesi][6]" id=""
                                          type="checkbox" value="Subtenon"  {{ @$asessment['anesthesi']['6'] == 'Subtenon' ? 'checked' : '' }} >
                                      Subtenon
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[anesthesi][7]" id=""
                                          type="checkbox" value="NU"  {{ @$asessment['anesthesi']['7'] == 'NU' ? 'checked' : '' }} >
                                      NU
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[anesthesi][8]" id=""
                                          type="checkbox" value="Lain-lain"  {{ @$asessment['anesthesi']['8'] == 'Lain-lain' ? 'checked' : '' }} >
                                      Lain-lain
                                    </label>
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Peritomi</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[peritomi][1]" id=""
                                          type="checkbox" value="Basis Forniks"  {{ @$asessment['peritomi']['1'] == 'Basis Forniks' ? 'checked' : '' }} >
                                      Basis Forniks
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[peritomi][2]" id=""
                                          type="checkbox" value="Basis Limbus"  {{ @$asessment['peritomi']['2'] == 'Basis Limbus' ? 'checked' : '' }} >
                                      Basis Limbus
                                    </label>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Lokasi</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasi][1]" id=""
                                          type="checkbox" value="Superonasal"  {{ @$asessment['lokasi']['1'] == 'Superonasal' ? 'checked' : '' }} >
                                      Superonasal
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasi][2]" id=""
                                          type="checkbox" value="Superior"  {{ @$asessment['lokasi']['2'] == 'Superior' ? 'checked' : '' }} >
                                      Superior
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasi][3]" id=""
                                          type="checkbox" value="Superotemporal"  {{ @$asessment['lokasi']['3'] == 'Superotemporal' ? 'checked' : '' }} >
                                      Superotemporal
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasi][4]" id=""
                                          type="checkbox" value="Temporal"  {{ @$asessment['lokasi']['4'] == 'Temporal' ? 'checked' : '' }} >
                                      Temporal
                                    </label>
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Lokasi Insisi</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasiInsisi][1]" id=""
                                          type="checkbox" value="Kornea"  {{ @$asessment['lokasiInsisi']['1'] == 'Kornea' ? 'checked' : '' }} >
                                      Kornea
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasiInsisi][2]" id=""
                                          type="checkbox" value="Limbus"  {{ @$asessment['lokasiInsisi']['2'] == 'Limbus' ? 'checked' : '' }} >
                                      Limbus
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasiInsisi][3]" id=""
                                          type="checkbox" value="Sklera"  {{ @$asessment['lokasiInsisi']['3'] == 'Sklera' ? 'checked' : '' }} >
                                      Sklera
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasiInsisi][4]" id=""
                                          type="checkbox" value="Skleraltunnel"  {{ @$asessment['lokasiInsisi']['4'] == 'Skleraltunnel' ? 'checked' : '' }} >
                                      Skleraltunnel
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[lokasiInsisi][5]" id=""
                                          type="checkbox" value="Side Port"  {{ @$asessment['lokasiInsisi']['5'] == 'Side Port' ? 'checked' : '' }} >
                                      Side Port
                                    </label>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Ukuran Insisi</td>
                              <td>
                                <input type="text" class="form-control" name="fisik[ukuranInsisi]" value="{{ @$asessment['ukuranInsisi']}}" />
                              </td>
                              <td style="width:20%; font-weight:bold;">Alat Insisi</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[alatInsisi][1]" id=""
                                          type="checkbox" value="Jarum"  {{ @$asessment['alatInsisi']['1'] == 'Jarum' ? 'checked' : '' }} >
                                      Jarum
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[alatInsisi][2]" id=""
                                          type="checkbox" value="Crescent"  {{ @$asessment['alatInsisi']['2'] == 'Crescent' ? 'checked' : '' }} >
                                      Crescent
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[alatInsisi][3]" id=""
                                          type="checkbox" value="Diamond"  {{ @$asessment['alatInsisi']['3'] == 'Diamond' ? 'checked' : '' }} >
                                      Diamond
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[alatInsisi][4]" id=""
                                          type="checkbox" value="Keratome"  {{ @$asessment['alatInsisi']['4'] == 'Keratome' ? 'checked' : '' }} >
                                      Keratome
                                    </label>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Capsulectomy Anterior</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[capsulectomyAnterior][1]" id=""
                                          type="checkbox" value="Can Opener"  {{ @$asessment['capsulectomyAnterior']['1'] == 'Can Opener' ? 'checked' : '' }} >
                                      Can Opener
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[capsulectomyAnterior][2]" id=""
                                          type="checkbox" value="Envelope"  {{ @$asessment['capsulectomyAnterior']['2'] == 'Envelope' ? 'checked' : '' }} >
                                      Envelope
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[capsulectomyAnterior][3]" id=""
                                          type="checkbox" value="CCC"  {{ @$asessment['capsulectomyAnterior']['3'] == 'CCC' ? 'checked' : '' }} >
                                      CCC
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[capsulectomyAnterior][4]" id=""
                                          type="checkbox" value="FLACS"  {{ @$asessment['capsulectomyAnterior']['4'] == 'FLACS' ? 'checked' : '' }} >
                                      FLACS
                                    </label>
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Ekstrasksi Lensa</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[ekstraksiLensa][1]" id=""
                                          type="checkbox" value="Phaco"  {{ @$asessment['ekstraksiLensa']['1'] == 'Phaco' ? 'checked' : '' }} >
                                      Phaco
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[ekstraksiLensa][2]" id=""
                                          type="checkbox" value="ECCE"  {{ @$asessment['ekstraksiLensa']['2'] == 'ECCE' ? 'checked' : '' }} >
                                      ECCE
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[ekstraksiLensa][3]" id=""
                                          type="checkbox" value="AI"  {{ @$asessment['ekstraksiLensa']['3'] == 'AI' ? 'checked' : '' }} >
                                      AI
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[ekstraksiLensa][4]" id=""
                                          type="checkbox" value="SICE"  {{ @$asessment['ekstraksiLensa']['4'] == 'SICE' ? 'checked' : '' }} >
                                      SICE
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[ekstraksiLensa][5]" id=""
                                          type="checkbox" value="RLE"  {{ @$asessment['ekstraksiLensa']['5'] == 'RLE' ? 'checked' : '' }} >
                                      RLE
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[ekstraksiLensa][6]" id=""
                                          type="checkbox" value="ICCE"  {{ @$asessment['ekstraksiLensa']['6'] == 'ICCE' ? 'checked' : '' }} >
                                      ICCE
                                    </label>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Tindakan Tambahan</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[tindakanTambahan][1]" id=""
                                          type="checkbox" value="Sinechiolysis"  {{ @$asessment['tindakanTambahan']['1'] == 'Sinechiolysis' ? 'checked' : '' }} >
                                      Sinechiolysis
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[tindakanTambahan][2]" id=""
                                          type="checkbox" value="Jahitan Iris"  {{ @$asessment['tindakanTambahan']['2'] == 'Jahitan Iris' ? 'checked' : '' }} >
                                      Jahitan Iris
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[tindakanTambahan][3]" id=""
                                          type="checkbox" value="Vitrectomy Anterior"  {{ @$asessment['tindakanTambahan']['3'] == 'Vitrectomy Anterior' ? 'checked' : '' }} >
                                      Vitrectomy Anterior
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[tindakanTambahan][4]" id=""
                                          type="checkbox" value="Kapsulotomi post"  {{ @$asessment['tindakanTambahan']['4'] == 'Kapsulotomi post' ? 'checked' : '' }} >
                                      Kapsulotomi post
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[tindakanTambahan][5]" id=""
                                          type="checkbox" value="Sphincterectomy"  {{ @$asessment['tindakanTambahan']['5'] == 'Sphincterectomy' ? 'checked' : '' }} >
                                      Sphincterectomy
                                    </label>
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Cairan Irigasi</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanIrigasi][1]" id=""
                                          type="checkbox" value="R.L"  {{ @$asessment['cairanIrigasi']['1'] == 'R.L' ? 'checked' : '' }} >
                                      R.L
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanIrigasi][2]" id=""
                                          type="checkbox" value="B.S.S"  {{ @$asessment['cairanIrigasi']['2'] == 'B.S.S' ? 'checked' : '' }} >
                                      B.S.S
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanIrigasi][3]" id=""
                                          type="checkbox" value="Fiksasi Sklera"  {{ @$asessment['cairanIrigasi']['3'] == 'Fiksasi Sklera' ? 'checked' : '' }} >
                                      Fiksasi Sklera
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanIrigasi][4]" id=""
                                          type="checkbox" value="Lain-lain"  {{ @$asessment['cairanIrigasi']['4'] == 'Lain-lain' ? 'checked' : '' }} >
                                      Lain-lain
                                    </label>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Fiksasi LIO</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[fiksasiLIO][1]" id=""
                                          type="checkbox" value="In the bag"  {{ @$asessment['fiksasiLIO']['1'] == 'In the bag' ? 'checked' : '' }} >
                                      In the bag
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[fiksasiLIO][2]" id=""
                                          type="checkbox" value="B.M.D"  {{ @$asessment['fiksasiLIO']['2'] == 'B.M.D' ? 'checked' : '' }} >
                                      B.M.D
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[fiksasiLIO][3]" id=""
                                          type="checkbox" value="Sulkus Siliaris"  {{ @$asessment['fiksasiLIO']['3'] == 'Sulkus Siliaris' ? 'checked' : '' }} >
                                      Sulkus Siliaris
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[fiksasiLIO][4]" id=""
                                          type="checkbox" value="Afakia"  {{ @$asessment['fiksasiLIO']['4'] == 'Afakia' ? 'checked' : '' }} >
                                      Afakia
                                    </label>
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Penanaman</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[penanaman][1]" id=""
                                          type="checkbox" value="Diputar"  {{ @$asessment['penanaman']['1'] == 'Diputar' ? 'checked' : '' }} >
                                      Diputar
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[penanaman][2]" id=""
                                          type="checkbox" value="Tidak Diputar"  {{ @$asessment['penanaman']['2'] == 'Tidak Diputar' ? 'checked' : '' }} >
                                      Tidak Diputar
                                    </label>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Jenis LIO</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[jenisLIO][1]" id=""
                                          type="checkbox" value="Dilipat"  {{ @$asessment['jenisLIO']['1'] == 'Dilipat' ? 'checked' : '' }} >
                                      Dilipat
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[jenisLIO][2]" id=""
                                          type="checkbox" value="Tidak Dilipat"  {{ @$asessment['jenisLIO']['2'] == 'Tidak Dilipat' ? 'checked' : '' }} >
                                      Tidak Dilipat
                                    </label>
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Posisi LIO</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[posisiLIO][1]" id=""
                                          type="checkbox" value="Vertikal"  {{ @$asessment['posisiLIO']['1'] == 'Vertikal' ? 'checked' : '' }} >
                                      Vertikal
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[posisiLIO][2]" id=""
                                          type="checkbox" value="Horizontal"  {{ @$asessment['posisiLIO']['2'] == 'Horizontal' ? 'checked' : '' }} >
                                      Horizontal
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[posisiLIO][3]" id=""
                                          type="checkbox" value="Miring"  {{ @$asessment['posisiLIO']['3'] == 'Miring' ? 'checked' : '' }} >
                                      Miring
                                    </label>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Cairan Viscoelastik</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanViscoelastik][1]" id=""
                                          type="checkbox" value="Healon"  {{ @$asessment['cairanViscoelastik']['1'] == 'Healon' ? 'checked' : '' }} >
                                      Healon
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanViscoelastik][2]" id=""
                                          type="checkbox" value="Viscoat"  {{ @$asessment['cairanViscoelastik']['2'] == 'Viscoat' ? 'checked' : '' }} >
                                      Viscoat
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanViscoelastik][3]" id=""
                                          type="checkbox" value="Amvisc"  {{ @$asessment['cairanViscoelastik']['3'] == 'Amvisc' ? 'checked' : '' }} >
                                      Amvisc
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanViscoelastik][4]" id=""
                                          type="checkbox" value="Healon 5"  {{ @$asessment['cairanViscoelastik']['4'] == 'Healon 5' ? 'checked' : '' }} >
                                      Healon 5
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[cairanViscoelastik][5]" id=""
                                          type="checkbox" value="Rohtovisc"  {{ @$asessment['cairanViscoelastik']['5'] == 'Rohtovisc' ? 'checked' : '' }} >
                                      Rohtovisc
                                    </label>
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Benang</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[benang][1]" id=""
                                          type="checkbox" value="Vicryl 8-0"  {{ @$asessment['benang']['1'] == 'Vicryl 8-0' ? 'checked' : '' }} >
                                      Vicryl 8-0
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[benang][2]" id=""
                                          type="checkbox" value="Ethylon 10-0"  {{ @$asessment['benang']['2'] == 'Ethylon 10-0' ? 'checked' : '' }} >
                                      Ethylon 10-0
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[benang][3]" id=""
                                          type="checkbox" value="Jahitan"  {{ @$asessment['benang']['3'] == 'Jahitan' ? 'checked' : '' }} >
                                      Jahitan
                                    </label>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">TIO Pra Bedah</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      OD (mm)
                                    </label>
                                    <input type="text" class="form-control" name="fisik[TIOPraBedah][od]" value="{{ @$asessment['TIOPraBedah']['od']}}" />
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      OS (mmHg)
                                    </label>
                                    <input type="text" class="form-control" name="fisik[TIOPraBedah][os]" value="{{ @$asessment['TIOPraBedah']['os']}}" />
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Perdarahan</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[perdarahan][1]" id=""
                                          type="checkbox" value="Tidak"  {{ @$asessment['perdarahan']['1'] == 'Tidak' ? 'checked' : '' }} >
                                      Tidak
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[perdarahan][2]" id=""
                                          type="checkbox" value="Ada"  {{ @$asessment['perdarahan']['2'] == 'Ada' ? 'checked' : '' }} >
                                      Ada
                                    </label>
                                    <input type="text" class="form-control" name="fisik[perdarahan][jumlahPendarahan]" value="{{ @$asessment['perdarahan']['jumlahPendarahan']}}" />
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Komplikasi dan Penangananya</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[komplikasi][1]" id=""
                                          type="checkbox" value="Tidak"  {{ @$asessment['komplikasi']['1'] == 'Tidak' ? 'checked' : '' }} >
                                      Tidak
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[komplikasi][2]" id=""
                                          type="checkbox" value="Ya"  {{ @$asessment['komplikasi']['2'] == 'Ya' ? 'checked' : '' }} >
                                      Ya
                                    </label>
                                    <input type="text" placeholder="Isi Jika Ya" class="form-control" name="fisik[komplikasi][jelaskan]" value="{{ @$asessment['perdarahan']['jelaskan']}}" />
                                  </div>
                                </div>
                              </td>
                              <td style="width:20%; font-weight:bold;">Pemeriksaan PA</td>
                              <td>
                                <div style="display: flex; flex-flow: column">
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[pemeriksaanPA][1]" id=""
                                          type="checkbox" value="Tidak"  {{ @$asessment['pemeriksaanPA']['1'] == 'Tidak' ? 'checked' : '' }} >
                                      Tidak
                                    </label>
                                  </div>
                                  <div style="width:100%;">
                                    <label for="">
                                      <input class="form-check-input"
                                          name="fisik[pemeriksaanPA][2]" id=""
                                          type="checkbox" value="Ya"  {{ @$asessment['pemeriksaanPA']['2'] == 'Ya' ? 'checked' : '' }} >
                                      Ya
                                    </label>
                                    <input type="text" placeholder="Jenis Spesimen" class="form-control" name="fisik[pemeriksaanPA][jenisSpesimen]" value="{{ @$asessment['pemeriksaanPA']['jenisSpesimen']}}" />
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="width:20%; font-weight:bold;">Instruksi Pasca Bedah</td>
                              <td colspan="3">
                                <textarea name="fisik[instruksiPascaBedah]" class="form-control" style="resize: vertical;" rows="5">{{ @$asessment['instruksiPascaBedah'] }}</textarea>
                              </td>
                            </tr>
                          </table>
                        </div>

                        <br /><br />
                    </div>
                </div>

                <div class="col-md-12 text-right">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    @endsection
    <!-- Modal Preview -->
    <div id="previewModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Preview Laporan Operasi Mata</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="previewContent">
                        <!-- Isi preview laporan akan dimasukkan di sini -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="printLaporan()">Cetak</button>
                </div>
            </div>
        </div>
    </div>


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
            function previewLaporan($inputindex) {
        // Ambil data dari form input
               let index = event.target.getAttribute('data-index');

            // Pastikan index tidak undefined
            if (index === undefined) {
                console.error("Index is undefined.");
                return;
            }
            var assesment = @json($asessment);  

            var pasien = @json($pasien);  
            var reg = @json($reg); 
            // Ambil data riwayat berdasarkan index
            var riwayats = @json($riwayats); 
            var dataFisikOperasi = JSON.parse(riwayats[index]["fisik"]) ;
            console.log(dataFisikOperasi)
            console.log(assesment)
            console.log(dataFisikOperasi.diagnosisPreOperasi)
        let tanggalOperasi = document.querySelector('input[name="fisik[tanggalOperasi]"]')?.value || ".....";
        let ruangOperasi = document.querySelector('input[name="fisik[ruangOperasi]"]')?.value || ".....";
        let kamar = document.querySelector('input[name="fisik[kamar]"]')?.value || ".....";
        let dpjpBedah = document.querySelector('select[name="fisik[dpjpBedah]"]')?.value || ".....";
        let perawatInstrumen = document.querySelector('select[name="fisik[perawatInstrumen]"]')?.value || ".....";
        let jenisOperasi = document.querySelector('input[name="fisik[jenisOperasi]"]')?.value || ".....";
        let diagnosisPostOperasi = document.querySelector('input[name="fisik[diagnosisPostOperasi]"]')?.value || ".....";
        let instruksiPascaBedah = document.querySelector('textarea[name="fisik[instruksiPascaBedah]"]')?.value || ".....";
        var tgllahir = pasien["tgllahir"];  // Menggunakan template literal

        // Fungsi untuk format tanggal menjadi dd-mm-yyyy
        function formatDate(dateString) {
            var date = new Date(dateString);  // Membuat objek Date dari string tanggal
            var day = date.getDate();  // Mendapatkan hari (tanggal)
            var month = date.getMonth() + 1;  // Mendapatkan bulan (bulan dimulai dari 0, jadi tambahkan 1)
            var year = date.getFullYear();  // Mendapatkan tahun

            // Menambahkan leading zero jika hari atau bulan kurang dari 10
            day = (day < 10) ? '0' + day : day;
            month = (month < 10) ? '0' + month : month;

            // Mengembalikan tanggal dalam format dd-mm-yyyy
            return day + '-' + month + '-' + year;
        }
      function calculateAge(birthdate, currentDate) {
            // Memisahkan tanggal dan waktu pada created (karena ada waktu pada created_at)
            var current = new Date(currentDate.split(' ')[0]);  // Ambil hanya bagian tanggal (yyyy-mm-dd)
            var birth = new Date(birthdate);  // Membuat objek Date untuk tanggal lahir

            // Jika tanggal lahir lebih besar dari tanggal saat ini, umur harus 0
            if (birth > current) {
                return 0;
            }

            // Menghitung umur berdasarkan tahun
            var age = current.getFullYear() - birth.getFullYear();
            var month = current.getMonth() - birth.getMonth();  // Menghitung selisih bulan
            var day = current.getDate() - birth.getDate();  // Menghitung selisih hari

            // Menyesuaikan umur jika bulan atau hari belum tercapai
            if (month < 0 || (month === 0 && day < 0)) {
                age--;  // Kurangi 1 tahun jika bulan atau hari belum tercapai
            }

            return age;  // Mengembalikan umur
        }

    // Format tanggal lahir
     var formattedDate = formatDate(tgllahir);
      var umur = calculateAge(tgllahir, reg['created_at']);
      var jenisAnastesi = Object.values(dataFisikOperasi.jenisAnestesi);
        // Membuat HTML untuk preview
             var umur = calculateAge(tgllahir, reg['created_at']);
      var jenisAnastesi = dataFisikOperasi?.jenisAnestesi ;
      const now = new Date();
            var smf = @json($smf);

      // Format tanggal dalam format dd-mm-yyyy
      const day = ("0" + now.getDate()).slice(-2); // Menambahkan leading zero jika hari kurang dari 10
      const month = ("0" + (now.getMonth() + 1)).slice(-2); // Menambahkan leading zero jika bulan kurang dari 10
      const year = now.getFullYear();

      // Format jam dalam format hh:mm
      const hours = ("0" + now.getHours()).slice(-2); // Menambahkan leading zero jika jam kurang dari 10
      const minutes = ("0" + now.getMinutes()).slice(-2); // Menambahkan leading zero jika menit kurang dari 10

      // Menyusun tanggal dan jam dalam format yang diinginkan
      const formattedDateTemp = `${day}-${month}-${year}`;
      const formattedTime = `${hours}:${minutes}`;
      let laporanHTML = `
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Operasi</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0.5cm;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        .center-text {
            text-align: center;
            font-weight: bold;
        }
        .right-text {
            text-align: right;
            font-weight: bold;
        }
        .container {
            padding-top: 1%;
            padding-bottom: 1%;
        }
        .container-to-right {
            text-align: right;
            padding: 1% 1%;
        }
        .container-medium {
            width: 50%;
            padding: 1%;
        }
        .container-border {
            border: 1px solid black;
        }
        .container-custom-left {
            padding-top: 1%;
            padding-left: 0.8%;
        }
        .container-custom-bottom {
            padding-bottom: 7%;
        }
        .size-medium {
            width: 40%;
        }
        @media print {
          .page-break {
              page-break-before: always;
          }
    .hide-on-print {
        visibility: hidden;
    }

      }
    </style>
</head>
<body>
   <table>
        <tr >
            <td rowspan="3" class="container-border" style="width: 20%; text-align: center; padding : 2%; ">    
              <img src="{{ asset('images/1679985924Lambang_Kabupaten_Bandung,_Jawa_Barat,_Indonesia.svg.png') }}" alt="Logo RSUD" style="width: 50%; height: auto;"><br/>
              <span  style="font-size : 60%; font-weight: bold;">RSUD OTO ISKANDAR DINATA</span><br/>
              <span style="font-size : 5px">Jl. Gading Tutuka, RT.01 RW.01, Kp, Cincin Kolot, Kec. Soreang, Kab. Bandung,
Jawa Barat</span>
            </td>
            <td colspan="2" class="center-text container-border" style="border-bottom : 0px white; padding-top : 2%">LAPORAN OPERASI</td>
            <td rowspan="3" class="container-border" style="width: 30%; padding-left : 1%; padding-right : auto;    padding-top : 2%;   font-size : 17px;">
                <span style="font-weight: bold;">No. RM</span> : ${riwayats[index]['pasien_id'] || ''}<br>
                <span style="font-weight: bold;">Nama</span> : ${pasien['nama'] || ''}  <span style="font-weight: normal;">${pasien['kelamin'] == "L" ? "L / <del>P</del>" : "<del>L</del> / P"} </span><br>
                <span style="font-weight: bold;">Tgl. lahir</span> : ${formattedDate || ''} <br>  <span style="font-weight: bold;">Umur</span> : ${umur}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="center-text container-border" style="border-top : 0px white; ; padding-top : 2%;">SMF  ${smf[3]}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="container-to-right container-border" colspan="4" style="border-top : 0px white; border-bottom : 0px white; font-weight : bold;">Halaman 1 dari 2</td>
        </tr>
    </table>
    <table>
         <tr>
            <td class="container-medium container-border" colspan="2" style="font-weight : bold;">
              <table>
                <tr>
                  <td style="padding-top : 2%; padding-bottom : 2%; border : 0px white; "><span style="font-weight : bold">Ruang Operasi</span> : ${dataFisikOperasi.ruangOperasi}</td>
                  <td style="padding-top : 2%; padding-bottom : 2%; border : 0px white;"><span style="font-weight : bold">Kamar </span> : ${dataFisikOperasi.kamar}</td>
                </tr>
                <tr>
                  <td class="container-medium container-border" colspan="2" style="border : 0px white;""><span style="font-weight : bold;">Cito / Terencana</span> : ${dataFisikOperasi.sifat}</td>
                </tr>
                <tr>
                  <td class="container-medium container-border" colspan="2" style="border : 0px white;""><span style="font-weight : bold;">Area Operasi</span> : <input type="checkbox"  ${dataFisikOperasi.areaOperasi[1] == "OD" ? "checked" : ""}> <span style="font-weight : bold">OD</span> <input type="checkbox"  ${dataFisikOperasi.areaOperasi[2] == "OS" ? "checked" : ""}><span style="font-weight : bold">OS</span></td>
                </tr>
               </table>
            </td>
             <td class="container-medium container-border" colspan="2" style="font-weight : bold;">
              <table>
                <tr>
                    <td class="container-medium container-border" colspan="2" style=" border : 0px white;"><span style="font-weight : bold">DPJP Bedah</span> : ${dataFisikOperasi.dpjpBedah}</td>
                </tr>
                <tr>
                    <td class="container-medium container-border" colspan="2" style=" border : 0px white;"><span style="font-weight : bold">Asisten</span> : ${dataFisikOperasi.asisten}</td>
                </tr>
                 <tr>
                    <td class="container-medium container-border" colspan="2" style=" border : 0px white;"><span style="font-weight : bold">Perawat Instrumen</span> : ${dataFisikOperasi.perawatInstrumen}</td>
                </tr>
              </table>
            </td>
        </tr>
        <tr>
          <table>
            <tr>
              <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Jam Mulai Operasi</span> : ${dataFisikOperasi.jamMulaiOperasi}</td>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold; border-bottom : 0px white;"></td>
            </tr>
            <tr>
                <td class="container-medium container-border" colspan="2" style=" border-top : 0px white;"><span  style="font-weight : bold;">Jam Selesai Operasi</span>  :  ${dataFisikOperasi.jamSelesaiOperasi}</td> 
                <td class="container-medium container-border" colspan="2" style=" border-top : 0px white;"><span  style="font-weight : bold; border-top : 0px white;">Lama Operasi Berlangsung </span> : ${dataFisikOperasi.lamaOperasi}</td> 
            </tr>
          </table>
        </tr>
        <tr>
          <table>
            <tr>
              <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Diagnosis Pre Operasi</span> : ${dataFisikOperasi.diagnosisPreOperasi}</td>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold; border-bottom : 0px white;"></td>
            </tr>
            <tr style=" border-bottom : 0px white;">
                <td class="container-medium container-border" colspan="2" style=" border-top : 0px white; border-bottom : 0px white;"><span  style="font-weight : bold;">Visus</span>  :  ${dataFisikOperasi.visus}</td> 
                <td class="container-medium container-border" colspan="2" style=" border-top : 0px white; border-bottom : 0px white;"><span  style="font-weight : bold;">Jenis Anestesi</span>  : 
                  <table style="border : 0px white;">
                    <tr style="border : 0px white;">
                      <td  style="border : 0px white;"><input type="checkbox"  ${dataFisikOperasi?.jenisAnestesi[1] == "Lokal" ? "checked" : ""}  style="border : 0px white;"> <span style="font-weight : bold;border : 0px white;">Lokal</span> </td>
                      <td  style="border : 0px white;"><input type="checkbox"  ${dataFisikOperasi?.jenisAnestesi[2] == "Anestesi Umum" ? "checked" : ""} style="border : 0px white;"><span style="font-weight : bold;border : 0px white;">Anestesi Umum</span></td>
                    </tr>
                     <tr style="border : 0px white;">
                      <td  style="border : 0px white;"><input type="checkbox"  ${dataFisikOperasi?.jenisAnestesi[3] == "Sedasi" ? "checked" : ""} style="border : 0px white;"> <span style="font-weight : bold;border : 0px white;">Sedasi</span> </td>
                      <td  style="border : 0px white;"><input type="checkbox"  ${dataFisikOperasi?.jenisAnestesi[4] == "Anestesi Block" ? "checked" : ""} style="border : 0px white;"><span style="font-weight : bold;border : 0px white;">Anestesi Block</span></td>
                    </tr>
                  </table>
                </td> 
            </tr>
            <tr style=" border-top : 0px white;">
                <td class="container-medium container-border" colspan="2" style=" border-top : 0px white;"><span  style="font-weight : bold;">Indikasi Operasi</span>  :  ${dataFisikOperasi.indikasiOperasi}</td> 
                <td class="container-medium container-border" colspan="2" style=" border-top : 0px white;"><span  style="font-weight : bold; border-top : 0px white;">Lama Operasi Berlangsung </span> : ${dataFisikOperasi.lamaOperasi}</td> 
            </tr>
          </table>
        </tr>
         <tr>
          <table>
            <tr>
              <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Diagnosis Post Operasi</span> : <br/> ${dataFisikOperasi.diagnosisPostOperasi}</td>
              <td class="container-medium container-border" colspan="2" style="font-weight : bold; border-bottom : 0px white;"><span  style="font-weight : bold;">DPJP Anestesi : </span> ${dataFisikOperasi.dpjpAnestesi}</td>
            </tr>
            <tr>
                <td class="container-medium container-border" colspan="2" style=" border-top : 0px white;"><span  style="font-weight : bold;">Jenis Operasi </span>  :  ${dataFisikOperasi.jenisOperasi}</td> 
                <td class="container-medium container-border" colspan="2" style=" border-top : 0px white;"><span  style="font-weight : bold; border-top : 0px white;">Perawat Anestesi </span> : ${dataFisikOperasi.perawatAnestesi}</td> 
            </tr>
          </table>
        </tr>
         <tr>
          <table>
                    <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Anesthesi</span> : <br/> 
                    <table style="border : 0px white;">
                    <tr style="border : 0px white;">
                        <td style="border : 0px white;">
                            <input type="checkbox" ${dataFisikOperasi?.anesthesi[1] == "Retrobulbar" ? "checked" : ""} style="border : 0px white;"> 
                            <span style="font-weight : bold; border : 0px white;">Retrobulbar</span>
                        </td>
                        <td style="border : 0px white;">
                            <input type="checkbox" ${dataFisikOperasi?.anesthesi[2] == "Lidocain 2%" ? "checked" : ""} style="border : 0px white;">
                            <span style="font-weight : bold; border : 0px white;">Lidocain 2%</span>
                        </td>
                    </tr>
                    <tr style="border : 0px white;">
                        <td style="border : 0px white;">
                            <input type="checkbox" ${dataFisikOperasi?.anesthesi[3] == "Peribulber" ? "checked" : ""} style="border : 0px white;"> 
                            <span style="font-weight : bold; border : 0px white;">Peribulber</span>
                        </td>
                        <td style="border : 0px white;">
                            <input type="checkbox" ${dataFisikOperasi?.anesthesi[4] == "Marcain 0,5%" ? "checked" : ""} style="border : 0px white;">
                            <span style="font-weight : bold; border : 0px white;">Marcain 0,5%</span>
                        </td>
                    </tr>
                    <tr style="border : 0px white;">
                        <td style="border : 0px white;">
                            <input type="checkbox" ${dataFisikOperasi?.anesthesi[5] == "Topikal" ? "checked" : ""} style="border : 0px white;"> 
                            <span style="font-weight : bold; border : 0px white;">Topikal</span>
                        </td>
                        <td style="border : 0px white;">
                            <input type="checkbox" ${dataFisikOperasi?.anesthesi[6] == "Subtenon" ? "checked" : ""} style="border : 0px white;">
                            <span style="font-weight : bold; border : 0px white;">Subtenon</span>
                        </td>
                    </tr>
                    <tr style="border : 0px white;">
                        <td style="border : 0px white;">
                            <input type="checkbox" ${dataFisikOperasi?.anesthesi[7] == "NU" ? "checked" : ""} style="border : 0px white;"> 
                            <span style="font-weight : bold; border : 0px white;">NU</span>
                        </td>
                        <td style="border : 0px white;">
                            <input type="checkbox" ${dataFisikOperasi?.anesthesi[8] == "Lain-lain" ? "checked" : ""} style="border : 0px white;">
                            <span style="font-weight : bold; border : 0px white;">Lain-lain</span>
                        </td>
                    </tr>
                </table>
              </td>
            </tr>
          </table>
        </tr>
        <tr>
          <table>
                    <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Peritomi</span> : <br/> 
                   <table style="border : 0px white;">
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.peritomi[1] == "Basis Forniks" ? "checked" : ""} style="border : 0px white;"> 
                              <span style="font-weight : bold; border : 0px white;">Basis Forniks</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.peritomi[2] == "Basis Limbus" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Basis Limbus</span>
                          </td>
                      </tr>
                  </table>
              </td>
            </tr>
          </table>
        </tr>
        <tr>
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style=""><span  style="font-weight : bold;">Lokasi</span> : <br/> 
                      <table style="border : 0px white;">
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasi[1] == "Superonasal" ? "checked" : ""} style="border : 0px white;"> 
                                <span style="font-weight : bold; border : 0px white;">Superonasal</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasi[2] == "Superior" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Superior</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasi[3] == "Superotemporal" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Superotemporal</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasi[4] == "Temporal" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Temporal</span>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
            </table>
        </tr>
        <tr >
          <table class="page-break">
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Lokasi Insisi</span> : <br/> 
                      <table style="border : 0px white;">
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasiInsisi[1] == "Kornea" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Kornea</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasiInsisi[2] == "Limbus" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Limbus</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasiInsisi[3] == "Sklera" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Sklera</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasiInsisi[4] == "Skleraltunnel" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Skleraltunnel</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.lokasiInsisi[5] == "Side Port" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Side Port</span>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
            </table>
        </tr>
         <tr>
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Ukuran Insisi</span> : ${dataFisikOperasi?.ukuranInsisi}<br/> </tr>
              </tr>
            </table>
        </tr>
        <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Alat Insisi</span> : <br/> 
                     <table style="border : 0px white;">
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.alatInsisi[1] == "Jarum" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Jarum</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.alatInsisi[2] == "Crescent" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Crescent</span>
                          </td>
                      </tr>
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.alatInsisi[3] == "Diamond" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Diamond</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.alatInsisi[4] == "Keratome" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Keratome</span>
                          </td>
                      </tr>
                  </table>

                </td>
              </tr>
            </table>
        </tr>
         <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Capsulectomy Anterior</span> : <br/> 
                     <table style="border : 0px white;">
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.capsulectomyAnterior[1] == "Can Opener" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Can Opener</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.capsulectomyAnterior[2] == "Envelope" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Envelope</span>
                          </td>
                      </tr>
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.capsulectomyAnterior[3] == "CCC" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">CCC</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.capsulectomyAnterior[4] == "FLACS" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">FLACS</span>
                          </td>
                      </tr>
                  </table>

                </td>
              </tr>
          </table>
        </tr>
         <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Ekstrasksi Lensa</span> : <br/> 
                     <table style="border : 0px white;">
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.ekstraksiLensa[1] == "Phaco" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Phaco</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.ekstraksiLensa[2] == "ECCE" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">ECCE</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.ekstraksiLensa[3] == "AI" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">AI</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.ekstraksiLensa[4] == "SICE" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">SICE</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.ekstraksiLensa[5] == "RLE" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">RLE</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.ekstraksiLensa[6] == "ICCE" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">ICCE</span>
                            </td>
                        </tr>
                    </table>


                </td>
              </tr>
          </table>
        </tr>
         <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Tindakan Tambahan</span> : <br/> 
                      <table style="border : 0px white;">
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.tindakanTambahan[1] == "Sinechiolysis" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Sinechiolysis</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.tindakanTambahan[2] == "Jahitan Iris" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Jahitan Iris</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.tindakanTambahan[3] == "Vitrectomy Anterior" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Vitrectomy Anterior</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.tindakanTambahan[4] == "Kapsulotomi post" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Kapsulotomi post</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.tindakanTambahan[5] == "Sphincterectomy" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Sphincterectomy</span>
                            </td>
                        </tr>
                    </table>

                </td>
              </tr>
          </table>
        </tr>
         <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Cairan Irigasi</span> : <br/> 
                      <table style="border : 0px white;">
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.cairanIrigasi[1] == "R.L" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">R.L</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.cairanIrigasi[2] == "B.S.S" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">B.S.S</span>
                          </td>
                      </tr>
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.cairanIrigasi[3] == "Fiksasi Sklera" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Fiksasi Sklera</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.cairanIrigasi[4] == "Lain-lain" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Lain-lain</span>
                          </td>
                      </tr>
                  </table>
                </td>
              </tr>
          </table>
        </tr>
        <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Fiksasi LIO</span> : <br/> 
                     <table style="border : 0px white;">
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.fiksasiLIO[1] == "In the bag" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">In the bag</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.fiksasiLIO[2] == "B.M.D" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">B.M.D</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.fiksasiLIO[3] == "Sulkus Siliaris" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Sulkus Siliaris</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.fiksasiLIO[4] == "Afakia" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Afakia</span>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
          </table>
        </tr>
         <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style=""><span  style="font-weight : bold;">Penanaman</span> : <br/> 
                     <table style="border : 0px white;">
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.penanaman[1] == "Diputar" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Diputar</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.penanaman[2] == "Tidak Diputar" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Tidak Diputar</span>
                          </td>
                      </tr>
                  </table>
                </td>
              </tr>
          </table>
        </tr>
          <tr >
          <table>
                <tr class="page-break">
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Jenis LIO</span> : <br/> 
                     <table style="border : 0px white;">
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.jenisLIO[1] == "Dilipat" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Dilipat</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.jenisLIO[2] == "Tidak Dilipat" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Tidak Dilipat</span>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
          </table>
        </tr>
        <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Posisi LIO</span> : <br/> 
                     <table style="border : 0px white;">
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.posisiLIO[1] == "Vertikal" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Vertikal</span>
                          </td>
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.posisiLIO[2] == "Horizontal" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Horizontal</span>
                          </td>
                      </tr>
                      <tr style="border : 0px white;">
                          <td style="border : 0px white;">
                              <input type="checkbox" ${dataFisikOperasi?.posisiLIO[3] == "Miring" ? "checked" : ""} style="border : 0px white;">
                              <span style="font-weight : bold; border : 0px white;">Miring</span>
                          </td>
                      </tr>
                  </table>
                </td>
              </tr>
          </table>
        </tr>
         <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Cairan Viscoelastik</span> : <br/> 
                     <table style="border : 0px white;">
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.cairanViscoelastik[1] == "Healon" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Healon</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.cairanViscoelastik[2] == "Viscoat" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Viscoat</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.cairanViscoelastik[3] == "Amvisc" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Amvisc</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.cairanViscoelastik[4] == "Healon 5" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Healon 5</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.cairanViscoelastik[5] == "Rohtovisc" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Rohtovisc</span>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
          </table>
        </tr>
           <tr >
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Benang</span> : <br/> 
                     <table style="border : 0px white;">
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.benang[1] == "Vicryl 8-0" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Vicryl 8-0</span>
                            </td>
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.benang[2] == "Ethylon 10-0" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Ethylon 10-0</span>
                            </td>
                        </tr>
                        <tr style="border : 0px white;">
                            <td style="border : 0px white;">
                                <input type="checkbox" ${dataFisikOperasi?.benang[3] == "Jahitan" ? "checked" : ""} style="border : 0px white;">
                                <span style="font-weight : bold; border : 0px white;">Jahitan</span>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
          </table>
        </tr>
         <tr>
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">TIO Prabedah</span> : <span style="font-weight : bold">OD </span>${dataFisikOperasi?.TIOPraBedah['od']} mm  <span style="font-weight : bold">OS </span>${dataFisikOperasi?.TIOPraBedah['od']} mmHg<br/> </tr>
              </tr>
            </table>
        </tr>
        <tr>
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Perdarahan</span> :<span style="font-weight : bold;"></span> <input type="checkbox"  ${dataFisikOperasi.perdarahan[1] == "Tidak" ? "checked" : ""}> <span style="font-weight : bold">Tidak</span> <input type="checkbox"  ${dataFisikOperasi.perdarahan[2] == "Ada" ? "checked" : ""}><span style="font-weight : bold">Ada</span> <span style="font-weight : bold">  <br/>Jumlah Pendarahan</span> :  ${dataFisikOperasi?.perdarahan['jumlahPendarahan'] || ''}</td>
                </tr>
            </table>
        </tr>
        <tr>
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Komplikasi dan Penangananya</span> :<span style="font-weight : bold;"></span> <input type="checkbox"  ${dataFisikOperasi.komplikasi[1] == "Tidak" ? "checked" : ""}> <span style="font-weight : bold">Tidak</span> <input type="checkbox"  ${dataFisikOperasi.komplikasi[2] == "Ya" ? "checked" : ""}><span style="font-weight : bold">Ya</span> <span style="font-weight : bold">  <br/>Jika Ya </span> :  ${dataFisikOperasi?.komplikasi['jelaskan'] || ""}</td>
                </tr>
            </table>
        </tr>
        <tr>
          <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style="  border-bottom : 0px white;"><span  style="font-weight : bold;">Pemeriksaan PA</span> :<span style="font-weight : bold;"></span> <input type="checkbox"  ${dataFisikOperasi.pemeriksaanPA[1] == "Tidak" ? "checked" : ""}> <span style="font-weight : bold">Tidak</span> <input type="checkbox"  ${dataFisikOperasi.pemeriksaanPA[2] == "Ya" ? "checked" : ""}><span style="font-weight : bold">Ya</span> <span style="font-weight : bold">  <br/>Jenis specimen pemeriksaan  </span> :  ${dataFisikOperasi?.pemeriksaanPA['jenisSpesimen'] || ""}</td>
                </tr>
            </table>
        </tr>
       <tr>
        <table>
                <tr>
                      <td class="container-medium container-border" colspan="2" style=" height : 5em;"><span  style="font-weight : bold;">Intruksi Pasca Bedah </span> :<span style="font-weight : bold;"></span> ${dataFisikOperasi.instruksiPascaBedah }</td>
                </tr>
            </table>
        </tr>
        <tr>
          <table style="height : 5em; text-align : right;">
              <tr>
                  <td class="container" colspan="2" style="text-align: right; border-bottom : 0px white; border-top : 0px white; font-weight : bold;">Soreang, ${formattedDateTemp} Jam ${formattedTime}</td>
              </tr>
              <tr>
                 <td class="container" colspan="2" style="height : 7em; text-align: right; padding-top: 2%; border-top : 0px white; border-bottom : 0px white;  ">${riwayats[index].tte ? riwayats[index].tte : "" }</td>
              </tr
              <tr>
                 <td class="container" colspan="2" style="height : 7em; text-align: right; padding-top: 2%; border-top : 0px white;  "> ${dataFisikOperasi.dpjpBedah || ''}</td>
              </tr
          </table>
        </tr>
        
    </table>
</body>
</html>
        `;

        // Menampilkan laporan dalam modal
        document.getElementById('previewContent').innerHTML = laporanHTML;

        // Menampilkan modal
        $('#previewModal').modal('show');
    }

    // Fungsi untuk mencetak laporan
    function printLaporan() {
        let printContents = document.getElementById('previewContent').innerHTML;
        let originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        location.reload();
    }
        </script>
    @endsection
