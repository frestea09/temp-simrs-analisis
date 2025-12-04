<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'kamar', 'namespace' => 'Modules\Kamar\Http\Controllers'], function()
{
    Route::get('/', 'KamarController@index')->name('kamar');
    Route::get('/create', 'KamarController@create')->name('kamar.create');
    Route::post('/store', 'KamarController@store')->name('kamar.store');
    Route::get('/{id}/edit', 'KamarController@edit')->name('kamar.edit');
    Route::put('/{id}', 'KamarController@update')->name('kamar.update');

    //Ajax
    Route::get('/getkelas/{kelompokkelas_id}', 'KamarController@getKelas')->name('kamar.getkelas');
    Route::get('/getkamar/{kelompokkelas_id}/{kelas_id}', 'KamarController@getKamar')->name('kamar.getKamar');
});
