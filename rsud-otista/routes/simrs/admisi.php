<?php

Route::group(['middleware' => ['web', 'auth', 'role:laboratorium|admission|rawatinap|rekammedis|supervisor|administrator|antrian|loketigd']], function () {
	//Admisi
	Route::get('admission', 'AdmissionController@index');
	Route::post('admission', 'AdmissionController@admissionByTanggal');
	Route::get('admission/proses/{id?}', 'AdmissionController@proses');
	//SEP Susulan
	Route::get('admission/sep-susulan/data-rawat-jalan', 'AdmissionController@dataRawatJalan');


	Route::view('admission/sep-susulan', 'admission.sep_susulan');
	Route::get('admission/sep-susulan/rawat-inap', 'AdmissionController@sepSusulanIRNA');
	Route::post('admission/sep-susulan/rawat-inap', 'AdmissionController@sepSusulanIRNAByTanggal');
	Route::get('admission/sep-susulan/rawat-jalan', 'AdmissionController@sepSusulanIRJ');
	Route::post('admission/sep-susulan/rawat-jalan', 'AdmissionController@sepSusulanIRJByTanggal');
	Route::get('admission/sep-susulan/rawat-darurat', 'AdmissionController@sepSusulanIGD');
	Route::post('admission/sep-susulan/rawat-darurat', 'AdmissionController@sepSusulanIGDByTanggal');

	Route::get('/admission/get-data-irna/{registrasi_id}', 'AdmissionController@getDataRawatInap');
	
	Route::get('form-sep-susulan/{reg_id?}', 'AdmissionController@formSEP_igd_irj');
	Route::get('form-sep-susulan-online/{reg_id?}', 'AdmissionController@formSEP_igd_irj_online');

	Route::post('admission/save-sep/irna', 'AdmissionController@saveSEPirna');
	Route::post('admission/save-sep/irj-igd', 'AdmissionController@saveSEP_irj_igd');
	
	// READMISI
	Route::get('frontoffice/readmisi', 'AdmissionController@readmisi');
	Route::post('frontoffice/readmisi', 'AdmissionController@readmisiSearch');
	Route::post('proses-readmisi', 'AdmissionController@prosesReadmisi');

});
