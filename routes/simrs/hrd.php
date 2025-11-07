<?php

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::view('hrd/pegawai', 'hrd.pegawai');
	Route::view('hrd/administrasi', 'hrd.administrasi');
	Route::view('hrd/mutasi', 'hrd.mutasi');
	Route::view('hrd/diklat', 'hrd.diklat');
	Route::view('hrd/laporan', 'hrd.laporan');
	Route::view('hrd/other', 'hrd.other');
});
