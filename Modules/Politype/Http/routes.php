<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'politype', 'namespace' => 'Modules\Politype\Http\Controllers'], function()
{
    Route::get('/', 'PolitypeController@index')->name('politype');
    Route::get('/create', 'PolitypeController@create')->name('politype.create');
    Route::post('/store', 'PolitypeController@store')->name('politype.store');
    Route::get('/{id}/edit', 'PolitypeController@edit')->name('politype.edit');
    Route::put('/{id}', 'PolitypeController@update')->name('politype.update');
});
