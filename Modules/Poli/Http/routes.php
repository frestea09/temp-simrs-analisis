<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'poli', 'namespace' => 'Modules\Poli\Http\Controllers'], function()
{
  Route::get('/', 'PoliController@index')->name('poli');
  Route::get('/create', 'PoliController@create')->name('poli.create');
  Route::post('/store', 'PoliController@store')->name('poli.store');
  Route::get('/{id}/edit', 'PoliController@edit')->name('poli.edit');
  Route::put('/{id}', 'PoliController@update')->name('poli.update');
});
