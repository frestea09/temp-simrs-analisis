<?php
// Master
Route::group(['middleware' => ['web', 'auth', 'role:laboratorium_patalogi_anatomi']], function () {
	Route::resource('labsection', 'LabsectionController');
	Route::resource('labkategori', 'LabkategoriController');
	Route::resource('lab', 'LaboratoriumControllerCommon');

	//Hapus LabSection
	Route::get('laboratoriumCommon/hapus-lapsection/{id}', 'LaboratoriumControllerCommon@hapusLabSection');

	//Hapus LabLKategori
	Route::get('laboratoriumCommon/hapus-lapkategori/{id}', 'LaboratoriumControllerCommon@hapusLabKategori');


	// ==========================================================
	Route::view('laboratoriumCommon/billing', 'laboratoriumCommon.billing');
	Route::view('laboratoriumCommon/hasil', 'laboratoriumCommon.hasil');
	Route::view('laboratoriumCommon/master', 'laboratoriumCommon.master');
	Route::view('laboratoriumCommon/laporan', 'laboratoriumCommon.laporan');

	Route::get('laboratoriumCommon/insert-kunjungan/{registrasi_id}/{pasien_id}', 'LaboratoriumControllerCommon@insertKunjungan');

	//tindakan
	Route::get('laboratoriumCommon/tindakan-irj', 'LaboratoriumControllerCommon@tindakanIRJ');
	Route::post('laboratoriumCommon/tindakan-irj', 'LaboratoriumControllerCommon@tindakanIRJByTanggal');
	Route::get('laboratoriumCommon/tindakan-ird', 'LaboratoriumControllerCommon@tindakanIRD');
	Route::post('laboratoriumCommon/tindakan-ird', 'LaboratoriumControllerCommon@tindakanIRDByTanggal');
	Route::get('laboratoriumCommon/tindakan-cetak/{registrasi_id}', 'LaboratoriumControllerCommon@tindakanCetak');
	Route::get('laboratoriumCommon/cetakTindakanLab/{order_lab_id}/{unit}/{registrasi_id}', 'LaboratoriumControllerCommon@cetakTindakanLabPerSesi');
	Route::get('laboratoriumCommon/cetakLab/{registrasi_id}', 'LaboratoriumControllerCommon@cetakLab');

	Route::get('laboratoriumCommon/tindakan-irna', 'LaboratoriumControllerCommon@tindakanIRNA');
	Route::post('laboratoriumCommon/tindakan-irna', 'LaboratoriumControllerCommon@tindakanIRNAByTanggal');

	Route::get('laboratoriumCommon/insert-kunjungan/{registrasi_id}/{pasien_id}', 'LaboratoriumControllerCommon@insertKunjungan');

	Route::get('laboratoriumCommon/entry-tindakan-irj/{idreg}/{idpasien}', 'LaboratoriumControllerCommon@entryTindakanIRJ');
	Route::post('laboratoriumCommon/save-tindakan', 'LaboratoriumControllerCommon@saveTindakan');
	// Route::get('laboratoriumCommon/hapus-tindakan/{id}', 'LaboratoriumControllerCommon@saveTindakan');

	Route::get('laboratoriumCommon/entry-tindakan-irna/{idreg}/{idpasien}', 'LaboratoriumControllerCommon@entryTindakanIRNA');

	//TINDAKAN LANGSUNG
	Route::get('laboratoriumCommon/entry-tindakan-langsung/', 'LaboratoriumControllerCommon@tindakanLangsung');
	Route::post('laboratoriumCommon/entry-tindakan-langsung', 'LaboratoriumControllerCommon@tindakanLangsungBytanggal');
	Route::post('laboratoriumCommon/simpan-transaksi-langsung/', 'LaboratoriumControllerCommon@simpanTransaksiLangsung');
	Route::get('laboratoriumCommon/entry-transaksi-langsung/{registrasi_id}', 'LaboratoriumControllerCommon@entryTindakanLangsung');

	//Hapus tindakan IRJ
	Route::get('laboratoriumCommon/hapus-tindakan-irj/{id}/{registrasi_id}/{pasien_id}', 'LaboratoriumControllerCommon@hapusTindakanIRJ');

	//CETAK RINCIAN LAB
	Route::get('laboratoriumCommon/cetakRincianLab/{unit}/{registrasi_id}', 'LaboratoriumControllerCommon@cetakRincianLab');

	//LAPORAN KUNJUNGAN
	Route::get('laboratoriumCommon/laporan-kunjungan', 'LaboratoriumControllerCommon@lap_kunjungan');
	Route::post('laboratoriumCommon/laporan-kunjungan', 'LaboratoriumControllerCommon@lap_kunjungan_by_request');

	//Laporan Kinerja
	Route::get('laboratoriumCommon/laporan-kinerja', 'LaboratoriumControllerCommon@laporanKinerja');
	Route::post('laboratoriumCommon/laporan-kinerja', 'LaboratoriumControllerCommon@laporanKinerjaByRequest');
	//Bank Darah
	Route::get('laboratoriumCommon/laporan-kinerja-bank-darah', 'LaboratoriumControllerCommon@laporanKinerjaBankDarah');
	Route::post('laboratoriumCommon/laporan-kinerja-bank-darah', 'LaboratoriumControllerCommon@laporanKinerjaBankDarahByRequest');

	//catatan
	Route::get('laboratoriumCommon/catatan-pasien/{registrasi_id}', 'LaboratoriumControllerCommon@Order');

	// CARI PASIEN
	Route::get('laboratoriumCommon/cari-pasien', 'LaboratoriumControllerCommon@cariPasien');
	Route::post('laboratoriumCommon/cari-pasien', 'LaboratoriumControllerCommon@cariPasienProses');

	// Hapus
	Route::get('laboratoriumCommon/histori-delete/{reg_id}/{id}', 'LaboratoriumControllerCommon@hapusHistoriOrderLab');

});
