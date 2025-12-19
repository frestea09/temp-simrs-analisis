<?php

Route::view('/hrd/jabatan', 'hrd.jabatan.index')->name('jabatan.index');
Route::post('/hrd/jabatan/store', 'HRD\JabatanController@store')->name('jabatan.store');
Route::get('/hrd/jabatan/{id}/edit', 'HRD\JabatanController@edit')->name('jabatan.edit');
Route::get('/hrd/jabatan/{id}/show', 'HRD\JabatanController@show')->name('jabatan.show');
Route::put('/hrd/jabatan/update/{id}', 'HRD\JabatanController@update')->name('jabatan.update');
Route::get('/hrd/jabatan/destroy/{id}', 'HRD\JabatanController@destroy')->name( 'jabatan.destroy');

//data
Route::get('/hrd/jabatan/data-pegawai', 'HRD\JabatanController@dataPegawai')->name('jabatan.data-pegawai');
Route::get('/hrd/jabatan/data-jabatan/{biodata_id}', 'HRD\JabatanController@dataJabatan')->name('jabatan.data-jabatan');
