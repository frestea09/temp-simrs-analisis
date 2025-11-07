<?php

Route::group(['middleware' => ['web', 'auth', 'role:radiologi|administrator']], function () {
    //tindakanIRJ
    Route::view('echocardiogram/billing', 'echocardiogram.billing');
    Route::view('echocardiogram/template', 'echocardiogram.hasil_echocardiogram');
    Route::view('echocardiogram/hasil', 'echocardiogram.hasil');
    
	Route::get('echocardiogram/tindakan-irj', 'echocardiogramController@tindakanIRJ');
	Route::post('echocardiogram/tindakan-irj', 'echocardiogramController@tindakanIRJByTanggal');

	//tindakanIGD
	Route::get('echocardiogram/tindakan-ird', 'echocardiogramController@tindakanIRD');
	Route::post('echocardiogram/tindakan-ird', 'echocardiogramController@tindakanIRDByTanggal');

	//tindakanIRNA
	Route::get('echocardiogram/tindakan-irna', 'echocardiogramController@tindakanIRNA');
	Route::post('echocardiogram/tindakan-irna', 'echocardiogramController@tindakanIRNAByTanggal');

	Route::get('echocardiogram/cetak-echocardiogram/{registrasi_id}/{id?}', 'echocardiogramController@cetakEchocardiogram');

	//Ekspertise
	Route::get('echocardiogram/echocardiogram/{registrasi_id}', 'echocardiogramController@echocardiogram');
	Route::post('echocardiogram/echocardiogram/', 'echocardiogramController@saveEchocardiogram');

	//hasil echocardiogram
	Route::get('echocardiogram/hasil-echocardiogram', 'echocardiogramController@echocardiogramHasil');
	Route::post('echocardiogram/hasil-echocardiogram', 'echocardiogramController@echocardiogramBytanggal');

});