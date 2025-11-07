<?php

// Route::view ('/hrd/cuti', 'hrd.cuti.index')->name ('cuti.index');
Route::get('/hrd/cuti', 'HRD\CutiController@index')->name('cuti.store');
Route::post('/hrd/cuti/store', 'HRD\CutiController@store')->name('cuti.store');
Route::get('/hrd/cuti/{id}/edit', 'HRD\CutiController@edit')->name('cuti.edit');
Route::get('/hrd/cuti/{id}/show', 'HRD\CutiController@show')->name('cuti.show');
Route::put('/hrd/cuti/update/{id}', 'HRD\CutiController@update')->name('cuti.update');
Route::get('/hrd/cuti/destroy/{id}', 'HRD\CutiController@destroy')->name('cuti.destroy');

//data
Route::get('/hrd/cuti/data-pegawai', 'HRD\CutiController@dataPegawai')->name('cuti.data-pegawai');
Route::get('/hrd/cuti/data-cuti/{biodata_id}', 'HRD\CutiController@datacuti')->name('cuti.data-cuti');
Route::get('/hrd/cuti/verifikator/{id}', 'HRD\CutiController@dataVerifikator');

// verify
Route::get('/hrd/cuti/verifikator', 'HRD\CutiController@verifikator');
Route::post('/hrd/cuti/verifikator', 'HRD\CutiController@prosesVerifikator');

// singkron biodata - pegawai
Route::get('/pegawai/biodata/sinkron', 'HRD\CutiController@sinkronPegawai');
Route::post('/pegawai/biodata/sinkron', 'HRD\CutiController@prosesSinkronPegawai');

// cetak
Route::get('/hrd/cuti/cetak/cuti/{id}', 'HRD\CutiController@cetakCuti');
Route::get('/hrd/cuti/cetak/pernyataan/{id}', 'HRD\CutiController@cetakPernyataaan');
Route::get('/hrd/cuti/cetak/pelimpahan/{id}', 'HRD\CutiController@cetakPelimpahan');