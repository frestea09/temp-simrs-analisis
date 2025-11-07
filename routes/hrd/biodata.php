<?php

 Route::view('/hrd/biodata', 'hrd.biodata.index')->name('biodata.index');
 Route::get('/hrd/biodata/create', 'HRD\BiodataController@create')->name('biodata.create');
 Route::post('/hrd/biodata/store', 'HRD\BiodataController@store')->name('biodata.store');
 Route::get('/hrd/biodata/data', 'HRD\BiodataController@data')->name('biodata.data');
 Route::get('/hrd/biodata/{id}/edit', 'HRD\BiodataController@edit')->name('biodata.edit');
 Route::put('/hrd/biodata/{id}', 'HRD\BiodataController@update')->name('biodata.update');
 Route::get('/hrd/biodata/search/pegawai', 'HRD\BiodataController@searchPegawai');