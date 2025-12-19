<?php

 
Route::view('antrian-rawatinap', 'antrianrawatinap.index');
Route::post('/antrianrawatinap/savetouch', 'AntrianRawatInapController@savetouch')->name('antrianrawatinap.savetouch');
Route::get('/antrian-rawatinap/touch', 'AntrianRawatInapController@touch')->name('antrianrawatinap.touch');
Route::get('antrian-rawatinap/suara', 'AntrianRawatInapController@suara')->name('antrianrawatinap.suara');
Route::get('antrian-rawatinap/layarlcd', 'AntrianRawatInapController@layarlcd')->name('antrianrawatinap.layarlcd');

Route::get('antrian-rawatinap/print', 'AntrianRawatInapController@printAntrian');
Route::get('antrian-rawatinap/layarlcd/nextantrian', 'AntrianRawatInapController@antrianLayarLCD');

// Route::get('/datalayarlcd', 'AntrianController@datalayarlcd')->name('antrian.datalayarlcd');
// Route::get('/registrasi/{id}/{jenis?}', 'AntrianController@registrasi');
// Route::get('/reg_pasienlama/{id}/{jenis?}', 'AntrianController@reg_pasienlama');
// Route::get('/reg_blmterdata/{id}/{jenis?}', 'AntrianController@reg_blm_terdata');

Route::get('antrianrawatinap/', 'AntrianRawatInapController@touch')->name('antrianrawatinap');
#ANTRIAN LOKET 1
Route::get('antrian-rawatinap/daftarpanggil1', 'AntrianRawatInapController@daftarpanggil1')->name('antrianrawatinap.daftarpanggil1'); //Data
Route::get('antrian-rawatinap/daftarantrian1', 'AntrianRawatInapController@daftarantrian1')->name('antrianrawatinap.daftarantrian1'); //Halaman Daftar Antrian
Route::get('antrian-rawatinap/panggil1/{id}', 'AntrianRawatInapController@panggil1')->name('antrianrawatinap.panggil1'); 
Route::get('antrian-rawatinap/panggilkembali1/{id}', 'AntrianRawatInapController@panggilkembali1')->name('antrianrawatinap.panggilkembali1');
Route::get('antrian-rawatinap/datalayarlcd1', 'AntrianRawatInapController@datalayarlcd1')->name('antrianrawatinap.datalayarlcd1');


#ANTRIAN LOKET 2
Route::get('antrian-rawatinap/daftarpanggil2', 'AntrianRawatInapController@daftarpanggil2')->name('antrianrawatinap.daftarpanggil2'); //Data
Route::get('antrian-rawatinap/daftarantrian2', 'AntrianRawatInapController@daftarantrian2')->name('antrianrawatinap.daftarantrian2'); //Halaman Daftar Antrian
Route::get('antrian-rawatinap/panggil2/{id}', 'AntrianRawatInapController@panggil2')->name('antrianrawatinap.panggil2'); 
Route::get('antrian-rawatinap/panggilkembali2/{id}', 'AntrianRawatInapController@panggilkembali2')->name('antrianrawatinap.panggilkembali2');
Route::get('antrian-rawatinap/datalayarlcd2', 'AntrianRawatInapController@datalayarlcd2')->name('antrianrawatinap.datalayarlcd2');

#ANTRIAN LOKET 3
Route::get('antrian-rawatinap/daftarpanggil3', 'AntrianRawatInapController@daftarpanggil3')->name('antrianrawatinap.daftarpanggil3'); //Data
Route::get('antrian-rawatinap/daftarantrian3', 'AntrianRawatInapController@daftarantrian3')->name('antrianrawatinap.daftarantrian3'); //Halaman Daftar Antrian
Route::get('antrian-rawatinap/panggil3/{id}', 'AntrianRawatInapController@panggil3')->name('antrianrawatinap.panggil3'); 
Route::get('antrian-rawatinap/panggilkembali3/{id}', 'AntrianRawatInapController@panggilkembali3')->name('antrianrawatinap.panggilkembali3');
Route::get('antrian-rawatinap/datalayarlcd3', 'AntrianRawatInapController@datalayarlcd3')->name('antrianrawatinap.datalayarlcd3');

#ANTRIAN LOKET 4
Route::get('antrian-rawatinap/daftarpanggil4', 'AntrianRawatInapController@daftarpanggil4')->name('antrianrawatinap.daftarpanggil4'); //Data
Route::get('antrian-rawatinap/daftarantrian4', 'AntrianRawatInapController@daftarantrian4')->name('antrianrawatinap.daftarantrian4'); //Halaman Daftar Antrian
Route::get('antrian-rawatinap/panggil4/{id}', 'AntrianRawatInapController@panggil4')->name('antrianrawatinap.panggil4'); 
Route::get('antrian-rawatinap/panggilkembali4/{id}', 'AntrianRawatInapController@panggilkembali4')->name('antrianrawatinap.panggilkembali4');
Route::get('antrian-rawatinap/datalayarlcd4', 'AntrianRawatInapController@datalayarlcd4')->name('antrianrawatinap.datalayarlcd4');

