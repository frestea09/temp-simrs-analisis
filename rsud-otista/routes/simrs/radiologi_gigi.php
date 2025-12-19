<?php

Route::group(['middleware' => ['web', 'auth']], function () {

	//tindakanIRJ
	Route::get('radiologi-gigi/tindakan-irj', 'RadiologiGigiController@tindakanIRJ');
	Route::post('radiologi-gigi/tindakan-irj', 'RadiologiGigiController@tindakanIRJByTanggal');
	Route::get('radiologi-gigi/entry-tindakan-irj/{idreg}/{idpasien}', 'RadiologiGigiController@entryTindakanIRJ');
	Route::post('radiologi-gigi/save-tindakan', 'RadiologiGigiController@saveTindakan');
	Route::get('radiologi-gigi/cetakRincianRad/{unit}/{registrasi_id}', 'RadiologiGigiController@cetakRincianRad');

	Route::post('radiologi-gigi/searchpasien', 'RadiologiGigiController@searchPasien');
	Route::post('radiologi-gigi/saveRadiologiLangsung/{id_pasien}', 'RadiologiGigiController@simpanTransaksiLangsungLama');

	//Insert Kunjungan
	Route::get('radiologi-gigi/insert-kunjungan/{registrasi_id}/{pasien_id}', 'RadiologiGigiController@insertKunjungan');

	//Insert Expertise
	Route::get('radiologi-gigi/entry-expertise-irj/{registrasi_id}/{id}/{tarif_id}', 'RadiologiGigiController@entryExpertiseIRJ');
	Route::get('radiologi-gigi/entry-expertise-igd/{registrasi_id}/{id}/{tarif_id}', 'RadiologiGigiController@entryExpertiseIGD');
	Route::get('radiologi-gigi/entry-expertise-irna/{registrasi_id}/{id}/{tarif_id}', 'RadiologiGigiController@entryExpertiseIRNA');
	Route::post('radiologi-gigi/save-ekspertise', 'RadiologiGigiController@saveEkpertisePasien');
	// expertise satu-satu
	Route::get('radiologi-gigi/tambah-ekspertise/{registrasi_id}', 'RadiologiGigiController@detailEkspertise');


	//tindakanIGD
	Route::get('radiologi-gigi/tindakan-ird', 'RadiologiGigiController@tindakanIRD');
	Route::post('radiologi-gigi/tindakan-ird', 'RadiologiGigiController@tindakanIRDByTanggal');

	//tindakanIRNA
	Route::get('radiologi-gigi/tindakan-irna', 'RadiologiGigiController@tindakanIRNA');
	Route::post('radiologi-gigi/tindakan-irna', 'RadiologiGigiController@tindakanIRNAByTanggal');
	Route::get('radiologi-gigi/entry-tindakan-irna/{idreg}/{idpasien}', 'RadiologiGigiController@entryTindakanIRNA');

	//pasien Sudah Pulang
	Route::get('radiologi-gigi/pasien-sudah-pulang', 'RadiologiGigiController@sudahPulang');
	Route::post('radiologi-gigi/pasien-sudah-pulang', 'RadiologiGigiController@sudahPulangByTanggal');

	//Pencarian Pasien
	Route::get('radiologi-gigi/pencarian-pasien', 'RadiologiGigiController@pencarianPasien');
	Route::post('radiologi-gigi/pencarian-pasien', 'RadiologiGigiController@pencarianPasienByTanggal');

	// radiologi tindakan
	Route::get('radiologi-gigi/tindakan/{id}', 'RadiologiGigiController@getTindakanRadiologi');
	Route::get('radiologi-gigi/diagnosa/{id}', 'RadiologiGigiController@getDiagnosaRadiologi');
	Route::get('radiologi-gigi/no_foto/{id}', 'RadiologiGigiController@getNoFotoRadiologi');
	Route::get('radiologi-gigi/dokter/{id}', 'RadiologiGigiController@getDokter');

	Route::view('radiologi-gigi/billing', 'radiologi-gigi.billing');
	Route::view('radiologi-gigi/template', 'radiologi-gigi.template');
	Route::view('radiologi-gigi/hasil', 'radiologi-gigi.hasil');
	Route::view('radiologi-gigi/laporan', 'radiologi-gigi.laporan');

	Route::view('radiologi-gigi/template', 'radiologi-gigihasil_radiologi');

	Route::get('radiologi-gigi/cetak-ekpertise/{id}/{registrasi_id}', 'RadiologiGigiController@cetakEkspertise');
	// PACS
	Route::get('radiologi-gigi/cetak-ekpertise-pacs/{id}', 'RadiologiGigiController@cetakEkspertisePacs');
	
	Route::get('radiologi-gigi/cetak-ekpertise-vedika/{registrasi_id}', 'RadiologiGigiController@cetakEkspertiseVedika');
	
	// Lihat Hasil Ekspertise di Pengorder
	Route::get('radiologi-gigi/ekspertise-pasien/{id}', 'RadiologiGigiController@lihatHasil');

	//LAPORAN KUNJUNGAN
	Route::get('radiologi-gigi/laporan-kunjungan', 'RadiologiGigiController@lap_kunjungan');
	Route::post('radiologi-gigi/laporan-kunjungan', 'RadiologiGigiController@lap_kunjungan_by_request');

	//Transaksi Langsung
	Route::get('radiologi-gigi/transaksi-langsung', 'RadiologiGigiController@transaksiLangsung');
	Route::post('radiologi-gigi/transaksi-langsung', 'RadiologiGigiController@tindakanLangsungBytanggal');
	Route::post('radiologi-gigi/simpan-transaksi-langsung', 'RadiologiGigiController@simpanTransaksiLangsung');
	Route::get('radiologi-gigi/cetak-langsung-ekpertise/{id}', 'RadiologiGigiController@cetakEkspertiseLangsung');
	Route::get('radiologi-gigi/entry-transaksi-langsung/{registrasi_id}', 'RadiologiGigiController@entryTindakanLangsung');
	Route::get('radiologi-gigi/cetakRadLangsung/{registrasi_id}', 'RadiologiGigiController@transaksiCetak');

	//Hapus Tindakan
	Route::get('radiologi-gigi/hapus-tindakan/{id}/{registrasi_id}/{pasien_id}', 'RadiologiGigiController@hapusTindakan');

	//Ekspertise Get Rajal
	Route::get('radiologi-gigi/ekspertise/{registrasi_id}', 'RadiologiGigiController@ekspertise');
	Route::get('radiologi-gigi/ekspertise/{registrasi_id}/{id}', 'RadiologiGigiController@ekspertiseBaru');
	Route::get('radiologi-gigi/ekspertise-langsung/{registrasi_id}', 'RadiologiGigiController@ekspertise_langsung');
	Route::post('radiologi-gigi/ekspertise/', 'RadiologiGigiController@saveEkpertise');
	Route::post('radiologi-gigi/ekspertise-baru', 'RadiologiGigiController@saveEkpertiseBaru');

	//Ekspertise Get IGD
	Route::get('radiologi-gigi/igd/{registrasi_id}', 'RadiologiGigiController@ekspertise_igd');

	//Ekspertise Get IRNA
	Route::get('radiologi-gigi/irna/{registrasi_id}', 'RadiologiGigiController@ekspertise_irna');

	//Laporan Kinerja
	Route::get('radiologi-gigi/laporan-kinerja', 'RadiologiGigiController@laporanKinerja');
	Route::post('radiologi-gigi/laporan-kinerja', 'RadiologiGigiController@laporanKinerjaByRequest');

	//catatan
	// Route::get('radiologi-gigi/catatan-pasien/{registrasi_id}', 'RadiologiGigiController@Order');
	Route::get('radiologi-gigi/showNote/{id}', 'RadiologiGigiController@showCatatan');
	Route::post('radiologi-gigi/updateNote/{id}', 'RadiologiGigiController@upadateCatatan');

	//hasil radiologi
	Route::get('radiologi-gigi/hasil-radiologi', 'RadiologiGigiController@radiologiHasil');
	Route::post('radiologi-gigi/hasil-radiologi', 'RadiologiGigiController@radiologiHasilBytanggal');


	Route::get('/radiologi-gigi/notif/', 'RadiologiGigiController@notif')->name('radiologi-giginotif');

	Route::get('radiologi-gigi/terbilling', 'RadiologiGigiController@radiologiTerbilling');
	Route::post('radiologi-gigi/terbilling', 'RadiologiGigiController@radiologiTerbillingBytanggal');
	Route::get('/radiologi-gigi/view-rad/{registrasi_id}', 'RadiologiGigiController@viewrad');


	Route::get('radiologi-gigi/create-ekspertise/{registrasi_id}', 'RadiologiGigiController@createEkspertise');
	Route::get('radiologi-gigi/edit-ekpertise/{id}/{registrasi_id}', 'RadiologiGigiController@editEkspertise');


	Route::get('radiologi-gigi/cari-pasien', 'RadiologiGigiController@cariPasien');
	Route::post('radiologi-gigi/cari-pasien', 'RadiologiGigiController@cariPasienProses');

	Route::get('radiologi-gigi/cari-pasien-perawat', 'RadiologiGigiController@cariPasienPerawat');
	Route::post('radiologi-gigi/cari-pasien-perawat', 'RadiologiGigiController@cariPasienProsesPerawat');
});
