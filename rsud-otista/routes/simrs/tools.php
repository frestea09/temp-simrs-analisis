<?php
// Route::get('test/kamera', 'ToolsController@index');
Route::post('cek-histori-pasien', 'ToolsController@historiPasien');
Route::post('/update-logistik-stok/{id}', 'ToolsController@updateLogistikID')->name('tools-update-logistik-stok');
Route::get('/total-penjualan/{faktur}', 'ToolsController@totalPenjualan');
Route::get('/total-folio/{reg_id}', 'ToolsController@totalFolio');
Route::get('/microtime', 'ToolsController@microtime');


// UPDATE PENJUALAN DETAIL
Route::get('acuan-data-penjualan', 'ToolsController@getLogistikStock');
Route::get('list-penjualan-salah', 'ToolsController@getPenjualanDetail');
Route::post('list-penjualan-salah', 'ToolsController@getPenjualanDetailby');
Route::post('rincian-penjualan/{id}', 'ToolsController@updateRincianObat')->name('tools-update-penjualan-detail');



Route::view('tools', 'tools.index');

