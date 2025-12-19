<?php

Route::resource('ppi', 'PPI\PpiController');
Route::resource('master-ppi', 'PPI\MasterPpiController');

Route::get('master-get-pasien', 'PPI\PpiController@getMasterPasien');

//laporan
Route::get('/laporan-ppi', 'PPI\PpiController@lap_ppi');
Route::post('/laporan-ppi', 'PPI\PpiController@lap_ppi_byTanggal');
