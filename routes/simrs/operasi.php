<?php

Route::group(['middleware' => ['web', 'auth', 'role:operasi|administrator']], function () {
	Route::view('operasi/billing', 'operasi.billing');
	Route::view('operasi/laporan', 'operasi.laporan');

	// ODC
	Route::get('operasi/odc/{tgl?}', 'OperasiController@ODC');
	Route::post('operasi/odcPerTanggal', 'OperasiController@odcPerTanggal');

	Route::get('operasi/antrian/{tgl?}', 'OperasiController@antrian');
	Route::post('operasi/pertanggal', 'OperasiController@byTanggal');
	Route::get('operasi/cari-pasien', 'OperasiController@cariPasien');
	Route::post('operasi/cari-pasien', 'OperasiController@cariPasienProses');
	Route::get('operasi/tindakan/{unit}/{registrasi_id}', 'OperasiController@tindakan');
	Route::post('operasi/simpantindakan', 'OperasiController@simpanTindakan');
	Route::get('operasi/cetak-tindakan-oka/{reg_id}', 'OperasiController@cetakTindakanOka');

	//Ajax
	Route::get('operasi/get-tarif/{kat_id}', 'OperasiController@gettarif');
	Route::get('operasi/get-dokter', 'OperasiController@getDokter');
	Route::get('operasi/get-tarif-tindakan', 'OperasiController@getTarifTindakan');
	Route::get('operasi/get-data-folio/{registrasi_id}', 'OperasiController@getDataFolio');
	Route::get('operasi/hapus-tindakan/{folio_id}/{reg_id}', 'OperasiController@hapusTindakan');

	//Laporan
	Route::get('operasi/laporan/laporan-operasi', 'OperasiController@laporanOperasi');
	Route::get('operasi/ajax-get-tindakan', 'OperasiController@ajaxGetTindakan');
	Route::post('operasi/laporan/laporan-operasi', 'OperasiController@laporanOperasiByReq');

	// Output & TTE
	Route::get('operasi/cetak-daftar-tilik/pdf/{registrasi_id}/{id}', 'OperasiController@cetakDaftarTilik');

	//hapus daftar tilik
	Route::get('operasi/delete-daftar-tilik/{daftar_id}', 'OperasiController@daftarTilikDelete');

	//catatan
	Route::get('operasi/catatan-pasien/{registrasi_id}', 'OperasiController@Order');
	Route::post('operasi/searchpasien', 'OperasiController@searchPasien');
	Route::get('operasi/registrasioperasi/{pasien_id}', 'OperasiController@registrasiPasien');
	Route::post('operasi/savereservasi', 'OperasiController@saveReservasi');
});
Route::group(['middleware' => ['web', 'auth', 'role:emr_operasi']], function () {
	Route::get('operasi/emr/{unit}', 'OperasiController@emr');
	Route::post('operasi/emr/{unit}', 'OperasiController@emrByRequest');
});
