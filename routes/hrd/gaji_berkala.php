<?php

Route::view ('/hrd/gaji', 'hrd.gaji_berkala.index')->name ('gaji.index');
Route::post('/hrd/gaji/store', 'HRD\GajiBerkalaController@store')->name('gaji.store');
Route::get('/hrd/gaji/{id}/edit', 'HRD\GajiBerkalaController@edit')->name('gaji.edit');
Route::get('/hrd/gaji/{id}/show', 'HRD\GajiBerkalaController@show')->name('gaji.show');
Route::put('/hrd/gaji/update/{id}', 'HRD\GajiBerkalaController@update')->name('gaji.update');
Route::get('/hrd/gaji/destroy/{id}', 'HRD\GajiBerkalaController@destroy')->name( 'gaji.destroy');

//data
Route::get('/hrd/gaji/data-pegawai', 'HRD\GajiBerkalaController@dataPegawai')->name('gaji.data-pegawai');
Route::get('/hrd/gaji/data-gaji/{biodata_id}', 'HRD\GajiBerkalaController@dataGaji')->name('gaji.data-gaji');
