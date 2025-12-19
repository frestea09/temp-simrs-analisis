<?php
// Master
Route::group(['middleware' => ['web', 'auth', 'role:laboratorium|administrator']], function () {
	Route::resource('labsection', 'LabsectionController');
	Route::resource('labkategori', 'LabkategoriController');
	Route::resource('lab', 'LaboratoriumController');

	//Hapus LabSection
	Route::get('laboratorium/hapus-lapsection/{id}', 'LaboratoriumController@hapusLabSection');

	//Hapus LabLKategori
	Route::get('laboratorium/hapus-lapkategori/{id}', 'LaboratoriumController@hapusLabKategori');

	// CARI PASIEN
	Route::get('laboratorium/cari-pasien', 'LaboratoriumController@cariPasien');
	Route::post('laboratorium/cari-pasien', 'LaboratoriumController@cariPasienProses');


	// ==========================================================
	Route::view('laboratorium/billing', 'laboratorium.billing');
	Route::view('laboratorium/hasil', 'laboratorium.hasil');
	Route::view('laboratorium/master', 'laboratorium.master');
	Route::view('laboratorium/laporan', 'laboratorium.laporan');
	Route::view('laboratorium/antrian-lab', 'laboratorium.antrian');

	Route::get('laboratorium/insert-kunjungan/{registrasi_id}/{pasien_id}', 'LaboratoriumController@insertKunjungan');

	//tindakan
	Route::get('laboratorium/tindakan-irj', 'LaboratoriumController@tindakanIRJ');
	Route::get('laboratorium/list-lis/{registrasi_id}', 'LaboratoriumController@listLis');
	Route::post('laboratorium/tindakan-irj', 'LaboratoriumController@tindakanIRJByTanggal');
	Route::get('laboratorium/tindakan-ird', 'LaboratoriumController@tindakanIRD');
	Route::post('laboratorium/tindakan-ird', 'LaboratoriumController@tindakanIRDByTanggal');
	Route::get('laboratorium/tindakan-cetak/{registrasi_id}', 'LaboratoriumController@tindakanCetak');
	Route::get('laboratorium/cetakLab/{registrasi_id}', 'LaboratoriumController@cetakLab');

	Route::get('laboratorium/registered', 'LaboratoriumController@registered');
	Route::post('laboratorium/registered', 'LaboratoriumController@registeredByTanggal');
	Route::get('laboratorium/data-registered', 'LaboratoriumController@dataRegistered');

	Route::get('laboratorium/tindakan-irna', 'LaboratoriumController@tindakanIRNA');
	Route::post('laboratorium/tindakan-irna', 'LaboratoriumController@tindakanIRNAByTanggal');

	Route::get('laboratorium/insert-kunjungan/{registrasi_id}/{pasien_id}', 'LaboratoriumController@insertKunjungan');

	Route::get('laboratorium/entry-tindakan-irj/{idreg}/{idpasien}', 'LaboratoriumController@entryTindakanIRJ')->name('entry.tindakan.irj');
	Route::get('laboratorium/entry-tindakan-irj-new/{idreg}/{idpasien}', 'LaboratoriumController@entryTindakanIRJNew')->name('entry.tindakan.irj.new');
	Route::post('laboratorium/save-tindakan', 'LaboratoriumController@saveTindakan');
	Route::post('laboratorium/kirim-tindakan-lis', 'LaboratoriumController@kirimLis');
	Route::post('laboratorium/kirim-tindakan-lis-pasien-langsung', 'LaboratoriumController@kirimLisLangsung');
	Route::post('laboratorium/save-tindakan-new', 'LaboratoriumController@saveTindakanNew');
	Route::post('laboratorium/save-tindakan-langsung', 'LaboratoriumController@saveTindakanLangsung');
	// Route::get('laboratorium/hapus-tindakan/{id}', 'LaboratoriumController@saveTindakan');

	Route::get('laboratorium/entry-tindakan-irna/{idreg}/{idpasien}', 'LaboratoriumController@entryTindakanIRNA')->name('entry.tindakan.irna');
	Route::get('laboratorium/entry-tindakan-irna-new/{idreg}/{idpasien}', 'LaboratoriumController@entryTindakanIRNAnew')->name('entry.tindakan.irna.new');

	//TINDAKAN LANGSUNG
	Route::get('laboratorium/entry-tindakan-langsung/', 'LaboratoriumController@tindakanLangsung');
	Route::post('laboratorium/entry-tindakan-langsung', 'LaboratoriumController@tindakanLangsungBytanggal');
	Route::post('laboratorium/simpan-transaksi-langsung/', 'LaboratoriumController@simpanTransaksiLangsung');
	Route::get('laboratorium/entry-transaksi-langsung/{registrasi_id}', 'LaboratoriumController@entryTindakanLangsung');
	Route::post('laboratorium/searchpasien', 'LaboratoriumController@searchPasien');
	Route::get('laboratorium/saveLaborLangsung/{id_pasien}', 'LaboratoriumController@simpanTransaksiLangsungLama');

	//Hapus tindakan IRJ
	Route::get('laboratorium/hapus-tindakan-irj/{id}/{registrasi_id}/{pasien_id}', 'LaboratoriumController@hapusTindakanIRJ');

	//CETAK RINCIAN LAB
	Route::get('laboratorium/cetakRincianLab/{unit}/{registrasi_id}', 'LaboratoriumController@cetakRincianLab');
	Route::get('laboratorium/cetakRincianLab-pertgl/{unit}/{registrasi_id}/{tgl}', 'LaboratoriumController@cetakRincianLabPerTgl');
	
	// Cetak tindakan lab
	Route::get('laboratorium/cetakTindakanLab/{unit}/{registrasi_id}', 'LaboratoriumController@cetakTindakanLab');
	
	// Cetak tindakan persesi
	Route::get('laboratorium/cetakTindakanLab/{order_lab_id}/{unit}/{registrasi_id}', 'LaboratoriumController@cetakTindakanLabPerSesi');
	
	// Tindakan terregistrasi
	Route::get('laboratorium/registered-tindakan/{order_lab_id}/{registrasi_id}/{id_pasien}', 'LaboratoriumController@registeredTindakan')->name('registered.tindakan');

	//LAPORAN RESPONTIME
	Route::get('laboratorium/laporan-respontime', 'LaboratoriumController@lap_respontime');
	Route::post('laboratorium/laporan-respontime', 'LaboratoriumController@lap_respontime_by_request');
	
	//LAPORAN KUNJUNGAN
	Route::get('laboratorium/laporan-kunjungan', 'LaboratoriumController@lap_kunjungan');
	Route::post('laboratorium/laporan-kunjungan', 'LaboratoriumController@lap_kunjungan_by_request');
	
	//LAPORAN KUNJUNGAN PER CARA BAYAR
	Route::get('laboratorium/laporan-kunjungan-cb', 'LaboratoriumController@lap_kunjunganCB');
	Route::post('laboratorium/laporan-kunjungan-cb', 'LaboratoriumController@lap_kunjunganCB_by_request');

	//LAPORAN PEMERIKSAAN
	Route::get('laboratorium/laporan-pemeriksaan', 'LaboratoriumController@lap_pemeriksaan');
	Route::post('laboratorium/laporan-pemeriksaan', 'LaboratoriumController@lap_pemeriksaan_by_request');

	Route::get('laboratorium/laporan-jumlah-pemeriksaan', 'LaboratoriumController@jml_lap_pemeriksaan');
	Route::post('laboratorium/laporan-jumlah-pemeriksaan', 'LaboratoriumController@jml_lap_pemeriksaan_by_request');

	//Laporan Kinerja
	Route::get('laboratorium/laporan-kinerja', 'LaboratoriumController@laporanKinerja');
	Route::post('laboratorium/laporan-kinerja', 'LaboratoriumController@laporanKinerjaByRequest');
	//Bank Darah
	Route::get('laboratorium/laporan-kinerja-bank-darah', 'LaboratoriumController@laporanKinerjaBankDarah');
	Route::post('laboratorium/laporan-kinerja-bank-darah', 'LaboratoriumController@laporanKinerjaBankDarahByRequest');

	//catatan
	Route::get('laboratorium/catatan-pasien/{registrasi_id}', 'LaboratoriumController@Order');

	
	// Test Get Lica
	Route::get('laboratorium/result-lica/{id_lica}', 'LaboratoriumController@getResult');

	Route::get('laboratorium/antrian-lab/{unit?}', 'LaboratoriumController@antrianLab');
    Route::get('laboratorium/antrian-belum-periksa/{unit}', 'LaboratoriumController@labBelumPeriksa');
    Route::get('laboratorium/antrian-sudah-periksa/{unit}', 'LaboratoriumController@labSudahPeriksa');
    Route::get('laboratorium/tandai-selesai/{id}', 'LaboratoriumController@markAsDone');

	Route::get('laboratorium/display/antrian', 'LaboratoriumController@display');
	Route::get('/laboratorium/data-lcd-antrian-pasien', 'LaboratoriumController@datalcdantrianpasien')->name('laboratorium.data_lcd_antrian_pasien');

	Route::get('laboratorium/panggil-antrian/{nomor}/{id}/{regId}', 'LaboratoriumController@panggilAntrian');

	// Mark Done Order lab
	Route::get('laboratorium/mark-order-done/{id_history_order}', 'LaboratoriumController@markDoneOrder');
	Route::post('laboratorium/mark-order-item-done', 'LaboratoriumController@markItemDone');
	// Insert ke billing
	Route::get('laboratorium/insert-to-billing/{id_history_order}', 'LaboratoriumController@insertBilling');
	Route::get('laboratorium/insert-to-billing-item/{id_history_order}/{tarifId}', 'LaboratoriumController@insertBillingPerItem');

	// Hapus histori order lab
	Route::get('laboratorium/histori-delete/{reg_id}/{id}', 'LaboratoriumController@hapusHistoriOrderLab');

});
