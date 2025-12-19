<?php

// Route::group(['middleware' => ['web', 'auth', 'role:verifikator|kasir|supervisor|administrator']], function () {
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('kasir/rawatjalan', 'KasirController@rawat_jalan')->name('kasir.rawatjalan');
	Route::post('kasir/rawatjalan', 'KasirController@rawatjalanByTanggal')->name('kasir.rawatjalan');
	Route::get('kasir/rawatjalan-ajax', 'KasirController@ajax_rawat_jalan')->name('kasir.rawatjalan-ajax');
	Route::get('kasir/data_rawatjalan', 'KasirController@data_rawat_jalan')->name('kasir.data_rawatjalan');
	Route::post('kasir/rawatjalan/bytanggal', 'KasirController@byTanggal');
	Route::post('kasir/rawatjalan/byrm', 'KasirController@byRM');
	Route::get('kasir/rawatjalan/bayar/{reg_id}/{pasien_id}', 'KasirController@bayar_rawat_jalan');
	Route::post('kasir/rawatjalan/save_bayar_rawat_jalan', 'KasirController@save_bayar_rawat_jalan')->name('kasir.save_bayar_rawat_jalan');

	// KASIR TINDAKAN
	Route::get('kasir-tindakan/rawatjalan/bayar/{reg_id}/{pasien_id}', 'KasirController@bayar_tindakan_rawat_jalan');
	Route::post('kasir-tindakan/rawatjalan/save_bayar_rawat_jalan', 'KasirController@save_bayar_tindakan_rawat_jalan')->name('kasir-tindakan.save_bayar_rawat_jalan');

	// KASIR OBAT
	Route::get('kasir-obat/data_rawatjalan', 'KasirObatController@data_rawat_jalan')->name('kasir-obat.data_rawatjalan');
	Route::get('kasir-obat/rawatjalan', 'KasirObatController@rawat_jalan')->name('kasir-obat.rawatjalan');
	Route::post('kasir-obat/rawatjalan', 'KasirObatController@rawatjalanByTanggal')->name('kasir-obat.rawatjalan');
	Route::get('kasir-obat/rawatjalan-ajax', 'KasirObatController@ajax_rawat_jalan')->name('kasir-obat.rawatjalan-ajax');
	Route::post('kasir-obat/rawatjalan/bytanggal', 'KasirObatController@byTanggal');
	Route::post('kasir-obat/rawatjalan/byrm', 'KasirObatController@byRM');
	Route::get('kasir-obat/rawatjalan/bayar/{reg_id}/{pasien_id}', 'KasirObatController@bayar_rawat_jalan');
	Route::post('kasir-obat/rawatjalan/save_bayar_rawat_jalan', 'KasirObatController@save_bayar_rawat_jalan')->name('kasir-obat.save_bayar_rawat_jalan');
	
	// KASIR EKSEKUTIF
	Route::get('kasir/eksekutif', 'KasirController@kasirEksekutif')->name('kasir.eksekutif');
	Route::get('kasir/data_eksekutif', 'KasirController@data_eksekutif')->name('kasir.data_eksekutif');
	Route::get('kasir/eksekutif/bayar/{reg_id}/{pasien_id}', 'KasirController@bayarEksekutif')->name('kasir.bayar_eksekutif');
	Route::post('kasir/rawatjalan/save_bayar_eksekutif', 'KasirController@save_bayar_eksekutif')->name('kasir.save_bayar_eksekutif');

	Route::view('kasir/cetak', 'kasir.cetak_kasir');
	//rawat inap
	Route::get('kasir/cetakIRNA', 'KasirController@cetakIRNA');
	Route::post('kasir/cetakIRNA', 'KasirController@cetakIRNAByTanggal');
	//rawat igd
	Route::get('kasir/cetakIGD', 'KasirController@cetakIGD');
	Route::post('kasir/cetakIGD', 'KasirController@cetakIGDByTanggal');
	//rawat jalan
	Route::get('kasir/cetakRj', 'KasirController@cetakRj');
	Route::post('kasir/cetakRj', 'KasirController@cetakRjByTanggal');
	//cetak
	Route::get('kasirkasir-obat.save_bayar_rawat_jalan/cetak/cetakkuitansi/igd/{id}', 'KasirController@cetakkuitansiigd');
	Route::get('kasir/cetak/cetakkuitansi/{id}', 'KasirController@cetakkuitansi');
	Route::get('kasir/cetak/cetakkuitansi-irna/{id}', 'KasirController@cetakkuitansiIrna');
	Route::get('kasir/cetak/cetakkuitansiigd/{id}', 'KasirController@cetak_kuitansi_igd');
	Route::get('kasir/kwitansi-eksekutif/{registrasi_id}', 'KasirController@cetak_kuitansi_eksekutif');
	Route::get('kasir/cetak/cetakkuitansiirna/{id}', 'KasirController@cetak_kuitansi_ranap');
	Route::get('kasir/cetak/cetakkuitansinonjasaracik/{id}', 'KasirController@cetaknonjasakuitansi');
	Route::get('kasir/cetakkuitansi/{id}', 'KasirController@cetak_kuitansi_langsung');
	Route::post('kasir/cetakkuitansi-dipilih/{registrasi_id}', 'KasirController@cetak_kuitansi_dipilih');
	Route::post('kasir/cetakkuitansi-dipilih-eksekutif/{registrasi_id}', 'KasirController@cetak_kuitansi_dipilih_eksekutif');
	Route::get('kasir/cetakkuitansitanparetribusi/{id}', 'KasirController@cetak_kuitansi_langsung_tretribusi');
	Route::get('kasir/cetakkuitansi-perkwitansi/{id}', 'KasirController@cetak_kuitansi_perkwitansi');
	Route::get('kasir/cetakkuitansi-tindakan/{id}', 'KasirController@cetak_kuitansi_langsung_tindakan');
	Route::get('kasir/cetakkuitansi-obat/{id}', 'KasirController@cetak_kuitansi_langsung_obat');
	Route::get('kasir/cetakkuitansi-penunjang-rad/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_rad');
	Route::get('kasir/cetakkuitansi-penunjang-lab/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_lab');
	Route::get('kasir/cetakkuitansi-penunjang-usg/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_usg');
	Route::get('kasir/cetakkuitansi-penunjang-ekg/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_ekg');
	Route::get('kasir/cetakkuitansi-penunjang-ctscan/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_ctscan');
	Route::get('kasir/cetakkuitansi-penunjang-citologi/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_citologi');
	Route::get('kasir/cetakkuitansi-penunjang-pa-operasi/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_pa_operasi');
	Route::get('kasir/cetakkuitansi-penunjang-fnab/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_fnab');
	Route::get('kasir/cetakkuitansi-penunjang-pa-biopsi/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_pa_biopsi');
	Route::get('kasir/cetakkuitansi-penunjang-resume-medis/{id}', 'KasirController@cetak_kuitansi_langsung_penunjang_resume_medis');

	Route::get('kasir/rincian-biaya/{id}', 'KasirController@cetak_RincianBiaya');
	Route::get('kasir/rincian-biaya-non-jasa/{id}', 'KasirController@cetak_RincianBiayaNonJasa');

	Route::get('kasir/rincian-biaya-rajal/{id}', 'KasirController@cetak_RincianBiayaRajal');
	// RINCIAN BIAYA
	Route::get('kasir/rincian-biaya-tindakan/{id}', 'KasirController@cetak_RincianBiayaTindakan');
	Route::get('kasir/rincian-biaya-tindakan-registrasi/{regId}', 'KasirController@cetak_RincianBiayaTindakanRegistrasi');
	Route::get('kasir/rincian-biaya-obat/{id}', 'KasirObatController@cetak_RincianBiayaObat');

	//PIUTANG
	Route::get('kasir/data-piutang/', 'KasirController@dataPiutang');
	Route::get('kasir/piutang/{registrasi_id}', 'KasirController@piutang');
	Route::get('kasir/piutang-igd/{registrasi_id}', 'KasirController@piutangIgd');

	//Kasir IGD
	Route::get('kasir/igd', 'KasirController@igd')->name('kasir.igd');
	Route::post('kasir/igd', 'KasirController@igdByTanggal')->name('kasir.igd');
	Route::get('kasir/data-igd', 'KasirController@data_igd')->name('kasir.data_igd');
	Route::get('kasir/ajax-igd', 'KasirController@ajax_igd')->name('kasir.ajax-igd');

	//Rawat Inap
	Route::get('kasir/rawatinap', 'KasirController@rawat_inap')->name('kasir.rawatinap');
	Route::post('kasir/rawatinap', 'KasirController@rawat_inap_byTanggal');
	Route::get('kasir/rawatinap/bayar/{reg_id}/{pasien_id}', 'KasirController@bayar_rawat_inap');
	Route::post('kasir/rawatinap/save_bayar_rawat_inap', 'KasirController@save_bayar_rawat_inap');
	Route::get('kasir/cetakkuitansi_irna/{id}', 'KasirController@cetak_kuitansi_langsung_irna');
	Route::get('kasir/cetak-surat-pulang-paksa/{registrasi_id}', 'KasirController@cetakSuratPulangPaksa');

	Route::get('kasir/batal-pulang/{registrasi_id}', 'KasirController@batalPulang');

	Route::get('kasir/detail-verifikasi/{registrasi_id}', 'KasirController@detailVerifikasi');
	Route::get('kasir/detail-tindakan-verifikasi/{registrasi_id?}/{poli_tipe?}', 'KasirController@detailTindakanVerifikasi');

	Route::post('kasir/ubah-tipe-jkn', 'KasirController@ubahTipeJKN');
	Route::post('kasir/save-tindakan', 'KasirController@save_tindakan');


	//Lain - lain
	Route::get('kasir/lain-lain', 'KasirController@transaksi_lain_lain');
	Route::post('kasir/lain-lain', 'KasirController@transaksi_lain_lain_by');
	Route::get('kasir/lain-lain/bayar/{registrasi_id?}', 'KasirController@form_bayar_lain_lain');
	Route::post('kasir/rawatinap/save_bayar_lain_lain', 'KasirController@save_bayar_lain_lain');
	Route::get('kasir/cetakkuitansibebas/{id}', 'KasirController@cetak_kuitansi_bebas');

	//SUPERVISOR
	Route::get('kasir/edit-transaksi', 'KasirController@edit_transaksi');
	Route::get('kasir/batal-bayar', 'KasirController@batal_bayar');
	Route::post('kasir/batal-bayar', 'KasirController@batal_bayar_byTanggal');
	Route::get('kasir/data-batal-bayar', 'KasirController@data_batal_bayar')->name('kasir.data_batal_bayar');
	Route::get('kasir/rincian-bayar/{registrasi_id}', 'KasirController@rincian_pembayaran');
	Route::get('kasir/save-batal-bayar/{registrasi_id}/{no_kwitansi}', 'KasirController@save_pembatalan');
	Route::get('kasir/batal-piutang', 'KasirController@batal_piutang');

	//LAPORAN
	Route::get('kasir/laporan-rincian-detail-tindakan', 'KasirController@lap_detail_tindakan');
	Route::post('kasir/laporan-rincian-detail-tindakan', 'KasirController@lap_detail_tindakanByFilter');
	Route::get('kasir/laporan-penerimaan-tunai', 'KasirController@lap_penerimaan_tunai');
	Route::post('kasir/laporan-penerimaan-tunai', 'KasirController@lap_penerimaan_tunai_byTanggal');
	Route::get('kasir/tutup-kasir', 'KasirController@tutup_kasir');
	Route::post('kasir/tutup-kasir', 'KasirController@tutup_kasir_byRequest');

	Route::view('kasir/transaksi', 'kasir.transaksi');
	Route::view('kasir/supervisor', 'kasir.supervisor');
	Route::view('kasir/laporan', 'kasir.laporan');

	//Get Tarif
	Route::get('kasir/gettarif/{kat_id}', 'KasirController@getTarif');

	//verifikasi Kasa
	Route::get('kasir/verifikasi-kasa', 'KasirController@verifikasiKasa');
	Route::post('kasir/verifikasi-kasa', 'KasirController@verifikasiKasaByRequest');
	Route::get('kasir/detail-verifikasi-kasa/{registrasi_id}', 'KasirController@detailVerifikasiKasa');
	Route::post('kasir/save-verifikasi-kasa', 'KasirController@saveVerifikasiKasa');
	Route::get('kasir/verifikasi-rajal/{id}', 'KasirController@verifikasiRajal');
	Route::get('kasir/detail-verifikasi-rajal/{reg}/{poli_tipe}', 'KasirController@detailVerifRajal');

	//Tambah Tindakan
	Route::get('kasir/tambah-tindakan/{registrasi_id}', 'KasirController@tambahTindakan');
	Route::post('/kasir/save-tambah-tindakan/', 'KasirController@saveTindakan');

	//Cetak
	Route::get('kasir/cetak-verifikasi/{registrasi_id}', 'KasirController@cetakVerifikasi');

	//Kosongkan Bed
	Route::get('kasir/kosongkan-bed/{reg_id}/{pasien_id}', 'KasirController@kosongkanBed');

	//Verifikasi IRNA
	Route::get('kasir/verifikasi', 'KasirController@verifikasi');
	Route::post('kasir/verifikasi', 'KasirController@getDataVerifInap');
	Route::get('kasir/verifikasi-get-data', 'KasirController@getDataVerifikasi');

	Route::post('kasir/verifikasi-kasir-irna/', 'KasirController@verifikasirKasirIrna');
	Route::post('kasir/verifikasi-detail-kasir-irna/', 'KasirController@verifikasirDetailKasirIrna');
	Route::get('kasir/unverifikasi-kasir-irna/{folio_id}/{registrasi_id}', 'KasirController@unverifikasiKasirIrna');
	Route::get('kasir/hapus-tindakan-irna/{folio_id}/{registrasi_id}', 'KasirController@hapusTindakanIrna');

	//TAMBAH PEMBIAYAAN DI KASIR
	Route::get('kasir/get-register/{registrasi_id}', 'KasirController@getRegister');
	Route::get('kasir/get-tarif', 'KasirController@getTarifIrna');
	Route::get('kasir/get-pelaksana', 'KasirController@getPelaksana');
	Route::get('kasir/get-perawat', 'KasirController@getPerawat');
	Route::post('kasir/save-biaya-tambahan', 'KasirController@saveBiayaTambahan');

	//verifikasi berkas
	Route::get('kasir/laporan-verifikasi-berkas', 'KasirController@laporanVerifiksiberkas');
	Route::post('kasir/laporan-verifikasi-berkas', 'KasirController@lap_Verifikasi_berkas_bytanggal');

	//laporan naik kelas ('27-mei')
	Route::get('kasir/cetakkuitansinaikkelas/{id}', 'KasirController@cetak_kuitansi_naik_kelas');

	//DetailrincianPembayaran
	Route::get('kasir/get-rincian-pembayaran/{no_kwitansi}', 'KasirController@detailRincianBayar');
	Route::get('kasir/get-rincian-piutang/{id}', 'KasirController@detailPiutang');
	Route::post('kasir/bayar-piutang', 'KasirController@bayarPiutang');

	Route::get('kasir/diklat', 'KasirController@diklat');
	Route::post('kasir/diklat-save', 'KasirController@diklatSave');
	Route::get('kasir/diklat-data', 'KasirController@dataDiklat');
	Route::get('kasir/diklat-batal/{id}', 'KasirController@batalBayarDiklat');
	Route::get('kasir/diklat-cetak/{id}', 'KasirController@cetakDiklat');


	//Uang Muka - Deposit
	Route::get('kasir/uangmuka-rawatinap', 'KasirController@uangmuka_rawatinap');
	Route::post('kasir/uangmuka-rawatinap', 'KasirController@uangmuka_rawatinap_byPasien');
	Route::post('kasir/save-uangmuka-rawatinap', 'KasirController@save_uangmuka');
	Route::get('kasir/save-return-rawatinap/{id}', 'KasirController@save_return');

	Route::get('kasir/uangmuka-rawatdarurat', 'KasirController@uangmuka_rawatdarurat');
	Route::get('kasir/dataPasienDarurat', 'KasirController@dataPasienDarurat');

	Route::get('kasir/viewDeposit/{registrasi_id}', 'KasirController@viewDeposit');
	Route::get('kasir/dataPasienInap', 'KasirController@dataPasienInap');
	Route::get('kasir/tutup-transaksi', 'KasirController@tutup_transaksi');
	Route::get('kasir/cetak-deposit/{id}', 'KasirController@cetakDeposit');
	Route::get('kasir/cetak-return/{id}', 'KasirController@cetakReturn');

	//Jamkesda
	Route::get('kasir/jamkesda', 'KasirController@jamkesda');
	Route::post('kasir/jamkesda', 'KasirController@jamkesdaGetData');
	Route::post('kasir/jamkesdaSave', 'KasirController@saveJamkesda');

	//hapus tindakan kasir
	Route::get('kasir/hapus-tindakan-kasir/{folio_id}/{registrasi_id}', 'KasirController@hapusTindakan');
	Route::post('kasir/simpan-hapus-tindakan-kasir', 'KasirController@simpanHapusTindakan');
	Route::post('kasir/hapus-tindakan-select', 'KasirController@hapusTindakanSelect');


	Route::get('kasir/dunnowhat', 'KasirController@dunnoWhat');


	// Transaksi Keluar
	Route::get('kasir/transaksi-keluar', 'KasirController@transaksiKeluar');
	Route::post('kasir/transaksi-keluar-save', 'KasirController@transaksiKeluarSave');
	Route::get('kasir/transaksi-keluar-data', 'KasirController@dataTransaksiKeluar');
	Route::get('kasir/transaksi-keluar-batal/{id}', 'KasirController@batalBayarTransaksiKeluar');
	Route::get('kasir/transaksi-keluar-cetak/{id}', 'KasirController@cetakTransaksiKeluar');
	Route::post('kasir/save-klasifikasi-pengeluaran', 'KasirController@klasifikasiPengeluaranSave');
	Route::post('kasir/save-jenis-pengeluaran', 'KasirController@jenisPengeluaranSave');

	//Buat SIP
	Route::post('kasir/buat-sip', 'KasirController@buatSip');

	//Batal SIP
	Route::post('kasir/batal-sip', 'KasirController@batalSIP');

	// Ubah Surat PULPAK penanggung jawab
	Route::post('/kasir/ubah-penanggung-jawab', 'KasirController@ubahPenanggungJawab');
	

});
