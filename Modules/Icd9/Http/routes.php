<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'icd9', 'namespace' => 'Modules\Icd9\Http\Controllers'], function()
{
    Route::get('/', 'Icd9Controller@index')->name('icd9');
    Route::get('/create', 'Icd9Controller@create')->name('icd9.create');
    Route::post('/store', 'Icd9Controller@store')->name('icd9.store');
    Route::get('/{id}/edit', 'Icd9Controller@edit')->name('icd9.edit');
    Route::put('/{id}', 'Icd9Controller@update')->name('icd9.update');

    Route::get('/getICD9', 'Icd9Controller@getICD9');
    Route::get('/getData/{no?}', 'Icd9Controller@getDataIcd9');

});
