<?php

 Route::get('/hrd/mutasi', 'HRD\MutasiController@index');
 Route::get('/hrd/mutasi/create/{id}', 'HRD\MutasiController@create');
 Route::get('/hrd/mutasi/data', 'HRD\MutasiController@data');
 Route::post('/hrd/mutasi', 'HRD\MutasiController@store');
 Route::delete('/hrd/mutasi/{id}', 'HRD\MutasiController@destroy');
 Route::get('/hrd/mutasi/detail/{id}', 'HRD\MutasiController@detail');