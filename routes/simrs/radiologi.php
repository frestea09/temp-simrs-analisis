<?php

Route::group(['middleware' => ['web', 'auth']], function () {

	//tindakanIRJ
	Route::get('radiologi/tindakan-irj', 'RadiologiController@tindakanIRJ');
	Route::post('radiologi/tindakan-irj', 'RadiologiController@tindakanIRJByTanggal');
	Route::get('radiologi/entry-tindakan-irj/{idreg}/{idpasien}', 'RadiologiController@entryTindakanIRJ');
	Route::post('radiologi/save-tindakan', 'RadiologiController@saveTindakan');
	Route::get('radiologi/cetakRincianRad/{unit}/{registrasi_id}', 'RadiologiController@cetakRincianRad');

	Route::post('radiologi/searchpasien', 'RadiologiController@searchPasien');
	Route::post('radiologi/saveRadiologiLangsung/{id_pasien}', 'RadiologiController@simpanTransaksiLangsungLama');

	//Insert Kunjungan
	Route::get('radiologi/insert-kunjungan/{registrasi_id}/{pasien_id?}', 'RadiologiController@insertKunjungan');

	//Insert Expertise
	Route::get('radiologi/entry-expertise-irj/{registrasi_id}/{id}/{tarif_id}', 'RadiologiController@entryExpertiseIRJ');
	Route::get('radiologi/entry-expertise-igd/{registrasi_id}/{id}/{tarif_id}', 'RadiologiController@entryExpertiseIGD');
	Route::get('radiologi/entry-expertise-irna/{registrasi_id}/{id}/{tarif_id}', 'RadiologiController@entryExpertiseIRNA');
	Route::post('radiologi/save-ekspertise', 'RadiologiController@saveEkpertisePasien');
	// expertise satu-satu
	Route::get('radiologi/tambah-ekspertise/{registrasi_id}', 'RadiologiController@detailEkspertise');


	//tindakanIGD
	Route::get('radiologi/tindakan-ird', 'RadiologiController@tindakanIRD');
	Route::post('radiologi/tindakan-ird', 'RadiologiController@tindakanIRDByTanggal');

	//tindakanIRNA
	Route::get('radiologi/tindakan-irna', 'RadiologiController@tindakanIRNA');
	Route::post('radiologi/tindakan-irna', 'RadiologiController@tindakanIRNAByTanggal');
	Route::get('radiologi/entry-tindakan-irna/{idreg}/{idpasien}', 'RadiologiController@entryTindakanIRNA');

	//pasien Sudah Pulang
	Route::get('radiologi/pasien-sudah-pulang', 'RadiologiController@sudahPulang');
	Route::post('radiologi/pasien-sudah-pulang', 'RadiologiController@sudahPulangByTanggal');

	//Pencarian Pasien
	Route::get('radiologi/pencarian-pasien', 'RadiologiController@pencarianPasien');
	Route::post('radiologi/pencarian-pasien', 'RadiologiController@pencarianPasienByTanggal');

	// radiologi tindakan
	Route::get('radiologi/tindakan/{id}', 'RadiologiController@getTindakanRadiologi');
	Route::get('radiologi/diagnosa/{id}', 'RadiologiController@getDiagnosaRadiologi');
	Route::get('radiologi/no_foto/{id}', 'RadiologiController@getNoFotoRadiologi');
	Route::get('radiologi/dokter/{id}', 'RadiologiController@getDokter');

	Route::view('radiologi/billing', 'radiologi.billing');
	Route::view('radiologi/template', 'radiologi.template');
	Route::view('radiologi/hasil', 'radiologi.hasil');
	Route::view('radiologi/laporan', 'radiologi.laporan');

	Route::view('radiologi/template', 'radiologi.hasil_radiologi');

	Route::get('radiologi/cetak-ekpertise/{id}/{registrasi_id}/{folio_id?}', 'RadiologiController@cetakEkspertise');
	Route::post('radiologi/hapus-ekpertise/{id}', 'RadiologiController@hapusEkspertise');
	Route::get('radiologi/cetak-ekpertise-eklaim/{id}/{registrasi_id}', 'RadiologiController@cetakEkspertiseEklaim');
	// PACS
	Route::get('radiologi/cetak-ekpertise-pacs/{id}', 'RadiologiController@cetakEkspertisePacs');
	
	Route::get('radiologi/cetak-ekpertise-vedika/{registrasi_id}', 'RadiologiController@cetakEkspertiseVedika');
	
	// Lihat Hasil Ekspertise di Pengorder
	Route::get('radiologi/ekspertise-pasien/{id}', 'RadiologiController@lihatHasil');

	//LAPORAN KUNJUNGAN
	Route::get('radiologi/laporan-kunjungan', 'RadiologiController@lap_kunjungan');
	Route::post('radiologi/laporan-kunjungan', 'RadiologiController@lap_kunjungan_by_request');

	//Transaksi Langsung
	Route::get('radiologi/transaksi-langsung', 'RadiologiController@transaksiLangsung');
	Route::post('radiologi/transaksi-langsung', 'RadiologiController@tindakanLangsungBytanggal');
	Route::post('radiologi/simpan-transaksi-langsung', 'RadiologiController@simpanTransaksiLangsung');
	Route::get('radiologi/cetak-langsung-ekpertise/{id}', 'RadiologiController@cetakEkspertiseLangsung');
	Route::get('radiologi/entry-transaksi-langsung/{registrasi_id}', 'RadiologiController@entryTindakanLangsung');
	Route::get('radiologi/cetakRadLangsung/{registrasi_id}', 'RadiologiController@transaksiCetak');

	//Hapus Tindakan
	Route::get('radiologi/hapus-tindakan/{id}/{registrasi_id}/{pasien_id}', 'RadiologiController@hapusTindakan');

	//Ekspertise Get Rajal
	Route::get('radiologi/ekspertise/{registrasi_id}', 'RadiologiController@ekspertise');
	Route::get('radiologi/ekspertise/{registrasi_id}/{id}', 'RadiologiController@ekspertiseBaru');
	Route::get('radiologi/ekspertise-langsung/{registrasi_id}', 'RadiologiController@ekspertise_langsung');
	Route::post('radiologi/ekspertise/', 'RadiologiController@saveEkpertise');
	Route::post('radiologi/ekspertise-baru', 'RadiologiController@saveEkpertiseBaru');

	//Ekspertise Get IGD
	Route::get('radiologi/igd/{registrasi_id}', 'RadiologiController@ekspertise_igd');

	//Ekspertise Get IRNA
	Route::get('radiologi/irna/{registrasi_id}', 'RadiologiController@ekspertise_irna');

	//Laporan Kinerja
	Route::get('radiologi/laporan-kinerja', 'RadiologiController@laporanKinerja');
	Route::post('radiologi/laporan-kinerja', 'RadiologiController@laporanKinerjaByRequest');


	//  CARI PASIEN
	Route::get('radiologi/cari-pasien', 'RadiologiController@cariPasien');
	Route::post('radiologi/cari-pasien', 'RadiologiController@cariPasienProses');

	Route::get('radiologi/cari-pasien-perawat', 'RadiologiController@cariPasienPerawat');
	Route::post('radiologi/cari-pasien-perawat', 'RadiologiController@cariPasienProsesPerawat');
	
	// TTE
	Route::post('radiologi/tte-ekspertise/{id}', 'RadiologiController@tteEkspertise');
	Route::get('radiologi/ekspertis-pdf-tte/{id}', 'RadiologiController@cetakTteEkspertise');

	//catatan
	Route::get('radiologi/catatan-pasien/{registrasi_id}', 'RadiologiController@Order');
	Route::get('radiologi/showNote/{id}', 'RadiologiController@showCatatan');
	Route::post('radiologi/updateNote/{id}', 'RadiologiController@upadateCatatan');

	Route::get('radiologi/showNoteEmr/{id}', 'RadiologiController@showCatatanEmr');
	Route::post('radiologi/updateNoteEmr/{id}', 'RadiologiController@upadateCatatanEmr');

	Route::get('radiologi/showNoteReg/{id}', 'RadiologiController@showCatatanReg');
	Route::post('radiologi/updateNoteReg/{id}', 'RadiologiController@upadateCatatanReg');

	//hasil radiologi
	Route::get('radiologi/hasil-radiologi', 'RadiologiController@radiologiHasil');
	Route::post('radiologi/hasil-radiologi', 'RadiologiController@radiologiHasilBytanggal');


	Route::get('/radiologi/notif/', 'RadiologiController@notif')->name('radiologi.notif');
	Route::get('radiologi/proses-periksa/{folioId}', 'RadiologiController@prosesPeriksa');

	Route::get('radiologi/terbilling', 'RadiologiController@radiologiTerbilling');
	Route::post('radiologi/terbilling', 'RadiologiController@radiologiTerbillingBytanggal');
	Route::get('/radiologi/view-rad/{registrasi_id}', 'RadiologiController@viewrad');
	Route::post('/radiologi/edit-rad/{id}/{radiografer_id}', 'RadiologiController@editrad');
	Route::post('/radiologi/edit-dok/{id}/{dokter_id}', 'RadiologiController@editdok');


	Route::get('radiologi/create-ekspertise/{registrasi_id}/{id}', 'RadiologiController@createEkspertise');
	Route::get('radiologi/edit-ekpertise/{id}/{registrasi_id}', 'RadiologiController@editEkspertise');


	Route::get('radiologi/getDetailTemplate/{id}', 'RadiologiController@getDetailTemplate');
	Route::post('radiologi/deleteDetailTemplate/{id}', 'RadiologiController@deleteDetailTemplate');
	Route::post('radiologi/editDetailTemplate/{id}', 'RadiologiController@editDetailTemplate');

	Route::get('/radiologi/dokter/{id}', 'RadiologiController@getDokterById');

	Route::get('radiologi/history-lab/{pasienId}', 'RadiologiController@historyLab');

	Route::get('radiologi/antrian-rad', 'RadiologiController@antrianRad');
    Route::get('radiologi/antrian-belum-periksa', 'RadiologiController@radBelumPeriksa');
    Route::get('radiologi/antrian-sudah-periksa', 'RadiologiController@radSudahPeriksa');
    Route::get('radiologi/tandai-selesai/{id}', 'RadiologiController@markAsDone');
	
	Route::get('radiologi/display/antrian', 'RadiologiController@display');
	Route::get('/radiologi/data-lcd-antrian-pasien', 'RadiologiController@datalcdantrianpasien')->name('radiologi.data_lcd_antrian_pasien');

	Route::get('radiologi/panggil-antrian/{nomor}/{id}/{regId}', 'RadiologiController@panggilAntrian');
});
