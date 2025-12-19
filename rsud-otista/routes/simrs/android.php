<?php

Route::namespace('Android')->group(function () {
    Route::group(['prefix' => 'android', 'middleware' => ['web','auth']], function(){
        Route::get('pages', 'PagesController@index');
        Route::get('pages/create/{id}', 'PagesController@create');
        Route::post('pages/store', 'PagesController@store');
        Route::get('pages/{type}', 'PagesController@show');
        Route::get('pages/{id}/edit', 'PagesController@edit');
        Route::put('pages/{id}', 'PagesController@update');
        Route::delete('pages/{id}', 'PagesController@destroy');
        
        Route::view('konfigurasi', 'android.konfigurasi');

        Route::resource('type', 'TypeController');
        Route::resource('jabatan', 'JabatanController');
        Route::resource('manajemen', 'ManajemenController');
        Route::resource('direksi', 'DireksiController');
        Route::resource('slider', 'SliderController');
    });
});