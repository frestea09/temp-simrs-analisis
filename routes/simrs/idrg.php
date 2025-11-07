<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('idrg/{id?}', 'IdrgController@index')->name('idrg');
	Route::get('data-tarif-idrg/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'IdrgController@dataTarif')->name('data-tarif-idrg');
	Route::post('simpan-idrg', 'IdrgController@simpanIdrg')->name('simpan-idrg');
	Route::get('idrgdetail/{id?}', 'IdrgController@idrgDetail')->name('idrgdetail');
	Route::get('hapus-idrg/{tarif_id}', 'IdrgController@hapusIdrg')->name('hapusIdrg');

});
