<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'registrasi', 'namespace' => 'Modules\Registrasi\Http\Controllers'], function () {
	Route::get('/', 'RegistrasiController@index')->name('registrasi');
	Route::get('/create/{id?}', 'RegistrasiController@create')->name('registrasi.create');
	Route::post('/store', 'RegistrasiController@store')->name('registrasi.store');
	Route::get('/show', 'RegistrasiController@show')->name('registrasi.show');
	Route::put('/{id}', 'RegistrasiController@update')->name('registrasi.update');
	Route::post('/search', 'RegistrasiController@search')->name('registrasi.search');
	Route::post('/search_ajax', 'RegistrasiController@search_ajax')->name('registrasi.search_ajax');
	Route::get('/getkasus/{poli_id}/{pasien}', 'RegistrasiController@getKasus');
	Route::get('/getDokterPoli/{poli_id}', 'RegistrasiController@getDokterPoli');
	Route::get('/temuandokter/{poli_id}', 'RegistrasiController@getTemuanDokter');
	Route::get('/create_umum/{id?}', 'RegistrasiController@create_umum')->name('registrasi.create_umum');

	//IGD JKN
	Route::get('/igd/jkn/{id?}', 'RegistrasiController@reg_igd_jkn');
	Route::get('/igd/jknlama', 'RegistrasiController@reg_igd_jkn_lama');
	Route::get('/igd/jkn-blm-terdata', 'RegistrasiController@reg_igd_jkn_blmterdata');
	//IGD UMUM
	Route::get('/igd/umum/{id?}', 'RegistrasiController@reg_igd_umum');
	Route::get('/igd/umumlama', 'RegistrasiController@reg_igd_umum_lama');
	Route::get('/igd/umum-blm-terdata', 'RegistrasiController@reg_igd_umum_blmterdata');

	// RANAP JKN
	Route::get('/ranap/form-sep/{id?}', 'RegistrasiRanapController@form_sep');
	Route::get('/ranap/jkn/{id?}', 'RegistrasiRanapController@reg_ranap_jkn');
	Route::get('/ranap/jknlama', 'RegistrasiRanapController@reg_ranap_jkn_lama');
	Route::get('/ranap/jkn-blm-terdata', 'RegistrasiRanapController@reg_ranap_jkn_blmterdata');
	//RANAP UMUM
	Route::get('/ranap/umum/{id?}', 'RegistrasiRanapController@reg_ranap_umum');
	Route::get('/ranap/umumlama', 'RegistrasiRanapController@reg_ranap_umum_lama');
	Route::get('/ranap/umum-blm-terdata', 'RegistrasiRanapController@reg_ranap_umum_blmterdata');
	
	Route::post('/ranap/store-reg', 'RegistrasiRanapController@store')->name('registrasi_ranap.store');;
	Route::put('/ranap/update/{id}', 'RegistrasiRanapController@update')->name('registrasi_ranap.update');

	Route::get('/dataicd10', 'RegistrasiController@get_icd10');


	Route::post('/store-with-antrol', 'RegistrasiController@storeWithAntrol');
	Route::put('/update-with-antrol/{id}', 'RegistrasiController@updateWithAntrol');

	//Tarif IDRG
	Route::post('/set-tarif-idrg', 'RegistrasiController@setTarifIDRG')->name('registrasi.setTarifIDRG');

});
