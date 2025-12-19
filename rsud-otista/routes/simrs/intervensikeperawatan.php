<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('master-intervensi', 'IntervensiKeperawatanController@index')->name('master-intervensi');
	Route::get('master-intervensi/create', 'IntervensiKeperawatanController@create')->name('master-intervensi.create');
	Route::post('master-intervensi', 'IntervensiKeperawatanController@store')->name('master-intervensi.store');
	Route::get('master-intervensi/{id}/show', 'IntervensiKeperawatanController@show')->name('master-intervensi.show');
	Route::get('master-intervensi/{id}/edit', 'IntervensiKeperawatanController@edit')->name('master-intervensi.edit');
	Route::put('master-intervensi/{id}', 'IntervensiKeperawatanController@update')->name('master-intervensi.update');
	Route::get('master-intervensi/{id}/delete', 'IntervensiKeperawatanController@destroy')->name('master-intervensi.destroy');
});