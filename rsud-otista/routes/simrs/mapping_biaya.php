<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('mapping-biaya', 'MappingbiayaController@index')->name('mapping-biaya');
	Route::get('data-mapping-biaya', 'MappingbiayaController@dataMappingBiaya')->name('data-mapping-biaya');
	Route::get('mapping-biaya-tarif', 'MappingbiayaController@mappingBiaya');
	Route::post('simpan-mapping-biaya', 'MappingbiayaController@simpanMapping');
	Route::get('mapping-biaya/{id}', 'MappingbiayaController@viewMappingBiaya');
	Route::get('groupper-mapping/{id}', 'MappingbiayaController@groupper');
});
