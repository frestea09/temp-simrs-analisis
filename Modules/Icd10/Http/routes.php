<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'icd10', 'namespace' => 'Modules\Icd10\Http\Controllers'], function()
{
    Route::get('/', 'Icd10Controller@index')->name('icd10');
    Route::get('/create', 'Icd10Controller@create')->name('icd10.create');
    Route::post('/store', 'Icd10Controller@store')->name('icd10.store');
    Route::get('/{id}/edit', 'Icd10Controller@edit')->name('icd10.edit');
    Route::put('/{id}', 'Icd10Controller@update')->name('icd10.update');

    Route::get('/getICD10', 'Icd10Controller@getICD10');
    Route::get('/getData/{no?}', 'Icd10Controller@getDataIcd10');
});
