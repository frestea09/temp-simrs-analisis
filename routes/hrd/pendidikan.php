<?php

Route::view('/hrd/pendidikan', 'hrd.pendidikan.index')->name('pendidikan.index');
Route::get('/hrd/pendidikan/{id}/edit', 'HRD\PendidikanController@edit')->name('pendidikan.edit');
Route::post( '/hrd/pendidikan/store', 'HRD\PendidikanController@store')->name( 'pendidikan.store');
Route::get('/hrd/pendidikan/{id}/show', 'HRD\PendidikanController@show')->name('pendidikan.show');
Route::put('/hrd/pendidikan/update/{id}','HRD\PendidikanController@update')->name('pendidikan.update');
Route::get('/hrd/pendidikan/destroy/{id}', 'HRD\PendidikanController@destroy')->name('pendidikan.destroy');

//data
Route::get('/hrd/pendidikan/data-pegawai', 'HRD\PendidikanController@dataPegawai')->name('pendidikan.data-pegawai');
Route::get('/hrd/pendidikan/data-pendidikan', 'HRD\PendidikanController@dataPendidikan')->name('pendidikan.data-pendidikan');
Route::get('/hrd/pendidikan/pendidikan/{biodata_id}', 'HRD\PendidikanController@pendidikan')->name('pendidikan.pendidikan');
