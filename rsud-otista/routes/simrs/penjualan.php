<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	//PENJUALAN RAWAT JALAN
	Route::get('penjualan/jalan', 'PenjualanController@indexRajal');
	Route::get('penjualan/darurat', 'PenjualanController@indexDarurat');
	Route::post('penjualan/jalan', 'PenjualanController@indexRajalBy');
	Route::post('penjualan/darurat', 'PenjualanController@indexDaruratBy');
	//IRNA
	Route::get('penjualan/irna', 'PenjualanController@rawat_inap');
	Route::post('penjualan/irna', 'PenjualanController@rawat_inap_byTanggal');
	Route::post('penjualan/updateFaktur', 'PenjualanController@updateFaktur');

	Route::post('penjualan/search', 'PenjualanController@search');
	Route::get('penjualan/formpenjualan/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@form_penjualan');
	Route::post('penjualan/savepenjualan', 'PenjualanController@save_penjualan');
	Route::post('penjualan/savedetail', 'PenjualanController@save_detail');
	Route::get('penjualan/deleteDetail/{id}/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@deleteDetail');
	Route::get('penjualan/savetotal/{penjualan_id}', 'PenjualanController@save_totalpenjualan');
	Route::get('penjualan/{id}/history', 'PenjualanController@history');
	Route::get('penjualan/{id}/{bayar}/history-eresep', 'PenjualanController@historyEresep');

	//PENJUALAN BEBAS
	Route::get('penjualanbebas', 'PenjualanController@penjualanBebas');
	Route::post('penjualanbebas', 'PenjualanController@penjualanBebasBytanggal');
	Route::post('penjualan/savepenjualanbebas', 'PenjualanController@save_penjualan_bebas');
	Route::get('penjualan/formpenjualanbebas/{idpasien}/{idreg}/{penjualan_id}', 'PenjualanController@form_penjualan_bebas');
	Route::post('penjualan/savedetailbebas', 'PenjualanController@save_detail_bebas');
	Route::get('penjualan/deleteDetailbebas/{id}/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@deleteDetailBebas');
	Route::post('penjualan/savetotalbebas', 'PenjualanController@save_totalpenjualan_bebas');
	Route::get('penjualan/edit-penjualan-bebas/{idreg}/{penjualan_id}', 'PenjualanController@editPenjualanBebas');
	Route::post('penjualan/update-save-penjualan', 'PenjualanController@updateSavePenjualan');


	
	//UPDATE DETAIL PENJUALAN
	Route::get('detail-penjualan/{penjualan_id}', 'PenjualanController@detailPenjualan');
	Route::get('penjualan/hapus-faktur/{fr}', 'PenjualanController@hapusFaktur');
	Route::get('hapus-detail-penjualan/{id}', 'PenjualanController@hapusObat');
	Route::get('tambah-detail-penjualan/{penjualan_id}', 'PenjualanController@tambahPenjualan');
	Route::post('simpan-detail-penjualan', 'PenjualanController@saveTambahPenjualan');

	//LAPORAN
	Route::get('penjualan/laporan', 'PenjualanController@laporan');
	Route::post('penjualan/laporan', 'PenjualanController@laporanPenjualan');

	Route::get('penjualan/laporan-penjualan-user', 'PenjualanController@laporanPenjualanUser');
	Route::get('penjualan/laporan-penjualan-user-data', 'PenjualanController@laporanPenjualanUserByRequest');


	Route::get('penjualan/laporan/{no_faktur}', 'PenjualanController@laporanPenjualanDetail');

	//RETUR OBAT RAJAL
	Route::get('retur/rajal', 'PenjualanController@returRajal');
	Route::get('retur/rajal/detailnya/{id}', 'PenjualanController@returRajalDetailnya');
	Route::post('retur/rajal', 'PenjualanController@returRajalByRequest');
	Route::get('retur/dataReturRajalByRequest', 'PenjualanController@dataReturRajalByRequest');
	Route::get('retur/getdataretur/{registrasi_id}', 'PenjualanController@getDataRetur');
	Route::get('retur/getPenjualanDetail/{no_faktur}', 'PenjualanController@getPenjualanDetail');
	Route::post('retur/saveRetur', 'PenjualanController@saveRetur');

	//RETUR OBAT RANAP
	Route::get('retur/ranap', 'PenjualanController@returRanap');
	Route::post('retur/ranap', 'PenjualanController@returRanapByRequest');
	Route::get('retur/dataReturRanapByRequest', 'PenjualanController@dataReturRanapByRequest');

	//INSERT PENJUALAN BLM TERTAGIH
	Route::get('penjualan/insert-tagihan-penjualan/{registrasi_id}', 'PenjualanController@insertTagihanPenjualan');

	//Penjulaan
	Route::post('cartAdd', 'CartController@addCart');
	Route::post('cartUpdate', 'CartController@updateCart');
	Route::get('cartDelete/{id}', 'CartController@deleteCart');
	Route::get('cartDestroy', 'CartController@destroyCart');
	Route::view('cartContent/{idreg?}', 'penjualan.cartContent');
	Route::view('cartContentResep/{idreg?}', 'penjualan.penjualan-baru.cartContentEresep');

	Route::post('penjualan/new-save-penjualan', 'PenjualanController@newSavePenjualan');

	Route::get('penjualan/master-obat', 'PenjualanController@getMasterObat');
	//hapus penjualan bebas
	Route::get('hapus-penjualanbebas/{registrasi_id}', 'PenjualanController@hapusPenjualanBebas');

	//PENJUALAN Terbaru
	Route::get('penjualan/jalan-baru', 'PenjualanController@indexRajalBaru');
	Route::post('penjualan/jalan-baru', 'PenjualanController@indexRajalBaruBy');

	// operas penjualan
	Route::get('penjualan/ibs-baru', 'PenjualanController@indexIbsBaru');
	Route::post('penjualan/ibs-baru', 'PenjualanController@indexIbsBaruBy');
	Route::get('penjualan/ibs-jalan-baru', 'PenjualanController@indexIbsJalanBaru');
	Route::post('penjualan/ibs-jalan-baru', 'PenjualanController@indexIbsJalanBaruBy');

	// PENJUALAN FAST
	Route::get('penjualan/jalan-baru-fast', 'PenjualanController@indexRajalBaruFast');
	Route::post('penjualan/jalan-baru-fast', 'PenjualanController@indexRajalBaruFastBy');
	
	Route::get('penjualan/darurat-baru-fast', 'PenjualanController@indexDaruratBaruFast');
	Route::post('penjualan/darurat-baru-fast', 'PenjualanController@indexDaruratBaruFastBy');

	Route::get('penjualan/irna-baru-fast', 'PenjualanController@indexIrnaBaruFast');
	Route::post('penjualan/irna-baru-fast', 'PenjualanController@indexIrnaBaruFastBy');

	// END PENJUALAN FAST


	Route::get('penjualan/darurat-baru', 'PenjualanController@indexDaruratBaru');
	Route::post('penjualan/darurat-baru', 'PenjualanController@indexDaruratBaruBy');
	Route::get('penjualan/irna-baru', 'PenjualanController@indexIrnaBaru');
	Route::post('penjualan/irna-baru', 'PenjualanController@indexIrnaBaruBy');
	Route::get('penjualan/{id}/history-baru', 'PenjualanController@historyBaru');
	Route::get('penjualan/{id}/history-baru-obat', 'PenjualanController@historyBaruObat');
	Route::get('penjualan/{id}/{id_penjualan}/history-baru-filter', 'PenjualanController@historyBaruFilter');
	Route::get('penjualan/{id}/{id_penjualan}/history-baru-obat-filter', 'PenjualanController@historyBaruObatFilter');
	Route::get('penjualan/{id}/history-baru-by-id-pasien', 'PenjualanController@historyBaruByIdPasien');
	Route::post('penjualan/cetak-eresep-manual/{id}', 'PenjualanController@cetakEresepManual');
	Route::get('penjualan/editformpenjualan/{unit}/{idreg?}/{penjualan_id}', 'PenjualanController@edit_form_penjualan');
	Route::get('penjualan/editformpenjualanibs/{idreg?}/{penjualan_id}', 'PenjualanController@edit_form_penjualan_ibs');
	Route::get('hapus-detail-penjualan-new/{id}', 'PenjualanController@hapusObatNew');

	
	//PENJUALAN BEBAS penjualan/simpan-penjualan-det
	Route::get('penjualanbebas-baru', 'PenjualanController@penjualanBebasBaru');
	Route::post('penjualanbebas-baru', 'PenjualanController@penjualanBebasBaruBytanggal');
	Route::post('penjualan/savepenjualanbebasbaru', 'PenjualanController@save_penjualan_bebas_baru');
	Route::get('penjualan/formpenjualanbebasbaru/{idpasien}/{idreg}/{penjualan_id}', 'PenjualanController@form_penjualan_bebas_baru');
	Route::post('penjualan/savedetailbebasbaru', 'PenjualanController@save_detail_bebas_baru');
	Route::get('penjualan/deleteDetailbebasbaru/{id}/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@deleteDetailBebasBaru');
	Route::post('penjualan/savetotalbebasbaru', 'PenjualanController@save_totalpenjualan_bebas_baru');
	Route::get('penjualan/edit-penjualan-bebas-baru/{idreg}/{penjualan_id}', 'PenjualanController@editPenjualanBebasBaru');

	//get data
	Route::get('penjualan/master-obat-baru', 'PenjualanController@getMasterObatBaru');
	Route::get('penjualan/master-obat-baru-ibs', 'PenjualanController@getMasterObatBaruIbs');
	Route::get('penjualan/resep/master-obat-baru', 'PenjualanController@getMasterObatBaruResep');
	Route::get('penjualan/resep/master-obat-baru-racik', 'PenjualanController@getMasterObatBaruResepRacik');
	Route::get('penjualan/kode', 'PenjualanController@getMasterKode');
	Route::get('penjualan/kode/icd-9', 'PenjualanController@getMasterKodeIcd9');
	Route::get('penjualan/get-obat-baru/{id}', 'PenjualanController@getDataMasterObatBaru');


	// get data e -resep
	Route::get('penjualan/resep/master-obat-baru-no-batch', 'PenjualanController@getMasterObatBaruResepNoBatch');
	Route::get('penjualan/get-obat-baru-no-batch/{id}', 'PenjualanController@getDataMasterObatBaruNoBatch');

	//simpan penjualan
	Route::get('penjualan/form-penjualan-baru/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@form_penjualan_baru');
	Route::get('penjualannew/form-penjualan-baru/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@form_penjualan_baru_cart');
	Route::get('penjualan/sinkron-faktur/{faktur}/{reg_id}/{harga}', 'PenjualanController@sinkronFaktur');
	Route::post('penjualan/simpan/penjualan-baru', 'PenjualanController@save_totalpenjualan_baru');
	Route::post('penjualan/simpan-penjualan-detail', 'PenjualanController@saveDetailBaru');
	Route::post('penjualannew/simpan-penjualan-detail', 'PenjualanController@saveDetailBaruCart');
	Route::post('penjualan/simpan-total-penjualan', 'PenjualanController@saveTotalBaru');
	Route::post('penjualannew/simpan-total-penjualan', 'PenjualanController@saveTotalBaruEresepCart');
	Route::post('penjualan/simpan-total-penjualan-new', 'PenjualanController@saveTotalBaruCart');
	// Penjualan IBS
	Route::get('penjualan/form-penjualan-baru-ibs/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@form_penjualan_baru_ibs');
	Route::post('penjualan/simpan-total-penjualan-ibs', 'PenjualanController@saveTotalBaruIbs');
	Route::get('penjualannew/form-penjualan-baru-ibs/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@form_penjualan_baru_cart_ibs');
	Route::post('penjualan/simpan-total-penjualan-new-ibs', 'PenjualanController@saveTotalBaruCartIbs');


	Route::resource('penjualan/master-uang-racik', 'UangRacikController');
	Route::resource('penjualan/master-cara-minum', 'masterCaraMinumController');
	Route::get('penjualan/deleteDetailBaru/{id}/{idpasien?}/{idreg?}/{penjualan_id?}/{ideresep?}', 'PenjualanController@deleteDetailBaru');
	Route::get('penjualan/deleteDetailBaruValidasi/{idpasien}/{idreg?}/{idnote?}', 'PenjualanController@deleteDetailBaruValidasi');
	Route::get('penjualan/hapus-faktur-baru/{no_resep?}', 'PenjualanController@hapus_faktur_baru');
	Route::get('detail-penjualan-baru/{penjualan_id}', 'PenjualanController@detailPenjualanHapus');


	// RETUR PENJUALAN BEBAS
	Route::get('retur/bebas', 'PenjualanController@returBebas');
	Route::post('retur/bebas', 'PenjualanController@returBebasByRequest');
	Route::get('retur/dataReturBebasByRequest', 'PenjualanController@dataReturBebasByRequest');

	// ERESEP
	Route::post('penjualan/validasi-eresep', 'PenjualanController@validasiEresep');
	Route::post('penjualannew/validasi-eresep', 'PenjualanController@validasiEresepCart');
	Route::post('penjualan/editKronis/{id}', 'PenjualanController@editKronis');
	Route::post('penjualan/editJumlah/{id}', 'PenjualanController@editJumlah');
	Route::post('penjualan/editStatusKronis/{id}', 'PenjualanController@editStatusKronis');
	Route::get('penjualan/batal-eresep/{unit}/{id}', 'PenjualanController@batalEresep');
	Route::get('penjualan/view-eresep/{id}', 'PenjualanController@viewEresep');
	Route::get('penjualan/form-penjualan-baru-eresep/{idpasien?}/{idreg?}/{ideresep?}/{idpenjualan?}', 'PenjualanController@form_penjualan_baru_eresep');
	Route::get('penjualannew/form-penjualan-baru-eresep/{idpasien?}/{idreg?}/{ideresep?}/{idpenjualan?}', 'PenjualanController@form_penjualan_baru_eresep_cart');


	//Penjulaan
	Route::get('refresh-obat', 'CartNewController@refreshObat');

	Route::post('cartAddNew', 'CartNewController@addCart');
	Route::post('cartUpdateNew', 'CartNewController@updateCart');
	Route::get('cartDeleteNew/{id}', 'CartNewController@deleteCart');
	Route::get('cartDestroyNew', 'CartNewController@destroyCart');
	Route::get('cartEditJumlahNew', 'CartNewController@cartEditJumlah');
	Route::get('cartEditKronisNew', 'CartNewController@cartEditKronis');
	// Eresep
	Route::get('cartEditJumlahEresep', 'CartNewController@cartEditJumlahEresep');
	Route::get('cartEditKronisEresep', 'CartNewController@cartEditKronisEresep');
	Route::get('cartDeleteEresep/{id}/{idreg}', 'CartNewController@deleteEresepCart');
	// Route::view('cartContentNew', 'penjualannew.cartContent');
	Route::get('penjualan/tab-resep/{registrasi_id}', 'PenjualanController@tabResep');
	Route::get('penjualan/tab-obat-farmasi/{registrasi_id}', 'PenjualanController@tabObatFarmasi');
	Route::get('penjualan/tab-copy-resep/{registrasi_id}', 'PenjualanController@tabCopyResep');
	Route::get('penjualan/tab-faktur/{registrasi_id}', 'PenjualanController@tabFaktur');
	Route::get('penjualan/tab-fkronis/{registrasi_id}', 'PenjualanController@tabFkronis');
	Route::get('penjualan/tab-fnonkronis/{registrasi_id}', 'PenjualanController@tabFnonkronis');
	Route::get('penjualan/tab-infus/{registrasi_id}', 'PenjualanController@tabInfus');
	Route::get('penjualan/tab-etiket/{registrasi_id}', 'PenjualanController@tabEtiket');
	Route::get('penjualan/tab-etiket2/{registrasi_id}', 'PenjualanController@tabEtiket2');
	Route::get('penjualan/tab-edit/{registrasi_id}', 'PenjualanController@tabEdit');


	Route::get('penjualan/bundling-resep/{registrasi_id}', 'CopyResepController@bundlingResep');
	Route::post('penjualan/tte-bundling-resep/{registrasi_id}', 'CopyResepController@tteBundlingResep');

});
