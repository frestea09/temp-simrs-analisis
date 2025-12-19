<?php

Route::post('newclaim', 'InacbgController@new_claim');
Route::get('cek-sitb/{sitb}/{sep?}', 'InacbgController@sitb');

// IDRG
Route::post('newclaim-idrg', 'IdrgController@new_claim');
Route::post('final-idrg', 'IdrgController@final_claim_idrg');
Route::post('final-idrg-only', 'IdrgController@final_idrg_only');
Route::post('grouping-stage-2', 'IdrgController@GroupingStage2');
Route::post('grouping-idrg-only', 'IdrgController@grouping_idrg_only');
Route::post('grouping-inacbg-only', 'IdrgController@grouping_inacbg_only');
Route::post('import-idrg-only', 'IdrgController@import_idrg_only');
Route::post('edit-idrg', 'IdrgController@idrg_grouper_reedit');
Route::post('edit-ulang-klaim', 'IdrgController@EditUlangKlaim');
Route::post('inacbg-edit-klaim', 'IdrgController@inacbg_edit_klaim');
Route::post('inacbg-edit-klaim-belum-dc', 'IdrgController@inacbg_edit_klaim_belum_dc');

Route::post('editclaim', 'InacbgController@editClaim');
Route::get('inacbg/data-detail-per-claim/{sep}', 'InacbgController@ambbilDataPerKlaim');

Route::get('eklaim-get-response/{no_sep}', 'InacbgController@getResponse');
Route::get('eklaim-detail-bridging/{registrasi_id}', 'InacbgController@detailBridging');
Route::get('eklaim-rincian-biaya-perawatan/{registrasi_id}', 'InacbgController@cetakBiayaPerawatan');
Route::get('eklaim-detail-rincian-biaya-eklaim/{registrasi_id}', 'InacbgController@cetakDetailEklaim');

Route::post('editclaimirna-idrg', 'IdrgIRNAController@editClaim');
Route::post('newclaim-irna-idrg', 'IdrgIRNAController@new_claim');

//Rawat Inap
Route::post('newclaim-irna', 'InacbgIRNAController@new_claim');
Route::post('editclaimirna', 'InacbgIRNAController@editClaim');


Route::get('inacbg/save-final-klaim-idrg/{no_sep}/{coder_nik?}', 'IdrgIRNAController@finalKirimDC');
Route::get('cetak-e-claim-idrg/{nomor_sep}','IdrgController@CetakKlaim');
//Test Tarif
Route::get('claim/kirimdc/{nomor_sep}', 'InacbgController@KirimKlaimIndividualKeDC');

//Final Klaim dan kirim DC
Route::get('inacbg/get-dataklaim/{registrasi_id}', 'InacbgController@getDataKlaim');
//Save Final
Route::get('inacbg/save-final-klaim/{no_sep}/{coder_nik}', 'InacbgController@finalKirimDC');
//Hapus Klaim
Route::get('inacbg/hapus-klaim/{no_sep}/{coder_nik}', 'InacbgController@hapusKlaim');
Route::get('inacbg/hapus-klaim-irna/{no_sep}/{coder_nik}', 'InacbgIRNAController@hapusKlaim');

//laporan bridging klaim
Route::view('inacbg/laporan-eklaim', 'bridging/laporanEklaim');
Route::post('inacbg/laporan-eklaim', 'InacbgController@lap_Eklaim_bytanggal');

//STatus InaCbg
Route::get('inacbg/get-status-klaim/{registrasi_id}', 'InacbgController@statusInaCGB');
Route::get('inacbg/delete-inacbg/{id}', 'InacbgController@deleteInacbg');


Route::get('cetak-e-claim/{nomor_sep}','InacbgController@CetakKlaim');

// LIHAT INACBG
Route::view('inacbg/lihat-eklaim-irj-igd', 'bridging/lihat-eklaim-irj-igd');
Route::post('inacbg/lihat-eklaim-irj-igd', 'InacbgController@lihatEklaimIRJIGD');
Route::view('inacbg/lihat-eklaim-irna', 'bridging/lihat-eklaim-irna');
Route::post('inacbg/lihat-eklaim-irna', 'InacbgController@lihatEklaimIRNA');

// HAPUS INACBG
Route::get('inacbg/hapus-eklaim-irj-igd/{id}', 'InacbgController@hapusInacbgIRJIGD');
Route::get('inacbg/hapus-eklaim-irna/{id}', 'InacbgController@hapusInacbgIRNA');