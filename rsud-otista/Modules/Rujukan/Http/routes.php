<?php

Route::group(['middleware' => 'web', 'prefix' => 'rujukan', 'namespace' => 'Modules\Rujukan\Http\Controllers'], function()
{
  Route::get('/', 'RujukanController@index')->name('rujukan');
  Route::get('/{id}/edit', 'RujukanController@edit')->name('rujukan.edit');
  Route::put('/{id}', 'RujukanController@update')->name('rujukan.update');
  Route::get('/create', 'RujukanController@create')->name('rujukan.create');
  Route::post('/store', 'RujukanController@store')->name('rujukan.store');
});
