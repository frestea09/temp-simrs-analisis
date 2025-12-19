<?php
Route::get('/refbpjs/propinsi/', 'RefbpjsController@propinsi');
Route::get('/refbpjs/kabupaten/{val}', 'RefbpjsController@kabupaten');
Route::get('/refbpjs/kecamatan/{val}', 'RefbpjsController@kecamatan');

// IMPORT DATA WILAYAH SESUAI KODE WILAYAH BPJS
// Route::get('/refbpjs/importpropinsi', 'RefbpjsController@importprovinsi');
// Route::get('/refbpjs/importkabupaten', 'RefbpjsController@importkabupaten');
// Route::get('/refbpjs/importkecamatan', 'RefbpjsController@importkecamatan');

Route::get('/refbpjs/dokter/{val}', 'RefbpjsController@dokter');
