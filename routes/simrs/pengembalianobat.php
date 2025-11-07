<?php

Route::group(['middleware' => ['web', 'auth']], function () {

	// Route::get('/pengembalian','PengembalianObatController@index');
	Route::get('/pengembalian/create/{peminjaman_id}','PengembalianObatController@create');
	Route::post('/pengembalian/save','PengembalianObatController@store');
	Route::post('/pengembalian/simpan-rincian','PengembalianObatController@simpanRincian')->name('simpan-rincian-pengembalian-obat');

	//detail
	Route::get('/pengembalian/detail-batch/{masterobat_id}/{id_pinjam}','PengembalianObatController@detail_popuap_batch');
	Route::get('/pengembalian/detail-obat-batch/{nomorbatch}','PengembalianObatController@detail_master_obat_batch');

	Route::get('hapus-pengembalian-obat/{id}','PengembalianObatController@hapusObat');
});

