<?php
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web', 'auth']], function () {
  // Route::view('sirs/obat', 'sirs.obat');
  // Route::view('sirs/penyakit', 'sirs.penyakit');
  // Route::view('sirs/other', 'sirs.other');
  Route::view('sirs/rl', 'sirs.rl');
  // Route::get('sirs/rl/gigi-mulut', 'SirsRlController@gigiMulut');
  // Route::get('sirs/rl/pembedahan', 'SirsRlController@pembedahan');
  // Route::get('sirs/rl/rawat-darurat', 'SirsRlController@rawatDarurat');
  // Route::get('sirs/rl/rawat-darurat/toExcel', 'SirsRlController@rawatDaruratExcel');

  Route::get('sirs/rl/penyakit-rawat-inap', 'SirsRlController@penyakitRawatInap');
  Route::post('sirs/rl/penyakit-rawat-inap', 'SirsRlController@penyakitRawatInapFilter');
  Route::get('sirs/rl/penyakit-rawat-jalan', 'SirsRlController@penyakitRawatJalan');
  Route::post('sirs/rl/penyakit-rawat-jalan', 'SirsRlController@penyakitRawatJalanFilter');

  Route::get('sirs/rl/penyakit-rawat-inap-sebab-luar', 'SirsRlController@penyakitLuarRawatInap');
  Route::post('sirs/rl/penyakit-rawat-inap-sebab-luar', 'SirsRlController@penyakitLuarRawatInapFilter');
  Route::get('sirs/rl/penyakit-rawat-jalan-sebab-luar', 'SirsRlController@penyakitLuarRawatJalan');
  Route::post('sirs/rl/penyakit-rawat-jalan-sebab-luar', 'SirsRlController@penyakitLuarRawatJalanFilter');


  Route::get('/10-besar-diagnosa-irna-baru', 'RlController@sepuluhBesarDiagnosa_irna');
  Route::post('/10-besar-diagnosa-irna-baru', 'RlController@sepuluhBesarDiagnosaIrna_byTanggal');

  Route::get('10-besar-diagnosa-irj-baru', 'RlController@sepuluhBesarDiagnosa_irj');
  Route::post('10-besar-diagnosa-irj-baru', 'RlController@sepuluhBesarDiagnosaIrj_byTanggal');

  Route::get('kujungan-rawat-jalan', 'RlController@kujungan_rawat_jalan');
  Route::post('kujungan-rawat-jalan', 'RlController@kujungan_rawat_jalanBytaggal');

  Route::get('pengadaan-obat', 'RlController@pengadaanObat');
  Route::post('pengadaan-obat', 'RlController@pengadaanObatFilter');

  Route::get('pelayanan-resep', 'RlController@pelayananResep');
  Route::post('pelayanan-resep', 'RlController@pelayananResepFilter');

  Route::get('tempat-tidur', 'RlController@tempat_tidur');
  Route::post('tempat-tidur', 'RlController@tempat_tidurBytaggal');

  Route::get('pelayanan', 'RlController@pelayanan');
  Route::post('pelayanan', 'RlController@pelayananBytaggal');

  Route::get('ketenagaan', 'RlController@ketenagaan');
  Route::post('ketenagaan', 'RlController@ketenagaanBytaggal');

  Route::get('kegiatan-rujukan', 'RlController@kegitan_rujukan');
  Route::post('kegiatan-rujukan', 'RlController@kegitan_rujukanBytaggal');

  Route::get('kegiatan-rehabilitasi-medik', 'RlController@kegiatan_rehabilitasi_medik');
  Route::post('kegiatan-rehabilitasi-medik', 'RlController@kegiatan_rehabilitasi_medikBytaggal');

  Route::get('kegiatan-kesehatan-jiwa', 'RlController@kesehatan_jiwa');
  Route::post('kegiatan-kesehatan-jiwa', 'RlController@kesehatan_jiwaBytaggal');

  Route::get('kegiatan-pelayanan-rawat-inap', 'RlController@pelayanan_rawat_inap');
  Route::post('kegiatan-pelayanan-rawat-inap', 'RlController@pelayanan_rawat_inapBytaggal');

  Route::get('kujungan-rawat-darurat', 'RlController@kujungan_rawat_darurat');
  Route::post('kujungan-rawat-darurat', 'RlController@kujungan_rawat_daruratBytaggal');

  Route::get('kegiatan-kesehatan-gigi-dan-mulut', 'RlController@kegiatan_kesehatan_gigi_dan_mulut');
  Route::post('kegiatan-kesehatan-gigi-dan-mulut', 'RlController@kegiatan_kesehatan_gigi_dan_mulutBytaggal');

  Route::get('kegiatan-pembedahan', 'RlController@kegiatan_pembedahan');
  Route::post('kegiatan-pembedahan', 'RlController@kegiatan_pembedahanBytaggal');

  Route::get('kegiatan-radiologi', 'RlController@kegiatan_radiologi');
  Route::post('kegiatan-radiologi', 'RlController@kegiatan_radiologiBytaggal');

  Route::get('pemeriksaan-laboratorium', 'RlController@pemeriksaan_laboratorium');
  Route::post('pemeriksaan-laboratorium', 'RlController@pemeriksaan_laboratoriumBytaggal');

  Route::get('sirs/rl/kebidanan', 'RlController@kebidanan');
  Route::post('sirs/rl/kebidanan', 'RlController@kebidananFilter');

  Route::get('kegiatan-pelayanan-khusus', 'RlController@pelayanan_khusus');
  Route::post('kegiatan-pelayanan-khusus', 'RlController@pelayanan_khususBytaggal');

  Route::get('kegiatan-cara-bayar', 'RlController@cara_bayar');
  Route::post('kegiatan-cara-bayar', 'RlController@cara_bayarBytaggal');

  Route::get('kegiatan-pengujung', 'RlController@kegiatan_pengujung');
  Route::post('kegiatan-pengujung', 'RlController@kegiatan_pengujungBytaggal');

  Route::get('sirs/rl/perinatologi', 'RlController@perinatologi');
  Route::post('sirs/rl/perinatologi', 'RlController@perinatologiFilter');

  Route::get('kegiatan-keluarga-berencana', 'RlController@keluarga_berencana');
  Route::post('kegiatan-keluarga-berencana', 'RlController@keluarga_berencanaBytaggal');

  Route::get('rl-pemakaian-obat', 'RlController@pemakaianObat');
  Route::post('rl-pemakaian-obat', 'RlController@pemakaianObat_byTanggal');

  Route::get('rl-jumlah-obat', 'RlController@jumlahObat');

  Route::get('sirs/rl/laporan-tb', 'SirsRlController@laporanTb');
  Route::get('sirs/rl/laporan-tb-irj', 'SirsRlController@laporanTbIrj');
  Route::post('sirs/rl/laporan-tb-irj', 'SirsRlController@laporanTbIrjByTanggal');
  Route::get('sirs/rl/laporan-tb-igd', 'SirsRlController@laporanTbIgd');
  Route::post('sirs/rl/laporan-tb-igd', 'SirsRlController@laporanTbIgdByTanggal');
  Route::get('sirs/rl/laporan-morbiditas', 'SirsRlController@laporanMorbiditas')->name('laporan.morbiditas');
  Route::post('/sirs/get-poli-kamar', 'SirsRlController@getPoliOrKamar')->name('get.poli.kamar');
  Route::match(['get', 'post'], 'sirs/rl/filter-morbiditas', 'SirsRlController@filtermorbiditas')->name('filter.morbiditas');
  Route::match(['get', 'post'], 'sirs/rl/filter-dbd', 'SirsRlController@filterDBD')->name('filter.filterDBD');
  Route::match(['get', 'post'], 'sirs/rl/filter-icd', 'SirsRlController@filterICD')->name('filter.filterICD');
  Route::match(['get', 'post'], 'sirs/rl/filter-special-attention-diseases', 'SirsRlController@filterKekhususan')->name('filter.filterKeKhususan');
  Route::get('sirs/rl/laporan-tb-irna', 'SirsRlController@laporanTbIrna');
  Route::post('sirs/rl/laporan-tb-irna', 'SirsRlController@laporanTbIrnaByTanggal');
  Route::get('sirs/rl/laporan-db', 'SirsRlController@laporanDB');
  Route::post('sirs/rl/laporan-db', 'SirsRlController@laporanDBByTanggal');
  Route::get('sirs/rl/laporan-pengisian-emr-dokter', 'SirsRlController@laporanEmrDokter');
  Route::post('sirs/rl/laporan-pengisian-emr-dokter', 'SirsRlController@laporanEmrDokterByTanggal');
  Route::get('sirs/rl/laporan-pengisian-emr-perawat', 'SirsRlController@laporanEmrPerawat');
  Route::post('sirs/rl/laporan-pengisian-emr-perawat', 'SirsRlController@laporanEmrPerawatByTanggal');
  Route::get('sirs/rl/laporan-evaluasi-emr-dokter', 'SirsRlController@laporanEvaluasiEmrDokter');
  Route::post('sirs/rl/laporan-evaluasi-emr-dokter', 'SirsRlController@laporanEvaluasiEmrDokterByTanggal');
  Route::get('sirs/rl/laporan-restriksi-obat', 'SirsRlController@restriksiObat');
  Route::post('sirs/rl/laporan-restriksi-obat', 'SirsRlController@restriksiObatBy');

  Route::get('sirs/rl/get-perawat', 'SirsRlController@getPerawat');
});
