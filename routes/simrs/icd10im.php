<?php
Route::group(['middleware' => ['web', 'auth']], function () {

	Route::view('icd10-im/import','icd10-im.import_icd10')->name('icd10-im.import');
	Route::get('icd10-im', 'Icd10ImController@index')->name('icd10-im');
	Route::get('icd10-im/data', 'Icd10ImController@getData');
	Route::get('icd10-im/create', 'Icd10ImController@create')->name('icd10-im.create');
	Route::post('icd10-im/import', 'Icd10ImController@import')->name('icd10-im.proses-import');
	Route::post('icd10-im', 'Icd10ImController@store')->name('icd10-im.store');
	Route::get('icd10-im/{id}/show', 'Icd10ImController@show')->name('icd10-im.show');
	Route::get('icd10-im/{id}/edit', 'Icd10ImController@edit')->name('icd10-im.edit');
	Route::put('icd10-im/{id}', 'Icd10ImController@update')->name('icd10-im.update');
	Route::get('icd10-im/{id}/delete', 'Icd10ImController@destroy')->name('icd10-im.destroy');
});