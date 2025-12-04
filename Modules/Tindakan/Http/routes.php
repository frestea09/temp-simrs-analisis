<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'tindakan', 'namespace' => 'Modules\Tindakan\Http\Controllers'], function () {
	//Rawat Jalan
	Route::get('/update-histori-kunjungan-irj/{o}', 'TindakanController@updateKunjunganIrj');
	Route::get('/', 'TindakanController@index')->name('tindakan');
	Route::post('/', 'TindakanController@index_byTanggal')->name('tindakan');
	Route::get('/order-poli/{reg}/{pas}', 'TindakanController@orderPoli');
	Route::post('/poli-ordered', 'TindakanController@poliOrdered');
	Route::get('/entry/{idreg}/{idpasien}/{idhistori?}', 'TindakanController@entry')->name('tindakan.entry');
	Route::post('/search', 'TindakanController@search')->name('tindakan.search');
	Route::post('/saveTindakan', 'TindakanController@saveTindakan')->name('tindakan.save');
	Route::post('/kondisiakhir', 'TindakanController@kondisi_akhir_pasien')->name('tindakan.kondisiakhir');
	Route::get('/ajax', 'TindakanController@view_ajax');
	Route::get('/labJalan/{id}', 'TindakanController@labJalan');
	Route::get('/radJalan/{id}', 'TindakanController@radJalan');
	Route::post('/simpanLabJalan', 'TindakanController@simpanLabJalan');
	Route::post('/simpanRadJalan', 'TindakanController@simpanRadJalan');
	Route::get('/cetak-sbpk/{id}', 'TindakanController@cetakSBPK');
	Route::get('/cetak-sip/{id}', 'TindakanController@cetakSIP');
	Route::get('/cetak-suspek/{id}', 'TindakanController@cetakSUSPEK');
	Route::get('/cetak-gelang/{id}', 'TindakanController@cetakGelang');

	Route::get('/lis/{id}', 'TindakanController@lis');
	Route::post('/saveLis', 'TindakanController@saveLis')->name('tindakan.save_lis');

	//IGD
	Route::get('/igd', 'TindakanController@tindakanIGD')->name('tindakan.igd');
	Route::post('/igd', 'TindakanController@tindakanIGD_byTanggal')->name('tindakan.igd');
	Route::get('/ajaxigd', 'TindakanController@ajax_tindakanIGD');
	Route::get('/igd/ubah-status-ugd/{registrasi_id}/{status_ugd}', 'TindakanController@ubahStatusUGD');
	Route::get('/labIGD/{id}', 'TindakanController@labIGD');
	Route::get('/radIGD/{id}', 'TindakanController@radIGD');
	Route::get('/labIgd/{id}', 'TindakanController@labIgd');
	Route::get('/radIgd/{id}', 'TindakanController@radIgd');
	Route::post('/simpanLabIgd', 'TindakanController@simpanLabIgd');
	Route::post('/simpanRadIgd', 'TindakanController@simpanRadIgd');

	//Hapus Tindakan
	Route::get('/hapus-tindakan/{id}/{idreg}/{pasien_id}', 'TindakanController@hapusTindakan');

	//Update Cara Bayar Tindakan
	Route::get('/updateCaraBayar/{id}/{cara_bayar}', 'TindakanController@updateCaraBayar');

	//Pilih Tarif Kategori
	Route::get('getTarif/{kategoritarif_id}', 'TindakanController@getTarif');

	//Verifikasi Tindakan
	Route::get('/verifikasi-rj', 'TindakanController@verifikasiRJ');
	Route::get('/detail-verifikasi-rj/{registrasi_id}', 'TindakanController@detailVerifikasiRJ');
	Route::post('/save-verifikasi-rj', 'TindakanController@saveVerifikasiRJ');

	Route::get('/cetak-rincian-tindakan/{registrasi_id}', 'TindakanController@cetakTindakanIGD');
	Route::get('/cetak-rincian-tindakan-rawatjalan/{registrasi_id}', 'TindakanController@cetakTindakanRawatJalan');

	Route::post('lunas', 'TindakanController@lunaskanTindakan');
	Route::post('belumLunas', 'TindakanController@belumLunas');

	// tindakan sinkron inhealth
	Route::post('inhealth/{id}', 'TindakanController@sinkronTindakanInhealth');

	// E-Resep
	Route::get('e-resep/show/{reg_id}', 'TindakanController@getRegistrasi');
	Route::post('e-resep/save-detail', 'TindakanController@saveDetailResep');
	Route::get('e-resep/paket/{id}', 'TindakanController@getPaketFarmasi');
	Route::post('e-resep/save-detail-igd', 'TindakanController@saveDetailResepIGD');
	Route::delete('e-resep/detail/{id}/delete', 'TindakanController@deleteDetailResep');
	Route::post('e-resep/detail/editQty/{id}', 'TindakanController@editQtyDetailResep');
	Route::post('e-resep/detail/editSigna/{id}', 'TindakanController@editSigna');
	
	Route::post('e-resep/save-resep', 'TindakanController@saveResep');
	Route::post('e-resep/save-resep-duplicate', 'TindakanController@saveResepDuplicate');
	Route::post('e-resep/save-resep-duplicate-next', 'TindakanController@saveResepDuplicateNext');

	Route::get('e-resep/history/{reg_id}', 'TindakanController@getHistoryResep');

	// Inap
	Route::post('/simpanRadInap', 'TindakanController@simpanRadInap');
	Route::post('/simpanLabInap', 'TindakanController@simpanLabInap');

	Route::get('/ajax-tindakan/{status_reg}/{kelas_id?}', 'TindakanController@ajaxTindakan');
	Route::get('/ajax-tindakan-lis/{status_reg}', 'TindakanController@ajaxTindakanLis');
	Route::get('/ajax-tindakan-lab/{status_reg}', 'TindakanController@ajaxTindakanLab');
	Route::get('/ajax-tindakan-lab-common/{status_reg}', 'TindakanController@ajaxTindakanLabCommon');
	Route::get('/ajax-tindakan-operasi/{kelas_id?}', 'TindakanController@ajaxTindakanOperasi');

	// CARI PASIEN
	Route::get('cari-pasien', 'TindakanController@cariPasien');
	Route::post('cari-pasien', 'TindakanController@cariPasienProses');

	// Obat Kronis
	Route::get('cetak-rincian-biaya-kronis/{registrasi_id}', 'TindakanController@cetakRincianBiayaKronis');
	Route::get('cetak-rincian-biaya-non-kronis/{registrasi_id}', 'TindakanController@cetakRincianBiayaNonKronis');

	// Cetak Kontrol
	Route::get('cetak-kontrol/{registrasi_id}', 'TindakanController@kontrolPrint');
});
