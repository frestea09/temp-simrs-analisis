<?php
Route::get('regperjanjian/{id?}', 'RegperjanjianController@index' );
Route::post('regperjanjian/searchpasien', 'RegperjanjianController@searchPasien');
Route::post('save-reg-perjanjian', 'RegperjanjianController@savePerjanjian');
Route::put('save-reg-perjanjian/{id}', 'RegperjanjianController@savePerjanjianPasienLama');
Route::get('daftar-perjanjian/{tgl?}/{poli_id?}', 'RegperjanjianController@antrianPerjanjian');
Route::post('view-perjanjian', 'RegperjanjianController@cariAntrian');
Route::get('hapus-regperjanjian/{id}/{tgl}/{poli_id}', 'RegperjanjianController@hapusAntrian');

Route::get('regperjanjian/online/{id?}', 'RegperjanjianController@indexOnline' );

// save perjanjian online
Route::post('save-reg-perjanjian-online', 'RegOnlineController@savePerjanjianOnline');
Route::put('save-reg-perjanjian-online/{id}', 'RegOnlineController@savePerjanjianPasienLamaOnline');
