<?php
Route::group(['middleware' => ['web', 'auth']], function () {

	Route::view('farmasi/master', 'farmasi.master');
	Route::view('farmasi/penjualan', 'farmasi.penjualan');
	Route::view('farmasi/distribusi', 'farmasi.distribusi');
	Route::view('farmasi/reture-penjualan', 'farmasi.reture-penjualan');
	Route::view('farmasi/laporan', 'farmasi.laporan');
	Route::view('farmasi/laporan-kronis', 'farmasi.laporan.kronis');
	Route::view('farmasi/laporan-non-kronis', 'farmasi.laporan.non-kronis');

	Route::view('farmasi/eresep', 'farmasi.eresep');
	Route::view('farmasi/display-eresep', 'farmasi.display-eresep');
	Route::view('farmasi/suara-eresep', 'farmasi.suara-eresep');
	Route::view('farmasi/eresep-validasi', 'farmasi.eresep-validasi');

	// laporan
	Route::get('farmasi/laporan/laporan-penggunaan-obat-irj', 'FarmasiController@laporanPenggunaanObatIrj');
	Route::post('farmasi/laporan/laporan-penggunaan-obat-irj', 'FarmasiController@filterPenggunaanObatIrj');

	Route::get('farmasi/laporan/laporan-penggunaan-obat-irna', 'FarmasiController@laporanPenggunaanObatIrna');
	Route::post('farmasi/laporan/laporan-penggunaan-obat-irna', 'FarmasiController@filterPenggunaanObatIrna');

	Route::get('farmasi/laporan/laporan-penggunaan-obat-radar', 'FarmasiController@laporanPenggunaanObatIgd');
	Route::post('farmasi/laporan/laporan-penggunaan-obat-radar', 'FarmasiController@filterPenggunaanObatIgd');

	// Laporan Pengunaan Obat
	Route::get('farmasi/laporan-expired-date', 'FarmasiLaporanController@lapExpiredDate');
	Route::post('farmasi/laporan-expired-date', 'FarmasiLaporanController@lapExpiredDateExcel');

	Route::get('farmasi/updateDetail', 'FarmasiController@updateDetail');
	Route::get('farmasi/updateFolios', 'FarmasiController@updateFolios');
	Route::get('farmasi/onDtl', 'FarmasiController@onDtl');

	//Master Etiket
	Route::get('farmasi/etiket', 'EtiketController@index');
	Route::get('farmasi/etiket/create', 'EtiketController@create');
	Route::post('farmasi/etiket/store', 'EtiketController@store');
	Route::get('farmasi/etiket/{id}/edit', 'EtiketController@edit');
	Route::put('farmasi/etiket/update/{id}', 'EtiketController@update');
	Route::post('farmasi/etiket/delete/{id}', 'EtiketController@destroy');

	//laporan
	Route::post('farmasi/laporan/periodetanggal', 'FarmasiController@periodeTanggal');
	Route::get('farmasi/laporan/penjualan/', 'FarmasiController@lap_farmasi');
	Route::post('farmasi/laporan/penjualan/', 'FarmasiController@lap_farmasi_byTanggal');
	Route::get('farmasi/laporan/etiket/{penjualan_id}', 'FarmasiController@cetak_etiket');
	Route::get('farmasi/laporan/etiket2/{penjualan_id}', 'FarmasiController@cetak_etiket2');
	Route::get('farmasi/laporan/infus/{penjualan_id}', 'FarmasiController@cetak_infus');
	Route::get('farmasi/laporan/hapus/{no_resep}', 'FarmasiController@hapusLaporan');
	//Cetak FAKTUR
	Route::get('farmasi/cetak-detail/{penjualan_id}', 'FarmasiController@cetakDetail');
	Route::get('farmasi/cetak-detail-operasi/{penjualan_id}', 'FarmasiController@cetakDetailOperasi');
	Route::get('farmasi/cetak-detail-vedika/{penjualan_id}', 'FarmasiController@cetakDetailVedika');
	Route::get('farmasi/cetak-fakturkronis/{penjualan_id}', 'FarmasiController@cetakDetailKronis');
	Route::get('farmasi/cetak-detail-bebas/{penjualan_id}', 'FarmasiController@cetakDetailBebas');
	
	Route::get('farmasi/proses-ulang-eresep', 'FarmasiController@prosesUlangEresep');
	Route::post('farmasi/proses-ulang-eresep-by-tgl', 'FarmasiController@prosesUlangEresepByTgl');
	
	Route::get('farmasi/eresep-cetak', 'FarmasiController@eresepCetak');
	Route::post('farmasi/eresep-cetak-by-tgl', 'FarmasiController@eresepCetakByTgl');
	Route::get('farmasi/eresep-print/{id}', 'FarmasiController@eresepPrint');
	Route::get('farmasi/get-eresep-cetak-belum-panggil', 'FarmasiController@getDataEresepCetakBelumPanggil');
	Route::get('farmasi/get-eresep-cetak-sudah-panggil', 'FarmasiController@getDataEresepCetakSudahPanggil');

	Route::get('farmasi/laporan/etiketbebas/{penjualan_id}', 'FarmasiController@cetak_etiket_bebas');

	//LAPORAN KINERJA FARMASI
	Route::get('farmasi/laporan-kinerja', 'FarmasiController@laporanKinerjaFarmasi');
	Route::post('farmasi/laporan-kinerja', 'FarmasiController@dataLaporanKinerjaFarmasi');


	//LAPORAN RESEP
	Route::get('farmasi/laporan-resep', 'FarmasiController@laporanResepFarmasi');
	Route::post('farmasi/laporan-resep', 'FarmasiController@dataLaporanResepFarmasi');

    //LAPORAN RESEPPNSE TIME
	Route::get('farmasi/laporan-response-time', 'FarmasiController@laporanResponseTime');
	Route::post('farmasi/laporan-response-time', 'FarmasiController@filterLaporanResponseTime');

	//LAPORAN ERESEP
	Route::get('farmasi/laporan-eresep', 'FarmasiController@laporanEresep');
	Route::post('farmasi/laporan-eresep', 'FarmasiController@filterLaporanEresep');

	//cetak kronis
	Route::get('farmasi/cetak-baru-fakturkronis/{penjualan_id}', 'FarmasiController@cetakDetailKronisBaru');
	Route::get('farmasi/cetak-detail-baru/{penjualan_id}', 'FarmasiController@cetakDetailBaru');
	Route::get('farmasi/cetak-detail-bebas-baru/{penjualan_id}', 'FarmasiController@cetakDetailBebasBaru');

	Route::get('farmasi/laporan/pemakaian-obat', 'FarmasiController@pemakaian_obat');
	Route::post('farmasi/laporan/pemakaian-obat', 'FarmasiController@pemakaian_obat_byTanggal');

	//Laporan Pemakaian Harian
	Route::get('farmasi/laporan/pemakaian-obat-harian', 'FarmasiController@pemakaian_obat_harian');
	Route::post('farmasi/laporan/pemakaian-obat-harian', 'FarmasiController@pemakaian_obat_byTanggal_harian');
	Route::get('farmasi/laporan/pemakaian-obat-harian-narkotika', 'FarmasiController@pemakaian_obat_harian_narkotika');
	Route::post('farmasi/laporan/pemakaian-obat-harian-narkotika', 'FarmasiController@pemakaian_obat_narkotika_byTanggal');
	Route::get('farmasi/laporan/pemakaian-obat-harian-highalert', 'FarmasiController@pemakaian_obat_harian_highalert');
	Route::post('farmasi/laporan/pemakaian-obat-harian-highalert', 'FarmasiController@pemakaian_obat_highalert_byTanggal');
	Route::get('farmasi/laporan/pemakaian-obat-harian-generik', 'FarmasiController@pemakaian_obat_harian_generik');
	Route::post('farmasi/laporan/pemakaian-obat-harian-generik', 'FarmasiController@pemakaian_obat_generik_byTanggal');
	Route::get('farmasi/laporan/pemakaian-obat-harian-psikotropika', 'FarmasiController@pemakaian_obat_harian_psikotropika');
	Route::post('farmasi/laporan/pemakaian-obat-harian-psikotropika', 'FarmasiController@pemakaian_obat_psikotropika_byTanggal');
	
	Route::get('farmasi/laporan/pemakaian-obat-harian-antibiotik', 'FarmasiController@pemakaian_obat_harian_antibiotik');
	Route::post('farmasi/laporan/pemakaian-obat-harian-antibiotik', 'FarmasiController@pemakaian_obat_antibiotik_byTanggal');

	Route::get('farmasi/laporan-kronis', 'FarmasiController@laporanKronis');
	Route::post('farmasi/laporan-kronis', 'FarmasiController@laporanKronis_byTanggal');

	// E-Resep Belum tervalidasi
	Route::get('/farmasi/data-lcd-eresep/{unit?}', 'FarmasiController@datalcderesep')->name('farmasi.data_lcd_eresep');
	Route::get('/farmasi/lcd-eresep/{unit?}', 'FarmasiController@lcderesep');

	// E-Resep Display To Pasien
	// Route::get('/farmasi/display-data-lcd-eresep/{unit?}', 'FarmasiController@displaydatalcderesep')->name('farmasi.display_data_lcd_eresep');
	// Route::get('/display/eresep/{unit?}', 'FarmasiController@displaylcderesep');
	
	


	// E-Resep Tervalidasi
	Route::get('/farmasi/validasi-data-lcd-eresep/{unit?}', 'FarmasiController@validasidatalcderesep')->name('farmasi.validasi_data_lcd_eresep');
	Route::get('/farmasi/validasi-lcd-eresep/{unit?}', 'FarmasiController@validasilcderesep');

	Route::get('/farmasi/proses-eresep/{eresep_id}', 'FarmasiController@prosesEresep');
	Route::get('farmasi/cetak-eresep/{penjualan_id}', 'FarmasiController@cetakEresep');
	Route::get('farmasi/cetak-eresep-tte/{penjualan_id}', 'FarmasiController@cetakEresepTTE');
	Route::get('farmasi/cetak-antrian-eresep/{id}', 'FarmasiController@cetakAntrianEresep');
	Route::get('farmasi/panggil-antrian/{id}', 'FarmasiController@panggilAntrianEresep');

	Route::get('farmasi/tte-eresep/{penjualan_id}', 'FarmasiController@tteEresep');
	Route::get('farmasi/eresep/pdf-cek-tte/{regId}/{penjualan_id}', 'FarmasiController@eresepCek');
	Route::get('farmasi/eresep-bertte/{penjualan_id}', 'FarmasiController@EresepTTE');

	//Form Lepasan
	Route::get('farmasi/form-lepasan-obat', 'FarmasiController@formLepasanObat');
	Route::post('farmasi/form-lepasan-obat', 'FarmasiController@formLepasanObat');
	Route::get('farmasi/get-lepasan-rekonsiliasi/{tga}/{tgb}', 'FarmasiController@getLepasanRekonsiliasi');
	Route::get('farmasi/get-lepasan-obatalergi/{tga}/{tgb}', 'FarmasiController@getLepasanObatalergi');
	
});
