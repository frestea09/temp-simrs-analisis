<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'sebabsakit', 'namespace' => 'Modules\Sebabsakit\Http\Controllers'], function()
{
  Route::get('/', 'SebabsakitController@index')->name('sebabsakit');
  Route::get('/create', 'SebabsakitController@create')->name('sebabsakit.create');
  Route::get('/{id}/edit', 'SebabsakitController@edit')->name('sebabsakit.edit');
  Route::post('/store', 'SebabsakitController@store')->name('sebabsakit.store');
  Route::put('/{id}', 'SebabsakitController@update')->name('sebabsakit.update');
});
