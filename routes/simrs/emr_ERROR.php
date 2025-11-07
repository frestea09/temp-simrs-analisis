<?php

Route::group(['middleware' => ['web', 'auth']], function () {

	Route::match(['get', 'post'], 'emr-laporan-operasi/{registrasi_id}', 'EmrController@laporanOperasi')->name('laporan-operasi');
	Route::get('cetak-laporan-operasi/{registrasi_id}', 'EmrController@cetakLaporanOperasi');
	// SOAP PASIEN
	// Route::match(['get', 'post'], 'emr-soap-icd/icd10/{unit}/{registrasi_id}', 'Emr\EmrIcdController@icd10');
	Route::get('emr-soap-icd/icd10/{unit}/{registrasi_id}', 'Emr\EmrIcdController@icd10');
	Route::post('emr-soap-icd/icd10/{unit}/{registrasi_id}', 'Emr\EmrIcdController@icd10');
	Route::post('emr-soap-icd/icd10/{id}', 'Emr\EmrIcdController@icd10Destroy');
	Route::match(['get', 'post'], 'emr-soap-icd/icd9/{unit}/{registrasi_id}', 'Emr\EmrIcdController@icd9');


	Route::post('emr/save-riwayat', 'EmrController@saveRiwayat');
	Route::post('emr/save-tindakan', 'EmrController@saveTindakan');

	// EREEP
	Route::get('emr/eresep/use-template-eresep/{registrasi_id}/{unit}/{uuid}', 'EmrController@useTemplateEresep');
	Route::get('emr/eresep/use-template-eresep/delete/{id}', 'EmrController@useTemplateEresepDelete');
	Route::get('emr/eresep/{unit}/{registrasi_id}', 'EmrController@eresep')->name('eresep');
	Route::get('emr/eresep/edit-template/{unit}/{registrasi_id}/{uuid}', 'EmrController@editEresep')->name('edit-eresep');

	// ERESEP RACIK
	Route::get('emr/eresep-racikan/{unit}/{registrasi_id}', 'EmrController@eresepRacikan')->name('eresep-racikan');

	Route::get('emr/{unit}', 'EmrController@index');
	Route::post('emr/{unit}', 'EmrController@index_byTanggal')->name('emr'); 
	Route::get('emr/duplicate-soap/{id}/{dokter}/{poli}/{reg_id}', 'EmrController@duplicateSoap');
	
	Route::get('emr/{unit}/{registrasi_id}', 'EmrController@create')->name('medical_history');
	Route::get('emr/{unit}/{registrasi_id}', 'EmrController@soap')->name('soap');
	Route::get('emr/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'EmrController@soap')->name('soap');
	Route::get('pemeriksaan-fisik/{unit}/{registrasi_id}', 'EmrController@pemeriksaanfisik')->name('pemeriksaan_fisik');
	
	Route::get('emr/rad/{unit}/{registrasi_id}', 'EmrController@rad')->name('rad');
	Route::get('emr/ris/{unit}/{registrasi_id}', 'EmrController@ris')->name('ris');
	Route::get('emr/lab/{unit}/{registrasi_id}', 'EmrController@lab')->name('lab');
	Route::get('emr/lab-paket/{unit}/{registrasi_id}', 'EmrController@labPaket')->name('lab-paket');
	Route::get('emr/poli/{unit}/{registrasi_id}', 'EmrController@orderPoli')->name('order_poli');
	
	Route::get('emr/cetak-lis/{no_lab}/{registrasi_id}', 'EmrController@cetakLis')->name('cetakLis');
	Route::get('cetak-lis-pdf/{no_lab}/{registrasi_id}', 'EmrController@cetakLisPdf')->name('cetakLis');
	

	
	Route::post('save-emr', 'EmrController@save');
	Route::post('update-soap', 'EmrController@updateSoap');
	Route::get('cetak-emr/{registrasi_id}', 'EmrController@cetakResume');
	Route::delete('emr/{id}', 'EmrController@deleteResume');
	Route::get('cetak-emr/pdf/{registrasi_id}', 'EmrController@cetakPDFResume');
	Route::get('cetak-emr-rencana-kontrol/pdf/{registrasi_id}', 'EmrController@cetakPDFResumeRencanaKontrol');

	Route::get('emr/pemeriksaan-rad/{unit}/{registrasi_id}', 'EmrController@pemeriksaanRad')->name('pemeriksaan-rad');
	Route::get('emr/pemeriksaan-lab/{unit}/{registrasi_id}', 'EmrController@pemeriksaanLab')->name('pemeriksaan-lab');
	Route::get('emr/resume/{unit}/{registrasi_id}', 'EmrController@resume')->name('emr-resume');

	// EMR NEW
	// Anamnesis
	Route::get('emr/triase/{unit}/{registrasi_id}', 'EmrController@triase');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/main/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisMain');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/umum/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisUmum');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/riwayat/{unit}/{registrasi_id}', 'EmrController@anamnesisRiwayat');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/riwayat_umum/{unit}/{registrasi_id}', 'EmrController@anamnesisRiwayatUmum');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/riwayatgigi/{unit}/{registrasi_id}', 'EmrController@anamnesisRiwayatGigi');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/keluhanutama/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisKeluhanUtama');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/statusfungsional/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisStatusFungsional');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/kondisisosial/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisKondisiSosial');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/permasalahangizi/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisPermasalahanGizi');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/edukasipasienkeluarga/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisEdukasiPasienKeluarga');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/rencana/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisRencana');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/edukasipasienemergency/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisEdukasiPasienEmergency');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/edukasiobgyn/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisEdukasiObgyn');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/keadaanmukosaoral/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisKeadaanMukosaOral');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/obgyn/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisObgyn');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/saraf_otak/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@anamnesisSarafOtak');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/generalisTHT/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@generalisTHT');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/asesmenAnatomiAnak/{unit}/{registrasi_id}/{record_id?}/{method?}', 'EmrController@asesmenAnatomiAnak');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/status/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@status');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/primary/airway/{unit}/{registrasi_id}', 'EmrController@airway');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/primary/breathing/{unit}/{registrasi_id}', 'EmrController@breathing');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/primary/circulation/{unit}/{registrasi_id}', 'EmrController@circulation');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/primary/disability/{unit}/{registrasi_id}', 'EmrController@disability');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/primary/eksposure/{unit}/{registrasi_id}', 'EmrController@eksposure');
	Route::match(['get', 'post'], 'emr-soap/anamnesis/status/generalis/{unit}/{registrasi_id}', 'EmrController@anamnesisStatusGeneralis');
	
	// Hapus Anamnesis
	Route::get('emr-soap-hapus-umum/{registrasi_id}/{id}', 'EmrController@hapusUmum');
	Route::get('emr-soap-hapus-riwayat/{registrasi_id}/{id}', 'EmrController@hapusRiwayat');

	// pemeriksaan()
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/tandavital/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@tandaVital');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/nutrisi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@nutrisi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fungsional/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@fungsional');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisik/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@fisik');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisikCommon/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@fisikUmum');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisikumum/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisikdalam/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaandalam');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisikobgyn/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanObgyn');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/penunjangInap/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanPenunjang');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/penunjangTHT/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanPenunjangTHT');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/diagnosis_banding/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@diagnosis_banding');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/diagnosis_kerja/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@diagnosis_kerja');
	
	// penilaian()
	Route::post('emr-soap/penilaian/fisik/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@fisikPost');
	Route::get('emr-soap/penilaian/fisik/{unit}/{registrasi_id}/{cppt_id}', 'Emr\EmrPenilaianController@fisik');
	Route::post('emr-soap/penilaian/obgyn/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@obgynPost');
	Route::get('emr-soap/penilaian/obgyn/{unit}/{registrasi_id}/{cppt_id}', 'Emr\EmrPenilaianController@obgyn');
	Route::post('emr-soap/penilaian/gigi/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@gigiPost');
	Route::get('emr-soap/penilaian/gigi/{unit}/{registrasi_id}/{cppt_id}', 'Emr\EmrPenilaianController@gigi');
	Route::match(['get', 'post'], 'emr-soap/penilaian/nyeri/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@nyeri');
	Route::match(['get', 'post'], 'emr-soap/penilaian/diagnosis/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@diagnosis');
	// Perencanaan
	Route::match(['get', 'post'], 'emr-soap/perencanaan/terapi/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@terapi');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/kontrol/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@kontrol');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/surat/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@surat');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/rujukan/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@rujukan');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/kematian/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@kematian');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/rujukanRS/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@rujukanRS');
    // Cetak Perencanaan
	Route::get('emr-soap-print-surat/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSurat');
	Route::get('emr-soap-print-surat-rujukan/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratrujukan');
	Route::get('emr-soap-print-surat-kematian/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratkematian');
	Route::get('emr-soap-print-surat-rujukan-rumahsakit/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratRujukanRS');

	//surat kematian
	Route::get('emr-soap/suratkematian/', 'EmrController@suratkematian');
	
	Route::get('emr/diet/{unit}/{registrasi_id}', 'EmrController@diet')->name('diet');
	Route::get('emr/odontogram/{unit}/{registrasi_id}', 'EmrController@odontogram')->name('odontogram');
	Route::post('emr-diet/diet/{unit}/{registrasi_id}', 'EmrController@saveDiet');
	Route::post('emr-odontogram/odontogram/{unit}/{registrasi_id}', 'EmrController@saveOdontogram');

	// JASA DOKTER
	Route::get('emr-jasa-dokter/{unit}/{registrasi_id}', 'EmrController@jasaDokter');
	Route::post('emr-jasa-dokter/{unit}/{registrasi_id}', 'EmrController@dataLaporanKinerja');

	// pengkajian harian
	Route::get('emr/pengkajian-harian/{unit}/{registrasi_id}', 'Emr\EmrPengkajianController@pengkajianHarian')->name('pengkajian-harian');
	Route::get('emr/pengkajian-harian/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'Emr\EmrPengkajianController@pengkajianHarian')->name('pengkajian-harian');
	Route::get('delete-emr-pengkajian-harian/{id}', 'Emr\EmrPengkajianController@deletePengkajianHarian');
	Route::post('save-emr-pengkajian-harian', 'Emr\EmrPengkajianController@savePengkajianHarian');
	Route::post('update-emr-pengkajian-harian', 'Emr\EmrPengkajianController@updatePengkajianHarian');
	Route::get('emr/duplicate-pengkajian-harian/{id}/{reg_id}', 'Emr\EmrPengkajianController@duplicatePengkajianHarian');


	// KONSUL
	Route::get('emr-jawabkonsul/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'Emr\EmrKonsulController@jawabKonsul');
	Route::post('emr-jawabkonsul', 'Emr\EmrKonsulController@saveJawabKonsul');
	Route::post('emr-update-jawabkonsul', 'Emr\EmrKonsulController@updateJawabKonsul');

	Route::get('emr-datakonsul/{konsul_id}', 'Emr\EmrKonsulController@dataKonsul');
	Route::get('emr-datajawabankonsul/{konsul_id}', 'Emr\EmrKonsulController@dataJawabanKonsul');
	Route::get('emr-konsuldokter/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'Emr\EmrKonsulController@konsulDokter');
	Route::post('emr-konsuldokter', 'Emr\EmrKonsulController@saveKonsulDokter');
	Route::post('emr-update-konsuldokter', 'Emr\EmrKonsulController@updateKonsulDokter');
});
