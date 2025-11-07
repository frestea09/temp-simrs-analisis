<?php




Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('hais/{unit}/{registrasi_id}', 'HaisController@create');
	Route::post('hais/save', 'HaisController@save');
	// Route::get('cetak-hais/{registrasi_id}', 'HaisController@cetakResume');
	Route::delete('hais/{id}', 'HaisController@deleteResume');
	Route::get('cetak-hais/pdf/{registrasi_id}', 'HaisController@cetakPDFResume');
	Route::get('cetak-hais/formCetakHais/{id}', 'HaisController@formCetakHais');
	Route::get('hapus-hais/{id}', 'HaisController@hapus');
});
