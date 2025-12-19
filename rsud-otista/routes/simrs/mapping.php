<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('mapping/{id?}', 'MappingController@index')->name('mapping');
	Route::get('data-tarif-mapping/{tahuntarif_id?}/{jenis?}/{kategoritarif_id?}', 'MappingController@dataTarif')->name('data-tarif-mapping');
	Route::post('simpan-mapping', 'MappingController@simpanMapping')->name('simpan-mapping');
	Route::get('mappingdetail/{id?}', 'MappingController@mappingDetail')->name('mappingdetail');
	Route::get('hapus-mapping/{tarif_id}', 'MappingController@hapusMapping')->name('hapusMapping');

});
