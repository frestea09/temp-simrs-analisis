<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'pekerjaan', 'namespace' => 'Modules\Pekerjaan\Http\Controllers'], function()
{
  Route::get('/', 'PekerjaanController@index')->name('pekerjaan');
  Route::get('/create', 'PekerjaanController@create')->name('pekerjaan.create');
  Route::get('/{id}/edit', 'PekerjaanController@edit')->name('pekerjaan.edit');
  Route::post('/store', 'PekerjaanController@store')->name('pekerjaan.store');
  Route::put('/{id}', 'PekerjaanController@update')->name('pekerjaan.update');
});
