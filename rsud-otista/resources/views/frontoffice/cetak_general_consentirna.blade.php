<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.merek') }} | {{ config('app.nama') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet"
        href="{{ asset('style') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet"
        href="{{ asset('style') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="{{ asset('style') }}/bower_components/select2/dist/css/select2.css">
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/AdminLTE.min.css">
    {{-- default
  <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/_all-skins.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/skin-yellow.min.css">
    <link rel="stylesheet" href="{{ asset('style') }}/dist/css/skins/skin-red.min.css">
    <link rel="stylesheet" href="{{ asset('style') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-chosen.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.min.css') }}">
    {{--
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('style') }}/plugins/timepicker/bootstrap-timepicker.min.css">
</head>
<style>
    @media print {
    .page-break {
        page-break-before: always;
    }
}
</style>

<body class="hold-transition skin-red sidebar-mini" onload="print()">
    <body class="hold-transition skin-red sidebar-mini" onload="print()">
    <table border=0 style="width:95%;font-size:12px;">
        <tr>
            <td style="width:10%;">
                <img src="{{ asset('images/' . configrs()->logo) }}"style="width: 60px;">
            </td>
            <td style="text-align: center">
                <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br />
                <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br />
                <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br />
                <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
            </td>
            <td style="width:10%;">
                <img src="{{ asset('images/' . configrs()->logo_paripurna) }}" style="width:68px;height:60px">
            </td>
        </tr>
    </table><hr>

    <h4 style="text-align: center"><b>SURAT PERNYATAAN</b></h4>
    <br>
    <div class="container">
        <div class="header">
            <p>Yang bertanda tangan di bawah ini:</p>
            <table border="0">
                <tr>
                    <td style="padding-right: 10px;">Nama</td>
                    <td>:</td>
                    <td style="padding-left: 10px;">{{@$consent['tanda_tangan']['nama']}}</td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td style="padding-left: 10px;">{{@$consent['tanda_tangan']['umur']}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td style="padding-left: 10px;">{{@$consent['tanda_tangan']['alamat']}}</td>
                </tr>
                <tr>
                    <td style="padding-right: 10px;">Hubungan dengan pasien</td>
                    <td>:</td>
                    <td style="padding-left: 10px;">{{@$consent['tanda_tangan']['hubungan']}}</td>
                </tr>
                <tr>
                    <td><b>No. HP (WAJIB DIISI)</b></td>
                    <td>:</td>
                    <td style="padding-left: 10px;">{{@$consent['tanda_tangan']['nohp']}}</td>
                </tr>
            </table><br>
            <p>Menyatakan dengan sungguh-sungguh, bahwa pasien sebagai berikut:</p>
            <table border="0">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td style="padding-left: 10px;">{{ @$reg->pasien->nama }}</td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td style="padding-left: 10px;">{{ @$umur }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td style="padding-left: 10px;">{{ @$reg->pasien->alamat }}</td>
                </tr>
                    <td style="padding-right: 10px;">Memang betul-betul pasien</td>
                    <td>:</td>
                    <td style="padding-left: 10px;">Benar</td>
                </tr>
            </table>
        </div><br>

        <div class="section">
            <p class="section-title" style="font-weight:bold;">A. UMUM</p>
            <p>Biaya retribusi, Obat-obatan yang digunakan, tindakan serta pemeriksaan penunjang lainnya <em>dibebankan kepada pasien</em>.</p>
        </div>
        
        <div class="section">
            <p class="section-title" style="font-weight:bold;">B. PESERTA BPJS</p>
            <ul>
                <li>Pembiayaan yang terkait pelayanan pasien yang dijamin oleh BPJS dengan mengikuti aturan yang berlaku.</li>
                <li>Pasien harus menunjukkan <strong>Nomor Identitas peserta JKN selambat-lambatnya 3 x 24 jam hari kerja</strong> sejak pasien dirawat atau sebelum pasien pulang.</li>
                <li>Apabila sampai waktu yang telah ditentukan pasien tidak dapat menunjukkan Nomor Identitas Peserta JKN, maka pasien dinyatakan sebagai pasien <strong>UMUM</strong>.</li>
                <li>Apabila <strong>melakukan kenaikan kelas perawatan</strong> dari hak pasien sesuai JKN maka diharuskan <strong>membayar selisih</strong> sesuai dengan <strong>Permenkes No. 4 tahun 2017</strong>.</li>
            </ul>
        </div>
        
        <div class="section">
            <p class="section-title" style="font-weight:bold;">C. KONTRAKTOR</p>
            <p>Biaya retribusi, Obat-obatan yang digunakan, tindakan serta pemeriksaan penunjang lainnya <em>disesuaikan dengan aturan yang sudah ditetapkan oleh masing-masing perusahaan</em>.</p>
        </div>
        
        <div class="section">
            <p class="section-title" style="font-weight:bold;">D. DENGAN SKTM</p>
            <ul>
                <li>Biaya penggantian pasien sesuai dengan peraturan Bupati Bandung Nomor 112 tahun 2016 mengenai peraturan SKTM yang berlaku.</li>
                <li>Pasien menunjukkan <em>persyaratan selambat-lambatnya 3 x 24 jam hari kerja</em> sejak pasien dirawat atau sebelum pasien pulang. Jika sampai waktu yang telah ditentukan pasien tidak dapat menunjukkan maka pasien dinyatakan sebagai pasien <strong>UMUM</strong>.</li>
            </ul>
        </div>
        
        <div class="section">
            <p class="section-title" style="font-weight:bold;">E. PESERTA JAMKESDA KAB. BANDUNG BARAT</p>
            <ul>
                <li>Perawatan pasien sesuai dengan peraturan Bupati Kabupaten Bandung Barat mengenai Jamkesda yang terbaru.</li>
                <li>Pasien harus menunjukkan persyaratan <em>selambat-lambatnya 3 x 24 jam hari kerja</em> sejak pasien dirawat atau sebelum pasien pulang. Jika sampai waktu yang telah ditentukan pasien tidak dapat menunjukkan maka pasien dinyatakan sebagai pasien <strong>UMUM</strong>.</li>
                <li>Bila pasien pulang belum melengkapi persyaratan, maka semua biaya pelayanan kesehatan <strong>harus dibayar</strong> (sebagai pasien umum).</li>
            </ul>
        </div>
        
        <div class="section">
            <p class="section-title" style="font-weight:bold;">F. PESERTA JAMPELSAL (JAMINAN PERSALINAN)</p>
            <ul>
                <li>Bagi Ibu bersalin dan bayi baru lahir s/d umur 28 hari.</li>
                <li>Ketentuan persyaratan sesuai dengan persyaratan pasien SKTM.</li>
                <li>Persyaratan lebih dari <strong>3 x 24 jam</strong> (kecuali Hari Sabtu dan Minggu), maka semua pelayanan atas nama pasien tersebut <strong>harus dibayar</strong> (sebagai pasien umum).</li>
            </ul>
        </div>        
                
    <table style="width: 100%;margin-top: 20px;" border="0">
        <tr>
            <td style="width: 50%;text-align:center"></td>
            <td style="width: 50%;text-align:center">
                Soreang, {{ date('d-m-Y') }}
                <br>
                Yang membuat pernyataan
            </td>
        </tr>
        <tr>
            <td style="width: 50%;text-align:center;">
                
                    <br><br><br><br>
                
            </td>
            <td style="width: 50%;text-align:center;">
                  {{-- {{ dd($ttd) }}  --}}
                @if (@$ttd)
                    <img src="{{ asset('images/upload/ttd/' . @$ttd->tanda_tangan) }}" style="height: 100px; width: auto;" onerror="this.style.display='none';">
                @else
                    <br><br><br><br>
                @endif
            </td>                
        </tr>
        <tr>
            <td style="width: 50%;text-align:center"></td>
            <td style="width: 50%;text-align:center">
                ({{ @$consent['yangMenyatakan'] }}) <br>
            </td>
        </tr>
    </table>

    <div style="width: 100%;padding: 10px;" class="page-break">
        {{-- <table style="width: 100%">
            <tr>
                <td style="width: 30%;font-weight:bold">Nama</td>
                <td style="width: 70%">: {{ @$reg->pasien->nama }} ({{ @$reg->pasien->kelamin }})</td>
            </tr>
            <tr>
                <td style="width: 30%;font-weight:bold">NO.RM</td>
                <td style="width: 70%">: {{ @$reg->pasien->no_rm }}</td>
            </tr>
            <tr>
                <td style="width: 30%;font-weight:bold">Tgl. Lahir</td>
                <td style="width: 70%">: {{ @$reg->pasien->tgllahir }}</td>
            </tr>
        </table> --}}
        <table border=0 style="width:95%;font-size:12px;">
            <tr>
                <td style="width:10%;">
                    <img src="{{ asset('images/' . configrs()->logo) }}"style="width: 60px;">
                </td>
                <td style="text-align: center">
                    <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br />
                    <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br />
                    <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br />
                    <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
                </td>
                <td style="width:10%;">
                    <img src="{{ asset('images/' . configrs()->logo_paripurna) }}" style="width:68px;height:60px">
                </td>
            </tr>
        </table><hr>
        <h4 style="text-align: center"><b>PERSETUJUAN UMUM (GENERAL CONSENT)</b></h4><br>

        <ol style="text-align: justify">
            <li>
                <strong>PERSETUJUAN UNTUK PENGOBATAN (CONSENT FOR TREATMENT)</strong>
                <ol>
                    <li>Saya mengetahu bahwa saya memiliki kondisi yang membutuhkan perawatan medis, saya mengizinkan dokter dan profesional kesehatan lainnya untuk melakukan prosedur diagnostik dan untuk memberikan pengobatan medis seperti yang diperlukan dalam penilaian profesional mereka. Prosedur diagnostik dan perawatan medis tidak terbatas pada elektokardiogram, x-ray, tes darah terapi fisik dan pemberian obat. </li>
                    <li>Saya sadar bahwa praktik kedokteran dan bedah bukanlah ilmu pasti dan saya mengakui bahwa tidak ada jaminan atas hasil apapun, terhadap perawatan prosedur atau pemeriksaan apapu yang dilakukan kepada saya.</li>
                    <li>Apabila saya terlibat dalam penelitian atay prosedur eksperimental, maka hal tersebut hanya dapat dilakukan dengan sepengetahuan dan persetujuan saya.</li>
                    <li>Pasien hanya diperbolehkan pulang seizin dokter yang merawat dan memiliki surat pulang rawat.</li>
                    <li>Pasien yang pulang tanpa seizin dokter dinyatakan pulang paksa atau pulang atas permintaan sendiri dan diwajibkan membuat surat penolakan di rawat.</li>
                </ol>
            </li>
            <li>
                <strong>TANGGUNG JAWAB PASIEN/KELUARGA (PATIENS RESPONSIBILITIES)</strong>
                <ol>
                    <li>Memberikan informasi yang akurat dan lengkap tentanng keluhan sakit sekarang, riwayat medis yang lalu, riwayat medikasi/pengobatan dan hal-hal lain yang berkaitan dengan kesehatan pasien.</li>
                    <li>Memberikan staff RS dan pasien lain dengan bermartabat dan hormat serta tidak melakukan tindakan yang akan mengganggu pekerjaan tenaga RS.</li>
                    <li>Menghormati privasi orang lain dan barang milik RS.</li>
                    <li>Tidak membawa alkohol obat-obatan yang tidak mendapat persetujuan, senjata/benda tajam ke dalam RS.</li>
                    <li>Tidak membawa barang berharga dan hanya membawa barang-barang yang dibutuhkan selama diwawat di RS.</li>
                    <li>Memastikan bahwa kewajiban finansial atas asuhan pasien dipenuhi sebagaimana ketentuan RS.</li>
                    <li>Bertanggung jawab atas tindakannya sendiri bila menolak pengobatan atau saran dokter.</li>
                    <li>Mengikuti rencana pengobatan yang di adviskan oleh dokter termasuk instruksi para perawat dan profesional kesehatan lain sesuai perintah dokter.</li>
                </ol>
            </li>
            <li>
                <strong>PELEPASAN INFORMASI (RELEASE INFORMATION)</strong>
                <ol>
                    <li>Saya memahamai informasi yang ada didalam diri saya, termasuk diagnosis, hasil laboratorium dan hasil tes diagnostik yang akan digunakan untuk perawatan medis, RS akan menjamin kerahasiannya.</li>
                    <li>Saya memberi wewenang kepada RS untuk memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan bila diperlukan untuk memproses klaim asuransi/perusahaan dan atau lembaga pemerintah.</li>
                    <li>Saya memberikan wewenang kepada RS untuk memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan saya kepada anggota keluarga/teman saya yaitu: 
                        <ol>
                            <li>{{@$consent['pelepasanInformasi_1']}}</li>
                            <li>{{@$consent['pelepasanInformasi_2']}}</li>
                        </ol>
                    </li>
                </ol>
            </li>
    
            <li>
                <strong>KEINGINAN PRIVASI (DESIRE PRIVACY)</strong>
                <ol>
                    <li>Pasien dapat ditunggu oleh 1 orang anggota keluarga apabila dibutuhkan lebih dari 1 penunggu harus ada persetujuan dari petugas ruangan.</li>
                    <li>Saya mengizinkan RS memberi akses bagi keluarga dan handai taulan serta orang-orang yang akan menengok saya kecuali : 
                        <ol>
                            <li>{{@$consent['keinginanPrivasi_1']}}</li>
                            <li>{{@$consent['keinginanPrivasi_2']}}</li>
                        </ol>
                    </li>
                </ol>
            </li>
    
            <li>
                <strong>BARANG BERHARGA MILIK PRIBADI ( WORTHY OF PERSONAL)</strong>
                <ol>
                    <li>Saya telah memahami bahwa RS tidak bertanggung jawab atas semua kehilangan barang-barang milik saya, dan saya pribadi bertanggung jawab atas barang-barang berharga yang saya bawa ke RS kecuali di titipkan RS</li>
                    <li>Berang berharga yang dapat di titipkan ke RS adalah uang dan dokumen yang berhubungan dengan proses perawatan di RS 
                        <ol>
                            <li>{{@$consent['barahBerharga_1']}}</li>
                            <li>{{@$consent['barahBerharga_2']}}</li>
                        </ol>
                    </li>
                </ol>
            </li>
    
            <li>
                <strong>PERNYATAAN PASIEN (STATEMENT OF PATIENTS)</strong>
                Saya mengerti dan memahami bahwa :
                <ol>
                    <li>Saya memiliki hak untuk mengajukan pertanyaan tentang pengobatan yang diusulkan ( termasuk identitas setiap orang yang memberikan atau mengamatin ( pengobatan ) setiap saat.                </li>
                    <li>Saya mengerti dan memahami bahwwa memiliki hak untuk menyetujui, atau menolak setiap prosedur/terapi.</li>
                    <li>Saya mengerti bahwa banyak dokter dan paramedik RS yang bukan karyawan tetapi staf indefendent/tamu yang telah diberikan hak untuk menggunakan fasilitas untuk perawatan dan pengobatan pasien mereka.</li>
                    <li>Jika diperlukan, saya bersedia memenuhi aturan RS tentang dokter yang bertanggung jawab untuk perawatan saya selama dalam perawatan di RS.</li>
                    <li>Bila diperlukan untuk kelengkapan data dan informasi, saya bersedia untuk dokumentassi visual.</li>
                    <li>Bila diperlukan dalam proses pendidikan, saya bersedia membantu proses pendidikan tersebut</li>
                    <li>Saya sudah membaca / memahami hak dan kewajiban pasien di RSUD Soreang apabila membutuhkan informasi tambahan saya akan menghubungi staf rumah sakit.</li>
                    <li>Jika ada komplain saya bersedia mengikuti aturan tentang alur penanganan komplain pasien di RSUD Soreang.</li>
                    <li>Saya Bersedia mengikuti tata-tertib peraturan yang ada di RSUD Soreang</li>
                </ol>
            </li>
    
        </ol>

        <ol>
            <div style="text-align: center;">
                <strong>HAK DAN KEWAJIBAN PASIEN</strong>
                <br>
                <strong>HAK PASIEN</strong>
            </div>
            <li>Mmemperoleh informasi mengenai tata tertib dan peraturan yang berlaku di Rumah Sakit.</li>
            <li>Mmeperoleh informasi mengenai Hak dan Kewajiban Pasien.</li>
            <li>Berhak atas pelayanan yang manusiawi, adil dan jujur tanpa diskriminasi.</li>
            <li>Memperoleh layanan kesehatan yang bermutu sesuai dengan standar profesi (SPO)</li>
            <li>Memperoleh layanan yang efektif dan efisien sehingga pasien terhindar dari kerugian fisik dan materi.</li>
            <li>Mengajukan pengaduan atas kualitas pelayanan yang didapatkan.</li>
            <li>Memilih dokter dan kelas perawatan sesuai dengan keinginannya dan peraturan yang berlaku di Rumah Sakit.</li>
            <li>Meminta konsultasi tentang penyakit yang dideritanya kepada dokter lain yang mempunyai surat ijin Praktek baik diluar maupun didalam Rumah Sakit.</li>
            <li>Mendapatkan privasi dan kerahasiaan penyakit yang diderita termasuk data-data medisnya.</li>
            <li>Mendapatkan informasi tentang kondisi penyakit yang dideritanya serta perkiraan biaya pengobatan.</li>
            <li>Memberikan persetujuan  atau menolak atas tindakan yang akan dilakukan oleh tenaga kesehatan terhadap penyakit yang dideritanya.</li>
            <li>Didampingi keluarganya disaat kritis.</li>
            <li>Menjalankan ibadah sesuai agama/kepercayaan selama hal tersebut tidak mengganggu pasien lainya.</li>
            <li>Berhak atas keamanan dan keselamatan dirinya selama dalam perawatan di Rumah Sakit.</li>
            <li>Mengajukan usul, saran, perbaikan atas perlakuan Rumah Sakit terhadap dirinya.</li>
            <li>Menolak pelayanan bimbingan rohani yang tidak sesuai dengan agama dan kepercayaan yang dianutnya.</li>
            <li>Menggugat Rumah Sakit apabila Rumah Sakit diduga memberikan pelayanan yang tidak sesuai dengan standar, baik secara perdata maupun pidana.</li>
            <li>Mengeluhkan pelayanan Rumah Sakit yang tidak sesuai dengan standar pelayanan melalui media sesuai dengan ketentuan peraturan peraturan-peraturan.</li>
        </ol>

        <ol>
            <div style="text-align: center;">
                <strong>KEWAJIBAN PASIEN</strong>
            </div>
            <li>Mematuhi peraturan yang berlaku di Rumah Sakit.</li>
            <li>Menggunakan fasilitas Rumah Sakit secara bertanggung jawab.</li>
            <li>Menghormati hak-hak pasien Rumah Sakit lain pengunjung dan hak tenaga kerja kesehatan serta petugas lainya yang bekerja di Rumah Sakit.</li>
            <li>Memberikan informasi yang jujur, lengkap dan akurat sesuai kemampuan dan pengetahuanya tentang masalah kesehatannya.</li>
            <li>Memberikan informasi mengenai kemampuan finansial dan jaminan kesehatan yang dimilikinya.</li>
            <li>Mematuhi rencana terapi yang merekomendasikan oleh tenaga kesehatan di Rumah Sakit dan disetujui oleh pasien yang bersangkutan setelah mendapatkan penjelasan sesuai ketentuan peraturan perundang-undangan.</li>
            <li>Menerima segala konsekuensi atas keputusan pribadinya untuk melaksanakan rencana terapi yang direkomendasikan oleh tenaga kesehatan atau tidak mematuhi petunjuk yang diberikan oleh tenaga kesehatan dalam rangka penyembuhan penyakit atau masalah kesehatan.</li>
            <li>Memberikan imbalan jasa atas pelayanan yang diterima.</li>
        </ol>

        <p>
            Demikian saya atas nama pasien {{@$consent['pasien']}}. telah membaca serta memahami surat Persetujuan umum ini, saya bersedia memenuhi ketentuan persetujuan tersebut diatas.
        </p>

        <table style="width: 100%;margin-top: 20px">
            <tr>
                <td style="width: 50%;text-align:center">Mengetahui Petugas Rumah Sakit</td>
                <td style="width: 50%;text-align:center">
                    Soreang, {{ date('d-m-Y') }}
                    <br>
                    Pasien/Penanggung Jawab pasien
                </td>
            </tr>
            <tr>
                <td style="width: 50%;text-align:center;">
                    @if (Auth::user()->pegawai->tanda_tangan)
                        <img src="{{asset('images/' . Auth::user()->pegawai->tanda_tangan)}}" style="height: 120px; width: auto;margin-top:20px" onerror="this.style.display='none';">
                    @else
                        <br><br><br><br><br>
                    @endif
                </td>
                <td style="width: 50%;text-align:center;">
                      {{-- {{ dd($ttd) }}  --}}
                    @if (@$ttd)
                        <img src="{{ asset('images/upload/ttd/' . @$ttd->tanda_tangan) }}" style="height: 120px; width: auto;" onerror="this.style.display='none';">
                    @else
                        <br><br><br><br><br>
                    @endif
                </td>                
            </tr>
            <tr>
                <td style="width: 50%;text-align:center">({{ baca_user(@$consent['user_id']) }})</td>
                <td style="width: 50%;text-align:center">
                    ({{ @$consent['yangMenyatakan'] }}) <br>
                </td>
            </tr>
        </table>
    </div>
    
</body>

</html>
