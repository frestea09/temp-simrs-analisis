<?php

Route::namespace('Saderek')->group(function () {
    Route::group(['prefix' => 'saderek', 'middleware' => ['web','auth']], function(){
        Route::get('pendaftaran-online', 'PendaftaranOnlineController@index');
        Route::post('pendaftaran-online', 'PendaftaranOnlineController@indexFilter');
    });
});