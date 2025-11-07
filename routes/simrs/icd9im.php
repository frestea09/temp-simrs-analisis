<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('icd9-im', 'Icd9ImController@index')->name('icd9-im');
	Route::get('icd9-im/create', 'Icd9ImController@create')->name('icd9-im.create');
	Route::post('icd9-im', 'Icd9ImController@store')->name('icd9-im.store');
	Route::get('icd9-im/data', 'Icd9ImController@getData');
	Route::get('icd9-im/{id}/show', 'Icd9ImController@show')->name('icd9-im.show');
	Route::get('icd9-im/{id}/edit', 'Icd9ImController@edit')->name('icd9-im.edit');
	Route::put('icd9-im/{id}', 'Icd9ImController@update')->name('icd9-im.update');
	Route::get('icd9-im/{id}/delete', 'Icd9ImController@destroy')->name('icd9-im.destroy');
});