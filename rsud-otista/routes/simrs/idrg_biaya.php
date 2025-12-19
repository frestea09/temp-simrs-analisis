<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('idrg-biaya', 'IdrgbiayaController@index')->name('idrg-biaya');
	Route::get('data-idrg-biaya', 'IdrgbiayaController@dataIdrgBiaya')->name('data-idrg-biaya');
	Route::get('idrg-biaya-tarif', 'IdrgbiayaController@idrgBiaya');
	Route::post('simpan-idrg-biaya', 'IdrgbiayaController@simpanIdrg');
	Route::get('idrg-biaya/{id}', 'IdrgbiayaController@viewIdrgBiaya');
	Route::get('groupper-idrg/{id}', 'IdrgbiayaController@groupper');
});
