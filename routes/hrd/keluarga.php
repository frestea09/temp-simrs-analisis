<?php

Route::view('/hrd/keluarga', 'hrd.keluarga.index')->name('keluarga.index');
Route::get('/hrd/keluarga/create', 'HRD\KeluargaController@create')->name('keluarga.create');
Route::post('/hrd/keluarga/store', 'HRD\KeluargaController@store')->name('keluarga.store');
Route::get('/hrd/keluarga/{id}/edit', 'HRD\KeluargaController@edit')->name('keluarga.edit');
Route::post('/hrd/keluarga/save-anak', 'HRD\KeluargaController@saveDataAnak')->name('keluarga.save-anak');
Route::get('/hrd/keluarga/{id}/edit-anak', 'HRD\KeluargaController@editDaataAnak')->name('keluarga.edit-anak');
Route::put('/hrd/keluarga/update-anak/{id}', 'HRD\KeluargaController@updateDataAnak')->name('keluarga.update-anak');
Route::get('/hrd/keluarga/hapus-anak/{id}', 'HRD\KeluargaController@hapusAnak')->name('keluarga.hapus-anak');

//data
Route::get('/hrd/keluarga/data', 'HRD\KeluargaController@data')->name('keluarga.data');
Route::get('/hrd/keluarga/data-anak/{biodata_id}', 'HRD\KeluargaController@dataAnak')->name('keluarga.data-anak');

//option
Route::get('/hrd/keluarga/data-pekerjaan', 'HRD\KeluargaController@dataKerja')->name('keluarga.data-pekerjaan');
Route::get('/hrd/keluarga/data-pendidikan', 'HRD\KeluargaController@dataPendidikan')->name('keluarga.data-pendidikan');
