<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Tilik</title>
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
            padding: 5px;
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
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD BEDAS KERTASARI. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
        </div>
    @endif
    <table>
        <tr>
            <th colspan="1" style="width: 20%;">
                <img src="{{ public_path('images/' . configrs()->logo) }}"style="width: 60px;">
            </th>
            <th colspan="5" style="font-size: 18pt; width:80%;">
                <b>DAFTAR TILIK</b>
            </th>
        </tr>
        <tr>
            <td colspan="6" style="width:100%;">
                Tanggal Pemeriksaan : {{ !empty($riwayat->created_at) ? date('d-m-Y', strtotime($riwayat->created_at)) : '' }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width:35%;">
                <b>Nama Pasien</b><br>
                {{ $pasien->nama }}
            </td>
            <td colspan="2" style="width:30%;">
                <b>Tgl. Lahir</b><br>
                {{ !empty($pasien->tgllahir) ? hitung_umur($pasien->tgllahir) : null }}
            </td>
            <td style="width: 20%;">
                <b>Jenis Kelamin</b><br>
                {{ $pasien->kelamin }}
            </td>
            <td style="width: 15%;">
                <b>No MR.</b><br>
                {{ $pasien->no_rm }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width:60%;">
                <b>Alamat Lengkap</b><br>
                {{ $pasien->alamat }}
            </td>
            <td colspan="2" style="width:40%;">
                <b>No Telp</b><br>
                {{ $pasien->nohp }}
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td style="vertical-align: middle; width:20%;">
                <b>Sign In</b>
            </td>
            <td colspan="5" style="width: 80%;">
                <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td>Pukul</td>
                    <td>
                      {{ \Carbon\Carbon::parse(@$cetak['sign_in']['pukul'])->format('d-m-Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>1. Pasien telah dikonfirmasikan</b></td>
                  </tr>
                  <tr>
                    <td>- Identitas dan gelang pasien</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['pasien_konfirmasi']['identitas_dan_gelang_pasien'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Lokasi operasi</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['pasien_konfirmasi']['lokasi_operasi'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Prosedur</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['pasien_konfirmasi']['prosedur'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Surat ijin operasi</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['pasien_konfirmasi']['surat_ijin_operasi'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>2. Lokasi operasi sudah diberi tanda</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['lokasi_operasi']['diberi_tanda'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>3. Mesin dan obat-obatan anestesi sudah dicek lengkap</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['mesin_dan_obat']['lengkap'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>4. Pulse oximeter sudah terpasang dan berfungsi</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['pulse_oximeter']['terpasang'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>5. Apakah pasien mempunyai riwayat alergi</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['riwayat_alergi']['ya'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['sign_in']['riwayat_alergi']['tidak'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>6. Kesulitan bernafas / risiko aspirasi dan menggunakan peralatan bantuan ?</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['kesulitan_bernafas']['ya'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['sign_in']['kesulitan_bernafas']['tidak'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>7. Risiko kehilangan darah &gt; 500 ml (7 ml / kg BB pada anak)</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['resiko_kehilangan_darah']['ya'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['sign_in']['resiko_kehilangan_darah']['tidak'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td><b>8. Dua akses intravena/akses sentral dan rencana terapi cairan</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['dua_akses_intravena']['ya'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['sign_in']['dua_akses_intravena']['tidak'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                </table>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="vertical-align: middle; width:20%;">
                <b>Time Out</b>
            </td>
            <td colspan="5" style="width: 80%;">
                <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td>Pukul</td>
                    <td>
                      {{ \Carbon\Carbon::parse(@$cetak['time_out']['pukul'])->format('d-m-Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td><b>1. Konfirmasi seluruh anggota tim memperkenalkan nama dan perannya masing-masing</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['konfirmasi_seluruh_anggota_tim']['perkenalkan_nama_dan_peran'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>2. Dokter bedah, dokter anestesi dan perawat melakukan konfirmasi secara verbal</b></td>
                  </tr>
                  <tr>
                    <td>- Nama Pasien</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['konfirmasi_secara_verbal']['nama_pasien'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Prosedur</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['konfirmasi_secara_verbal']['prosedur'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Lokasi dimana insisi akan dibuat</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['konfirmasi_secara_verbal']['lokasi_insisi_dibuat'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>3. Apakah antibiotik profilaksis sudah diberikan 60 menit sebelunya?</b></td>
                  </tr>
                  <tr>
                    <td>- Nama antibiotik yang diberikan</td>
                    <td>
                      <input type="text" class="form-control" value="{{@$cetak['time_out']['antibiotik_profilaksis']['nama_antibiotik']}}">
                    </td>
                  </tr>
                  <tr>
                    <td>- Dosis antibiotik yang diberikan</td>
                    <td>
                      <input type="text" class="form-control" value="{{@$cetak['time_out']['antibiotik_profilaksis']['dosis_antibiotik']}}">
                    </td>
                  </tr>
                  <tr>
                    <td><b>3. Mesin dan obat-obatan anestesi sudah dicek lengkap</b></td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_in']['mesin_dan_obat']['lengkap'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>4. Antisipasi Kejadian Kritis</b></td>
                  </tr>
                  <tr>
                    <td colspan="2">a. Ahli Bedah</td>
                  </tr>
                  <tr>
                    <td>- Apakah ada kejadian kritis/langkah yang tidak rutin</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['ada_kejadian_kritis'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['ada_kejadian_kritis'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Estimasi lama operasi</td>
                    <td>
                      <input type="text" class="form-control" value="{{@$cetak['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['estimasi_lama_operasi']}}" placeholder="Menit">
                    </td>
                  </tr>
                  <tr>
                    <td>- Apakah ada antisipasi kehilangan darah</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['antisipasi_kehilangan_darah'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['ahli_bedah']['antisipasi_kehilangan_darah'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">b. Ahli Anestesi</td>
                  </tr>
                  <tr>
                    <td>- Apakah ada perhatian khusus terhadap pasien</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['ahli_anestesi']['perhatian_khusus'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['ahli_anestesi']['perhatian_khusus'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">c. Perawat</td>
                  </tr>
                  <tr>
                    <td>- Sterilitas sudah dikonfirmasikan ?</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['perawat']['sterilitas_dikonfirmasi'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['perawat']['sterilitas_dikonfirmasi'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                </table>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="vertical-align: middle; width:20%;">
                <b>Time Out</b>
            </td>
            <td colspan="5" style="width: 80%;">
                <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td>- Apakah ada perlengkapan terhadap kejadian kritis / perhatian lain ?</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['perawat']['perlengkapan_terhadap'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['time_out']['antisipasi_kejadian_kritis']['perawat']['perlengkapan_terhadap'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Jumlah kasa awal</td>
                    <td>
                      <input type="text" class="form-control" value="{{@$cetak['time_out']['antisipasi_kejadian_kritis']['perawat']['jumlah_kasa_awal']}}" placeholder="Menit">
                    </td>
                  </tr>
                  <tr>
                    <td><b>5. Apakah foto Rontgen/ CT - Scan dan MRI telah ditayangkan ?</b></td>
                    <td>
                      <input type="checkbox" value="Sudah" {{@$cetak['time_out']['foto_rontgen']['ditayangkan'] == "Sudah" ? "checked" : ""}}>
                      <label>Sudah</label>
                      <input type="checkbox" value="Belum" {{@$cetak['time_out']['foto_rontgen']['ditayangkan'] == "Belum" ? "checked" : ""}}>
                      <label>Belum</label>
                    </td>
                  </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: middle; width:20%;">
                <b>Sign Out</b>
            </td>
            <td colspan="5" style="width: 80%;">
                <table style="width: 100%; font-size:15px;" class="table table-striped table-bordered table-hover table-condensed form-box">
                  <tr>
                    <td>Pukul</td>
                    <td>
                      {{ \Carbon\Carbon::parse(@$cetak['sign_out']['pukul'])->format('d-m-Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>1. Perawat melakukan konfirmasi secara verbal dengan tim</b></td>
                  </tr>
                  <tr>
                    <td>- Nama prosedur tindakan telah dicatat</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_out']['perawat_melakukan_konfirmasi']['nama_prosedur'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Instrumen kasa, dan jarum telah dihitung dengan benar</td>
                    <td>
                      <div>
                        <input type="checkbox" value="Ya" {{@$cetak['sign_out']['instrumen_kasa']['dihitung_dengan_benar'] == "Ya" ? "checked" : ""}}>
                        <label>Ya</label>
                    
                        <table style="border: 1px solid black; margin-top: 5px;">
                          <tr style="border: 1px solid black; text-align: center;">
                            <td style="border: 1px solid black;">Item Instrumen</td>
                            <td style="border: 1px solid black;">Pra</td>
                            <td style="border: 1px solid black;">Intra (+)</td>
                            <td style="border: 1px solid black;">Post</td>
                          </tr>
                          <tr style="border: 1px solid black; text-align: center;">
                            <td style="border: 1px solid black;">Kasa</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['kasa']['pra']}}</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['kasa']['intra']}}</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['kasa']['post']}}</td>
                          </tr>
                          <tr style="border: 1px solid black; text-align: center;">
                            <td style="border: 1px solid black;">Jarum</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['jarum']['pra']}}</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['jarum']['intra']}}</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['jarum']['post']}}</td>
                          </tr>
                          <tr style="border: 1px solid black; text-align: center;">
                            <td style="border: 1px solid black;">Depper</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['depper']['pra']}}</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['depper']['intra']}}</td>
                            <td style="border: 1px solid black;">{{@$cetak['sign_out']['instrumen_kasa']['item_instrumen']['depper']['post']}}</td>
                          </tr>
                        </table>
                      </div>
                    </td>                    
                  </tr>
                  <tr>
                    <td>- Spesimen telah diberi label (termasuk nama pasien dan asal jaringan spesimen)</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_out']['perawat_melakukan_konfirmasi']['spesimen'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['sign_out']['perawat_melakukan_konfirmasi']['spesimen'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td>- Adakah masalah dengan peralatan selama operasi</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_out']['perawat_melakukan_konfirmasi']['masalah_perawatan_operasi'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['sign_out']['perawat_melakukan_konfirmasi']['masalah_perawatan_operasi'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><b>2. Operator dokter bedah, dokter anestesi dan perawat</b></td>
                  </tr>
                  <tr>
                    <td>- Apakah ada perhatian khusus untuk pemulihan dan penatalaksanaan pasien ?</td>
                    <td>
                      <input type="checkbox" value="Ya" {{@$cetak['sign_out']['operator_dokter_bedah']['perhatian_khusus_pasien'] == "Ya" ? "checked" : ""}}>
                      <label>Ya</label>
                      <input type="checkbox" value="Tidak" {{@$cetak['sign_out']['operator_dokter_bedah']['perhatian_khusus_pasien'] == "Tidak" ? "checked" : ""}}>
                      <label>Tidak</label> <br>
                      {{@$cetak['sign_out']['operator_dokter_bedah']['perhatian_khusus_pasien_detail']}}
                    </td>
                  </tr>
                  <tr>
                    <td>Tanggal Tindakan :</td>
                    <td>
                      {{ \Carbon\Carbon::parse(@$cetak['sign_out']['tanggal_tindakan'])->format('d-m-Y H:i') }}
                    </td>
                  </tr>
                </table>
            </td>
        </tr>
    </table>

    <br>
    <table style="border: 0px; width:100%;">
        <tr style="border: 0px;">
            <td colspan="3" style="text-align: center; border: 0px; width:50%;">
                
            </td>
            <td colspan="3" style="text-align: center; border: 0px; width:50%;">
                Dokter <br><br>
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
                @else
                  <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(Auth::user()->pegawai->nama, 'QRCODE', 4,4)}}" class="d-inline block" alt="barcode" /><br>
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
                {{ Auth::user()->pegawai->nama }}
            </td>
        </tr>
    </table>

</body>

</html>