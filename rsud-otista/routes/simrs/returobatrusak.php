<?php
Route::get('retur-obat-rusak', 'ReturObatRusakController@index');
Route::get('retur-obat-rusak/create', 'ReturObatRusakController@create');
Route::get('retur-obat-rusak/get-obat', 'ReturObatRusakController@getObat');
Route::post('retur-obat-rusak/save', 'ReturObatRusakController@store')->name('simpan-retur-obat-rusak');
Route::post('penyerahan-obat-rusak-supplier', 'ReturObatRusakController@penyerahanObat');