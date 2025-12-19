<?php

Route::get('/cek-folio-count/{id}/{poli}', 'AjaxController@cekCountFolio');
Route::post('/cek-status-batch', 'AjaxController@cekStatusBatch');
Route::post('/cek-status-perawat-batch', 'AjaxController@cekStatusPerawatBatch');
Route::post('/cek-discharge-batch', 'AjaxController@cekDischargeBatch');
Route::get('/ajax/cek-emr/{registrasi_id}', 'AjaxController@cekEmr');
Route::get('/ajax/cek-kamar-bed/{id}', 'AjaxController@cekKamarBed');
Route::get('/registrasi/check/{id}', 'AjaxController@checkCetak')->name('registrasi.checkCetak');
Route::post('/update-taskid', 'AjaxController@updateTaskIdAjax')->name('update.taskid');
Route::get('/ajax/cek-spri/{id}', 'AjaxController@cekSpriAjax');
Route::get('/ajax/cek-resep/{id}', 'AjaxController@cekResepAjax');
Route::post('/ajax/cek-resep-bulk', 'AjaxController@cekResepBulk');
Route::post('/ajax/cek-spri-bulk', 'AjaxController@cekSpriBulk');
Route::get('/cek-diagnosa-terakhir', 'AjaxController@cekDiagnosaTerakhir')->name('cek.diagnosa.terakhir');





//Bridging SEP baru

