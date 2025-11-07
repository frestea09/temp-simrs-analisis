<?php

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('spri/{registrasi_id}', 'SuratInapController@spri');
	Route::get('create-spri/{registrasi_id}', 'SuratInapController@createSpri');
	Route::get('create-spri-manual/{registrasi_id}', 'SuratInapController@createSpriManual');
	Route::delete('/spri/delete/{id}', 'SuratInapController@deleteSpri');
	Route::get('view-spri/{registrasi_id}', 'SuratInapController@index');
	Route::post('spri/store', 'SuratInapController@store');
	Route::post('spri/buat-spri', 'SuratInapController@buat_spri');
	Route::get('spri/cetak/{registrasi_id}', 'SuratInapController@show');

	
});
