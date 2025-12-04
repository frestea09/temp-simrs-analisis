<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'instalasi', 'namespace' => 'Modules\Instalasi\Http\Controllers'], function()
{
    Route::get('/', 'InstalasiController@index')->name('instalasi');
    Route::get('/create', 'InstalasiController@create')->name('instalasi.create');
    Route::post('/store', 'InstalasiController@store')->name('instalasi.store');
    Route::get('/{id}/edit', 'InstalasiController@edit')->name('instalasi.edit');
    Route::put('/{id}/update', 'InstalasiController@update')->name('instalasi.update');
});
