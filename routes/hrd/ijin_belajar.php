<?php

Route::view ('/hrd/ijin', 'hrd.ijin_belajar.index')->name ('ijin.index');
Route::post('/hrd/ijin/store', 'HRD\IjinBelajarController@store')->name('ijin.store');
Route::get('/hrd/ijin/{id}/edit', 'HRD\IjinBelajarController@edit')->name('ijin.edit');
Route::get('/hrd/ijin/{id}/show', 'HRD\IjinBelajarController@show')->name('ijin.show');
Route::put('/hrd/ijin/update/{id}', 'HRD\IjinBelajarController@update')->name('ijin.update');
Route::get('/hrd/ijin/destroy/{id}', 'HRD\IjinBelajarController@destroy')->name('ijin.destroy');

//data
Route::get('/hrd/ijin/data-pegawai', 'HRD\IjinBelajarController@dataPegawai')->name('ijin.data-pegawai');
Route::get('/hrd/ijin/data-ijin/{biodata_id}', 'HRD\IjinBelajarController@dataIjinBelajar')->name('ijin.data-ijin');
