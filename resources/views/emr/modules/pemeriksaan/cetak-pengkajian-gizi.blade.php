<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
          margin-top: 0;
          /* margin-left: 0.3cm; */
      }
      .border {
        border: 1px solid black;
        border-collapse: collapse;
      }
    </style>

  </head>
  <body>
    @php
    libxml_use_internal_errors(true);
  @endphp
  <div class="col-md-12">
    <h5 class="text-center"><b>Pengkajian Gizi</b></h5>
    <div class="row">
        <h5><b>Antropometri</b></h5>
        <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                    <td colspan="2" style="width: 50%; font-weight: bold;">Dewasa</td>
                </tr>
                <tr>
                    <td>
                        BB Saat ini (Kg)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['dewasa']['bb_saat_ini']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        BB biasanya (Kg)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['dewasa']['bb_biasanya']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Penurunan BB (%)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['dewasa']['penurunan_bb']}}
                        <br>
                            Dalam (minggu/bulan)
                        <br>
                        {{@$assesment['pengkajian']['antropometri']['dewasa']['penurunan_bb_dalam']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Tinggi Badan (cm)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['dewasa']['tinggi_badan']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        LILA (cm)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['dewasa']['lila']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        IMT
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['dewasa']['imt']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Status Gizi
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['dewasa']['status_gizi']}}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                    <td colspan="2" style="width: 50%; font-weight: bold;">Anak</td>
                </tr>
                <tr>
                    <td>
                        BB Saat ini (Kg)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['anak']['bb_saat_ini']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        BB biasanya (Kg)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['anak']['bb_biasanya']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Penurunan BB (%)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['anak']['penurunan_bb']}}
                        <br>
                            Dalam (minggu/bulan)
                        <br>
                        {{@$assesment['pengkajian']['antropometri']['anak']['penurunan_bb_dalam']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Tinggi Badan (cm)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['anak']['tinggi_badan']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        LILA (cm)
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['anak']['lila']}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Standar Deviasi
                    </td>
                    <td>
                         BB / U
                        <br>
                        {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['1']}}
                        {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_1']}}
                        <br>
                         PB, TB / U
                        <br>
                        {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['2']}}
                        {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_2']}}
                        <br>
                         BB / PB , TB
                        <br>
                        {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['3']}}
                        {{@$assesment['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_3']}}
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Status Gizi
                    </td>
                    <td>
                        {{@$assesment['pengkajian']['antropometri']['anak']['status_gizi']}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-12">
            <h5><b>Bio Kimia Terkait Gizi</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                    <td colspan="2" style="width: 50%;">
                        <textarea rows="5" name="fisik[pengkajian][biokimia]" style="display:inline-block;" >{{@$assesment['pengkajian']['biokimia']}}</textarea>
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-12">
            <h5><b>Fisik Klinis Gizi</b></h5>
            <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box"
                style="font-size:12px;">
                <tr style="border: 1px solid black;">
                    <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                        Gangguan Nafsu Makan
                    </td>
                    <td style="border: 1px solid black; width: 10%;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gangguan_nafsu_makan]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_nafsu_makan']=='Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black; width: 10%;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gangguan_nafsu_makan]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_nafsu_makan']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                    <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                        Kembung
                    </td>
                    <td style="border: 1px solid black; width: 10%;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][kembung]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['kembung']=='Ya' ? 'checked' : '' }} type="radio"
                                value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black; width: 10%;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][kembung]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['kembung']=='Tidak' ? 'checked' : '' }} type="radio"
                                value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="font-weight: bold;border: 1px solid black;">
                        Mual
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][mual]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['mual']=='Ya' ? 'checked' : '' }} type="radio"
                                value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][mual]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['mual']=='Tidak' ? 'checked' : '' }} type="radio"
                                value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                    <td style="font-weight: bold;border: 1px solid black;">
                        Konstipasi
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][konstipasi]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['konstipasi']=='Ya' ? 'checked' : '' }} type="radio"
                                value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][konstipasi]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['konstipasi']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="font-weight: bold;border: 1px solid black;">
                        Muntah
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][muntah]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['muntah']=='Ya' ? 'checked' : '' }} type="radio"
                                value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][muntah]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['muntah']=='Tidak' ? 'checked' : '' }} type="radio"
                                value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                    <td style="font-weight: bold;border: 1px solid black;">
                        Kepala dan mata
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][kepala_dan_mata]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['kepala_dan_mata']=='Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][kepala_dan_mata]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['kepala_dan_mata']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="font-weight: bold;border: 1px solid black;">
                        Atropi otot lengan
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][antropi_otot_lengan]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['antropi_otot_lengan']=='Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][antropi_otot_lengan]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['antropi_otot_lengan']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                    <td style="font-weight: bold;border: 1px solid black;">
                        Diare
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gigi_geligi]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gigi_geligi']=='Ya' ? 'checked' : '' }} type="radio"
                                value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gigi_geligi]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gigi_geligi']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="font-weight: bold;border: 1px solid black;">
                        Hilang lemak subkutan
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][hilang_lemak_subkutan]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['hilang_lemak_subkutan']=='Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][hilang_lemak_subkutan]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['hilang_lemak_subkutan']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                    <td style="font-weight: bold;border: 1px solid black;">
                        Gangguan menelan
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gangguan_menelan]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_menelan']=='Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gangguan_menelan]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_menelan']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="font-weight: bold;border: 1px solid black;">
                        Gangguan mengunyah
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gangguan_mengunyah]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_mengunyah']=='Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gangguan_mengunyah]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_mengunyah']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                    <td style="font-weight: bold;border: 1px solid black;">
                        Gangguan menghisap
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gangguan_menghisap]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_menghisap']=='Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][gangguan_menghisap]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['gangguan_menghisap']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="font-weight: bold;border: 1px solid black;">
                        Sesak
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][sesak]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['sesak']=='Ya' ? 'checked' : '' }} type="radio"
                                value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][sesak]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['sesak']=='Tidak' ? 'checked' : '' }} type="radio"
                                value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                    <td style="font-weight: bold;border: 1px solid black;">
                        Stomatitis
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][stomatitis]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['stomatitis']=='Ya' ? 'checked' : '' }} type="radio"
                                value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                    </td>
                    <td style="border: 1px solid black;" class="text-center">
                        <div>
                            <input class="form-check-input" name="fisik[pengkajian][fisik_klinis_gizi][stomatitis]" {{
                                @$assesment['pengkajian']['fisik_klinis_gizi']['stomatitis']=='Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="font-weight: bold;border: 1px solid black;">
                        Lainnya
                    </td>
                    <td style="border: 1px solid black;" class="text-center" colspan="5">
                        <input type="text" name="fisik[pengkajian][fisik_klinis_gizi][lainnya]" class="form-control"
                            value="{{ @$assesment['pengkajian']['fisik_klinis_gizi']['lainnya'] }}">
                    </td>
                </tr>
            
                <tr>
                    <td colspan="6" style="width:50%; font-weight:bold;">Tanda Vital</td>
                </tr>
                <tr>
                    <td>
                        <label class="form-check-label" style="font-weight: normal;">Tekanan Darah (mmHG)</label><br />
                        {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['tekanan_darah'] ?? @$cppt_perawat->tekanan_darah}}
                    </td>
                    <td>
                        <label class="form-check-label" style="font-weight: normal;"> Suhu (°C)</label><br />{{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['suhu'] ?? @$cppt_perawat->suhu}}
                    </td>
                    <td>
                        <label class="form-check-label" style="font-weight: normal;">Nadi (x/menit)</label><br />
                        {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['nadi'] ?? @$cppt_perawat->nadi}}
                    </td>
                    <td>
                        <label class="form-check-label" style="font-weight: normal;">Respirasi (x/menit)</label><br />
                        {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['respirasi'] ?? @$cppt_perawat->frekuensi_nafas}}
                    </td>
                    <td colspan="2">
                        <label class="form-check-label" style="font-weight: normal;">Saturasi (x/menit)</label><br />
                        {{@$assesment['pengkajian']['fisik_klinis_gizi']['tanda_vital']['saturasi']}}
                    </td>
                </tr>
            </table>
            
        </div>

        <div class="col-md-12">
            <h5><b>Riwayat Diet</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                    <td style="width: 20%;">
                        Asupan Nutrisi RS
                    </td>
                    <td>
                        <input type="text" placeholder="Asupan Nutrisi RS" name="fisik[pengkajian][riwayat_diet][asupan_nutrisi_rs]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_rs']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;">
                        Asupan Nutrisi SMRS
                    </td>
                    <td>
                        <input type="text" placeholder="Asupan Nutrisi SMRS" name="fisik[pengkajian][riwayat_diet][asupan_nutrisi_smrs]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_smrs']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;">
                        Asupan Nutrisi Cairan
                    </td>
                    <td>
                        <input type="text" placeholder="Asupan Nutrisi Cairan" name="fisik[pengkajian][riwayat_diet][asupan_nutrisi_cairan]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['asupan_nutrisi_cairan']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;">
                        Pantangan makan
                    </td>
                    <td>
                        <input type="text" placeholder="Pantangan makan" name="fisik[pengkajian][riwayat_diet][pantangan_makan]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['pantangan_makan']}}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;">
                        Pengalaman diet sebelumnya
                    </td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pengkajian][riwayat_diet][pengalaman_diet]"
                                {{ @$assesment['pengkajian']['riwayat_diet']['pengalaman_diet'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pengkajian][riwayat_diet][pengalaman_diet]"
                                {{ @$assesment['pengkajian']['riwayat_diet']['pengalaman_diet'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;">
                        Riwayat konseling gizi
                    </td>
                    <td>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pengkajian][riwayat_diet][riwayat_konseling]"
                                {{ @$assesment['pengkajian']['riwayat_diet']['riwayat_konseling'] == 'Ya' ? 'checked' : '' }}
                                type="radio" value="Ya">
                            <label class="form-check-label" style="font-weight: 400;">Ya</label>
                        </div>
                        <div>
                            <input class="form-check-input"
                                name="fisik[pengkajian][riwayat_diet][riwayat_konseling]"
                                {{ @$assesment['pengkajian']['riwayat_diet']['riwayat_konseling'] == 'Tidak' ? 'checked' : '' }}
                                type="radio" value="Tidak">
                            <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;">
                        Alergi makanan
                    </td>
                    <td>
                        <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                                    Telur
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][telur]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['telur'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][telur]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['telur'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                <td style="font-weight: bold;border: 1px solid black; width: 30%;">
                                    Gluten/gandum
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][gluten]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['gluten'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][gluten]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['gluten'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Udang
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][udang]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['udang'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][udang]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['udang'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Susu sapi / produk olahan
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][susu_sapi]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['susu_sapi'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][susu_sapi]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['susu_sapi'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Ikan
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][ikan]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['ikan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][ikan]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['ikan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                                <td style="font-weight: bold;border: 1px solid black;">
                                    Kacang-kacangan
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][kacang_kacangan]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['kacang_kacangan'] == 'Ya' ? 'checked' : '' }}
                                            type="radio" value="Ya">
                                        <label class="form-check-label" style="font-weight: 400;">Ya</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[pengkajian][riwayat_diet][alergi_makanan][kacang_kacangan]"
                                            {{ @$assesment['pengkajian']['riwayat_diet']['alergi_makanan']['kacang_kacangan'] == 'Tidak' ? 'checked' : '' }}
                                            type="radio" value="Tidak">
                                        <label class="form-check-label" style="font-weight: 400;">Tidak</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;">
                        Alergi makanan lainnya
                    </td>
                    <td>
                        <input type="text" placeholder="Alergi makanan lainnya" name="fisik[pengkajian][riwayat_diet][alergi_makanan_lainnya]" style="display:inline-block;" class="form-control" value="{{@$assesment['pengkajian']['riwayat_diet']['alergi_makanan_lainnya']}}">
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-12">
            <h4 style="text-align: center; padding: 10px"><b>DIAGNOSA GIZI</b></h4>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                    <td colspan="2" style="width: 50%;">
                        {{@$assesment['diagnosa_gizi']}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-12">
            <h4 style="text-align: center; padding: 10px"><b>INTERVENSI GIZI</b></h4>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                    <td style="width: 20%;">
                        Tujuan
                    </td>
                    <td>
                        <input type="text" placeholder="Tujuan" name="fisik[intervensi_gizi][tujuan]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['tujuan']}}">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 20%;">
                        Preskrisi Diet
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="font-weight: bold;">a. Bentuk <br/>makanan</td>
                    <td>
                        <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                                        name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                                        {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'MC' ? 'checked' : '' }}
                                                        type="radio" value="MC">
                                            {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'MC' ? 'checked' : '' }}
                                        <label class="form-check-label" style="font-weight: 400;">MC</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                            {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'BR' ? 'checked' : '' }}
                                            type="radio" value="BR">
                                        <label class="form-check-label" style="font-weight: 400;">BR</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                            {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Sippy' ? 'checked' : '' }}
                                            type="radio" value="Sippy">
                                        <label class="form-check-label" style="font-weight: 400;">Sippy</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div style="display: flex; vertical-align:middle">
                                        <input style="margin: 0" class="form-check-input"
                                            name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                            {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Lainnya' ? 'checked' : '' }}
                                            type="radio" value="Lainnya">
                                        <label class="form-check-label" style="font-weight: 400; margin: 0 1rem 0 0;">Lainnya</label>
                                        <input type="text" placeholder="Isi jika Lainnya" name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan_lain]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan_lain']}}">
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                            {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Makanan saring (TD I) ' ? 'checked' : '' }}
                                            type="radio" value="Makanan saring (TD I) ">
                                        <label class="form-check-label" style="font-weight: 400;">Makanan saring (TD I) </label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                            {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Makanan lunak (TD II)' ? 'checked' : '' }}
                                            type="radio" value="Makanan lunak (TD II)">
                                        <label class="form-check-label" style="font-weight: 400;">Makanan lunak (TD II)</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                            {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Makanan lunak (TD III)' ? 'checked' : '' }}
                                            type="radio" value="Makanan lunak (TD III)">
                                        <label class="form-check-label" style="font-weight: 400;">Makanan lunak (TD III)</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid black; width: 10%;" class="text-center">
                                    <div>
                                        <input class="form-check-input"
                                            name="fisik[intervensi_gizi][preskripsi_diet][bentuk_makanan]"
                                            {{ @$assesment['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] == 'Makanan biasa (TD IV)  ' ? 'checked' : '' }}
                                            type="radio" value="Makanan biasa (TD IV)  ">
                                        <label class="form-check-label" style="font-weight: 400;">Makanan biasa (TD IV)  </label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 20%;">b. Jenis diet</td>
                    <td>
                        <select name="fisik[intervensi_gizi][preskripsi_diet][jenis_diet]" class="form-control select2" id="" style="width: 100%;" onchange="showJenisDietLain(this)">
                            
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Diet Jantung (DJ)' ? 'selected' : '' }} value="Diet Jantung (DJ)">Diet Jantung (DJ)</option>
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Rendah Serat (RS)' ? 'selected' : '' }} value="Rendah Serat (RS)">Rendah Serat (RS)</option>
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Diet Hati (DH)' ? 'selected' : '' }} value="Diet Hati (DH)">Diet Hati (DH)</option>
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Diet Diabetes Mellitus (DM)' ? 'selected' : '' }} value="Diet Diabetes Mellitus (DM)">Diet Diabetes Mellitus (DM)</option>
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Tinggi Kalori Tinggi Protein (TKTP)' ? 'selected' : '' }} value="Tinggi Kalori Tinggi Protein (TKTP)">Tinggi Kalori Tinggi Protein (TKTP)</option>
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Diet Lambung (DL)' ? 'selected' : '' }} value="Diet Lambung (DL)">Diet Lambung (DL)</option>
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Rendah Protein (R.PROT)' ? 'selected' : '' }} value="Rendah Protein (R.PROT)">Rendah Protein (R.PROT)</option>
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Rendah Lemak (RL)' ? 'selected' : '' }} value="Rendah Lemak (RL)">Rendah Lemak (RL)</option>
                            <option {{ @$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Lainnya' ? 'selected' : '' }} value="Lainnya">Lainnya</option>
                          </select>
                          <div id="jenis_diet_lainnya" @if(@$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet'] != 'Lainnya')style="display: none;"@endif>
                              <input type="text" class="form-control" name="fisik[intervensi_gizi][preskripsi_diet][jenis_diet_lainnya]" placeholder="Isi jika jenis diet 'Lainnya'" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet_lainnya']}}">
                          </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 20%;">c. Frekuensi</td>
                    <td>
                        <input type="text" placeholder="Frekuensi" name="fisik[intervensi_gizi][preskripsi_diet][frekuensi]" style="display:inline-block;" class="form-control" value="{{@$assesment['intervensi_gizi']['preskripsi_diet']['frekuensi']}}">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 20%;">d. Rute</td>
                    <td>
                        <select name="fisik[intervensi_gizi][preskripsi_diet][rute][]" class="form-control select2" multiple id="" style="width: 100%;">
                            @if (@in_array("Oral", @$assesment['intervensi_gizi']['preskripsi_diet']['rute']))
                                <option selected value="Oral">Oral</option>
                            @else
                                <option value="Oral">Oral</option>
                            @endif
                            @if (@in_array("NGT", @$assesment['intervensi_gizi']['preskripsi_diet']['rute']))
                                <option selected value="NGT">NGT</option>
                            @else
                                <option value="NGT">NGT</option>
                            @endif
                            @if (@in_array("Panteral", @$assesment['intervensi_gizi']['preskripsi_diet']['rute']))
                                <option selected value="Panteral">Panteral</option>
                            @else
                                <option value="Panteral">Panteral</option>
                            @endif
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 20%;">e. Kebutuhan</td>
                    <td>
                        Energi :  {{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['energi']}}
                        <br>
                        Protein : {{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['protein']}}
                        <br>
                        Lemak : {{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['lemak']}}
                        <br>
                        Karbohidrat : {{@$assesment['intervensi_gizi']['preskripsi_diet']['kebutuhan']['karbohidrat']}}
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 20%;">f. Edukasi</td>
                    <td>
                        {{@$assesment['intervensi_gizi']['preskripsi_diet']['edukasi']}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-12">
            <h4 style="text-align: center; padding: 10px"><b>MONITORING DAN EVALUASI</b></h4>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                <tr>
                    <td colspan="2" style="width: 50%;">
                        {{@$assesment['monitoring_dan_evaluasi']}}
                    </td>
                </tr>
            </table>
        </div>
    </div>

</form>
<br />

</div>
  </div>
  </body>
</html>