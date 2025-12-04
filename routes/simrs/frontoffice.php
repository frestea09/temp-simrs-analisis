<?php

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::view('frontoffice/antrian-rawat-jalan', 'frontoffice.antrian-rawat-jalan');
	Route::view('frontoffice/laporan', 'frontoffice.laporan');
	Route::view('frontoffice/rawat-darurat', 'frontoffice.rawat-darurat');
	Route::view('frontoffice/rawat-inap', 'frontoffice.rawat-inap');
	Route::view('frontoffice/rawat-jalan', 'frontoffice.rawat-jalan');
	Route::view('frontoffice/supervisor', 'frontoffice.supervisor');
	Route::view('frontoffice/rekammedis', 'frontoffice.rekammedis');
	Route::view('frontoffice/merging-data', 'frontoffice.merging');
	Route::view('frontoffice/rekammedis/laporan', 'frontoffice.laporanrekammedis');

	//CETAK
	Route::get('frontoffice/cetak', 'FrontofficeController@cetak');
	Route::get('frontoffice/cetak-igd', 'FrontofficeController@cetakIGD');
	Route::get('frontoffice/cetak-irj', 'FrontofficeController@cetakIRJ');
	Route::get('frontoffice/cetak-irna', 'FrontofficeController@cetakIRNA');
	Route::post('frontoffice/cetak-igd', 'FrontofficeController@cetak_byTanggalIGD');
	Route::post('frontoffice/cetak-irj', 'FrontofficeController@cetak_byTanggalIRJ');
	Route::post('frontoffice/cetak-irna', 'FrontofficeController@cetak_byTanggalIRNA');
	Route::get('frontoffice/cetak-ajax', 'FrontofficeController@ajax_cetak');
	Route::get('frontoffice/cetak_barcode', 'FrontofficeController@dataCetakBarcode');
	Route::get('frontoffice/cetak_barcode/{id}/{reg_id}', 'FrontofficeController@cetak_barcode');
	Route::get('frontoffice/cetak_barcoderi/{id}/{reg_id}', 'FrontofficeController@cetak_barcoderi');
	Route::get('frontoffice/cetak_barcodeigd/{id}/{reg_id}', 'FrontofficeController@cetak_barcodeigd');
	Route::get('frontoffice/cetak_barcodeigd2/{id}/{reg_id}', 'FrontofficeController@cetak_barcodeigd2');
	Route::get('frontoffice/cetak_barcode2/{id}/{reg_id}', 'FrontofficeController@cetak_barcode2');
	Route::get('frontoffice/cetak_buktiregistrasi/{id}', 'FrontofficeController@cetak_buktiregistrasi');
	Route::get('frontoffice/cetak_gelang/{id}', 'FrontofficeController@cetak_gelang');
	Route::get('frontoffice/cetak-perjanjian', 'FrontofficeController@cetakPerjanjian');
	Route::get('frontoffice/cetak-kiup/{id}', 'FrontofficeController@cetakKIUP');
	Route::get('frontoffice/cetak-persetujuan/{id}', 'FrontofficeController@cetakPersetujuan');
	Route::get('frontoffice/cetak-rm01/{id}', 'FrontofficeController@cetakRm01');
	Route::get('frontoffice/cetak-e-sep/{id}', 'FrontofficeController@cetak_E_sep');
	
	//cetak tte
	Route::get('cetak-tte-general-consent/pdf/{regId}', 'FrontofficeController@cetakTTEPDFGeneralConsent');
	Route::post('tte-pdf-general-consent', 'FrontofficeController@ttePDFGeneralConsent');

	// LAPORAN TAGIHAN RAJAL
	Route::get('frontoffice/laporan/pengunjung-tagihan-irj', 'FrontofficeController@lapPengunjungTagihanIrj');
	Route::post('frontoffice/laporan/pengunjung-tagihan-irj', 'FrontofficeController@filterLapPengunjungTagihanIrj');
	
	// LAPORAN PENGUNJUNG
	Route::get('frontoffice/laporan/pengunjung-irj', 'FrontofficeController@lapPengunjungIrj');
	Route::post('frontoffice/laporan/pengunjung-irj', 'FrontofficeController@filterLapPengunjungIrj');

	// LAPORAN Retur Obat
	Route::get('frontoffice/laporan/laporan-retur-obat', 'FrontofficeController@laporanReturObat');
	Route::post('frontoffice/laporan/laporan-retur-obat', 'FrontofficeController@filterReturObat');

	// LAPORAN Kunjungan Semua POLI irj
	Route::get('frontoffice/laporan/laporan-kunjungan-irj', 'FrontofficeController@laporanKunjunganRawatJalan');
	Route::post('frontoffice/laporan/laporan-kunjungan-irj', 'FrontofficeController@filterLaporanKunjunganRawatJalan');

	// LAPORAN Kunjungan Rawat Inap
	Route::get('frontoffice/laporan/laporan-kunjungan-irna', 'FrontofficeController@laporanKunjunganRawatInap');
	Route::post('frontoffice/laporan/laporan-kunjungan-irna', 'FrontofficeController@filterLaporanKunjunganRawatInap');

	// LAPORAN RUJUKAN
	Route::get('frontoffice/laporan/rujukan', 'FrontofficeController@laporanRujukan');
	Route::post('frontoffice/laporan/rujukan', 'FrontofficeController@filterLaporanRujukan');

	//LAPORAN
	Route::get('frontoffice/laporan/laporan-resume-pasien', 'FrontofficeController@lapResumePasien');
	Route::post('frontoffice/laporan/laporan-resume-pasien', 'FrontofficeController@filterLapResumePasien');
	Route::get('frontoffice/laporan/pengunjung', 'FrontofficeController@lap_pengunjung');
	Route::post('frontoffice/laporan/pengunjung', 'FrontofficeController@lap_pengunjung_bytanggal');
	Route::get('frontoffice/laporan/kunjungan', 'FrontofficeController@lap_kunjungan');
	Route::post('frontoffice/laporan/kunjungan', 'FrontofficeController@lap_kunjungan_byTanggal');
	Route::get('frontoffice/laporan/kunjungan-irna', 'FrontofficeController@lap_kunjungan_irna');
	Route::post('frontoffice/laporan/kunjungan-irna', 'FrontofficeController@lap_kunjungan_irna_byTanggal');
	Route::get('frontoffice/laporan/diagnosa-irj', 'FrontofficeController@lap_diagnosa_irj');
	Route::post('frontoffice/laporan/diagnosa-irj', 'FrontofficeController@lap_diagnosa_irj_byTanggal');
    Route::get('frontoffice/laporan/diagnosa-igd', 'FrontofficeController@lap_diagnosa_igd');
	Route::post('frontoffice/laporan/diagnosa-igd', 'FrontofficeController@lap_diagnosa_igd_byTanggal');
    Route::get('frontoffice/laporan/indikator-pelayanan-igd', 'FrontofficeController@lap_indikator_igd');
	Route::get('frontoffice/laporan/diagnosa-irna', 'FrontofficeController@lap_diagnosa_irna');
	Route::post('frontoffice/laporan/diagnosa-irna', 'FrontofficeController@lap_diagnosa_irna_byTanggal');
	Route::get('frontoffice/laporan/rekammedis-pasien', 'FrontofficeController@rekammedis_pasien');
	Route::post('frontoffice/laporan/rekammedis-pasien', 'FrontofficeController@view_rekammedis_pasien');
	Route::get('frontoffice/laporan/pengunjung-ajax', 'FrontofficeController@ajax_lap_pengunjung');



	Route::get('frontoffice/laporan/distribusi-ranap', 'FrontofficeController@distribusi_ranap');
	Route::post('frontoffice/laporan/distribusi-ranap', 'FrontofficeController@distribusi_ranap_byTanggal');

	
	Route::get('frontoffice/laporan/distribusi-radar', 'FrontofficeController@distribusi_radar');
	Route::post('frontoffice/laporan/distribusi-radar', 'FrontofficeController@distribusi_radar_byTanggal');

	Route::get('frontoffice/laporan/distribusi-rajal', 'FrontofficeController@distribusi_rajal');
	Route::post('frontoffice/laporan/distribusi-rajal', 'FrontofficeController@distribusi_rajal_byTanggal');
	
	Route::get('frontoffice/laporan/usg', 'FrontofficeController@usg');
	Route::post('frontoffice/laporan/usg', 'FrontofficeController@usg_byTanggal');

	Route::get('frontoffice/laporan/ekg', 'FrontofficeController@ekg');
	Route::post('frontoffice/laporan/ekg', 'FrontofficeController@ekg_byTanggal');


	Route::get('frontoffice/rekap-pengunjung', 'FrontofficeController@rekapPengunjung');
	Route::post('frontoffice/rekap-pengunjung', 'FrontofficeController@dataRekap');

	// Laporan Antrian
	Route::get('frontoffice/laporan/antrian', 'FrontofficeController@lap_antrian');
	Route::post('frontoffice/laporan/antrian', 'FrontofficeController@lap_antrianBy');
	
	Route::get('frontoffice/laporan/perawat', 'FrontofficeController@lap_perawat');
	Route::post('frontoffice/laporan/perawat', 'FrontofficeController@lap_perawatBy');

	Route::get('frontoffice/laporan/lap-penunjang', 'FrontofficeController@lap_penunjang');
	Route::post('frontoffice/laporan/lap-penunjang', 'FrontofficeController@lap_penunjangBy');

	
	// Response Time

	Route::get('frontoffice/time', 'FrontofficeController@ResponTime');
	Route::post('frontoffice/time', 'FrontofficeController@ResponTime');
	
	//LOG USER
	Route::get('frontoffice/log-user', 'FrontofficeController@LogUser');
	Route::post('frontoffice/log-user', 'FrontofficeController@LogUser');

	Route::get('frontoffice/getRespon/{periode}/{poli}', 'FrontofficeController@getRespon');
	Route::post('frontoffice/export', 'FrontofficeController@exportresponses');
	Route::get('frontoffice/getRespon/{id}', 'FrontofficeController@getOpname');

	//detailLaporanRekammedis
	Route::get('frontoffice/laporanrekammedis//{registrasi_id}', 'FrontofficeController@viewDetailTindakan');
	Route::get('frontoffice/laporanrekammedis/obat/{registrasi_id}', 'FrontofficeController@viewDetailObat');
	Route::get('frontoffice/laporanrekammedis/diagnosa/{registrasi_id}', 'FrontofficeController@viewDetailDiagnosa');
	Route::get('frontoffice/laporanrekammedis/radiologi/{registrasi_id}', 'FrontofficeController@viewDetailRadiologi');

	//SUPERVISOR
	Route::get('frontoffice/supervisor/ubahdpjp', 'FrontofficeController@ubah_dpjp');
	Route::get('frontoffice-data-ubah-dpjp/{tga?}/{tgb?}', 'FrontofficeController@dataUbahDpjp');
	Route::get('frontoffice-data-detail-reg/{id}', 'FrontofficeController@dataReg');
	Route::post('frontoffice/supervisor/saveubahdpjp', 'FrontofficeController@save_ubahdpjp');
	//Create SEP Manual 19 Maret 2019
	Route::get('frontoffice/supervisor/create_sep/{registrasi_id}', 'FrontofficeController@createSepSusulan');

	Route::get('frontoffice/supervisor/hapusregistrasi/{tanggal?}/{poli?}', 'FrontofficeController@hapusRegistrasi');
	Route::get('frontoffice/supervisor/data-hapusregistrasi', 'FrontofficeController@datahapusRegistrasi');
	//View Untuk Restore Data Registrasi
	Route::get('frontoffice/supervisor/back/{tanggal?}', 'FrontofficeController@backRegistrasi');

    //Hapus SoftDelete
	Route::get('frontoffice/supervisor/soft-delete-registrasi/{id}', 'FrontofficeController@SoftDeleteRegistrasi');
	//Hapus Permanen Registrasi Pasien
	Route::get('frontoffice/supervisor/save-hapus-registrasi/{id}', 'FrontofficeController@saveHapusRegistrasi');
	//Kembalikadata after softdelete
	Route::get('frontoffice/supervisor/kembalikan-registrasi/{id}', 'FrontofficeController@kembalikanreq');

	Route::post('frontoffice/supervisor/registrasibytanggal', 'FrontofficeController@registrasiByTanggal');
	Route::post('frontoffice/supervisor/backregistrasibytanggal', 'FrontofficeController@backregistrasiByTanggal');

	//INPUT DIAGNOSA
	Route::get('frontoffice/input_diagnosa_rawatjalan', 'FrontofficeController@input_diagnosa_rawatjalan');
	Route::post('frontoffice/input_diagnosa_rawatjalan', 'FrontofficeController@input_diagnosa_rawatjalan_byTanggal');
	Route::get('frontoffice/form_input_diagnosa_rawatjalan/{id?}', 'FrontofficeController@form_input_diagnosa_rawatjalan');
	Route::post('frontoffice/simpan_diagnosa_rawatjalan', 'FrontofficeController@simpan_diagnosa_rawatjalan');
	Route::get('frontoffice/lap-rekammedis', 'FrontofficeController@rekammedis_pasien');

	Route::get('frontoffice/input_diagnosa_rawatinap', 'FrontofficeController@input_diagnosa_rawatinap');
	Route::post('frontoffice/input_diagnosa_rawatinap', 'FrontofficeController@input_diagnosa_rawatinap_byTanggal');
	Route::get('frontoffice/form_input_diagnosa_rawatinap/{id?}', 'FrontofficeController@form_input_diagnosa_rawatinap');
	Route::post('frontoffice/simpan_diagnosa_rawatinap', 'FrontofficeController@simpan_diagnosa_rawatinap');

    Route::get('frontoffice/ajax_icd10', 'FrontofficeController@ajaxIcd10');
    Route::get('frontoffice/ajax_icd9', 'FrontofficeController@ajaxIcd9');

	Route::get('frontoffice/input_diagnosa_igd', 'FrontofficeController@input_diagnosa_igd');
	Route::post('frontoffice/input_diagnosa_igd', 'FrontofficeController@input_diagnosa_igd_byTanggal');
	Route::get('frontoffice/form_input_diagnosa_igd/{id?}', 'FrontofficeController@form_input_diagnosa_igd');
	Route::post('frontoffice/simpan_diagnosa_igd', 'FrontofficeController@simpan_diagnosa_igd');

	Route::get('frontoffice/jkn-input-diagnosa-irj/{id?}', 'FrontofficeController@jknInputDiagnosaIrj');
	Route::post('frontoffice/jkn-simpan-diagnosa-irj', 'FrontofficeController@jknSimpanDiagnosaIrj');
	Route::get('frontoffice/jkn-input-diagnosa-irna/{id?}', 'FrontofficeController@jknInputDiagnosaIrna');
	Route::post('frontoffice/jkn-simpan-diagnosa-irna', 'FrontofficeController@jknSimpanDiagnosaIrna');
	Route::get('frontoffice/jkn-input-diagnosa-igd/{id?}', 'FrontofficeController@jknInputDiagnosaIGD');
	Route::post('frontoffice/jkn-simpan-diagnosa-igd', 'FrontofficeController@jknSimpanDiagnosaIGD');

	Route::get('frontoffice/history-diagnosa/{id}', 'FrontofficeController@historyDiagnosa');
	Route::get('frontoffice/history-prosedur/{id}', 'FrontofficeController@historyProsedur');

	Route::get('frontoffice/history-diagnosa-jkn/{id}', 'FrontofficeController@historyDiagnosaJkn');
	Route::get('frontoffice/history-prosedur-jkn/{id}', 'FrontofficeController@historyProsedurJkn');
    
    Route::get('frontoffice/hasil-lab/{id}', 'FrontofficeController@hasilLab');
	Route::get('frontoffice/hasil-rad/{id}', 'FrontofficeController@hasilRad');

	//Hapus diagnosa dan Prosedur
	Route::get('frontoffice/hapus-diagnosa/{id}/{registrasi_id}', 'FrontofficeController@hapusDiagnosa');
	Route::get('frontoffice/hapus-prosedur/{id}/{registrasi_id}', 'FrontofficeController@hapusProsedur');

	Route::get('frontoffice/hapus-diagnosa-jkn/{id}/{registrasi_id}', 'FrontofficeController@hapusDiagnosaJkn');
	Route::get('frontoffice/hapus-prosedur-jkn/{id}/{registrasi_id}', 'FrontofficeController@hapusProsedurJkn');

	//E-CLAIM
	Route::get('frontoffice/e-claim/dataRawatJalan', 'FrontofficeController@data_rawatJalan');
	Route::post('frontoffice/e-claim/dataRawatJalan', 'FrontofficeController@data_rawatJalan_byTanggal');
	Route::get('frontoffice/e-claim/dataRawatInap', 'FrontofficeController@data_rawatInap');
	Route::post('frontoffice/e-claim/dataRawatInap', 'FrontofficeController@data_rawatInap_byTanggal');
	Route::get('frontoffice/e-claim/bridging/{registrasi_id}', 'FrontofficeController@bridging');
	Route::get('frontoffice/e-claim/get_dataRawatJalan', 'FrontofficeController@get_data_rawatJalan');
	Route::get('frontoffice/e-claim/cetak-eklaim/{no_sep}', 'FrontofficeController@cetakEklaim');
	Route::get('frontoffice/e-claim/cetak-full/{registrasi_id}', 'FrontofficeController@cetakFull');

	Route::get('frontoffice/e-claim/bridging-idrg/{registrasi_id}', 'FrontofficeController@bridgingIdrg');
	Route::get('frontoffice/e-claim/bridging-irna-idrg/{registrasi_id}', 'FrontofficeController@bridgingIRNAIDRG');
	//FAIQ
	Route::get('frontoffice/e-claim/detailTindakan/{registrasi_id}', 'FrontofficeController@eklaimDetailTindakan');
	Route::get('frontoffice/e-claim/detailResume/{registrasi_id}', 'FrontofficeController@eklaimDetailResume');
	Route::get('frontoffice/e-claim/detailSpri/{registrasi_id}', 'FrontofficeController@eklaimDetailSpri');
	Route::get('frontoffice/e-claim/detailLab/{registrasi_id}', 'FrontofficeController@eklaimDetailLab');
	Route::get('frontoffice/e-claim/detailRad/{registrasi_id}', 'FrontofficeController@eklaimDetailRad');

	Route::get('frontoffice/e-claim/bridging-irna/{registrasi_id}', 'FrontofficeController@bridgingIRNA');

	//diagnosa
	Route::get('frontoffice/e-claim/get-icd9-data', 'FrontofficeController@geticd9data');
	Route::get('frontoffice/e-claim/get-icd9-data-inacbg', 'FrontofficeController@geticd9dataInacbg');
	//diagnosa
	Route::get('frontoffice/e-claim/get-icd10-data', 'FrontofficeController@geticd10data');
	Route::get('frontoffice/e-claim/get-icd10-data-inacbg', 'FrontofficeController@geticd10dataInacbg');
	Route::get('/frontoffice/lap-rekammedis/datapasien', 'FrontofficeController@datapasien');

	//Tracer
	Route::get('frontoffice/data-folio/{reg_id}', 'FrontofficeController@dataFolio');
	Route::get('frontoffice/tracer', 'FrontofficeController@tracer');
	Route::post('frontoffice/filter-tracer', 'FrontofficeController@filterTracer');
	Route::get('frontoffice/data-tracer/{poli_id?}/{tgl?}', 'FrontofficeController@dataTracer');
	Route::get('frontoffice/cetak-tracer/{registrasi_id}', 'FrontofficeController@cetakTracer');
	Route::get('frontoffice/tracerAll', 'FrontofficeController@tracerAll');
	Route::get('frontoffice/cetakTracerAll', 'FrontofficeController@cetakTracerAll');

	//Setting Kuota Poli
	Route::get('frontoffice/setting-kuota-poli', 'FrontofficeController@settingKuotaPoli')->name('setting-poli');
	Route::get('frontoffice/get-poli/{id}', 'FrontofficeController@getPoli');
	Route::post('frontoffice/save-kuota-poli', 'FrontofficeController@saveKuotaPoli');
	Route::get('frontoffice/buka-praktik/{id}', 'FrontofficeController@bukaPraktik');
	Route::get('frontoffice/tutup-praktik/{id}', 'FrontofficeController@tutupPraktik');

	//Setting Kuota Dokter
	Route::get('frontoffice/setting-kuota-dokter', 'FrontofficeController@settingKuotaDokter')->name('setting-dokter');
	Route::get('frontoffice/get-dokter/{id}', 'FrontofficeController@getDokters');
	Route::post('frontoffice/save-kuota-dokter', 'FrontofficeController@saveKuotaDokter');
	Route::get('frontoffice/buka-praktik-dokter/{id}', 'FrontofficeController@bukaPraktikDokter');
	Route::get('frontoffice/tutup-praktik-dokter/{id}', 'FrontofficeController@tutupPraktikDokter');

	//Out Gate
	Route::get('frontoffice/outgate', 'FrontofficeController@outgate');
	Route::post('frontoffice/outgate', 'FrontofficeController@outgateViewData');

	//In Guide
	Route::get('frontoffice/inguide', 'FrontofficeController@inguide');
	Route::post('frontoffice/inguide', 'FrontofficeController@inguideViewData');

	// Cetak SJP
	Route::get('frontoffice/data-sjp', 'FrontofficeController@dataSJP');
	Route::get('frontoffice/cetak-sjp/{unit}/{id_reg}/', 'FrontofficeController@cetakSJP');

	//Cetak SEP OTOMATIS
	Route::get('frontoffice/data-sep', 'FrontofficeController@dataSEP');
	Route::get('frontoffice/cetak-sep', 'FrontofficeController@cetakSEP');
	Route::get('frontoffice/data-sep2', 'FrontofficeController@dataSEP2');
	Route::get('frontoffice/cetak-sep2', 'FrontofficeController@cetakSEP2');

	//Histori Pasien
	Route::get('frontoffice/histori-pasien/{pasien_id}', 'FrontofficeController@historiPasien');
	Route::get('frontoffice/histori-pasien-rm/{pasien_id}', 'FrontofficeController@historiPasienRM');
	Route::post('frontoffice/histori-pasien', 'FrontofficeController@historiPasienByRequest');
	Route::post('frontoffice/pindah-tindakan-pasien', 'FrontofficeController@pindahTindakanPasien');
	Route::get('frontoffice/total_tagihan/{registrasi_id}', 'FrontofficeController@totalTagihan');

	//Histori RM Pasien By App Kanza
	Route::get('frontoffice/search-pasien-kanza/{no_rm}', 'FrontofficeController@searchHistoryPasien');

	//Ubah Status Pelayanan
	Route::get('get-data-registrasi/{registrasi_id}', 'FrontofficeController@getDataRegistrasi');
	Route::post('ubah-status-pelayanan/', 'FrontofficeController@ubahStatusPelayanan');

	//Ubah Status Pelayanan
	Route::get('/frontoffice/set-cara-bayar', 'FrontofficeController@setCarabayar');
	Route::get('/frontoffice/set-bangsal-folio', 'FrontofficeController@setBangsalFolio');
	Route::get('/frontoffice/set-jenis-icd9', 'FrontofficeController@setJenisPerawatanIcd9');
	Route::get('/frontoffice/set-jenis-icd10', 'FrontofficeController@setJenisPerawatanIcd10');
	Route::get('/frontoffice/set-mapping-biaya', 'FrontofficeController@setMappingBiaya');

	//MERGE RM
	Route::get('/frontoffice/get-rm', 'FrontofficeController@getRM');
	Route::post('frontoffice/save-merge-rm', 'FrontofficeController@saveMergeRM');

	//UPLOAD DOKUMENT RM
	Route::get('/frontoffice/uploadDokument/{registrasi_id}', 'FrontofficeController@uploadDokument');
	Route::post('/frontoffice/saveuploadDokument', 'FrontofficeController@saveDocument');
	Route::get('/frontoffice/viewDokument/{id}', 'FrontofficeController@viewDokumen');

	// LAPORAN PENDAFTARAN IGD
	Route::get('frontoffice/laporan-igd', 'FrontofficeController@lap_pengunjung_igd');
	Route::post('frontoffice/laporan-igd', 'FrontofficeController@lap_pengunjung_igd_bytanggal');
	Route::post('frontoffice/cek-pasien', 'FrontofficeController@cekPasien');
	Route::post('frontoffice/cek-pasien-penjualan', 'FrontofficeController@cekPasienPenjualan');

    //dokumen view
	Route::get('frontoffice/laporanrekammedis/viewdokumen/{registrasi_id}', 'FrontofficeController@viewDetailDokumen');

    // Response Time
	Route::get('frontoffice/laporan/response-time-irj', 'FrontofficeController@responseTimeIRJ');
	Route::post('frontoffice/laporan/response-time-irj', 'FrontofficeController@responseTimeIRJExcel');
	Route::get('frontoffice/laporan/response-time-irj-data', 'FrontofficeController@responseTimeIRJDataTable');

    // LAPORAN Harian
	Route::get('frontoffice/laporan/laporan-harian', 'FrontofficeController@laporanHarian');
	Route::post('frontoffice/laporan/laporan-harian', 'FrontofficeController@filterLaporanHarian');

	// LAPORAN PENGUNJUNG RAWAT JALAN
	Route::get('frontoffice/laporan/pengunjung-irj', 'FrontofficeController@lapPengunjungIrj');
	Route::post('frontoffice/laporan/pengunjung-irj', 'FrontofficeController@filterLapPengunjungIrj');

	// LAPORAN PENGUNJUNG RAWAT DARURAT
	Route::get('frontoffice/laporan/pengunjung-igd', 'FrontofficeController@lapPengunjungIGD');
	Route::post('frontoffice/laporan/pengunjung-igd', 'FrontofficeController@filterLapPengunjungIGD');
    
    // Laporan Registrasi IGD
    Route::get('frontoffice/laporan/registrasi-igd', 'FrontofficeController@lapRegistrasiIGD');
	Route::post('frontoffice/laporan/registrasi-igd', 'FrontofficeController@filterLapRegistrasiIGD');

	// LAPORAN PENGUNJUNG RAWAT INAP
	Route::get('frontoffice/laporan/pengunjung-irna', 'FrontofficeController@lapPengunjungIRNA');
	Route::post('frontoffice/laporan/pengunjung-irna', 'FrontofficeController@filterLapPengunjungIRNA');
	
	// LAPORAN JAGA IGD
	Route::get('frontoffice/laporan/jaga-igd', 'FrontofficeController@lapJagaIGD');
	Route::post('frontoffice/laporan/jaga-igd', 'FrontofficeController@filterLapJagaIGD');

	// HISTORI HAPUS TINDAKAN
	Route::get('frontoffice/riwayat-hapus-tindakan', 'FrontofficeController@historiHapusTindakan');
	Route::post('frontoffice/riwayat-hapus-tindakan', 'FrontofficeController@filterHistoriHapusTindakan');
	
	
	// LAPORAN PENGUNJUNG RAWAT INAP
	Route::get('frontoffice/laporan/laporan-ranap', 'FrontofficeController@lapRanap');
	Route::post('frontoffice/laporan/laporan-ranap', 'FrontofficeController@filterLapRanap');
	// Route::view('rawat-inap/lap', 'FrontofficeController@lapPengunjungIRNA');


	// VEDIKA

	Route::get('frontoffice/laporan/rekammedis-pasien/irj-igd', 'FrontofficeController@rekammedis_pasienIRJ_IGD');
	Route::post('frontoffice/laporan/rekammedis-pasien/irj-igd', 'FrontofficeController@view_rekammedis_pasienIRj_IGD');
	Route::get('frontoffice/laporan/rekammedis-pasien/irna', 'FrontofficeController@rekammedis_pasienIRNA');
	Route::post('frontoffice/laporan/rekammedis-pasien/irna', 'FrontofficeController@view_rekammedis_pasienIRNA');
	
	// Hapus Dokumen
	Route::get('frontoffice/hapus-file-radiologi/{id}', 'FrontofficeController@hapusFileRadiologi');
	Route::get('frontoffice/hapus-file-resummedis/{id}', 'FrontofficeController@hapusFileResummedis');
	Route::get('frontoffice/hapus-file-operasi/{id}', 'FrontofficeController@hapusFileOperasi');
	Route::get('frontoffice/hapus-file-laboratorium/{id}', 'FrontofficeController@hapusFileLaboratorium');
	Route::get('frontoffice/hapus-file-pathway/{id}', 'FrontofficeController@hapusFilePathway');
	Route::get('frontoffice/hapus-file-ekg/{id}', 'FrontofficeController@hapusFileEkg');
	Route::get('frontoffice/hapus-file-echo/{id}', 'FrontofficeController@hapusFileEcho');

	Route::get('frontoffice/set-tracer/{reg_id}/{posisi_tracer}', 'FrontofficeController@setTracer');
	
	
	// Cetak
	Route::get('frontoffice/cetak-dokumen', 'FrontofficeController@cetakDokumen');
	Route::post('frontoffice/cetak-dokumen', 'FrontofficeController@filterCetakDokumen');
	// Route::get('frontoffice/download-all/{registrasi_id}', 'FrontofficeController@downloadAll');
	
	Route::get('frontoffice/hasil-upload/{registrasi_id}', 'FrontofficeController@hasilUpload');
	Route::get('frontoffice/hasil-upload-operasi/{registrasi_id}', 'FrontofficeController@uploadOperasi');

	Route::get('frontoffice/antrian-realtime', 'FrontofficeController@antrianRealtime');
	Route::post('frontoffice/antrian-realtime-bytgl', 'FrontofficeController@antrianRealtime_byTanggal');
	Route::match(['GET','POST'], 'frontoffice/antrian-realtime-igd-bytgl', 'FrontofficeController@antrianRealtimeIgd_byTanggal')
     ->name('frontoffice.antrian-igd-bytgl');
	 Route::match(['GET','POST'], 'frontoffice/antrian-realtime-igd-bybln','FrontofficeController@antrianRealtimeIgd_byBulan')
	 ->name('frontoffice.antrian-igd-bybln');
	 // antrian realtime inap
	 Route::get('frontoffice/antrian-realtime-inap', 'FrontofficeController@antrianRealtimeInap');
	 Route::post('frontoffice/antrian-realtime-inap-bytgl', 'FrontofficeController@antrianRealtimeInap_byTanggal');
	 Route::get('frontoffice/tab-kriteria-icu/{registrasi_id}', 'FrontofficeController@tabKriteriaICU');
	 // antrian realtime igd
	Route::get('frontoffice/antrian-realtime-igd', 'FrontofficeController@antrianRealtimeIgd');
	Route::get('frontoffice/antrian-realtime-igd', 'FrontofficeController@antrianRealtimeIgd')->name('frontoffice.antrian-igd');
	Route::post('frontoffice/antrian-realtime-igd-bytgl', 'FrontofficeController@antrianRealtimeIgd_byTanggal');
	Route::get('frontoffice/tab-radiologi/{registrasi_id}', 'FrontofficeController@tabRadiologi');
	Route::get('frontoffice/tab-cppt-igd/{registrasi_id}', 'FrontofficeController@tabCPPTIGD');
	Route::get('frontoffice/tab-surkon/{registrasi_id}', 'FrontofficeController@tabSurkon');
	Route::get('frontoffice/tab-surkon-casemix/{registrasi_id}', 'FrontofficeController@tabSurkonCasemix');
	Route::get('frontoffice/tab-coding/{registrasi_id}', 'FrontofficeController@tabCoding');
	Route::get('frontoffice/tab-lap-tindakan/{registrasi_id}', 'FrontofficeController@tabLapTindakanIRJ');

	// general consent
	Route::get('frontoffice/general-consent/{registrasi_id}', 'FrontofficeController@generalConsent');
  	Route::post('frontoffice/general-consent/{registrasi_id}', 'FrontofficeController@generalConsentPost');
	Route::get('frontoffice/general-consent-irna/{registrasi_id}', 'FrontofficeController@generalConsentIrna');
  	Route::post('frontoffice/general-consent-irna/{registrasi_id}', 'FrontofficeController@generalConsentPostIrna');
  	Route::get('frontoffice/cetak-general-consent/{registrasi_id}', 'FrontofficeController@generalConsentCetak');
  	Route::get('frontoffice/cetak-general-consent-irna/{registrasi_id}', 'FrontofficeController@generalConsentCetakIrna');
});