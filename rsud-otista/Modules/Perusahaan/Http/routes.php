<?php

Route::group(['middleware' => 'web', 'prefix' => 'perusahaan', 'namespace' => 'Modules\Perusahaan\Http\Controllers'], function()
{
  Route::get('/', 'PerusahaanController@index')->name('perusahaan');
  Route::get('/create', 'PerusahaanController@create')->name('perusahaan.create');
  Route::post('/store', 'PerusahaanController@store')->name('perusahaan.store');
  Route::put('/{id}', 'PerusahaanController@update')->name('perusahaan.update');
  Route::get('/{id}/edit', 'PerusahaanController@edit')->name('perusahaan.edit');
});
