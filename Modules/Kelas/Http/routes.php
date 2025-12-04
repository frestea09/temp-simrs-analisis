<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'kelas', 'namespace' => 'Modules\Kelas\Http\Controllers'], function()
{
    Route::get('/', 'KelasController@index')->name('kelas');
    Route::get('/create', 'KelasController@create')->name('kelas.create');
    Route::post('/store', 'KelasController@store')->name('kelas.store');
    Route::get('/{id}/edit', 'KelasController@edit')->name('kelas.edit');
    Route::put('/kelas/{id}', 'KelasController@update')->name('kelas.update');
    Route::get('/kelas/{id}', 'KelasController@destroy')->name('kelas.destroy');
});
