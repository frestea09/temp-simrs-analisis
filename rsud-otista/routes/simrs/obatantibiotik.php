<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('obat-antibiotik', 'ObatAntibiotikController@index')->name('obat-antibiotik');
	Route::get('obat-antibiotik/create', 'ObatAntibiotikController@create')->name('obat-antibiotik.create');
	Route::post('obat-antibiotik', 'ObatAntibiotikController@store')->name('obat-antibiotik.store');
	Route::get('obat-antibiotik/{id}/show', 'ObatAntibiotikController@show')->name('obat-antibiotik.show');
	Route::get('obat-antibiotik/{id}/edit', 'ObatAntibiotikController@edit')->name('obat-antibiotik.edit');
	Route::put('obat-antibiotik/{id}', 'ObatAntibiotikController@update')->name('obat-antibiotik.update');
	Route::get('obat-antibiotik/{id}/delete', 'ObatAntibiotikController@destroy')->name('obat-antibiotik.destroy');
});