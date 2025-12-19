<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('masteridrg', 'MasteridrgController@index')->name('masteridrg');
	Route::get('masteridrg/mappRad', 'MasteridrgController@mappRad')->name('');
	Route::get('masteridrg/edit-tarif', 'MasteridrgController@editTarif')->name('masteridrg.edittarif');
	Route::post('masteridrg/edit-tarif', 'MasteridrgController@storeEditTarif')->name('masteridrg..edittarif');
	Route::post('masteridrg', 'MasteridrgController@store')->name('masteridrg.store');
	Route::get('masteridrg/{id}/show', 'MasteridrgController@show')->name('masteridrg.show');
	Route::get('data-masteridrg', 'MasteridrgController@dataList')->name('data-masteridrg');
	Route::get('masteridrg/{id}/edit', 'MasteridrgController@edit')->name('masteridrg.edit');
	Route::patch('masteridrg/{id}', 'MasteridrgController@update')->name('masteridrg.update');

});
