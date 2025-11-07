<?php
Route::view('antrian-farmasi', 'antrianfarmasi.index');
Route::post('/antrianfarmasi/savetouch', 'AntrianFarmasiController@savetouch')->name('antrianfarmasi.savetouch');
Route::get('/antrian-farmasi/touch', 'AntrianFarmasiController@touch')->name('antrianfarmasi.touch');
Route::get('antrian-farmasi/suara', 'AntrianFarmasiController@suara')->name('antrianfarmasi.suara');
Route::get('antrian-farmasi/layarlcd', 'AntrianFarmasiController@layarlcd')->name('antrianfarmasi.layarlcd');

Route::get('antrian-farmasi/print', 'AntrianFarmasiController@printAntrian');
Route::get('antrian-farmasi/layarlcd/nextantrian', 'AntrianFarmasiController@antrianLayarLCD');

// Route::get('/datalayarlcd', 'AntrianController@datalayarlcd')->name('antrian.datalayarlcd');
// Route::get('/registrasi/{id}/{jenis?}', 'AntrianController@registrasi');
// Route::get('/reg_pasienlama/{id}/{jenis?}', 'AntrianController@reg_pasienlama');
// Route::get('/reg_blmterdata/{id}/{jenis?}', 'AntrianController@reg_blm_terdata');

Route::get('antrianfarmasi/', 'AntrianFarmasiController@touch')->name('antrianfarmasi');
#ANTRIAN LOKET 1
Route::get('antrian-farmasi/daftarpanggil1', 'AntrianFarmasiController@daftarpanggil1')->name('antrianfarmasi.daftarpanggil1'); //Data
Route::get('antrian-farmasi/daftarantrian1', 'AntrianFarmasiController@daftarantrian1')->name('antrianfarmasi.daftarantrian1'); //Halaman Daftar Antrian

Route::get('antrian-farmasi/panggil1/{id}', 'AntrianFarmasiController@panggil1')->name('antrianfarmasi.panggil1'); 
Route::get('antrian-farmasi/panggilkembali1/{id}', 'AntrianFarmasiController@panggilkembali1')->name('antrianfarmasi.panggilkembali1');
Route::get('antrian-farmasi/datalayarlcd1', 'AntrianFarmasiController@datalayarlcd1')->name('antrianfarmasi.datalayarlcd1');


#ANTRIAN LOKET 2
Route::get('antrian-farmasi/daftarpanggil2', 'AntrianFarmasiController@daftarpanggil2')->name('antrianfarmasi.daftarpanggil2'); //Data
Route::get('antrian-farmasi/daftarantrian2', 'AntrianFarmasiController@daftarantrian2')->name('antrianfarmasi.daftarantrian2'); //Halaman Daftar Antrian
Route::get('antrian-farmasi/panggil2/{id}', 'AntrianFarmasiController@panggil2')->name('antrianfarmasi.panggil2'); 
Route::get('antrian-farmasi/panggilkembali2/{id}', 'AntrianFarmasiController@panggilkembali2')->name('antrianfarmasi.panggilkembali2');
Route::get('antrian-farmasi/datalayarlcd2', 'AntrianFarmasiController@datalayarlcd2')->name('antrianfarmasi.datalayarlcd2');

#ANTRIAN LOKET 3
Route::get('antrian-farmasi/daftarpanggil3', 'AntrianFarmasiController@daftarpanggil3')->name('antrianfarmasi.daftarpanggil3'); //Data
Route::get('antrian-farmasi/daftarantrian3', 'AntrianFarmasiController@daftarantrian3')->name('antrianfarmasi.daftarantrian3'); //Halaman Daftar Antrian
Route::get('antrian-farmasi/panggil3/{id}', 'AntrianFarmasiController@panggil3')->name('antrianfarmasi.panggil3'); 
Route::get('antrian-farmasi/panggilkembali3/{id}', 'AntrianFarmasiController@panggilkembali3')->name('antrianfarmasi.panggilkembali3');
Route::get('antrian-farmasi/datalayarlcd3', 'AntrianFarmasiController@datalayarlcd3')->name('antrianfarmasi.datalayarlcd3');

#ANTRIAN LOKET 4
Route::get('antrian-farmasi/daftarpanggil4', 'AntrianFarmasiController@daftarpanggil4')->name('antrianfarmasi.daftarpanggil4'); //Data
Route::get('antrian-farmasi/daftarantrian4', 'AntrianFarmasiController@daftarantrian4')->name('antrianfarmasi.daftarantrian4'); //Halaman Daftar Antrian
Route::get('antrian-farmasi/panggil4/{id}', 'AntrianFarmasiController@panggil4')->name('antrianfarmasi.panggil4'); 
Route::get('antrian-farmasi/panggilkembali4/{id}', 'AntrianFarmasiController@panggilkembali4')->name('antrianfarmasi.panggilkembali4');
Route::get('antrian-farmasi/datalayarlcd4', 'AntrianFarmasiController@datalayarlcd4')->name('antrianfarmasi.datalayarlcd4');
