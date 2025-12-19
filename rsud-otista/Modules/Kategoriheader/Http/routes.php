<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'kategoriheader', 'namespace' => 'Modules\Kategoriheader\Http\Controllers'], function()
{
    Route::get('/', 'KategoriheaderController@index')->name('kategoriheader');
    Route::get('/create', 'KategoriheaderController@create')->name('kategoriheader.create');
    Route::post('/store', 'KategoriheaderController@store')->name('kategoriheader.store');
    Route::get('/{id}/edit', 'KategoriheaderController@edit')->name('kategoriheader.edit');
    Route::put('/{id}', 'KategoriheaderController@update')->name('kategoriheader.update');
});
