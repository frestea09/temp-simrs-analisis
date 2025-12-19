<?php

Route::view ('/hrd/disiplin', 'hrd.disiplin.index')->name ('disiplin.index');
Route::post('/hrd/disiplin/store', 'HRD\DisiplinController@store')->name('disiplin.store');
Route::get('/hrd/disiplin/{id}/edit', 'HRD\DisiplinController@edit')->name('disiplin.edit');
Route::get('/hrd/disiplin/{id}/show', 'HRD\DisiplinController@show')->name('disiplin.show');
Route::put('/hrd/disiplin/update/{id}', 'HRD\DisiplinController@update')->name('disiplin.update');
Route::get('/hrd/disiplin/destroy/{id}', 'HRD\DisiplinController@destroy')->name('disiplin.destroy');

//data
Route::get('/hrd/disiplin/data-pegawai', 'HRD\DisiplinController@dataPegawai')->name('disiplin.data-pegawai');
Route::get('/hrd/disiplin/data-disiplin/{biodata_id}', 'HRD\DisiplinController@dataDisiplin')->name('disiplin.data-disiplin');
