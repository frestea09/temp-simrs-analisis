<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('master-implementasi', 'ImplementasiKeperawatanController@index')->name('master-implementasi');
	Route::get('master-implementasi/create', 'ImplementasiKeperawatanController@create')->name('master-implementasi.create');
	Route::post('master-implementasi', 'ImplementasiKeperawatanController@store')->name('master-implementasi.store');
	Route::get('master-implementasi/{id}/show', 'ImplementasiKeperawatanController@show')->name('master-implementasi.show');
	Route::get('master-implementasi/{id}/edit', 'ImplementasiKeperawatanController@edit')->name('master-implementasi.edit');
	Route::put('master-implementasi/{id}', 'ImplementasiKeperawatanController@update')->name('master-implementasi.update');
	Route::get('master-implementasi/{id}/delete', 'ImplementasiKeperawatanController@destroy')->name('master-implementasi.destroy');
});