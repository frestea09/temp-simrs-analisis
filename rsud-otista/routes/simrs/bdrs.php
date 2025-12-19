<?php
// Master
Route::group(['middleware' => ['web', 'auth', 'role:bdrs|administrator']], function () {

	//tindakan
	Route::get('bdrs/billing', 'BDRSController@billing');
	Route::post('bdrs/simpan-transaksi', 'BDRSController@simpanTransaksi');
	Route::get('bdrs/rb/{id}', 'BDRSController@rincianBiaya');
	Route::get('bdrs/delete/{id}', 'BDRSController@delete');

});
