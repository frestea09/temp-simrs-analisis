<?php

Route::get('kelompokkelas', 'KelompokkelasController@index');
Route::post('kelompokkelas/save', 'KelompokkelasController@save');
Route::get('kelompokkelas/data', 'KelompokkelasController@data');
Route::get('kelompokkelas/{id}/edit', 'KelompokkelasController@edit');
Route::patch('kelompokkelas/{id}', 'KelompokkelasController@update');
