<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dokumen Pemberian Informasi</title>
    <style>
        * {
          font-size: 11px;
        }
        table{
          width: 100%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px 8px;
            /* text-align: left; */
        }
        @page {
            padding-bottom: 2cm;
        }
        .footer {
          position: fixed; 
          bottom: 0cm; 
          left: 0cm; 
          right: 0cm;
          height: 1cm;
          text-align: justify;
        }
        .page_break_after{
          page-break-after: always;
        }
    </style>
  </head>
  <body>

    @if (isset($proses_tte))
      <div class="footer">
        Dokumen ini di tandatangani secara elektronik hanya untuk kepentingan Rekam Medis Elektronik di lingkungan RSUD Oto Iskandar Di Nata. UU ITE No. 11 Tahun 2008 Pasal 5 Ayat 1 "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetakannya merupakan alat bukti hukum yang sah
      </div>
    @endif

    <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
      <tr>
        <th colspan="1" style="text-align: center;">
          <img src="{{ public_path('images/'.configrs()->logo) }}" style="width: 60px;"><br>
          <b style="font-size:12px;">RSUD OTO ISKANDAR DINATA</b><br/>
          <b style="font-size:6px; font-weight:normal;">{{ configrs()->alamat }}</b> <br>
        </th>
        <th colspan="2" style="font-size: 19px !important; text-align: center;">
          PERSETUJUAN <br>
          PASIEN/KELUARGA <br>
          TERHADAP TINDAKAN
        </th>
        <th colspan="3" style="vertical-align: middle; text-align: left; padding: 5px; font-size: 12px !important;">
          <table style="width: 100%; border: none;">
            <tr>
              <td style="width: 70px; padding: 2px 0; border: none;">No RM</td>
              <td style="padding: 5px 0; border: none;">: {{$reg->pasien->no_rm}}</td>
            </tr>
            <tr>
              <td style="padding: 5px 0; border: none;">Nama</td>
              <td style="padding: 5px 0; border: none;">: {{$reg->pasien->nama}}</td>
            </tr>
            <tr>
              <td style="padding: 5px 0; border: none;">Tgl. Lahir</td>
              <td style="padding: 5px 0; border: none;">: {{ date('d-m-Y', strtotime(@$reg->pasien->tgllahir)) }}</td>
            </tr>
            <tr>
              <td style="padding: 5px 0; border: none;">Tgl. Masuk</td>
              <td style="padding: 5px 0; border: none;">: {{ \Carbon\Carbon::parse($reg->created_at)->format('d-m-Y') }}</td>
            </tr>
          </table>
    </table>
    
    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box">
      <tr style="border: 1px solid black; text-align:center; font-size: 20px !important;">
        <td colspan="4"><b>DOKUMEN PEMBERIAN INFORMASI</b></td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; text-align: center;" class="text-center">
              <b>NO</b>
          </td>
          <td style="border: 1px solid black; width: 25%; text-align: center;" class="text-center">
              <b>TGL/JAM</b>
          </td>
          <td style="border: 1px solid black; width: 30%; text-align: center;" class="text-center">
              <b>JENIS INFORMASI</b>
          </td>
          <td style="border: 1px solid black; width: 30%; text-align: center;" class="text-center">
              <b>ISI INFORMASI</b>
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              1
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['pemasangan_infus']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['pemasangan_infus']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Pemasangan Infus
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Untuk rehidrasi / pemberian therapu cairan <br>
              - Untuk memberikan obat obat injeksi IV <br>
              - Untuk memberikan untrisi parenteral <br>
              <b>Resiko : </b> <br>
              - Plebhitis / Infeksi
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              2
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
              <input>{{ @$data['dokumen_pemberian_terapi']['pemberian_suntikan']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['pemberian_suntikan']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Pemberian Suntikan / Injeksi
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Untuk memberikan obat obat yang tidak bisa diberikan melalui mulut <br>
              <b>Resiko : </b> <br>
              - Plebhitis / Infeksi (IV) <br>
              - Hematoma / Memar (IM)
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              3
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['pemasangan_ogt']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['pemasangan_ogt']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Pemasangan OGT
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Untuk Dekompresi / mengeluarkan udara dari lambung <br>
              - Untuk pemberisan nutrisi enteral <br>
              - Untuk bilang lambung <br>
              <b>Resiko : </b> <br>
              - Aspirasi / tersedak <br>
              - Iritasi / lecet
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              4
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
              <input>{{ @$data['dokumen_pemberian_terapi']['suction_nasofaring']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['suction_nasofaring']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Suction Nasofaring
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Membersihkan jalan nafas dari lendir / ketuban <br>
              <b>Resiko : </b> <br>
              - Iritasi / lect pada selaput lendir mulut / hidung
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              5
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['pemasangan_therapy']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['pemasangan_therapy']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Pemasangan therapy sinar (blue light)
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Untuk menurunkan kadar bilirubin dalam darah <br>
              <b>Resiko : </b> <br>
              - Kekurangan cairan <br>
              - Demam <br>
              - Diare <br>
              - Baby Bronze Syndrome
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              6
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['skrining_bayi']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['skrining_bayi']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Skrining Bayi baru lahir (Pemeriksaan Darah)
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Untuk mengetahui kondisi kesehatan / mendeteksi adanya kemungkinan penyakit <br>
              <b>Resiko : </b> <br>
              - Hematoma / memar pada area pengambilan darah
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              7
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['pemasangan_early_cpap']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['pemasangan_early_cpap']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Pemasangan early CPAP
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Membuka alveoli paru <br>
              - Mencegah kekurangan oksigen <br>
              <b>Resiko : </b> <br>
              - Keracunan oksigen <br>
              - Lecet pada selaput lendir hidung
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              8
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['pemasangan_cpap']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['pemasangan_cpap']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Pemasangan CPAP
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Membuka alveoli paru <br>
              - Mencegah kekurangan oksigen <br>
              <b>Resiko : </b> <br>
              - Keracunan oksigen <br>
              - Lecet pada selaput lendir hidung <br>
              - Kerusakan retina mata pada bayi prematur
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              9
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['pemberian_therapy_oksigen']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['pemberian_therapy_oksigen']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Pemberian therapy oksigen Nasal canule
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Mencegah / mengatasi kekurangan oksigen <br>
              <b>Resiko : </b> <br>
              - Keracunan oksigen <br>
              - Lecet pada selaput lendir hidung <br>
              - Kerusakan retina mata pada bayi prematur
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              10
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['resusitasi_ventilasi']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['resusitasi_ventilasi']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              Resusitasi / Ventilasi Tekanan Positif
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top;">
              <b>Tujuan : </b> <br>
              - Untuk memperbaiki sistem pernapasan bayi dan membuka alveoli paru <br>
              <b>Resiko : </b> <br>
              - Pneumothorax
          </td>
      </tr>
      <tr style="border: 1px solid black;">
          <td style="border: 1px solid black; width: 5%; vertical-align: top;" class="text-center">
              11
          </td>
          <td style="border: 1px solid black; width: 25%; vertical-align: top;" class="text-center">
            <input>{{ @$data['dokumen_pemberian_terapi']['tambahan']['tanggal_waktu'] ? date('d-m-Y / H:i', strtotime($data['dokumen_pemberian_terapi']['tambahan']['tanggal_waktu'])) : '' }}
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top; padding: 0;">
              <textarea style="width: 100%;" name="fisik[dokumen_pemberian_terapi][tambahan][jenis_informasi]"cols="30" rows="10">{{@$data['dokumen_pemberian_terapi']['tambahan']['jenis_informasi']}}</textarea>
          </td>
          <td style="border: 1px solid black; width: 30%; vertical-align: top; padding: 0;">
              <textarea style="width: 100%;" name="fisik[dokumen_pemberian_terapi][tambahan][isi_informasi]"cols="30" rows="10">{{@$data['dokumen_pemberian_terapi']['tambahan']['isi_informasi']}}</textarea>
          </td>
      </tr>
      <tr style="border: 1px solid black;">
        <td colspan="3">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jujur dan memberikan kesempatan untuk bertanya dan / atau berdiskusi (Petugas)</td>
        <td style="text-align: center;">
          Petugas <br><br><br>
          (..........................................)
        </td>
      </tr>
      <tr style="border: 1px solid black;">
        <td colspan="3">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di atas yang saya tanda tangani di kolom kanannya, dan telah memahaminya dan diberikan waktu / kesempatan untuk berdiskusi (pasien dan keluarga)</td>
        <td style="text-align: center;">
          Pasien/Keluarga <br><br><br>
          (..........................................)
        </td>
      </tr>
    </table>
  </body>
</html>
 