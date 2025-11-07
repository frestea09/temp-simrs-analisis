<?php

Route::get('aplicare-bpjs', 'AplicareController@index');
Route::get('aplicare-bpjs/create', 'AplicareController@create');
Route::post('aplicare-bpjs/store', 'AplicareController@store');
Route::get('aplicare-bpjs/update/{id}', 'AplicareController@update');
Route::get('aplicare-bpjs/updateall', 'AplicareController@updateall');
Route::get('aplicare-bpjs/readbed', 'AplicareController@readbed');
Route::get('aplicare-bpjs/kelas', 'AplicareController@kelas');
Route::get('aplicare-bpjs/delete-bed/{kodekelas}/{koderuang}', 'AplicareController@deleteBed');

Route::get('aplicare-bpjs/update', 'AplicareController@updateAll');

// KENANGA KELAS 2 & 3
Route::get('aplicare-bpjs/create-camelia-2', 'AplicareController@createBedCamelia2');
Route::get('aplicare-bpjs/create-bugenvil-2', 'AplicareController@createBedBugen2');
Route::get('aplicare-bpjs/create-anyelir-2', 'AplicareController@createBedAnyelir2');
Route::get('aplicare-bpjs/create-flamboyan', 'AplicareController@createBedFlamboyan1');
Route::get('aplicare-bpjs/create-mawar', 'AplicareController@createBedMawar2');
Route::get('aplicare-bpjs/create-wk', 'AplicareController@createBedWijaya');

// update kelas
Route::get('aplicare-bpjs/vip', 'AplicareController@vip');
Route::get('aplicare-bpjs/kls1', 'AplicareController@kls1');
Route::get('aplicare-bpjs/kls2', 'AplicareController@kls2');
Route::get('aplicare-bpjs/kls3', 'AplicareController@kls3');
Route::get('aplicare-bpjs/hcu', 'AplicareController@hcu');
Route::get('aplicare-bpjs/iso', 'AplicareController@iso');
