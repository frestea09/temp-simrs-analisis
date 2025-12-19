<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('form-sep/{reg_id?}', 'SepController@index');
	// Route::get('create/{reg_id?}', 'SepController@create');
	Route::get('form-sep-rujukan/', 'SepController@sepRujukan');
	Route::post('cari-sep/noka', 'SepController@cari_nojkn');
	Route::post('cari-histori-pelayanan', 'SepController@cariHistoriPelayanan');
	Route::get('sep/cetak-label/{registrasi_id}', 'SepController@cetakLabel');


	Route::get('form-antrian', 'SepController@create');
	
	
	Route::post('cari-sep/noka-igd', 'SepController@cari_nojkn_igd');
	Route::post('get-data-by-rujukan', 'SepController@getDataByRujukan');
	Route::post('cari-nik', 'SepController@cari_nik');
	Route::post('buat-sep', 'SepController@buat_sep');
	Route::post('buat-sep-inap', 'SepController@buat_sep_inap');
	Route::post('buat-sep-validasi', 'SepController@buat_sep_validasi');
	Route::post('buat-antrian', 'SepController@buat_antrian');
	Route::post('simpan-no-sep', 'SepController@simpan_sep');
	Route::get('sep-sukses', 'SepController@sep_sukses');
	Route::get('cetak-sep-new/{no_sep}', 'SepController@cetak_sep_new');
	Route::get('cetak-sep/{no_sep}', 'SepController@cetak_sep');
	Route::get('cetak-sep-farmasi/{no_sep}/{id}', 'SepController@cetak_sep_farmasi');
	Route::get('cetak-sep_rad/{no_sep}', 'SepController@cetak_sep_rad');
	Route::post('cari-ppk2ByNoka', 'SepController@cari_ppk2ByNoka');
	Route::get('sep/getdatadiet', 'SepController@getDataDiet');
	Route::get('sep/getPoli', 'SepController@getPoli');
	Route::get('sep/getDokter', 'SepController@getDokter');
	
	
	Route::get('sep/geticd10', 'SepController@getIcd10');
	Route::get('sep/geticd9', 'SepController@getIcd9');
	
	//IRNA
	Route::get('cari-sep-irna/noka/{no_kartu}', 'SepController@cari_nojknIRNA');
	Route::get('cari-sep-irna/nik/{nik}', 'SepController@cari_nikIRNA');
	Route::get('sep-update-tgl-pulang/{noSep}/{tglPulang}', 'SepController@updateTglPulang');
	
	Route::get('cetak-sep-irna/{id}', 'SepController@cetakSepSY');
	
	Route::get('updatesep', 'SepController@searchUpdateSEP');
	Route::post('updatesep', 'SepController@updateSEP');
	Route::post('simpan-update-SEP', 'SepController@simpanUpdateSEP');
	
	Route::get('respon-cetak-sep/{no_sep}', 'SepController@respon_cetak_sep');

	Route::get('faskeslanjutan/{ppk_rujukan}', 'AdmissionController@faskesLanjut');

	// INHEALTH MANDIRI
	Route::get('form-sep-inhealth/{reg_id?}', 'SepInhealthController@index');
	Route::post('cari-sep-inhealth/noka', 'SepInhealthController@EligibilitasPeserta');
	Route::post('buat-sjp', 'SepInhealthController@SimpanSJP');
	Route::post('simpan-no-sjp', 'SepInhealthController@simpan_sep');
	Route::post('cetak-sjp', 'SepInhealthController@CetakSJP');
});
