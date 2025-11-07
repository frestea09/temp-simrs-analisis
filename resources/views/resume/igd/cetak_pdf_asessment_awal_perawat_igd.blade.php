<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asesmen Gawat Darurat</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 15px;
            /* text-align: left; */
        }
        input, label {
            vertical-align: middle !important;
        }
        @page {
            padding-bottom: .3cm;
        }

        .footer {
          position: fixed; 
          bottom: 0cm; 
          left: 0cm; 
          right: 0cm;
          height: 1cm;
          text-align: justify;
        }
    </style>
</head>

<body>
    @if (isset($cetak_tte))
        <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
        </div>
    @endif
    <table>
        <tr>
            <th colspan="1">
                <img src="{{ public_path('images/' . configrs()->logo) }}"style="width: 60px;">
            </th>
            <th colspan="5" style="font-size: 18pt;">
                <b>ASESMEN GAWAT DARURAT</b>
            </th>
        </tr>
        <tr>
            <td colspan="6">
                Tanggal Pemeriksaan : {{ date('d-m-Y', strtotime(@$pemeriksaan->created_at)) }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Nama Pasien</b><br>
                {{ $reg->pasien->nama }}
            </td>
            <td colspan="2">
                <b>Tgl. Lahir</b><br>
                {{ !empty($reg->pasien->tgllahir) ? hitung_umur($reg->pasien->tgllahir) : null }}
            </td>
            <td>
                <b>Jenis Kelamin</b><br>
                {{ $reg->pasien->kelamin }}
            </td>
            <td>
                <b>No MR.</b><br>
                {{ $reg->pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <b>Alamat Lengkap</b><br>
                {{ $reg->pasien->alamat }}
            </td>
            <td>
                <b>No Telp</b><br>
                {{ $reg->pasien->nohp }}
            </td>
        </tr>
        <tr>
            <td>
                <b>Keluhan Utama</b>
            </td>
            <td colspan="5">
                {{@$asessment['keluhan_utama']}}
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5 style="margin-top: -5px">Asesmen Keperawatan - Airway</h5>

                <table class="table-striped table-bordered table-hover table-condensed form-box table" style="width: 100%; font-size: 12px; border: none;">
                    <tr style="border: none;">
                        <td style="padding: 0; margin: 0;border: none;">
                            <div style="display: inline-block;">
                                <input class="form-check-input" name="asessment[airwaybersih]"
                                    {{ @$asessment['airwaybersih'] == 'Bersih' ? 'checked' : '' }} type="checkbox"
                                    value="Bersih">
                                <label class="form-check-label">Bersih</label>
                            </div>
                            <div style="display: inline-block;">
                                <input class="form-check-input" name="asessment[airwayspontan]"
                                    {{ @$asessment['airwayspontan'] == 'Spontan' ? 'checked' : '' }} type="checkbox"
                                    value="Spontan">
                                <label class="form-check-label">Spontan</label>
                            </div>
                            <div style="display: inline-block;">
                                <input class="form-check-input" name="asessment[airwaydispnoe]"
                                    {{ @$asessment['airwaydispnoe'] == 'Dispnoe' ? 'checked' : '' }} type="checkbox"
                                    value="Dispnoe">
                                <label class="form-check-label">Dispnoe</label>
                            </div>
                            <div style="display: inline-block;">
                                <input class="form-check-input" name="asessment[airwaytechnipnoe]"
                                    {{ @$asessment['airwaytechnipnoe'] == 'Techipnoe' ? 'checked' : '' }} type="checkbox"
                                    value="Techipnoe">
                                <label class="form-check-label">Techipnoe</label>
                            </div>
                            <div style="display: inline-block;">
                                <input class="form-check-input" name="asessment[airwayapnoe]"
                                    {{ @$asessment['airwayapnoe'] == 'Apnoe' ? 'checked' : '' }} type="checkbox"
                                    value="Apnoe">
                                <label class="form-check-label">Apnoe</label>
                            </div>
                            <div style="display: inline-block;">
                                <input class="form-check-input" name="asessment[airwayslem]"
                                    {{ @$asessment['airwayslem'] == 'Slem' ? 'checked' : '' }} type="checkbox"
                                    value="Slem">
                                <label class="form-check-label">Slem</label>
                            </div>
                            <div style="display: inline-block;">
                                <input class="form-check-input" name="asessment[airwayobstruksi]"
                                    {{ @$asessment['airwayobstruksi'] == 'Obstruksi' ? 'checked' : '' }} type="checkbox"
                                    value="Obstruksi">
                                <label class="form-check-label">Obstruksi</label>
                            </div>
                            <div>
                                {{ @$asessment['airwaydll'] }}
                            </div>
                        </td>
                    </tr>
                </table>

                <h5>Diagnosa Keperawatan - Airway</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="">
                    <tr style="border: none;">
                        <td>{{@$asessment['diagnosa_keperawatan']['airway']}} </td>
                    </tr>
                </table>

                <h5>Intervensi - Airway</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['intervensi_keperawatan']['airway'])
                        @foreach (@$asessment['intervensi_keperawatan']['airway'] as $intervensi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$intervensi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>

                <h5>Implementasi - Airway</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['implementasi_keperawatan']['airway'])
                        @foreach (@$asessment['implementasi_keperawatan']['airway'] as $implementasi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$implementasi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5 style="margin-top: -5px">Asesmen Keperawatan - Breathing</h5>
                <table style="width: 100%; font-size: 12px; border: none;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr style="border: none;">
                        <td rowspan="6">Asesmen Keperawatan - Breathing</td>
                        <td>Pola Napas</td>
                        <td colspan="2">
                                {{ @$asessment['breathingfrekuensi']}}
                        </td>
                    </tr>

                    <tr style="border: none;">
                        <td rowspan="2">Bunyi Napas</td>
                        <td>
                            <input type="hidden" name="asessment[breathingVesikuler]" value="-">
                            <input type="checkbox" name="asessment[breathingVesikuler]" value="vesikuler" {{ @$asessment['breathingVesikuler'] == 'vesikuler' ? 'checked' : '' }}>
                            Vesikuler
                        </td>
                        <td>
                            <input type="hidden" name="asessment[breathingwheezing]" value="-">
                            <input type="checkbox" name="asessment[breathingwheezing]" value="wheezing" {{ @$asessment['breathingwheezing'] == 'wheezing' ? 'checked' : '' }}>
                            wheezing
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td colspan="2">
                            <input type="hidden" name="asessment[breathingronchi]" value="-">
                            <input type="checkbox" name="asessment[breathingronchi]" value="ronchi" {{ @$asessment['breathingronchi'] == 'ronchi' ? 'checked' : '' }}>
                            Ronchi
                        </td>
                    </tr>

                    <tr style="border: none;">
                        <td rowspan="2">Tanda Distress Pernapasan</td>
                        <td>
                            <input type="hidden" name="asessment[breathingtanda_distressototbantu]"
                                value="-">
                            <input type="checkbox" name="asessment[breathingtanda_distressototbantu]"
                                value="Ya" {{ @$asessment['breathingtanda_distressototbantu'] == 'Ya' ? 'checked' : '' }}>
                            Penggunaan otot bantu
                        </td>
                        <td>
                            <input type="hidden" name="asessment[breathingtanda_distressretraksi]"
                                value="-">
                            <input type="checkbox" name="asessment[breathingtanda_distressretraksi]"
                                value="Ya" {{ @$asessment['breathingtanda_distressretraksi'] == 'Ya' ? 'checked' : '' }}>
                            Retraksi dada/inter costa
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td colspan="2">
                            <input type="hidden" name="asessment[breathingtanda_distresscuping]" value="-">
                            <input type="checkbox" name="asessment[breathingtanda_distresscuping]"
                                value="Ya" {{ @$asessment['breathingtanda_distresscuping'] == 'Ya' ? 'checked' : '' }}>
                            Cuping hidung
                        </td>
                    </tr>

                    <tr style="border: none;">
                        <td>Jenis Pernapasan</td>
                        <td>
                            <input type="hidden" name="asessment[breathingjenis_napasdada]" value="-">
                            <input type="checkbox" name="asessment[breathingjenis_napasdada]"
                                value="Pernapasan dada" {{ @$asessment['breathingjenis_napasdada'] == 'Pernapasan dada' ? 'checked' : '' }}>
                            Pernapasan dada
                        </td>
                        <td>
                            <input type="hidden" name="asessment[breathingjenis_napasperut]" value="-">
                            <input type="checkbox" name="asessment[breathingjenis_napasperut]"
                                value="pernapasan perut" {{ @$asessment['breathingjenis_napasperut'] == 'pernapasan perut' ? 'checked' : '' }}>
                            Pernapasan perut
                        </td>
                    </tr>
                </table>

                <h5>Diagnosa Keperawatan - Breathing</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="">
                    <tr style="border: none;">
                        <td>{{@$asessment['diagnosa_keperawatan']['breathing']}} </td>
                    </tr>
                </table>

                <h5>Intervensi - Breathing</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['intervensi_keperawatan']['breathing'])
                        @foreach (@$asessment['intervensi_keperawatan']['breathing'] as $intervensi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$intervensi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>

                <h5>Implementasi - Breathing</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['implementasi_keperawatan']['breathing'])
                        @foreach (@$asessment['implementasi_keperawatan']['breathing'] as $implementasi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$implementasi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>

            </td>
        </tr>
        
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5>Asesmen Keperawatan - Circulation</h5>

                <table style="width: 100%; font-size: 12px; border: none;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td rowspan="2">Akral</td>
                        <td>
                            <input type="hidden" name="asessment[circulationakralhangat]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationakralhangat'] == 'Hangat' ? 'checked' : '' }} name="asessment[circulationakralhangat]" value="Hangat">
                            Hangat
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationakraldingin]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationakraldingin'] == 'Dingin' ? 'checked' : '' }} name="asessment[circulationakraldingin]" value="Dingin">
                            Dingin
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="asessment[circulationakraloedema]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationakraloedema'] == 'Oedema' ? 'checked' : '' }} name="asessment[circulationakraloedema]" value="Oedema">
                            Oedema
                        </td>
                    </tr>

                    <tr>
                        <td>Pucat</td>
                        <td>
                            <input type="hidden" name="asessment[circulationpucatya]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationpucatya'] == 'Ya' ? 'checked' : '' }} name="asessment[circulationpucatya]" value="Ya">
                            Ya
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationpucattidak]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationpucattidak'] == 'Tidak' ? 'checked' : '' }} name="asessment[circulationpucattidak]" value="Tidak">
                            Tidak
                        </td>
                    </tr>

                    <tr>
                        <td>Sianosis</td>
                        <td>
                            <input type="hidden" name="asessment[circulationsianosisya]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationsianosisya'] == 'Ya' ? 'checked' : '' }} name="asessment[circulationsianosisya]" value="Ya">
                            Ya
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationsianosistidak]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationsianosistidak'] == 'Tidak' ? 'checked' : '' }} name="asessment[circulationsianosistidak]" value="Tidak">
                            Tidak
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">Nadi</td>
                        <td colspan="2">
                                {{@$asessment['circulationfrekuensi']}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="asessment[circulationnaditeraba]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationnaditeraba'] == 'Teraba' ? 'checked' : '' }} name="asessment[circulationnaditeraba]" value="Teraba">
                            Teraba
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationnadiTteraba]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationnadiTteraba'] == 'Tidak teraba' ? 'checked' : '' }} name="asessment[circulationnadiTteraba]" value="Tidak teraba">
                            Tidak Teraba
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">Irama :</td>
                        <td>
                            <input type="hidden" name="asessment[circulationiramareguler]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationiramareguler'] == 'Reguler' ? 'checked' : '' }} name="asessment[circulationiramareguler]" value="Reguler">
                            Reguler
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationiramaireguler]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationiramaireguler'] == 'Ireguler' ? 'checked' : '' }} name="asessment[circulationiramaireguler]" value="Ireguler">
                            Ireguler
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="asessment[circulationiramakuat]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationiramakuat'] == 'Kuat' ? 'checked' : '' }} name="asessment[circulationiramakuat]" value="Kuat">
                            Kuat
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationiramalemah]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationiramalemah'] == 'Lemah' ? 'checked' : '' }} name="asessment[circulationiramalemah]" value="Lemah">
                            Lemah
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5>Asesmen Keperawatan - Circulation</h5>

                <table style="width: 100%; font-size: 12px; border: none;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td>Tekanan Darah</td>
                        <td colspan="2">
                                {{@$asessment['circulationtekanandarah']}}
                        </td>
                    </tr>

                    <tr>
                        <td>Suhu Badan</td>
                        <td colspan="2">
                                {{@$asessment['circulationsuhubadan']}}
                        </td>
                    </tr>

                    <tr>
                        <td>Perdarahan</td>
                        <td colspan="2">
                                {{@$asessment['circulationperdarahan']}}
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">Luka Bakar</td>
                        <td>Grade</td>
                        <td>
                                {{@$asessment['circulationlukabakargrade']}}
                        </td>
                    </tr>
                    <tr>
                        <td>Luas</td>
                        <td>
                                {{@$asessment['circulationlukabakarluas']}}
                        </td>
                    </tr>

                    <tr>
                        <td>Mual</td>
                        <td>
                            <input type="hidden" name="asessment[circulationmualya]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationmualya'] == 'Ya' ? 'checked' : '' }} name="asessment[circulationmualya]" value="Ya">
                            Ya
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationmualtidak]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationmualtidak'] == 'Tidak' ? 'checked' : '' }} name="asessment[circulationmualtidak]" value="Tidak">
                            Tidak
                        </td>
                    </tr>

                    <tr>
                        <td>Muntah</td>
                        <td>
                            <input type="hidden" name="asessment[circulationmuntahya]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationmuntahya'] == 'Ya' ? 'checked' : '' }} name="asessment[circulationmuntahya]" value="Ya">
                            Ya
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationmuntahtidak]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationmuntahtidak'] == 'Tidak' ? 'checked' : '' }} name="asessment[circulationmuntahtidak]" value="Tidak">
                            Tidak
                        </td>
                    </tr>

                    <tr>
                        <td>Pengisian Kapiler(CRT)</td>
                        <td>
                            <input type="hidden" name="asessment[circulationcrt_<2]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationcrt_<2'] == '<2' ? 'checked' : '' }} name="asessment[circulationcrt_<20]" value="<2">
                            &lt; 2
                        </td>
                        <td>
                            <input type="hidden" name="asessment[circulationcrt_>2]" value="-">
                            <input type="checkbox" {{ @$asessment['circulationcrt_>2'] == '>2' ? 'checked' : '' }} name="asessment[circulationcrt_>2]" value=">2">
                            > 2
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5>Diagnosa Keperawatan - Circulation</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="">
                    <tr style="border: none;">
                        <td>{{@$asessment['diagnosa_keperawatan']['circulation']}} </td>
                    </tr>
                </table>

                <h5>Intervensi - Circulation</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['intervensi_keperawatan']['circulation'])
                        @foreach (@$asessment['intervensi_keperawatan']['circulation'] as $intervensi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$intervensi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>

                <h5>Implementasi - Circulation</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['implementasi_keperawatan']['circulation'])
                        @foreach (@$asessment['implementasi_keperawatan']['circulation'] as $implementasi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$implementasi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5><b>Asesmen Keperawatan - Disability</b></h5>
                <table style="width: 100%; font-size: 12px; border: none;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td rowspan="2">Kesadaran :</td>
                        <td>
                            <input type="hidden" name="asessment[disabilitykesadarancm]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitykesadarancm'] == 'CM' ? 'checked' : '' }} name="asessment[disabilitykesadarancm]" value="CM">
                            CM (15)
                        </td>
                        <td>
                            <input type="hidden" name="asessment[disabilitykesadaransomnolen]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitykesadaransomnolen'] == 'Somnolen' ? 'checked' : '' }} name="asessment[disabilitykesadaransomnolen]"
                                value="Somnolen">
                            Somnolen (12-14)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="asessment[disabilitykesadaransopor]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitykesadaransopor'] == 'Sopor' ? 'checked' : '' }} name="asessment[disabilitykesadaransopor]" value="Sopor">
                            Sopor (9-11)
                        </td>
                        <td>
                            <input type="hidden" name="asessment[disabilitykesadarankoma]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitykesadarankoma'] == 'Koma' ? 'checked' : '' }} name="asessment[disabilitykesadarankoma]" value="Koma">
                            Koma (3-8)
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">Nilai GCS :</td>
                        <td>E :</td>
                        <td>
                                {{@$asessment['disabilitycgse']}}
                        </td>
                    </tr>
                    <tr>
                        <td>M :</td>
                        <td>
                                {{@$asessment['disabilitycgsm']}}

                        </td>
                    </tr>
                    <tr>
                        <td>V :</td>
                        <td>
                                {{@$asessment['disabilitycgsv']}}

                        </td>
                    </tr>
                    <tr>
                        <td>Total GCS :</td>
                        <td colspan="2">
                            {{@$asessment['disabilitycgstotal']}}

                        </td>
                    </tr>
                    <tr>
                        <td>Reflek Cahaya :</td>
                        <td>
                            <input type="hidden" name="asessment[disabilityreflekada]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilityreflekada'] == 'Ada' ? 'checked' : '' }} name="asessment[disabilityreflekada]" value="Ada">
                            Ada
                        </td>
                        <td>
                            <input type="hidden" name="asessment[disabilityreflektidakada]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilityreflektidakada'] == 'Tidak ada' ? 'checked' : '' }} name="asessment[disabilityreflektidakada]" value="Tidak ada">
                            Tidak Ada
                        </td>
                    </tr>
                    <tr>
                        <td>Diameter Pupil :</td>
                        <td colspan="2">
                                {{@$asessment['disabilitytxt']}}

                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4">Ekstremitas :</td>
                        <td rowspan="2">Motorik :</td>
                        <td>
                            <input type="hidden" name="asessment[disabilitymotorikya]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitymotorikya'] == 'Ya' ? 'checked' : '' }} name="asessment[disabilitymotorikya]" value="Ya">
                            Ya
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="asessment[disabilitymotoriktidak]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitymotoriktidak'] == 'Tidak' ? 'checked' : '' }} name="asessment[disabilitymotoriktidak]" value="Tidak">
                            Tidak
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">Sensorik :</td>
                        <td>
                            <input type="hidden" name="asessment[disabilitysensorikya]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitysensorikya'] == 'Ya' ? 'checked' : '' }} name="asessment[disabilitysensorikya]" value="Ya">
                            Ya
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="asessment[disabilitysensoriktidak]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitysensoriktidak'] == 'Tidak' ? 'checked' : '' }} name="asessment[disabilitysensoriktidak]" value="Tidak">
                            Tidak
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5><b>Asesmen Keperawatan - Disability</b></h5>
                <table style="width: 100%; font-size: 12px; border: none;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td>Kekuatan Otot :</td>
                        <td colspan="2">
                            <input type="text" class="form-control" name="asessment[disabilityotot]"
                                value="" >
                        </td>
                    </tr>
                    <tr>
                        <td>Kejang :</td>
                        <td>
                            <input type="hidden" name="asessment[disabilitykejangya]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitykejangya'] == 'Ya' ? 'checked' : '' }} name="asessment[disabilitykejangya]" value="Ya">
                            Ya
                        </td>
                        <td>
                            <input type="hidden" name="asessment[disabilitykejangtidak]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitykejangtidak'] == 'Ya' ? 'checked' : '' }} name="asessment[disabilitykejangtidak]" value="Ya">
                            Tidak
                        </td>
                    </tr>
                    <tr>
                        <td>Trismus :</td>
                        <td>
                            <input type="hidden" name="asessment[disabilitytrismusya]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitytrismusya'] == 'Ya' ? 'checked' : '' }} name="asessment[disabilitytrismusya]" value="Ya">
                            Ya
                        </td>
                        <td>
                            <input type="hidden" name="asessment[disabilitytrismustidak]" value="-">
                            <input type="checkbox" {{ @$asessment['disabilitytrismustidak'] == 'Tidak' ? 'checked' : '' }} name="asessment[disabilitytrismustidak]" value="Tidak">
                            Tidak
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5>Diagnosa Keperawatan - Disability</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="">
                    <tr style="border: none;">
                        <td>{{@$asessment['diagnosa_keperawatan']['disability']}} </td>
                    </tr>
                </table>

                <h5>Intervensi - Disability</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['intervensi_keperawatan']['disability'])
                        @foreach (@$asessment['intervensi_keperawatan']['disability'] as $intervensi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$intervensi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>

                <h5>Implementasi - Disability</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['implementasi_keperawatan']['disability'])
                        @foreach (@$asessment['implementasi_keperawatan']['disability'] as $implementasi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$implementasi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5><b>Asesmen Keperawatan - Eksposure</b></h5>
                <table style="width: 100%; font-size: 12px; border: none;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td>
                            Adanya trauma / luka
                        </td>
                        <td>
                            <label for="trauma_1">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][isTrauma]" id="trauma_1" value="Tidak" {{ @$asessment['eksposure']['asesmen']['trauma']['isTrauma'] == 'Tidak' ? 'checked' : '' }}>
                                Tidak
                            </label>
                            <label for="trauma_2">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][isTrauma]" id="trauma_2" value="Ya" {{ @$asessment['eksposure']['asesmen']['trauma']['isTrauma'] == 'Ya' ? 'checked' : '' }}>
                                Ya
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="pilihan_1">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_1" value="Laceratum" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Laceratum' ? 'checked' : '' }}>
                                Laceratum
                            </label><br>
                            <label for="pilihan_2">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_2" value="Ekskoriasi" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Ekskoriasi' ? 'checked' : '' }}>
                                Ekskoriasi
                            </label><br>
                            <label for="pilihan_3">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_3" value="Hematoma" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Hematoma' ? 'checked' : '' }}>
                                Hematoma
                            </label><br>
                            <label for="pilihan_4">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_4" value="Contusio" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Contusio' ? 'checked' : '' }}>
                                Contusio
                            </label><br>
                            <label for="pilihan_5">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_5" value="Auto Amputasi" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Auto Amputasi' ? 'checked' : '' }}>
                                Auto Amputasi
                            </label>
                        </td>
                        <td>
                            <label for="pilihan_6">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_6" value="Fraktur" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Fraktur' ? 'checked' : '' }}>
                                Fraktur
                            </label><br>
                            <label for="pilihan_7">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_7" value="Dislokasi" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Dislokasi' ? 'checked' : '' }}>
                                Dislokasi
                            </label><br>
                            <label for="pilihan_8">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_8" value="Morsum" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Morsum' ? 'checked' : '' }}>
                                Morsum
                            </label><br>
                            <label for="pilihan_9">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_9" value="Punctum" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Punctum' ? 'checked' : '' }}>
                                Punctum
                            </label><br>
                            <label for="pilihan_10">
                                <input type="radio" name="asessment[eksposure][asesmen][trauma][pilihan]" id="pilihan_10" value="Apulsi" {{ @$asessment['eksposure']['asesmen']['trauma']['pilihan'] == 'Apulsi' ? 'checked' : '' }}>
                                Apulsi
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" class="form-control" name="asessment[eksposure][asesmen][trauma][lainnya]" placeholder="Lainnya" value="{{ @$asessment['eksposure']['asesmen']['trauma']['lainnya'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Adanya Nyeri
                        </td>
                        <td>
                            <label for="adaNyeri_1">
                                <input type="radio" name="asessment[eksposure][asesmen][nyeri][pilihan]" id="adaNyeri_1" value="Tidak" {{ @$asessment['eksposure']['asesmen']['nyeri']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                                Tidak
                            </label>
                            <label for="adaNyeri_2">
                                <input type="radio" name="asessment[eksposure][asesmen][nyeri][pilihan]" id="adaNyeri_2" value="Ya" {{ @$asessment['eksposure']['asesmen']['nyeri']['pilihan'] == 'Ya' ? 'checked' : '' }}>
                                Ya
                            </label>
                            <br>
                            <input type="text" class="form-control" name="asessment[eksposure][asesmen][nyeri][lokasi]" placeholder="Lokasi" value="{{ @$asessment['eksposure']['asesmen']['nyeri']['lokasi'] }}">
                        </td>
                    </tr>
                </table>

                <h5>Diagnosa Keperawatan - Eksposure</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="">
                    <tr style="border: none;">
                        <td>{{@$asessment['diagnosa_keperawatan']['eksposure']}} </td>
                    </tr>
                </table>

                <h5>Intervensi - Eksposure</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['intervensi_keperawatan']['eksposure'])
                        @foreach (@$asessment['intervensi_keperawatan']['eksposure'] as $intervensi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$intervensi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>

                <h5>Implementasi - Eksposure</h5>
                <table style="width: 100%; font-size: 12px; border: none;" class="table-striped table-bordered table-hover table-condensed form-box table" >
                    @if (@$asessment['implementasi_keperawatan']['eksposure'])
                        @foreach (@$asessment['implementasi_keperawatan']['eksposure'] as $implementasi_keperawatan)
                            <tr style="border: none;">
                                <td>- {{$implementasi_keperawatan}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <h5><b>Tindakan Keperawatan / Kebidanan</b></h5>
                <table style="width: 100%; font-size: 12px; border: none;"
                    class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td>{{ @$asessment['tindakan_keperawatan_kebidanan'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table-striped table-bordered table-hover table-condensed form-box table">
                    <tr>
                        <td style="width:20%;">Risiko Cidera / Jatuh :</td>
                        <td colspan="2" style="padding: 5px;">

                            <input type="radio" value="Tidak" name="asessment[asesmen_nyeri][cidera]" {{ @$asessment['asesmen_nyeri']['cidera'] == 'Tidak' ? 'checked' : '' }}> Tidak
                            <input type="radio" value="Ya" name="asessment[asesmen_nyeri][cidera]" {{ @$asessment['asesmen_nyeri']['cidera'] == 'Ya' ? 'checked' : '' }}> Ya
                            <br>
                            <small>Bila ya isi form monitoring pencegahan pasien jatuh dan pasang gelang warna kuning</small>
                        </td>
                    </tr>
                    <tr>
                        <td>Aktifitas dan mobilisasi</td>
                        <td colspan="2">
                            <label >
                                <input type="radio" name="asessment[aktifitasMobilisasi][pilihan]" class="form-check-input" value="Mandiri" {{ @$asessment['aktifitasMobilisasi']['pilihan'] == 'Mandiri' ? 'checked' : '' }}>
                                Mandiri
                            </label>
                            <label for="aktifitasMobilisasi2">
                                <input type="radio" name="asessment[aktifitasMobilisasi][pilihan]" class="form-check-input" value="Perlu Bantuan" {{ @$asessment['aktifitasMobilisasi']['pilihan'] == 'Perlu Bantuan' ? 'checked' : '' }}>
                                Perlu Bantuan
                            </label>
                            <label for="aktifitasMobilisasi3">
                                <input type="radio" name="asessment[aktifitasMobilisasi][pilihan]" class="form-check-input" value="Alat Bantu Jalan" {{ @$asessment['aktifitasMobilisasi']['pilihan'] == 'Alat Bantu Jalan' ? 'checked' : '' }}>
                                Alat Bantu Jalan
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="7" style="width:20%;">Asesmen Nyeri</td>
                        <td>
                            <label for="nyeri1">
                                <input type="radio" name="asessment[asesmen_nyeri][pilihan]" class="form-check-input" value="Tidak" {{@$asessment['asesmen_nyeri']['pilihan'] == "Tidak" ? "checked" : ""}}>
                                Tidak
                            </label>
                        </td>
                        <td>
                            <label for="nyeri2">
                                <input type="radio" name="asessment[asesmen_nyeri][pilihan]" class="form-check-input" value="Ya" {{@$asessment['asesmen_nyeri']['pilihan'] == "Ya" ? "checked" : ""}}>
                                Ya
                            </label>
                        </td>
                        
                    <tr>
                        <td style="padding: 5px;">
                            <label class="form-check-label">
                                Provokatif
                            </label>
                        </td>
                        <td>
                            <label for="provokatif1">
                                <input type="radio" name="asessment[asesmen_nyeri][provokatif][pilihan]" class="form-check-input" value="Benturan" {{@$asessment['asesmen_nyeri']['provokatif']['pilihan'] == "Benturan" ? "checked" : ""}}>
                                Benturan
                            </label>
                            <label for="provokatif2">
                                <input type="radio" name="asessment[asesmen_nyeri][provokatif][pilihan]" class="form-check-input" value="Spontan" {{@$asessment['asesmen_nyeri']['provokatif']['pilihan'] == "Spontan" ? "checked" : ""}}>
                                Spontan
                            </label>
                                {{@$asessment['asesmen_nyeri']['provokatif']['sebutkan']}}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">
                            <label class="form-check-label">Quality</label>
                        </td>
                        <td>
                            <label for="quality1" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" class="form-check-input" {{@$asessment['asesmen_nyeri']['quality']['pilihan'] == "Seperti Tertusuk Benda Tajam / Tumpul" ? "checked" : ""}} value="Seperti Tertusuk Benda Tajam / Tumpul">
                                Seperti Tertusuk Benda Tajam / Tumpul
                            </label>
                            <label for="quality2" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" class="form-check-input" {{@$asessment['asesmen_nyeri']['quality']['pilihan'] == "Berdenyut" ? "checked" : ""}} value="Berdenyut">
                                Berdenyut
                            </label>
                            <label for="quality3" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" class="form-check-input" {{@$asessment['asesmen_nyeri']['quality']['pilihan'] == "Terbakar" ? "checked" : ""}} value="Terbakar">
                                Terbakar
                            </label>
                            <label for="quality4" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" class="form-check-input" {{@$asessment['asesmen_nyeri']['quality']['pilihan'] == "Terpelintir" ? "checked" : ""}} value="Terpelintir">
                                Terpelintir
                            </label>
                            <label for="quality5" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" class="form-check-input" {{@$asessment['asesmen_nyeri']['quality']['pilihan'] == "Tertindih Benda Berat" ? "checked" : ""}} value="Tertindih Benda Berat">
                                Tertindih Benda Berat
                            </label>
                            <label for="quality6" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][quality][pilihan]" class="form-check-input" {{@$asessment['asesmen_nyeri']['quality']['pilihan'] == "Lain - Lain" ? "checked" : ""}} value="Lain - Lain">
                                Lain - Lain
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">
                            <label class="form-check-label">Region</label>
                        </td>
                        <td>
                            {{@$asessment['asesmen_nyeri']['region']['lokasi']}}
                            <br>
                            <span>Menyebar : </span>
                            <br>
                            <label for="region1" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][region][pilihan]" {{@$asessment['asesmen_nyeri']['region']['pilihan'] == "Tidak" ? "checked" : ""}} class="form-check-input" value="Tidak">
                                Tidak
                            </label>
                            <label for="region2" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][region][pilihan]" {{@$asessment['asesmen_nyeri']['region']['pilihan'] == "Ya" ? "checked" : ""}} class="form-check-input" value="Ya">
                                Ya
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">
                            <label class="form-check-label">Severity</label>
                        </td>
                        <td>
                            <label for="severity1" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][severity][pilihan]" {{@$asessment['asesmen_nyeri']['severity']['pilihan'] == "Wong Baker Face" ? "checked" : ""}} class="form-check-input" value="Wong Baker Face">
                                Wong Baker Face
                            </label>
                            <label for="severity2" style="margin-right: 10px;">
                                <input type="radio" name="asessment[asesmen_nyeri][severity][pilihan]" {{@$asessment['asesmen_nyeri']['severity']['pilihan'] == "FLACCS" ? "checked" : ""}} class="form-check-input" value="FLACCS">
                                FLACCS
                            </label>
                            <br>
                            {{@$asessment['asesmen_nyeri']['severity']['skor']}}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;">
                            <label class="form-check-label">Time (Durasi)</label>
                        </td>
                        <td>
                                {{@$asessment['asesmen_nyeri']['time']}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <b>ASSESMEN AWAL PERAWAT</b>
            </td>
            <td colspan="5">
                <table style="width: 100%; font-size:12px;" class="table-striped table-bordered table-hover table-condensed form-box table">
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Nyeri Hilang Jika</label>
                            </td>
                            <td colspan="2">
                                <label for="nyeriHilang1">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" {{@$asessment['asesmen_nyeri']['nyeriHilang']['pilihan'] == "Minum Obat" ? "checked" : ""}} class="form-check-input" value="Minum Obat">
                                    Minum Obat
                                </label>
                                <label for="nyeriHilang2">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" {{@$asessment['asesmen_nyeri']['nyeriHilang']['pilihan'] == "Istirahat" ? "checked" : ""}} class="form-check-input" value="Istirahat">
                                    Istirahat
                                </label>
                                <label for="nyeriHilang3">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" {{@$asessment['asesmen_nyeri']['nyeriHilang']['pilihan'] == "Berubah Posisi" ? "checked" : ""}} class="form-check-input" value="Berubah Posisi">
                                    Berubah Posisi
                                </label>
                                <label for="nyeriHilang4">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" {{@$asessment['asesmen_nyeri']['nyeriHilang']['pilihan'] == "Mendengar Musik" ? "checked" : ""}} class="form-check-input" value="Mendengar Musik">
                                    Mendengar Musik
                                </label>
                                <label for="nyeriHilang5">
                                    <input type="radio" name="asessment[asesmen_nyeri][nyeriHilang][pilihan]" {{@$asessment['asesmen_nyeri']['nyeriHilang']['pilihan'] == "Lain - Lain" ? "checked" : ""}} class="form-check-input" value="Lain - Lain">
                                    Lain - Lain
                                </label>
                                    {{@$asessment['asesmen_nyeri']['nyeriHilang']['detail']}}
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="5" style="width:2Tidak%;">Kesadaran</td>
                            <td colspan="2" style="padding: 5px;">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][compos_mentis]"
                                        type="hidden" value="Tidak">
                                    <input class="form-check-input" name="asessment[kesadaran][compos_mentis]"
                                        type="checkbox" {{@$asessment['kesadaran']['compos_mentis'] == "Ya" ? "checked" : ""}} value="Ya">
                                    Compos Mentis
                                </label>
                            </td>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][apatis]" type="hidden"
                                        value="Tidak">
                                    <input class="form-check-input" name="asessment[kesadaran][apatis]" type="checkbox" {{@$asessment['kesadaran']['apatis'] == "Ya" ? "checked" : ""}}
                                        value="Ya">
                                    Apatis
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][somnolen]" type="hidden"
                                        value="Tidak">
                                    <input class="form-check-input" name="asessment[kesadaran][somnolen]"
                                        type="checkbox" value="Ya" {{@$asessment['kesadaran']['somnolen'] == "Ya" ? "checked" : ""}}>
                                    Somnolen
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][sopor]" type="hidden"
                                        value="Tidak">
                                    <input class="form-check-input" name="asessment[kesadaran][sopor]" type="checkbox"
                                        value="Ya" {{@$asessment['kesadaran']['sopor'] == "Ya" ? "checked" : ""}}>
                                    Sopor
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <input class="form-check-input" name="asessment[kesadaran][coma]" type="hidden"
                                        value="Tidak">
                                    <input class="form-check-input" name="asessment[kesadaran][coma]" type="checkbox"
                                        value="Ya" {{@$asessment['kesadaran']['coma'] == "Ya" ? "checked" : ""}}>
                                    Coma
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="7" style="width:20%;">Tanda Vital</td>
                            <td style="padding: 5px;" colspan="2"></td>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Tekanan Darah (mmHG)</label>
                            </td>
                            <td>
                                {{ @$asessment['tanda_vital']['tekanan_darah'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Nadi (x/menit)</label>
                            </td>
                            <td>
                                {{ @$asessment['tanda_vital']['nadi'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">Frekuensi Nafas (x/menit)</label>
                            </td>
                            <td>
                                {{ @$asessment['tanda_vital']['frekuensi_nafas'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label"> Suhu (°C)</label>
                            </td>
                            <td>
                                {{ @$asessment['tanda_vital']['suhu'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label"> SpO2</label>
                            </td>
                            <td>
                                {{ @$asessment['tanda_vital']['spo2'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <label class="form-check-label">BB (kg)</label>
                            </td>
                            <td>
                                {{ @$asessment['tanda_vital']['BB'] }}
                            </td>
                        </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td >
                <b>ASUHAN KEPERAWATAN</b>
            </td>
            <td colspan="5">
                @foreach (@$askep as $item)
                  @php
                    $diagnosa     = json_decode($item->diagnosis, true);
                    $implementasi = json_decode($item->fungsional, true);
                    $siki         = json_decode($item->pemeriksaandalam, true);
                  @endphp
                  @if (!empty($diagnosa))
                  - Diagnosa <br>
                    <ul>
                      @foreach ($diagnosa as $d)
                        <li>{{$d}}</li>
                      @endforeach
                    </ul>
                  @endif
                  @if (!empty($siki))
                  - Intervensi <br>
                    <ul>
                      @foreach ($siki as $s)
                        <li>{{$s}}</li>
                      @endforeach
                    </ul>
                  @endif
                  @if (!empty($implementasi))
                  - Implementasi <br>
                    <ul>
                        @foreach ($implementasi as $i)
                          <li>{{$i}}</li>
                        @endforeach
                    </ul>
                  @endif
                @endforeach
            </td>
        </tr>
    </table>
    <table style="border: 0px;">
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">
    
            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                  Perawat
            </td>
        </tr>
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                @if (isset($cetak_tte))
                <span style="margin-left: 1rem;">
                    #
                </span>
                    <br>
                    <br>
                @elseif (isset($tte_nonaktif))
                    @php
                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' | ' . Auth::user()->pegawai->nip))
                    @endphp
                    <img src="data:image/png;base64, {!! $base64 !!} ">
                @endif
            </td>
        </tr>
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
        </tr>
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px;">

            </td>
            <td colspan="3" style="text-align: center; border: 0px;">
                    {{ baca_user($soap->user_id) }}
            </td>
        </tr>
    </table>

</body>

</html>
