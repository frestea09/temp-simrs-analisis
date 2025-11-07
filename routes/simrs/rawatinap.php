<?php


Route::group(['middleware' => ['web', 'auth', 'role:laboratorium|apotik|admission|rawatinap|rawatdarurat|rawatjalan|rekammedis|supervisor|administrator|antrian|loketigd']], function () {
	Route::view('rawat-inap/admission', 'rawat-inap.admission');
	Route::view('rawat-inap/emr', 'rawat-inap.emr');
	Route::view('rawat-inap/laporan', 'rawat-inap.laporan');

	// EDIT INACBGS
	Route::get('rawat-inap/edit-inacbgs', 'RawatinapController@editInacbgs');
	Route::get('rawat-inap/data-inacbgs/{id}', 'RawatinapController@dataInacbgs');
	Route::post('rawat-inap/update-inacbgs', 'RawatinapController@updateInacbgs');

	// SENSUS 
	Route::get('rawatinap/sensus-masuk', 'RawatinapController@sensusMasuk');
	Route::post('rawatinap/sensus-masuk', 'RawatinapController@filterSensusMasuk');

	Route::get('rawatinap/sensus-keluar', 'RawatinapController@sensusKeluar');
	Route::post('rawatinap/sensus-keluar', 'RawatinapController@filterSensusKeluar');

	// CARA BAYAR
	Route::get('rawatinap/laporan-carabayar', 'RawatinapController@laporanCaraBayar');
	Route::post('rawatinap/laporan-carabayar', 'RawatinapController@caraBayarByReq');

	// KELAS RAWAT
	Route::get('rawatinap/laporan-kelasrawat', 'RawatinapController@laporanKelasRawat');
	Route::post('rawatinap/laporan-kelasrawat', 'RawatinapController@kelasRawatByReq');

	//BILLING
	Route::get('rawat-inap-menu-billing', 'RawatinapController@menuBilling');
	Route::get('rawat-inap/billing/{kelas_id?}/{kamar_id?}', 'RawatinapController@billing');
	Route::post('rawat-inap/billing/{registrasi_id}', 'RawatinapController@pilihKelas');
	Route::get('rawat-inap/billingpulang/{kelas_id?}/{kamar_id?}', 'RawatinapController@billingp');
	Route::post('rawat-inap/billingpulang/{registrasi_id}', 'RawatinapController@pilihKelasp');
	Route::get('rawat-inap/billing-filter', 'RawatinapController@filterBilling');
	Route::get('rawat-inap/rincian-biaya/{id}', 'RawatinapController@cetak_RincianBiaya');
	Route::get('rawat-inap/rinciantin/{id}', 'RawatinapController@cetak_rincian');
	Route::post('rawat-inap/billing-filter-new', 'RawatinapController@filterBillingNew');
	Route::post('rawat-inap/billing-filter-new-pulang', 'RawatinapController@filterBillingNewPulang');
	Route::post('rawat-inap/billing-filter', 'RawatinapController@filterBillingPost');
	Route::get('rawat-inap/inacbgs/{reg_id}', 'RawatinapController@inacbgs');
	Route::post('rawat-inap/inacbgsSave', 'RawatinapController@inacbgsSave');
	Route::get('rawat-inap/lihat-pasien-bed/{registrasi_id}', 'RawatinapController@lihat_pasien_bed');
	Route::get('rawat-inap/entry-tindakan/{registrasi_id}', 'RawatinapController@entry_tindakan');
	Route::get('rawat-inap/data-tindakan/{registrasi_id}', 'RawatinapController@dataTindakanIrna');
	Route::post('rawat-inap/entry-tindakan/save', 'RawatinapController@save_tindakan');
	Route::post('rawat-inap/entry-tindakan/update/pagu/{registrasi_id}', 'RawatinapController@update_pagu');

	Route::get('rawat-inap/updateCaraBayar/{id}/{cara_bayar}', 'RawatinapController@updateCaraBayar');

	// E-Resep
	Route::get('rawat-inap/e-resep/show/{reg_id}', 'RawatinapController@getRegistrasi');
	Route::post('rawat-inap/e-resep/save-detail', 'RawatinapController@saveDetailResep');
	Route::delete('rawat-inap/e-resep/detail/{id}/delete', 'RawatinapController@deleteDetailResep');
	Route::post('rawat-inap/e-resep/save-resep', 'RawatinapController@saveResep');
	Route::get('rawat-inap/e-resep/history/{reg_id}', 'RawatinapController@getHistoryResep');

	//Ambulance
	Route::get('rawat-inap/ambulance', 'RawatinapController@ambulance');
	Route::post('rawat-inap/ambulance', 'RawatinapController@ambulanceGetData');
	Route::post('rawat-inap/save-ambulance', 'RawatinapController@saveAmbulance');

	//Pemulasaran Jenazah
	Route::get('rawat-inap/jenazah', 'RawatinapController@jenazah');
	Route::post('rawat-inap/jenazah', 'RawatinapController@jenazahGetData');
	Route::post('rawat-inap/save-jenazah', 'RawatinapController@saveJenazah');

	//Update Hapus
	Route::get('rawat-inap/edit-tindakan/{folio_id}/{tarif_id}', 'RawatinapController@editTindakan');
	Route::post('rawat-inap/edit-jenis-tindakan/{id}', 'RawatinapController@editJenisTindakan');
	Route::post('/rawat-inap/save-edit-tindakan/', 'RawatinapController@saveEditTindakan');
	Route::get('rawat-inap/hapus-tindakan/{id}/{registrasi_id}', 'RawatinapController@hapusTindakan');

	Route::get('rawat-inap/getKategoriTarifID/{id}/{reg_id?}', 'RawatinapController@getTarif');
	//IBS
	Route::get('rawat-inap/ibs/{id}', 'RawatinapController@ibs');
	Route::post('rawat-inap/save-ibs', 'RawatinapController@saveibs');

	//PIP
	Route::get('rawat-inap/ppi/{pasien_id}', 'RawatinapController@ppi');
	Route::post('rawat-inap/simpan-ppi', 'RawatinapController@simpanppi');

	//tagihan
	Route::get('rawat-inap/tagihan-ranap', 'RawatinapController@tagihan_ranap');
	Route::post('rawat-inap/tagihan-ranap', 'RawatinapController@tagihan_ranap_by');

	//LAB
	Route::get('rawat-inap/laboratorium/{id}', 'RawatinapController@laboratorium');
	Route::post('rawat-inap/simpan-laboratorium', 'RawatinapController@simpanLaboratorium');

	//RADIOLOGI
	Route::get('rawat-inap/radiologi/{id}', 'RawatinapController@radiologi');
	Route::post('rawat-inap/simpan-radiologi', 'RawatinapController@simpanRadiologi');

	//GIZI
	Route::get('rawat-inap/gizi/{id}', 'RawatinapController@gizi');
	Route::post('rawat-inap/simpan-gizi', 'RawatinapController@simpanGizi');

	//MUTASI
	Route::get('rawat-inap/mutasi/{id}', 'RawatinapController@mutasi');
	Route::post('rawat-inap/simpan-mutasi', 'RawatinapController@simpanMutasi');
	Route::post('rawat-inap/update-mutasi', 'RawatinapController@updateMutasi');

	// CARI PASIEN
	Route::get('rawat-inap/cari-pasien', 'RawatinapController@cariPasien');
	Route::post('rawat-inap/cari-pasien', 'RawatinapController@cariPasienProses');
	//PULANG
	Route::post('rawat-inap/pulang', 'RawatinapController@pulang');
	Route::get('rawat-inap/kosongkan-bed/{bed_id}/{registrasi_id}', 'RawatinapController@kosongkanBed');

	//FISIOTERAPI
	Route::get('rawat-inap/fisioterapi/{id}', 'RawatinapController@fisioterapi');

	//ANTRIAN
	Route::get('rawatinap', 'RawatinapController@index');
	Route::get('rawatinap/antrian/{id?}', 'RawatinapController@antrian');
	Route::get('rawatinap/antrianform/{id?}', 'RawatinapController@antrianform');
	Route::post('rawatinap/save', 'RawatinapController@saveRawatInap');
	Route::get('rawat-inap/get-datareg/{registrasi_id}', 'RawatinapController@getdatareg');

	Route::get('getkamar/{id}', 'RawatinapController@getKamar');
	Route::get('getbed/{kelompokkelas_id}/{kelas_id}/{kamar_id}', 'RawatinapController@getBed');

	//EMR
	Route::get('rawatinap/emr', 'RawatinapController@emr');

	//LAPORAN
	Route::get('rawatinap/lap-pengunjung', 'RawatinapController@lapPengunjung');
	// end of route 
	Route::post('rawatinap/lap-pengunjung', 'RawatinapController@filterLapPengunjung');
	Route::get('rawatinap/sensus-harian', 'RawatinapController@sensus_harian');
	Route::get('lap-irna-getkamar/{kelas_id?}', 'RawatinapController@lapirnagetkamar');
	Route::get('rawatinap/laporan-rekammedis', 'RawatinapController@lapRekammedis');
	Route::post('rawatinap/laporan-rekammedis', 'RawatinapController@filterLapRekammedis');
	Route::get('rawatinap/laporan-resume-pasien', 'RawatinapController@lapResumePasien');
	Route::post('rawatinap/laporan-resume-pasien', 'RawatinapController@filterLapResumePasien');
	Route::get('rawatinap/laporan-10-besar-penyakit', 'RawatinapController@sepuluhBesarPenyakit');
	Route::post('rawatinap/laporan-10-besar-penyakit', 'RawatinapController@sepuluhBesarPenyakitByTanggal');

	//ASKEP
	Route::get('rawat-inap/askep', 'RawatinapController@askep');

	//Hapus rawat inap hari ini
	Route::get('list-rawat-inap-hari-ini', 'RawatinapController@getToday');
	Route::post('list-rawat-inap-hari-ini', 'RawatinapController@getTodayByTgl');
	Route::get('list-rawat-inap-hari-ini-hapus/{id}', 'RawatinapController@hapusToday');

	//UBAH DPJP
	Route::get('rawat-inap/ubah-dpjp', 'RawatinapController@UbahDpjp');
	Route::get('rawat-inap/data-ubah-dpjp/{tga?}/{tgb?}', 'RawatinapController@dataUbahDpjp');
	Route::get('rawatinap-data-detail-reg/{id}', 'RawatinapController@dataReg');
	Route::post('rawat-inap/saveubahdpjp', 'RawatinapController@save_ubahdpjp');

	Route::post('rawat-inap/lunas', 'RawatinapController@lunaskanTindakan');
	Route::post('rawat-inap/belumLunas', 'RawatinapController@belumLunas');

	Route::get('informasi-rawat-inap', 'RawatinapController@informasi_rawat');
	Route::post('update-keterangan/{id}', 'RawatinapController@updateKeterangan');
	Route::get('data-rawat-inap', 'RawatinapController@dataRawatInap');
	Route::get('detail-data-rawat-inap/{registrasi_id}', 'RawatinapController@detailDataRawatInap');
	Route::get('informasi-rincian-biaya/{registrasi_id}', 'RawatinapController@rincianBiaya');
	Route::get('informasi-rincian-biaya-baru/{registrasi_id}', 'RawatinapController@rincianBiayaBaru');
	Route::get('informasi-total-biaya/{registrasi_id}', 'RawatinapController@sisaTotalTagihan');
	Route::post('update-tanggal-masuk-rawat-inap', 'RawatinapController@simpanUpdateTanggalMasuk');

	Route::get('ranap-informasi-rincian-biaya/{registrasi_id}', 'RawatinapController@rincianBiayaRs');
	Route::get('ranap-informasi-unit-rincian-biaya/{registrasi_id}', 'RawatinapController@rincianBiayaUnit');
	Route::get('ranap-informasi-unit-rincian-biaya-tanpa-rajal/{registrasi_id}', 'RawatinapController@rincianBiayaUnitTanpaRajal');
	Route::get('ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/{registrasi_id}', 'RawatinapController@rincianBiayaUnitItemTanpaRajal');
	Route::get('ranap-informasi-unit-item-rincian-biaya/{registrasi_id}', 'RawatinapController@rincianBiayaUnitItem');
	Route::get('ranap-informasi-unit-item-rincian-biaya-tanpa-kronis/{registrasi_id}', 'RawatinapController@rincianBiayaUnitItemTanpaKronis');
	Route::get('ranap-informasi-unit-rincian-biaya-tanpa-igd/{registrasi_id}', 'RawatinapController@rincianBiayaUnitTanpaIgd');

	//KOde DPJP
	Route::get('rawatinap/get-kode-dpjp/{id}', 'RawatinapController@kodeDPJP');
	
	//RESUME
	Route::get('resume-rawat-inap/{registrasi_id}', 'RawatinapController@resume');
	Route::get('rawat-inap/cetak-rincian/{registrasi_id}', 'RawatinapController@cetakRincianTindakan');
	Route::get('cek-inap', 'RawatinapController@cekpasieninap');

	Route::get('rawat-inap/histori-ranap', 'RawatinapController@historiRanap');
	
	Route::get('rawat-inap/laporan-indeks-kematian', 'RawatinapController@indeksKematian');
	Route::post('rawat-inap/laporan-indeks-kematian', 'RawatinapController@indeksKematianByTanggal');


	Route::get('rawat-inap/demografi-pasien', 'RawatinapController@demografiPasien');
	Route::post('rawatinap/demografi-pasien-by', 'RawatinapController@demografiPasienBy');

	Route::get('sinkron-rb-tagihan/{reg_id}', 'RawatinapController@sinkronRbTagihan');

	Route::post('rawatinap/deleteIbs/{id}', 'RawatinapController@deleteIbs');

	Route::get('rawat-inap/hasil', 'RawatinapController@hasil');
	Route::post('rawat-inap/hasil-filter', 'RawatinapController@filterHasil');

	Route::get('rawat-inap/selesai-billing/{reg_id}', 'RawatinapController@selesaiBilling');
});