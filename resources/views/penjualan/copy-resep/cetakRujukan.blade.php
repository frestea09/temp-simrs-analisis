<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data PDF</title>
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style>
        .page-break {
            page-break-after: always;
        }

        @page {
            padding-bottom: 1cm;
        }

        .keterangan-surat {
            text-align: justify;
        }

    </style>
  </head>
  <body>
    @if ($surat == "resistensi")
        <table border=0 style="width: 100%"> 
            <tr>
            <td style="text-align: center">
                <b style="font-size:15px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                <b style="font-size:10px;">{{ configrs()->alamat }}</b><br>
                <b style="font-size:10px;">Telp. {{ configrs()->tlp }}</b><br>
                <b style="font-size:10px;">Email. {{ configrs()->email }}</b><br>
            </td>
            </tr>
        </table>
        <hr>
        <div class="content">
            <br><br>
            <div>
                <p>Dengan Hormat,</p>
                <p>Melalui surat ini, saya menerangkan bahwa pasien saya :</p>
            </div>
            <br><br>
            <div class="detail-pasien">
                <table border="0" style="width: 100%;">
                    <tr>
                        <td style="width: 25%;">
                            Nama
                        </td>
                        <td>
                            : {{$pasien->nama}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;">
                            No RM
                        </td>
                        <td>
                            : {{$pasien->no_rm}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;">
                            Diagnosa
                        </td>
                        <td>
                            : {{$rujukan->diagnosa}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;">
                            Nama Obat
                        </td>
                        <td>
                            : <b>{{$rujukan->nama_obat}}</b>
                        </td>
                    </tr>
                </table>
            </div>
            <br><br>
            <div class="keterangan-surat">
                <p>
                    Karena tidak tersedianya pemeriksaan resistensi terhadap Asam Asetilsalisilat, dan pasien memerlukan terapi <b>{{$rujukan->nama_obat}}</b> untuk kasus Peripheral Artherial Disease (PAD) dan Small Vessel Disease Cerebry (CSVD) maka saya menyatakan bahwa pasien tidak dapat menggunakan lagi terapi Asam Asetilsalisilat dengan alasan klinis.
                </p>
            </div>
            <br><br><br>
            <div class="ttd-area">
                <table border="0" style="width: 100%;">
                    <tr>
                        <td style="width: 25%;">&nbsp;</td>
                        <td style="width: 25%;">&nbsp;</td>
                        <td style="width: 25%;">&nbsp;</td>
                        <td style="width: 25%; text-align:center;">
                            Hormat Saya, <br><br><br>
                            @php
                                $dokter = Modules\Pegawai\Entities\Pegawai::find($registrasi->dokter_id);
                                if ($dokter) {
                                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
                                }
                            @endphp
                            @if ($dokter)
                                <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                                ({{$dokter->nama}})
                            @else
                                <br><br><br><br>
                                (....................................)
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
    {{-- <div class="page-break"></div> --}}
    @if ($surat == "inhibitor")
        <table border=0 style="width: 100%"> 
            <tr>
                <td style="width:10%;">
                    <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
                </td>
                <td style="text-align: center">
                    <b style="font-size:15px;">{{ strtoupper(configrs()->pt) }}</b><br/>
                    <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
                    <b style="font-size:10px;">{{ configrs()->alamat }}</b><br>
                    <b style="font-size:10px;">Telp. {{ configrs()->tlp }}</b>
                    <b style="font-size:10px;">Email. {{ configrs()->email }}</b><br>
                </td>
            </tr>
        </table>
        <hr>
        <br>
        <div class="content">
            <div>
                <p>Dengan ini menerangkan bahwa pasien :</p>
            </div>
            <br>
            <div class="detail-pasien">
                <table border="0" style="width: 100%;">
                    <tr>
                        <td style="width: 40%;">
                            Nama
                        </td>
                        <td>
                            : {{$pasien->nama}} ({{$pasien->kelamin}})
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            No RM
                        </td>
                        <td>
                            : {{$pasien->no_rm}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            Berdasarkan penggunaan obat di Rumah Sakit
                        </td>
                        <td>
                            : {{$rujukan->rumah_sakit}}
                        </td>
                    </tr>
                </table>
            </div>
            <br><br>
            <div>
                <p>Pasien tersebut :</p>
            </div>
            <div class="detail-riwayat">
                @php
                    $riwayat = json_decode($rujukan->riwayat);
                @endphp
                <div>
                    @if (@$riwayat->riwayat_penggunaan_obat_acei->status == "Tidak ada")
                        <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat ACEI</p>
                    @else
                        <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat ACEI</p>
                    @endif
                    <table border="0" style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <ul>
                                    <li>
                                        (Captopril)
                                    </li>
                                    <li>
                                        (Lisinopril)
                                    </li>
                                    <li>
                                        (Ramipril)
                                    </li>
                                </ul>
                            </td>
                            <td style="text-align: end;">
                                <ul style="list-style-type: none">
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_acei->captopril}}</span>
                                    </li>
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_acei->lisinopril}}</span>
                                    </li>
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_acei->ramipril}}</span>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    @if (@$riwayat->riwayat_penggunaan_obat_statin->status == "Tidak ada")
                        <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat STATIN</p>
                    @else
                        <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat STATIN</p>
                    @endif
                    <table border="0" style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <ul>
                                    <li>
                                        (Simvastatin)
                                    </li>
                                </ul>
                            </td>
                            <td style="text-align: end;">
                                <ul style="list-style-type: none">
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_statin->simvastatin}}</span>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    @if (@$riwayat->riwayat_penggunaan_obat_arb->status == "Tidak ada")
                        <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat ARB</p>
                    @else
                        <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat ARB</p>
                    @endif
                    <table border="0" style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <ul>
                                    <li>
                                        (Candesartan)
                                    </li>
                                    <li>
                                        (Irbesartan)
                                    </li>
                                    <li>
                                        (Telmisartan)
                                    </li>
                                </ul>
                            </td>
                            <td style="text-align: end;">
                                <ul style="list-style-type: none">
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_arb->candesartan}}</span>
                                    </li>
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_arb->irbesarta}}</span>
                                    </li>
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_arb->telmisartan}}</span>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    @if (@$riwayat->riwayat_penggunaan_obat_insulin->status == "Tidak ada")
                        <p><strike>ADA</strike> riwayat / TIDAK ADA riwayat penggunaan obat Insulin</p>
                    @else
                        <p>ADA riwayat / <strike>TIDAK ADA</strike> riwayat penggunaan obat Insulin</p>
                    @endif
                    <table border="0" style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <ul>
                                    <li>
                                        (Human Insulin: short acting / intermediate acting / mix insulin)
                                    </li>
                                    <li>
                                        (Analog Insulin: rapid acting / mix insulin / long acting)
                                    </li>
                                </ul>
                            </td>
                            <td style="text-align: end;">
                                <ul style="list-style-type: none">
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_insulin->human_insulin}}</span>
                                    </li>
                                    <li>
                                        <span>Sejak : {{$riwayat->riwayat_penggunaan_obat_insulin->analog_insulin}}</span>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br><br><br>
            <div class="ttd-area">
                <table border="0" style="width: 100%;">
                    <tr>
                        <td style="width: 25%;">&nbsp;</td>
                        <td style="width: 25%;">&nbsp;</td>
                        <td style="width: 25%;">&nbsp;</td>
                        <td style="width: 25%; text-align:center;">
                            Hormat Saya, <br><br><br>
                            @php
                                $dokter = Modules\Pegawai\Entities\Pegawai::find($registrasi->dokter_id);
                                if ($dokter) {
                                    $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate($dokter->nama . ' | ' . $dokter->nip));
                                }
                            @endphp
                            @if ($dokter)
                                <img src="data:image/png;base64, {!! $base64 !!} "> <br>
                                ({{$dokter->nama}})
                            @else
                                <br><br><br><br>
                                (....................................)
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
  </body>
</html>
