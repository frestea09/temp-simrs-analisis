<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('masterpagu', 'MasterpaguController@index')->name('masterpagu');
	Route::get('masterpagu/create', 'MasterpaguController@create')->name('masterpagu.create');
	Route::post('masterpagu', 'MasterpaguController@store')->name('masterpagu.store');
	Route::get('masterpagu/{id}/show', 'MasterpaguController@show')->name('masterpagu.show');
	Route::get('masterpagu/{id}/edit', 'MasterpaguController@edit')->name('masterpagu.edit');
	Route::put('masterpagu/{id}', 'MasterpaguController@update')->name('masterpagu.update');
	Route::get('masterpagu/{id}/delete', 'MasterpaguController@destroy')->name('masterpagu.destroy');

});