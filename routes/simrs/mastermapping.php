<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('mastermapping', 'MastermappingController@index')->name('mastermapping');
	Route::get('mastermapping/mappRad', 'MastermappingController@mappRad')->name('');
	Route::get('mastermapping/edit-tarif', 'MastermappingController@editTarif')->name('mastermapping.edittarif');
	Route::post('mastermapping/edit-tarif', 'MastermappingController@storeEditTarif')->name('mastermapping..edittarif');
	Route::post('mastermapping', 'MastermappingController@store')->name('mastermapping.store');
	Route::get('mastermapping/{id}/show', 'MastermappingController@show')->name('mastermapping.show');
	Route::get('data-mastermapping', 'MastermappingController@dataList')->name('data-mastermapping');
	Route::get('mastermapping/{id}/edit', 'MastermappingController@edit')->name('mastermapping.edit');
	Route::patch('mastermapping/{id}', 'MastermappingController@update')->name('mastermapping.update');

});
