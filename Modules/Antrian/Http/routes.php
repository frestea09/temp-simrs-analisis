<?php

Route::group(['prefix' => 'antrian', 'namespace' => 'Modules\Antrian\Http\Controllers'], function()
{
    Route::get('/', 'AntrianController@touch')->name('antrian');
    Route::get('/layarlcd', 'AntrianController@layarlcd')->name('antrian.layarlcd');
    Route::post('/savetouch', 'AntrianController@savetouch')->name('antrian.savetouch');
    Route::post('/klinik-savetouch', 'AntrianController@savetouchKlinik')->name('antrian.savetouch_klinik');
    Route::post('/klinik-savetouch-new', 'AntrianController@savetouchKlinikNew')->name('antrian.savetouch_klinik_new');
    Route::get('/datalayarlcd', 'AntrianController@datalayarlcd')->name('antrian.datalayarlcd');
    Route::get('/suara', 'AntrianController@suara')->name('antrian.suara');

});
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'antrian', 'namespace' => 'Modules\Antrian\Http\Controllers'], function()
{
    Route::get('/daftarpanggil', 'AntrianController@daftarpanggil')->name('antrian.daftarpanggil'); //Data
    Route::get('/daftarantrian', 'AntrianController@daftarantrian')->name('antrian.daftarantrian'); //Halaman Daftar Antrian
    Route::get('/panggil/{id}', 'AntrianController@panggil')->name('antrian.panggil');
    Route::get('/panggil-beda/{id}/{loket}', 'AntrianController@panggilBeda')->name('antrian.panggil-beda');
    Route::get('/panggilkembali/{id}', 'AntrianController@panggilkembali')->name('antrian.panggilkembali');
    Route::get('/panggilkembali-beda/{id}/{loket}', 'AntrianController@panggilkembaliBeda')->name('antrian.panggilkembali-beda');
    Route::get('/registrasi/{id}/{jenis?}', 'AntrianController@registrasi');
    Route::get('/reg_pasienlama/{id}/{jenis?}', 'AntrianController@reg_pasienlama');
    Route::get('/reg_blmterdata/{id}/{jenis?}', 'AntrianController@reg_blm_terdata');

});
