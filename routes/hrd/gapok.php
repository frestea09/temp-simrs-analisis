<?php

Route::view ('/hrd/gapok', 'hrd.gapok.index')->name ('gapok.index');
Route::post('/hrd/gapok/store', 'HRD\GapokController@store')->name('gapok.store');
Route::get('/hrd/gapok/{id}/edit', 'HRD\GapokController@edit')->name('gapok.edit');
Route::get('/hrd/gapok/{id}/show', 'HRD\GapokController@show')->name('gapok.show');
Route::put('/hrd/gapok/update/{id}', 'HRD\GapokController@update')->name('gapok.update');
Route::get('/hrd/gapok/destroy/{id}', 'HRD\GapokController@destroy')->name('gapok.destroy');

//data
Route::get('/hrd/gapok/data-pegawai', 'HRD\GapokController@dataPegawai')->name('gapok.data-pegawai');
Route::get('/hrd/gapok/data-gapok/{biodata_id}', 'HRD\GapokController@dataGapok')->name('gapok.data-gapok');
