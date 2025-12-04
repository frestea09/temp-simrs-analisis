<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'pendidikan', 'namespace' => 'Modules\Pendidikan\Http\Controllers'], function()
{
  Route::get('/', 'PendidikanController@index')->name('pendidikan');
  Route::get('/create', 'PendidikanController@create')->name('pendidikan.create');
  Route::get('/{id}/edit', 'PendidikanController@edit')->name('pendidikan.edit');
  Route::post('/store', 'PendidikanController@store')->name('pendidikan.store');
  Route::put('/{id}', 'PendidikanController@update')->name('pendidikan.update');
});
