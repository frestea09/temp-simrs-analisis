<?php

Route::get('/api/v3/siranap', 'Covid\CovidController@post');
Route::get('/api/v3/siranapupdate', 'Covid\CovidController@put');
Route::get('/api/v3/siranapdelete', 'Covid\CovidController@delete');
// Route::post('bridging/cari', 'BridgingController@cariPasien');

//Bridging SEP baru

