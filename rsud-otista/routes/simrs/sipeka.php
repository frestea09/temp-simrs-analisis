<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('/sipeka/dashboard', 'KeluhanPasienController@dashboard');
  Route::post('/sipeka/dashboard', 'KeluhanPasienController@dashboard_byTanggal');
  Route::post('/sipeka/update-disposisi/{id}', 'KeluhanPasienController@updateDisposisi');
  Route::post('/sipeka/update-bidang/{id}', 'KeluhanPasienController@updateBidang');
  Route::post('/sipeka/update-balasan-bagian/{id}', 'KeluhanPasienController@updateBalasanBagian');
  Route::post('/sipeka/update-balasan-admin/{id}', 'KeluhanPasienController@updateBalasanAdmin');
  Route::get('/sipeka/get-balasan-bagian/{id}', 'KeluhanPasienController@getBalasanBagian');
  Route::get('/sipeka/get-balasan-admin/{id}', 'KeluhanPasienController@getBalasanAdmin');
  Route::post('/sipeka/upload-dokumen/{id}', 'KeluhanPasienController@uploadDokumen');
  Route::post('/sipeka/kembalikan-dokumen/{id}', 'KeluhanPasienController@kembalikanDokumen');
  Route::get('/sipeka/laporan-pdf/{id}', 'KeluhanPasienController@laporanPDF');
});
