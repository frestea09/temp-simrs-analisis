<?php

Route::group(['middleware' => ['web', 'auth']], function () {

	Route::get('/peminjaman','PinjamObatController@index');
	Route::get('/peminjaman/create','PinjamObatController@create');
	Route::post('/peminjaman/save','PinjamObatController@store')->name('simpan-peminjaman-obat');
	Route::get('/peminjaman/rincian/{id}','PinjamObatController@rincian');
	Route::post('/peminjaman/simpan-rincian','PinjamObatController@simpanRincian')->name('simpan-rincian-pinjam-obat');
	Route::get('/hapus-pinjam-obat/{id}','PinjamObatController@hapusObat');
});

