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
<h1>Fisik</h1>
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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/edukasi/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        @include('emr.modules.addons.tabs')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          <br>

          <div class="col-md-12" style="padding-top: 20px">

            <table class='table table-striped table-bordered table-hover table-condensed' >
                <thead>
                  <tr>
                    <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                    <th class="text-center" style="vertical-align: middle;">User</th>
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
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                            {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                        </td>
                        {{-- @if ( $riwayat->id == request()->asessment_id )
                            <td style="text-align: center; background-color:rgb(172, 247, 162)">
                                {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                            </td>
                        @else
                            <td style="text-align: center;">
                                {{Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i')}}
                            </td>
                        @endif --}}
                       
                        <td style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : ''}}">
                          {{ baca_user(@$riwayat->user_id) }}
                            {{-- <a href="{{ URL::current() . '?asessment_id='. $riwayat->id }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> --}}
                            {{-- <a href="{{ url('tarif/') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> --}}
                        </td>
                    </tr>
                @endforeach
               
              </tbody>
            </table>
           
        </div>

          <div class="col-md-6">
            <h4><b>KEMAMPUAN DAN KEMAUAN EDUKASI</b></h4>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Agama</label>
                <td>
                    <input type="text" name="fisik[kemauan_edukasi][agama]" style="display:inline-block" class="form-control" id="" value="{{@$asessment['kemauan_edukasi']['agama']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Nilai-Nilai Yang Dianut</label>
                <td>
                    <input type="text" name="fisik[kemauan_edukasi][nilai_dianut]" style="display:inline-block" class="form-control" id="" value="{{@$asessment['kemauan_edukasi']['nilai_dianut']}}">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Pendidikan</label>
                <td>
                    <input type="text" name="fisik[kemauan_edukasi][pendidikan]" style="display:inline-block" class="form-control" id="" value="{{@$asessment['kemauan_edukasi']['pendidikan']}}">
                </td>
              </tr>

              <tr>
                <td rowspan="3" style="width:50%; font-weight:bold;">Konsultasi Komunikasi</td>
                <td>   
                  <input class="form-check-input"  name="fisik[konsultasi_komunikasi][tidak_ada]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[konsultasi_komunikasi][tidak_ada]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['konsultasi_komunikasi']['tidak_ada'] == 'Ya' ? 'checked' : ''}}>
                  Tidak Ada
                </td>
                <tr>
                  <td>   
                    <input class="form-check-input"  name="fisik[konsultasi_komunikasi][ada]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[konsultasi_komunikasi][ada]" type="checkbox" value="Ya" id="konsultasiKomunikasiId" onclick="konsultasiKomunikasi()" {{@$asessment['konsultasi_komunikasi']['ada'] == 'Ya' ? 'checked' : ''}}>
                    Ada
                  </td>
                </tr>
                <tr>
                  <td>   
                    <input style="display:inline-block;" type="hidden" name="fisik[konsultasi_komunikasi][jelaskan]" placeholder="Jelaskan" class="form-control" id="konsultasiKomunikasiText" value="{{@$asessment['konsultasi_komunikasi']['jelaskan'] == 'Ya' ? 'checked' : ''}}">
                  </td>
                </tr>
              </tr>

              <tr>
                <td rowspan="3" style="width:50%; font-weight:bold;">Bahasa Yang Dipakai</td>
                <td>   
                  <input class="form-check-input"  name="fisik[bahasa_dipakai][indonesia]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[bahasa_dipakai][indonesia]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['bahasa_dipakai']['indonesia'] == 'Ya' ? 'checked' : ''}}>
                  Indonesia
                </td>
                <tr>
                  <td>   
                    <input class="form-check-input"  name="fisik[bahasa_dipakai][mandarin_inggris]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[bahasa_dipakai][mandarin_inggris]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['bahasa_dipakai']['mandarin_inggris'] == 'Ya' ? 'checked' : ''}}>
                    Mandarin Inggris
                  </td>
                </tr>
                <tr>
                  <td>   
                    <input class="form-check-input"  name="fisik[bahasa_dipakai][lainnya]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[bahasa_dipakai][lainnya]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['bahasa_dipakai']['lainnya'] == 'Ya' ? 'checked' : ''}}>
                    Lainnya
                  </td>
                </tr>
              </tr>

              <tr>
                <td rowspan="3" style="width:50%; font-weight:bold;">Penerjemah</td>
                <td>   
                  <input class="form-check-input"  name="fisik[penerjemah][perlu]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[penerjemah][perlu]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['penerjemah']['perlu'] == 'Ya' ? 'checked' : ''}}>
                  Perlu
                </td>
                <tr>
                  <td>   
                    <input class="form-check-input"  name="fisik[penerjemah][tidak_perlu]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[penerjemah][tidak_perlu]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['penerjemah']['tidak_perlu'] == 'Ya' ? 'checked' : ''}}>
                    Tidak Perlu
                  </td>
                </tr>
                <tr>
                  <td>   
                    <input class="form-check-input"  name="fisik[penerjemah][lainnya]" type="hidden" value="-" id="flexCheckDefault">
                    <input class="form-check-input"  name="fisik[penerjemah][lainnya]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['penerjemah']['lainnya'] == 'Ya' ? 'checked' : ''}}>
                    Lainnya
                  </td>
                </tr>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">Hambatan Edukasi</td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][tidak_ada]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][tidak_ada]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['hambatan_edukasi']['tidak_ada'] == 'Ya' ? 'checked' : ''}}>
                  Tidak Ada 
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][gangguan_penglihatan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][gangguan_penglihatan]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['hambatan_edukasi']['gangguan_penglihatan'] == 'Ya' ? 'checked' : ''}}>
                  Gangguan Penglihatan
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][gangguan_proses_pikir]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][gangguan_proses_pikir]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['hambatan_edukasi']['gangguan_proses_pikir'] == 'Ya' ? 'checked' : ''}}>
                  Gangguan Proses Pikir
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][gangguan_pendengaran]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][gangguan_pendengaran]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['hambatan_edukasi']['gangguan_pendengaran'] == 'Ya' ? 'checked' : ''}}>
                  Gangguan Pendengaran
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][hambatan_bahasa]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][hambatan_bahasa]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['hambatan_edukasi']['hambatan_bahasa'] == 'Ya' ? 'checked' : ''}}>
                  Hambatan Bahasa
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][batasan_jasmani]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][batasan_jasmani]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['hambatan_edukasi']['batasan_jasmani'] == 'Ya' ? 'checked' : ''}}>
                  Batasan Jasmani dan Kognitif
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][gangguan_emosional]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][gangguan_emosional]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['hambatan_edukasi']['gangguan_emosional'] == 'Ya' ? 'checked' : ''}}>
                  Gangguan Emosional
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][kemampuan_membaca]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[hambatan_edukasi][kemampuan_membaca]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['hambatan_edukasi']['kemampuan_membaca'] == 'Ya' ? 'checked' : ''}}>
                  Kemampuan Membaca
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                  <label class="form-check-label" style="font-weight: normal;">Hambatan Lain</label>
                  <td>
                      <input type="text" name="fisik[hambatan_edukasi][lainnya]" style="display:inline-block" class="form-control" id="" value="{{@$asessment['hambatan_edukasi']['lainnya']}}">
                  </td>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <h4><b>KEBUTUHAN EDUKASI</b></h4>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">PROGRAM EDUKASI</td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][kondisi_medis]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][kondisi_medis]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['kondisi_medis'] == 'Ya' ? 'checked' : ''}}>
                  Kondisi Medis dan Diagnosa
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][rencana_perawatan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][rencana_perawatan]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['rencana_perawatan'] == 'Ya' ? 'checked' : ''}}>
                  Rencana Perawatan dan Pengobatan
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][perawatan_luka]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][perawatan_luka]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['perawatan_luka'] == 'Ya' ? 'checked' : ''}}>
                  Perawatan Luka
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][perawatan_lanjutan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][perawatan_lanjutan]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['perawatan_lanjutan'] == 'Ya' ? 'checked' : ''}}>
                  Perawatan Lanjutan Setelah Pasien Pulang
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][penggunaan_alat_medis]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][penggunaan_alat_medis]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['penggunaan_alat_medis'] == 'Ya' ? 'checked' : ''}}>
                  Penggunaan Alat Medis
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][manajemen_nyeri]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][manajemen_nyeri]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['manajemen_nyeri'] == 'Ya' ? 'checked' : ''}}>
                  Manajemen Nyeri
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][diet_nutrisi]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][diet_nutrisi]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['diet_nutrisi'] == 'Ya' ? 'checked' : ''}}>
                  Diet / Nyeri
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][penggunaan_obat]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][penggunaan_obat]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['penggunaan_obat'] == 'Ya' ? 'checked' : ''}}>
                  Penggunaan Obat
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][intraksi_obat]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][intraksi_obat]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['intraksi_obat'] == 'Ya' ? 'checked' : ''}}>
                  Intraksi Obat dan Makanan
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][teknis_rehab]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][teknis_rehab]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['teknisi_rehab'] == 'Ya' ? 'checked' : ''}}>
                  Teknis Rehabilitasi
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][pengisian_informed]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][pengisian_informed]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['pengisian_informed'] == 'Ya' ? 'checked' : ''}}>
                  Pengisian Informed Consent
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][teknik_cuciTangan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][teknik_cuciTangan]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['teknik_cuci_tangan'] == 'Ya' ? 'checked' : ''}}>
                  Teknik Cuci Tangan
                </td>
              </tr>
              <tr>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][perawatan_gigi]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][perawatan_gigi]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['perawatan_gigi'] == 'Ya' ? 'checked' : ''}}>
                  Perawatan Kesehatan Gigi
                </td>
                <td>   
                  <input class="form-check-input"  name="fisik[program_edukasi][pengawasan_kehamilan]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][pengawasan_kehamilan]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['pengawasan_kehamilan'] == 'Ya' ? 'checked' : ''}}>
                  Pengawasan Kehamilan
                </td>
              </tr>
              <tr>
                <td colspan="2">   
                  <input class="form-check-input"  name="fisik[program_edukasi][edukasi_lain]" type="hidden" value="-" id="flexCheckDefault">
                  <input class="form-check-input"  name="fisik[program_edukasi][edukasi_lain]" type="checkbox" value="Ya" id="flexCheckDefault" {{@$asessment['program_edukasi']['edukasi_lain'] == 'Ya' ? 'checked' : ''}}>
                  Edukasi Lainnya
                </td>
              </tr>

              <tr>
                <td style="width:50%; font-weight:bold;">SIAPA YANG EDUKASI</td>
                <td style="width:50%; font-weight:bold;">METODE EDUKASI</td>
              </tr>
              <tr>
                <td>
                  <input type="checkbox" id="pasien" name="fisik[siapa_edukasi][pasien]" value="pasien">
                  <label for="pasien" style="font-weight: normal;">Pasien</label><br>
                  <input type="checkbox" id="ayah-ibu" name="fisik[siapa_edukasi][ayahibu]" value="ayah-ibu">
                  <label for="ayah-ibu" style="font-weight: normal;">Ayah / Ibu</label><br>
                  <input type="checkbox" id="suami-istri" name="fisik[siapa_edukasi][suamiistri]" value="suami-istri">
                  <label for="suami-istri" style="font-weight: normal;">Suami / Istri</label><br>
                  <input type="checkbox" id="anak" name="fisik[siapa_edukasi][anak]" value="anak">
                  <label for="anak" style="font-weight: normal;">Anak</label><br>
                </td>
                <td>
                  <input type="radio" id="diskusi" name="fisik[metode_edukasi]" value="diskusi">
                  <label for="diskusi" style="font-weight: normal;">Diskusi</label><br>
                  <input type="radio" id="peragaan" name="fisik[metode_edukasi]" value="peragaan">
                  <label for="peragaan" style="font-weight: normal;">Peragaan</label><br>
                  <input type="radio" id="selebaran" name="fisik[metode_edukasi]" value="selebaran">
                  <label for="selebaran" style="font-weight: normal;">Selebaran</label><br>
                  <input type="radio" id="audio_visual" name="fisik[metode_edukasi]" value="audio_visual">
                  <label for="audio_visual" style="font-weight: normal;">Audio Visual</label><br>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">RESPON</td>
              </tr>
              <tr>
                <td>
                  <input type="radio" id="tidak_ada_respon" name="fisik[respon_edukasi]" value="tidak_ada_respon">
                  <label for="tidak_ada_respon" style="font-weight: normal;">1. Tidak Ada Respon Sama Sekali</label><br>
                  <input type="radio" id="tidak_paham" name="fisik[respon_edukasi]" value="tidak_paham">
                  <label for="tidak_paham" style="font-weight: normal;">2. Tidak Paham (Ingin Belajar Tapi Kesulitan Mengerti)</label><br>
                  <input type="radio" id="paham" name="fisik[respon_edukasi]" value="paham">
                  <label for="paham" style="font-weight: normal;">3. Paham Hal Yang Diajarkan, Tapi Tidak Bisa Menjelaskan Sendiri</label><br>
                </td>
                <td>
                  <input type="radio" id="dapat_menjelaskan_dibantu" name="fisik[respon_edukasi]" value="dapat_menjelaskan_dibantu">
                  <label for="dapat_menjelaskan_dibantu" style="font-weight: normal;">4. Dapat Menjelaskan Apa Yang Telah Diajarkan Tapi Harus Dibantu Edukator</label><br>
                  <input type="radio" id="dapat_menjelaskan" name="fisik[respon_edukasi]" value="dapat_menjelaskan">
                  <label for="dapat_menjelaskan" style="font-weight: normal;">5. Dapat Menjelaskan Apa Yang Telah Diajarkan Tanpa Dibantu</label><br>
                </td>
              </tr>

              <tr>
                <td colspan="2" style="width:50%; font-weight:bold;">CATATAN EDUKASI</td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Edukasi Yang Diberikan</label>
                <td>
                    <input type="text" name="fisik[catatan_edukasi][yang_diberikan]" style="display:inline-block" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Siapa Yang Diedukasi</label>
                <td>
                    <input type="text" name="fisik[catatan_edukasi][siapa_yang_diedukasi]" style="display:inline-block" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Tempat</label>
                <td>
                    <input type="text" name="fisik[catatan_edukasi][tempat]" style="display:inline-block" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Metode Edukasi</label>
                <td>
                    <input type="text" name="fisik[catatan_edukasi][metode]" style="display:inline-block" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Respon</label>
                <td>
                    <input type="text" name="fisik[catatan_edukasi][respon]" style="display:inline-block" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Nama Edukator</label>
                <td>
                    <input type="text" name="fisik[catatan_edukasi][nama_edukator]" style="display:inline-block" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Paraf Edukator</label>
                <td>
                    <input type="text" name="fisik[catatan_edukasi][paraf_edukator]" style="display:inline-block" class="form-control" id="">
                </td>
              </tr>
              <tr>
                <td style="padding: 5px;">
                <label class="form-check-label" style="font-weight: normal;">Bidang Disiplin</label>
                <td>
                    <input type="text" name="fisik[catatan_edukasi][bidang_disiplin]" style="display:inline-block" class="form-control" id="">
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

  @section('script')

  <script type="text/javascript">
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);  
         
  </script>
   <script>
    function diberikan() {
      var checkBox = document.getElementById("edukasiDiberikan");
      var text = document.getElementById("edukasiDiberikanText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicara() {
      var checkBox = document.getElementById("bicaraId");
      var text = document.getElementById("bicaraText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function bicaraSeharihari() {
      var checkBox = document.getElementById("bicaraSeharihariId");
      var text = document.getElementById("bicaraSeharihariText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    function alergi() {
      var checkBox = document.getElementById("alergiId");
      var text = document.getElementById("alergiText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function penyakitKeluarga() {
      var checkBox = document.getElementById("penyakitKeluargaId");
      var text = document.getElementById("penyakitKeluargaText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function alatBantu() {
      var checkBox = document.getElementById("alatBantuId");
      var text = document.getElementById("alatBantuText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function pendengaran() {
      var checkBox = document.getElementById("pendengaranId");
      var text = document.getElementById("pendengaranText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function penglihatan() {
      var checkBox = document.getElementById("penglihatanId");
      var text = document.getElementById("penglihatanText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function sputum() {
      var checkBox = document.getElementById("sputumId");
      var text = document.getElementById("sputumText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function edema() {
      var checkBox = document.getElementById("edemaId");
      var text = document.getElementById("edemaText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function babCair() {
      var checkBox = document.getElementById("babCairId");
      var text = document.getElementById("babCairText");
      var label = document.getElementById("babCairLabel");
      if (checkBox.checked == true){
        text.type = "text";
        label.style.display = "block";
      } else {
         text.type= "hidden";
         label.style.display = "none";
      }
    }

    function kateter() {
      var checkBox = document.getElementById("kateterId");
      var text = document.getElementById("kateterText");
      var label = document.getElementById("kateterLabel");
      if (checkBox.checked == true){
        text.type = "text";
        label.style.display = "block";
      } else {
         text.type= "hidden";
         label.style.display = "none";
      }
    }

    function lokasiLuka() {
      var checkBox = document.getElementById("lokasiLukaId");
      var text = document.getElementById("lokasiLukaText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
         label.style.display = "none";
      }
    }

    function totalResikoJatuhDewasa(){
      var arr = document.getElementsByClassName('resikoJatuhDewasa');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('totalResikoJatuhDewasaId').value = tot;
    }

    function totalResikoJatuhAnak(){
      var arr = document.getElementsByClassName('resikoJatuhAnak');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('totalResikoJatuhAnakId').value = tot;
    }

    function alasanCemas() {
      var checkBox = document.getElementById("alasanCemasId");
      var text = document.getElementById("alasanCemasText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function pengasuh() {
      var checkBox = document.getElementById("pengasuhId");
      var text = document.getElementById("pengasuhText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function tempramen() {
      var checkBox = document.getElementById("tempramenId");
      var text = document.getElementById("tempramenText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function perilakuUnik() {
      var checkBox = document.getElementById("perilakuUnikId");
      var text = document.getElementById("perilakuUnikText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function pernahJatuh() {
      var checkBox = document.getElementById("pernahJatuhId");
      var text = document.getElementById("pernahJatuhText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function nyeriGerak() {
      var checkBox = document.getElementById("nyeriGerakId");
      var text = document.getElementById("nyeriGerakText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }

    function konsultasiKomunikasi() {
      var checkBox = document.getElementById("konsultasiKomunikasiId");
      var text = document.getElementById("konsultasiKomunikasiText");
      if (checkBox.checked == true){
        text.type = "text";
      } else {
         text.type= "hidden";
      }
    }
    </script>
  @endsection