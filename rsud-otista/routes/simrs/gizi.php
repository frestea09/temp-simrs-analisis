<?php
Route::group(['middleware' => ['web', 'auth']], function () {
		Route::resource('mastergizi', 'MastergiziController');
		Route::get('gizi-pasien', 'MastergiziController@gizi_pasien');
		Route::post('gizi-pasien', 'MastergiziController@gizi_pasien_byTanggal');

		Route::get('index-inap', 'MastergiziController@indexInap');
		Route::post('index-inap', 'MastergiziController@indexInapByTanggal');

		Route::get('index-inap-laporan', 'MastergiziController@indexInapLaporan');
		Route::post('index-inap-laporan', 'MastergiziController@indexInapLaporanBy');

		Route::get('index-inap-hasil-pemeriksaan', 'MastergiziController@hasilPemeriksaan');
		Route::post('index-inap-hasil-pemeriksaan', 'MastergiziController@hasilPemeriksaanBy');
		
		Route::get('gizi/cetak', 'MastergiziController@cetak');
		Route::post('gizi/cetak', 'MastergiziController@cetakBy');
		Route::get('gizi/cetak-label/{registrasi_id}', 'MastergiziController@cetakLabel');

		Route::get('get-predictive', 'MastergiziController@getPredictive');
	});
