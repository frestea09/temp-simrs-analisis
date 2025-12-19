<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'pegawai', 'namespace' => 'Modules\Pegawai\Http\Controllers'], function()
{
    Route::get('/', 'PegawaiController@index')->name('pegawai');
    Route::get('/create', 'PegawaiController@create')->name('pegawai.create');
    Route::post('/store', 'PegawaiController@store')->name('pegawai.store');
    Route::get('/{id}/edit', 'PegawaiController@edit')->name('pegawai.edit');
    Route::put('/pegawai/{id}', 'PegawaiController@update')->name('pegawai.update');
    Route::post('/update-kuota', 'PegawaiController@updateKuota')->name('pegawai.update.kuota');
    Route::get('/{id}', 'PegawaiController@destroy')->name('pegawai.destroy');
});
