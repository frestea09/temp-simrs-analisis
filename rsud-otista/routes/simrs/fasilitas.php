<?php

Route::get('/fasilitas', 'FasilitasController@index')->name('fasilitas');
Route::put('/fasilitas/update/{id}', 'FasilitasController@update')->name('fasilitas.update');


Route::get('/consid', 'FasilitasController@consid')->name('consid');
Route::get('/antrolo', 'FasilitasController@antrolo')->name('consid');
Route::post('/consid/update', 'FasilitasController@updateConsid')->name('consid.update');
Route::post('/consid/antrolo', 'FasilitasController@updateAntrolo')->name('antrolo.update');

Route::get('/jam_laporan', 'FasilitasController@JamLaporan')->name('jam_laporan');
Route::post('/jam_laporan/update', 'FasilitasController@updateJamLaporan')->name('jam_laporan.update');

// LOCK APM
Route::get('/lock_apm', 'FasilitasController@LockApm')->name('lock_apm');
Route::post('/lock_apm/update', 'FasilitasController@updateLockApm')->name('lock_apm.update');

Route::post('/satu_sehat/update', 'FasilitasController@updateSatusehat')->name('satu_sehat.update');
Route::get('/satu_sehat', 'FasilitasController@Satusehat')->name('satu_sehat');