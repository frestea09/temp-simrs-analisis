<?php
Route::group(['middleware' => ['web', 'auth']], function () {

	Route::view('icdo-im/import','icdo-im.import_icdo')->name('icdo-im.import');
	Route::get('icdo-im', 'IcdoImController@index')->name('icdo-im');
	Route::get('icdo-im/data', 'IcdoImController@getData');
	Route::get('icdo-im/create', 'IcdoImController@create')->name('icdo-im.create');
	Route::post('icdo-im/import', 'IcdoImController@import')->name('icdo-im.proses-import');
	Route::post('icdo-im', 'IcdoImController@store')->name('icdo-im.store');
	Route::get('icdo-im/{id}/show', 'IcdoImController@show')->name('icdo-im.show');
	Route::get('icdo-im/{id}/edit', 'IcdoImController@edit')->name('icdo-im.edit');
	Route::put('icdo-im/{id}', 'IcdoImController@update')->name('icdo-im.update');
	Route::get('icdo-im/{id}/delete', 'IcdoImController@destroy')->name('icdo-im.destroy');
});