<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('diagnosa-keperawatan', 'DiagnosaKeperawatanController@index')->name('diagnosa-keperawatan');
	Route::get('diagnosa-keperawatan/create', 'DiagnosaKeperawatanController@create')->name('diagnosa-keperawatan.create');
	Route::post('diagnosa-keperawatan', 'DiagnosaKeperawatanController@store')->name('diagnosa-keperawatan.store');
	Route::get('diagnosa-keperawatan/{id}/show', 'DiagnosaKeperawatanController@show')->name('diagnosa-keperawatan.show');
	Route::get('diagnosa-keperawatan/{id}/edit', 'DiagnosaKeperawatanController@edit')->name('diagnosa-keperawatan.edit');
	Route::put('diagnosa-keperawatan/{id}', 'DiagnosaKeperawatanController@update')->name('diagnosa-keperawatan.update');
	Route::get('diagnosa-keperawatan/{id}/delete', 'DiagnosaKeperawatanController@destroy')->name('diagnosa-keperawatan.destroy');
});