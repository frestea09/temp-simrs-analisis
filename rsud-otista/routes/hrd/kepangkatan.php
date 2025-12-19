<?php

Route::view('/hrd/kepangkatan', 'hrd.kepangkatan.index')->name('kepangkatan.index');
Route::post('/hrd/kepangkatan/store', 'HRD\KepangkatanController@store')->name('kepangkatan.store');
Route::get('/hrd/kepangkatan/{id}/edit','HRD\KepangkatanController@edit')->name('kepangkatan.edit');
Route::get('/hrd/kepangkatan/destroy/{id}', 'HRD\KepangkatanController@destroy')->name('kepangkatan.destroy');
Route::get('/hrd/kepangkatan/{id}/show', 'HRD\KepangkatanController@show')->name('kepangkatan.show');
Route::put('/hrd/kepangkatan/update/{id}', 'HRD\KepangkatanController@update')->name('kepangkatan.update');


//data
Route::get('/hrd/kepangkatan/data-pegawai', 'HRD\KepangkatanController@dataPegawai')->name('kepangkatan.data-pegawai');
Route::get('/hrd/kepangkatan/data-kepangkatan/{biodata_id}', 'HRD\KepangkatanController@dataKepangakatan')->name('kepangkatan.data-kepangkatan');
