 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ @$reg->no_sep }}_{{ @$reg->pasien->nama }}</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
    <style>
      body{
        font-family: sans-serif;
        font-size: 10pt;
        
      }
      th{
        text-align: left;
      }
      .page_break_after{
        page-break-after: always;
      }
      .tableResume{
        width: 100%;
      }
      .borderResume{ /* table, th, td */
        border: 1px solid black;
        border-collapse: collapse;
      }
      .borderTriage th,.borderTriage tr,.borderTriage td{ /* table, th, td */
        border: 1px solid black;
        border-collapse: collapse;
      }
      .paddingResume{ /* th, td */
        padding: 15px;
      }

      hr.dot {
        border-top: 1px solid black;
      }
      .dotTop{
        border-top:1px dotted black
      }
    </style>
  </head>
  <body>
        <div style="">
          <table class="" style="width:100%;" border="1" cellspacing="0">
            <tr>
                <th colspan="1">
                    <img src="{{ public_path('images/' . configrs()->logo) }}"style="width: 60px;">
                </th>
                <th colspan="4" style="font-size: 18pt; border: 0px solid rgb(255, 255, 255);">
                    <b>TRIAGE</b>
                </th>
                <th colspan="1" style="border: 0px solid rgb(255, 255, 255);">
                    @php
                        $triage = json_decode(json_encode($asessment), true);

                        switch (@$triage['triage']['kesimpulan']) {
                            case 'Emergency ATS I':
                                $style = "rgb(255, 106, 106)";
                                break;
                            case 'Urgent ATS II & III':;
                                $style = "rgb(255, 238, 110)";
                                break;
                            case 'Non Urgent ATS IV & V':
                                $style = "rgb(166, 255, 110)";
                                break;
                            case 'Meninggal':
                                $style = "rgb(169, 169, 169)";
                                break;
                            
                            default:
                                $style = "transparent";
                                break;
                        }
                    @endphp
                    <div style="width: 100%; height: 60px; background-color: {{$style}};">
                    </div>
                </th>
            </tr>
            <tr>
                <td colspan="6">
                    Tanggal Pemeriksaan : {{ date('d-m-Y', strtotime(@$reg->created_at)) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Nama Pasien</b><br>
                    {{ $reg->pasien->nama }}
                </td>
                <td colspan="2">
                    <b>Tgl. Lahir</b><br>
                    {{ !empty($reg->pasien->tgllahir) ? hitung_umur_by_tanggal($reg->pasien->tgllahir, $reg->created_at) : null }}
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
                    {{ $reg->pasien->alamat .', '. @$reg->pasien->kelurahan->name .', '. @$reg->pasien->kecamatan->name .', '. @$reg->pasien->kabupaten->name .', '. @$reg->pasien->provinsi->name }}
                </td>
                <td>
                    <b>No Telp</b><br>
                    {{ $reg->pasien->nohp }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>TRIAGE</b>
                </td>
                <td colspan="5">
                    <ul>
                        <li><strong>Kontak awal dengan pasien :</strong>
                            {{ @$asessment->kontakAwal ? date('d-m-Y H:i', strtotime(@$asessment->kontakAwal)) : '' }}</li>
                        <li><strong>Cara Masuk :</strong> {{ @$asessment->caraMasuk }}</li>
                        <li><strong>Sudah Terpasang :</strong> {{ @$asessment->sudahTerpasang }}</li>
                        <li><strong>Alasan Kedatangan :</strong> {{ @$asessment->sebabDatang->sebab }}
                            ({{ @$asessment->sebabDatang->ket }})</li>
                        <li><strong>Kendaraan :</strong> {{ @$asessment->kendaraan }}</li>
                        <li><strong>Identitas Pengantar :</strong> Nama: {{ @$asessment->namaPengantar }} (Tepl.
                            {{ @$asessment->telpPengantar }}) </li>
                        <li><strong>Kasus :</strong> {{ @$asessment->kasus }}</li>
                        @if (@$asessment->kasus == 'Trauma')
                            <li><strong>Mekanisme Trauma :</strong>
                                <ul>
                                    @if (@$asessment->trauma->kllTunggal->ada == 'true')
                                        <li>
                                            <strong>KLL Tunggal </strong> {{ @$asessment->trauma->kllTunggal->subject }} di
                                            {{ @$asessment->trauma->kllTunggal->lokasi }} pada
                                            {{ @$asessment->trauma->kllTunggal->waktu ? date('d-m-Y H:i', strtotime(@$asessment->trauma->kllTunggal->waktu)) : '' }}
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->kll->ada == 'true')
                                        <li>
                                            <strong>KLL </strong> antara {{ @$asessment->trauma->kll->subject1 }} dengan
                                            {{ @$asessment->trauma->kll->subject2 }} di
                                            {{ @$asessment->trauma->kll->lokasi }}
                                            pada
                                            {{ @$asessment->trauma->kll->waktu ? date('d-m-Y H:i', strtotime(@$asessment->trauma->kll->waktu)) : '' }}
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->jatuh->ada == 'true')
                                        <li>
                                            <strong>Trauma Jatuh dari ketinggian </strong>
                                            ({{ @$asessment->trauma->jatuh->ket }})
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->lukaBakar->ada == 'true')
                                        <li>
                                            <strong>Trauma Luka Bakar </strong> ({{ @$asessment->trauma->lukaBakar->ket }})
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->listrik->ada == 'true')
                                        <li>
                                            <strong>Trauma Listrik </strong> ({{ @$asessment->trauma->listrik->ket }})
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->kimia->ada == 'true')
                                        <li>
                                            <strong>Trauma Zat Kimia </strong> ({{ @$asessment->trauma->kimia->ket }})
                                        </li>
                                    @endif
                                    @if (@$asessment->trauma->dll->ada == 'true')
                                        <li>
                                            <strong>Trauma Lainnya </strong> ({{ @$asessment->trauma->dll->ket }})
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        <li><strong>Keluhan Utama :</strong> {{ @$asessment->keluhanUtama->ket }}</li>
                        <li><strong>Alergi :</strong> {{ @$asessment->alergi->ket }}</li>
                        <li>
                            <strong>Tanda Vital : </strong> <br/>
                            TD : {{@$asessment_awal['igdAwal']['tandaVital']['tekananDarah'] ?? @$asessment_awal_ponek['tanda_vital']['tekanan_darah']}} mmHg<br/>
                            Frekuensi Nadi : {{@$asessment_awal['igdAwal']['tandaVital']['frekuensiNadi'] ?? @$asessment_awal_ponek['tanda_vital']['nadi']}} x/Menit<br/>
                            Suhu : {{@$asessment_awal['igdAwal']['tandaVital']['suhu'] ?? @$asessment_awal_ponek['tanda_vital']['suhu']}} &deg;C<br/>
                            RR : {{@$asessment_awal['igdAwal']['tandaVital']['RR'] ?? @$asessment_awal_ponek['tanda_vital']['frekuensi_nafas']}} x/Menit<br/>
                            SPO2 : {{@$asessment_awal['igdAwal']['tandaVital']['spo2'] ?? @$asessment_awal_ponek['tanda_vital']['SPO2']}} spo2<br/>
                            {{-- BB : {{@$asessment_awal['igdAwal']['tandaVital']['BB']}} Kg<br/> --}}
                        </li>
                        <li><strong>Skala Nyeri :</strong> {{ @$asessment_awal['igdAwal']['skalaNyeri'] }}</li>
                        @php
                            $asessment = json_decode(json_encode($asessment), true);
                        @endphp
                        <li><strong>Catatan Khusus :</strong> {{ @$asessment['triage']['catatan'] }}</li>
                    </ul>


                </td>
            </tr>
            <tr>
                <td colspan="6">
                    @php
                        $asessment = json_decode(json_encode($asessment), true);
                    @endphp
                    <style>
                        .red {
                            background-color: rgb(255, 106, 106);
                        }

                        .yellow {
                            background-color: rgb(255, 238, 110);
                        }

                        .green {
                            background-color: rgb(166, 255, 110);
                        }
                    </style>
                    <table style="width: 100%;font-size:12px;" border="1" cellspacing="0">
                        <tr>
                            <td colspan="6" style="font-weight: 900; text-align:center; padding-top:10px;">
                                TRIAGE
                            </td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td></td>
                            <td class="red">ATS I SEGERA</td>
                            <td class="yellow">ATS II 10 MENIT</td>
                            <td class="yellow">ATS III 30 MENIT</td>
                            <td class="green">ATS IV 60 MENIT</td>
                            <td class="green">ATS V 120 MENIT</td>
                        </tr>
                        <tr>
                            <td>Jalan Nafas</td>
                            <td class="red">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['obstruksi'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Obstruksi / Parsial Obstruksi</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['paten']['yellow1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Paten</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['paten']['yellow2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Paten</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['paten']['green1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Paten</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['jalanNafas']['paten']['green2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Paten</label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Pernafasan</td>
                            <td class="red">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['nafasBerat'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Distress nafas berat</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['hentiNafas'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Henti Nafas</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['hivoventilasi'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Hivoventilasi</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['nafasSedang'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Distress nafas sedang</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['nafasRingan'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Distress nafas ringan</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['noDistress']['green1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Tidak ada distress nafas</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['pernafasan']['noDistress']['green2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Tidak ada distress nafas</label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Sirkulasi</td>
                            <td class="red">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['hemodinamikBerat'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Gangguan hemodinamik berat</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['hentiJantung'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Henti Jantung</label>
                                </div>
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['pendarahTakTerkontrol'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Pendarah tak terkontrol</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['hemodinamikSedang'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Gangguan hemodinamik sedang</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['hemodinamikRingan'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Gangguan hemodinamik ringan</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['sirkulasi']['noGangguan']['green1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Tidak ada gangguan sirkulasi</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input" name="asessment[triage][sirkulasi][noGangguan]"
                                        {{ @$asessment['triage']['sirkulasi']['noGangguan']['green2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Tidak ada gangguan sirkulasi</label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>GCS</td>
                            <td class="red">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['<9'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">GCS &lt; 9 </label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['9-12'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">GCS 9-12</label>
                                </div>
                            </td>
                            <td class="yellow">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['>12'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">GCS >12</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['normalGCS']['green1'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Normal GCS</label>
                                </div>
                            </td>
                            <td class="green">
                                <div>
                                    <input class="form-check-input"
                                        {{ @$asessment['triage']['GCS']['normalGCS']['green2'] == 'true' ? 'checked' : '' }}
                                        type="checkbox" value="true">
                                    <label class="form-check-label">Normal GCS</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kesimpulan
                            </td>
                            <td colspan="5">
                                @if (@$asessment['triage']['kesimpulan'] == 'Emergency ATS I')
                                    <div class="red" style="display: inline-block; padding: 10px">
                                        <input class="form-check-input"
                                            {{ @$asessment['triage']['kesimpulan'] == 'Emergency ATS I' ? 'checked' : '' }}
                                            type="checkbox">
                                        <label class="form-check-label">Emergency ATS I</label>
                                    </div>
                                @endif
                                @if (@$asessment['triage']['kesimpulan'] == 'Urgent ATS II & III')
                                    <div class="yellow" style="display: inline-block; padding: 10px">
                                        <input class="form-check-input"
                                            {{ @$asessment['triage']['kesimpulan'] == 'Urgent ATS II & III' ? 'checked' : '' }}
                                            type="checkbox">
                                        <label class="form-check-label">Urgent ATS II dan III</label>
                                    </div>
                                @endif
                                @if (@$asessment['triage']['kesimpulan'] == 'Non Urgent ATS IV & V')
                                    <div class="green" style="display: inline-block; padding: 10px">
                                        <input class="form-check-input"
                                            {{ @$asessment['triage']['kesimpulan'] == 'Non Urgent ATS IV & V' ? 'checked' : '' }}
                                            type="checkbox">
                                        <label class="form-check-label">Non Urgent ATS IV dan V</label>
                                    </div>
                                @endif
                                @if (@$asessment['triage']['kesimpulan'] == 'Meninggal')
                                    <div style="display: inline-block; padding: 10px; background-color:rgb(169, 169, 169)">
                                        <input class="form-check-input"
                                            {{ @$asessment['triage']['kesimpulan'] == 'Meninggal' ? 'checked' : '' }}
                                            type="checkbox">
                                        <label class="form-check-label">Meninggal</label>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        {{-- <div class="page_break_after"></div> --}}<br/>
        <table style="border: 0px;width:100%;">
            <tr style="border: 0px;">
                <td colspan="3" style="text-align: center; border: 0px; width:50%;">
                    {{-- @if (isset($proses_tte) || isset($tte_nonaktif))
                        {{Auth::user()->pegawai->kategori_pegawai == 1 ? 'Dokter' : 'Perawat'}}
                    @else
                        @if (@$pegawai->kategori_pegawai == 1)
                            Dokter
                        @else
                            Perawat
                        @endif
                    @endif --}}
                    &nbsp;
                </td>
                <td colspan="3" style="text-align: center; border: 0px; width:50%;">
                  Petugas Triage
                </td>
            </tr>
            <tr style="border: 0px;">
                <td colspan="3" style="text-align: center; border: 0px;">
                  {{-- <br/>
                    @if (isset($proses_tte))
                        #
                    @elseif (isset($tte_nonaktif))
                        @php
                            @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ' , ' . Auth::user()->pegawai->nip))
                        @endphp
                        <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                    @endif --}}
                    &nbsp;
                </td>
                <td colspan="3" style="text-align: center; border: 0px;">
                  <br/>
                    @php
                        @$dokter = Modules\Pegawai\Entities\Pegawai::find($reg->dokter_id);
                        @$base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(@$pemeriksaan->user->pegawai->nama . ' , ' . @$pemeriksaan->user->pegawai->sip . ' , ' . date('d-m-Y', strtotime(@$reg->created_at))))
                    @endphp
                    @if ($base64)
                        <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                    @endif
                </td>
            </tr>
            <tr style="border: 0px;">
                <td colspan="3" style="text-align: center; border: 0px;">
                    {{-- @if (isset($proses_tte) || isset($tte_nonaktif))
                        {{Auth::user()->pegawai->nama}}
                    @else
                        {{ @$pegawai->nama }}
                    @endif --}}
                    &nbsp;
                </td>
                <td colspan="3" style="text-align: center; border: 0px;">
                  {{@$pemeriksaan->user->pegawai->nama}}
                  {{-- {{$dokter->nama}} <br>
                  {{$dokter->sip}} --}}
                </td>
            </tr>
        </table>
        </div>   
  </body>
</html>

