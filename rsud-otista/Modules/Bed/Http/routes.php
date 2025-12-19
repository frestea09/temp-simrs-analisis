<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'bed', 'namespace' => 'Modules\Bed\Http\Controllers'], function()
{
    Route::get('/', 'BedController@index')->name('bed');
    Route::get('/create', 'BedController@create')->name('bed.create');
    Route::post('/store', 'BedController@store')->name('bed.store');
    Route::get('/{id}/edit', 'BedController@edit')->name('bed.edit');
    Route::put('/{id}', 'BedController@update')->name('bed.update');
    Route::get('/hapus/{id}', 'BedController@destroy')->name('bed.destroy');
    Route::get('/display-bed', 'BedController@display_bed');
    Route::get('/kosongkan/{id}', 'BedController@kosongkanBed')->name('bed.kosongkan');
    Route::get('/kosongkanbatal/{id}', 'BedController@batalKosongkanBed')->name('bed.kosongkanbatal');
});
