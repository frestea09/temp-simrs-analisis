<?php

Route::view ('/hrd/penghargaan', 'hrd.penghargaan.index')->name ('penghargaan.index');
Route::post('/hrd/penghargaan/store', 'HRD\PenghargaanController@store')->name('penghargaan.store');
Route::get('/hrd/penghargaan/{id}/edit', 'HRD\PenghargaanController@edit')->name('penghargaan.edit');
Route::get('/hrd/penghargaan/{id}/show', 'HRD\PenghargaanController@show')->name('penghargaan.show');
Route::put('/hrd/penghargaan/update/{id}', 'HRD\PenghargaanController@update')->name('penghargaan.update');
Route::get('/hrd/penghargaan/destroy/{id}', 'HRD\PenghargaanController@destroy')->name('penghargaan.destroy');

//data
Route::get('/hrd/penghargaan/data-pegawai', 'HRD\PenghargaanController@dataPegawai')->name('penghargaan.data-pegawai');
Route::get('/hrd/penghargaan/data-penghargaan/{biodata_id}', 'HRD\PenghargaanController@dataPenghargaan')->name('penghargaan.data-penghargaan');
