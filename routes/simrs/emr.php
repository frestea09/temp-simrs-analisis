<?php

use App\Http\Controllers\Emr\EmrKonsulController;

Route::group(['middleware' => ['web', 'auth']], function () {

	Route::match(['get', 'post'], 'emr-laporan-operasi/{registrasi_id}', 'EmrController@laporanOperasi')->name('laporan-operasi');
	Route::get('cetak-laporan-operasi/{registrasi_id}', 'EmrController@cetakLaporanOperasi');
	// SOAP PASIEN
	// Route::match(['get', 'post'], 'emr-soap-icd/icd10/{unit}/{registrasi_id}', 'Emr\EmrIcdController@icd10');
	Route::get('emr-surkon/{unit}/{registrasi_id}', 'Emr\EmrSurkonController@index')->name('emr-surkon');;

	Route::get('emr-soap-icd/icd10/{unit}/{registrasi_id}', 'Emr\EmrIcdController@icd10');
	Route::post('emr-soap-icd/icd10/{unit}/{registrasi_id}', 'Emr\EmrIcdController@icd10');

	// ICARE
	Route::get('emr-soap-icare/fkrtl/{unit}/{registrasi_id}', 'EmrController@fkrtl');

	// Form Kriteria ICU
	Route::get('emr/form-kriteria-masuk-icu/{unit}/{registrasi_id}', 'EmrController@formKriteriaMasukICU');
	Route::post('emr/form-kriteria-masuk-icu/{unit}/{registrasi_id}', 'EmrController@formKriteriaMasukICU');
	Route::get('emr/form-kriteria-keluar-icu/{unit}/{registrasi_id}', 'EmrController@formKriteriaKeluarICU');
	Route::post('emr/form-kriteria-keluar-icu/{unit}/{registrasi_id}', 'EmrController@formKriteriaKeluarICU');
	Route::get('emr-print/cetak-kriteria-masuk-icu/{unit}/{registrasi_id}/{id}', 'EmrController@cetakKriteriaMasukICU');
	Route::get('emr-print/cetak-kriteria-keluar-icu/{unit}/{registrasi_id}/{id}', 'EmrController@cetakKriteriaKeluarICU');

	Route::post('emr-soap-icd/icd10/{id}', 'Emr\EmrIcdController@icd10Destroy');
	Route::post('emr-soap-icd/icd9/{id}', 'Emr\EmrIcdController@icd9Destroy');
	Route::match(['get', 'post'], 'emr-soap-icd/icd9/{unit}/{registrasi_id}', 'Emr\EmrIcdController@icd9');


	Route::post('emr/save-riwayat', 'EmrController@saveRiwayat');
	Route::post('emr/save-tindakan', 'EmrController@saveTindakan');

	// EREEP
	Route::get('emr/eresep/use-template-eresep/{registrasi_id}/{unit}/{uuid}', 'EmrController@useTemplateEresep');
	Route::get('emr/eresep/use-template-eresep/delete/{id}', 'EmrController@useTemplateEresepDelete');
	Route::get('emr/eresep/use-template-eresep/share/{id}', 'EmrController@useTemplateEresepShare');
	Route::get('emr/eresep/{unit}/{registrasi_id}', 'EmrController@eresep')->name('eresep');
	Route::get('emr/eresep/edit-template/{unit}/{registrasi_id}/{uuid}', 'EmrController@editEresep')->name('edit-eresep');
	Route::get('emr/eresep/cancel-use-template/{unit}/{registrasi_id}/{uuid}', 'EmrController@cancelEresep')->name('cancel-eresep');

	// ERESEP RACIK
	Route::get('emr/eresep-racikan/{unit}/{registrasi_id}', 'EmrController@eresepRacikan')->name('eresep-racikan');

	Route::get('emr/{unit}', 'EmrController@index');
	Route::post('emr/{unit}', 'EmrController@index_byTanggal')->name('emr');
	Route::get('emr/duplicate-soap/{id}/{dokter}/{poli}/{reg_id}', 'EmrController@duplicateSoap');
	Route::get('emr/duplicate-soap-perawat/{id}/{dokter}/{poli}/{reg_id}', 'EmrController@duplicateSoapPerawat');
	Route::get('emr/duplicate-soap-gizi/{id}/{reg_id}', 'EmrController@duplicateSoapGizi');
	Route::get('emr/duplicate-soap-farmasi/{id}/{reg_id}', 'EmrController@duplicateSoapFarmasi');
	Route::get('emr/move-cppt/{id}/{reg_id}', 'EmrController@moveCppt');


	Route::get('emr-list-soap/{unit}/{reg_id}/{pasien_id}', 'EmrController@listSoap')->name('list-soap');
	Route::get('emr-list-tindakan/{unit}/{reg_id}/{pasien_id}', 'EmrController@listTindakan')->name('list-soap');

	Route::get('emr/{unit}/{registrasi_id}', 'EmrController@create')->name('medical_history');
	Route::get('emr/soap/{unit}/{registrasi_id}', 'EmrController@soap')->name('soap');
	Route::get('emr/soap/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'EmrController@soap')->name('soap');
	Route::get('emr/soap-delete/{unit}/{registrasi_id}/{id_soap}', 'EmrController@soapDelete')->name('soap.delete');
	Route::get('emr/soap_perawat/{unit}/{registrasi_id}', 'EmrController@soap_perawat')->name('soap_perawat');
	Route::get('emr/soap_perawat/{unit}/{registrasi_id}/{id_soap_perawat?}/{edit?}', 'EmrController@soap_perawat')->name('soap_perawat');
	Route::get('emr/soap-gizi/{unit}/{registrasi_id}', 'EmrController@soapGizi')->name('soap-gizi');
	Route::get('emr/soap-gizi/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'EmrController@soapGizi')->name('soap-gizi');
	Route::get('emr-soap-verif-dpjp/{id_soap}', 'EmrController@verifDPJP');
	Route::get('emr/soap-gizi-delete/{id_soap}/delete', 'EmrController@soapGiziDelete')->name('soap-gizi-delete');
	Route::get('emr/soap-farmasi/{unit}/{registrasi_id}', 'EmrController@soapFarmasi')->name('soap-farmasi');
	Route::get('emr/soap-farmasi/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'EmrController@soapFarmasi')->name('soap-farmasi');
	Route::get('emr/soap-farmasi-delete/{id_soap}/delete', 'EmrController@soapFarmasiDelete')->name('soap-farmasi-delete');
	Route::get('pemeriksaan-fisik/{unit}/{registrasi_id}', 'EmrController@pemeriksaanfisik')->name('pemeriksaan_fisik');

	Route::get('emr/rad/{unit}/{registrasi_id}', 'EmrController@rad')->name('rad');
	Route::get('emr/ris/{unit}/{registrasi_id}', 'EmrController@ris')->name('ris');
	Route::get('emr/lab/{unit}/{registrasi_id}', 'EmrController@lab')->name('lab');
	Route::get('emr/labPatalogiAnatomi/{unit}/{registrasi_id}', 'EmrController@labPatalogiAnatomi')->name('labPatalogiAnatomi');
	Route::get('emr/get-tindakan-pa/{katTarif}/{unit}', 'EmrController@getTindakanPA');
	Route::get('emr/lab-paket/{unit}/{registrasi_id}', 'EmrController@labPaket')->name('lab-paket');
	Route::get('emr/poli/{unit}/{registrasi_id}', 'EmrController@orderPoli')->name('order_poli');

	Route::get('emr/cetak-lis/{no_lab}/{registrasi_id}', 'EmrController@cetakLis')->name('cetakLis');
	Route::match(['get', 'post'], 'cetak-lis-pdf/{no_lab}/{registrasi_id}', 'EmrController@cetakLisPdf')->name('cetakLis');
	Route::match(['get', 'post'], 'cetak-lis-all-pdf/{registrasi_id}', 'EmrController@cetakLisAllPdf')->name('cetakLisAll');



	Route::post('save-emr', 'EmrController@save');
	Route::post('update-soap', 'EmrController@updateSoap');
	Route::post('save-emr-perawat', 'EmrController@savePerawat');
	Route::post('update-soap-perawat', 'EmrController@updateSoapPerawat');
	Route::post('save-emr-gizi', 'EmrController@saveGizi');
	Route::post('update-soap-gizi', 'EmrController@updateSoapGizi');
	Route::post('save-emr-farmasi', 'EmrController@saveFarmasi');
	Route::post('update-soap-farmasi', 'EmrController@updateSoapFarmasi');
	Route::get('cetak-emr/{registrasi_id}', 'EmrController@cetakResume');
	Route::delete('emr/{id}', 'EmrController@deleteResume');
	Route::get('cetak-emr/pdf/{registrasi_id}', 'EmrController@cetakPDFResume');
	Route::get('cetak-emr-rencana-kontrol/pdf/{registrasi_id}', 'EmrController@cetakPDFResumeRencanaKontrol');
	Route::get('soap/history/{unit}/{pasienId}', 'EmrController@historySoap');
	Route::get('soap/history-filter/{unit}/{regId}', 'EmrController@filterHistorySoap');
	Route::get('soap/history-gizi/{pasienId}', 'EmrController@historyGizi');
	Route::get('soap/history-farmasi/{pasienId}', 'EmrController@historyFarmasi');
	Route::get('soap/list-kontrol/{tgl}/{dokterId}', 'EmrController@modalListKontrol');

	Route::get('emr/pemeriksaan-rad/{unit}/{registrasi_id}', 'EmrController@pemeriksaanRad')->name('pemeriksaan-rad');
	Route::get('emr/pemeriksaan-penunjang/{unit}/{registrasi_id}', 'EmrController@pemeriksaanPenunjang')->name('pemeriksaan-penunjang');
	Route::get('emr/pemeriksaan-lab/{unit}/{registrasi_id}', 'EmrController@pemeriksaanLab')->name('pemeriksaan-lab');
	Route::get('emr/pemeriksaan-lab-pa/{unit}/{registrasi_id}', 'EmrController@pemeriksaanLabPA')->name('pemeriksaan-lab-pa');
	Route::get('emr/pemeriksaan-laporan-operasi/{unit}/{registrasi_id}', 'EmrController@pemeriksaanLaporanOperasi')->name('pemeriksaan-laporan-operasi');
	Route::get('emr/pemeriksaan-laporan-operasi/cetak/{unit}/{registrasi_id}/{id}', 'EmrController@cetakLaporanOperasi')->name('cetak-laporan-operasi');
	Route::get('emr/resume/{unit}/{registrasi_id}', 'EmrController@resume')->name('emr-resume');
	Route::get('emr/resume-gizi/{unit}/{registrasi_id}', 'EmrController@resumeGizi')->name('emr-resume-gizi');


	Route::post('emr/editDokter/{id}/{registrasi_id}', 'EmrController@editDokter');

	// EMR NEW
	// Anamnesis
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


	// Hapus Anamnesis
	Route::get('emr-soap-hapus-umum/{registrasi_id}/{id}', 'EmrController@hapusUmum');
	Route::get('emr-soap-hapus-riwayat/{registrasi_id}/{id}', 'EmrController@hapusRiwayat');

	// pemeriksaan()
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/status-igd/{registrasi_id}', 'Emr\EmrPemeriksaanController@statusIGD');
	Route::get('emr-soap/ajax-faskes', 'Emr\EmrPemeriksaanController@ajaxFaskes');
	Route::get('emr-soap/ajax-faskes-rs', 'Emr\EmrPemeriksaanController@ajaxFaskesRS');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/triage-igd/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@triageGawatDarurat');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/triage-igd-awal/{triageId?}', 'Emr\EmrPemeriksaanController@triageGawatDaruratAwal');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen-igd/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@gawatDarurat');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen-igd-ponek/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@gawatDaruratPonek');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen-igd-awal-perawat/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@gawatDaruratAsesmentAwal');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/penelusuran-obat-igd/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@penelusuranObat');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/tandavital/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@tandaVital');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/nutrisi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@nutrisi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fungsional/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@fungsional');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisik/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@fisik');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisikCommon/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@fisikUmum');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asuhanBidan/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@asuhanBidan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asuhanKeperawatan/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@asuhanKeperawatan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/mata/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@mata');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/gigi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@gigi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/gizi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@gizi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/rehab-medik/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@rehabMedik');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/obgyn/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@obgyn');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/awal-obgyn/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalObgynDokter');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/hemodialisis/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@hemodialisis');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/laporan-hemodialisis/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@laporanHemodialisis');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/paru/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@paru');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/awal-mcu/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMCU');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/mcu/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@mcu');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/mcu/hasil/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@hasilMCU');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/layananRehab/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@layananRehab');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/programTerapi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@programTerapi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/ujiFungsi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@ujiFungsi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/rehabBaru/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@rehabBaru');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisikumum/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisikdalam/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaandalam');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/fisikobgyn/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanObgyn');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/penunjangInap/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanPenunjang');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/penunjangTHT/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanPenunjangTHT');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/diagnosis_banding/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@diagnosis_banding');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/diagnosis_kerja/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@diagnosis_kerja');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/akses_vaskular_hemodialis/{unit}/{registrasi_id}/{id?}', 'Emr\EmrPemeriksaanController@akses_vaskular_hemodialis');

	// Asesmen Inap
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/maternitas/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@maternitas');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/perinatologi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@perinatologi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_tht/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisTHT');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_dalam/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisDalam');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_paru/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisParu');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_psikiatri/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisPsikiatri');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_kulit/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisKulit');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_bedah/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisBedah');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_gigi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisGigi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_neurologi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisNeurologi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_mata/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisMata');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_bedah_mulut/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisBedahMulut');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_rehab_medik/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisRehabMedik');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_gizi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisGizi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_onkologi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisOnkologi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_anak/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisAnak');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_obgyn/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisObgyn');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_neonatus/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisNeonatus');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/pemantauan-transfusi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemantauanTransfusi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_anak_perawat/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@asesmenAnakPerawat');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/apgar_score/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@apgarScore');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/ballard_score/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@ballardScore');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/usia_kehamilan/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@usiaKehamilan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/tindakan_keperawatan/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@tindakanKeperawatan');

	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_apgar_score/{registrasi_id}/{riwayat_id}', 'Emr\EmrPemeriksaanController@cetakapgarScore');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_pengkajian_gizi/{registrasi_id}/{riwayat_id}', 'Emr\EmrPemeriksaanController@cetak_pengkajian_gizi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_ballard_score/{registrasi_id}', 'Emr\EmrPemeriksaanController@cetakballardScore');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_observasi_obgyn/{registrasi_id}', 'Emr\EmrPerencanaanController@cetakobservasiObgyn');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_laporan_persalinan/{registrasi_id}', 'Emr\EmrPemeriksaanController@cetaklaporanPersalinan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_laporan_kuret/{registrasi_id}', 'Emr\EmrPerencanaanController@cetaklaporanKuret');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_catatan_persalinan/{registrasi_id}', 'Emr\EmrPemeriksaanController@cetakcatatanPersalinan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_catatan_handOver/{registrasi_id}', 'Emr\EmrPemeriksaanController@cetakcatatanHandOver');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_partograf/{registrasi_id}', 'Emr\EmrPemeriksaanController@cetakPartograf');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_catatan_intake_output/{registrasi_id}/{riwayat_id}', 'Emr\EmrPemeriksaanController@cetakIntakeOutput');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/cetak_lembar_kendali_regimen/{registrasi_id}/{riwayat_id}', 'Emr\EmrPemeriksaanController@cetakLembarKendaliRegimen');

	// Cetak Pemeriksaan
	Route::get('emr-soap-print/cetak-pemantauan-transfusi/{id}', 'Emr\EmrPemeriksaanController@cetakPemantauanTransfusi');
	Route::get('emr-soap-print/cetak-mcu/{id}', 'Emr\EmrPemeriksaanController@cetakMCU');
	Route::get('emr-soap-print/cetak-hasil-mcu/{id}', 'Emr\EmrPemeriksaanController@cetakHasilMCU');
	Route::get('emr-soap-print/cetak-pre-operatif/{id}', 'Emr\EmrPemeriksaanController@cetakIBS');
	Route::get('emr-soap-print/cetak-dokumen-pemberian-informasi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@cetakPemberianInformasi');
	Route::get('emr-soap-print/cetak-hasil-penunjang/{registrasi_id}/{id}', 'Emr\EmrPemeriksaanController@cetakHasilPenunjang');
	Route::get('emr-soap-print/cetak-pemberian-terapi/{unit}/{registrasi_id}/{id}', 'Emr\EmrPemeriksaanController@cetakPemberianTerapi');
	Route::get('emr-soap-print/cetak-rekonsiliasi-obat/{unit}/{registrasi_id}/{id}', 'Emr\EmrPemeriksaanController@cetakRekonsiliasiObat');
	Route::get('emr-soap-print/cetak-akses-vaskular-hemodialis/{unit}/{registrasi_id}/{id}', 'Emr\EmrPemeriksaanController@cetakAksesVaskularHemodialisis');
	Route::get('emr-soap-print/cetak-laporan-hemodialisis/{unit}/{registrasi_id}/{id}', 'Emr\EmrPemeriksaanController@cetakLaporanHemodialisis');

	// ICU
	Route::match(['get', 'post'], 'emr/icu/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@icu');

	// SBAR
	Route::get('emr/sbar/{unit}/{registrasi_id}', 'EmrController@SBAR');
	Route::get('cetak-eresume-transfer-internal/{id}', 'EmrController@cetakSBAR');
	Route::get('cetak-eresume-transfer-internal-tte/{id}', 'EmrController@cetakTTESBAR');
	Route::post('tte-transfer-internal/{id}', 'EmrController@tteSBAR');

	Route::post('save-emr-sbar', 'EmrController@saveSBAR');
	Route::post('update-emr-sbar', 'EmrController@updateSBAR');
	Route::get('emr/duplicate-emr-sbar/{id}/{dokter}/{poli}/{reg_id}', 'EmrController@duplicateSBAR');
	Route::get('emr/sbar/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'EmrController@SBAR');
	
	// SBAR v2
	Route::post('save-emr-sbar-new', 'EmrController@saveSBARNew');
	Route::post('update-emr-sbar-new', 'EmrController@updateSBARNew');
	Route::get('cetak-eresume-transfer-internal-new/{id}', 'EmrController@cetakSBARNew');
	Route::get('emr/duplicate-emr-sbar-new/{id}/{reg_id}', 'EmrController@duplicateSBARNew');
	Route::get('emr/sbar-delete/{unit}/{registrasi_id}/{id_sbar}', 'EmrController@deleteSBAR')->name('sbar.delete');

	// TTE Pemeriksaan
	Route::get('cetak-tte-mcu/pdf/{registrasi_id}/{id}', 'Emr\EmrPemeriksaanController@cetakTTEPDFMCU');
	Route::post('tte-pdf-mcu', 'Emr\EmrPemeriksaanController@ttePDFMCU');
	Route::get('cetak-tte-hasil-mcu/pdf/{registrasi_id}/{id}', 'Emr\EmrPemeriksaanController@cetakTTEPDFHasilMCU');
	Route::post('tte-pdf-hasil-mcu', 'Emr\EmrPemeriksaanController@ttePDFHasilMCU');

	//TTE Perencanaan
	Route::get('cetak-tte-kir-sehat/pdf/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakTTEPDFKIRSehat');
	Route::post('tte-pdf-kir-sehat', 'Emr\EmrPerencanaanController@ttePDFKIRSehat');

	//OK
	Route::match(['get', 'post'], 'emr-soap/operasi/main/{unit}/{registrasi_id}', 'EmrController@operasiMain');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/pre-operatif/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@ibs')->name('ibs');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/pra-anestesi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@praAnestesi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/laporan-operasi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@laporanOperasi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/laporan-operasi-ranap/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@laporanOperasiRanap');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/laporan-operasi-ods/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@laporanOperasiODS');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen-pra-bedah/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@asesmenPraBedah');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/daftar-tilik-operasi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@daftarTilik');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/kartu-anestesi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@kartuAnestesi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/keadaan-pasca-bedah/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@keadaanPascaBedah');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/upload-laporan-operasi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@uploadLaporanOperasi');

	//Aswal Medis (Dokter) Inap
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen_awal_medis_pasien_anak/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@awalMedisAnak');

	//Aswal Perawat Inap
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/asesmen-inap-perawat-dewasa/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@asesmenInapPerawatDewasa');

	//Skrining Inap
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan-gizi/inap/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanGizi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan-gizi-anak/inap/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanGiziAnak');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan-gizi-maternitas/inap/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanGiziMaternitas');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan-gizi-perinatologi/inap/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanGiziPerinatologi');
	Route::match(['get', 'post'], 'emr-soap/asuhan-gizi-terintegrasi/inap/{registrasi_id}', 'Emr\EmrPemeriksaanController@asuhanGizi');

	//Ulang Inap
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/nyeri-inap/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@nyeriInap');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/resiko-jatuh-dewasa-inap/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@resikoJatuhDewasaInap');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/resiko-jatuh-anak-inap/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@resikoJatuhAnakInap');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/resiko-jatuh-neonatus-inap/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@resikoJatuhNeonatusInap');

	//Edukasi Inap
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/edukasi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@edukasiInap');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/formulir-edukasi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@formulirEdukasiInap');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/formulir-edukasi-gizi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@formulirEdukasiGizi')->name('form.edukasi.gizi');

	// Riwayat Pemeriksaan
	Route::get('emr-riwayat-askep/{pasien_id}', 'Emr\EmrPemeriksaanController@historyAskep'); //Askep
	Route::post('emr-riwayat-askep/delete/{askep_id}', 'Emr\EmrPemeriksaanController@historyAskepDelete'); //Hapus Askep
	Route::get('emr-askep/delete/{askep_id}', 'Emr\EmrPemeriksaanController@askepDelete'); //Hapus Askep
	Route::post('emr-riwayat-askep/tte', 'Emr\EmrPemeriksaanController@TTEAskep'); //TTE Askep
	// Riwayat Pemeriksaan
	Route::get('emr-riwayat-askeb/{pasien_id}', 'Emr\EmrPemeriksaanController@historyAskeb'); //Askeb
	Route::post('emr-riwayat-askeb/delete/{askeb_id}', 'Emr\EmrPemeriksaanController@historyAskebDelete'); //Hapus Askeb
	Route::get('emr-askeb/delete/{askeb_id}', 'Emr\EmrPemeriksaanController@askebDelete'); //Hapus Askeb
	Route::post('emr-riwayat-askeb/tte', 'Emr\EmrPemeriksaanController@TTEAskeb'); //TTE Askeb
	// Hapus Pemeriksaan
	Route::get('emr-soap-hapus-pemeriksaan/{unit}/{reg_id}/{id}', 'Emr\EmrPemeriksaanController@hapusPemeriksaan');

	// Rekonsiliasi
	Route::get('rekonsiliasi/hapus/{registrasi_id}/{index}', 'Emr\EmrPemeriksaanController@hapusRekonsiliasi')->name('rekonsiliasi.hapus');
	// Alergi
	Route::get('alergi/hapus/{registrasi_id}/{index}', 'Emr\EmrPemeriksaanController@hapusAlergi')->name('alergi.hapus');
			
	// Pengantar
	Route::get('emr-soap/pemeriksaan/pengantar/{unit}/{reg_id}', 'Emr\EmrPemeriksaanController@pengantar');



	// penilaian()
	Route::post('emr-soap/penilaian/fisik/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@fisikPost');
	Route::get('emr-soap/penilaian/fisik/{unit}/{registrasi_id}/{cppt_id?}', 'Emr\EmrPenilaianController@fisik');
	Route::post('emr-soap/penilaian/prostodonti/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@prostodontiPost');
	Route::get('emr-soap/penilaian/prostodonti/{unit}/{registrasi_id}/{cppt_id?}', 'Emr\EmrPenilaianController@prostodonti');
	Route::get('emr-soap-print-prostodonti/{registrasi_id}', 'Emr\EmrPenilaianController@cetakProstodonti');
	// Route::get('emr-soap/penilaian/fisik/{unit}/{registrasi_id}/{cppt_id}', 'Emr\EmrPenilaianController@fisik');
	Route::post('emr-soap/penilaian/obgyn/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@obgynPost');
	Route::get('emr-soap/penilaian/obgyn/{unit}/{registrasi_id}/{cppt_id?}', 'Emr\EmrPenilaianController@obgyn');
	// Route::get('emr-soap/penilaian/obgyn/{unit}/{registrasi_id}/{cppt_id}', 'Emr\EmrPenilaianController@obgyn');
	Route::post('emr-soap/penilaian/gigi/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@gigiPost');
	Route::get('emr-soap/penilaian/gigi/{unit}/{registrasi_id}/{cppt_id?}', 'Emr\EmrPenilaianController@gigi');
	// Route::get('emr-soap/penilaian/gigi/{unit}/{registrasi_id}/{cppt_id}', 'Emr\EmrPenilaianController@gigi');
	Route::post('emr-soap/penilaian/hemodialisis/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@hemodialisisPost');
	Route::get('emr-soap/penilaian/hemodialisis/{unit}/{registrasi_id}/{cppt_id?}', 'Emr\EmrPenilaianController@hemodialisis');
	Route::post('emr-soap/penilaian/paru/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@paruPost');
	Route::get('emr-soap/penilaian/paru/{unit}/{registrasi_id}/{cppt_id?}', 'Emr\EmrPenilaianController@paru');
	Route::post('emr-soap/penilaian/mata1/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@mata1Post');
	Route::get('emr-soap/penilaian/mata1/{unit}/{registrasi_id}/{cppt_id?}', 'Emr\EmrPenilaianController@mata1');
	Route::post('emr-soap/penilaian/mata2/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@mata2Post');
	Route::get('emr-soap/penilaian/mata2/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@mata2');
	Route::post('emr-soap/penilaian/mata3/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@mata3Post');
	Route::get('emr-soap/penilaian/mata3/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@mata3');
	Route::post('emr-soap/penilaian/kulit/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@kulitPost');
	Route::get('emr-soap/penilaian/kulit/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@kulit');
	Route::post('emr-soap/penilaian/bedah-mulut/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@bedahMulutPost');
	Route::get('emr-soap/penilaian/bedah-mulut/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@bedahMulut');
	Route::match(['get', 'post'], 'emr-soap/penilaian/nyeri/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@nyeri');
	Route::match(['get', 'post'], 'emr-soap/penilaian/diagnosis/{unit}/{registrasi_id}', 'Emr\EmrPenilaianController@diagnosis');
	// Perencanaan
	Route::match(['get', 'post'], 'emr-soap/perencanaan/terapi/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@terapi');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/kontrol/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@kontrol');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/surat/{unit}/{registrasi_id}/{item_id?}/{method?}', 'Emr\EmrPerencanaanController@surat');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/menolak-rujuk/{unit}/{registrasi_id}/{item_id?}/{method?}', 'Emr\EmrPerencanaanController@menolakRujuk');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/kir-sehat/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@kirSehat');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/rujukan/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@rujukan');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/kematian/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@kematian');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/rujukanRS/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@rujukanRS');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/visum/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@visum');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/catatanKhusus/{unit}/{registrasi_id}/{id_record?}/{method?}', 'Emr\EmrPerencanaanController@catatanKhusus');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/informedConsent/{unit}/{registrasi_id}/{record_id?}/{method?}', 'Emr\EmrPerencanaanController@informedConsent');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/treadmill/{unit}/{registrasi_id}/{id_record?}/{method?}', 'Emr\EmrPerencanaanController@treadmill');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/catatan-transfer-internal/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@catatanTransferInternal');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/sbar/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@sbar');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/tindakan-rj/{unit}/{registrasi_id}/{record_id?}/{method?}', 'Emr\EmrPerencanaanController@laporanTindakanRJ');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/surat-paps/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@suratPaps');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/pernyataan-persetujuan-rawat-nicu/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@persetujuanNICU');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/inap/persetujuan-tindakan/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@persetujuanTindakan');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/inap/pulang-pasien/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@pulangPasien');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/inap/surat-dpjp/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@suratDPJP');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/inap/lembar-observasi-obgyn/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@lembarObservasiObgyn');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/konsultasi-gizi/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@konsulGizi');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/inap/laporan-kuret/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@laporanKuret');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/sertifikat-kematian/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@sertifikatKematian');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/permohonan-vaksinasi/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@permohonanVaksinasi');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/persetujuan-vaksinasi/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@persetujuanVaksinasi');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/daftar-tilik-vaksinasi/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@daftarTilikVaksinasi');
	
	// Resume
	Route::match(['get', 'post'], 'emr-soap/perencanaan/inap/resume/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@resume');
	Route::match(['get', 'post'], 'emr-inap-perencanaan/update-icd', 'Emr\EmrPerencanaanController@icdUpdateResume')->name('emr_inap_perencanaan.update_icd');
	Route::match(['get', 'post'], 'emr-soap/perencanaan/igd/resume/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@resumeIGD');
	Route::match(['get', 'post'], 'emr-inap-perencanaan/update-icd-igd', 'Emr\EmrPerencanaanController@icdUpdateResumeIGD')->name('emr_resume.update_icd');
	
	//Hapus perencanaan
	Route::get('emr-soap-delete/{unit}/{reg_id}/{id}', 'Emr\EmrPerencanaanController@hapusPerencanaan');
	Route::get('delete-emr-soap-surat-rujukan-rumahsakit/{id}', 'Emr\EmrPerencanaanController@deleteSuratRujukanRS');
	Route::get('emr-soap-delete/perencanaan/tindakan-rj/{unit}/{reg_id}/{id}', 'Emr\EmrPerencanaanController@hapusPerencanaan');
	Route::get('emr-soap-delete/perencanaan/kir-sehat/{unit}/{reg_id}/{id}', 'Emr\EmrPerencanaanController@hapusPerencanaan');

	// Cetak Perencanaan
	Route::get('emr-soap-print-surat/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSurat');
	Route::get('emr-soap-print-surat-byreg/{registrasi_id}', 'Emr\EmrPerencanaanController@cetakSuratReg');
	Route::match(['get', 'post'], 'emr-soap-print-surat-rujukan/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratrujukan');
	Route::get('emr-soap-print-surat-kematian/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratkematian');
	Route::get('emr-soap-print-tte-surat-kematian/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakTTEPDFSuratKematian');
	Route::post('tte-emr-soap-surat-kematian/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@ttePDFSuratKematian');
	Route::get('emr-soap-print-sertifikat-kematian/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSertifikatkematian');
	Route::get('emr-soap-print-tte-sertifikat-kematian/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakTTEPDFSertifikatKematian');
	Route::post('tte-emr-soap-sertifikat-kematian/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@ttePDFSertifikatKematian');
	Route::post('tte-emr-soap-laporan-kuret/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@ttePDFSertifikatKuret');
	Route::get('emr-soap-print-surat-rujukan-rumahsakit/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratRujukanRS');
	Route::get('emr-soap-print-surat-visum/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakVisum');
	Route::get('emr-soap-print-laporan-tindakan-rj/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakLapTindakanRJ');
	Route::get('emr-soap-print-surat-paps/{unit}/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratPaps');
	Route::get('emr-soap-print-surat-menolak-rujuk/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratMenolakRujuk');
	Route::get('emr-soap-print-surat-persetujuan-nicu/{unit}/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakPersetujuanNICU');
	Route::get('emr-soap-print-surat-persetujuan-tindakan/{unit}/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakPersetujuanTindakan');
	Route::get('emr-soap-print-surat-dpjp/{unit}/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratDPJP');
	Route::get('emr-soap-print-informedConsentPersetujuan/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakinformedConsentPersetujuan');
	Route::get('emr-soap-print-informedConsentPenolakan/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakinformedConsentPenolakan');
	Route::get('emr-soap-print-informedConsentPenundaan/{registrasi_id}', 'Emr\EmrPerencanaanController@cetakinformedConsentPenundaan');
	Route::get('emr-soap-print-surat-perencanaan-pasien-pulang/{unit}/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakPerencanaanPasienPulang');
	Route::get('emr-soap-print-kir-sehat/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@cetakKirSehat');
	Route::get('emr-soap-print-permohonan-vaksinasi/{unit}/{id}', 'Emr\EmrPerencanaanController@cetakPermohonanVaksinasi');
	Route::get('emr-soap-print-persetujuan-vaksinasi/{unit}/{id}', 'Emr\EmrPerencanaanController@cetakPersetujuanVaksinasi');
	Route::get('emr-soap-print-daftar-tilik-vaksinasi/{unit}/{id}', 'Emr\EmrPerencanaanController@cetakDaftarTilikVaksinasi');

	Route::get('emr/diet/{unit}/{registrasi_id}', 'EmrController@diet')->name('diet');
	Route::get('emr/diet-gizi/{unit}/{registrasi_id}', 'EmrController@dietGizi')->name('diet.gizi');
	Route::get('emr/odontogram/{unit}/{registrasi_id}', 'EmrController@odontogram')->name('odontogram');
	Route::post('emr-diet/diet/{unit}/{registrasi_id}', 'EmrController@saveDiet');
	Route::post('emr-diet-gizi/diet/{unit}/{registrasi_id}', 'EmrController@saveDiet');
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
	Route::get('emr/{unit}/{registrasi_id}', [EmrKonsulController::class,'create'])->name('medical_history');
	Route::get('emr-jawabkonsul/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'Emr\EmrKonsulController@jawabKonsul');
	Route::post('emr-jawabkonsul', 'Emr\EmrKonsulController@saveJawabKonsul');
	Route::post('emr-update-jawabkonsul', 'Emr\EmrKonsulController@updateJawabKonsul');
	Route::post('emr-delete-jawabkonsul', 'Emr\EmrKonsulController@deleteJawabKonsul');
	Route::post('emr-update-jawabkonsul-ajax', 'Emr\EmrKonsulController@updateJawabKonsulAjax');
	Route::get('emr-konsul/verif', 'Emr\EmrKonsulController@verifKonsul');
	Route::post('emr-konsul/verif', 'Emr\EmrKonsulController@verifKonsulFilter');
	Route::get('emr-konsul/proses-verif/{idKonsul}', 'Emr\EmrKonsulController@verifKonsulProses');

	Route::get('emr-datakonsul/{konsul_id}', 'Emr\EmrKonsulController@dataKonsul');
	Route::get('emr-datajawabankonsul/{konsul_id}', 'Emr\EmrKonsulController@dataJawabanKonsul');
	Route::get('emr-konsuldokter/{unit}/{registrasi_id}/{id_soap?}/{edit?}', 'Emr\EmrKonsulController@konsulDokter');
	Route::post('emr-konsuldokter', 'Emr\EmrKonsulController@saveKonsulDokter');
	Route::post('emr-update-konsuldokter', 'Emr\EmrKonsulController@updateKonsulDokter');
	Route::get('emr-konsul/getDokterPoli/{poli_id}', 'Emr\EmrKonsulController@getDokterPoli');
	Route::post('emr-konsul/buat-cetak-konsul', 'Emr\EmrKonsulController@buatCetakKonsul');
	Route::get('emr-konsul/cetak-konsul/{registrasi_id}/{konsul_id}', 'Emr\EmrKonsulController@cetakKonsul');

	Route::get('emr-soap-print-surat-pemindahan/{registrasi_id}/{id}', 'Emr\EmrPerencanaanController@cetakSuratPemindahan');

	Route::match(['get', 'post'], 'emr-anestesi-inap/{registrasi_id}/{record_id?}/{method?}', 'Emr\EmrPerencanaanController@anestesi')->name('anestesi-emr');
	Route::match(['get', 'post'], 'emr-anestesi-cetak-inap/{record_id}', 'Emr\EmrPerencanaanController@cetakAnestesi');

	Route::get('emr-get-askep', 'Emr\EmrPemeriksaanController@getAskep');

	// EMR EWS
	Route::match(['get', 'post'], 'emr-ews-dewasa/{unit?}/{registrasi_id?}/{ass_id?}/{method?}', 'Emr\EmrEwsController@dewasa')->name('ews-dewasa');
	Route::match(['get', 'post'], 'emr-ews-maternal/{unit?}/{registrasi_id?}/{ass_id?}/{method?}', 'Emr\EmrEwsController@maternal')->name('ews-maternal');
	Route::match(['get', 'post'], 'emr-ews-anak/{unit?}/{registrasi_id?}/{ass_id?}/{method?}', 'Emr\EmrEwsController@anak')->name('ews-anak');
	Route::match(['get', 'post'], 'emr-ews-neonatus/{unit?}/{registrasi_id?}/{ass_id?}/{method?}', 'Emr\EmrEwsController@neonatus')->name('ews-neonatus');
	Route::get('get-ews/{reg_id}', 'Emr\EmrEwsController@getEws');

	//Echocardiogram
	Route::match(['get', 'post'], 'emr-soap/echocardiogram/{unit}/{registrasi_id}', 'Emr\EmrPerencanaanController@echocardiogram');
	
	// Gizi
	Route::match(['get', 'post'], 'emr-soap/pengkajian-gizi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pengkajianGizi');
	Route::get('emr-soap/riwayat/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@riwayat');

	// UPLOAD HASIL PEMERIKSAAN
	Route::match(['get', 'post'], 'emr/upload-hasil/usg/{unit}/{registrasi_id}', 'EmrController@uploadHasilUSG');
	Route::match(['get', 'post'], 'emr/upload-hasil/ekg/{unit}/{registrasi_id}', 'EmrController@uploadHasilEKG');
	Route::match(['get', 'post'], 'emr/upload-hasil/ctg/{unit}/{registrasi_id}', 'EmrController@uploadHasilCTG');
	Route::match(['get', 'post'], 'emr/upload-hasil/lain/{unit}/{registrasi_id}', 'EmrController@uploadHasilLain');
	Route::get('emr-hasil-pemeriksaan/hapus-hasil-pemeriksaan/{id}', 'EmrController@hapusHasilPemeriksaan');
	Route::get('emr/cetak/usg/{unit}/{registrasi_id}', 'EmrController@cetakUSG');

	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/form-surveilans-infeksi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@surveilansInfeksi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/partograf/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@partograf');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@daftarPemberianTerapi');
	Route::post('emr-soap/pemeriksaan/mark-done/daftar-pemberian-terapi/{id}', 'Emr\EmrPemeriksaanController@markDoneDaftarPemberianTerapi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/catatan-persalinan/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@catatanPersalinan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/laporan-persalinan/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@laporanPersalinan');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/hand-over-pasien/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@handOverPasien');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/catatan-intake-output/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@catatanIntakeOutput');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/lembar-kendali-regimen/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@lembarKendaliRegimen');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/lembar-rawat-gabung/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@lembarRawatGabung');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/pemeriksaan-fisik-askep/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pemeriksaanFisikAskep');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/daftar-kontrol-istimewa/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@daftarKontrolIstimewa');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/dokumen-pemberian-informasi/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@dokumenPemberianInformasi');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/pernyataan-dnr/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@pernyataanDNR');
	Route::match(['get', 'post'], 'emr-soap/pemeriksaan/inap/catatan-harian/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@catatanHarian');

 	Route::get('emr-soap/pemeriksaan/inap/daftar-kontrol-istimewa-cetak/{unit}/{registrasi_id}', 'Emr\EmrPemeriksaanController@cetakDaftarKontrolIstimewa');

	// TTE
	Route::get('emr-soap-file-tte/{id}/{type}', 'Emr\EmrPemeriksaanController@getTteFile');
	Route::post('emr-soap/tte/tte-triage/{id}', 'Emr\EmrPemeriksaanController@tteTriage');
	
	// Upload Surat
	Route::post('emr-soap-upload-surat-paps', 'Emr\EmrPerencanaanController@uploadSuratPaps');

	// Clinical Pathway
	Route::get('clinicalpathway/{path?}', 'Emr\EmrPerencanaanController@clinicalPathway')->where('path', '.*');
});