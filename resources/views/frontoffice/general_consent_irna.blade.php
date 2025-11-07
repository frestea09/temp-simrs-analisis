<div style="width: 100%;padding: 10px;"> 
    <table style="width: 100%">
        <tr>
            <td style="width: 50%;font-weight:bold">Nama</td>
            <td style="width: 50%">: {{@$reg->pasien->nama}} ({{@$reg->pasien->kelamin}})</td>
        </tr>
        <tr>
            <td style="width: 50%;font-weight:bold">NO.RM</td>
            <td style="width: 50%">: {{@$reg->pasien->no_rm}}</td>
        </tr>
        <tr>
            <td style="width: 50%;font-weight:bold">Tgl. Lahir</td>
            <td style="width: 50%">: {{@$reg->pasien->tgllahir}}</td>
        </tr>
    </table>
    <hr>

    <table style="margin-left: 30px; width: 90%;" border="0">
        <tr style="padding-left: 10px;">
            <td colspan="2">Yang bertanda tangan dibawah ini :</td>
        </tr>
        <tr>
            <td style="width: 30%;">Nama</td>
            <td><input required type="text" name="consent[tanda_tangan][nama]" value="{{@$consent['tanda_tangan']['nama']}}" class="form-control"></td>
        </tr>
        <tr>
            <td>Umur</td>
            <td><input required type="text" name="consent[tanda_tangan][umur]" value="{{@$consent['tanda_tangan']['umur']}}" class="form-control"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input required type="text" name="consent[tanda_tangan][alamat]" value="{{@$consent['tanda_tangan']['alamat']}}" class="form-control"></td>
        </tr>
        <tr>
            <td>Hubungan dengan pasien</td>
            <td><input required type="text" name="consent[tanda_tangan][hubungan]" value="{{@$consent['tanda_tangan']['hubungan']}}" class="form-control"></td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td><input required type="text" name="consent[tanda_tangan][nohp]" value="{{@$consent['tanda_tangan']['nohp']}}" class="form-control"></td>
        </tr>
    </table><br>
    
    <ol style="text-align: justify">
        <li>
            <strong>PERSETUJUAN UNTUK PENGOBATAN (CONSENT FOR TREATMENT)</strong>
            <ol>
                <li>Saya mengetahui bahwa saya memiliki kondisi yang membutuhkan perawatan medis, saya mengizinkan dokter dan profesional kesehatan lainnya untuk melakukan prosedur diagnostik dan untuk memberikan pengobatan medis seperti yang diperlukan dalam penilaian profesional mereka. Prosedur diagnostik dan perawatan medis tidak terbatas pada elektokardiogram, x-ray, tes darah terapi fisik dan pemberian obat. </li>
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
                <li>Saya memberikan wewenang kepada RS untuk memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan saya kepada anggota keluarga/teman saya yaitu: <input required type="text" name="consent[pelepasanInformasi_1]" value="{{@$consent['pelepasanInformasi_1']}}" class="form-control"> <input required type="text" name="consent[pelepasanInformasi_2]" value="{{@$consent['pelepasanInformasi_2']}}" class="form-control"> </li>
            </ol>
        </li>

        <li>
            <strong>KEINGINAN PRIVASI (DESIRE PRIVACY)</strong>
            <ol>
                <li>Pasien dapat ditunggu oleh 1 orang anggota keluarga apabila dibutuhkan lebih dari 1 penunggu harus ada persetujuan dari petugas ruangan.</li>
                <li>Saya mengizinkan RS memberi akses bagi keluarga dan handai taulan serta orang-orang yang akan menengok saya kecuali : <input required type="text" name="consent[keinginanPrivasi_1]" value="{{@$consent['keinginanPrivasi_1']}}" class="form-control"> <input required type="text" name="consent[keinginanPrivasi_2]" value="{{@$consent['keinginanPrivasi_2']}}" class="form-control"></li>
            </ol>
        </li>

        <li>
            <strong>BARANG BERHARGA MILIK PRIBADI ( WORTHY OF PERSONAL)</strong>
            <ol>
                <li>Saya telah memahami bahwa RS tidak bertanggung jawab atas semua kehilangan barang-barang milik saya, dan saya pribadi bertanggung jawab atas barang-barang berharga yang saya bawa ke RS kecuali di titipkan RS</li>
                <li>Berang berharga yang dapat di titipkan ke RS adalah uang dan dokumen yang berhubungan dengan proses perawatan di RS <input required type="text" name="consent[barahBerharga_1]" value="{{@$consent['barahBerharga_1']}}" class="form-control"> <input required type="text" name="consent[barahBerharga_2]" value="{{@$consent['barahBerharga_2']}}" class="form-control"></li>
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
        Demikian saya atas nama pasien <input required type="text" name="consent[pasien]" value="{{@$consent['pasien']}}" class="form-control"> telah membaca serta memahami surat Persetujuan umum ini, saya bersedia memenuhi ketentuan persetujuan tersebut diatas.
    </p>

    <table style="width: 100%;margin-top: 20px">
        <tr>
            <td style="width: 50%;text-align:center">Mengetahui Petugas Rumah Sakit</td>
            <td style="width: 50%;text-align:center">
                Soreang, {{date('d-m-Y')}}
                <br>
                Pasien/Penanggung Jawab pasien
            </td>
        </tr>
        <tr>
            <td style="width: 50%;text-align:center; height: 100px" colspan="2"></td>
        </tr>
        <tr>
            <td style="width: 50%;text-align:center">({{@$consent['user_id'] ? baca_user(@$consent['user_id']) : Auth::user()->name}})</td>
            <input type="hidden" name="consent[user_id]" value="{{@$consent['user_id'] ? @$consent['user_id'] : Auth::user()->id}}">
            <td style="width: 50%;text-align:center">
                <input required type="text" name="consent[yangMenyatakan]" value="{{@$consent['yangMenyatakan']}}" class="form-control" placeholder="Yang menyatakan">
            </td>
        </tr>
    </table>

    <button type="submit" class="btn btn-md btn-primary pull-right" style="margin-top: 20px">SIMPAN/button>
</div>